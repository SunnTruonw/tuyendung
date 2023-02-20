@if (isset($data) && $data)
    @foreach ($data as $item)
        <div class="col-sm-12">
            <input type="checkbox" class="change-attr-child" name="attribute_child_id[]"
                    value="{{$attributeId}}|{{$item->id}}|{{$item->name}}|{{$item->value}}"/>
            <span class="att-title">{{$item->name}} -<span style="color: red"> {{number_format($item->value, 0, ',', '.') ?? 0}}</span></span>
        </div>
    @endforeach
    
    @if (isset($dataParent) && $dataParent)
        <div class="col-sm-12 pl-4 color-date mt-2">
            <label class="control-label" for="">Ngày bắt đầu <span class="lowercase">{{$dataParent->name}}</span></label>
            <div class="">
                <input type="date" class="form-control @error($dataParent->time_start) is-invalid @enderror" value="{{ old($dataParent->time_start) ?? Carbon::now()->format('Y-m-d') }}" name="{{$dataParent->time_start}}" placeholder="ngày bán" />
            </div>
        </div>
        
        <div class="col-sm-12 pl-4 color-date mt-2">
            <label class="control-label" for="">Ngày kết thúc <span class="lowercase">{{$dataParent->name}}</span></label>
            <div class="">
                <input type="date" class="form-control @error($dataParent->time_end) is-invalid @enderror" value="{{ old($dataParent->time_end) ?? Carbon::now()->addYears($dataParent->year)->format('Y-m-d') }}" name="{{$dataParent->time_end}}" placeholder="ngày mua" />
            </div>
        </div>
    @endif
@endif