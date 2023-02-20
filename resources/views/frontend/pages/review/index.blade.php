@extends('frontend.layouts.main-profile')
@section('title',"Danh sach bài viết")
@section('css')
@endsection
@section('content')
<style>
	.table td, .table th {
		text-align: left;
		padding: 5px 10px;
	}
	.table thead th {
		text-align: left;
		padding: 10px 5px;
		text-transform: uppercase;
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
		font-size: 12px;
		background: #28a745;
		text-align: center;
		border: none;
	}
</style>
<div class="content-wrapper lb_template_list_post">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if(session("alert"))
                <div class="alert alert-success">
                    {{session("alert")}}
                </div>
                @elseif(session('error'))
                <div class="alert alert-warning">
                    {{session("error")}}
                </div>
                @endif

                <div class="d-flex justify-content-between ">
                    <a href="{{route('profile.createReview')}}" class="btn  btn-info btn-md mb-2">+ Đăng review</a>
                </div>

                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="card-tools w-100 mb-3">
                            <form action="{{ route('profile.listReview') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="form-group col-md-6 mb-0">
                                                <input id="keyword" value="{{ $keyword }}" name="keyword" type="text" class="form-control" placeholder="Tìm kiếm review">
                                                <div id="keyword_feedback" class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                <select id="order" name="order_with" class="form-control">
                                                    <option value="">-- Sắp xếp theo --</option>
                                                    <option value="dateASC" {{ $order_with=='dateASC'? 'selected':'' }}>Ngày tạo tăng dần</option>
                                                    <option value="dateDESC" {{ $order_with=='dateDESC'? 'selected':'' }}>Ngày tạo giảm dần</option>
                                                    {{-- <option value="viewASC" {{ $order_with=='viewASC'? 'selected':'' }}>Lượt xem tăng dần</option>
                                                    <option value="viewDESC" {{ $order_with=='viewDESC'? 'selected':'' }}>Lượt xem giảm dần</option> --}}
                                                    {{-- <option value="priceASC" {{ $order_with=='priceASC'? 'selected':'' }}>Giá tăng dần</option>
                                                    <option value="priceDESC" {{ $order_with=='priceDESC'? 'selected':'' }}>Giá giảm dần</option> --}}
                                                    {{-- <option value="payASC" {{ $order_with=='payASC'? 'selected':'' }}>Số lượt mua tăng dần</option>
                                                    <option value="payDESC" {{ $order_with=='payDESC'? 'selected':'' }}>Số lượt mua giảm dần</option> --}}
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                <select id="" name="fill_action" class="form-control">
                                                    <option value="">-- Lọc --</option>
                                                    <option value="active" {{ $fill_action=='active'? 'selected':'' }}>Review đã duyệt</option>
                                                    <option value="no_active" {{ $fill_action=='no_active'? 'selected':'' }}>Review đang chờ duyệt</option>
                                                </select>
                                            </div>
                                            {{-- <div class="form-group col-md-3 mb-0" style="min-width:100px; display: none">
                                                <select id="categoryProduct" name="category" class="form-control">
                                                    <option value="">-- Tất cả danh mục --</option>
                                                    {!!$option!!}
                                                </select>
                                            </div> --}}
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-0">
                                        <button type="submit" class="btn btn-success w-40"> Tìm kiếm </button>
                                        <a href="{{ route('profile.listReview') }}" class="btn btn-danger">Làm mới</a>
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
                                    <th>STT</th>
                                    <th >Tiêu đề review</th>
                                    <th class="white-space-nowrap">Ảnh</th>
                                    <th class="white-space-nowrap">Trạng thái</th>
                                    <th class="white-space-nowrap">Quà</th>
                                    <th style="width:150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $reviewItem)
                                <tr>
                                    <td style="text-align: center; font-weight:600;">{{$loop->index}}</td>
                                    <td>{{$reviewItem->name}}</td>
                                    <td><img src="{{asset($reviewItem->avatar_path)}}" alt="{{$reviewItem->name}}" style="width:80px;"></td>
                                    <td class="wrap-load-active">
                                        @if ($reviewItem->active==1)
                                            <span class="badge badge-success">Đã duyệt</span>
                                        @else
                                          <span class="badge badge-danger">Đang đợi duyệt</span>
                                        @endif
                                     </td>
                                     <td>

                                        @if ($reviewItem->status===0||$reviewItem->status==3)
                                        @php
                                            $type=optional($reviewItem->points()->first())->type;

                                        @endphp
                                        @if ($type)
                                        {{  config('point.typePoint')[$type]['point'] }} <small>điểm</small>
                                        @endif
                                        @elseif($reviewItem->status===1)
                                            Nhận sách (đang đợi nhận)
                                        @elseif($reviewItem->status===2)
                                            Nhận sách (đã nhận)
                                        @endif
                                     </td>
                                    <td>
                                        {{-- <a href="{{route('profile.editProduct',['id'=>$reviewItem->id])}}" class="btn btn-sm btn-info">Sửa</a> --}}
                                        <a data-url="{{route('profile.destroyReview',['id'=>$reviewItem->id])}}" class="btn btn-sm btn-danger lb_delete">Xoá</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                {{$data->appends(request()->input())->links()}}
            </div>
        </div>
      </div>
    </div>


</div>

@endsection

@section('js')
<script src="{{asset('lib/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
{{-- <script src="{{asset('lib/tinymce5/js/tinymce.min.js')}}"></script> --}}
<script src="https://cdn.tiny.cloud/1/si5evst7s8i3p2grgfh7i5gdsk2l26daazgefvli0hmzapgn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
{{-- <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script> --}}
<script src="{{asset('lib/select2/js/select2.min.js')}}"></script>
<script src="{{asset('admin_asset/ajax/deleteAdminAjax.js')}}"></script>
<script src="{{asset('admin_asset/js/function.js')}}"></script>
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
