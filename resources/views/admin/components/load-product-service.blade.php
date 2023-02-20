<style>
    .wrapper{
        font-size: 14px;
        font-weight: 0;
    }
</style>
<div class="wrapper">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                   <h3 class="card-title">Thông tin bảo hành</h3>
                </div>
                <div class="card-body table-responsive p-3">
                    <div class="tab-content">
                        <div class="container tab-pane active"><br>
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 control-label" for="">Họ và tên</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="name_chunha" value="{{old('name_chunha')?? $data->name_chunha }}" name="name_chunha" placeholder="Nhập họ tên" readonly>
                                    </div>
                                </div>
                                @error('name_chunha')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
    
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 control-label" for="">Số
                                        khung/Biển số</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                            class="form-control
                                    @error('masp') is-invalid @enderror"
                                            id="masp" value="{{ old('masp') ?? $data->masp }}"
                                            name="masp" placeholder="Nhập số khung" readonly>
                                            @error('masp')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 control-label" for="">Điện
                                        thoại</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                            class="form-control
                                    @error('phone_chunha') is-invalid @enderror"
                                            id="phone_chunha" value="{{ old('phone_chunha') ?? $data->phone_chunha }}"
                                            name="phone_chunha" placeholder="Nhập số điện thoại" readonly>
                                            @error('phone_chunha')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 control-label" for="">Dòng
                                        xe</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                            class="form-control
                                    @error('type_car') is-invalid @enderror"
                                            id="type_car" value="{{ old('type_car') ?? $data->type_car }}"
                                            name="type_car" placeholder="Nhập dòng xe" readonly>
                                            @error('type_car')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 control-label" for="">Đơn vị thi công</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                            class="form-control
                                    @error('donvithicong') is-invalid @enderror"
                                            id="donvithicong" value="{{ old('donvithicong') ?? $data->donvithicong }}"
                                            name="donvithicong" placeholder="Nhập đơn vị thi công" readonly>
                                            @error('donvithicong')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="row">
                                    <label for=""
                                        class="col-sm-4 control-label">Tỉnh/Thành
                                        phố</label>
                                    <div class="col-sm-8">
                                        <select name="city_id" id="city" class="form-control" required="required" data-url="{{ route('ajax.address.districts') }}" readonly>
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
    
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-12 control-label" for="">Ghi chú</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control tinymce_editor_init" name="content" id="" rows="7" placeholder="Ghi chú">{{old('content')?? $data->content }}</textarea>
                                    </div>
                                </div>
                                @error('content')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
    
                            {{-- <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label" for="">Avatar</label>
                                        <div class="">
                                            <input type="file" class="form-control-file img-load-input border" id="avatar_path" name="avatar_path">
                                        </div>
                                    </div>
                                    @error('avatar_path')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
    
                        </div>
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
                            <select data-id="{{$attribute->id}}" data-url="{{route('admin.load.attributes')}}" class="form-control attributeParentModal"  name="attribute[]" >
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
                                    <div class="row resultAttributesModal" id="resultAttributesModal{{$attribute->id}}">
    
                                    </div>
                                </div>
                            <!-- End -->
                        </div>
                     @endforeach
                    <hr>
                <div class="group-checkbox">
                    <div class="warpper-ajax-checkbox-modal">
                        <div class="form-groups">
                            <label class="control-label" for="">CheckBox Phim cách nhiệt bảo vệ ô tô</label>
    
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input ajax-checkbox-modal @error('check_btn') is-invalid
                                        @enderror" value="1" data-type="phim cách nhiệt" data-addyear="15" data-time_buy="time_buy" data-time_expires="time_expires" name="check_btn">
                                </label>
                            </div>
                            @error('check_btn')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="old-date-time pl-20"></div>
                    </div>
    
                    <div class="warpper-ajax-checkbox-modal">
                        <div class="form-groups">
                            <label class="control-label" for="">CheckBox Phim bảo vệ bề mặt</label>
    
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input ajax-checkbox-modal @error('check_btn2') is-invalid
                                        @enderror" value="1" data-addyear="2" data-type="bảo vệ bề mặt" data-time_buy="time_buy2" data-time_expires="time_expires2" name="check_btn2">
                                </label>
                            </div>
                            @error('check_btn2')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="old-date-time pl-20"></div>
                    </div>
    
                    <div class="warpper-ajax-checkbox-modal">
                        <div class="form-groups">
                            <label class="control-label" for="">CheckBox Phim bảo vệ sơn</label>
    
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input ajax-checkbox-modal @error('check_btn3') is-invalid
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
                </div>
            </div>
    
        </div>
    </div>
</div>

<script>
    //load ajax attributes
    $(document).on('change', '.attributeParentModal', function() {
        let urlRequest = $(this).data("url");
        let id = $(this).data("id");
        let mythis = $(this);
        let value = $(this).val();

        if(value == 0){
            mythis.parents('.form-group').find('.resultAttributesModal').empty();
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
                $('#resultAttributesModal'+ id).html(html);
            }
        });
    });

    //load ajax date time
    $(document).on('change', '.ajax-checkbox-modal', function() {
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
                    mythis.parents('.warpper-ajax-checkbox-modal').find('.old-date-time').html(html);
                }
            });
        }else{
            // $(this).val($(this).is(':checked'));
            mythis.parents('.warpper-ajax-checkbox-modal').find('.old-date-time').empty();
        }
    });

    $(document).on("click", ".change-attr-child", function() {
        if ($(this).prop('checked')) {
            $('.group-checkbox').hide();
        }else{
            $('.group-checkbox').show();
        }
    });

    
</script>