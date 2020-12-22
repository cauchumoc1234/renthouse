<?php

namespace App\Http\Controllers;

use App\ExtendPost;
use App\City;
use App\District;
use App\Facilities;
use App\Notify;
use App\RequestEditRoom;
use App\Room_facilities;
use App\Room;
use App\Room_image;
use App\Room_type;
use App\User;
use App\User_views;
use App\User_vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
//     Controller nay chua test dc gi vi chua co frontend, du lieu, route



    public function getAllRoom()
    {
        app()->call('App\Http\Controllers\RoomController@checkExpired');
        $user = Auth::user();
        $data = Room::where(['user_id' => $user->id])->orderBy('created_at', 'ASC')->get();
        $getDate = date('Y-m-d');
        foreach ($data as $value) {
            if ($getDate > $value->expired_date) {
                $value->is_active = 0;
            }
        }
        return view('owner.room.index', [
            'data' => $data
        ]);
        // or return json ?
    }

    public function getAllUnApprovedRoom()
    {
        $user = Auth::user();
        $list = Room::where(['user_id' => $user->id, 'approved_id' => null])->orderBy('created_at', 'ASC')->get();
        return view('', [
            'list' => $list
        ]);
    }

    public function showRoomDetail($id)
    {
        $data = Room::findorFail($id);
        $roomTypeName = Room_type::where('id', $data->roomType_id)->first();
        $facilities = $data->facilities()->get();
        $room_detailImages =  Room_image::where(['room_id' => $data->id ])->orderBy('position', 'ASC')->get();
        $getDate = date('Y-m-d');
        $expiredDate = $data->expired_date;
        if ($getDate > $expiredDate) {
            $data->is_active = 0;
            $data->save();
        }
        // luot yeu thich cua phong tro - start
        $room_likes = 0;
        $likes_query = "SELECT count(*) AS 'likes' FROM user_like WHERE room_id = '$id'";
        $room_likes = DB::select($likes_query)[0]->likes;
        // end
        $show_Request = 1;
        $request_edit = RequestEditRoom::where(['room_id' => $id])->orderBy('created_at', 'DESC')->limit(1)->first();
        if($request_edit != null) {
            if($request_edit->approved_by == null) {
                $show_Request = 0;
            }
        }

        $canEdit = $data->canbe_edit; // ??
        return view('owner.room.show', [
            'data' => $data,
            'roomTypeName' => $roomTypeName->name,
            'room_detailImages' => $room_detailImages,
            'facilities' => $facilities,
            'getDate' => $getDate,
            'show_Request' => $show_Request,
            'room_likes' => $room_likes

        ]);
    }
    public function require_extendDate(Request $request, $room_id)
    {
        // mac dinh unit_date: 1 la tuan, 2 la thang, 3 la nam
        // mac dinh gia tien cho thue la 50k 1 tuan
        $p = 50000;
        $total_price = 0;
        $unit_date = $request->input('unit_date');
        $q = $request->input('quantity');
        $r = new ExtendPost();
        $user = Auth::user();
        $r->room_id = $room_id;
        $r->user_id = $user->id;
        $r->quantity = $request->input('quantity');
        $r->unit_date = $unit_date;
        $r->phone = $user->phone;
        if($unit_date == 1) { // tuan
            $total_price = $p*$q;
        } else if ($unit_date == 2 ) { // thang
            $total_price = $p*$q*4;
        } else { // nam
            $total_price = $p*$q*52;
        }
        $r->total_price = $total_price;
        $r->save();
        return redirect()->route('owner.room.index')->with('msg', 'Gửi yêu cầu gia hạn bài viết thành công. Vui lòng đợi Admin phê duyệt');
    }

    public function login()
    {
        if(!Auth::check()) {
            return view('owner.login');
        } else {

            $user = Auth::user();
            if($user->role_id == 1 ) {
                return redirect()->route('admin.dashboard');
            } else if($user->role_id == 2 ) {
                return redirect()->route('owner.room.index');
            }
            else if($user->role_id == 3) {
                return redirect('/');
            }
        }
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);

        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];


        // check success
        if (Auth::attempt($data, $request->has('remember'))) {
            $user = Auth::user();
            if($user->is_active == 0) {
                Auth::logout();
                return redirect()->back()->with('msg', 'Tài khoản của bạn chưa được kích hoạt');
            } else {
                if($user->role_id == 2 ) {
                    return redirect()->route('owner.room.index');
                } else if($user->role_id == 1 || $user->role_id == 3) {
                    Auth::logout();
                    return redirect()->back()->with('msg', 'Bạn không có quyền truy cập vào quản lý owner');
                }
            }
        }
        return redirect()->back()->with('msg', 'Email hoặc Password không chính xác');
    }



    public function register() {
        return view('owner.register');
    }

    public function postRegister(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000'
        ]);

        $is_active = 0;
        //luu vào csdl
        $user = new User();
        $user->name = $request->input('name'); // họ tên
        $user->birthday = $request->input('birthday');
        $user->phone = $request->input('phone');
        $user->cmnd = $request->input('cmnd');
        $user->email = $request->input('email'); // email
        $user->password = bcrypt($request->input('password')); // mật khẩu
        $user->role_id = 2; // phần quyền
        $user->address = $request->input('address');
        if ($request->hasFile('avatar')) {
            // get file
            $file = $request->file('avatar');
            // get ten
            $filename = time().'_'.$file->getClientOriginalName();
            // duong dan upload
            $path_upload = 'uploads/user/';
            // upload file
            $request->file('avatar')->move($path_upload,$filename);

            $user->image = $path_upload.$filename;
        }

        $user->is_active = $is_active;
        $user->save();

        // chuyen dieu huong trang
        return redirect()->back()->with('msg', 'Đăng ký tài khoản thành công. Vui lòng đợi Admin phê duyệt');
    }

    public function viewCreateRoom() {
        $typeRoom = Room_type::all();
        $city = City::all();
        $facility = Facilities::all();
        return view('owner.room.create', [
            'typeRoom' => $typeRoom,
            'city' => $city,
            'facility' => $facility
        ]);
    }

    public function storeRoom(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000'
        ]);
        $user = Auth::user();
        $room = new Room(); // khởi tạo model
        $room->roomType_id = $request->input('typeRoom');
        $room->title = $request->input('title');
        $room->address = $request->input('address');
        $room->district_id = $request->input('district');
        $room->city_id = $request->input('city');
        $room->quantity = $request->input('quantity');
        $room->price = $request->input('price');
        $room->price_unit = $request->input('priceUnit');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path_upload = 'uploads/room/';
            $request->file('image')->move($path_upload, $filename);
            $room->image = $path_upload . $filename;
        }
        $room->area = $request->input('area');
        $room->note = $request->input('note');
        $room->description = $request->input('description');
        $live_with_owner = 0;
        if ($request->has('with_owner')) {
            $live_with_owner = $request->input('with_owner');
        }
        $room->live_with_owner = $live_with_owner;

        $room->electric_price = $request->input('electricPrice');
        $room->water_price = $request->input('waterPrice');
        $room->user_id = $user->id;
        $is_active = 0;
        $room->is_active = $is_active;



        $facilities = $request->input('facilities');
        $room->save();

        // luu thoi gian muon hien thi
        $p = 50000;
        $total_price = 0;
        $unit_date = $request->input('unit_date');
        $date_q = $request->input('date_quantity');
        $r = new ExtendPost();
        $user = Auth::user();
        $r->room_id = $room->id;
        $r->user_id = $user->id;
        $r->quantity = $date_q;
        $r->unit_date = $unit_date;
        $r->phone = $user->phone;
        if($unit_date == 1) { // tuan
            $total_price = $p*$date_q;
        } else if ($unit_date == 2 ) { // thang
            $total_price = $p*$date_q*4;
        } else { // nam
            $total_price = $p*$date_q*52;
        }
        $r->total_price = $total_price;
        $r->save();

        // end luu thoi gian muon hien thi

        if ($request->hasFile('detailImage')) {
            $file = $request->file('detailImage');
            $path_upload = 'uploads/room/';
            foreach ($file as $key => $item){
                $r_image = new Room_image();
                $r_image->room_id = $room->id;
                $r_image->position = $key;
                $f_name = time().'_'.$item->getClientOriginalName();
                $item->move($path_upload, $f_name);
                $r_image ->image = $path_upload.$f_name;
                $r_image->save();
            };
        }
        $room->Facilities()->syncWithoutDetaching($facilities);
        return redirect()->route('owner.room.index')->with('msg', 'Tạo phòng thành công. Vui lòng đợi Admin duyệt !');
    }

    public function viewEditRoom($id)
    {
        $room = Room::findorFail($id);
        if($room->canbe_edit == 0)
        {
            return redirect()->back()->with('msg', 'Bạn không thể chỉnh sửa bài đăng này');
        }
        else {
            $facility = Facilities::all();
            $room_facilities = Room_facilities::where(['room_id' => $id])->get();
            $exists_facilities = [];
            $room_detailImages = Room_image::where(['room_id' => $room->id])->orderBy('position', 'ASC')->get();
            $pickedCity = City::findOrFail($room->city_id);
            $pickedDistrict = District::findOrFail($room->district_id);
            $city = City::where('id', '!=', $pickedCity->id)->get();
            $district = District::where([
                ['city_id', '=', $pickedCity->id],
                ['id', '!=', $pickedDistrict->id]
            ])->get();
            $pickedTypeRoom = Room_type::findOrFail($room->roomType_id);
            $typeRoom = Room_type::where('id', '!=', $pickedTypeRoom->id)->get();

            foreach ($room_facilities as $item) {
                array_push($exists_facilities, $item->facilities_id);
            }

            return view('owner.room.edit', [
                'room' => $room,
                'typeRoom' => $typeRoom,
                'city' => $city,
                'district' => $district,
                'facility' => $facility,
                'room_detailImages' => $room_detailImages,
                'exists_facilities' => $exists_facilities,
                'pickedCity' => $pickedCity,
                'pickedDistrict' => $pickedDistrict,
                'pickedTypeRoom' => $pickedTypeRoom
            ]);
        }
    }

    public function updateRoom(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000'
        ]);

        $room =  Room::findOrFail($id); // khởi tạo model
        $room->roomType_id = $request->input('typeRoom');
        $room->title = $request->input('title');
        $room->address = $request->input('address');
        $room->district_id = $request->input('district');
        $room->city_id = $request->input('city');
        $room->quantity = $request->input('quantity');
        $room->price = $request->input('price');
        // Upload file
        if ($request->hasFile('new_image')) { // dòng này Kiểm tra xem có image có được chọn

            @unlink(public_path($room->image)); // hàm unlink của PHP không phải laravel , chúng ta thêm @ đằng trước tránh bị lỗi
            // get file
            $file = $request->file('new_image');
            // đặt tên cho file image
            $filename = time().'_'.$file->getClientOriginalName(); // $file->getClientOriginalName() == tên ban đầu của image
            // Định nghĩa đường dẫn sẽ upload lên
            $path_upload = 'uploads/room/';
            // Thực hiện upload file
            $request->file('new_image')->move($path_upload,$filename); // upload lên thư mục public/uploads/product

            $room->image = $path_upload.$filename;
        }
        // edit anh chi tiet da co
        $list_ImageDetail = Room_image::where(['room_id' => $room->id])->get();
        foreach ($list_ImageDetail as $item)
        {
            if ($request->hasFile('new_image'.$item->id)) { // dòng này Kiểm tra xem có image có được chọn
                $i_detail = Room_image::findOrFail($item->id);
                @unlink(public_path($i_detail->image)); // hàm unlink của PHP không phải laravel , chúng ta thêm @ đằng trước tránh bị lỗi
                // get file
                $file = $request->file('new_image'.$item->id);
                // đặt tên cho file image
                $filename = time().'_'.$file->getClientOriginalName(); // $file->getClientOriginalName() == tên ban đầu của image
                // Định nghĩa đường dẫn sẽ upload lên
                $path_upload = 'uploads/room/';
                // Thực hiện upload file
                $request->file('new_image'.$item->id)->move($path_upload,$filename); // upload lên thư mục public/uploads/product

                $i_detail->image = $path_upload.$filename;
                $i_detail->save();
            }
        }
//         them anh chi tiet sp
        if ($request->hasFile('new_detailImage')) {
            // get file
            $file = $request->file('new_detailImage');
            // Định nghĩa đường dẫn sẽ upload lên
            $path_upload = 'uploads/room/';
//                // Thực hiện upload file
            foreach ($file as $key => $item){
                $r_image = new Room_image();
                $r_image->room_id = $room->id;
                $r_image->position = $key;
                $f_name = time().'_'.$item->getClientOriginalName();
                $item->move($path_upload, $f_name);
                $r_image ->image = $path_upload.$f_name;
                $r_image->save();
            }

        }

        $room->area = $request->input('area'); // diện tích
        $room->note = $request->input('note');
        $live_with_owner = 0;
        if ($request->has('with_owner')){
            $live_with_owner = $request->input('with_owner');
        }
        $room->live_with_owner = $live_with_owner;
        $room->electric_price = $request->input('electricPrice');
        $room->water_price = $request->input('waterPrice');
        $is_active = 0;
        if ($request->has('is_active')){//kiem tra is_active co ton tai khong?
            $is_active = $request->input('is_active');
        }
        $room->is_active = $is_active;
        $room->price_unit = $request->input('priceUnit');
        $facilities = $request->input('facilities');
        $room->canbe_edit = 0;
        $room->save();
        $room->Facilities()->syncWithoutDetaching($facilities);
//        $room->Room_image()->syncWithoutDetaching($detaiImage);

        // chuyển hướng đến trang
        return redirect()->route('owner.room.index')->with('msg', 'Sửa Đổi Thông Tin Phòng Thành Công');
    }

    public function extendDate($roomId)
    {
        $data = Room::findOrFail($roomId);
        return view('owner.room.extend', [
            'data' => $data,
        ]);
    }

    public function requestEditRoom($room_id)
    {
        $room = Room::findOrFail($room_id);
        return view('owner.room.requestEditRoom', [
            'room_id' => $room_id,
            'room_title' => $room->title
        ]);
    }
    public function sendRequestEditRoom(Request $request)
    {
        $r = new RequestEditRoom();
        $user = Auth::user();
        $r->user_id = $user->id;
        $r->room_id = $request->input('room_id');
        $r->reason = $request->input('reason');
        $r->save();

        return redirect()->route('owner.room.show', ['id'=> $request->input('room_id') ]);
    }

    public function getAllNotification()
    {
        $user = Auth::user();
        $data = Notify::where(['receive_id' => $user->id]);
        return json_encode($data); // lam js sau
    }

    public function showDetailNoti($id)
    {
        $data = Notify::findOrFail($id);
        $data->be_seen = 1;
        $data->save();
        return view('owner.showNoti', [
            'data' => $data
        ]);
    }

    public function showAllNoti()
    {
        $user = Auth::user();
        $data = Notify::where(['receive_id' => $user->id])->get();
        return view('owner.viewAllNoti', [
            'data' => $data,
        ]);
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('owner.showProfile', [
            'user'=> $user
        ]);
    }

    public function deleteRoom($id)
    {
        // gọi tới hàm destroy của laravel để xóa 1 object
        Room::destroy($id);

        // Trả về dữ liệu json và trạng thái kèm theo thành công là 200
        return response()->json([
            'status' => true
        ], 200);
    }

    public function deleteRoomImage($id)
    {
        Room_image::destroy($id);
        return response()->json([
            'status' => true
        ], 200);
    }

    public function changePassword()
    {
        return view('owner.changePassword');
    }

    public function editProfile()
    {
        $user = Auth::user();

        return view('owner.editProfile', [
            'user'=> $user
        ]);
    }

    public function updateProfile(Request $request)
    {
//        dd($request);
//
//        $validatedData = $request->validate([
//            'name' => 'required|max:255',
//            'email' => 'required|email',
//            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000'
//        ]);

        $user = Auth::user();

        //luu vào csdl
        $user->name = $request->input('name'); // họ tên
        $user->birthday = $request->input('birthday');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        if ($request->hasFile('new_avatar')) {
            // xóa file cũ
            @unlink(public_path($user->image)); // hàm unlink của PHP không phải laravel , chúng ta thêm @ đằng trước tránh bị lỗi
            // get file
            $file = $request->file('new_avatar');
            // get ten
            $filename = time().'_'.$file->getClientOriginalName();
            // duong dan upload
            $path_upload = 'uploads/user/';
            // upload file
            $request->file('new_avatar')->move($path_upload,$filename);

            $user->image = $path_upload.$filename;
        }

        $user->save();

        // chuyen dieu huong trang
        return redirect()->route('owner.showProfile', ['user' => $user])->with('msg', 'Cập nhật tài khoản thành công.');
    }

    public function markAsRead($noti_id)
    {
        $noti = Notify::findOrFail($noti_id);
        $noti->be_seen = 1;
        $noti->save();

        return response()->json([
            'status' => true
        ], 200);
    }

    public function markAsUnRead($noti_id)
    {
        $noti = Notify::findOrFail($noti_id);
        $noti->be_seen = 0;
        $noti->save();

        return response()->json([
            'status' => true
        ], 200);
    }
//
//    public function markAsRented($room_id)
//    {
//        $room = Room::findOrFail($room_id);
//        $room->rented = 1;
//        $room->save();
//
//        return response()->json([
//            'status' => true
//        ], 200);
//    }
    public function test_owner($room_id)
    {
        // thống kê lượt vote của room
        $vote_statistics = User_vote::where(['room_id' => $room_id])->get();
        $vote_avg = 0;
        foreach($vote_statistics as $vote) {
            $vote_avg += $vote->star;
        }
        $vote_avg = $vote_avg/count($vote_statistics);
        $vote_avg = round($vote_avg, 2); // lam tron den 2 chu so thap phan
        dd($vote_avg);
    }

}
