@extends('backend.layouts.main')
@section('content')
    <style>
        .listImg{
            width: 50%;
            float: left;
        }
        .listImg img{
            -webkit-shape-image-threshold: 100%;
            width:100%;
            object-fit: cover;
            height: 150px;
        }
        .Pad-img{
            padding: 10px;
        }
        .filter {
            display: flex;
            justify-content: space-between;
            width: 35%;
        }
    </style>
<section class="content-header">
    <h1>
        {{ $title }} <a href="{{route('admin.room.index')}}" class="btn btn-success pull-right"> Danh sách phòng trọ </a>
    </h1>
    @if(isset($type_page))
        @if($type_page == 'filter_view')
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary" style="margin-top: 30px">
                        <div class="box-body">
                            <form action="{{ route('admin.getMostViewedRoombytime') }}" method="get">
                                <h4>Lọc theo</h4>
                                <div class="filter">
                                    <div class="filter-m">
                                        <label for="filter_m">Tháng</label>
                                        <select name="filter_m" id="filter_m">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                    <div class="filter-y">
                                        <label for="filter_y">Năm</label>
                                        <select name="filter_y" id="filter_y">
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    @endif
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td><b>Tiêu Đề</b></td>
                                <td>{{ $data->title }}</td>
                            </tr>
                            <tr>
                                <td><b>Mô Tả</b></td>
                                <td>{{ $data->description }}</td>
                            </tr>
                            <tr>
                                <td><b>Địa Chỉ</b></td>
                                <td>{{ $data->address }}</td>
                            </tr>
                            <tr>
                                <td><b>Quận/Huyện</b></td>
                                <td>{{ \App\District::findOrFail($data->district_id)->name }}</td>
                            </tr>
                            <tr>
                                <td><b>Tỉnh/Thành Phố</b></td>
                                <td>{{ \App\City::findOrFail($data->city_id)->name }}</td>
                            </tr>
                            <tr>
                                <td><b>Số Lượng Phòng</b></td>
                                <td>{{ $data->quantity }}</td>
                            </tr>
                            <tr>
                                <td><b>Giá Phòng (VNĐ) </b></td>
                                <td>{{  number_format($data->price,0,",",".") }}</td>
                            </tr>
                            <tr>
                                <td><b>Hình ảnh tiêu đề:</b></td>
                                <td><img src="{{ $data->image }}" width="250"></td>
                            </tr>
                            <tr>
                                <td><b>Ghi Chú</b></td>
                                <td>{{ $data->note }}</td>
                            </tr>
                            <tr>
                                <td><b>Số Lượng Phòng</b></td>
                                <td>{{ $data->quantity }}</td>
                            </tr>
                            <tr>
                                <td><b>Ở Chung Chủ </b></td>
                                <td>{{ ($data->live_with_owner==1) ? 'Có' : 'Không' }}</td>
                            </tr>


                            <tr>
                                <td><b> Giá Điện / kWh </b></td>
                                <td>{{ $data->electric_price}} VNĐ</td>
                            </tr>
                            <tr>
                                <td><b> Giá Nước / m3 </b></td>
                                <td>{{ $data->water_price}} VNĐ</td>
                            </tr>
                            <tr>
                                <td><b> Người đăng </b></td>
                                <td>{{ \App\User::findOrFail($data->user_id)->name  }} </td>
                            </tr>
                            <tr>
                                <td><b> Ngày Phê Duyệt </b></td>
                                @if($data->approval_date != null)
                                    <td>{{ $data->approval_date }}</td>
                                @else
                                    <td>Chưa được phê duyệt</td>
                                @endif
                            </tr>
                            <tr>
                                <td><b> Ngày Hết Hạn </b></td>
                                @if($data->expired_date != null)
                                    <td>{{ $data->expired_date }}</td>
                                @else
                                    <td>Chưa được phê duyệt</td>
                                @endif
                            </tr>
                            <tr>
                                <td><b> Người Phê Duyệt </b></td>
                                @if($data->approval_id != null )
                                    <td>{{ \App\User::findOrFail($data->approval_id)->name }}</td>
                                @else
                                    <td>Chưa được phê duyệt</td>
                                @endif
                            </tr>
                            <tr>
                                <td><b> Tiện Ích </b></td>
                                <td>
                                    @foreach($facilities as $facility)
                                    {{$facility->title . ' | '}}
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @if($data->approval_id == null || $data->approval_date == null)
                        <div class="box-footer">
                            <a href="{{ route('admin.approveRoom', ['id' => $data->id]) }}" class="btn btn-primary">Duyệt bài đăng</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td><b>Lượt xem</b></td>
                            <td>{{ $data->views }}</td>
                        </tr>
                        <tr>
                            <td><b>Lượt yêu thích</b></td>
                            <td>{{ $room_likes }}</td>
                        </tr>
                        <tr>
                            <td><b>Vote</b></td>
                            @if($star_voted == 0)
                                <td>Chưa được đánh giá.</td>
                            @else
                                <td>{{ $star_voted }} sao</td>
                            @endif
                        </tr>
                        </tbody>
                    </table>
                    <h3>Ảnh chi tiết phòng trọ</h3>
                    @foreach($room_detailImages as $item)
                        <div class="listImg">
                            <div class="Pad-img">
                            <img src="{{ asset($item->image) }}">
                            </div>
                        </div>
                    @endforeach
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
