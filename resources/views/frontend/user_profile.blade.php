@extends('frontend.layouts.main')
@section('content')
    <style>
        .top-bar{
            position: relative;
        }
        .top-bar .extra-menu {
            display: flex;
        }
        /* account info style */
        .account{
            display: inline-flex;
            margin-top: 30px;
            background-color: white;
            padding: 10px 20px;
            border-radius: 10px;
            margin-left: 5%;
        }
        .account > img{
            height: 50px;
            width: 50px;
            border-radius: 50%;
            border: 1px solid gainsboro;
            overflow: hidden;
            object-fit: cover;
            margin-right: 10px;
        }
        .account > div{
            padding: 0;
        }
        .account p{
            margin: 0;
        }
        .info p:first-child{
            font-weight: 500;
        }
        /* account info style */

        .account-nav{
            list-style-type: none;
            /* margin-bottom: 200px; */
            min-width: 200px;
            margin-top: 20px;
            margin-left: 5%;

        }
        .account-nav li{
            height: auto;
            font-size: auto;
            background-color: rgb(250, 250, 250);

        }

        .account-nav li{
            display: flex;
            width: 100%;
            align-items: center;
            color: rgb(0, 0, 0);
            text-decoration: none;
            overflow: hidden;
            padding: 20px;
            cursor: pointer;
            transition: 0.3s;

        }
        .account-nav li:hover{
            background-color: rgb(224, 220, 220);
        }
        .account-nav li.is-actived{
            background-color:  rgb(224, 220, 220);
        }
        .account-nav li span:first-child{
            margin-right: 15px;
            color: rgb(95, 94, 94);
        }
        iframe{
            min-height: 100%;
            flex-grow: 1;
            margin-right: 5%;
            background-color: white;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 20px 10px;
            margin-left: 20px;
            border-radius: 10px;
            overflow-y: scroll;
            transition: 0.2s;
        }
        #fb-root {
            display: none!important;
        }
        @media only screen and (max-width: 768px){
            iframe{
                margin: 20px 2%;

            }
            .account-nav{
                margin-left: 0;
            }
            .account{
                margin-left: 0;
            }
        }

    </style>

    <div class="body container-fluid">
        <div class="account">
            <img src="{{ asset($user->image) }}" alt="Ảnh đại diện của {{ $user->name }}" id="user_image">
            <div class="info">
                <p>Tài khoản của</p>
                <p>{{ $user->name }}</p>
            </div>
        </div>
        <div class="profile row">
            <ul class="account-nav col-md-3 col-12">
                <li class="is-actived" id="acc-show">
                    <span><i class="fa fa-user" aria-hidden="true"></i></span>
                    <span>Thay đổi mật khẩu</span>
                </li>
                <li id="noti-show">
                    <span><i class="fa fa-bell" aria-hidden="true"></i></span>
                    <span>Thông báo</span>
                </li>
{{--                <li id="liked-show">--}}
{{--                    <span><i class="fa fa-heart" aria-hidden="true"></i></span>--}}
{{--                    <span>Phòng đã thích</span>--}}
{{--                </li>--}}
            </ul>

            <iframe id="mainFrame" class="col-12 col-md-7" src="{{ route('changePassword-page') }}" frameborder="0" scrolling="no"></iframe>
        </div>
    </div>

    <script src="../frontend/js/profile_sw.js"></script>
    <script src="../frontend/js/iframeResizer.min.js"></script>
    <script src="../frontend/js/resize-profile.js"></script>

@endsection
