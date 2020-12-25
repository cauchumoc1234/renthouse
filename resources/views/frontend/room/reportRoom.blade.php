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
        <form id="mainForm" class="row my-form">
            <h3 id="tit">Gửi báo cáo / báo cáo phòng vi phạm</h3>
            <div class="col-12">
                <label for="room_id">Báo cáo phòng: <b>{{ $room->title }}</b></label>
                <input id="room_id" type="text" value="{{ $room->id }}" name="room_id" placeholder="ID phòng" readonly>
            </div>
            {{--        <div class="col-12">--}}
            {{--            <label for="pass">Password</label>--}}
            {{--            <input type="password" value="">--}}
            {{--        </div>--}}
            <div class="col-12">
                <label for="content">Nội dung</label>
                <textarea type="text" id="content" name="content" value="" rows="5" cols="67" style="padding: 10px;" placeholder="Viết nội dung tại đây"></textarea>
            </div>


            <div class="col-12 ">
                <button type="button" onclick="storeReport()" class="btn btn-save" data-toggle="modal" data-target=".bd-example-modal-sm">Gửi báo cáo</button>
                <a class="btn btn-cancel" href="">Huỷ</a>
            </div>
        </form>

{{--        <div class="col-12 ">--}}
{{--            <button class="btn btn-save" data-toggle="modal" data-target=".bd-example-modal-sm">Gửi báo cáo</button>--}}
{{--            <a class="btn btn-cancel" href="">Huỷ</a>--}}
{{--        </div>--}}

    </div>
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                </div>
                <div class="modal-body storeliked-msg">

                </div>
            </div>
        </div>
    </div>
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
    <script src="../frontend/js/main.js"></script>

@endsection

