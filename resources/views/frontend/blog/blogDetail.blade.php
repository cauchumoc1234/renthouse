@extends('frontend.layouts.main')
@section('content')
    <style>
        .header .top-bar .extra-menu{
            display: flex;
        }
        body{
            background-color: white;
        }
        .top-img{
            height: 60vh;
            min-height: 400px;
        }
        .top-img img{
            height: 100%;
            width: 100%;
            object-position: 50%;
            object-fit: cover;
        }
        .body{
            margin-top: 20px;
            min-height: 150px;
        }
        .top-ct > h2,h6{
            /* text-align: center; */
        }
        .main-ct .img-ct{
            width: 100%;
            text-align: center;
        }
        .intro{
            font-size: 0.8rem;
            font-style: italic;
            color: gray;
        }
        .img-ct{
            width: 100%;
            margin-bottom: 20px;
        }
        .img-ct img{
            width: 90%;
            height: auto;
            object-fit: contain;
        }
        .img-ct small{
            font-size: 12px;
            font-style: italic;
        }

        .bottom-ct{
            padding-top: 5px;
            font-style: italic;
            font-size: 12px;
            text-align: end;
        }
        .other-blogs{
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 30px;
            margin-top: 30px;
        }
        .other-blogs a{
            display: block;
            width: 100%;
            font-size: 14px;
            color: gray;
            padding-left: 5px;
        }
        .other-blogs h6{
            padding-left: 5px;
            border-left: 2px solid blue;
        }
        .main-ct img {
            max-width: 1200px!important;
            max-height: 800px!important;
        }
    </style>
    <div class="top-img">
        <img src="{{ asset($data->thumbnail) }}" alt="{{ $data->title }}">
    </div>
    <div class="body">
        <div class="content col-11 col-md-10 mx-auto">
            <article>
                <div class="top-ct">
                    <h1 class="title">{{ $data->title }}</h1>
                    <h6 class="date"> <span><?php $create = date('M d, Y', strtotime($data->created_at)); echo $create ?></span> <span> by </span> <span> {{ $author_name }} </span> </h6>
                </div>
                <div class="main-ct">
                    {!! $data->content !!}
                </div>
{{--                <div class="bottom-ct">--}}
{{--                    <p class="writer">Tác giả : <span>Donald Trump</span></p>--}}
{{--                </div>--}}
            </article>
            <div class="other-blogs">
                <h6>Tin liên quan</h6>
                @foreach($related_post as $item)
                    <a href="{{ route('guest.blogDetail', ['post_id' => $item->id]) }}">{{ $item->title }}</a>
                @endforeach
{{--                    <a href="#">Danh sách nhà trọ homestay xác thực khu vực quận 1</a>--}}
{{--                <a href="#">Kinh nghiệm tìm phòng trọ: Sinh viên nên tìm phòng trọ qua kênh nào</a>--}}
            </div>
        </div>
        <script src="../frontend/js/drop_menu.js"></script>
        <script>
            $(document).ready(function(){
                var iScrollPos = 0;
                $(window).scroll(function () {
                    var iCurScrollPos = $(this).scrollTop();
                    if (iCurScrollPos > iScrollPos) {
                        $(".extra-menu").hide();
                    } else {
                        $(".extra-menu").css("display","flex")
                    }
                    iScrollPos = iCurScrollPos;
                });

            })

        </script>
@endsection
