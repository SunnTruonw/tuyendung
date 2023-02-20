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
                        {{-- <li  class="col-sm-12 col-md-6">
                            <strong>Sở thích</strong>   {{ $user->info_more?$user->info_more:"Chưa cập nhập" }}
                        </li>
                        <li  class="col-sm-12 col-md-6">
                            <strong>Bạn muốn trở thành</strong>   {{ $user->you_become?$user->you_become:"Chưa cập nhập" }}
                        </li>
                        <li class="col-sm-12 col-md-6"> <strong>Ngày sinh </strong>    {{$user->date_birth? $user->date_birth:"Chưa cập nhập" }}   </li>
                        @if ($user->type==1)
                        <li  class="col-sm-12 col-md-6">
                            <strong>Địa chỉ</strong>
                            @if ($user->city_id&& $user->district_id && $user->commune_id)
                            {{ optional($user->district)->name }} , {{ optional($user->city)->name }}
                            @endif
                        </li>
                        @endif --}}

                        {{-- <li class="col-sm-12 col-md-6"> <strong>Tình trạng </strong>    {{ $user->active==1?'Hiện':'Ẩn' }} </li> --}}
                        {{-- <li class="col-sm-12 col-md-6"> <strong>Người giới thiệu </strong>     {{ $user->parent_id?$user->parent->name:"Không có" }} </li> --}}

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
                            <span class="info-box-icon bg-danger"><i class="far fa-newspaper"></i></span>
                            <div class="info-box-content">
                            <span class="info-box-text">Tổng số sản phẩm</span>
                            <span class="info-box-number">{{ $countProduct }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="alert alert-success">
                    Sản phẩm thành viên đã thêm
                </div>
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="card-tools w-100 mb-3">
                            <form action="{{ route('admin.user_frontend.detail',['id'=>$user->id]) }}" method="GET">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="form-group col-md-6 mb-0">
                                                <input id="keyword" value="{{ $keyword }}" name="keyword"
                                                    type="text" class="form-control"
                                                    placeholder="Nhập số khung, biển kiểm soát,rollid">
                                                <div id="keyword_feedback" class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                <select id="order" name="order_with" class="form-control">
                                                    <option value="">-- Sắp xếp theo --</option>
                                                    <option value="dateASC"
                                                        {{ $order_with == 'dateASC' ? 'selected' : '' }}>Ngày mua
                                                        tăng
                                                        dần</option>
                                                    <option value="dateDESC"
                                                        {{ $order_with == 'dateDESC' ? 'selected' : '' }}>Ngày mua
                                                        giảm
                                                        dần</option>

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
                                                            <label for="">Ngày mua: bắt đầu</label>
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
                                                            <label for="">kết thúc:</label>
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

                    <div class="card-body table-responsive p-0 lb-list-category">
                        <table class="table table-head-fixed" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th>Thông tin</th>
                                    <th>Số khung</th>
                                    <th>Loại xe</th>
                                    <th>Biển kiểm soát</th>
                                    <th>Rollid</th>
                                    <th>Ngày mua</th>
                                    <th>Ngày hết bảo hành</th>

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
                                            {{-- <a href="{{ route('profile.editProduct', ['id' => $productItem->id]) }}"
                                                class="btn btn-sm btn-info">Sửa</a> --}}
                                            {{-- <form  action="{{ route('profile.updateToTop',['id'=>$productItem->id]) }}" method="POST" class="d-inline-block">
                                               @csrf
                                               <button class="btn btn-sm btn-success">Up top</button>
                                              </form> --}}
                                              <a href="{{ route('home.search', ['keyword' => $productItem->masp]) }}"
                                                class="btn btn-sm btn-primary" target="blank">Xem</a>
                                                @can('product-delete')
                                                <a data-url="{{ route('admin.product.destroy', ['id' => $productItem->id]) }}"
                                                    class="btn btn-sm btn-danger lb_delete">Xoá</a>
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
