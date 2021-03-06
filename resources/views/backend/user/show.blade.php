@extends('backend.layouts.main')
@section('content')
    <section class="content-header">
        <h1>
            Thông tin user <a href="{{route('admin.user.index')}}" class="btn btn-success pull-right"><i class="fa fa-list"></i> Danh sách user</a>
        </h1>
    </section>
    @if (session('msg'))
        <div class="pad margin no-print">
            <div class="alert alert-success alert-dismissible" style="" id="thongbao">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Thông báo !</h4>
                {{ session('msg') }}
            </div>
        </div>
    @endif
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <div class="box box-primary">
                    <!-- form start -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td><b>Tên :</b></td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td><b>Ngày sinh :</b></td>
                                <td>{{ $user->birthday }}</td>
                            </tr>
                            <tr>
                                <td><b>Căn cước công dân :</b></td>
                                <td>{{ $user->CMND }}</td>
                            </tr>
                            <tr>
                                @if($user->approval_id != null )
                                    <td><b>Người duyệt :</b></td>
                                    <td>{{ \App\User::findOrFail($user->approval_id)->name }}</td>
                                @else
                                    <td><b>Người duyệt :</b></td>
                                    <td>Tài khoản chưa được duyệt</td>
                                @endif
                            </tr>
                            <tr>
                                @if($user->date_approval != null )
                                    <td><b>Ngày được duyệt :</b></td>
                                    <td>{{ $user->date_approval }}</td>
                                @else
                                    <td><b>Ngày duyệt :</b></td>
                                    <td>Tài khoản chưa được duyệt</td>
                                @endif
                            </tr>
                            <tr>
                                <td><b>Email :</b></td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td><b>Địa chỉ :</b></td>
                                <td>{{ $user->address }}</td>
                            </tr>
                            <tr>
                                <td><b>Số điện thoại :</b></td>
                                <td>{{ ($user->phone != null) ? $user->phone : 'Không có' }}</td>
                            </tr>
                            <tr>
                                <td><b>Hình ảnh:</b></td>
                                <td><img src="{{ asset($user->image) }}" width="250" alt="Chưa có hình ảnh"></td>
                            </tr>
                            <tr>
                                <td><b>Chức vụ</b></td>
                                <td><?php if($user->role_id == 1) {echo "Admin";} else if ($user->role_id == 2) {echo "Owner";} else {echo "Customer";} ?></td>
                            </tr>
                            <tr>
                                <td><b>Trạng thái</b></td>
                                <td>{{ ($user->is_active == 1) ? 'Hiển thị' : 'Ẩn'  }}</td>
                            </tr>

                            </tbody></table>
                        @if($user->role_id == 2 && ($user->approval_id == null || $user->date_approval == null))
                            <div class="box-footer">
                                <a href="{{ route('admin.approveOwnerAccount', ['owner_id' => $user->id]) }}" class="btn btn-primary">Duyệt</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- /.box -->


            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </section>
@endsection
