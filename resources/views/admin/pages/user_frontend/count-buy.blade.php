@extends('admin.layouts.main')
@section('title',"Edit user")
@section('css')
<link href="{{asset('lib/select2/css/select2.min.css')}}" rel="stylesheet" />
<style>
   .select2-container--default .select2-selection--multiple .select2-selection__choice{
   background-color: #000 !important;
   }
   .select2-container .select2-selection--single{
   height: auto;
   }
</style>
@endsection

@section('content')
<div class="content-wrapper">
   @include('admin.partials.content-header',['name'=>"Thành viên","key"=>"Thông tin thành viên"])
   <!-- Main content -->
   <div class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
                <div class="list-info-user mb-5">
                    <ul class="row">

                        <li class="col-sm-12">
                            <div class="avatar text-center p-3">
                                <img src="{{ $user->avatar_path?$user->avatar_path: $shareFrontend['userNoImage'] }}" alt="{{ $user->name }}" class="mb-3 rounded-circle" style="width:60px;">
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


                        <li  class="col-sm-12 col-md-6">
                            @php
                                if($user->type==4){
                                    $type='Nhân viên công ty';
                                }else if($user->type==1||$user->type==2||$user->type==3){
                                    $type=config('web_default.typeUser')[$user->type]['name'];
                                }else{
                                    $type='Chưa cập nhập';
                                }
                            @endphp
                            <strong>Nhu cầu</strong>    {{ $type }}
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
                        <a href="{{ route('admin.user_frontend.history',['id'=>$user->id]) }}" class="btn btn-success">Xem lịch sử sử dụng tiền</a>
                        <a href="{{ route('admin.user_frontend.detail',['id'=>$user->id]) }}" class="btn btn-success">Sản phẩm đã thêm</a>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="alert alert-success">
                    Thống kê click
                </div>
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="card-tools w-100 mb-3">
                            <form action="{{ route('admin.user_frontend.countBuy',['id'=>$user->id]) }}" method="GET">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="form-group d-flex align-items-center">
                                                <label for="" class="text-nowrap  mb-0">Ngày bắt đầu:</label>
                                                <input type="date" value="{{ $start }}" class="form-control" name="start">
                                              </div>
                                              <div class="form-group d-flex align-items-center ml-2">
                                                <label for="" class="text-nowrap mb-0">Ngày kết thúc:</label>
                                                <input type="date" value="{{ $end }}" class="form-control" name="end">
                                              </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1 mb-0">
                                        <button type="submit" class="btn btn-success w-100">Tìm</button>
                                    </div>
                                    <div class="col-md-1 mb-0">
                                        <a  class="btn btn-danger w-100" href="{{ route('admin.user_frontend.countBuy',['id'=>$user->id]) }}">Làm mới</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-tools text-right pl-3 pr-3 pt-2 pb-2">
                        <div class="count">
                            Tổng số lượt click
                            @if (isset($start)&&$start)
                                từ ngày {{ $start }}
                            @endif
                            @if (isset($end)&&$end)
                             đến  ngày {{ $end }}
                            @endif
                            <strong style="color: red;font-size:130%;">{{  $totalPoint }}</strong> lượt click
                         </div>
                      </div>
                    <div class="card-body table-responsive p-0 lb-list-category">
                        <table class="table table-head-fixed" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên dự án</th>
                                    <th>User click</th>
                                    <th>Thời gian click</th>
                                    <th>Số tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $point)
                                @php
                                    $productItem=$point->product;
                                    $userItem=$point->user;
                                @endphp
                                    {{-- {{dd($productItem->category)}} --}}
                                <tr>
                                    <td>{{$loop->index}}</td>
                                    <td>{{$productItem->name}}</td>
                                    <td>
                                        @if ($userItem)
                                        <a href="{{ route('admin.user_frontend.detail', ['id' => $userItem->id]) }}">{{ $userItem->name }}</a>
                                        @endif
                                    </td>
                                    <td>{{ $point->created_at }}</td>
                                    <td>
                                        {{ $point->point }}
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

{{-- <script>
   $(function(){
    $(document).on('click','.pagination a',function(){
        event.preventDefault();
        let href=$(this).attr('href');
        //alert(href);
        $.ajax({
            type: "Get",
            url: href,
           // data: "data",
            dataType: "JSON",
            success: function (response) {
                if(response.type=='rose-user_frontend'){
                    $('.wrap-rose-user-frontend').html(response.html);
                } else if(response.type=='user_frontend'){
                    $('.wrap-user-frontend').html(response.html);
                }
            }
        });
    });
   })
</script> --}}
@endsection
