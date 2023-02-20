    <div class="form-group">
        <label class="control-label" for="">Ngày bắt đầu {{$type}}</label>
        <div class="">
            <input type="date" class="form-control @error($time_buy) is-invalid @enderror" value="{{ old($time_buy) ?? Carbon::now()->format('Y-m-d') }}" name="{{$time_buy}}" placeholder="ngày bán" />
            @error($time_buy)
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label" for="">Ngày kết thúc {{$type}}</label>
        <div class="">
            <input type="date" class="form-control @error($time_expires) is-invalid @enderror" value="{{ old($time_expires) ??Carbon::now()->addYears($addYear)->format('Y-m-d') }}" name="{{$time_expires}}" placeholder="ngày mua" />
            @error($time_expires)
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>