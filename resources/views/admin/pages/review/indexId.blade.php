@extends('admin.layouts.main')
@section('title',"danh sach review")

@section('css')
<link rel="stylesheet" href="{{asset('lib/sweetalert2/css/sweetalert2.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>"Review","key"=>"Danh sách review"])

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="list-info-user mb-5">
                    <ul class="row">
                        <li class="col-sm-12">
                            <div class="avatar text-center p-3">
                                <img src="{{ $user->avatar_path?$user->avatar_path: $shareFrontend['userNoImage'] }}" alt="{{ $user->name }}" class="mb-3 rounded-circle" style="width:60px;">
                            </div>
                            <div class="text-center mb-4">
                                <strong>Loại tài khoản</strong>
                                    <button class="btn btn-success">
                                        @if ($user->provider)
                                        Đăng ký bằng {{ $user->provider }}
                                        @else
                                        Đăng ký trên website
                                        @endif
                                    </button>
                            </div>
                        </li>

                        <li  class="col-sm-12 col-md-6">
                            <strong>Họ tên</strong>   {{ $user->name?$user->name:"Chưa cập nhập" }}
                        </li>
                        <li  class="col-sm-12 col-md-6">
                            <strong>Email</strong>   {{ $user->email?$user->email:"Chưa cập nhập" }}
                        </li>
                        <li class="col-sm-12 col-md-6">
                            <strong>Tài khoản</strong>    {{ $user->username?$user->username:"Chưa cập nhập" }}
                        </li>
                        <li  class="col-sm-12 col-md-6">
                            <strong>Phone</strong>   {{ $user->phone?$user->phone:"Chưa cập nhập" }}
                        </li>

                        @if ($user->type==1)
                        <li  class="col-sm-12 col-md-6">
                            <strong>Địa chỉ</strong>
                            @if ($user->city_id&& $user->district_id && $user->commune_id)
                            {{-- {{ $user->address_detail?$user->address_detail:"" }} ,   {{ optional($user->commune)->name }} ,  --}}
                            {{ optional($user->district)->name }} , {{ optional($user->city)->name }}
                            @endif
                        </li>
                        <li  class="col-sm-12 col-md-6">
                            <strong>Tài chính</strong>   {{ $user->tai_chinh?$user->tai_chinh:"Chưa cập nhập" }}
                        </li>
                        @endif

                        {{-- <li class="col-sm-12 col-md-6"> <strong>Tình trạng </strong>    {{ $user->active==1?'Hiện':'Ẩn' }} </li> --}}
                        {{-- <li class="col-sm-12 col-md-6"> <strong>Người giới thiệu </strong>     {{ $user->parent_id?$user->parent->name:"Không có" }} </li> --}}
                        {{-- <li class="col-sm-12 col-md-6"> <strong>Ngày sinh </strong>    {{$user->date_birth? $user->date_birth:"Chưa cập nhập" }}   </li> --}}
                        {{-- <li class="col-sm-12 col-md-6"> <strong>HKTT </strong>     {{ $user->hktt?$user->hktt:"Chưa cập nhập" }} </li>
                        <li class="col-sm-12 col-md-6"> <strong>CMT </strong>     {{ $user->cmt?$user->cmt:"Chưa cập nhập" }} </li>
                        <li class="col-sm-12 col-md-6"> <strong>STK </strong>     {{ $user->stk?$user->stk:"Chưa cập nhập" }} </li>
                        <li class="col-sm-12 col-md-6"> <strong>CTK </strong>     {{ $user->ctk?$user->ctk:"Chưa cập nhập" }} </li>
                        <li class="col-sm-12 col-md-6"> <strong>Ngân hàng </strong>     {{ $user->bank?$user->bank->name:"Chưa cập nhập" }} </li>
                        <li class="col-sm-12 col-md-6"> <strong>Chi nhánh ngân hàng </strong>     {{ $user->bank_branch?$user->bank_branch:"Chưa cập nhập" }} </li> --}}
                        {{-- <li class="col-sm-12 col-md-6"> <strong>Giới tính </strong>     {{ $user->sex==1?"Nam":($user->sex==0?"Nữ":"Chưa  cập nhập") }} </li> --}}
                        <li class="col-sm-12 col-md-6"> <strong>Ngày tạo tài khoản </strong>     {{ $user->created_at }} </li>
                        <li class="col-sm-12 col-md-6"> <strong>Admin xử lý </strong>     {{ optional($user->admin)->name }} </li>
                    </ul>
                    <div class="text-right">
                        {{-- <a href="{{ route('admin.user_frontend.history',['id'=>$user->id]) }}" class="btn btn-success">Xem lịch sử sử dụng tiền</a> --}}
                        <a href="{{ route('admin.listReviewId',['id'=>$user->id]) }}" class="btn btn-primary">Danh sách review</a>
                        @if ($user->type==4)
                        <a href="{{ route('admin.user_frontend.countBuy',['id'=>$user->id]) }}" class="btn btn-primary">Lọc số lượt mua theo ngày</a>
                        @endif
                        <a href="{{ route('admin.user_frontend.detail',['id'=>$user->id]) }}" class="btn btn-danger">Sản phẩm đã thêm</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê chung</h3>
                        </div>
                    </div>
                    @php
                        $pointM=new App\Models\Point();
                        $countPoint=$pointM->select(App\Models\Point::raw('SUM(point) as total'))->where('user_id',$user->id)->first()->total;
                        $productM=new App\Models\Product();
                        $countProduct=$productM->select(App\Models\Product::raw('COUNT(id) as total'))->where('user_id',$user->id)->first()->total;
                    @endphp
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-newspaper"></i></span>
                            <div class="info-box-content">
                            <span class="info-box-text">Tổng số điểm</span>
                            <span class="info-box-number">{{ $countPoint }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="far fa-newspaper"></i></span>
                            <div class="info-box-content">
                            <span class="info-box-text">Tổng số sản phẩm</span>
                            <span class="info-box-number">{{ $countProduct }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

                {{-- <div class="d-flex justify-content-between ">
                    <a href="{{route('profile.createReview')}}" class="btn  btn-info btn-md mb-2">+ Đăng review</a>
                </div> --}}
                <div class="alert alert-success">
                    Danh sách review của thành viên
                </div>
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="card-tools w-100 mb-3">
                            <form action="{{ route('admin.listReviewId',['id'=>$user->id]) }}" method="GET">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="form-group col-md-3 mb-0">
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
                                            <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                <select id="" name="status" class="form-control">
                                                    <option value="">-- Loại quà --</option>
                                                    <option value="status" {{ $status=='status'? 'selected':'' }}>Nhận sách</option>
                                                    <option value="no_status" {{ $status=='no_status'? 'selected':'' }}>Nhận điểm</option>
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
                                        <a href="{{ route('admin.listReviewId',['id'=>$user->id]) }}" class="btn btn-danger">Làm mới</a>
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
                                    {{-- <th class="white-space-nowrap">Thành viên viết</th> --}}
                                    <th class="white-space-nowrap">Quà</th>
                                    <th class="white-space-nowrap">Tình trạng quà</th>

                                    <th style="width:170px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $reviewItem)
                                <tr>
                                    <td style="text-align: center; font-weight:600;">{{$loop->index}}</td>
                                    <td>{{$reviewItem->name}}</td>
                                    <td><img src="{{asset($reviewItem->avatar_path)}}" alt="{{$reviewItem->name}}" style="width:80px;"></td>
                                    <td class="wrap-load-active" data-url="{{ route('admin.loadActiveReview',['id'=>$reviewItem->id]) }}">
                                        @if ($reviewItem->active)
                                        <span class="badge badge-success">Đã duyệt</span>
                                        @else
                                          @can('review-duyet')
                                          @include('admin.components.load-change-review-active',['data'=>$reviewItem,'type'=>'Review'])
                                          @endcan
                                        @endif

                                     </td>
                                     {{-- <td>
                                         <a href="{{ route('admin.user_frontend.detail',['id'=>$reviewItem->user_id]) }}">{{ optional($reviewItem->user)->username }}</a>
                                     </td> --}}
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
                                        @if ($reviewItem->status==1||$reviewItem->status==2)
                                        <ul>
                                            <li><strong>Tên người nhận: </strong> <span>{{ $reviewItem->name_nhan }}</span></li>
                                            <li><strong>SĐT người nhận: </strong> <span>{{ $reviewItem->phone_nhan }}</span></li>
                                            <li><strong>Địa chỉ người nhận: </strong> <span>{{ $reviewItem->address_nhan }}</span></li>
                                            @if ($reviewItem->info_nhan)
                                               <li><strong>Thông tin thêm: </strong> <span>{{ $reviewItem->info_nhan }}</span></li>
                                            @endif
                                        </ul>
                                        @endif
                                     </td>
                                     <td class="wrap-load-active" data-url="{{ route('admin.loadStatusReview',['id'=>$reviewItem->id]) }}">
                                        @include('admin.components.load-change-review-status',['data'=>$reviewItem,'type'=>'Review'])
                                     </td>
                                    <td>
                                        @can('review-duyet')
                                        <a href="{{ route('admin.review.preview',['id'=>$reviewItem->id]) }}" class="btn btn-sm btn-primary" target="_blank">Xem trước</a>
                                        @endcan
                                        @can('review-delete')
                                        {{-- <a href="{{route('profile.editProduct',['id'=>$reviewItem->id])}}" class="btn btn-sm btn-info">Sửa</a> --}}
                                        <a data-url="{{route('admin.destroyReview',['id'=>$reviewItem->id])}}" class="btn btn-sm btn-danger lb_delete">Xoá</a>
                                        @endcan
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
{{-- <script src="{{asset('')}}"></script> --}}
<script src="{{asset('lib/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('admin_asset/ajax/deleteAdminAjax.js')}}"></script>
@endsection
