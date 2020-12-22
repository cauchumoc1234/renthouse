@extends('frontend.layouts.main')
@section('content')
    <style>
        *{
            outline: none;
        }
        .header{
            margin-bottom: 140px;
        }
        body{
            display: flex;
            flex-direction: column;
        }
        .body{
            height: 100%;
            margin-bottom: 0;
        }
        .main-section{
            margin-bottom: 100px;
        }
        .extra-menu{
            display: flex !important;
        }
        .hero{
            width: 100%;
            height: 100%;
            font-family: sans-serif;

        }
        .form-box{
            width: 380px;
            height: 590px;
            position: relative;
            margin: 6% auto;
            background: rgb(255, 255, 255);
            padding: 5px;
            overflow: hidden;
        }
        .button-box{
            width: 220px;
            margin: 35px auto;
            position: relative;
            box-shadow: 0 0 20px 9px #f8f3f11f;
            border-radius: 30px;
            display: flex;
            background-color: rgba(105, 105, 121, 0.5);
        }
        .toggle-btn{
            padding: 10px 10px;
            cursor: pointer;
            background: transparent ;
            border: 0;
            outline: none;
            position: relative;
            flex-grow: 1;
            color: rgb(255, 255, 255);
        }
        .toggle-btn:focus{
            outline: none;
        }
        #btn{
            top: 0;
            left: 0;
            position: absolute;
            width: 110px;
            height: 100%;
            background:rgb(241, 50, 155);
            border-radius: 30px;
            transition: 0.5s;
            outline: none;
        }
        .social-icon{
            margin: 30px auto;
            text-align: center;
        }
        .social-icon img{
            width: 30px;
            margin: 0 12px;
            box-shadow: 0 0 20px 0 #7f7f7f3d;
            cursor: pointer;
            border-radius: 50%;
        }
        .input-group{
            top: 180px;
            position: absolute;
            width: 280px;
            transition: .5s;
        }
        .input-field{
            width: 100%;
            padding: 10px 0;
            margin: 5px 0;
            border-left: 0;
            border-top: 0;
            border-right: 0;
            border-bottom: 1px solid #999;
            outline: none;
            background: transparent;
            color: rgb(64, 139, 139);
        }
        .submit-btn{
            width: 85%;
            padding: 10px 30px;
            cursor: pointer;
            display: block;
            margin: auto;
            background:rgb(252, 0, 155);;
            border: 0;
            outline: 0;
            border-radius: 30px;
            color: rgb(253, 249, 249);
            transition: 0.3s;
            outline: none;
        }
        .submit-btn:hover{
            background-color:rgba(197, 12, 135);
        }

        .checkbox{
            margin: 30px 10px 30px 0;
        }
        span.rmb{
            color: #777;
            font-size: 12px;
            margin: 28px 10px 30px 0;
            /* position: absolute; */
        }
        #login{
            position: absolute;
            left: 50px;
        }
        #register{
            position: absolute;
            left: 450px;
        }
        .error-msg {
            font-size: 14px;
            color: red;
            margin-left: -148px;
        }
        #email-msg {
            font-size: 13px;
        }
    </style>
    <div class="body main-section container-fluid">
        <div class="row">

            <div class="hero">
                <div class="form-box">
                    <!-- hộp nút chuyển form trên cùng -->
                    <div class="button-box">
                        <!-- nút sáng -->
                        <div id="btn"></div>

                        <button type="button" class="toggle-btn" onclick="login()">Log In</button>
                        <button type="button" class="toggle-btn"  onclick="register()">Register</button>
                    </div>
                    <!-- form đăng nhập -->
                    <form role="form" id="login" action="{{ route('guest.postLogin') }}" class="input-group" method="post">
                        @csrf
                        <input type="email" class="input-field" name="email" placeholder="User Name" required>
                        <input type="password" class="input-field" name="password" placeholder="Enter Password" required>

                        <input type="checkbox" name="remember" id="remember" class="checkbox"><span class="rmb">Remember Password</span>
                        @if(session('msg'))
                            <span role="alert" class="error-msg">{{ session('msg') }}</span>
                        @endif

                        <button type="submit" class="submit-btn">Login</button>

                    </form>
                    <!-- form đăng ký -->
                    <form role="form" id="register" action="{{ route('guest.postRegister') }}" class="input-group" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="text" class="input-field" name="name" placeholder="User Name" required>
                        <input type="email" class="input-field" id="register_email" name="email" placeholder="Email" pattern=".+@.+(\.[a-z]{2,3})" title="Kiểm tra lại định dạng email" onchange="checkExistsEmail()"  required>
                        <span id="email-msg"></span>
                        <input type="password" class="input-field" id="register_password" name="password" placeholder="Enter Password" pattern=".{8,}" onchange="checkPass()" title="Mật khẩu phải từ 8 kí tự" required>
                        <input type="password" class="input-field" id="register_re_password" name="re_password" placeholder="Enter Re-password" onchange="checkPass()" pattern=".{8,}" title="Mật khẩu phải từ 8 kí tự" required>
                        <p class="" id="checkPass" style="color: red; font-size: 13px" ></p>
                        <div>
                            <input type="checkbox" name="" class="checkbox"><span class="rmb">I agree to ther term & conditions</span>
                        </div>
                        <button type="submit" class="submit-btn" id="submit_btn">Register</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script src="../frontend/js/float_form.js"></script>
    <script>
        function checkPass() {
            var pass = $('#register_password').val();
            var rePass = $('#register_re_password').val();
            if (pass != rePass) {
                $('#checkPass').html('Nhập lại mật khẩu không trùng khớp');
                $('#submit_btn').attr('disabled', 'true');
            }else {
                $('#checkPass').html('');
                $('#submit_btn').removeAttr('disabled');

            }

        }

        function checkExistsEmail() {
            let email = $('#register_email').val();
            if(email == '') {
                $('#email-msg').html('');
                $('#submit_btn').removeAttr('disabled');
            } else {
                let msg = '';
                $.ajax({
                    url: base_url + '/checkExistsEmail/'+email, // base_url được khai báo ở đầu page == http://renthouse.co
                    type: 'GET',
                    data: {}, // dữ liệu truyền sang nếu có
                    dataType: "json", // kiểu dữ liệu trả về
                    success: function (response) { // success : kết quả trả về sau khi gửi request ajax
                        if(response != true) {
                            $('#submit_btn').attr('disabled', 'true');
                            msg = 'Email này đã tồn tại. Vui lòng chọn email khác!';
                            $('#email-msg').html(msg);
                            $('#email-msg').css('color', 'red');
                        } else {
                            $('#submit_btn').removeAttr('disabled');
                            msg = 'Email này có thể sử dụng';
                            $('#email-msg').html(msg);
                            $('#email-msg').css('color', '#00fa04');
                        }
                    },
                    error: function (e) { // lỗi nếu có
                        console.log(e.message);
                    }
                });
            }

        }
    </script>
    @if(session('register_status') == 'true')
        <script>
            alert('Tạo tài khoản thành công. Bây giờ bạn có thể đăng nhập và sử dụng dịch vụ của Renthouse!');
        </script>
    @endif
@endsection
