@extends('admin.layouts.main')
@section('title',"Sửa bài viêt")

@section('css')
@endsection
@section('content')
<div class="content-wrapper lb_template_post_edit">
    @include('admin.partials.content-header',['name'=>"Bài viết","key"=>"Sửa bài viết"])

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
                    <form class="form-horizontal" action="{{route('admin.post.update',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
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
                                       <h3 class="card-title">Thông tin bài viết</h3>
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
                                           <li class="nav-item">
                                             <a class="nav-link" data-toggle="tab" href="#seo">Seo</a>
                                           </li>
                                        </ul>


                                        <div class="tab-content">
                                            <!-- START Tổng Quan -->
                                            <div id="tong_quan" class="container tab-pane active"><br>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="col-sm-2 control-label" for="">Tên bài viết</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control
                                                                @error('name') is-invalid @enderror" id="name" value="{{old('name')?? $data->name }}" name="name" placeholder="Nhập tên bài viết">
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
                                                             <input type="text" class="form-control
                                                             @error('slug') is-invalid  @enderror" id="slug" value="{{old('slug')?? $data->slug }}" name="slug" placeholder="Nhập slug">
                                                         </div>
                                                     </div>
                                                     @error('slug')
                                                     <div class="alert alert-danger">{{ $message }}</div>
                                                     @enderror
                                                 </div>
                                                <div class="form-group">
                                                   <div class="row">
                                                      <label class="col-sm-2 control-label" for="">Nhập mô tả</label>
                                                      <div class="col-sm-10">
                                                         <textarea class="form-control  @error('description') is-invalid @enderror" name="description" id="" rows="8" value="" placeholder="Nhập mô tả">{{old('description')?? $data->description }}</textarea>
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
                                                        <textarea class="form-control tinymce_editor_init @error('content') is-invalid  @enderror" name="content" id="" rows="20" value="" placeholder="Nhập content">
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
                                                      <label class="col-sm-2 control-label" for="">Chọn danh mục</label>
                                                      <div class="col-sm-10">
                                                        <select class="form-control custom-select select-2-init @error('category_id') is-invalid  @enderror" id="" name="category_id">
                                                            <option value="">Chọn danh mục</option>
                                                            @if (old('category_id')||old('category_id')==='0')
                                                                {!! \App\Models\CategoryPost::getHtmlOption(old('category_id')) !!}
                                                            @else
                                                               {!!$option!!}
                                                            @endif
                                                        </select>
                                                      </div>
                                                   </div>
                                                   @error('category_id')
                                                   <div class="alert alert-danger">{{ $message }}</div>
                                                   @enderror
                                                </div>

                                                <div class="form-group">
                                                   <div class="row">
                                                      <label class="col-sm-2 control-label" for="">Tình trạng</label>
                                                      <div class="col-sm-10">
                                                         <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input" value="1" name="active" @if( (old('active')??$data->active)=="1") {{'checked'}} @endif>Hiện
                                                            </label>
                                                         </div>
                                                         <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input" value="0" @if( (old('active')??$data->active)=="0"){{'checked'}} @endif name="active">Ẩn
                                                            </label>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   @error('active')
                                                   <div class="alert alert-danger">{{ $message }}</div>
                                                   @enderror
                                                </div>

                                                <div class="form-group">
                                                   <div class="row">
                                                      <label class="col-sm-2 control-label" for=""></label>
                                                      <div class="col-sm-10">
                                                         <div class="form-check-inline">
                                                            <label class="form-check-label">
                                                               <input type="checkbox" class="form-check-input
                                                                    @error('hot') is-invalid @enderror" value="1" name="hot" @if( $data->hot ==1) {{'checked'}} @endif
                                                                >
                                                               Tin nổi bật
                                                            </label>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   @error('hot')
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
                                                      <label for="">Avatar</label>
                                                      <input type="file" class="form-control-file img-load-input  border" id="" name="avatar_path">
                                                   </div>
                                                   <img class="img-load border p-1 w-100" src="{{$data->avatar_path}}" alt="{{$data->name}}" style="height: 200px;object-fit:cover; max-width: 260px">
                                                </div>
                                                @error('avatar_path')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
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

                                                <div class="form-group">
                                                   <div class="row">
                                                      <label class="col-sm-2 control-label" for="">Nhập tags</label>
                                                      <div class="col-sm-10">
                                                         <select class="form-control tag-select-choose" multiple="multiple" name="tags[]">
                                                            @foreach($data->tags as $tagItem)
                                                            <option value="{{$tagItem->name}}" selected>{{$tagItem->name}}</option>
                                                            @endforeach
                                                        </select>
                                                      </div>
                                                   </div>
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
@endsection
