@extends('frontend.layouts.main')
@section('content')
    <style>
        .rooms{
            /* height: 90% !important; */
        }
        .rooms .room {
            min-height: 20%;

        }
        .room-img{
            height: 100%;
        }
        .room-info{
            height: 100%;
            /* overflow-y: scroll; */
        }
        .room-detail .line span,.room-info p{
            font-size: 14px;
        }
        /* .line-1,.line-2,.line-3,.line-4{
            display: inline-block;
        }
        .line-2,.line-4{
            margin-left: 10%;
        } */
        @media only screen and (max-width:768px){
            .room-detail .line span{
                font-size: 1rem;
            }
            .room{
                width: 100% !important;
                margin-right: 0 !important;
                margin-left: 0 !important;
            }
        }
        @media only screen and (max-width:568px){
            .room-detail .line span{
                font-size: 0.8rem;
            }
        }
        .my-page {
            margin: 100px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
        }
    </style>

    <div class="my-page">
        <h3>Các phòng đã thích</h3>
        <div class="rooms">
                    @if(count($data) == 0)
                        <p>Bạn chưa thích phòng nào</p>
                    @else
                        @foreach($data as $room)
                            <a href="javascript:void(0)" id="room-{{ $room->id }}" class="my-room">
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

                                            <div class="line line-6">
                                                <button class="btn btn-warning" style="margin-top: 52px" onclick="destroyLikedRoom({{ $room->id }})">Bỏ thích phòng này</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <hr>
                        @endforeach
                    @endif

            {{--            <nav id="pagnition">--}}
            {{--                <ul class="pagination">--}}
            {{--                    <li class="page-item">--}}
            {{--                        <a class="page-link" href="#" aria-label="Previous">--}}
            {{--                            <span aria-hidden="true">&laquo;</span>--}}
            {{--                        </a>--}}
            {{--                    </li>--}}
            {{--                    <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
            {{--                    <li class="page-item"><a class="page-link" href="#">2</a></li>--}}
            {{--                    <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
            {{--                    <li class="page-item">--}}
            {{--                        <a class="page-link" href="#" aria-label="Next">--}}
            {{--                            <span aria-hidden="true">&raquo;</span>--}}
            {{--                        </a>--}}
            {{--                    </li>--}}
            {{--                </ul>--}}
            {{--            </nav>--}}
        </div>
    </div>
    <script src="../frontend/js/main.js"></script>
    <script>
        // hiện thanh search phụ khi kéo xuống
        $("document").ready(function() {
            $(window).scroll(function() {
                if ($(window).scrollTop() > 10) {
                    $(".extra-menu").css("display", "flex");
                } else {
                    $(".extra-menu").hide();
                }
            })
        })


    </script>
@endsection
