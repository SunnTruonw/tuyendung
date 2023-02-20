
@if ($data->active==1)
    Đã duyệt
@else
<a  class="btn btn-sm btn-warning lb-active-comment" data-url="{{ route($routeActive,['id'=>$data->id]) }}">
    Duyệt
</a>
@endif
