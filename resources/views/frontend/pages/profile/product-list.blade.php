@extends('frontend.layouts.main-profile')
@section('title', 'Danh sach bài viết')
@section('css')
@endsection
@section('content')
    <style>
        .table td,
        .table th {
            text-align: left;
            padding: 5px 10px;
        }

        .table thead th {
            text-align: left;
            padding: 10px 5px;
            text-transform: none;
            font-size: 12px;
        }

        .btn-info {
            font-size: 12px;
            background: #e90000;
            border: none;
        }

        .btn-danger {
            font-size: 12px;
            background: #e90000;
            border: none;
        }

        .btn-success {
            font-size: 16px;
            background: #28a745;
            text-align: center;
            border: none;
        }

    </style>
    <div class="content-wrapper lb_template_list_post">
        <!-- Main content -->
        <div class="content">

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

                    <div class="d-flex justify-content-between ">
                        <a href="{{ route('profile.createProduct') }}" class="btn  btn-info btn-md mb-2">+ ĐĂNG MÃ BẢO HÀNH</a>
                    </div>

                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-tools w-100 mb-3">
                                <form action="{{ route('profile.listProduct') }}" method="GET">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-0">
                                                    <input id="keyword" value="{{ $keyword }}" name="keyword" type="text" class="form-control" placeholder="Nhập Biển số, Số khung, số Roll">
                                                    <div id="keyword_feedback" class="invalid-feedback"></div>
                                                </div>
                                                <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                    <select id="order" name="order_with" class="form-control">
                                                        <option value="">-- Sắp xếp theo --</option>
                                                        <option value="dateASC" {{ $order_with == 'dateASC' ? 'selected' : '' }}>Tăng dần</option>
                                                        <option value="dateDESC" {{ $order_with == 'dateDESC' ? 'selected' : '' }}>Giảm dần</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                    <select  name="city_id" class="form-control">
                                                        <option value="">-- Tỉnh thành phố --</option>
                                                        @foreach ($cities as $city)
                                                        <option value="{{ $city->id }}" {{ $city->id==request()->city_id?'selected':'' }} >{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-1">
                                                            <div class="form-group mb-0">
                                                                <label for="">Ngày bắt đầu</label>
                                                                <div class="d-inline-block mr-1">
                                                                    <input type="date"
                                                                        class="form-control @error('start') is-invalid  @enderror"
                                                                        placeholder="" id="" name="start"
                                                                        value="{{ $start }}">
                                                                    @error('start')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                                <label for="">Ngày Kết thúc:</label>
                                                                <div class="d-inline-block">

                                                                    <input type="date"
                                                                        class="form-control @error('end') is-invalid  @enderror"
                                                                        placeholder="" id="" name="end"
                                                                        value="{{ $end }}">
                                                                    @error('end')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>


                                                {{-- <div class="form-group col-md-3 mb-0" style="min-width:100px; display: none">
                                                <select id="" name="fill_action" class="form-control">
                                                    <option value="">-- Lọc --</option>
                                                    <option value="hot" {{ $fill_action=='hot'? 'selected':'' }}>Sản phẩm hot</option>
                                                    <option value="no_hot" {{ $fill_action=='no_hot'? 'selected':'' }}>Sản phẩm không hot</option>
                                                    <option value="active" {{ $fill_action=='active'? 'selected':'' }}>Sản phẩm hiển thị</option>
                                                    <option value="no_active" {{ $fill_action=='no_active'? 'selected':'' }}>Sản phẩm bị ẩn</option>
                                                </select>
                                            </div> --}}
                                                {{-- <div class="form-group col-md-3 mb-0" style="min-width:100px; display: none">
                                                <select id="categoryProduct" name="category" class="form-control">
                                                    <option value="">-- Tất cả danh mục --</option>
                                                    {!!$option!!}
                                                </select>
                                            </div> --}}
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-0 mt-2">
                                            <button type="submit" class="btn btn-success w-40"> Tìm kiếm </button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-tools text-right pl-3 pr-3 pt-2 pb-2">
                            <div class="count">
                                {{-- Tổng số bản ghi <strong>{{  $data->count() }}</strong> / {{ $totalProduct }} --}}
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0 lb-list-category">
                            <table class="table table-head-fixed" style="font-size: 13px;">
                                <thead>
                                    <tr>
                                        <th>Thông tin</th>
                                        <th>Số khung</th>
                                        <th>Loại xe</th>
                                        <th>BKS</th>
                                        <th>Rollid</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày hết hạn</th>
                                        <th>Thành phố</th>
                                        <th style="width:100px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $productItem)
                                        <tr>

                                            {{-- <td>{{$productItem->masp}}</td> --}}
                                            <td>
                                                <ul>
                                                    <li><strong>Họ tên</strong> {{ $productItem->name_chunha }}</li>
                                                    <li><strong>Điện thoại</strong> {{ $productItem->phone_chunha }}
                                                    </li>
                                                    <li><strong>Địa chỉ</strong> {{ $productItem->address_chunha }}
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>{{ $productItem->masp }}</td>
                                            <td>{{ $productItem->type_car }}</td>
                                            <td>{{ $productItem->bienkiemsoat }}</td>
                                            <td>{{ $productItem->rollid }}</td>
                                            <td>{{ Carbon::parse($productItem->time_buy)->format('d/m/Y') }}</td>
                                            <td>{{ Carbon::parse($productItem->time_expires)->format('d/m/Y') }}</td>

                                            {{-- <td class="text-nowrap"><strong>{{ number_format($productItem->price) }}</strong></td> --}}
                                            {{-- <td class="text-nowrap"  style="text-align: center; font-weight:600;">{{$productItem->view}}</td> --}}
                                            {{-- <td>{{$productItem->stores()->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total? $productItem->stores()->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total:0 }}</td>
                                            <td class="text-nowrap">
                                                {{$productItem->stores()->whereIn('type',[2,3])->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total? $productItem->stores()->whereIn('type',[2,3])->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total:0 }}
                                            </td> --}}
                                                    {{-- <td><img src="{{ asset($productItem->avatar_path) }}"
                                                                alt="{{ $productItem->name }}" style="width:80px;"></td>
                                                        <td class="wrap-load-active"
                                                            data-url="{{ route('profile.loadActiveProduct', ['id' => $productItem->id]) }}">
                                                            @include('admin.components.load-change-active',['data'=>$productItem,'type'=>'sản
                                                            phẩm'])
                                                        </td> --}}
                                                    {{-- <td class="wrap-load-hot" data-url="{{ route('profile.loadHotProduct',['id'=>$productItem->id]) }}">
                                                @include('admin.components.load-change-hot',['data'=>$productItem,'type'=>'sản phẩm'])
                                            </td> --}}
                                                    {{-- <td>{{optional($productItem->category)->name}}</td> --}}
                                                    {{-- <td>
                                                <ul>
                                                    <li>
                                                        <strong>Tên</strong> {{optional($productItem->admin)->name}} <br>
                                                        <strong>Email</strong> {{optional($productItem->admin)->email}}
                                                    </li>
                                                </ul>
                                            </td> --}}
                                            <td>{{ optional($productItem->city)->name }}</td>
                                            <td>
                                                <a href="{{ route('profile.editProduct', ['id' => $productItem->id]) }}"
                                                    class="btn btn-sm btn-info">Sửa</a>
                                                {{-- <form  action="{{ route('profile.updateToTop',['id'=>$productItem->id]) }}" method="POST" class="d-inline-block">
                                                   @csrf
                                                   <button class="btn btn-sm btn-success">Up top</button>
                                                  </form> --}}
                                                <a data-url="{{ route('profile.destroyProduct', ['id' => $productItem->id]) }}"
                                                    class="btn btn-sm btn-danger lb_delete">Xoá</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    {{ $data->appends(request()->input())->links() }}
                </div>
            </div>

        </div>


    </div>

@endsection

@section('js')
    <script src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
    {{-- <script src="{{asset('lib/tinymce5/js/tinymce.min.js')}}"></script> --}}
    <script src="https://cdn.tiny.cloud/1/si5evst7s8i3p2grgfh7i5gdsk2l26daazgefvli0hmzapgn/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    {{-- <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script> --}}
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin_asset/ajax/deleteAdminAjax.js') }}"></script>
    <script src="{{ asset('admin_asset/js/function.js') }}"></script>
    <script>
        // js load change tráº¡ng thĂ¡i hot vĂ  active
        $(document).on('click', '.lb-active', function() {
            event.preventDefault();
            let wrapActive = $(this).parents('.wrap-load-active');
            let urlRequest = wrapActive.data("url");
            let value = $(this).data("value");
            let type = $(this).data("type");
            let title = '';
            if (value) {
                title = 'Bạn có chắc chắn muốn ẩn ' + type;
            } else {
                title = 'Bạn có chắc chắn muốn hiện ' + type;
            }
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
                                let html = data.html;
                                wrapActive.html(html);
                            }
                        }
                    });
                }
            })
        });

        $(document).on('click', '.lb-hot', function() {
            event.preventDefault();
            let wrapActive = $(this).parents('.wrap-load-hot');
            let urlRequest = wrapActive.data("url");
            let value = $(this).data("value");
            let type = $(this).data("type");
            let title = '';
            if (value) {
                title = 'Bạn có chắc chắn muốn bỏ trạng thái nổi bật ' + type;
            } else {
                title = 'Bạn có chắc chắn muốn chuyển  ' + type + ' sang nổi bật';
            }
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
                                let html = data.html;
                                wrapActive.html(html);
                            }
                        }
                    });
                }
            })
        });

        // end  js load change tráº¡ng thĂ¡i hot vĂ  active
    </script>

@endsection
