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
                                        <input type="text" class="form-control" id="name_chunha" value="{{old('name_chunha')?? $data->name_chunha }}" name="name_chunha" placeholder="Nhập họ tên">
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
                                            name="masp" placeholder="Nhập số khung">
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
                                            name="phone_chunha" placeholder="Nhập số điện thoại">
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
                                            name="type_car" placeholder="Nhập dòng xe">
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
                                        class="col-sm-4 control-label">Tỉnh/Thành
                                        phố</label>
                                    <div class="col-sm-8">
                                        <select name="city_id" id="city" class="form-control" required="required" data-url="{{ route('ajax.address.districts') }}">
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
                        <select class="form-control custom-select select-2-init @error('category_id')
                            is-invalid
                            @enderror" id="" value="{{ old('category_id') }}" name="category_id">
    
                            <option value="0">--- Chọn danh mục cha ---</option>
    
                            @if (old('category_id')||old('category_id')==='0')
                                {!! \App\Models\CategoryProduct::getHtmlOption(old('category_id')) !!}
                            @else
                            {!!$option!!}
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
                        <select class="form-control attributeParent" data-id="{{$attribute->id}}" data-url="{{route('admin.load.attributes')}}"  name="attribute[]" >
                            <option value="0">--Chọn--</option>
                            @foreach ($attribute->childs()->orderby('id')->get() as $k=> $attr)
                                <option value="{{ $attr->id }}"
                                    @if (old('attribute'))
                                        @if ($attr->id==old('attribute')[$key])
                                            selected
                                        @else
                                            {{ $data->attributes->pluck('id')->contains($attr->id)?'selected':"" }}
                                        @endif
                                    @else
                                    {{ $data->attributes->pluck('id')->contains($attr->id)?'selected':"" }}
                                    @endif
                                >
                                    {{ $attr->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('attribute_child_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                       
                        <!-- Load ajax attribute -->
                        <div class="child-attributes">
                            <div class="row resultAttributes mt-2" id="resultAttributes{{$attribute->id}}">
                                @if (isset($data->attributeChilds) && $data->attributeChilds->count() > 0)
                                    @foreach ($attribute->childs()->orderby('id')->get() as $k=> $attr)
                                    
                                        @foreach ($attr->options as $item)
                                            @php
                                                $dataChildAttr = $data->attributeChilds->pluck('attribute_product_id')->contains($item->id);
                                                $checkAttrId = $data->attributeChilds->pluck('attribute_id')->contains($item->attribute_id);
                                            @endphp
                                            @if ($checkAttrId)
                                                <div class="col-sm-12">
                                                    <input type="checkbox" class="change-attr-child" name="attribute_child_id[]"
                                                    @if (old('attribute_child_id'))
                                                        @if ($attr->id==old('attribute_child_id')[$key])
                                                            checked
                                                        @else
                                                            {{ $dataChildAttr?'checked':"" }}
                                                        @endif
                                                    @else
                                                        {{ $dataChildAttr?'checked':"" }}
                                                    @endif
                                                            value="{{$attr->id}}|{{$item->id}}|{{$item->name}}|{{$item->value}}"/>
                                                    <span class="att-title">{{$item->name}} -<span style="color: red"> {{number_format($item->value, 0, ',', '.') ?? 0}}</span></span>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                @endif
                                {{-- @php
                                    $dataAttr = \App\Models\ProductAttributeChild::where('product_id', $data->id)->get();
                                    // list taat car attribute co
                                    $listIdAttr = $dataAttr->pluck('attribute_id')->unique()->toArray();
                                    //get id attrbite
                                    $childAttr = \App\Models\Attribute::where('parent_id', $attribute->id)->pluck('id')->toArray();
                                    
                                    //filter data mapching
                                    $mappching = array_intersect($childAttr, $listIdAttr);
                                @endphp --}}
                                @if(count($data->attributes) > 0)
                                    @php
                                        $time_start = $attribute->time_start;
                                        $time_end = $attribute->time_end;
                                    @endphp
                                    @if (!empty($data->$time_start) && !empty($data->$time_end))
                                        <div class="col-sm-12 pl-4 color-date mt-2">
                                            <label class="control-label" for="">Ngày bắt đầu <span class="lowercase">{{$attribute->name}}</span></label>
                                            <div class="">
                                                <input type="date" class="form-control @error($time_start) is-invalid @enderror" value="{{ old($time_start) ?? $data->$time_start }}" name="{{$time_start}}"/>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-12 pl-4 color-date mt-2">
                                            <label class="control-label" for="">Ngày kết thúc <span class="lowercase">{{$attribute->name}}</span></label>
                                            <div class="">
                                                <input type="date" class="form-control @error($time_end) is-invalid @enderror" value="{{ old($time_end) ?? $data->$time_end }}" name="{{$time_end}}"/>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <!-- End -->
                    </div>
                    @endforeach
                    <hr>
                    @if(!$data->attributes)
                    <div class="group-checkbox">
                        <div class="warpper-ajax-checkbox">
                            <div class="form-groups">
                                <label class="control-label" for="">CheckBox Phim cách nhiệt bảo vệ ô tô</label>
    
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input ajax-checkbox @error('check_btn') is-invalid
                                            @enderror" value="1" data-type="phim cách nhiệt" data-addyear="15" data-time_buy="time_buy" data-time_expires="time_expires" name="check_btn" @if(old('check_btn')==="1"||$data->check_btn==1 ) {{'checked'}} @endif>
                                    </label>
                                </div>
                                @error('check_btn')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="old-date-time pl-20">
                                    @if ($data->check_btn == 1)
                                    <div class="form-group">
                                        <label class="control-label" for="">Ngày bắt đầu phim cách nhiệt</label>
                                        <div class="">
                                            <input type="date" class="form-control @error('time_buy') is-invalid @enderror" value="{{ old('time_buy') ?? $data->time_buy }}" name="time_buy" placeholder="ngày bán" />
                                            @error('time_buy')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label" for="">Ngày kết thúc phim cách nhiệt</label>
                                        <div class="">
                                            <input type="date" class="form-control @error('time_expires') is-invalid @enderror" value="{{ old('time_expires') ?? $data->time_expires }}" name="time_expires" placeholder="ngày mua" />
                                            @error('time_expires')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @endif
                                </div>
                        </div>
    
                        <div class="warpper-ajax-checkbox">
                            <div class="form-groups">
                                <label class="control-label" for="">CheckBox Phim bảo vệ bề mặt</label>
    
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input ajax-checkbox @error('check_btn2') is-invalid
                                            @enderror" value="1" data-addyear="2" data-type="bảo vệ bề mặt" data-time_buy="time_buy2" data-time_expires="time_expires2" name="check_btn2" @if(old('check_btn2')==="1"||$data->check_btn2==1 ) {{'checked'}} @endif>
                                    </label>
                                </div>
                                @error('check_btn2')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="old-date-time pl-20">
                                    @if ($data->check_btn2 == 1)
                                    <div class="form-group">
                                        <label class="control-label" for="">Ngày bắt đầu bảo bề mặt</label>
                                        <div class="">
                                            <input type="date" class="form-control @error('time_buy2') is-invalid @enderror" value="{{ old('time_buy2') ?? $data->time_buy2 }}" name="time_buy2" placeholder="ngày bán" />
                                            @error('time_buy2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label" for="">Ngày kết thúc bảo bề mặt</label>
                                        <div class="">
                                            <input type="date" class="form-control @error('time_expires2') is-invalid @enderror" value="{{ old('time_expires2') ?? $data->time_expires2 }}" name="time_expires2" placeholder="ngày mua" />
                                            @error('time_expires2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @endif
                                </div>
                        </div>
    
                        <div class="warpper-ajax-checkbox">
                            <div class="form-groups">
                                <label class="control-label" for="">CheckBox Phim bảo vệ sơn</label>
    
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input ajax-checkbox @error('check_btn3') is-invalid
                                            @enderror" value="1" data-addyear="5" data-time_buy="time_buy1" data-time_expires="time_expires1" data-type="bảo vệ sơn" name="check_btn3" @if(old('check_btn3')==="1"||$data->check_btn3==1 ) {{'checked'}} @endif>
                                    </label>
                                </div>
                                @error('check_btn3')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="old-date-time pl-20">
                                    @if ($data->check_btn3 == 1)
                                    <div class="form-group">
                                        <label class="control-label" for="">Ngày bắt đầu bảo vệ sơn</label>
                                        <div class="">
                                            <input type="date" class="form-control @error('time_buy1') is-invalid @enderror" value="{{ old('time_buy1') ?? $data->time_buy1 }}" name="time_buy1" placeholder="ngày bán" />
                                            @error('time_buy1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label" for="">Ngày kết thúc bảo vệ sơn</label>
                                        <div class="">
                                            <input type="date" class="form-control @error('time_expires1') is-invalid @enderror" value="{{ old('time_expires1') ?? $data->time_expires1 }}" name="time_expires1" placeholder="ngày mua" />
                                            @error('time_expires1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @endif
                                </div>
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                        <label class="control-label" for="">Trạng thái</label>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                            <input type="radio" class="form-check-input" value="1" name="active" @if((old('active')??$data->active)=='1') {{'checked'}} @endif>Hiện
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" class="form-check-input" value="0" @if((old('active')??$data->active)=="0"){{'checked'}} @endif name="active">Ẩn
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
