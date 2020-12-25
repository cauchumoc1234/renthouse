<?php

namespace App\Http\Controllers;

use App\District;
use App\ExtendPost;
use App\Notify;
use App\RequestEditRoom;
use App\Room;
use App\Room_image;
use App\Room_type;
use App\User;
use App\User_vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        app()->call('App\Http\Controllers\RoomController@checkExpired');
        return view('backend.home');
    }

    public function  login() {
        if(!Auth::check()) {
            return view('backend.login');
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
        //validate du lieu
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
                if($user->role_id == 1 ) {
                    return redirect()->route('admin.dashboard');
                } else if($user->role_id == 2 || $user->role_id == 3) {
                    Auth::logout();
                    return redirect()->back()->with('msg', 'Bạn không có quyền truy cập vào admin');
                }
            }
        }
        return redirect()->back()->with('msg', 'Email hoặc Password không chính xác');
    }

    public function logout()
    {
        $user = Auth::user();
//        dd($user);
        Auth::logout();
        // chuyển về trang đăng nhập
        if($user->role_id == 1) {
            return redirect()->route('admin.login');
        }
        else if ($user->role_id == 2 ) {
            return redirect()->route('owner.login');
        }
        else if ($user->role_id == 3) {
            return redirect('/'); // chua co view login client
        }
    }

    public function showAllExtendRoomRequest()
    {
        $data = ExtendPost::where(['approved_date' => null])->get();
        $title = 'Danh sách yêu cầu gia hạn';
        return view('backend.manageRequest.allExtendRequest', [
            'data' => $data,
            'title' => $title
        ]);
    }

    public function sendNoti($title,$msg, $receiver_id) // da chay dc
    {
        $noti = new Notify();
        $noti->receive_id = $receiver_id;
        $noti->title = $title;
        $noti->content = $msg;
        $noti->save();
    }

    public function writeReason($request_id)
    {
        $request = ExtendPost::findOrFail($request_id);
        $title = Room::findOrFail($request->room_id)->title;
        return view('backend.manageRequest.sendReason', [
            'receiver_id' => $request->user_id,
            'title' => $title,
            'request_id' => $request_id
        ]);
    }

    public function refuseExtendDate(Request $request, $request_id)
    {
        $r = ExtendPost::findOrFail($request_id);
        $room = Room::findOrFail($r->room_id);
        $noti_title = '';
        $noti_msg = '';
        $noti_msg = $request->input('content');
        $noti_title = 'Gia hạn bài đăng ' . $room->title . ' bị từ chối !';
        $noti_msg = $noti_msg . '. Chúng tôi rất tiếc khi không thể duyệt yêu cầu này.';
        $this->sendNoti($noti_title, $noti_msg, $r->user_id);
        $room->is_active = 0;
        $room->canbe_edit = 0;
        $room->save();

        ExtendPost::destroy($request_id);
        return redirect()->route('admin.showAllExtendRoomRequest');

    }


    public function showDetailRequest($r_id) // function xem chi tiet yeu cau gia han bai viet
    {
        $data = ExtendPost::findOrFail($r_id);
        return view('', [ // chua tao view
            'data' => $data
        ]);
    }


    public function extendDate($r_id) // duyet request gia han bai
    {
        $r = ExtendPost::findOrFail($r_id);
        $user = Auth::user();
        $noti_title = '';
        $noti_msg = '';
        $client = User::findOrFail($r->user_id);
        // xu ly lai room
        $date = date('Y-m-d');
        $quantity = $r->quantity;
        $unit_date = $r->unit_date;
        $extendInt = date('Y-m-d');
        if($unit_date == 1) {
            $extendInt = mktime(0, 0, 0, date('m'), date('d')+$quantity*7, date('Y') );
        } else if ($unit_date == 2) {
            $extendInt = mktime(0, 0, 0, date('m')+$quantity, date('d'), date('Y') );
        } else {
            $extendInt = mktime(0, 0, 0, date('m'), date('d'), date('Y')+$quantity );

        }
        $extend = date('Y-m-d', $extendInt);
        $room = Room::findOrFail($r->room_id);
        $room->expired_date = $extend;
        $room->approval_date = $date;
        $room->approval_id = $user->id;
        $room->is_active = 1;
        $room->save();
        $noti_title = 'Bài đăng ' . $room->title . ' đã được gia hạn thành công!';
        // xu ly xong roi thi save yeu cau gia han
        $noti_msg = 'Chào ' . $client->name . ' !. Bài đăng của bạn đã được gia hạn thành công với mức phí ' . $r->total_price . ' VNĐ. Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi.';
        $r->approved_by = $user->id;
        $r->approved_date = $date;
        $r->save();
        // gui noti cho owner
        $this->sendNoti($noti_title, $noti_msg, $client->id);
        return response()->json([
            'status' => true
        ], 200);
    }

    public function getListDistrict($city_id)
    {
        $data = District::where(['city_id' => $city_id])->get(['id', 'name']);
        return json_encode($data);
    }

    public function approveOwnerAccount($owner_id)
    {
        $user = Auth::user();
        $account = User::findOrFail($owner_id);
        $account->is_active = 1;
        $account->approval_id = $user->id;
        $account->date_approval = now();
        $account->save();
        return redirect()->route('admin.user.show', [ 'id' => $owner_id ])->with('msg', 'Tài khoản đã được duyệt');
    }

    public function getAllUnApprovedRoom()
    {
        $data = Room::where(['approval_id' => null, 'approval_date' => null])->get();
        return view('backend.manageRequest.allUnApprovedRoom', [
            'data' => $data,
        ]);
    }

    public function approveRoom($room_id)
    {
        $user = Auth::user();
        $room = Room::findOrFail($room_id);
        // xu ly duyet bai dang
        $time = ExtendPost::where([ 'room_id' => $room_id ,'approved_by' => null, 'approved_date' => null])->first();
        $today = date('Y-m-d');
        $room->public_date = $today;
        $room->approval_date = $today;
        $room->approval_id = $user->id;
        $room->is_active = 1;
        $room->is_approved = 1;
        $quantity = $time->quantity;
        $unit_date = $time->unit_date;
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
//        dd($extend);
        $room->save(); // xong xu ly duyet bai dang
        // luu request ve thoi gian la da dc duyet
        $time->approved_by = $user->id;
        $time->approved_date = $today;
        $time->save();
        // gui thong bao ve cho owner
        $title_msg = 'Bài đăng ' . $room->title . ' đã được duyệt!';
        $msg = 'Chúng tôi đã tiến hành kiểm duyệt và bài đăng của bạn đạt tiêu chuẩn. Hiện nay bài đăng đã được hiển thị trên trang chủ.';
        $this->sendNoti($title_msg, $msg, $room->user_id);
        return redirect()->route('admin.room.show', ['id' => $room->id]);
    }

    public function getAllRequestEditRoom()
    {
        $data = RequestEditRoom::where(['approved_by' => null])->get();
        return view('backend.manageRequest.allUnApprovedRequestEditRoom', [
            'data' => $data,
            'title' => 'Danh sách phòng yêu cầu chỉnh sửa'
        ]);
    }

    public function approveEditRoom($request_id)
    {
        $user = Auth::user();
        $request = RequestEditRoom::findOrFail($request_id);

        $room = Room::findOrFail($request->room_id);
        $room->canbe_edit = 1;
        $room->save();
        $request->approved_by = $user->id;
        $request->save();
        $msg_title = 'Yêu cầu chỉnh sửa bài đăng ' . $room->title . ' được chấp nhận';
        $msg = 'Với lý do ' . $request->reason . '. Chúng tôi đã chấp nhận và bạn có quyền chỉnh sửa thông tin phòng 1 lần. Cảm ơn.';
        $this->sendNoti($msg_title, $msg, $request->user_id);

        return response()->json([
            'status' => true
        ], 200);
    }

    public function declineEditRoom($request_id)
    {
        $user = Auth::user();
        $request = RequestEditRoom::findOrFail($request_id);

        $room = Room::findOrFail($request->room_id);

        $request->approved_by = $user->id;
        $request->save();
        $msg_title = 'Yêu cầu chỉnh sửa bài đăng ' . $room->title . 'không được chấp nhận';
        $msg = 'Với lý do ' . $request->reason . '. Chúng tôi rất tiếc không thể cho bạn chỉnh sửa bài đăng. Vui lòng liên hệ trực tiếp công ty nếu cần.';
        $this->sendNoti($msg_title, $msg, $request->user_id);

        return response()->json([
            'status' => true
        ], 200);
    }

    public function getMostViewedRoom()
    {
        $data = Room::orderBy('views', 'DESC')->first();
        $roomTypeName = Room_type::where('id', $data->roomType_id)->first();
        $facilities = $data->facilities()->get();
        $room_detailImages =  Room_image::where(['room_id' => $data->id ])->orderBy('position', 'ASC')->get();
        // luot yeu thich cua phong tro - start
        $room_likes = 0;
        $likes_query = "SELECT count(*) AS 'likes' FROM user_like WHERE room_id = '$data->id'";
        $room_likes = DB::select($likes_query)[0]->likes;
        // end
        // luot vote cua phong tro
        $star_voted = 0;
        $room_voted = User_vote::where(['room_id' => $data->id ])->get();
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
            if($star_voted > 5) {
                $star_voted = 5;
            }
        }
        return view('backend.room.show', [
            'title' => 'Phòng trọ được xem nhiều nhất',
            'data' => $data,
            'roomTypeName' => $roomTypeName->name,
            'room_detailImages' => $room_detailImages,
            'facilities' => $facilities,
            'room_likes' => $room_likes,
            'type_page' => 'filter_view',
            'star_voted' => $star_voted,
        ]);
    }

    public function getMostViewedRoom_bytime()
    {
        $month = $_GET['filter_m'];
        $year  = $_GET['filter_y'];
        $query = "SELECT room_id, date_views, count(*) AS `luot_views` FROM user_views GROUP BY 'room_id' HAVING MONTH(date_views) = $month AND YEAR(date_views) = $year ORDER BY count(*) DESC LIMIT 1";
        $arr_result = DB::select($query);
        if(!empty($arr_result)) {
            $result = $arr_result[0];
            $data = Room::findOrFail($result->room_id);
            $roomTypeName = Room_type::where('id', $data->roomType_id)->first();
            $facilities = $data->facilities()->get();
            $room_detailImages =  Room_image::where(['room_id' => $data->id ])->orderBy('position', 'ASC')->get();
            // luot yeu thich cua phong tro - start
            $room_likes = 0;
            $likes_query = "SELECT count(*) AS 'likes' FROM user_like WHERE room_id = '$data->id'";
            $room_likes = DB::select($likes_query)[0]->likes;
            // end
            return view('backend.room.show', [
                'title' => "Phòng trọ được xem nhiều nhất tháng $month năm $year",
                'data' => $data,
                'roomTypeName' => $roomTypeName->name,
                'room_detailImages' => $room_detailImages,
                'facilities' => $facilities,
                'room_likes' => $room_likes,
                'type_page' => 'filter_view'
            ]);
        } else {
            return view('backend.errorPage', [
                'err_msg' => 'Dữ liệu theo thời gian bạn tìm kiếm không tồn tại. Xin lỗi vì sự bất tiện này.',
            ]);
        }

    }



    public function getMostLikedRoom()
    {
        $query = "SELECT room_id, count(*) AS `likes` FROM user_like GROUP BY room_id ORDER BY count(*) DESC LIMIT 1";
        $result = DB::select($query)[0];
        $data = Room::findOrFail($result->room_id);
        $roomTypeName = Room_type::where('id', $data->roomType_id)->first();
        $facilities = $data->facilities()->get();
        $room_detailImages =  Room_image::where(['room_id' => $data->id ])->orderBy('position', 'ASC')->get();
        // luot yeu thich cua phong tro
        $room_likes = $result->likes;
        // so sao voted cua room
        $star_voted = 0;
        $room_voted = User_vote::where(['room_id' => $data->id ])->get();
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
            if($star_voted > 5) {
                $star_voted = 5;
            }
        }
        return view('backend.room.show', [
            'title' => 'Phòng trọ được nhiều lượt yêu thích nhất',
            'data' => $data,
            'roomTypeName' => $roomTypeName->name,
            'room_detailImages' => $room_detailImages,
            'facilities' => $facilities,
            'room_likes' => $room_likes,
            'type_page' => 'filter_like',
            'star_voted' => $star_voted,
        ]);
    }

    public function errorPage()
    {
        return view('backend.errorPage');
    }


    public function test()
    {
        $date = date('Y-m-d');
        $quantity = 1;
        $unit_date = 3;
        $extendInt = date('Y-m-d');
        if($unit_date == 1) {
            $extendInt = mktime(0, 0, 0, date('m'), date('d')+$quantity*7, date('Y') );
        } else if ($unit_date == 2) {
            $extendInt = mktime(0, 0, 0, date('m')+$quantity, date('d'), date('Y') );
        } else {
            $extendInt = mktime(0, 0, 0, date('m'), date('d'), date('Y')+$quantity );

        }
        $extend = date('Y-m-d', $extendInt);
        $time = ExtendPost::where([ 'room_id' => 14 ,'approved_by' => null, 'approved_date' => null])->first();
        dd(date('Y-m-d'));
    }
}
