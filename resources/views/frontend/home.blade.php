@extends('frontend.layouts.main')
@section('content')

    <!-- phần giới thiệu trang -->
    <div class="main-bar">
        <div class="info">
            <div class="logo">
                <img src="https://www.ohanaliving.vn/8541c2b17a0729942ed2a6f13b7b13e4.svg" alt="logo">
                <div class="option">
                    <a href="#" class="staying">Trang chủ</a>
                    <a href="{{ route('guest.blog') }}">Blog</a>
                    <a href="#">Đăng phòng</a>
                </div>
            </div>
            <p class="short">Ứng dụng tìm kiếm phòng trọ miễn phí cho người đi thuê hàng đầu Việt Nam</p>
            <div class="search-box">
                <div class="dropdown">
                    <span><i class="fas fa-map-marker-alt icon"></i></span>
                    <!-- nút chọn vị trí -->
                    <select name="city" id="" class="dropBtn">
                        <option value="" selected>Tất cả thành phố</option>
                        <option value="Hanoi">Hà Nội</option>
                        <option value="">Đà Nẵng</option>
                        <option value="">TP. Hồ Chí Minh</option>
                    </select>
                </div>
                <form action="" class="search-input" method="GET">
                    <input type="text" placeholder="Tìm kiếm theo địa điểm, quận, tên đường...">
                    <div class="submit-button">
                        <button id="search-btn"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </form>

            </div>
            <div class="app-link short">
                <p>Tải app để có trải nghiệm tuyệt vời</p>
                <div class="app">
                    <a href="">
                        <img src="https://www.ohanaliving.vn/3f9605492bb7388bbc16f25a16778cbc.png" alt="AppStore">
                    </a>
                    <a href="">
                        <img src="https://www.ohanaliving.vn/137381da1471b1c2ad438c213a34b0a4.png" alt="AppStore">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- phần giới thiệu trang -->
    <div class="body">
        <div class="trending">
            <h2>Xu hướng tìm kiếm</h2>
            <div class="items">
                @foreach($most_searched_districts as $district)
                    <a class="item" href="#" style="text-decoration: none ;background: linear-gradient(0deg, rgba(2,0,36,0.8) 10%, rgba(4,0,0,0.1) 100%),url('{{ asset($district->image) }}') no-repeat 30% center;background-size: cover;"><span>{{ $district->name }}</span></a>
                @endforeach
            </div>

        </div>
        <div class="container-fluid main-section">
            <div class="row">
                <div class="col-12 col-lg-8 newest-rooms room-list">
                    <div class="top">
                        <h2>Phòng mới nhất</h2>
                    </div>
                    <div class="rooms">
                        @foreach($newest_rooms as $room)
                            <a href="{{ route('guest.showroom', ['room_id' => $room->id]) }}" id="room-{{ $room->id }}">
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
                                                <span class="price">6 triệu/tháng</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <hr>
                        @endforeach

                        <a href="{{ route('guest.allroom') }}" class="view-all btn btn-success" style="margin: 0 auto; width: 110px;">Xem tất cả</a>

                    </div>
                </div>
                <div class="col-lg col-sm-12 col-12 posts">
                    <h2>Bài viết</h2>
                    @foreach($posts as $post)
                        <a href="{{ route('guest.blogDetail', ['post_id' => $post->id]) }}" class="post row">
                            <div class="post-img col-lg-12 col-md-5 col-12">
                                <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}">
                            </div>
                            <div class="post-info col-lg-12 col-md-7 col-12">
                                <div class="title">{{ $post->title }}</div>
                                <div class="extra-info">
                                    <span class="date"> <span><?php $create = date('M d, Y', strtotime($post->created_at)); echo $create ?></span> <span> by </span> <span> {{ \App\User::findOrFail($post->user_id)->name }} </span> </span>
                                    <span>&nbsp</span>
                                    <span class="article-views"><i class="fa fa-eye" aria-hidden="true"></i>{{ " " . $post->views }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach


                    <a href="{{ route('guest.blog') }}" class="btn btn-success" style="width:110px; margin: 0 auto; margin-top: 20px; padding: 7px">Xem thêm</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // hiện thanh search phụ khi kéo xuống
        $("document").ready(function() {
            $(window).scroll(function() {
                if ($(window).scrollTop() > 300) {
                    $(".extra-menu").css("display", "flex");
                } else {
                    $(".extra-menu").hide();
                }
            })
        })


    </script>

@endsection
