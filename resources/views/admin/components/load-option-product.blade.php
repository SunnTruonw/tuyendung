
<div class="col-md-4 col-12 col-item-price">
    <div class="item-price">
        <div class="box-content-price">
            {{-- <div class="form-group">
                <label class="control-label" for="">Tên</label>
                <input type="text"  class="form-control  @error('nameOption') is-invalid  @enderror"  value="{{ old('nameOption') }}" name="supplier_idOption[]" placeholder="Nhập tên">
                @error('supplier_idOption')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div> --}}
            <div class="form-group">
                <label class="control-label" for="">Chọn nhà cung cấp</label>
                <select class="form-control  @error('supplier_idOption') is-invalid  @enderror"   name="supplier_idOption[]">
                    <option value="">Chon nhà cung cấp</option>
                    @if (isset($supplier)&&$supplier)
                    @foreach ($supplier as $item)
                    <option value="{{ $item->id }}" {{ old('supplier_idOption')==$item->id?'selected':'' }}>{{ $item->name }}</option>
                    @endforeach
                    @endif
                  </select>
                @error('supplier_idOption')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="control-label" for="">Nhập đường dẫn</label>
                <input type="text"  class="form-control  @error('slugOption') is-invalid  @enderror"  value="{{ old('slugOption') }}" name="slugOption[]" placeholder="Nhập đường dẫn">
                @error('slugOption')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="control-label" for="">Nhập giá</label>
                <input type="number"  class="form-control  @error('priceOption') is-invalid  @enderror"  value="{{ old('priceOption') }}" name="priceOption[]" placeholder="Nhập giá">
                @error('priceOption')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="action">
            <a  class="btn btn-sm btn-danger deleteOptionProduct"><i class="far fa-trash-alt"></i></a>
        </div>
    </div>
</div>
