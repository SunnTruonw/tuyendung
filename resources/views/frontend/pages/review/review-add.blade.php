@extends('frontend.layouts.main-profile')
@section('title',"Viết review")
@section('css')
<style>
    .card{
        font-size: 14px;
		font-weight: 600;
		color: #333;
    }
    textarea,input,select{
        font-size: 14px !important;
    }
    .alert {
        font-size: 13px;
    }
	.select2-container--default .select2-selection--single .select2-selection__rendered {
		color: #333;
		font-weight: 400;
		padding: 0 20px;
		line-height: 35px;
	}
	.select2-container--default .select2-selection--single {
		height: 35px;
		color: #333;
	}
	.select2-results__option {
		padding: 2px 20px;
		font-size: 13px;
	}
	.alert-info {
		color: #333;
		background-color: #eee;
		border-color: #eee;
	}
	.btn-primary {
		margin-top: 20px;
		background: #e90000;
		padding: 5px 20px;
		color: #fff;
		border-radius:0;
		border: none;
		font-weight: 600;
		font-size: 15px;
	}
	.btn-danger {
		margin-top: 20px;
		background: #ccc;
		padding: 5px 20px;
		color: #333;
		border-radius:0;
		border: none;
		font-weight: 600;
		font-size: 15px;
	}
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content">

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
                    <form action="{{route('profile.storeReview')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="title-h">
                                    <span>Đăng review</span>
                                </div>
                                {{-- <div class="alert alert-info">
                                    - Để nâng cấp chất lượng nội dung tin rao bất động sản, chúng tôi tiến hành duyệt toàn bộ tin rao đăng mới. <br>
                                    - Tin rao đúng sẽ được duyệt chậm nhất trong vòng 9h làm việc.
                                </div> --}}
                                @if ($errors->count())
                                <div class="card-header">
                                    @foreach ($errors->all() as $message)
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @endforeach
                                 </div>
                                @endif
                                 <div class="text-right">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Đăng review</button>
                                        <button type="reset" class="btn btn-danger">Nhập lại</button>
                                    </div>
                                 </div>
                                <div class="card card-outline card-primary">
                                    <div class="card-body table-responsive p-3">
                                        <div class="form-group">
                                            <label class="" for="">Tiêu đề review sách</label>
                                            <input type="text" class="form-control
                                             @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" name="name" placeholder="Tiêu đề review">
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                         <div class="form-group">
                                            <label class="" for="">Đường dẫn review</label>
                                            <input  type="text" class="form-control
                                            @error('slug') is-invalid  @enderror" id="slug" value="{{ old('slug') }}" name="slug" placeholder="Nhập đường dẫn">
                                            @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="" for="">Đường dẫn sách</label>
                                            <input  type="text" class="form-control
                                            @error('link') is-invalid  @enderror"  value="{{ old('link') }}" name="link" placeholder="Nhập đường dẫn sách">
                                            @error('link')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            {{-- <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="">Chọn danh mục </label>
                                                    <select class="form-control  @error('category_id')
                                                        is-invalid
                                                        @enderror" id=""
                                                        required
                                                        value=""
                                                        name="category_id">
                                                        <option value="">--- Chọn danh mục ---</option>
                                                        @if (old('category_id'))
                                                            {!! \App\Models\CategoryProduct::getHtmlOption(old('category_id')) !!}
                                                        @else
                                                        {!!$option!!}
                                                        @endif
                                                    </select>
                                                </div>
                                                @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div> --}}

                                        </div>

                                        <div class="form-group">
                                            <label class="" for="">Nhập giới thiệu ngắn</label>
                                            <textarea class="form-control  @error('description') is-invalid @enderror" name="description" id="" rows="3"  placeholder="Nhập giới thiệu">{{ old('description') }}</textarea>
                                        </div>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        <div class="form-group">
                                            <label class="" for="">Nhập nội dung review</label>
                                            <textarea class="form-control tinymce_editor_init @error('content') is-invalid  @enderror" name="content" id="" rows="20" value="" placeholder="Nhập nội dung review"> {{ old('content') }}</textarea>
                                            @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- <div class="form-group">

                                            <label class="control-label" for="">Nhập title seo</label>
                                            <input type="text" class="form-control @error('title_seo') is-invalid @enderror" id="" value="{{ old('title_seo') }}" name="title_seo" placeholder="Nhập title seo">
                                            @error('title_seo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label" for="">Nhập mô tả seo</label>
                                            <input type="text" class="form-control @error('description_seo') is-invalid @enderror" id="" value="{{ old('description_seo') }}" name="description_seo" placeholder="Nhập mô tả seo">
                                            @error('description_seo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="">Nhập từ khóa seo</label>
                                            <input type="text" class="form-control @error('keyword_seo') is-invalid @enderror" id="" value="{{ old('keyword_seo') }}" name="keyword_seo" placeholder="Nhập từ khóa seo">
                                            @error('keyword_seo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div> --}}
										<div class="row">
                                            <div class="col-md-5">
												<div class="wrap-load-image mb-3">
													<div class="form-group">
														<label for="">Ảnh đại diện</label>
														<input type="file" class="form-control-file img-load-input border @error('avatar_path')
														is-invalid
														@enderror" id="" name="avatar_path">
													</div>
													@error('avatar_path')
													<div class="invalid-feedback">{{ $message }}</div>
													@enderror
													<img class="img-load border p-1 w-100" src="{{asset('admin_asset/images/upload-image.png')}}" style="height: 200px;object-fit:contain;">
												</div>
											</div>
											<div class="col-md-7">
												<div class="wrap-load-image mb-3">
													<div class="form-group">
														<label for="">Ảnh liên quan</label>
														<input type="file" class="form-control-file img-load-input border @error('image')
															is-invalid
															@enderror" id="" name="image[]" multiple>
													</div>
													@error('image')
													<div class="invalid-feedback">{{ $message }}</div>
													@enderror
													<div class="load-multiple-img">
														<img class="" src="{{asset('admin_asset/images/upload-image.png')}}">
														<img class="" src="{{asset('admin_asset/images/upload-image.png')}}">
														<img class="" src="{{asset('admin_asset/images/upload-image.png')}}">
													</div>
												 </div>
											</div>
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
@endsection
@section('js')

<script type="text/javascript">
    function changePrice(){
        var value = $('#price').val();

        value = value.replace(',', ".");

        $('#price').val(value);
    }
</script>



<script src="{{asset('lib/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
{{-- <script src="{{asset('lib/tinymce5/js/tinymce.min.js')}}"></script> --}}
<script src="https://cdn.tiny.cloud/1/si5evst7s8i3p2grgfh7i5gdsk2l26daazgefvli0hmzapgn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
{{-- <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script> --}}
<script src="{{asset('lib/select2/js/select2.min.js')}}"></script>
<script src="{{asset('admin_asset/ajax/deleteAdminAjax.js')}}"></script>
<script src="{{asset('admin_asset/js/function.js')}}"></script>
<script src="{{ asset('frontend/js/load-address.js') }}"></script>


<script>

    // js tinymce
    let editor_config = {
        path_absolute: "/",
        selector: 'textarea.tinymce_editor_init',
        relative_urls: false,
        plugins: [
            "advlist autolink lists link  charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime  nonbreaking save table directionality",
            "emoticons template paste textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link ",
        file_picker_callback: function(callback, value, meta) {
            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            let cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
            if (meta.filetype == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.openUrl({
                url: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no",
                onMessage: (api, message) => {
                    callback(message.content);
                }
            });
        }
    };
    if ($("textarea.tinymce_editor_init").length) {
        tinymce.init(editor_config);
    }

    // end  tinymce


      // js load áº£nh khi upload
    $(document).on('change', '.img-load-input', function() {
        let input = $(this);
        displayImage(input, '.wrap-load-image', '.img-load');
    });
    // js load nhiá»u áº£nh khi upload
    $(document).on('change', '.img-load-input', function() {
        let input = $(this);
        displayMultipleImage(input, '.wrap-load-image', '.load-multiple-img');
    });
    // end js load áº£nh khi upload

        // js create select tag
    $(".tag-select-choose").select2({
        tags: true,
        tokenSeparators: [','],
    });
    $(".select-2-init").select2({
        placeholder: "--- Chọn danh mục ---",
        allowClear: true,
    });
    // end create select tag
     // js render slug khi nhập tên
     $(document).on('change keyup', '#name', function() {
        let name = $(this).val();
        $('#slug').val(ChangeToSlug(name));
    });
    // end js render slug khi nhập tên


    // load category child

    $(document).on('change', '#typeGD', function() {
        let urlRequest = $(this).data("url");
        let mythis = $(this);
        let value = $(this).val();
        let defaultCategoryChild = "<option value=''>Chọn danh mục</option>";
        if (!value) {
            $('#categoryChild').html(defaultCategoryChild);
        } else {
            $.ajax({
                type: "GET",
                url: urlRequest,
                data: { 'id': value },
                success: function(data) {
                    if (data.code == 200) {
                        let html = defaultCategoryChild + data.html;
                        $('#categoryChild').html(html);
                    }
                }
            });
        }
    })
</script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker').datetimepicker({
            locale: 'vi',
            format:'d/m/Y H:i',
            formatTime:'H:i',
            formatDate:'d/m/Y',
        });
    });
</script>
@endsection
