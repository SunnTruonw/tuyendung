
@if ($data->active==1)
<span class="badge badge-success">Đã duyệt</span>
@else
<a  class="btn btn-sm btn-warning lb-active white-space-nowrap" data-value="{{$data->active}}" data-type="{{$type?$type:''}}" >
    Đang chờ duyệt
</a>
@endif
