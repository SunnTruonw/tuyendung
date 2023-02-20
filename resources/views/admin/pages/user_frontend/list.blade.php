@extends('admin.layouts.main')
@section('title', 'danh sach nhân viên')

@section('css')
    <link rel="stylesheet" href="{{ asset('lib/sweetalert2/css/sweetalert2.min.css') }}">
@endsection
@section('content')
    <div class="content-wrapper">

        @include('admin.partials.content-header',['name'=>" Admin User","key"=>"Danh sách thành viên"])

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('alert'))
                            <div class="alert alert-success">
                                {{ session('alert') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-warning">
                                {{ session('error') }}
                            </div>
                        @endif
                        {{-- <a href="{{ route('admin.user_frontend.create') }}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a> --}}
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <div class="card-tools w-100 mb-3">
                                    <form action="{{ route('admin.user_frontend.index') }}" method="GET">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="form-group col-md-2 mb-0">
                                                        <input id="keyword" value="{{ $keyword }}" name="keyword"
                                                            type="text" class="form-control" placeholder="Từ khóa">
                                                        <div id="keyword_feedback" class="invalid-feedback">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-2 mb-0" style="min-width:100px;">
                                                        <select id="order" name="order_with" class="form-control">
                                                            <option value="">-- Sắp xếp theo --</option>
                                                            <option value="dateASC"
                                                                {{ $order_with == 'dateASC' ? 'selected' : '' }}>Ngày tạo tăng
                                                                dần</option>
                                                            <option value="dateDESC"
                                                                {{ $order_with == 'dateDESC' ? 'selected' : '' }}>Ngày tạo giảm
                                                                dần</option>
                                                            <option value="usernameASC"
                                                                {{ $order_with == 'usernameASC' ? 'selected' : '' }}>Username
                                                                A-> Z</option>
                                                            <option value="usernameDESC"
                                                                {{ $order_with == 'usernameDESC' ? 'selected' : '' }}>Username
                                                                Z -> A</option>
                                                            <option value="activeDESC"
                                                                {{ $order_with == 'activeDESC' ? 'selected' : '' }}>Trạng thái
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2 mb-0" style="min-width:100px;">
                                                        <select id="" name="fill_action" class="form-control">
                                                            <option value="">-- Lọc --</option>
                                                            <option value="userNoActive"
                                                                {{ $fill_action == 'userNoActive' ? 'selected' : '' }}>Thành
                                                                viên chưa kích hoạt</option>
                                                            <option value="userActive"
                                                                {{ $fill_action == 'userActive' ? 'selected' : '' }}>Thành
                                                                viên đã kích hoạt</option>
                                                            <option value="userActiveKey"
                                                                {{ $fill_action == 'userActiveKey' ? 'selected' : '' }}>Thành
                                                                viên bị khóa</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-success">Search</button>
                                                <a class="btn btn-danger"
                                                    href="{{ route('admin.user_frontend.index') }}">Reset</a>
                                                {{-- <button type="submit" target="blank" name="btnExcel" class="btn btn-success"
                                                    value="1">Xuất excel</button> --}}
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- <div class="card-tools text-right pl-3 pr-3 pt-2 pb-2">
                                <div class="count">
                                    Tổng số bản ghi <strong>{{ $data->count() }}</strong> / {{ $totalUser }}
                                </div>
                            </div> --}}

                            <div class="card-body table-responsive p-0 lb-list-category">
                                <table class="table table-head-fixed" style="font-size:13px;">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tài khoản</th>
                                            <th>Họ và tên</th>
                                            <th>Số điện thoại</th>
                                            {{-- <th>Email</th> --}}
                                            {{-- <th>Nhu Cầu</th>
                                            <th>Tỉnh thành phố</th>
                                            <th>Quận huyện</th> --}}
                                            {{-- <th>Tài chính</th> --}}
                                            {{-- <th>Admin xử lý</th> --}}
                                            <th>Trạng thái</th>
                                            <th>Hoạt động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->username }}</td>
                                                <td>
                                                    <a
                                                        href="{{ route('admin.user_frontend.detail', ['id' => $item->id]) }}">{{ $item->name }}</a>
                                                </td>

                                                <td>{{ $item->phone }}</td>
                                                {{-- <td>{{$item->email}}</td> --}}
                                                {{-- <td>
                                                    @php
                                                        if ($item->type == 4) {
                                                            $type = 'Nhân viên công ty';
                                                        } elseif ($item->type == 1 || $item->type == 2 || $item->type == 3) {
                                                            $type = config('web_default.typeUser')[$item->type]['name'];
                                                        } else {
                                                            $type = 'Chưa cập nhập';
                                                        }
                                                    @endphp
                                                    {{ $type }}
                                                </td>
                                                <td>
                                                    @if ($item->type == 1)
                                                        {{ optional($item->city)->name }}
                                                    @endif
                                                </td> --}}
                                                {{-- <td>
                                                    @if ($item->type == 1)
                                                        {{ optional($item->district)->name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->type == 1)
                                                        {{ $item->tai_chinh ? $item->tai_chinh : 'Chưa cập nhập' }}
                                                    @endif
                                                </td> --}}
                                                {{-- <td>{{ optional($item->admin)->name }}</td> --}}
                                                <td class="wrap-load-active" data-url="{{ route('admin.user_frontend.load.active',['id'=>$item->id]) }}">
                                                    @include('admin.components.load-change-active-user',['data'=>$item,'type'=>'user'])
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-info btn-load-transaction-detail"
                                                        data-url="{{ route('admin.user_frontend.loadUserDetail', ['id' => $item->id]) }}"><i
                                                            class="fas fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success"
                                                        href="{{ route('admin.user_frontend.edit', ['id' => $item->id]) }}"><i
                                                            class="fas fa-edit"></i></a>

                                                    @if ($item->active)
                                                        <a class="btn btn-sm btn-danger {{ $item->active == 2 ? 'key' : '' }}"
                                                            id="btnKeyUser"
                                                            data-url="{{ route('admin.user_frontend.load.active-key', ['id' => $item->id]) }}">
                                                            {{ $item->active == 1 ? 'Khóa user' : 'Mở khóa' }}</a>
                                                    @endif
                                                    {{-- <a href="{{route('admin.user.edit',['id'=>$item->id])}}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a> --}}
                                                    <a data-url="{{ route('admin.user_frontend.destroy', ['id' => $item->id]) }}"
                                                        class="btn btn-sm btn-danger lb_delete"><i
                                                            class="far fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="transactionDetail">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thông tin chi tiết thành viên</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="content" id="loadTransactionDetail">

                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    {{-- <script src="{{asset('')}}"></script> --}}
    <script src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin_asset/ajax/deleteAdminAjax.js') }}"></script>
    <script>
        $(function() {

            $(document).on('change', '.city_s2', function() {
                let urlRequest = $(this).data("url");
                let mythis = $(this);
                let value = $(this).val();
                let defaultCity = "<option value=''>Chọn tỉnh/thành phố</option>";
                let defaultDistrict = "<option value=''>Chọn quận/huyện</option>";
                let defaultCommune = "<option value=''>Chọn xã/phường/thị trấn</option>";
                if (!value) {
                    mythis.parents('form').find('.district_s2').html(defaultDistrict);
                    mythis.parents('form').find('.commune_s2').html(defaultCommune);
                } else {
                    $.ajax({
                        type: "GET",
                        url: urlRequest,
                        data: {
                            'cityId': value
                        },
                        success: function(data) {
                            if (data.code == 200) {
                                let html = defaultDistrict + data.data;
                                mythis.parents('form').find('.district_s2').html(html);
                                mythis.parents('form').find('.commune_s2').html(defaultCommune);
                            }
                        }
                    });
                }
            })
            $(document).on('change', '.district_s2', function() {
                let urlRequest = $(this).data("url");
                let mythis = $(this);
                let value = $(this).val();
                let defaultCity = "<option value=''>Chọn tỉnh/thành phố</option>";
                let defaultDistrict = "<option value=''>Chọn quận/huyện</option>";
                let defaultCommune = "<option value=''>Chọn xã/phường/thị trấn</option>";
                if (!value) {
                    mythis.parents('form').find('.commune_s2').html(defaultCommune);
                } else {
                    $.ajax({
                        type: "GET",
                        url: urlRequest,
                        data: {
                            'districtId': value
                        },
                        success: function(data) {
                            if (data.code == 200) {
                                let html = defaultCommune + data.data;
                                mythis.parents('form').find('.commune_s2').html(html);
                            }
                        }
                    });
                }
            });




            $(document).on('click', '#btnTranferPoint', function() {
                event.preventDefault();
                let urlRequest = $(this).data("url");
                let title = '';
                title = 'Bạn có chắc chắn muốn bắn điểm';
                $this = $(this);
                Swal.fire({
                    title: title,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, next step!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: urlRequest,
                            success: function(data) {
                                if (data.code == 200) {
                                    $this.text('Đã bắn');
                                    $this.removeClass('btn-danger').addClass(
                                    'btn-info');
                                } else {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'warning',
                                        title: 'Bắn điểm không thành công',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            }
                        });
                    }
                });
            });

            $(document).on('click', '#btnKeyUser', function() {
                event.preventDefault();
                let urlRequest = $(this).data("url");
                let title = '';

                let $this = $(this);
                if ($this.hasClass('key')) {
                    title = 'Bạn có chắc chắn muốn mở khóa thành viên';
                } else {
                    title = 'Bạn có chắc chắn muốn khóa thành viên';

                }

                let loadActive = $(this).parents('tr').find('.wrap-load-active');
                Swal.fire({
                    title: title,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, next step!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: urlRequest,
                            success: function(data) {
                                if (data.code == 200) {
                                    loadActive.html(data.html);

                                    if ($this.hasClass('key')) {
                                        $this.removeClass('key');
                                        $this.text('Khóa user');
                                    } else {
                                        $this.addClass('key');
                                        $this.text('Mở khóa');
                                    }
                                } else {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'warning',
                                        title: data.title,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            },
                            error: function(data) {

                                Swal.fire({
                                    position: 'center',
                                    icon: 'warning',
                                    title: "Khóa không thành công",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

@endsection
