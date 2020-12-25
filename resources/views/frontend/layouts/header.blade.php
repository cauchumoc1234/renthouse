
<!-- thanh header -->
<div class="top-bar">
    <!-- thanh phía trên header -->
    <div class="large">

        @if(\Illuminate\Support\Facades\Auth::check())
            <?php
                $user = \Illuminate\Support\Facades\Auth::user();
                $noti_s = \App\Notify::where(['receive_id' => $user->id])->get();
            ?>
            <div class="drop-notify">
                <button class="notify" id="note-btn"><i class="fa fa-bell" aria-hidden="true"></i> Thông báo</button>
                <div class="note-table">
                    <ul class="list-noti">
                        @foreach($noti_s as $noti)
                            <li class="noti-{{$noti->id}}"><a href="1">{{ $noti->title }}</a></li>
                        @endforeach
{{--                        <li><a href="1">Phòng bạn thích bị thuê con mẹ mất rồi</a></li>--}}
{{--                        <li><a href="">Gần trường của bạn có 1 phòng đang ế</a></li>--}}
{{--                        <li><a href="#">Cơ hội trúng 1 chuyến du lịch đến cung điện Westminster</a></li>--}}
{{--                        <li><a href="#">Bạn ơi đừng boả vòng</a></li>--}}
{{--                        <li><a href="#">Đme sấu này cứng thế nhỉ? Sấu này ướp đá à</a></li>--}}
                    </ul>
                    <a href="{{ route('guest.userprofile') }}" class="all-note" id="notall">Xem tất cả</a>
                </div>
            </div>
<<<<<<< HEAD
            <div class="profile" onmouseover="show_profiledropdown()" onmouseleave="hide_profiledropdown()">
                <a id="link-profile" class="link-profile" href="javascript:void(0)" style="margin-left:10px">
                    Xin chào, <span id="fullname">{{ $user->name }}</span>
                    <img src="{{ asset($user->image) }}" alt="profile_picture" id="profile-picture">
                </a>
                <ul class="drop-menu">
                    <li><a href="{{ route('profile-info-page') }}">Thông tin cá nhân</a></li>
                    <li><a href="{{ route('liked-rooms') }}">Các phòng đã thích</a></li>
                    <li><a href="{{ route('guest.userprofile') }}">Đổi mật khẩu / Thông báo</a></li>
                    <li><a href="{{ route('guest.logout') }}">Đăng xuất</a></li>
                </ul>
{{--                <a href="{{ route('guest.logout') }}" id="logout">Đăng xuất</a>--}}
            </div>
{{--            <a id="link-profile" href="{{ route('guest.userprofile') }}" style="margin-left:10px">--}}
{{--                Xin chào, <span id="fullname">{{ $user->name }}</span>--}}
{{--                <img src="{{ asset($user->image) }}" alt="profile_picture" id="profile-picture">--}}
{{--            </a>--}}
{{--                <ul class="drop-menu">--}}
{{--                    <li><a href="#">Thông tin cá nhân</a></li>--}}
{{--                    <li><a href="#">Đăng xuất</a></li>--}}
{{--                </ul>--}}
{{--            <a href="{{ route('guest.logout') }}" id="logout">Đăng xuất</a>--}}
=======
            <a id="link-profile" href="{{ route('guest.userprofile') }}" style="margin-left:10px">
                Xin chào, <span id="fullname">{{ $user->name }}</span>
                <img src="{{ asset($user->image) }}" alt="profile_picture" id="profile-picture">
            </a>
            <a href="{{ route('guest.logout') }}" id="logout">Đăng xuất</a>
>>>>>>> 032f69430ad6efda626c5ac697620a5f38a51951
        @else
            <a href="{{ route('guest.login-register') }}">Đăng nhập / </a><a href="{{ route('guest.login-register') }}">Đăng ký</a>
        @endif
    </div>
    <!-- thanh phía trên header -->

    <!-- phần thanh tìm kiếm phụ,hiện ra khi scroll qua thanh tìm kiếm chính -->
    <div class="extra-menu">
        <a href="#" class="logo">
            <img src="https://grandetest.com/theme/findhouse-html/images/header-logo.png" class="logo-top" alt="logo">
{{--            <span>RentHouse</span>--}}
        </a>
        <!-- form tìm kiếm -->
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
            <form action="{{ route('guest.searchFromHome') }}" class="search-input" method="GET">
                <input type="text" name="key_title" placeholder="Tìm kiếm theo địa điểm, quận, tên đường...">
                <div class="submit-button">
                    <button type="submit" id="search-btn"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
            </form>

        </div>
    </div>
    <!-- phần thanh tìm kiếm phụ,hiện ra khi scroll qua thanh tìm kiếm chính -->
</div>
<!-- thanh header -->
<script>
    $("#note-btn").click(function(){
        // $(".popup-noti").fadeIn(300);
        $(".popup-noti").css({"visibility": "visible","opacity":"1"})
    })
    $(".popup-noti").click(function(){
        $(".popup-noti").css({"visibility": "hidden","opacity":"0"})
    })
</script>
