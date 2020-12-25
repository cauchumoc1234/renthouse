@extends('frontend.layouts.main')
@section('content')
    <style>
        .top-bar .extra-menu {
            display: flex;
        }

        .body {
            transform: translateY(130px);
            margin-bottom: 150px;
        }

        .body .filter {
            background-color: white;
            margin: 0 auto;
            padding: 5%;
            border-radius: 15px;
            align-self: flex-start;
        }

        .filter>h2 {
            margin-bottom: 20px;
        }

        .filter form>div {
            margin-bottom: 15px;
        }
        .filter form input[type="range"]{
            -webkit-appearance: none;
            width: 100%;
            height: 15px;
            border-radius: 5px;
            background: #d3d3d3;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
        }
        .filter-btn{
            width: 90%;
            background-color: rgb(255, 130, 151);
            border-radius: 15px;
            border: none;
            padding: 10px 5%;
            font-weight: 500;
            margin: auto;
        }
        .showBtn{
            margin-right: 10px;
            display: flex;
            justify-content: flex-end;
            padding: 10px;
            transition: 0.2s;
        }
        .op {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .item{
            display: none;
        }
        #city{
            margin-top: 5px;
            border: 1px solid gray;
        }
        @media only screen and (max-width: 1024px){
            .main-section{
                width: 95%;
                margin: auto;
                margin-bottom: 200px;
            }
        }
        @media only screen and (max-width: 768px) {
            .body .filter {
                padding: 30px 2%;
                margin-bottom: 30px;
            }
            .body .filter form{
                display: flex;
                justify-content: space-between;
            }
        }

    /*    nmd css*/
        .select-city {
            padding: 5px;
            border: 1px solid black;
            border-radius: 5px;
        }
    </style>
    <?php
//        $all_district = \App\District::all();
        $all_roomtype = \App\Room_type::all();
//        $facilities = \App\Facilities::all();
        $city = \App\City::all();
    ?>
    <div class="body main-section container-fluid">
        <div class="row">
            <div class="col-12 col-md-3 filter">
                <h2>Bộ lọc</h2>
{{--                filter form out here--}}
                <form role="form" action="#" method="post" class="row" enctype="multipart/form-data">
                    <div class="col-12">
                        <h5 class="op">Giá thấp hơn</h5>
                        <span><span id="pr-value">8</span> triệu</span>
                        <br>
                        <input type="range" name="price" id="price" type="range" min="0.5" max="15" step="0.5" value="8">
                    </div>
                    <div class="col-12">
                        <h5 class="op">Loại phòng</h5>


                        <select class="select-city" name="room-type" id="room-type">
                            <option value="0">-- Chọn loại phòng --</option>
                            @foreach($all_roomtype as $rt)
                                <option value="{{ $rt->id }}">{{ $rt->name }}</option>
                            @endforeach
                        </select>
                    </div>
{{--                    <div class="room-type col-12">--}}
{{--                        <h5 class="op">Loại phòng <span class="showBtn"><i class="fa fa-caret-down" aria-hidden="true"></i></span></h5>--}}
{{--                        @foreach($all_roomtype as $rt)--}}
{{--                            <div class="item">--}}
{{--                                <input type="checkbox" id="room-type-{{ $rt->id }}" value="{{ $rt->id }}">--}}
{{--                                <label for="room-type-{{ $rt->id }}">{{ $rt->name }}</label>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}

{{--                    </div>--}}
                    <div class="col-12">
                        <h5 class="op">Thành phố </h5>


                        <select class="select-city" name="city" id="city" onchange="getAllDistrict()">
                            @foreach($city as $ct)
                                <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <h5 class="op">Quận </h5>
                        <select class="select-city" name="district" id="district">
                            <option value="0">-- Chọn quận --</option>
                        </select>

                    </div>

                    <div class="col-12">
                        <h5 class="op">Chung chủ</h5>
                        <select class="select-city" name="with_owner" id="with_owner">
                            <option value="0">Không</option>
                            <option value="1">Có</option>
                        </select>
                    </div>


                </form>
                <button class="filter-btn" onclick="filterRoom()" data-toggle="modal" data-target=".bd-example-modal-sm">Lọc</button>

            </div>
            <div class="col-12 col-md-8 newest-rooms room-list">
                <div class="top">
                    <h2 id="page-title">{{ $title }}</h2>
                </div>
                <div class="rooms">
                    @foreach($data as $room)
                        <a href="{{ route('guest.showroom', ['room_id' => $room->id]) }}" id="room-{{ $room->id }}" class="my-room">
                            <div class="room row">
                                <div class="room-img col-md-5 col-sm-6 col-12">
                                    <img src="{{ asset($room->image) }}" alt="Ảnh của phòng {{ $room->title }}" style="max-height: 247.09px!important">
                                </div>
                                <div class="room-info col">
                                    <p class="room-name">
                                        {{ $room->title }}
                                    </p>
                                    <div class="room-detail">
                                        <div class="line-1 line">
                                            <span class="icon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                            @if($room->rented == 0)
                                                <span>Còn phòng</span>
                                            @else
                                                <span>Hết phòng</span>
                                            @endif
                                        </div>
                                        <div class="line line-2">
                                            <span class="icon"><i class="fas fa-user-friends"></i></span>
                                            <span>Nam & Nữ</span>
                                        </div>
                                        <div class="line line-3">
                                            <span class="icon"><i class="fas fa-ruler    "></i></span>
                                            <span>{{ $room->area }} m<sup style="font-size: 10px;">2</sup></span>
                                        </div>
                                        <div class="line line-4">
                                            <span class="icon"><i class="fas fa-map-marked    "></i></span>
                                            <span>{{ $room->address }}</span>
                                        </div>
                                        <div class="line line-5">
                                            <span class="icon"><i class="fas fa-money-check    "></i></span>
                                            <span class="price">{{  number_format($room->price,0,",",".") .' đồng/tháng' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <hr>
                    @endforeach


                        @if($action == 'showall')
                            <a href="#" class="view-all btn btn-success" style="margin: 0 auto; width: 110px;">Xem tất cả</a>
                        @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                </div>
                <div class="modal-body noti-msg">

                </div>
            </div>
        </div>
    </div>
    <script src="../frontend/js/price_range.js"></script>
    <script src="../frontend/js/show_filter.js"></script>
    <script src="../frontend/js/room_filter.js"></script>
@endsection
