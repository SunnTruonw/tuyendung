<div class="box-address">
    <h3>Bất động sản bạn quan tâm</h3>
    <div class="form-group">
        <div class="item_col_left">
            <label for="">Tỉnh/Thành phố</label>
        </div>
        <div class="item_col_right">
            <select name="city_id" id="city" class="form-control" value="{{ old('city_id') }}" data-url="{{ route('ajax.address.districts') }}">
                <option value="">Chọn tỉnh/thành phố</option>
                {!! $cities !!}
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="item_col_left">
            <label for="">Quận/huyện</label>
        </div>
        <div class="item_col_right">
            <select name="district_id" id="district" class="form-control" value="{{ old('district_id') }}" data-url="{{ route('ajax.address.communes') }}">
                <option value="">Chọn quận/huyện</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="item_col_left">
            <label for="">Xã/phường/thị trấn </label>
        </div>
        <div class="item_col_right">
            <select name="commune_id" id="commune" value="{{ old('commune_id') }}" class="form-control">
                <option value="">Chọn xã/phường/thị trấn</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="item_col_left">
            <label for=""> Địa chỉ cụ thể </label>
        </div>
        <div class="item_col_right">
            <input id="" type="text" class="form-control" name="address_detail" placeholder="Địa chỉ cụ thể">
        </div>
    </div>
</div>
