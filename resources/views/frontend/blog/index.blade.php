@extends('frontend.layouts.main')
@section('content')
    <style>
        .extra-menu{
            display: flex !important;
        }
        body{
            background-color: white;
        }
        .body{
            transform: translateY(150px);
            min-height: 150px;
            margin-bottom: 200px;
        }
        .blog{
            display: flex;
            font-size: 12px;
            color: rgb(100, 100, 100);
        }
        .blog{
            padding: 15px;
        }
        .blog img{
            width: 200px;
            object-fit: cover;
            object-position: center center;
            border-radius: 15px;
            padding: 0;
        }
        .top-blogs{
            width: 80%;
        }
        .top-blogs a{
            text-decoration: none;
            transition: 0.3s;
            border-radius: 10px;
        }
        .top-blogs a .title{
            transition: 0.3s;
        }
        .top-blogs a:hover{
            background-color: rgb(240, 239, 239);
        }
        .top-blogs a:hover .title{
            color: rgb(9, 127, 156);
        }
        .top-blogs a:first-child .title{
            font-size: 30px;
        }
        .top-blogs a:first-child .summary{
            font-size: 20px;
        }
        .top-blogs .col{
            width: 30% !important;
            margin-right: 10px;
        }
        .blog .info{
            padding: 0 2%;
            max-width: 100%;
            position: relative;
        }
        .blog .info .title{
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 5px;
            color: black;
        }
        .pagnition{
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .summary{
            overflow: hidden;
            font-size: 18px;
        }
        .overlay{
            position: absolute;
            width: 100%;
            height: 50%;
            background: rgb(255,255,255);
            background: linear-gradient(0deg, rgba(255,255,255,0.8) 3%, rgba(255,252,252,0.023) 60%);
            top: 50%;
            left: 0px;
        }
        @media only screen and (max-width:768px){
            .blog{
                padding-left: 10px;
            }
            .top-blogs{
                width: 100%;
            }
            .top-blogs a{
                margin-bottom: 15px;
            }
            .top-blogs a:first-child .title{
                font-size: 20px;
            }
            .top-blogs a:first-child .summary{
                font-size: 18px;
            }
        }
    </style>
    <div class="body">
        <div class="mx-auto row top-blogs">
            <a class="col-12" href="{{ route('guest.blogDetail', ['post_id' => $featured_blog->id]) }}">
                <div class="blog row">
                    <img class="col-12 col-md-8" src="{{ asset($featured_blog->thumbnail) }}" alt="{{ $featured_blog->meta_title }}">
                    <div class="info col-md-4">
                        <div class="title">{{ $featured_blog->title }}</div>
                        <div class="summary ">{!! $featured_blog->summary !!} </div>
                    </div>
                    <div class="overlay"></div>
                </div>
            </a>
            @foreach($data as $post)
                <a class="col-md-4" href="{{ route('guest.blogDetail', ['post_id' => $post->id]) }}">
                    <div class="blog row">
                        <img class="col-12" src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}">
                        <div class="info col-12">
                            <div class="title">{{ $post->title }}</div>
                            <div class="summary ">{!! $post->summary !!}</div>

                        </div>
                        <div class="overlay"></div>
                    </div>
                </a>
            @endforeach
{{--            <a class="col-md-4" href="">--}}
{{--                <div class="blog row">--}}
{{--                    <img class="col-12" src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885__340.jpg" alt="">--}}
{{--                    <div class="info col-12">--}}
{{--                        <div class="title">PHÒNG TRỌ SIÊU MINI, SANG CHẢNH, TIỆN NGHI DÀNH CHO MỘT NỮ Ở TẠI ĐỀ THÁM, Q1</div>--}}
{{--                        <div class="summary ">Một không gian sống sang chảnh với những chiếc tổ kén tiện nghi. Lối đi riêng với chủ. Gần : phố Tây Bùi Viện,   Takayashima, phố đi bộ Nguyễn Huệ.</div>--}}

{{--                    </div>--}}
{{--                    <div class="overlay"></div>--}}
{{--                </div>--}}
{{--            </a>--}}

{{--            <div class="pagnition col-12">--}}
{{--                <nav aria-label="...">--}}
{{--                    <ul class="pagination">--}}
{{--                        <li class="page-item disabled">--}}
{{--                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>--}}
{{--                        </li>--}}
{{--                        <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
{{--                        <li class="page-item active" aria-current="page">--}}
{{--                            <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>--}}
{{--                        </li>--}}
{{--                        <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                        <li class="page-item">--}}
{{--                            <a class="page-link" href="#">Next</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </nav>--}}
{{--            </div>--}}
        </div>
    </div>
    <script src="../frontend/js/drop_menu.js"></script>
@endsection
