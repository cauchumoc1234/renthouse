<?php

namespace App\Http\Controllers;

use App\Facilities;
use App\Room_facilities;
use App\Room_image;
use App\Room;
use App\Room_type;
use App\City;
use App\District;
use App\User_vote;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->checkExpired();
        $data = Room::latest()->paginate(20);
        return view('backend.room.index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typeRoom = Room_type::all();
        $city = City::all();
        $district = District::all();
        $facility = Facilities::all();
        return view('backend.room.create', [
            'typeRoom' => $typeRoom,
            'city' => $city,
            'district' => $district,
            'facility' => $facility
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        // Upload file
        if ($request->hasFile('image')) { // dòng này Kiểm tra xem có image có được chọn
            // get file
            $file = $request->file('image');
            // đặt tên cho file image
            $filename = time() . '_' . $file->getClientOriginalName(); // $file->getClientOriginalName() == tên ban đầu của image
            // Định nghĩa đường dẫn sẽ upload lên
            $path_upload = 'uploads/room/';
            // Thực hiện upload file
            $request->file('image')->move($path_upload, $filename); // upload lên thư mục public/uploads/product

            $room->image = $path_upload . $filename;
        }
        $room->area = $request->input('area'); // diện tích
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
        $room->approval_id = $user->id;
        $room->approval_date = now();
        $date = date('Y-m-d');
        $room->public_date = $date;
        $quantity = $request->input('date_quantity');
        $unit_date = $request->input('unit_date');
        $extendInt = date('Y-m-d');
        if($unit_date == 1) {
            $extendInt = mktime(0, 0, 0, date('m'), date('d')+$quantity*7, date('Y') );
        } else if ($unit_date == 2) {
            $extendInt = mktime(0, 0, 0, date('m')+$quantity, date('d'), date('Y') );
        } else {
            $extendInt = mktime(0, 0, 0, date('m'), date('d'), date('Y')+$quantity );

        }
        $extend = date('Y-m-d', $extendInt);
        $room->expired_date = $extend;

        $is_active = 0;
        if ($request->has('is_active')) {//kiem tra is_active co ton tai khong?
            $is_active = $request->input('is_active');
        }
        $room->is_active = $is_active;
        $facilities = $request->input('facilities');
        $room->is_approved = 1;
        $room->save();
        if ($request->hasFile('detailImage')) {
            // get file
            $file = $request->file('detailImage');
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


            $room->Facilities()->syncWithoutDetaching($facilities);
//            $room->Room_image()->syncWithoutDetaching($detailImage);

            // chuyển hướng đến trang
            return redirect()->route('admin.room.index')->with('msg', 'Lưu Thông Tin Phòng Thành Công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Room::findorFail($id);
        $roomTypeName = Room_type::where('id', $data->roomType_id)->first();
        $facilities = $data->facilities()->get();
        $room_detailImages =  Room_image::where(['room_id' => $data->id ])->orderBy('position', 'ASC')->get();
        // luot yeu thich cua phong tro - start
        $room_likes = 0;
        $likes_query = "SELECT count(*) AS 'likes' FROM user_like WHERE room_id = '$id'";
        $room_likes = DB::select($likes_query)[0]->likes;
        // luot yeu thich cua phong tro - end

        // luot vote cua phong tro - start
        $star_voted = 0;
        $room_voted = User_vote::where(['room_id' => $id ])->get();
        $room_voted_length  = count($room_voted);
        if($room_voted_length == 0)
        {
            $star_voted = 0;
        } else {
            foreach($room_voted as $item) {
                $star_voted += $item->star;
            }
            $star_voted /= $room_voted_length;
            $star_voted = round($star_voted, 2);
        }

        // luot vote cua phong tro - end
        return view('backend.room.show', [
            'title' => 'Chi Tiết Phòng Trọ',
            'data' => $data,
            'roomTypeName' => $roomTypeName->name,
            'room_detailImages' => $room_detailImages,
            'facilities' => $facilities,
            'room_likes' => $room_likes,
            'star_voted' => $star_voted,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = Room::findorFail($id);
        $facility = Facilities::all();
        $room_facilities = Room_facilities::where(['room_id' => $id])->get();
        $exists_facilities = [];
        $room_detailImages =  Room_image::where(['room_id' => $room->id ])->orderBy('position', 'ASC')->get();
        $pickedCity = City::findOrFail($room->city_id);
        $pickedDistrict = District::findOrFail($room->district_id);
        $city = City::where('id', '!=', $pickedCity->id)->get();
        $district = District::where([
            ['city_id', '=', $pickedCity->id],
            ['id', '!=', $pickedDistrict->id]
        ])->get();
        $pickedTypeRoom = Room_type::findOrFail($room->roomType_id);
        $typeRoom = Room_type::where('id', '!=', $pickedTypeRoom->id)->get();

        foreach($room_facilities as $item) {
            array_push($exists_facilities,$item->facilities_id );
        }

        return view('backend.room.edit', [
            'room' => $room,
            'typeRoom' => $typeRoom,
            'city' => $city,
            'district' => $district,
            'facility' => $facility,
            'room_detailImages' => $room_detailImages,
            'exists_facilities' => $exists_facilities,
            'pickedCity'=> $pickedCity,
            'pickedDistrict' => $pickedDistrict,
            'pickedTypeRoom' =>$pickedTypeRoom
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        $room->expired_date = $request->input('expiredDate');
        $room->electric_price = $request->input('electricPrice');
        $room->water_price = $request->input('waterPrice');
        $is_active = 0;
        if ($request->has('is_active')){//kiem tra is_active co ton tai khong?
            $is_active = $request->input('is_active');
        }
        $room->is_active = $is_active;
        $room->price_unit = $request->input('priceUnit');
        $facilities = $request->input('facilities');
        $room->save();
        $room->Facilities()->syncWithoutDetaching($facilities);
//        $room->Room_image()->syncWithoutDetaching($detaiImage);


        // chuyển hướng đến trang
        return redirect()->route('admin.room.index')->with('msg', 'Sửa Đổi Thông Tin Phòng Thành Công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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

    public function checkExpired()
    {
        $all_room = Room::all();
        $today = date('Y-m-d');
        foreach($all_room as $room)
        {
            if($room->expired_date < $today) {
                $room->is_active = 0;
                $room->save();
            }
        }
    }

    public function searchTitle($role)
    {
        $key_title = '';
        $key_title = $_GET['key_title'];
        $search_query = "SELECT * FROM room WHERE MATCH(title)AGAINST('$key_title' WITH QUERY EXPANSION)";
        $data = DB::select($search_query);
        if($role == 'admin') {
            return view('backend.room.index', [
                'data' => $data
            ]);
        } else if ($role == 'owner') {
            return view('owner.room.index', [
                'data' => $data
            ]);
        }
    }


}
