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

                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="card-tools w-100 mb-3">
                            <form action="{{ route('admin.listReview') }}" method="GET">
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
                                        <a href="{{ route('admin.listReview') }}" class="btn btn-danger">Làm mới</a>
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
                                    <th class="white-space-nowrap">Thành viên viết</th>


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
                                     <td>
                                         <a href="{{ route('admin.user_frontend.detail',['id'=>$reviewItem->user_id]) }}">{{ optional($reviewItem->user)->username }}</a>
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
