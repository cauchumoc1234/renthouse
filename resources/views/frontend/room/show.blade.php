@extends('frontend.layouts.main')
@section('content')
    <style>
        .extra-menu{
            display: flex !important;
        }
        .body{
            transform: translateY(150px);
            margin-bottom: 250px;
            min-height: 100px;
        }
        .slide-show{
            position: relative;
            display: flex;
            justify-content: center;
            background-color: white;
            height: 400px;
            width: 70%;
            border-radius: 10px;
            overflow: hidden;
        }
        .slide-show img{
            width: 100%;
            height: 100%;
            object-fit: contain;
            position: absolute;
            transition: 0.15s;
        }
        .slide-show .button{
            position: absolute;
            top: 0;
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 0 3%;
            height: 100%;
            align-items: center;
        }
        .slide-show .button button{
            border: none;
            background-color: rgba(82, 80, 80, 0.4);
            transition: 0.3s;
            outline: none;
            box-sizing: content-box;
            width: 30px;
            height: 40px;
            text-align: center;
            color: white;
        }
        .slide-show .button button:hover{
            background-color: rgba(53, 53, 53, 0.7);
        }
        .room-detail{
            width: 100%;
            margin: auto;
            flex-wrap: wrap;
            padding: 0 15%;
        }
        .room-detail > div{
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 15px;
            margin-right: 10px;
        }
        .room-detail .top-info{
            margin-right: 0px;
        }
        .rate-head{
            display: flex;
        }
        .rate-head > span:first-child{
            margin-right: 10px;
        }
        .hd{
            background-color: rgb(245, 244, 244);
            padding: 5px;
            border-radius: 15px;
            font-weight: bold;
            font-size: 15px;
        }
        .hd i{
            padding: 10px;
            border-radius: 10px;
            color: rgb(255, 255, 255);
            font-size: 15px;
        }
        .room-name{
            font-size: 20px;
            padding-left: 10px;
        }
        .room-info div div:first-child{
            font-size: 12px;
            color: rgb(88, 86, 86);
        }
        .room-info span{
            color: black;
        }
        .rate{
            display: flex;
            margin-top: 10px;
            justify-content: flex-start;
        }
        .rate > span{
            display: inline-block;
            height: 100%;
            margin-right: 20px;
        }
        .star .st-checked{
            color:  #ffff00;
        }
        .comment-section{
            width: 100%;
        }
        .comment-section .title{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .comments .your-cmt{
            display: flex;
            font-size: 12px;
            margin-top: 10px;
            align-items: center;
        }
        .comments .your-cmt textarea{
            display: block;
            flex-grow: 1;
            margin-right: 10px;
            padding: 8px 10px 8px 10px;
            border: 1px solid rgb(218, 208, 208);
        }
        .comments .your-cmt .post-cmt{
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            color: white;
            background-color: rgb(66, 66, 223);
        }
        .other-cmt{
            min-height: 30px;
            margin-top: 10px;
            border: 1px solid rgb(233, 231, 231);
            padding: 0px 0 3px 0;
        }
        .other-cmt > #view-allcmt{
            font-size: 12px;
            padding-left: 3%;
            color: rgb(83, 82, 82);
            font-style: italic;
            cursor: pointer;
        }
        #view-allcmt:hover{
            text-decoration: underline;
        }
        .comment {
            padding: 10px 4%;
            border-bottom: 1px solid rgb(230, 225, 225);
        }
        .comment p{
            margin-bottom: 5px;
            font-size: 12px;
        }
        .comment > a{
            font-size: 14px;
            font-weight: 500;
        }
        .comment .time{
            font-size: 10px;
            color: gray;
        }
        .rate-section{
            position: relative;
        }
        .rate-btn{
            display: block;
            /* height: 15px; */
            font-size: 16px;
            border-radius: 10px;
            border: none;
            margin-right: 10px;
            width: auto;
            word-wrap: none;
            padding: 8px;
        }
        .overlay{
            display: flex;
            justify-content: space-around;
            align-items: center;
            position: absolute;
            height: 50px;
            padding: 0 10px;
            background-color: rgba(67, 181, 185, 0.7);
            right: 0;
            top: 110%;
            border-radius: 5px;
            visibility: hidden;
            opacity: 0;
            transition: 0.5s;
        }
        .overlay label{
            cursor: pointer;
        }
        .overlay input[type="radio"]{
            display: none;
        }

        #del-rate{
            border-radius: 10px;
            border: none;
            margin-left: 5px;
            font-size: 12px;
            padding: 5px 7px;
            outline: none;
        }
        .yellow{
            transition: 0.3s;
            color: yellow;
        }
        .add-to-wl{
            margin-top: 10px;
            background-color: rgb(240, 89, 89);
            outline: none;
            border: none;
            transition: 0.2s;
        }
        .add-to-wl:hover{
            background-color: rgb(236, 61, 61);
        }

        @media only screen and (max-width: 768px){
            .comment > a{
                font-size: 14px;
            }
            .room-name{
                font-size: 18px !important;
            }
            .room-address,.rate-head{
                font-size: 14px;
            }
            .adjust-font{
                font-size: 12px !important;
            }
            .hd{
                font-size: 14px;
            }
            .slide-show img{
                width: 100%;
                height: 100%;
                object-fit: contain;
            }
            .slide-show{
                width: 90%;
            }
            .room-detail{
                padding: 0 5%;
            }
        }

        @media only screen and (max-width: 568px){
            .slide-show{
                height: 30vh;
            }
            .comment > a{
                font-size: 12px;
            }
            .room-name{
                font-size: 16px !important;
            }
            .adjust-font{
                font-size: 10px !important;
            }
            .hd{
                font-size: 12px;
            }
            .room-address,.rate-head{
                font-size: 12px;
            }
        }
    </style>
    <div class="body container-fluid">
        <div class="row">

            <div class="slide-show mx-auto">
                @foreach($room_detailImages as $item)
                    <img class="slide-img" src="{{ asset($item->image) }}" alt="">
                @endforeach

                <div class="button">
                    <button class="prev"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
                    <button class="next"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="room-detail row">
                <!-- tên,địa chỉ phòng -->
                <div class="top-info col-12 col-md">
                    <p class="room-name hd">{{ $data->title }}</p>
                    <div class="room-address">
                        <span class="city">{{ $city_name }}</span>
                        <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        <span class="distric">{{ $district_name }}</span>
                        <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                        <span class="address">{{ $data->address }}</span>
                    </div>
                    <div class="rate-head">
                        @if($star_voted == 0)
                            <span>Đánh giá: <span id="voted-content">Chưa có đánh giá nào</span>
                                <div class="star">
                                    <span class="fa fa-star" id="star-icon"></span>
                                    <span class="fa fa-star" id="star-icon"></span>
                                    <span class="fa fa-star" id="star-icon"></span>
                                    <span class="fa fa-star" id="star-icon"></span>
                                    <span class="fa fa-star" id="star-icon"></span>
                                </div>
                            </span>
                        @elseif($star_voted > 0 && $star_voted < 1)
                            <span>Đánh giá: <span id="voted-content">{{ $star_voted . ' sao' }}</span>
                                <div class="star">
                                    <span class="fa fa-star" id="star-icon"></span>
                                    <span class="fa fa-star" id="star-icon"></span>
                                    <span class="fa fa-star" id="star-icon"></span>
                                    <span class="fa fa-star" id="star-icon"></span>
                                    <span class="fa fa-star" id="star-icon"></span>
                                </div>
                            </span>
                        @else
                            <?php $star_voted = round($star_voted, 0); ?>
                            <span>Đánh giá: <span id="voted-content">{{ $star_voted . ' sao' }}</span>
                                <div class="star">
                                    @for($i=0; $i < $star_voted; $i++)
                                        <span class="fa fa-star st-checked" id="star-icon"></span>
                                    @endfor
                                    @for($i=0; $i < 5-$star_voted; $i++)
                                        <span class="fa fa-star" id="star-icon"></span>
                                    @endfor
                                </div>
                            </span>
                        @endif
                        <span>Lượt xem: <span>{{ $data->views }}</span></span>
                    </div>
                    <button type="button" onclick="storeLikedRoom({{ $data->id }})" class="add-to-wl btn btn-success" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="fa fa-heart" aria-hidden="true"></i>
                        Lưu phòng này</button>

{{--                    <div class="add-to-wl btn btn-success">--}}
{{--                        <i class="fa fa-heart" aria-hidden="true"></i>--}}
{{--                        Lưu phòng này--}}
{{--                    </div>--}}
                </div>
                <!-- thông tin chủ -->
                <div class="owner-info adjust-font own col-12">
                    <p class="hd"><i class="fa fa-user bg-warning" aria-hidden="true"></i> Thông tin chủ phòng</p>
                    <div class="own-name">
                        <span>Họ tên:</span>
                        <span>{{ $owner_name }}</span>
                    </div>
                    <div class="phone">
                        <span>SĐT:</span>
                        <span>{{ $owner_phone }}</span>
                    </div>
                </div>
                <!-- thông tin chung -->
                <div class="room-info adjust-font rm col-12 col-md">
                    <p class="hd"><i class="fa fa-home bg-primary" aria-hidden="true"></i> Thông tin phòng</p>
                    <div class="rm-price">
                        <div>GIÁ PHÒNG</div>
                        <div><span>{{  number_format($data->price,0,",",".") }}</span> đồng</div>
                    </div>
                    <div class="rm-area">
                        <div>DIỆN TÍCH</div>
                        <div><span>{{ $data->area }}</span> m <sup>2</sup></div>
                    </div>
                    <div class="rm-deposit">
                        <div>ĐẶT CỌC</div>
                        <div><span>2</span> tháng</div>
                    </div>
                    <div class="rm-address">
                        <div>ĐỊA CHỈ</div>
                        <div><span>{{ $data->address }}</span></div>
                    </div>
                </div>
                <!-- cơ sở vật chất -->
                <div class="room-facilities adjust-font rf col-12 col-md">
                    <p class="hd "><i class="fa fa-cog bg-success" aria-hidden="true"></i> Tiện ích</p>
                    @foreach($facilities as $f)
                        <div class="item">{{ $f->title }}</div>
                    @endforeach
                </div>
                <!-- thông tin mô tả thêm -->
                <div class="room-more adjust-font rmore col-12">
                    <p class="hd"><i class="fa fa-address-book bg-info" aria-hidden="true"></i> Mô tả thêm</p>

                    <div class="">
                            <pre class="adjust-font" itemprop="description">
{{--                                {{ $data->description }}--}}
TÌM NGƯỜI Ở GHÉP
KTX khu đô thị VẠN PHÚC ( gần đh LUẬT, HUTECH, NGOẠI THƯƠNG,
GTVT…)
KTX trong khu đô thị Vạn Phúc của chúng tôi sẽ đáp ứng được các nhu cầu của bạn.
TIỆN NGHI:
- Phòng rộng 40m2
- Hầm để xe máy siêu rộng, siêu thoáng
- Tủ quần áo, kệ dép,…..
- Đường truyền Internet wfi tốc độ cao
- Giờ giấc tự do, thoải mái
- Bảo vệ 2 vòng tại cổng vào và ra, bảo vệ đi tuần ( 30p/ lần)
- Có sân thượng view đẹp, trang bị bàn ghế
giá 1tr3-1tr5/tháng/người ( bao gồm điện nước + wifi , không phụ thu thêm phí )
                            </pre>
                    </div>
                </div>
                <div class="comment-section">
                    <div class="title">
                        <span>Bình luận</span>

                    </div>
                    <div class="comments">
                        <div class="other-cmt">
                            <div class="comment">
                                <a href="#">Thành Draw</a>
                                <span class="time">5 giờ trước</span>
                                <p>Phòng an ninh tốt,hay mất dép</p>
                            </div>
                            <div class="comment">
                                <a href="#">G-Dragon</a>
                                <span class="time">10 giờ trước</span>
                                <p>Bắt ở với Sơn Tùng rate 1*</p>
                            </div>
                            <div class="comment">
                                <a href="#">Tiến Bịp</a>
                                <span class="time">15 giờ trước</span>
                                <p>Phòng không có bình đá</p>
                            </div>
                            <div class="comment">
                                <a href="#">Trường Con</a>
                                <span class="time">1 ngày trước</span>
                                <p>Không cho nấu cơm không ăn trực được, 1*</p>
                            </div>
                            <span id="view-allcmt" href="#" class="ml-2">Xem tất cả</span>
                        </div>
                        <form class="your-cmt" id="myForm">
                            <textarea name="" id="user_comment" cols="30" rows="1" maxlength="150" placeholder="Nhập bình luận..."></textarea>
                            <div class="rate-section">
                                <button type="button" class="rate-btn " >Đánh giá</button>
                                <div class="overlay">
                                    <input type="radio" name="rate"  id="rate-1" value="1">
                                    <input type="radio" name="rate"   id="rate-2" value="2">
                                    <input type="radio" name="rate"   id="rate-3" value="3">
                                    <input type="radio" name="rate"   id="rate-4" value="4">
                                    <input type="radio" name="rate"   id="rate-5" value="5">
                                    <label for="rate-1" class="rate" id="s1"><i class="fa fa-star" aria-hidden="true"></i></label>
                                    <label for="rate-2" class="rate" id="s2"><i class="fa fa-star" aria-hidden="true"></i></label>
                                    <label for="rate-3" class="rate" id="s3"><i class="fa fa-star" aria-hidden="true"></i></label>
                                    <label for="rate-4" id="s4" class="rate"><i class="fa fa-star" aria-hidden="true"></i></label>
                                    <label for="rate-5" id="s5" class="rate"><i class="fa fa-star" aria-hidden="true"></i></label>
                                    <button id="del-rate" >Xoá</button>
                                </div>
                            </div>
                        </form>
                        <div class="guest-btn">
                            <button class="post-cmt btn btn-primary" onclick="userComment({{ $data->id }})" style="margin-top: 5px" data-toggle="modal" data-target=".bd-example-modal-sm">Gửi bình luận</button>
                            <button class="post-cmt btn btn-primary" onclick="storeVoted({{ $data->id }})" style="margin-top: 5px; margin-left: 630px;" data-toggle="modal" data-target=".bd-example-modal-sm">Gửi đánh giá</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
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
    <script src="../frontend/js/drop_menu.js"></script>
    <script src="../frontend/js/slide-show.js"></script>
    <script src="../frontend/js/rate.js"></script>
@endsection
