<?php
    $blog = \App\Post::where(['is_active' => 1])->limit(4)->get();
?>

<div style="background-color: #F7346F;">
    <div class="container">

        <!-- Grid row-->
        <div class="row py-4 d-flex align-items-center ">

            <!-- Grid column -->
            <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
                <h6 class="mb-0">Kết nối với chúng tôi trên các nền tảng mạng xã hội !</h6>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-6 col-lg-7 text-center text-md-right">

                <!-- Facebook -->
                <a href="#" class="fb-ic">
                    <i class="fab fa-facebook mr-4" aria-hidden="true"></i>
                </a>
                <!-- Twitter -->
                <a href="" class="tw-ic">
                    <i class="fab fa-twitter white-text mr-4"> </i>
                </a>
                <!-- Google +-->
                <a href="" class="gplus-ic">
                    <i class="fab fa-google-plus mr-4 white-text" aria-hidden="true"></i>
                </a>
                <!--Linkedin -->
                <a href="" class="li-ic">
                    <i class="fab fa-linkedin mr-4 white-text" aria-hidden="true"></i>
                </a>
                <!--Instagram-->
                <a href="" class="ins-ic">
                    <i class="fab fa-instagram white-text" aria-hidden="true"></i>
                </a>

            </div>
            <!-- Grid column -->

        </div>
        <!-- Grid row-->

    </div>
</div>

<!-- Footer Links -->
<div class="container text-center text-md-left mt-5 nmd-footer">

    <!-- Grid row -->
    <div class="row mt-3">

        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

            <!-- Content -->
            <h6 class="text-uppercase font-weight-bold">renthouse</h6>
            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
            <p>Được sinh ra để giúp mọi người dễ dàng hơn trong việc tìm kiếm cho mình căn phòng phù hợp. Tránh rủi ro, tin rác, uy tín tạo niềm tin.</p>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

            <!-- Links -->
            <h6 class="text-uppercase font-weight-bold">Về Renthouse</h6>
            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
            <p>
                <a href="#!">Giới thiệu</a>
            </p>
            <p>
                <a href="{{ route('guest.allroom') }}">Phòng trọ</a>
            </p>
            <p>
                <a href="{{ route('guest.blog') }}">Bài viết</a>
            </p>
            <p>
                <a href="#!">Tuyển dụng</a>
            </p>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">

            <!-- Links -->
            <h6 class="text-uppercase font-weight-bold">Thông tin hữu ích</h6>
            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">


            <p>
                <a href="#!">Quy định cần biết</a>
            </p>
            <p>
                <a href="#!">Hỗ trợ khách hàng</a>
            </p>
            <p>
                <a href="#!">An toàn mua bán</a>
            </p>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

            <!-- Links -->
            <h6 class="text-uppercase font-weight-bold">Liên hệ</h6>
            <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
            <p>
                <i class="fa fa-home mr-3" aria-hidden="true"></i>144 Xuân Thủy, Dịch Vọng Hậu, Cầu Giấy, Hà Nội</p>
            <p>
                <i class="fa fa-envelope mr-3" aria-hidden="true"></i> renthouse.84@gmail.com</p>
            <p>
                <i class="fa fa-phone mr-3" aria-hidden="true"></i>0838033333</p>
{{--            <p>--}}
{{--                <i class="fa fa-print mr-3 white-text" aria-hidden="true"></i>0838033333</p>--}}

        </div>
        <!-- Grid column -->

    </div>
    <!-- Grid row -->

</div>
<!-- Footer Links -->

<!-- Copyright -->
<div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href="">Rent House</a>
</div>
<!-- Copyright -->
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v9.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>


<div class="fb-customerchat"
     attribution=setup_tool
     page_id="101421108555719"
     theme_color="#fa3c4c"
     logged_in_greeting="Chào bạn. Chúng tôi có thể giúp gì cho bạn nhỉ ?"
     logged_out_greeting="Chào bạn. Chúng tôi có thể giúp gì cho bạn nhỉ ?">
</div>
