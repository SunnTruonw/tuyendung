@extends('frontend.layouts.main-profile')
@section('title', 'Sửa bài viêt')

@section('css')
    <style>
        .col-image {
            margin: 10px;
            position: relative;
            overflow: hidden;
            object-fit: cover;
        }

        .col-image img {}

        .lb_delete_image {
            position: absolute;
            top: 0;
            right: 0;
            background-color: red !important;
            color: #fff !important;
            margin: 0 !important;
            padding: 5px 10px !important;
        }

        .wrap-load-image img {
            width: 100%;
            /* max-width: 150px; */
            height: auto;
            object-fit: cover;
        }

        .card {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        textarea,
        input,
        select {
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

        .btn-primary {
            margin-top: 20px;
            background: #e90000;
            padding: 5px 20px;
            color: #fff;
            border-radius: 0;
            border: none;
            font-weight: 600;
            font-size: 15px;
        }

        .btn-danger {
            margin-top: 20px;
            background: #ccc;
            padding: 5px 20px;
            color: #333;
            border-radius: 0;
            border: none;
            font-weight: 600;
            font-size: 15px;
        }

        .alert-info {
            color: #333;
            background-color: #eee;
            border-color: #eee;
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
    <div class="content-wrapper lb_template_post_edit">
        <div class="content">

            <div class="row">
                <div class="col-md-12">
                    {{-- <div class="alert alert-success">
                        {{ dd($errors->all()) }}
                     </div> --}}

                    @if (session('alert'))
                        <div class="alert alert-success">
                            {{ session('alert') }}
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-warning">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('profile.updateProduct', ['id' => $data->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="title-h">
                                    <span>Chỉnh sửa mã bảo hành</span>
                                </div>
                                {{-- <div class="alert alert-info">
                                    - Để nâng cấp chất lượng nội dung tin rao bất động sản, chúng tôi tiến hành duyệt toàn bộ tin rao đăng mới. <br>
                                    - Tin rao đúng sẽ được duyệt chậm nhất trong vòng 9h làm việc.
                                </div> --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="card card-outline card-primary">
                                    <div class="card-body table-responsive p-3">
                                        <div class="form-group">
                                            <label class="" for="">Họ tên</label>
                                            <input type="text" class="form-control
                                             @error('name_chunha') is-invalid @enderror"  value="{{ old('name_chunha')??$data->name_chunha }}" name="name_chunha" placeholder="Họ tên">
                                            @error('name_chunha')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                         <div class="form-group">
                                            <label class="" for="">Số khung</label>
                                            <input  type="text" class="form-control
                                            @error('masp') is-invalid  @enderror"  value="{{ old('masp')??$data->masp }}" name="masp" placeholder="Số khung">
                                            @error('masp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="" for="">Diện thoại</label>
                                            <input  type="text" class="form-control
                                            @error('phone_chunha') is-invalid  @enderror"  value="{{ old('phone_chunha')??$data->phone_chunha }}" name="phone_chunha" placeholder="Điện thoại">
                                            @error('phone_chunha')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="" for="">Loại xe</label>
                                            <input  type="text" class="form-control
                                            @error('type_car') is-invalid  @enderror"  value="{{ old('type_car')??$data->type_car }}" name="type_car" placeholder="Loại xe">
                                            @error('type_car')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="" for="">Biển kiểm xoát</label>
                                            <input  type="text" class="form-control
                                            @error('bienkiemsoat') is-invalid  @enderror"  value="{{ old('bienkiemsoat')??$data->bienkiemsoat }}" name="bienkiemsoat" placeholder="Biển kiểm soát">
                                            @error('bienkiemsoat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group ">
                                            <label  for="">Tỉnh/Thành phố</label>
                                                <select name="city_id" id="city" class="form-control" required="required" data-url="{{ route('ajax.address.districts') }}">
                                                    <option value="">Chọn tỉnh/thành phố</option>
                                                    @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}" {{ $city->id==(old('city_id')??$data->city_id)?'selected':'' }} >{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="" for="">Rollid</label>
                                            <input  type="text" class="form-control
                                            @error('rollid') is-invalid  @enderror"  value="{{ old('rollid')??$data->rollid }}" name="rollid" placeholder="Rollid">
                                            @error('rollid')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="" for="">Ngày bắt đầu</label>
                                            <input  type="date" class="form-control
                                            @error('time_buy') is-invalid  @enderror"  value="{{ old('time_buy')??$data->time_buy }}" name="time_buy" placeholder="ngày mua">
                                            @error('time_buy')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="" for="">Ngày hết bảo hành</label>
                                            <input  type="date" class="form-control
                                            @error('time_expires') is-invalid  @enderror"  value="{{ old('time_expires')??$data->time_expires }}" name="time_expires" placeholder="ngày bán">
                                            @error('time_expires')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="form-group1">
                                            <label class="" for="">Địa chỉ</label>
                                            <input  type="text" class="form-control
                                            @error('address_chunha') is-invalid  @enderror"  value="{{ old('address_chunha')??$data->address_chunha }}" name="address_chunha" placeholder="Địa chỉ">
                                            @error('address_chunha')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group1">
                                            <label class="" for="">Nhập nội dung</label>
                                            <textarea
                                                class="form-control tinymce_editor_init @error('content') is-invalid  @enderror"
                                                name="content" id="" rows="20" value=""
                                                placeholder="Nhập nội dung"> {{ old('content') ?? $data->content }}</textarea>
                                            @error('content')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        {{-- <div class="row">
                                            <div class="col-md-5">
                                                <div class="wrap-load-image mb-3">
                                                    <div class="form-group">
                                                        <label for="">Ảnh đại diện</label>
                                                        <input type="file" class="form-control-file img-load-input border"
                                                            id="" name="avatar_path">
                                                    </div>
                                                    @error('avatar_path')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                    @enderror
                                                    <img class="img-load border p-1 w-100" src="{{ $data->avatar_path }}"
                                                        alt="{{ $data->name }}"
                                                        style="height: 200px;object-fit:contain;">
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="wrap-load-image mb-3">
                                                    <label class="mb-3 w-100">Hình ảnh khác</label>

                                                    <span class="badge badge-success">Đã thêm</span>
                                                    <div class="list-image d-flex flex-wrap">
                                                        @foreach ($data->images()->get() as $productImageItem)
                                                            <div class="col-image" style="width:20%;">
                                                                <img class="" src="
                                                                        {{ $productImageItem->image_path }}"
                                                                    alt="{{ $productImageItem->name }}">
                                                                <a class="btn btn-sm btn-danger lb_delete_image"
                                                                    data-url="{{ route('profile.product.destroy-image', ['id' => $data->user->id, 'idImage' => $productImageItem->id]) }}"><i
                                                                        class="far fa-trash-alt"></i></a>
                                                            </div>
                                                        @endforeach
                                                        @if (!$data->images()->get()->count())
                                                            Chưa thêm hình ảnh nào
                                                        @endif
                                                    </div>
                                                    <hr>
                                                    <span class="badge badge-primary mb-3">Thêm ảnh</span>
                                                    <div class="form-group">

                                                        <input type="file"
                                                            class="form-control-file img-load-input-multiple border" id=""
                                                            name="image[]" multiple>
                                                    </div>
                                                    @error('image')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                    <div class="load-multiple-img">
                                                        @if (!$data->images()->get()->count())
                                                            <img class="" src="
                                                                    {{ asset('admin_asset/images/upload-image.png') }}"
                                                                alt="'no image">
                                                            <img class="" src="
                                                                    {{ asset('admin_asset/images/upload-image.png') }}"
                                                                alt="'no image">
                                                            <img class="" src="
                                                                    {{ asset('admin_asset/images/upload-image.png') }}"
                                                                alt="'no image">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}


                                    </div>
                                </div>

                                <div class="text-left">
                                    <div class="form-group1">
                                        <button type="submit" class="btn btn-primary">CHẤP NHẬN</button>
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
    <script src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
    {{-- <script src="{{asset('lib/tinymce5/js/tinymce.min.js')}}"></script> --}}
    <script src="https://cdn.tiny.cloud/1/si5evst7s8i3p2grgfh7i5gdsk2l26daazgefvli0hmzapgn/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    {{-- <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script> --}}
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin_asset/ajax/deleteAdminAjax.js') }}"></script>
    <script src="{{ asset('admin_asset/js/function.js') }}"></script>
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
                let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                let y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

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

        $(document).on('change', '.img-load-input-multiple', function() {
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
                    data: {
                        'id': value
                    },
                    success: function(data) {
                        if (data.code == 200) {
                            let html = defaultCategoryChild + data.html;
                            $('#categoryChild').html(html);
                        }
                    }
                });
            }
        })


        function changePrice() {
            var value = $('#price').val();

            value = value.replace(',', ".");

            $('#price').val(value);
        }
    </script>

@endsection
