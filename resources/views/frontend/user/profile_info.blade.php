@extends('frontend.layouts.main')
@section('content')
    <style>

        #mainForm{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 16px;
            background-color: white;
            margin-left: 10%;
        }
        #mainForm *{
            border-radius: 10px;
        }
        #tit{
            text-align: center;
            width: 100%;
        }
        #mainForm div > input,select{
            padding: 5px 10px;
            font-size: 14px;
            transition: 0.2s;
            margin-bottom: 10px;
        }
        #mainForm {
            width: 70%;
            max-width: 600px;
        }
        #mainForm div > input,select{
            width: 100%;
        }

        #mainForm div > input:focus,select:focus{
            border: 1px solid pink;
            outline: none;
        }
        input:not(:focus){
            display: block;
            border: 1px solid rgb(187, 178, 178);
        }
        label{
            display: block;
            width: 100%;
        }
        /* css for upload avatar button */
        .fileContainer {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 30px;
            background-color: hotpink;
            width: 150px;
            color: white;
            margin-top: 10px;
            cursor: pointer;
            transition: 0.2s;
        }
        .fileContainer:hover{
            background-color: rgb(252, 119, 185);
            box-shadow: 2px 2px 10px rgb(167, 165, 165);
        }
        .fileContainer [type=file] {
            height: 0px;
            width: 0px;
            opacity: 0;
            border: none;
        }
        /* css for upload avatar button */
        #mainForm .btn{
            display: inline-block;
            text-decoration: none;
            margin-top: 10px;
            margin-right: 15px;
            padding: 8px 15px;
            cursor: pointer;
            color: white;
            font-size: 14px;
            transition: 0.2s;
        }
        #mainForm .btn-save{
            background-color: rgb(79, 57, 201);
            border: 2px solid rgb(96, 111, 196);
        }
        #mainForm .btn:hover{
            box-shadow: 2px 2px 10px rgb(167, 165, 165);
            filter:saturate(80%);
        }
        #mainForm .btn-cancel{
            background-color: rgb(130, 136, 136);
            border: 2px solid rgb(156, 154, 154);
        }
        @media only screen and (max-width: 768px){
            #mainForm{
                margin: auto;
                width: 90%;
            }
        }
        .profile-nmd {
            margin: 50px auto;
            width: 1200px;
        }
        .my-form {
            margin: 0 auto!important;
            padding: 30px;
            border-radius: 15px;
        }
    </style>
    <div class="profile-nmd">
        <form role="form" id="mainForm" class="row my-form" action="{{ route('guest.updateProfile') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h3 id="tit">Thông tin tài khoản</h3>
            <div class="col-12">
                <label for="email">Email</label>
                <input id="email" type="email" value="{{ $user->email }}" placeholder="your_email@gmail.com" readonly>
            </div>
            {{--        <div class="col-12">--}}
            {{--            <label for="pass">Password</label>--}}
            {{--            <input type="password" value="">--}}
            {{--        </div>--}}
            <div class="col-12">
                <label for="fullname">Họ tên</label>
                <input type="text" id="fullname" name="name" value="{{ $user->name }}" placeholder="Your name">
            </div>
            <div class="col-12 col-md-4">
                <label for="gender">Giới tính</label>
                <select name="gender" id="gender">
                    @if($user->gender == 1)
                        <option value="1">Nam</option>
                        <option value="2">Nữ</option>
                        <option value="3">Khác</option>
                    @elseif($user->gender == 2)
                        <option value="2">Nữ</option>
                        <option value="1">Nam</option>
                        <option value="3">Khác</option>
                    @else
                        <option value="3">Khác</option>
                        <option value="1">Nam</option>
                        <option value="2">Nữ</option>
                    @endif
                </select>
            </div>
            <div class="col-12 col-md-8">
                <label for="phonenumber">Số điện thoại</label>
                <input type="text" id="phonenumber" name="phone" value="{{ $user->phone }}">
            </div>

            <div class="col-12 col-md-4">
                <label for="birthdate">Ngày sinh</label>
                <input type="text" id="birthdate" name="birthday" value="{{ $user->birthday }}">
            </div>
            <div class="col-12 col-md-8">
                <label for="id">Số CMND/ Căn cước</label>
                <input type="text" id="id" name="cmnd" value="{{ $user->CMND }}" placeholder="VD : 0335231548761">
            </div>
            <div class="col-12 ">
                <label for="address">Địa chỉ</label>
                <input type="text" name="address" value="{{ $user->address }}" id="address">
            </div>

            <div class="col-12">
                <label for="avatar" class="fileContainer">Đổi ảnh đại diện
                    <input type="file" id="avatar" name="new_avatar">
                </label>
            </div>
            <div class="col-12 ">
                <button type="submit" class="btn btn-save">Lưu thay đổi</button>
                <a class="btn btn-cancel" href="">Huỷ</a>
            </div>

        </form>
    </div>
    <script src="../frontend/js/main.js"></script>
    @if(session('update_status') == true)
        <script>
            function myF() {
                alert('bạn đã thay đổi tài khoản thành công!');
            }
            getAvatarUser({{ $user->id }});
            setTimeout(myF, 1500);
        </script>
    @endif
@endsection

