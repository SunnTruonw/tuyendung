@extends('admin.layouts.main')
@section('title',"thêm sản phẩm")

@section('css')
<link href="{{asset('lib/select2/css/select2.min.css')}}" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #000 !important;
    }

    .select2-container .select2-selection--single {
        height: auto;
    }
</style>
@endsection
@section('content')


<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>"Product","key"=>"Thêm sản phẩm"])

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(session()->has("alert"))
                    <div class="alert alert-success">
                        {{session()->get("alert")}}
                    </div>
                    @elseif(session()->has('error'))
                    <div class="alert alert-warning">
                        {{session("error")}}
                    </div>
                    @endif
                    <form action="{{route('admin.product.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                       <h3 class="card-title">Thông tin sản phẩm</h3>
                                    </div>
                                    <div class="card-body table-responsive p-3">
                                        <div class="form-group">
                                            <label for="">Mã sản phẩm</label>
                                            <input type="text" class="form-control
                                                @error('name') is-invalid @enderror" id="masp" value="{{ old('masp') }}" name="masp" placeholder="Nhập mã sản phẩm" required>
                                            @error('masp')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Tên sản phẩm</label>
                                            <input type="text" class="form-control
                                                @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" name="name" placeholder="Nhập tên sản phẩm">
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Slug</label>
                                            <input type="text" class="form-control
                                            @error('slug') is-invalid  @enderror" id="slug" value="{{ old('slug') }}" name="slug" placeholder="Nhập slug">
                                        </div>
                                        @error('slug')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <label for="">Nhập mô tả</label>
                                            <textarea class="form-control  @error('description') is-invalid @enderror" name="description" id="" rows="3"  placeholder="Nhập mô tả">{{ old('description') }}</textarea>
                                        </div>
                                        @error('description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <label for="">Nhập content</label>
                                            <textarea class="form-control tinymce_editor_init @error('content') is-invalid  @enderror" name="content" id="" rows="3" value="" placeholder="Nhập content">
                                            {{ old('content') }}
                                            </textarea>
                                        </div>
                                        @error('content')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <label for="">Nhập tags</label>
                                            <select class="form-control tag-select-choose" multiple="multiple" name="tags[]">
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Chọn danh muc sản phẩm</label>
                                            <select class="form-control custom-select select-2-init @error('category_id')
                                                is-invalid
                                                @enderror" id="" value="{{ old('category_id') }}" name="category_id">
                                                {{-- <option value="0">Chọn danh mục cha</option> --}}
                                                <option value="">--- Chọn danh mục ---</option>
                                                {!!$option!!}
                                            </select>
                                        </div>
                                        @error('category_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="1" name="active" @if(old('active')==="1" ||old('active')===null) {{'checked'}} @endif>Active
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="0" @if(old('active')==="0" ){{'checked'}} @endif name="active">Disable
                                                </label>
                                            </div>
                                        </div>
                                        @error('active')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" name="checkrobot" id="">
                                            <label class="form-check-label" for="" required>Check me out</label>
                                        </div>
                                        @error('checkrobot')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <button type="reset" class="btn btn-danger">Reset</button>
                                            <button type="submit" class="btn btn-primary">Chấp nhận</button>
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
                                        <div class="wrap-load-image mb-3">
                                            <div class="form-group">
                                                <label for="">Avatar</label>
                                                <input type="file" class="form-control-file img-load-input border @error('avatar_path')
                                                is-invalid
                                                @enderror" id="" name="avatar_path">
                                            </div>
                                            @error('avatar_path')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <img class="img-load border p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" style="height: 200px;object-fit:cover;">
                                        </div>
                                        <div class="wrap-load-image mb-3">
                                            <div class="form-group">
                                                <label for="">Images</label>
                                                <input type="file" class="form-control-file img-load-input border @error('image')
                                                    is-invalid
                                                    @enderror" id="" name="image[]" multiple>
                                            </div>
                                            @error('image')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="load-multiple-img">
                                                <img class="" src="{{asset('admin_asset/images/upload-image.png')}}">
                                                <img class="" src="{{asset('admin_asset/images/upload-image.png')}}">
                                                <img class="" src="{{asset('admin_asset/images/upload-image.png')}}">
                                            </div>
                                         </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="">Price</label>
                                                    <input type="text" class="form-control
                                                @error('price') is-invalid @enderror" id="" value="{{ old('price') }}" name="price" placeholder="Nhập price">
                                                </div>
                                                @error('price')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Sale(%)</label>
                                                    <input type="number" class="form-control @error('sale')
                                                        is-invalid
                                                        @enderror" id="" value="{{ old('sale') }}" name="sale" placeholder="Nhập sale">
                                                </div>
                                                @error('sale')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">Hot
                                                    <input type="checkbox" class="form-check-input @error('hot')
                                                        is-invalid
                                                        @enderror" value="1" name="hot" @if(old('hot')==="1" ) {{'checked'}} @endif>
                                                </label>
                                            </div>
                                        </div>
                                        @error('hot')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        {{-- <div class="form-group">
                                        <label for="">Number</label>
                                        <input type="text" class="form-control" id="" value="{{ old('number') }}" name="number" placeholder="Nhập number">
                                        </div>
                                        @error('number')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror --}}

                                        <div class="form-group">
                                            <label for="">Thời gian bảo hành (tháng)</label>
                                            <input type="text" class="form-control @error('warranty')
                                            is-invalid
                                            @enderror" id="" value="{{ old('warranty') }}" name="warranty" placeholder="Nhập warranty">
                                        </div>
                                        @error('warranty')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        {{-- <div class="form-group">
                                            <label for="">Số lượt xem</label>
                                            <input type="mumber" class="form-control @error('view')
                                            is-invalid
                                            @enderror" id="" value="{{ old('view') }}" name="view" placeholder="Nhập view">
                                        </div>
                                        @error('view')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror --}}

                                        <div class="form-group">
                                            <label for="">Nhập description_seo</label>
                                            <input type="text" class="form-control @error('description_seo') is-invalid @enderror" id="" value="{{ old('description_seo') }}" name="description_seo" placeholder="Nhập description_seo">
                                        </div>
                                        @error('description_seo')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="form-group">
                                            <label for="">Nhập title_seo</label>
                                            <input type="text" class="form-control @error('title_seo') is-invalid @enderror" id="" value="{{ old('title_seo') }}" name="title_seo" placeholder="Nhập title_seo">
                                        </div>
                                        @error('title_seo')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                           </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('js')




@endsection
