<?php

namespace App\Http\Controllers;

use App\District;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    // function search title room
    public function searchFromHome()
    {
        $key_title = '';
        $key_title = $_GET['key_title'];
        $search_query = "SELECT * FROM room WHERE MATCH(title)AGAINST('$key_title')";
        $data = DB::select($search_query);
        return view('frontend.room.index', [
            'data' => $data,
            'action' => 'search',
            'title' => "Phòng theo từ khóa '" . $key_title . "'",
        ]);
    }

    public function searchByDistrict($district_id)
    {
        $district = District::findOrFail($district_id);
        $district_name = $district->name;
        $data = Room::where(['district_id' => $district_id, 'is_active' => 1])->get();
        return view('frontend.room.index', [
            'data' => $data,
            'action' => 'search',
            'title' => "Phòng ở quận " . $district_name,
        ]);
    }

    public function searchTitle($key_title)
    {
        $search_query = "SELECT * FROM room WHERE MATCH(title) AGAINST('$key_title')";
        $data = DB::select($search_query);
//        dd($data);
        return json_encode($data);
    }

    // function filter
    public function getListDistrict($city_id)
    {
        $data = District::where(['city_id' => $city_id])->get(['id', 'name']);
        return json_encode($data);
    }

    public function roomFilter($under_p, $r_type, $c_id, $d_id, $w_owner)
    {
        $under_price = $under_p;
        $under_price = $under_price*1000000;
        $room_type = $r_type;
        $city_id = $c_id;
        $district_id = $d_id;
        if($room_type == 0 && $city_id != 0 && $district_id != 0) // nguoi dung k chon loai phong
        {
            $data = Room::where(['is_active' => 1, 'city_id' => $city_id, 'district_id' => $district_id, 'live_with_owner' => $w_owner],
                ['price', '<=', $under_price])->get();
        } else if ($room_type != 0 && $city_id != 0 && $district_id == 0) { // nguoi dung k chon quan/huyen
            $data = Room::where(['is_active' => 1, 'roomType_id' => $room_type, 'city_id' => $city_id, 'live_with_owner' => $w_owner],
                ['price', '<=', $under_price])->get();
        } else if ($room_type == 0 && $city_id != 0 && $district_id == 0) { // nguoi dung k chon quan/huyen va k chon loai phong
            $data = Room::where(['is_active' => 1, 'city_id' => $city_id, 'live_with_owner' => $w_owner],
                ['price', '<=', $under_price])->get();
        } else {
            $data = Room::where(['is_active' => 1, 'roomType_id' => $room_type, 'city_id' => $city_id, 'district_id' => $district_id, 'live_with_owner' => $w_owner],
                ['price', '<=', $under_price])->get();
        }



//        dd($data);
        if(count($data) == 0) {
            return response()->json([
                'status' => false,
                'msg' => 'Không có phòng phù hợp',
        ]);
        } else {
            return response()->json([
               'status' => true,
               'data' => $data,
                'msg' => 'Tìm kiếm phòng thành công. Có ' . count($data) . ' phòng phù hợp.',
            ]);
        }

//
//        dd($data);
//        dd($request);
    }


}
