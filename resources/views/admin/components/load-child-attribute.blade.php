
<div class="col-12 col-item-price">
    <div class="item-price">
        <div class="box-content-price">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="">Tên sản phẩm</label>
                        <input type="text"  class="form-control  @error('nameOption') is-invalid  @enderror"  value="{{ old('nameOption') }}" name="nameOption[]" placeholder="Nhập tên sản phẩm">
                        @error('nameOption')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="">Giá</label>
                        <input type="number"  class="form-control  @error('valueOption') is-invalid  @enderror"  value="{{ old('valueOption') }}" name="valueOption[]" placeholder="Nhập giá">
                        @error('valueOption')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="">Số thứ tự</label>
                    
                        <input type="number" min="0" class="form-control @error('orderOption') is-invalid  @enderror" value="{{ old('orderOption') }}" name="orderOption[]" placeholder="Nhập số thứ tự" />
                        @error('orderOption')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="action">
            <a  class="btn btn-sm btn-danger deleteOptionProduct"><i class="far fa-trash-alt"></i></a>
        </div>
    </div>
</div>
