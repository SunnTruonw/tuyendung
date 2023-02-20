@extends('admin.layouts.main')
@section('title',"Sửa bảo hành")

@section('css')
@endsection
@section('content')
<style>
    .child-attributes{
        margin: 10px;
    }
    .child-attributes .col-sm-6{
        margin-bottom: 5px;
    }
</style>
<div class="content-wrapper lb_template_product_edit">
    @include('admin.partials.content-header',['name'=>"Bảo hành","key"=>"Sửa bảo hành"])

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
                    <form class="form-horizontal" action="{{route('admin.product.update',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-header">
                                    @foreach ($errors->all() as $message)
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @endforeach
                                 </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-tool p-3 text-right">
                                    <button type="button" title="_addProduct"
                                            class="btn btn-last btnSeiviceArising"
                                            data-target="#_addProduct"
                                            data-text="url"
                                            data-action="{{route('admin.product.create')}}"
                                            data-url={{route('admin.product.loadProductService',['id'=>$data->id])}}
                                            style="background: #563d7c;color : #fff">
                                            <i class="fas fa-plus" ></i> Thêm dịch vụ phát sinh
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-lg">Chấp nhận</button>
                                    <button type="reset" class="btn btn-danger btn-lg">Làm lại</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                       <h3 class="card-title">Thông tin bảo hành</h3>
                                    </div>
                                    <div class="card-body table-responsive p-3">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                              <a class="nav-link active" data-toggle="tab" href="#tong_quan">Tổng quan</a>
                                            </li>
                                            <!-- <li class="nav-item">
                                              <a class="nav-link" data-toggle="tab" href="#du_lieu">Dữ liệu</a>
                                            </li> -->
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#hinh_anh">Hình ảnh</a>
                                            </li>
                                            {{-- <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#seo">Seo</a>
                                            </li> --}}
                                        </ul>

                                        <div class="tab-content">
                                            <!-- START Tổng Quan -->
                                            <div id="tong_quan" class="container tab-pane active"><br>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Họ và tên</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="name_chunha" value="{{old('name_chunha')?? $data->name_chunha }}" name="name_chunha" placeholder="Nhập họ tên">
                                                        </div>
                                                    </div>
                                                    @error('name_chunha')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                {{-- <div class="form-group">
                                                    <div class="row">
                                                         <label class="col-sm-2 control-label" for="">Slug</label>
                                                         <div class="col-sm-10">
                                                             <input type="text" class="form-control
                                                             @error('slug') is-invalid  @enderror" id="slug" value="{{ old('slug')??$data->slug }}" name="slug" placeholder="Nhập slug">
                                                         </div>
                                                     </div>
                                                     @error('slug')
                                                     <div class="invalid-feedback d-block">{{ $message }}</div>
                                                     @enderror
                                                </div> --}}

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Số
                                                            khung/Biển số</label>
                                                        <div class="col-sm-10">
                                                            <input type="text"
                                                                class="form-control
                                                        @error('masp') is-invalid @enderror"
                                                                id="masp" value="{{ old('masp') ?? $data->masp }}"
                                                                name="masp" placeholder="Nhập số khung">
                                                                @error('masp')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Điện
                                                            thoại</label>
                                                        <div class="col-sm-10">
                                                            <input type="text"
                                                                class="form-control
                                                        @error('phone_chunha') is-invalid @enderror"
                                                                id="phone_chunha" value="{{ old('phone_chunha') ?? $data->phone_chunha }}"
                                                                name="phone_chunha" placeholder="Nhập số điện thoại">
                                                                @error('phone_chunha')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Dòng
                                                            xe</label>
                                                        <div class="col-sm-10">
                                                            <input type="text"
                                                                class="form-control
                                                        @error('type_car') is-invalid @enderror"
                                                                id="type_car" value="{{ old('type_car') ?? $data->type_car }}"
                                                                name="type_car" placeholder="Nhập dòng xe">
                                                                @error('type_car')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Đơn vị thi công</label>
                                                        <div class="col-sm-10">
                                                            <input type="text"
                                                                class="form-control
                                                        @error('donvithicong') is-invalid @enderror"
                                                                id="donvithicong" value="{{ old('donvithicong') ?? $data->donvithicong }}"
                                                                name="donvithicong" placeholder="Nhập đơn vị thi công">
                                                                @error('donvithicong')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label for=""
                                                            class="col-sm-2 control-label">Tỉnh/Thành
                                                            phố</label>
                                                        <div class="col-sm-10">
                                                            <select name="city_id" id="city" class="form-control" data-url="{{ route('ajax.address.districts') }}">
                                                                <option value="">Chọn tỉnh/thành phố</option>
                                                                @foreach ($cities as $city)
                                                                <option value="{{ $city->id }}" {{ $city->id==(old('city_id')??$data->city_id)?'selected':'' }} >{{ $city->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('city_id')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div> 

                                                {{-- <div class="form-group ">
                                                    <div class="row">
                                                        <label for=""
                                                            class="col-sm-2 control-label">Quận/Huyện</label>
                                                        <div class="col-sm-10">
                                                            <select name="district_id" id="district"
                                                                class="form-control @error('district_id') is-invalid @enderror">
                                                                <option value="">Chọn Quận/Huyện</option>
                                                                <option selected value="{{$data->district_id ?? null}}">{{$data->district->name ?? ''}}</option>
                                                            </select>
                                                            @error('district_id')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

        
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label for="" class="col-sm-2 control-label">Địa
                                                            chỉ</label>
                                                        <div class="col-sm-10">
                                                            <input type="text"
                                                                class="form-control
                                                                @error('address_chunha') is-invalid @enderror"
                                                                value="{{ old('address_chunha') ?? $data->address_chunha }}"
                                                                name="address_chunha" placeholder="Địa chỉ">
                                                            @error('address_chunha')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div> --}}

                                                {{-- <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Nhập giới thiệu</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control" name="description" id="" rows="4" placeholder="Nhập giới thiệu">{{old('description')?? $data->description }}</textarea>
                                                        </div>
                                                    </div>

                                                    @error('description')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div> --}}



                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Ghi chú</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control tinymce_editor_init" name="content" id="" rows="7" placeholder="Ghi chú">{{old('content')?? $data->content }}</textarea>
                                                        </div>
                                                    </div>
                                                    @error('content')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                {{--<div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Loại giao dịch</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control custom-select select-2-init" id="" name="category_id">
                                                            <option value="0">Chọn loại giao dịch</option>
                                                            {!!$option!!}
                                                    </select>
                                                        </div>
                                                    </div>
                                                    @error('category_id')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Tỉnh/Thành phố</label>
                                                        <div class="col-sm-10">
                                                            <select name="city_id" id="city" class="form-control" required="required" data-url="{{ route('ajax.address.districts') }}">
                                                                <option value="">Chọn tỉnh/thành phố</option>
                                                                {!! $cities !!}
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Quận/huyện</label>
                                                        <div class="col-sm-10">
                                                            <select name="district_id" id="district" class="form-control" required="required" data-url="{{ route('ajax.address.communes') }}">
                                                                <option value="">Chọn quận/huyện</option>
                                                                @if ($data->city_id)
                                                                    @foreach ($data->city->districts as $item)
                                                                        <option value="{{ $item->id }}" {{ $item->id==$data->district_id?"selected":"" }}>{{ $item->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Xã/phường/thị trấn</label>
                                                        <div class="col-sm-10">
                                                            <select name="commune_id" id="commune" class="form-control" required="required">
                                                                <option value="">Chọn xã/phường/thị trấn</option>
                                                                @if ($data->district_id)
                                                                    @foreach ($data->district->communes as $item)
                                                                        <option value="{{ $item->id }}" {{ $item->id==$data->commune_id?"selected":"" }}>{{ $item->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Diện tích</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control @error('dientich') is-invalid @enderror" id="" value="{{ $data->dientich }}" name="dientich" placeholder="Nhập diện tích">
                                                        </div>
                                                    </div>
                                                    @error('dientich')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div> --}}



                                                {{-- <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Hướng nhà</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control tag-select-choose"  name="huongnha">
                                                                @foreach ($huongnha as $item)
                                                                    <option value="{{ $item['value'] }}" {{$item['value']== $data->huongnha?"selected":"" }}>{{ $item['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @error('huongnha')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div> --}}



                                                {{-- <div class="form-group row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Nhập ngày đăng</label>
                                                            <input type="date" class="form-control  @error('created_at')
                                                            is-invalid

                                                            @enderror" id="" name="created_at"  placeholder="dd-mm-yyyy" value="{{ old('created_at')??  date_format($data->created_at,'Y-m-d') }}" >
                                                            @error('created_at')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Nhập ngày hết hạn</label>
                                                            <input type="date" class="form-control  @error('time_expires')
                                                            is-invalid
                                                            @enderror" id="" name="time_expires" placeholder="dd-mm-yyyy" value="{{ old('time_expires')?? ($data->time_expires? date_format(\Carbon::parse($data->time_expires),'Y-m-d'):'') }}">
                                                            @error('time_expires')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div> --}}

                                                {{-- <div class="form-group">
                                                    <div class="row">
                                                        <label for=""  class="col-sm-2 control-label">Sale(%)</label>
                                                        <div class="col-sm-10">
                                                          <input type="number" class="form-control" id="" value="{{ $data->sale }}" name="sale" placeholder="Nhập %">
                                                        </div>
                                                    </div>

                                                </div>
                                                @error('sale')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror --}}




                                                {{-- <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Dịch vụ nổi bật</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" class="form-check-input" value="1" name="hot" @if( $data->hot ===1) {{'checked'}} @endif>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error('hot')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div> --}}


                                            </div>
                                            <!-- END Tổng Quan -->

                                            <!-- START Dữ Liệu -->
                                            <!-- <div id="du_lieu" class="container tab-pane fade"><br>

                                            </div> -->
                                            <!-- END Dữ Liệu -->

                                            <!-- START Hình Ảnh -->
                                            <div id="hinh_anh" class="container tab-pane fade"><br>
                                                <div class="wrap-load-image mb-3">
                                                    <div class="form-group">
                                                        <label for="">Ảnh đại diện</label>
                                                        <input type="file" class="form-control-file img-load-input border" id="" name="avatar_path">
                                                    </div>
                                                    @error('avatar_path')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                    @if($data->avatar_path)
                                                    <img class="img-load border p-1 w-100" src="{{$data->avatar_path}}" alt="{{$data->name}}" style="height: 200px;object-fit:cover; max-width: 260px;">
                                                    @endif
                                                </div>

                                                {{-- <div class="wrap-load-image mb-3">
                                                    <label class="mb-3 w-100">Hình ảnh khác</label>

                                                    <span class="badge badge-success">Đã thêm</span>
                                                    <div class="list-image d-flex flex-wrap">
                                                        @foreach($data->images()->get() as $productImageItem)
                                                             <div class="col-image" style="width:20%;" >
                                                                <img class="" src="{{$productImageItem->image_path}}" alt="{{$productImageItem->name}}">
                                                                <a class="btn btn-sm btn-danger lb_delete_image"  data-url="{{ route('admin.product.destroy-image',['id'=>$productImageItem->id]) }}"><i class="far fa-trash-alt"></i></a>
                                                             </div>
                                                         @endforeach
                                                         @if (!$data->images()->get()->count())
                                                            Chưa thêm hình ảnh nào
                                                         @endif
                                                    </div>
                                                    <hr>
                                                    <span class="badge badge-primary mb-3">Thêm ảnh</span>
                                                    <div class="form-group">
                                                        <label for="">Thêm ảnh</label>
                                                        <input type="file" class="form-control-file img-load-input-multiple border" id="" name="image[]" multiple>
                                                    </div>
                                                    @error('image')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                    <div class="load-multiple-img">
                                                        @if (!$data->images()->get()->count())
                                                        <img class="" src="{{asset('admin_asset/images/upload-image.png')}}" alt="'no image">
                                                        <img class="" src="{{asset('admin_asset/images/upload-image.png')}}" alt="'no image">
                                                        <img class="" src="{{asset('admin_asset/images/upload-image.png')}}" alt="'no image">
                                                        @endif
                                                    </div>
                                                </div> --}}




                                            </div>
                                            <!-- END Hình Ảnh -->

                                            <!-- START Seo -->
                                            {{-- <div id="seo" class="container tab-pane fade"><br>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Nhập title seo</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="" value="{{ old('title_seo')??$data->title_seo }}" name="title_seo" placeholder="Nhập title seo">
                                                            @error('title_seo')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Nhập mô tả seo</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="" value="{{old('description_seo')?? $data->description_seo }}" name="description_seo" placeholder="Nhập mô tả seo">
                                                        </div>
                                                    </div>
                                                    @error('description_seo')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Nhập từ khóa seo</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="" value="{{old('keyword_seo')?? $data->keyword_seo }}" name="keyword_seo" placeholder="Nhập từ khóa seo">
                                                        </div>
                                                    </div>
                                                    @error('keyword_seo')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Nhập tags</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control tag-select-choose" multiple="multiple" name="tags[]">
                                                                @if (old('tags'))
                                                                    @foreach (old('tags') as $tag)
                                                                        <option value="{{ $tag }}" selected>{{ $tag }}</option>
                                                                    @endforeach
                                                                @else
                                                                @foreach($data->tags as $tagItem)
                                                                <option value="{{$tagItem->name}}" selected>{{$tagItem->name}}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @error('tags')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div> --}}
                                            <!-- END Seo -->
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Thông tin khác</h3>
                                     </div>
                                     <div class="card-body table-responsive p-3">
                                        <div class="form-group">
                                            <label class=" control-label" for="">Chọn danh mục</label>
                                            <select class="form-control custom-select select-2-init @error('category_id')
                                                is-invalid
                                                @enderror" id="" value="{{ old('category_id') }}" name="category_id">

                                                <option value="0">--- Chọn danh mục cha ---</option>

                                                @if (old('category_id')||old('category_id')==='0')
                                                    {!! \App\Models\CategoryProduct::getHtmlOption(old('category_id')) !!}
                                                @else
                                                {!!$option!!}
                                                @endif
                                            </select>
                                            @error('category_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="alert alert-light  mt-3 mb-1">
                                            <strong>Chọn thuộc tính</strong>
                                        </div>

                                        @foreach ($attributes as $key=> $attribute)
                                        <div class="form-group">
                                            <label class="control-label" for="">{{ $attribute->name }}</label>
                                            <select class="form-control attributeParent" data-id="{{$attribute->id}}" data-url="{{route('admin.load.attributes')}}"  name="attribute[]" >
                                                <option value="0">--Chọn--</option>
                                                @foreach ($attribute->childs()->orderby('id')->get() as $k=> $attr)
                                                    <option value="{{ $attr->id }}"
                                                        @if (old('attribute'))
                                                            @if ($attr->id==old('attribute')[$key])
                                                                selected
                                                            @else
                                                                {{ $data->attributes->pluck('id')->contains($attr->id)?'selected':"" }}
                                                            @endif
                                                        @else
                                                        {{ $data->attributes->pluck('id')->contains($attr->id)?'selected':"" }}
                                                        @endif
                                                    >
                                                        {{ $attr->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('attribute_child_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                           
                                            <!-- Load ajax attribute -->
                                            <div class="child-attributes">
                                                <div class="row resultAttributes" id="resultAttributes{{$attribute->id}}">
                                                    @if (isset($data->attributeChilds) && $data->attributeChilds->count() > 0)
                                                        @foreach ($attribute->childs()->orderby('id')->get() as $k=> $attr)
                                                        
                                                            @foreach ($attr->options as $item)
                                                                @php
                                                                    $dataChildAttr = $data->attributeChilds->pluck('attribute_product_id')->contains($item->id);
                                                                    $checkAttrId = $data->attributeChilds->pluck('attribute_id')->contains($item->attribute_id);
                                                                @endphp
                                                                @if ($checkAttrId)
                                                                    <div class="col-sm-12">
                                                                        <input type="checkbox" class="change-attr-child" name="attribute_child_id[]"
                                                                        @if (old('attribute_child_id'))
                                                                            @if ($attr->id==old('attribute_child_id')[$key])
                                                                                checked
                                                                            @else
                                                                                {{ $dataChildAttr?'checked':"" }}
                                                                            @endif
                                                                        @else
                                                                            {{ $dataChildAttr?'checked':"" }}
                                                                        @endif
                                                                                value="{{$attr->id}}|{{$item->id}}|{{$item->name}}|{{$item->value}}"/>
                                                                        <span class="att-title">{{$item->name}} -<span style="color: red"> {{number_format($item->value, 0, ',', '.') ?? 0}}</span></span>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                    {{-- @php
                                                        $dataAttr = \App\Models\ProductAttributeChild::where('product_id', $data->id)->get();
                                                        // list taat car attribute co
                                                        $listIdAttr = $dataAttr->pluck('attribute_id')->unique()->toArray();
                                                        //get id attrbite
                                                        $childAttr = \App\Models\Attribute::where('parent_id', $attribute->id)->pluck('id')->toArray();
                                                       
                                                        //filter data mapching
                                                        $mappching = array_intersect($childAttr, $listIdAttr);
                                                    @endphp --}}
                                                    @if(count($data->attributes) > 0)
                                                        @php
                                                            $time_start = $attribute->time_start;
                                                            $time_end = $attribute->time_end;
                                                        @endphp
                                                        @if (!empty($data->$time_start) && !empty($data->$time_end))
                                                            <div class="col-sm-12 pl-4 color-date">
                                                                <label class="control-label" for="">Ngày bắt đầu <span class="lowercase">{{$attribute->name}}</span></label>
                                                                <div class="">
                                                                    <input type="date" class="form-control @error($time_start) is-invalid @enderror" value="{{ old($time_start) ?? $data->$time_start }}" name="{{$time_start}}"/>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-sm-12 pl-4 color-date">
                                                                <label class="control-label" for="">Ngày kết thúc <span class="lowercase">{{$attribute->name}}</span></label>
                                                                <div class="">
                                                                    <input type="date" class="form-control @error($time_end) is-invalid @enderror" value="{{ old($time_end) ?? $data->$time_end }}" name="{{$time_end}}"/>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- End -->
                                        </div>
                                        @endforeach
                                        <hr>
                                        @if($data->attributes->count() == 0||1)
                                            <div class="group-checkbox">
                                                <div class="warpper-ajax-checkbox">
                                                    <div class="form-groups">
                                                        <label class="control-label" for="">CheckBox Phim cách nhiệt bảo vệ ô tô</label>
            
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input ajax-checkbox @error('check_btn') is-invalid
                                                                    @enderror" value="1" data-type="phim cách nhiệt" data-addyear="15" data-time_buy="time_buy" data-time_expires="time_expires" name="check_btn" @if(old('check_btn')==="1"|| $data->check_btn==1 ) {{'checked'}} @endif>
                                                            </label>
                                                        </div>
                                                        @error('check_btn')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="old-date-time pl-20">
                                                            {{-- @if ($data->check_btn == 1) --}}
                                                            <div class="form-group">
                                                                <label class="control-label" for="">Ngày bắt đầu phim cách nhiệt</label>
                                                                <div class="">
                                                                    <input type="text" class="form-control @error('time_buy') is-invalid @enderror" value="{{ old('time_buy') ?? $data->time_buy }}" name="time_buy" placeholder="ngày bán" />
                                                                    @error('time_buy')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="control-label" for="">Ngày kết thúc phim cách nhiệt</label>
                                                                <div class="">
                                                                    <input type="text" class="form-control @error('time_expires') is-invalid @enderror" value="{{ old('time_expires') ?? $data->time_expires }}" name="time_expires" placeholder="ngày mua" />
                                                                    @error('time_expires')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            {{-- @endif --}}
                                                        </div>
                                                </div>
        
                                                <div class="warpper-ajax-checkbox">
                                                    <div class="form-groups">
                                                        <label class="control-label" for="">Check box Phủ Ceramic</label>
            
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input ajax-checkbox @error('check_btn2') is-invalid
                                                                    @enderror" value="1" data-addyear="2" data-type="bảo vệ bề mặt" data-time_buy="time_buy2" data-time_expires="time_expires2" name="check_btn2" @if(old('check_btn2')==="1"||$data->check_btn2==1 ) {{'checked'}} @endif>
                                                            </label>
                                                        </div>
                                                        @error('check_btn2')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="old-date-time pl-20">
                                                            {{-- @if ($data->check_btn2 == 1) --}}
                                                            <div class="form-group">
                                                                <label class="control-label" for="">Ngày bắt đầu bảo bề mặt</label>
                                                                <div class="">
                                                                    <input type="text" class="form-control @error('time_buy2') is-invalid @enderror" value="{{ old('time_buy2') ?? $data->time_buy2 }}" name="time_buy2" placeholder="ngày bán" />
                                                                    @error('time_buy2')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="control-label" for="">Ngày kết thúc bảo bề mặt</label>
                                                                <div class="">
                                                                    <input type="text" class="form-control @error('time_expires2') is-invalid @enderror" value="{{ old('time_expires2') ?? $data->time_expires2 }}" name="time_expires2" placeholder="ngày mua" />
                                                                    @error('time_expires2')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            {{-- @endif --}}
                                                        </div>
                                                </div>
        
                                                <div class="warpper-ajax-checkbox">
                                                    <div class="form-groups">
                                                        <label class="control-label" for="">CheckBox Phim bảo vệ sơn</label>
            
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input ajax-checkbox @error('check_btn3') is-invalid
                                                                    @enderror" value="1" data-addyear="5" data-time_buy="time_buy1" data-time_expires="time_expires1" data-type="bảo vệ sơn" name="check_btn3" @if(old('check_btn3')==="1"||$data->check_btn3==1 ) {{'checked'}} @endif>
                                                            </label>
                                                        </div>
                                                        @error('check_btn3')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="old-date-time pl-20">
                                                            {{-- @if ($data->check_btn3 == 1) --}}
                                                            <div class="form-group">
                                                                <label class="control-label" for="">Ngày bắt đầu bảo vệ sơn</label>
                                                                <div class="">
                                                                    <input type="text" class="form-control @error('time_buy1') is-invalid @enderror" value="{{ old('time_buy1') ?? $data->time_buy1 }}" name="time_buy1" placeholder="ngày bán" />
                                                                    @error('time_buy1')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="control-label" for="">Ngày kết thúc bảo vệ sơn</label>
                                                                <div class="">
                                                                    <input type="text" class="form-control @error('time_expires1') is-invalid @enderror" value="{{ old('time_expires1') ?? $data->time_expires1 }}" name="time_expires1" placeholder="ngày mua" />
                                                                    @error('time_expires1')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            {{-- @endif --}}
                                                        </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <label class="control-label" for="">Số thứ tự</label>
                                            <input type="number" min="0" class="form-control  @error('order') is-invalid  @enderror"  value="{{ old('order')??$data->order }}" name="order" placeholder="Nhập số thứ tự">
                                            @error('order')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                         {{-- <div class="form-group">
                                            <label class="control-label" for="">Chọn nhà cung cấp</label>
                                            <select class="form-control @error('supplier')
                                                is-invalid
                                                @enderror" id="" value="{{ old('supplier_id') }}" name="supplier_id">

                                                <option value="0">--- Chọn nhà cung cấp ---</option>
                                                @foreach ($supplier as $item)
                                                <option value="{{ $item->id }}" {{ (old('supplier')??$data->supplier_id)==  $item->id ?"selected":""}}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('supplier_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div> --}}

                                        {{-- <div class="form-group">
                                            <label class="control-label" for="">Số thứ tự</label>
                                            <input type="number" min="0" class="form-control  @error('order') is-invalid  @enderror"  value="{{ old('order')??$data->order }}" name="order" placeholder="Nhập số thứ tự">
                                            @error('order')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div> 

                                         <div class="form-group">
                                            <label class="control-label" for="">Giá sản phẩm</label>
                                            <input type="text" class="form-control" id="price" onchange="changePrice()" value="{{ old('price')?? $data->price }}" name="price" placeholder="Nhập giá">
                                            @error('price')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class=" control-label" for="">Sale(%)</label>
                                            <input type="number" min="0" class="form-control  @error('sale') is-invalid  @enderror"  value="{{ old('sale')??$data->sale }}" name="sale" placeholder="Nhập sale">
                                            @error('sale')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label" for="">Sản phẩm nổi bật</label>

                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input @error('hot') is-invalid
                                                        @enderror" value="1" name="hot" @if((old('hot')??$data->hot)=="1" ) {{'checked'}} @endif>
                                                </label>
                                            </div>
                                            @error('hot')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>--}}
                                        <div class="form-group">
                                            <label class="control-label" for="">Trạng thái</label>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="1" name="active" @if((old('active')??$data->active)=='1') {{'checked'}} @endif>Hiện
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="0" @if((old('active')??$data->active)=="0"){{'checked'}} @endif name="active">Ẩn
                                                </label>
                                            </div>
                                            @error('active')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        {{--<div class="form-group">
                                            <label class="control-label" for="">Bán chạy</label>

                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input @error('ban_chay') is-invalid
                                                        @enderror" value="1" name="ban_chay" @if((old('ban_chay')??$data->ban_chay)=="1" ) {{'checked'}} @endif>
                                                </label>
                                            </div>
                                            @error('ban_chay')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                         <hr>
                                        <div class="alert alert-light  mt-3 mb-1">
                                            <strong>Chọn thuộc tính</strong>
                                          </div>

                                         @foreach ($attributes as $key=> $attribute)

                                            <div class="form-group">
                                                <label class="control-label" for="">{{ $attribute->name }}</label>
                                                <select class="form-control"  name="attribute[]" >
                                                    <option value="0">--Chọn--</option>
                                                    @foreach ($attribute->childs()->orderby('order')->get() as $k=> $attr)
                                                        <option value="{{ $attr->id }}"
                                                            @if (old('attribute'))
                                                                @if ($attr->id==old('attribute')[$key])
                                                                    selected
                                                                @else
                                                                    {{ $data->attributes()->get()->pluck('id')->contains($attr->id)?'selected':"" }}
                                                                @endif
                                                            @else
                                                            {{ $data->attributes()->get()->pluck('id')->contains($attr->id)?'selected':"" }}
                                                            @endif
                                                        >
                                                            {{ $attr->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('attribute.'.$key)
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                         @endforeach
                                            <hr> --}}
                                        {{--
                                        <div class="alert alert-light mt-3 mb-1">
                                            <strong>Upload file</strong>
                                          </div>

                                        <div class="form-group">
                                            <label for="">Brochure</label>
                                          <div>
                                            <a href="{{ $data->file }}" download>{{ $data->file }}</a>
                                          </div>
                                            <input type="file" class="form-control-file img-load-input border @error('file')
                                            is-invalid
                                            @enderror" id="" name="file">
                                            @error('file')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Hướng dẫn sử dụng</label>
                                            <div>
                                                <a href="{{ $data->file2 }}" download>{{ $data->file2 }}</a>
                                            </div>
                                            <input type="file" class="form-control-file img-load-input border @error('file2')
                                            is-invalid
                                            @enderror" id="" name="file2">
                                            @error('file2')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Drive</label>
                                            <div>
                                                <a href="{{ $data->file3 }}" download>{{ $data->file3 }}</a>
                                            </div>
                                            <input type="file" class="form-control-file img-load-input border @error('file3')
                                            is-invalid
                                            @enderror" id="" name="file3">
                                            @error('file3')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        --}}
                                     </div>
                                </div>


                            </div>
                            {{-- <div class="col-md-12">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Các lựa chọn</h3>
                                    </div>
                                     <div class="card-body table-responsive p-3">
                                            <div class="list-item-option wrap-option mt-3 row">
                                                    @foreach ($data->options()->latest()->get() as $key=>$item)
                                                    <div class="col-md-4 col-sm-6 col-12 col-item-price">
                                                        <div class="item-price">
                                                            <input type="hidden" name="idOption[]" value="{{ $item->id }}">
                                                            <div class="box-content-price">
                                                                <div class="form-group">
                                                                    <label class="control-label" for="">Chọn nhà cung cấp</label>
                                                                    <select class="form-control  @error('supplier_idOptionOld.'.$key) is-invalid  @enderror"   name="supplier_idOptionOld[]">
                                                                        <option value="">Chon nhà cung cấp</option>
                                                                        @if (isset($supplier)&&$supplier)
                                                                        @foreach ($supplier as $itemSup)
                                                                            <option value="{{ $itemSup->id }}" {{ (old('supplier_idOptionOld')[$key]??$item->supplier_id)==$itemSup->id?'selected':'' }}>{{ $itemSup->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                    @error('supplier_idOptionOld.'.$key)
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label" for="">Nhập đường dẫn</label>
                                                                    <input type="text" min="0" class="form-control  @error('slugOptionOld.'.$key) is-invalid  @enderror"  value="{{  old('slugOptionOld')[$key]??$item->slug }}" name="slugOptionOld[]" placeholder="Nhập đường dẫn">
                                                                    @error('slugOptionOld.'.$key)
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label" for="">Nhập giá</label>
                                                                    <input type="number" min="0" class="form-control  @error('priceOptionOld.'.$key) is-invalid  @enderror"  value="{{  old('priceOptionOld')[$key]??$item->price }}" name="priceOptionOld[]" placeholder="Nhập giá">
                                                                    @error('priceOptionOld.'.$key)
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="action">
                                                                <a  class="btn btn-sm btn-danger deleteOptionProductDB" data-url="{{ route('admin.product.destroyOptionProduct',['id'=>$item->id]) }}"><i class="far fa-trash-alt"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach

                                            </div>
                                            <div class="">Thêm option mới  <a data-url="{{ route('admin.product.loadOptionProduct') }}" class="btn  btn-info btn-md float-right " id="addOptionProduct">+ Thêm option</a></div>
                                            <div class="list-item-option wrap-option mt-3 row" id="wrapOption">
                                                @if (old('supplier_idOption')&&old('supplier_idOption'))
                                                    @foreach (old('supplier_idOption') as $key=>$value)
                                                    <div class="col-md-4 col-sm-6 col-12 col-item-price">
                                                        <div class="item-price">
                                                            <div class="box-content-price">
                                                                <div class="form-group">
                                                                    <label class="control-label" for="">Chọn nhà cung cấp</label>
                                                                    <select class="form-control  @error('supplier_idOption') is-invalid  @enderror"   name="supplier_idOption[]">
                                                                        <option value="">Chon nhà cung cấp</option>
                                                                        @if (isset($supplier)&&$supplier)
                                                                        @foreach ($supplier as $item)
                                                                        <option value="{{ $item->id }}" {{ old('supplier_idOption')[$key]==$item->id?'selected':'' }}>{{ $item->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </select>
                                                                    @error('supplier_idOption.'.$key)
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label" for="">Đường dẫn</label>
                                                                    <input type="text" min="0" class="form-control  @error('slugOption.'.$key) is-invalid  @enderror"  value="{{ old('slugOption')[$key] }}" name="slugOption[]" placeholder="Nhập đường dẫn">
                                                                    @error('slugOption.'.$key)
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label" for="">Nhập giá</label>
                                                                    <input type="number"  class="form-control  @error('priceOption.'.$key) is-invalid  @enderror"  value="{{ old('priceOption')[$key] }}" name="priceOption[]" placeholder="Nhập giá">
                                                                    @error('priceOption.'.$key)
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="action">
                                                                <a  class="btn btn-sm btn-danger deleteOptionProduct"><i class="far fa-trash-alt"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endif
                                            </div>

                                     </div>
                                </div>
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal" id="_addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <form action="" method="POST" id="modalAddSeiviceArising" class="form-submit">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="deleteItemText">Thêm dịch vụ phát sinh</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="modal-body" id="loadProductService">
                
            </div>
            <div class="modal-footer">
                <div class="text-center col-12">
                    <button class="btn btn-secondary btn-sm " type="button" data-dismiss="modal">Hủy bỏ</button>
                    <button class="btn btn-danger btn-sm btn-submit" type="submit">Xác nhận</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
@endsection

@section('js')
<script>
      function changePrice(){
        var value = $('#price').val();

        value = value.replace(',', ".");

        $('#price').val(value);
    }

    // js load ajax
    $(document).on("click", ".btnSeiviceArising", function() {
        let contentWrap = $('#loadProductService');
        let modal = $(this).attr('data-target');

        let urlRequest = $(this).data("url");
        $.ajax({
            type: "GET",
            url: urlRequest,
            success: function(data) {
                if (data.code == 200) {
                    let html = data.htmlLoadProductService;
                    contentWrap.html(html);
                    $(modal).modal('show');
                }
            }
        });
    });
    // end js load ajax

    // $(document).on("click ", ".change-attr-child", function() {
    //     if ($(this).prop('checked')) {
    //         $('.group-checkbox').hide();
    //     }else{
    //         $('.group-checkbox').show();
    //     }
    // });
    
</script>

<script>
    //load ajax attributes
    $(document).on('change', '.attributeParent', function() {
        let urlRequest = $(this).data("url");
        let id = $(this).data("id");
        let mythis = $(this);
        let value = $(this).val();
        if(value == 0){
            mythis.parents('.form-group').find('.resultAttributes').empty();
        }

        $.ajax({
            type: "GET",
            url: urlRequest,
            data: { 'attributeId': value, 'id' : id },
            success: function(data) {
                let html = data.data;
                $('#resultAttributes'+ id).html(html);
            }
        });
    });


    //load ajax date time
    $(document).on('change', '.ajax-checkbox', function() {
        let mythis = $(this);

        if ($(this).prop('checked')) {
            let urlRequest = '{{ url()->current() }}';
            let type = $(this).data("type");
            let time_buy = $(this).data("time_buy");
            let time_expires = $(this).data("time_expires");
            let addYear = $(this).data("addyear");

            let value = $(this).val();

            $.ajax({
                type: "GET",
                url: urlRequest,
                data: {value, type, time_buy,time_expires, addYear } ,
                success: function(data) {
                    let html = data.html;
                    mythis.parents('.warpper-ajax-checkbox').find('.old-date-time').html(html);
                }
            });
        }else{
            // $(this).val($(this).is(':checked'));
            mythis.parents('.warpper-ajax-checkbox').find('.old-date-time').empty();
        }
    });

    //load ajax address
    $(document).on('change', '#city', function() {
            let urlRequest = '{{ url()->current() }}';
        let mythis = $(this);
        let value = $(this).val();
        let defaultCity = "<option value=''>Chọn thành phố</option>";
        let defaultDistrict = "<option value=''>Chọn quận huyện</option>";
        if (!value) {
            $('#district').html(defaultDistrict);
        } else {
            $.ajax({
                type: "GET",
                url: urlRequest,
                data: { 'cityId': value },
                success: function(data) {
                    if (data.code == 200) {
                        let html = defaultDistrict + data.data;
                        $('#district').html(html);
                    }
                }
            });
        }
    });


    //submit modal product service
    $(document).on('submit', '#modalAddSeiviceArising', function() {
        // let formValues = $(this).serialize();
        let urlRequest = '{{route('admin.ajax.product-service.store')}}';
        var formData = new FormData(this);

        let info = 'Thêm bảo hành thành công. Bạn có muốn đi đến danh sách bảo hành?';
        let agree = 'Đồng ý';
        let skip = 'Hủy';
        let addfail = 'Thêm sản phẩm vào giỏ thất bại! Bạn có muốn đi đến đến danh sách bảo hành?';

        let swalOption = {
            //  title: "test",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: agree,
            cancelButtonText: skip
        }

        $.ajax({
            type: "POST",
            url: urlRequest,
            contentType: false,
            processData: false,
            data: formData,
            
            success: function(response) {
                if (response.code === 200) {
                    swalOption.title = info;
                    swalOption.icon = 'success';
                    Swal.fire(swalOption).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/admin/product";

                        }
                    })
                } else {
                    swalOption.title = addfail;
                    Swal.fire(swalOption).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/admin/product";
                        }
                    })
                }
            },
            error: function(response) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Lỗi rồi. Vui lòng điền đầy đủ các trường thông tin bắt buộc',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
        return false;
    });
</script>
@endsection
