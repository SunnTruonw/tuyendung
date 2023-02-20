@extends('admin.layouts.main')
@section('title', 'Thêm sản phẩm')

@section('css')
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #000 !important;
        }

        .select2-container .select2-selection--single {
            height: auto;
        }
        .child-attributes{
            margin: 10px;
        }
        .child-attributes .col-sm-6{
            margin-bottom: 5px;
        }
    </style>
@endsection
@section('content')


    <div class="content-wrapper">

        @include('admin.partials.content-header', ['name' => 'Bảo hành', 'key' => 'Thêm bảo hành'])

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if (session()->has('alert'))
                            <div class="alert alert-success">
                                {{ session()->get('alert') }}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-warning">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form class="form-horizontal" action="{{ route('admin.product.store') }}" method="POST"
                            enctype="multipart/form-data">
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
                                                    <a class="nav-link active" data-toggle="tab" href="#tong_quan">Tổng
                                                        quan</a>
                                                </li>
                                                <!-- <li class="nav-item">
                                                                                                                                                                            <a class="nav-link" data-toggle="tab" href="#du_lieu">Dữ liệu</a>
                                                                                                                                                                            </li> -->
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#hinh_anh">Hình
                                                        ảnh</a>
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
                                                            <label class="col-sm-2 control-label" for="">Họ và
                                                                tên</label>
                                                            <div class="col-sm-10">
                                                                <input type="text"
                                                                    class="form-control
                                                            @error('name_chunha') is-invalid @enderror"
                                                                    id="name_chunha" value="{{ old('name_chunha') }}"
                                                                    name="name_chunha" placeholder="Nhập họ tên">
                                                                    @error('name_chunha')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-sm-2 control-label"
                                                                for="">Slug</label>
                                                            <div class="col-sm-10">
                                                                <input type="text"
                                                                    class="form-control
                                                            @error('slug') is-invalid @enderror"
                                                                    id="slug" value="{{ old('slug') }}"
                                                                    name="slug" placeholder="Nhập slug">
                                                            </div>
                                                        </div>
                                                        @error('slug')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>

                                                        @enderror
                                                    </div> --}}

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-sm-2 control-label" for="">Số
                                                                khung/Biển sô</label>
                                                            <div class="col-sm-10">
                                                                <input type="text"
                                                                    class="form-control
                                                            @error('masp') is-invalid @enderror"
                                                                    id="masp" value="{{ old('masp') }}"
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
                                                                    id="phone_chunha" value="{{ old('phone_chunha') }}"
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
                                                                    id="type_car" value="{{ old('type_car') }}"
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
                                                                    id="donvithicong" value="{{ old('donvithicong') }}"
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
                                                                <select name="city_id" id="city"
                                                                    class="form-control @error('city_id') is-invalid @enderror"
                                                                    data-url="{{ route('ajax.address.districts') }}">
                                                                    <option value="">Chọn tỉnh/thành phố</option>
                                                                    {!! $cities !!}
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
                                                                </select>
                                                                @error('district_id')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                        </div>
                                                    </div> --}}

                                                    {{-- <div class="form-group">
                                                        <div class="row">
                                                            <label for="" class="col-sm-2 control-label">Địa
                                                                chỉ</label>
                                                            <div class="col-sm-10">
                                                                <input type="text"
                                                                    class="form-control
                                                                    @error('address_chunha') is-invalid @enderror"
                                                                    value="{{ old('address_chunha') }}"
                                                                    name="address_chunha" placeholder="Địa chỉ">
                                                                @error('address_chunha')
                                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div> --}}

                                                    

                                                    {{-- <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-sm-2 control-label" for="">Nhập giới
                                                                thiệu</label>
                                                            <div class="col-sm-10">
                                                                <textarea class="form-control  @error('description') is-invalid @enderror" name="description" id=""
                                                                    rows="3" placeholder="Nhập giới thiệu">{{ old('description') }}</textarea>
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
                                                                <textarea class="form-control tinymce_editor_init @error('content') is-invalid @enderror" name="content"
                                                                    id="" rows="20" value="" placeholder="Ghi chú">
                                                                {{ old('content') }}
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                        @error('content')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>



                                                    {{-- <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Địa chỉ</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control @error('address_detail') is-invalid @enderror" id="" value="{{ old('address_detail') }}" name="address_detail" placeholder="Nhập địa chỉ của bạn">
                                                        </div>
                                                    </div>
                                                    @error('address_detail')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>

                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Diện tích</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control @error('dientich') is-invalid @enderror" id="" value="{{ old('dientich') }}" name="dientich" placeholder="Nhập diện tích">
                                                        </div>
                                                    </div>
                                                    @error('dientich')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>

                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Đơn vị</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control tag-select-choose"  name="donvi">
                                                                @foreach ($donvi as $item)
                                                                    <option value="{{ $item['value'] }}">{{ $item['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @error('donvi')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>

                                                    @enderror
                                                </div> --}}


                                                    {{-- <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Hướng nhà</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control tag-select-choose"  name="huongnha">
                                                                @foreach ($huongnha as $item)
                                                                    <option value="{{ $item['value'] }}">{{ $item['name'] }}</option>
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
                                                            <input  type="date" class="form-control  @error('created_at')
                                                            is-invalid
                                                            @enderror"  name="created_at" placeholder="dd-mm-yyyy" value="{{ old('created_at') }}">
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
                                                            @enderror" id="" name="time_expires" placeholder="dd-mm-yyyy" value="{{ old('time_expires') }}">
                                                            @error('time_expires')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div> --}}

                                                    {{-- <div class="form-group">
                                                    <div class="row">
                                                        <label for="" class="col-sm-2 control-label">Sale(%)</label>
                                                        <div class="col-sm-10">
                                                                <input type="number" class="form-control @error('sale')
                                                                is-invalid
                                                                @enderror" id="" value="{{ old('sale') }}" name="sale" placeholder="Nhập %">
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
                                                                    <input type="checkbox" class="form-check-input @error('hot')
                                                                        is-invalid
                                                                        @enderror" value="1" name="hot" @if (old('hot') === '1') {{'checked'}} @endif>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error('hot')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>

                                                    @enderror
                                                </div> --}}




                                                    {{-- <div class="form-group form-check">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label">

                                                        </label>
                                                        <div class="col-sm-10">
                                                            <input type="checkbox" class="form-check-input" name="checkrobot" id="">
                                                            <label class="form-check-label" for="" required>Tôi đồng ý</label>
                                                        </div>
                                                    </div>
                                                    @error('checkrobot')
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
                                                            <input type="file"
                                                                class="form-control-file img-load-input border @error('avatar_path') is-invalid @enderror"
                                                                id="" name="avatar_path">
                                                        </div>
                                                        @error('avatar_path')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>

                                                        @enderror
                                                        <img class="img-load border p-1 w-100"
                                                            src="{{ asset('admin_asset/images/upload-image.png') }}"
                                                            style="height: 200px;object-fit:cover; max-width: 260px;">
                                                    </div>
                                                    {{-- <div class="wrap-load-image mb-3">
                                                        <div class="form-group">
                                                            <label for="">Ảnh liên quan</label>
                                                            <input type="file"
                                                                class="form-control-file img-load-input border @error('image') is-invalid @enderror"
                                                                id="" name="image[]" multiple>
                                                        </div>
                                                        @error('image')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                        <div class="load-multiple-img">
                                                            <img class=""
                                                                src="
                                                                {{ asset('admin_asset/images/upload-image.png') }}">
                                                            <img class=""
                                                                src="
                                                                {{ asset('admin_asset/images/upload-image.png') }}">
                                                            <img class=""
                                                                src="
                                                                {{ asset('admin_asset/images/upload-image.png') }}">
                                                        </div>
                                                    </div> --}}
                                                </div>
                                                <!-- END Hình Ảnh -->

                                                <!-- START Seo -->
                                                {{-- <div id="seo" class="container tab-pane fade"><br>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-sm-2 control-label" for="">Nhập
                                                                title
                                                                seo</label>
                                                            <div class="col-sm-10">
                                                                <input type="text"
                                                                    class="form-control @error('title_seo') is-invalid @enderror"
                                                                    id="" value="{{ old('title_seo') }}"
                                                                    name="title_seo" placeholder="Nhập title seo">
                                                                    @error('title_seo')
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-sm-2 control-label" for="">Nhập mô
                                                                tả
                                                                seo</label>
                                                            <div class="col-sm-10">
                                                                <input type="text"
                                                                    class="form-control @error('description_seo') is-invalid @enderror"
                                                                    id="" value="{{ old('description_seo') }}"
                                                                    name="description_seo" placeholder="Nhập mô tả seo">
                                                                    @error('description_seo')
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-sm-2 control-label" for="">Nhập từ
                                                                khóa
                                                                seo</label>
                                                            <div class="col-sm-10">
                                                                <input type="text"
                                                                    class="form-control @error('keyword_seo') is-invalid @enderror"
                                                                    id="" value="{{ old('keyword_seo') }}"
                                                                    name="keyword_seo" placeholder="Nhập từ khóa seo">
                                                                    @error('keyword_seo')
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <label class="col-sm-2 control-label" for="">Nhập
                                                                tags</label>
                                                            <div class="col-sm-10">
                                                                <select class="form-control tag-select-choose"
                                                                    multiple="multiple" name="tags[]"></select>
                                                                    @error('title_seo')
                                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                    @enderror
                                                            </div>
                                                        </div>
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
                                                <select
                                                    class="form-control custom-select select-2-init @error('category_id') is-invalid @enderror"
                                                    id="" value="{{ old('category_id') }}" name="category_id">

                                                    <option value="0">--- Chọn danh mục cha ---</option>
                                                    @if (old('category_id'))
                                                        {!! \App\Models\CategoryProduct::getHtmlOption(old('category_id')) !!}
                                                    @else
                                                        {!! $option !!}
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
                                                    <select data-id="{{$attribute->id}}" data-url="{{route('admin.load.attributes')}}" class="form-control attributeParent"  name="attribute[]" >
                                                        <option value="">--Chọn--</option>
                                                        @foreach ($attribute->childs()->orderby('order')->get() as $k=> $attr)
                                                            <option value="{{ $attr->id }}" @if (old('attribute')) {{ $attr->id== old('attribute')[$key] ? 'selected':"" }} @endif>{{ $attr->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('attribute_child_id')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror

                                                    <!-- Load ajax attribute -->
                                                        <div class="child-attributes">
                                                            <div class="row resultAttributes" id="resultAttributes{{$attribute->id}}">

                                                            </div>
                                                        </div>
                                                    <!-- End -->
                                                </div>
                                             @endforeach
                                            <hr>


                                            <div class="form-group">
                                                <label class="control-label" for="">Số thứ tự</label>
                                                <input type="number" min="0" class="form-control  @error('order') is-invalid  @enderror"  value="{{ old('order') }}" name="order" placeholder="Nhập số thứ tự">

                                                @error('order')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div> 
                                           {{-- <div class="form-group">
                                                <label class="control-label" for="">Giá</label>
                                                <input type="number" min="0"
                                                    class="form-control  @error('price') is-invalid @enderror"
                                                    value="{{ old('price') }}" name="price" placeholder="Nhập giá">
                                                @error('price')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>--}}
                                        
                                        <div class="group-checkbox">
                                            <div class="warpper-ajax-checkbox">
                                                <div class="form-groups">
                                                    <label class="control-label" for="">Check Box Phim cách nhiệt bảo vệ ô tô</label>
        
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input ajax-checkbox @error('check_btn') is-invalid
                                                                @enderror" value="1" data-type="phim cách nhiệt" data-addyear="15" data-time_buy="time_buy" data-time_expires="time_expires" name="check_btn">
                                                        </label>
                                                    </div>
                                                    @error('check_btn')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="old-date-time pl-20"></div>
                                            </div>
    
                                            <div class="warpper-ajax-checkbox">
                                                <div class="form-groups">
                                                    <label class="control-label" for="">Check Box Phủ Ceramic</label>
        
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input ajax-checkbox @error('check_btn2') is-invalid
                                                                @enderror" value="1" data-addyear="2" data-type="bảo vệ bề mặt" data-time_buy="time_buy2" data-time_expires="time_expires2" name="check_btn2">
                                                        </label>
                                                    </div>
                                                    @error('check_btn2')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="old-date-time pl-20"></div>
                                            </div>
    
                                            <div class="warpper-ajax-checkbox">
                                                <div class="form-groups">
                                                    <label class="control-label" for="">Check Box Phim bảo vệ sơn</label>
        
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input ajax-checkbox @error('check_btn3') is-invalid
                                                                @enderror" value="1" data-addyear="5" data-time_buy="time_buy1" data-time_expires="time_expires1" data-type="bảo vệ sơn" name="check_btn3">
                                                        </label>
                                                    </div>
                                                    @error('check_btn3')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="old-date-time pl-20"></div>
                                            </div>
                                        </div>

                                            
                                            {{-- <div class="form-group">
                                                <label class=" control-label" for="">Sale(%)</label>
                                                <input type="number" min="0"
                                                    class="form-control  @error('sale') is-invalid @enderror"
                                                    value="{{ old('sale') }}" name="sale" placeholder="Nhập sale">

                                                @error('sale')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label" for="">Sản phẩm nổi bật</label>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox"
                                                            class="form-check-input @error('hot') is-invalid @enderror"
                                                            value="1" name="hot"
                                                            @if (old('hot') === '1') {{ 'checked' }} @endif>
                                                    </label>
                                                </div>
                                                @error('hot')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div> --}}

                                            
                                            <div class="form-group">
                                                <label class="control-label" for="">Trạng thái</label>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" value="1"
                                                            name="active"
                                                            @if (old('active') === '1' || old('active') === null) {{ 'checked' }} @endif>Hiện
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" value="0"
                                                            @if (old('active') === '0') {{ 'checked' }} @endif
                                                            name="active">Ẩn
                                                    </label>
                                                </div>
                                                @error('active')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                          {{--  <div class="form-group">
                                                <label class="control-label" for="">Bán chạy</label>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox"
                                                            class="form-check-input @error('ban_chay') is-invalid @enderror"
                                                            value="1" name="ban_chay"
                                                            @if (old('ban_chay') === '1') {{ 'checked' }} @endif>
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

                                                @foreach ($attributes as $key => $attribute)

                                                    <div class="form-group">
                                                        <label class="control-label" for="">{{ $attribute->name }}</label>
                                                        <select class="form-control"  name="attribute[]" >
                                                            <option value="0">--Chọn--</option>
                                                            @foreach ($attribute->childs()->orderby('order')->get() as $k => $attr)
                                                                <option value="{{ $attr->id }}" @if (old('attribute')) {{ $attr->id== old('attribute')[$key]?'selected':"" }} @endif>{{ $attr->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('attribute.' . $key)
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                            <hr> --}}
                                        </div>
                                    </div>

                                </div>
                                {{-- <div class="col-md-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Các lựa chọn affliate</h3>
                                        </div>
                                        <div class="card-body table-responsive p-3">
                                            <div class="">Thêm option <a
                                                    data-url="{{ route('admin.product.loadOptionProduct') }}"
                                                    class="btn  btn-info btn-md float-right " id="addOptionProduct">+ Thêm
                                                    option</a></div>
                                            <div class="list-item-option wrap-option mt-3 row" id="wrapOption">
                                                @if (old('supplier_idOption') && old('supplier_idOption'))
                                                    @foreach (old('supplier_idOption') as $key => $value)
                                                        <div class="col-md-4 col-sm-6 col-12 col-item-price">
                                                            <div class="item-price">
                                                                <div class="box-content-price">
                                                                    <div class="form-group">
                                                                        <label class="control-label" for="">Chọn
                                                                            nhà cung
                                                                            cấp</label>
                                                                        <select
                                                                            class="form-control  @error('supplier_idOption') is-invalid @enderror"
                                                                            name="supplier_idOption[]">
                                                                            <option value="">Chon nhà cung cấp
                                                                            </option>
                                                                            @if (isset($supplier) && $supplier)
                                                                                @foreach ($supplier as $item)
                                                                                    <option value="{{ $item->id }}"
                                                                                        {{ old('supplier_idOption')[$key] == $item->id ? 'selected' : '' }}>
                                                                                        {{ $item->name }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                        @error('supplier_idOption.' . $key)
                                                                            <div class="invalid-feedback d-block">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label" for="">Đường
                                                                            dẫn</label>
                                                                        <input type="text" min="0"
                                                                            class="form-control  @error('slugOption.' . $key) is-invalid @enderror"
                                                                            value="{{ old('slugOption')[$key] }}"
                                                                            name="slugOption[]"
                                                                            placeholder="Nhập đường dẫn">
                                                                        @error('slugOption.' . $key)
                                                                            <div class="invalid-feedback d-block">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label" for="">Nhập
                                                                            giá</label>
                                                                        <input type="number"
                                                                            class="form-control  @error('priceOption.' . $key) is-invalid @enderror"
                                                                            value="{{ old('priceOption')[$key] }}"
                                                                            name="priceOption[]" placeholder="Nhập giá">
                                                                        @error('priceOption.' . $key)
                                                                            <div class="invalid-feedback d-block">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="action">
                                                                    <a class="btn btn-sm btn-danger deleteOptionProduct"><i
                                                                            class="far fa-trash-alt"></i></a>
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


@endsection
@section('js')

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
            // beforeSend: function () {
            //     $('.group-checkbox').hide();
            // },
            success: function(data) {
                let html = data.data;
                $('#resultAttributes'+ id).html(html);
            }
        });
    });

    // $(document).on("click", ".change-attr-child", function() {
    //     if ($(this).prop('checked')) {
    //         $('.group-checkbox').hide();
    //     }else{
    //         $('.group-checkbox').show();
    //     }
    // });

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
    // $(document).on('change', '#city', function() {
    //     let urlRequest = $(this).data("url");
    //     let mythis = $(this);
    //     let value = $(this).val();
    //     let defaultCity = "<option value=''>Chọn thành phố</option>";
    //     let defaultDistrict = "<option value=''>Chọn quận huyện</option>";
    //     if (!value) {
    //         $('#district').html(defaultDistrict);
    //     } else {
    //         $.ajax({
    //             type: "GET",
    //             url: urlRequest,
    //             data: { 'cityId': value },
    //             success: function(data) {
    //                 if (data.code == 200) {
    //                     let html = defaultDistrict + data.data;
    //                     $('#district').html(html);
    //                 }
    //             }
    //         });
    //     }
    // });
</script>



@endsection
