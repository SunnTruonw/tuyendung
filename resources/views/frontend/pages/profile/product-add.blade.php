@extends('frontend.layouts.main-profile')
@section('title',"Thêm đại lý")
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
		margin-top: 0px;
		background: #299eda;
		padding: 10px 30px;
		color: #fff;
		border-radius:0;
		border: none;
		font-weight: 600;
		font-size: 15px;
		text-transform: uppercase;
	}
	.btn-danger {
		margin-top: 0px;
		background: #ccc;
		padding: 12px 30px;
		color: #333;
		border-radius:0;
		border: none;
		font-weight: 600;
		font-size: 15px;
		text-transform: uppercase;
	}
	.title-h {
		text-align: left;
		text-transform: uppercase;
		color: #333;
		font-size: 18px;
		font-weight: 600;
		padding: 10px;
		margin-bottom: 20px;
		background: #eee;
	}
	.form-group {
		width: 48%;
		margin-right: 2%;
		float: left;
	}
	.form-group1 {
		width: 100%;
		margin-bottom: 20px;
	}
	.form-control {
		border-radius:0;
	}
	.card-body {
		border:none;
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
                    <form action="{{route('profile.storeProduct')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="title-h">
                                    <span>Đăng MÃ BẢO HÀNH</span>
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
                                <div class="card card-outline card-primary">
                                    <div class="card-body table-responsive p-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control
                                             @error('name_chunha') is-invalid @enderror"  value="{{ old('name_chunha') }}" name="name_chunha" placeholder="Họ tên">
                                            @error('name_chunha')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                         <div class="form-group">
                                            <input  type="text" class="form-control
                                            @error('masp') is-invalid  @enderror"  value="{{ old('masp') }}" name="masp" placeholder="Số khung">
                                            @error('masp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input  type="text" class="form-control
                                            @error('phone_chunha') is-invalid  @enderror"  value="{{ old('phone_chunha') }}" name="phone_chunha" placeholder="Điện thoại">
                                            @error('phone_chunha')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input  type="text" class="form-control
                                            @error('type_car') is-invalid  @enderror"  value="{{ old('type_car') }}" name="type_car" placeholder="Loại xe">
                                            @error('type_car')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input  type="text" class="form-control
                                            @error('bienkiemsoat') is-invalid  @enderror"  value="{{ old('bienkiemsoat') }}" name="bienkiemsoat" placeholder="Biển kiểm soát">
                                            @error('bienkiemsoat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input  type="text" class="form-control
                                            @error('rollid') is-invalid  @enderror"  value="{{ old('rollid') }}" name="rollid" placeholder="Rollid">
                                            @error('rollid')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group ">
                                            <label  for="">Tỉnh/Thành phố</label>

                                                <select name="city_id" id="city" class="form-control" required="required" data-url="{{ route('ajax.address.districts') }}">
                                                    <option value="">Chọn tỉnh/thành phố</option>
                                                    {!! $cities !!}
                                                </select>

                                        </div>

                                        <div class="form-group">
                                            <label class="" for="">Ngày bắt đầu bảo hành</label>
                                            <input  type="date" class="form-control
                                            @error('time_buy') is-invalid  @enderror"  value="{{ old('time_buy')??Carbon::now()->format('Y-m-d') }}" name="time_buy" placeholder="ngày mua">
                                            @error('time_buy')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="" for="">Ngày hết hạn bảo hành</label>
                                            <input  type="date" class="form-control
                                            @error('time_expires') is-invalid  @enderror"  value="{{ old('time_expires')??Carbon::now()->addYears(16)->format('Y-m-d') }}" name="time_expires" placeholder="ngày bán">
                                            @error('time_expires')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group1">
                                            <input  type="text" class="form-control
                                            @error('address_chunha') is-invalid  @enderror"  value="{{ old('address_chunha') }}" name="address_chunha" placeholder="Địa chỉ">
                                            @error('address_chunha')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- <div class="form-group">
                                            <label class="" for="">Nhập giới thiệu</label>
                                            <textarea class="form-control  @error('description') is-invalid @enderror" name="description" id="" rows="3"  placeholder="Nhập giới thiệu">{{ old('description') }}</textarea>

                                        </div>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror --}}

                                        <div class="form-group1">
                                            <label class="" for="">Nhập nội dung</label>
                                            <textarea class="form-control tinymce_editor_init @error('content') is-invalid  @enderror" name="content" id="" rows="20" value="" placeholder="Nhập nội dung"> {{ old('content') }}</textarea>
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
										{{-- <div class="row">
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
										</div> --}}


                                        {{-- <div class="form-group">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">Sản phẩm hot
                                                    <input type="checkbox" class="form-check-input @error('hot')
                                                        is-invalid
                                                        @enderror" value="1" name="hot" @if(old('hot')==="1" ) {{'checked'}} @endif>
                                                </label>
                                            </div>
                                        </div>
                                        @error('hot')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror --}}
                                        {{-- <div class="form-group">
                                        <label for="">Number</label>
                                        <input type="text" class="form-control" id="" value="{{ old('number') }}" name="number" placeholder="Nhập number">
                                        </div>
                                        @error('number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror --}}
                                        {{-- <div class="form-group" style="display: none">
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="1" name="active" @if(old('active')==="1" ||old('active')===null) {{'checked'}} @endif>Hiện
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" value="0" @if(old('active')==="0" ){{'checked'}} @endif name="active">Ẩn
                                                </label>
                                            </div>
                                        </div>
                                        @error('active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror --}}
                                        {{-- <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" name="checkrobot" id="" required>
                                            <label class="form-check-label" for="" required>{{ $thongBaoTruTienDangTin }}</label>
                                        </div>
                                        @error('checkrobot')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror --}}





                                        {{-- <div class="form-group">
                                            <label for="">Mã sản phẩm</label>
                                            <input type="text" class="form-control
                                                @error('name') is-invalid @enderror" id="masp" value="{{ old('masp') }}" name="masp" placeholder="Nhập mã sản phẩm" required>
                                            @error('masp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="">Thời gian bảo hành (tháng)</label>
                                            <input type="text" class="form-control @error('warranty')
                                            is-invalid
                                            @enderror" id="" value="{{ old('warranty') }}" name="warranty" placeholder="Nhập thời gian">
                                        </div>
                                        @error('warranty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror --}}

                                        {{-- <div class="form-group">
                                            <label for="">Số lượt xem</label>
                                            <input type="mumber" class="form-control @error('view')
                                            is-invalid
                                            @enderror" id="" value="{{ old('view') }}" name="view" placeholder="Nhập view">
                                        </div>
                                        @error('view')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror --}}



                                        {{-- <div class="form-group">
                                            <label for="">Nhập tags</label>
                                            <select class="form-control tag-select-choose" multiple="multiple" name="tags[]">
                                            </select>
                                        </div> --}}


                                    </div>
                                </div>

                                 <div class="text-left">
                                    <div class="form-group1">
                                        <button type="submit" class="btn btn-primary">chấp nhận</button>
                                        <button type="reset" class="btn btn-danger">Nhập lại</button>
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
