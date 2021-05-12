@extends('admin.layouts.main')
@section('title',"Sửa slider")

@section('css')
@endsection
@section('content')
<div class="content-wrapper lb_template_slider_edit">
   @include('admin.partials.content-header',['name'=>"Product","key"=>"Edit product"])
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
               <form action="{{route('admin.slider.update',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                     <div class="col-md-8">
                        <div class="card card-outline card-primary">
                           <div class="card-header">
                              <h3 class="card-title">Thông tin slider</h3>
                           </div>
                           <div class="card-body table-responsive p-3">
                              <div class="form-group">
                                 <label for="">Name</label>
                                 <input
                                    type="text"
                                    class="form-control  @error('name') is-invalid @enderror"
                                    id="name"
                                    value="{{ $data->name }}"
                                    name="name"
                                    placeholder="Nhập tên slider"
                                    >
                                 @error('name')
                                 <div class="alert alert-danger">{{ $message }}</div>
                                 @enderror
                              </div>
                              <div class="form-group">
                                 <label for="">Slug</label>
                                 <input type="text"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    id="slug"
                                    value="{{ $data->slug }}"
                                    name="slug"
                                    placeholder="Nhập slug"
                                    >
                              </div>
                              @error('slug')
                              <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                              <div class="form-group">
                                 <label for="">Nhập mô tả</label>
                                 <textarea
                                    class="form-control tinymce_editor_init"
                                    name="description" id="" rows="4"
                                    placeholder="Nhập description">
                                 {{ $data->description }}
                                 </textarea>
                              </div>
                              @error('description')
                              <div class="alert alert-danger">{{ $message }}</div>
                              @enderror

                              <div class="form-group">
                                 <div class="form-check-inline">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="1" name="active" @if( $data->active ==="1"||old('active')===null||old('active')==="1") {{'checked'}}  @endif>Active
                                    </label>
                                 </div>
                                 <div class="form-check-inline">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="0" @if($data->active==="0"){{'checked'}}  @endif name="active">Disable
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
                                 <button type="submit" class="btn btn-primary">Submit</button>
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
                                <div class="wrap-load-image">
                                    <div class="form-group">
                                        <label for="">Image</label>
                                        <input
                                           type="file"
                                           class="form-control-file img-load-input border"
                                           id=""
                                           name="image_path"
                                           >
                                     </div>
                                     @error('image_path')
                                     <div class="alert alert-danger">{{ $message }}</div>
                                     @enderror
                                     <img class="img-load border p-1 w-100" src="{{$data->image_path}}" alt="{{$data->name}}" style="height: 200px;object-fit:cover;">
                                </div>
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
