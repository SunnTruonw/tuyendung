
@if ($data->status==1)

<a  class="btn btn-sm btn-warning lb-status white-space-nowrap" data-value="{{$data->status}}" data-type="{{$type?$type:''}}" >
    Chưa gửi
</a>
@elseif($data->status==2)
<a  class="btn btn-sm btn-success white-space-nowrap">
     Đã gửi
</a>
@endif
