@extends('admin.layouts.main')
@section('title',"Sửa  danh mục bài viết")
@section('css')

@endsection

@section('content')

<div class="content-wrapper lb_template_categorypost_edit">
    @include('admin.partials.content-header',['name'=>"Danh mục bài viết","key"=>"Sửa danh mục bài viết"])

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
                    <form class="form-horizontal" action="{{route('admin.categorypost.update',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
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
                            <div class="col-md-12">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Thông tin danh mục sản phẩm</h3>
                                    </div>
                                    <div class="card-body table-responsive p-3">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#tong_quan">Tổng quan</a>
                                            </li>
                                            <li class="nav-item">
                                             <a class="nav-link" data-toggle="tab" href="#hinh_anh">Hình ảnh</a>
                                            </li>
                                            <li class="nav-item">
                                             <a class="nav-link" data-toggle="tab" href="#seo">Seo</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <!-- START Tổng Quan -->
                                            <div id="tong_quan" class="container tab-pane active"><br>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Tên danh mục</label>
                                                        <div class="col-sm-10">
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="name"
                                                                value="{{old('name')?? $data->name }}"
                                                                name="name"
                                                                placeholder="Nhập tên danh mục"
                                                                required="required"
                                                            >
                                                        </div>
                                                    </div>
                                                    @error('name')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Slug</label>
                                                        <div class="col-sm-10">
                                                            <input
                                                                type="text"
                                                                class="form-control lb_load_slug"
                                                                id="slug"
                                                                value="{{old('slug')?? $data->slug }}"
                                                                name="slug"
                                                                placeholder="Nhập slug"
                                                                required="required"
                                                            >
                                                        </div>
                                                    </div>
                                                    @error('slug')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Nhập giới thiệu</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control  @error('description') is-invalid @enderror" name="description" id="" rows="4"  placeholder="Nhập mô tả">{{old('description')?? $data->description }}</textarea>
                                                        </div>
                                                    </div>

                                                    @error('description')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Nhập nội dung</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control tinymce_editor_init @error('content') is-invalid  @enderror" name="content" id="" rows="20" placeholder="Nhập nội dung">
                                                            {{old('content')?? $data->content }}
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    @error('content')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Chọn danh mục cha</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control custom-select" id="" name="parentId">
                                                                <option value="0">Chọn danh mục cha</option>
                                                                @if (old('parent_id')||old('parent_id')==='0')
                                                                {!! \App\Models\CategoryPost::getHtmlOptionAddWithParent(old('parent_id')) !!}
                                                                @else
                                                                {!!$option!!}
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @error('parentId')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Số thứ tự</label>
                                                        <div class="col-sm-10">
                                                            <input
                                                                type="number"
                                                                class="form-control"
                                                                value="{{old('order')??  $data->order }}"
                                                                name="order"
                                                                placeholder="Nhập số thứ tự"
                                                            >
                                                        </div>
                                                    </div>
                                                    @error('order')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Trạng thái</label>
                                                        <div class="col-sm-10">
                                                            <div class="form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="radio" class="form-check-input" value="1" name="active" @if( (old('active')??$data->active)=="1") {{'checked'}} @endif >
                                                                    Hiện
                                                                </label>
                                                            </div>
                                                            <div class="form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="radio" class="form-check-input" value="0" @if((old('active')?? $data->active)=="0"){{'checked'}} @endif name="active">
                                                                    Ẩn
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @error('active')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

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
                                                        <label for="">icon</label>
                                                        <input type="file" class="form-control-file img-load-input border" id="" value="" name="icon_path">
                                                    </div>
                                                    @error('icon_path')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                    <img class="img-load border p-1 w-30" src="{{asset($data->icon_path)}}" alt="{{$data->name}}" style="height: 80px;object-fit:cover; max-width: 260px;">
                                                </div>
                                                <div class="wrap-load-image mb-3">
                                                    <div class="form-group">
                                                        <label for="">avatar</label>
                                                        <input type="file" class="form-control-file img-load-input" id="" value="" name="avatar_path">
                                                    </div>
                                                    @error('avatar_path')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                    <img class="img-load border p-1 w-100" src="{{asset($data->avatar_path)}}" alt="{{$data->name}}" style="height: 170px;object-fit:cover; max-width: 260px;">
                                                </div>
                                            </div>
                                            <!-- END Hình Ảnh -->

                                            <!-- START Seo -->
                                            <div id="seo" class="container tab-pane fade"><br>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Nhập title seo</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control @error('title_seo') is-invalid @enderror" id="" value="{{old('title_seo')?? $data->title_seo }}" name="title_seo" placeholder="Nhập title seo">
                                                        </div>
                                                    </div>
                                                    @error('title_seo')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Nhập mô tả seo</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control @error('description_seo') is-invalid @enderror" id="" value="{{old('description_seo')?? $data->description_seo }}" name="description_seo" placeholder="Nhập mô tả seo">
                                                        </div>
                                                    </div>
                                                    @error('description_seo')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Nhập từ khóa seo</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control @error('keyword_seo') is-invalid @enderror" id="" value="{{old('keyword_seo')?? $data->keyword_seo }}" name="keyword_seo" placeholder="Nhập từ khóa seo">
                                                        </div>
                                                    </div>
                                                    @error('keyword_seo')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!-- END Seo -->

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
@endsection
@section('js')
<script>
    $(document).on('change', '.img-load-input',function(){
        let input=$(this);
        displayImage(input,'.wrap-load-image','.img-load');
    });
    $(document).on('change keyup', '#name',function(){
        let name=$(this).val();
        $('#slug').val(ChangeToSlug(name));
    });

    // function display image when upload file
    // paramter selectorWrap slector thẻ bọc của image và input
    // paramter selectorImg slector thẻ bọc của image
    function displayImage(input,selectorWrap,selectorImg) {
        let img= input.parents(selectorWrap).find(selectorImg);
        let  file = input.prop('files')[0];
        let reader = new FileReader();

        reader.addEventListener("load", function () {
            // convert image file to base64 string
            img.attr('src',reader.result);
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    // function convert slug
    function ChangeToSlug(title)
    {
       // title = document.getElementById("title").value;
        //Đổi chữ hoa thành chữ thường
        let slug = title.toLowerCase();
        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        //Xóa các ký tự đặt biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        return slug;
    }
</script>
@endsection
