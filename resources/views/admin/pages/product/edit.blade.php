@extends('admin.layouts.main')
@section('title',"Sửa sản phẩm")

@section('css')
@endsection
@section('content')
<div class="content-wrapper lb_template_product_edit">
    @include('admin.partials.content-header',['name'=>"Sản phẩm","key"=>"Sửa sản phẩm"])

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
                    <form action="{{route('admin.product.update',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
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
                                            <input type="text" class="form-control" id="masp" value="{{ $data->masp }}" name="masp" placeholder="Nhập mã sản phẩm">
                                            @error('masp')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Tên sản phẩm</label>
                                            <input type="text" class="form-control" id="name" value="{{ $data->name }}" name="name" placeholder="Nhập tên sản phẩm">
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">slug</label>
                                            <input type="text" class="form-control" id="slug" value="{{ $data->slug }}" name="slug" placeholder="Nhập slug">
                                        </div>
                                        @error('slug')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <label for="">Nhập mô tả</label>
                                            <textarea class="form-control" name="description" id="" rows="4" placeholder="Nhập mô tả">{{ $data->description }}</textarea>
                                        </div>
                                        @error('description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <label for="">Nhập content</label>
                                            <textarea class="form-control tinymce_editor_init" name="content" id="" rows="7" placeholder="Nhập content">{{ $data->content }}</textarea>
                                        </div>
                                        @error('content')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="form-group">
                                            <label for="">Nhập tags</label>
                                            <select class="form-control tag-select-choose" multiple="multiple" name="tags[]">
                                                @foreach($data->tags as $tagItem)
                                                <option value="{{$tagItem->name}}" selected>{{$tagItem->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Chọn danh muc sản phẩm</label>
                                            <select class="form-control custom-select select-2-init" id="" name="category_id">
                                                {{-- <option value="0">Chọn danh mục cha</option> --}}
                                                <option value="">Chọn danh mục</option>
                                                {!!$option!!}
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="1" name="active" @if( $data->active=="1"||old('active')=="1") {{'checked'}} @endif>Active
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="0" @if( $data->active=="0"||old('active')=="0"){{'checked'}} @endif name="active">Disable
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
                                                <input type="file" class="form-control-file img-load-input border" id="" name="avatar_path">
                                            </div>
                                            @error('avatar_path')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <img class="img-load border p-1 w-100" src="{{$data->avatar_path}}" alt="{{$data->name}}" style="height: 200px;object-fit:cover;">
                                        </div>
                                        <div class="wrap-load-image mb-3">
                                            <div class="form-group">
                                                <label for="">Images</label>
                                                <input type="file" class="form-control-file img-load-input border" id="" name="image[]" multiple>
                                            </div>
                                            @error('image')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="load-multiple-img">
                                                @foreach($data->images()->get() as $productImageItem)
                                                   <img class="" src="{{$productImageItem->image_path}}" alt="{{$productImageItem->name}}">
                                                @endforeach
                                                @if (!$data->images()->get()->count())
                                                <img class="" src="{{asset('admin_asset/images/upload-image.png')}}" alt="'no image">
                                                <img class="" src="{{asset('admin_asset/images/upload-image.png')}}" alt="'no image">
                                                <img class="" src="{{asset('admin_asset/images/upload-image.png')}}" alt="'no image">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="">Price</label>
                                                    <input type="text" class="form-control" id="" value="{{ $data->price }}" name="price" placeholder="Nhập slug">
                                                </div>
                                                @error('price')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Sale(%)</label>
                                                    <input type="number" class="form-control" id="" value="{{ $data->sale }}" name="sale" placeholder="Nhập sale">
                                                </div>
                                                @error('sale')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">Hot
                                                    <input type="checkbox" class="form-check-input" value="1" name="hot" @if( $data->hot ===1) {{'checked'}} @endif>
                                                </label>
                                            </div>
                                        </div>
                                        @error('hot')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="form-group">
                                            <label for="">Thời gian bảo hành (tháng)</label>
                                            <input type="text" class="form-control" id="" value="{{ $data->warranty }}" name="warranty" placeholder="Nhập warranty">
                                        </div>
                                        @error('warranty')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="form-group">
                                            <label for="">Nhập description_seo</label>
                                            <input type="text" class="form-control" id="" value="{{ $data->description_seo }}" name="description_seo" placeholder="Nhập description_seo">
                                        </div>
                                        @error('description_seo')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="form-group">
                                            <label for="">Nhập title_seo</label>
                                            <input type="text" class="form-control" id="" value="{{ $data->title_seo }}" name="title_seo" placeholder="Nhập title_seo">
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
