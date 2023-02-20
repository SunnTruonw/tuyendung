@extends('admin.layouts.main')
@section('title',"Sửa gói")

@section('content')

  <div class="content-wrapper">
    @include('admin.partials.content-header',['name'=>"Gói","key"=>"Sửa gói"])
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
                <form action="{{route('admin.attribute.update',['id'=>$data->id])}}" method="POST" enctype="multipart/form-data">
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
                        <div class="col-md-8">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                   <h3 class="card-title">Thông tin thuộc tính</h3>
                                </div>
                                <div class="card-body table-responsive p-3">
                                    <ul class="nav nav-tabs">
                                        @foreach ($langConfig as $langItem)
                                        <li class="nav-item">
                                            <a class="nav-link {{$langItem['value']==$langDefault?'active':''}}" data-toggle="tab" href="#tong_quan_{{$langItem['value']}}">{{ $langItem['name'] }}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach ($langConfig as $langItem)
                                        <div id="tong_quan_{{$langItem['value']}}" class="p-3 tab-pane {{$langItem['value']==$langDefault?'active show':''}} fade">
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="col-sm-2 control-label" for="">Tên gói</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control nameChangeSlug
                                                        @error('name_'.$langItem['value']) is-invalid @enderror" id="name_{{$langItem['value']}}" value="{{ old('name_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->name }}" name="name_{{$langItem['value']}}" placeholder="Nhập tên gói">
                                                        @error('name_'.$langItem['value'])
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="form-group">
                                                <div class="row">
                                                    <label class="col-sm-2 control-label" for="">Value</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control
                                                        @error('value_'.$langItem['value']) is-invalid  @enderror" id="value_{{ $langItem['value'] }}" value="{{ old('value_'.$langItem['value'])??optional($data->translationsLanguage($langItem['value'])->first())->value }}" name="value_{{ $langItem['value'] }}" placeholder="Nhập value">
                                                        @error('value_'.$langItem['value'])
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                        @endforeach

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
                                        <label class="control-label" for="">Chọn danh mục</label>
                                        <select class="form-control custom-select select-2-init @error('parent_id')
                                            is-invalid
                                            @enderror" id="" value="{{ old('parent_id') }}" name="parent_id">
                                            <option value="0">--- Root---</option>
                                            @if (old('parent_id')||old('parent_id')==='0')
                                            {!! \App\Models\Attribute::getHtmlOptionAddWithParent(old('parent_id')) !!}
                                            @else
                                            {!!$option!!}
                                            @endif
                                        </select>
                                        @error('parent_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label" for="">Số thứ tự</label>

                                        <input type="number" min="0" class="form-control  @error('order') is-invalid  @enderror"  value="{{ old('order')??$data->order }}" name="order" placeholder="Nhập số thứ tự">

                                        @error('order')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="">Trạng thái</label>

                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" value="1" name="active" @if(old('active')==='1' ||old('active')===null) {{'checked'}} @endif>Hiện
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" value="0" @if(old('active')==="0" ){{'checked'}} @endif name="active">Ẩn
                                            </label>
                                        </div>
                                        @error('active')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Các lựa chọn của gói</h3>
                                </div>
                                 <div class="card-body table-responsive p-3">
                                    <div class="list-item-option wrap-option mt-3">
                                        @foreach ($data->options()->orderBy('order', 'ASC')->get() as $key=>$item)
                                        <div class="item-price col-item-price">
                                            <div class="box-content-price">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="control-label" for="">Tên sản phẩm</label>
                                                            <input type="hidden" name="idOption[]" value="{{ $item->id }}">
        
                                                            <input type="text" min="0" class="form-control  @error('nameOptionOld.'.$key) is-invalid  @enderror" value="{{  old('nameOptionOld')[$key]??$item->name }}" name="nameOptionOld[]" placeholder="Nhập tên sản phẩm">
                                                            @error('nameOptionOld.'.$key)
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="control-label" for="">Giá</label>
                                                            <input type="number" min="0" class="form-control  @error('valueOptionOld.'.$key) is-invalid  @enderror" value="{{ $item->value ?? 0 }}" name="valueOptionOld[]" placeholder="Nhập giá">
                                                            @error('valueOptionOld.'.$key)
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="control-label" for="">Số thứ tự</label>
                                                            <input type="number" min="0" class="form-control @error('orderOptionOld.'.$key) is-invalid  @enderror" value="{{  old('orderOptionOld')[$key]??$item->order }}" name="orderOptionOld[]" placeholder="Nhập số thứ tự" />
                                                            @error('orderOptionOld.'.$key)
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="action">
                                                <a  class="btn btn-sm btn-danger deleteOptionProductDB" data-url="{{ route('admin.attribute.destroyOptionAttribute',['id'=>$item->id]) }}"><i class="far fa-trash-alt"></i></a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div> 
                                    
                                    <div class="">Thêm sản phẩm mới  <a data-url="{{ route('admin.attribute.loadChildAttribute') }}" class="btn  btn-info btn-md float-right " id="addOptionProduct">+ Thêm mới</a></div>
                                    <div class="list-item-option wrap-option mt-3" id="wrapOption">
                                        @if (old('priceOption')&&old('priceOption'))
                                            @foreach (old('priceOption') as $key=>$value)
                                            <div class="item-price">
                                                <div class="box-content-price">

                                                    <div class="form-group">
                                                        <label class="control-label" for="">Tên sản phẩm</label>

                                                        <input type="text" min="0" class="form-control  @error('nameOption.'.$key) is-invalid  @enderror"  value="{{ old('nameOption')[$key] }}" name="nameOption[]" placeholder="Nhập tên sản phẩm">
                                                        @error('nameOption.'.$key)
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label" for="">Giá</label>
                                                        <input type="number" min="0" class="form-control  @error('valueOption.'.$key) is-invalid  @enderror"  value="{{ old('valueOption')[$key] }}" name="valueOption[]" placeholder="Nhập giá">
                                                        @error('valueOption.'.$key)
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label" for="">Số thứ tự</label>
                                                    
                                                        <input type="number" min="0" class="form-control @error('orderOption.'.$key) is-invalid  @enderror" value="{{ old('orderOption')[$key] }}" name="orderOption[]" placeholder="Nhập số thứ tự" />
                                                        @error('orderOption.'.$key)
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    
                                                </div>
                                                <div class="action">
                                                    <a  class="btn btn-sm btn-danger deleteOptionProduct"><i class="far fa-trash-alt"></i></a>
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
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
