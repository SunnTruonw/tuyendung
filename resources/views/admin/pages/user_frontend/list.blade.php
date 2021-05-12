@extends('admin.layouts.main')
@section('title',"danh sach nhân viên")

@section('css')
<link rel="stylesheet" href="{{asset('lib/sweetalert2/css/sweetalert2.min.css')}}">
@endsection
@section('content')
<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>" Admin User","key"=>"Danh sách thành viên"])

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
                <a href="{{route('admin.user.create')}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
                <div class="card card-outline card-primary">
                    <div class="card-tools w-100  p-3">
                        <form class="form-inline text-right justify-content-end  mb-2" action="{{ route('admin.user_frontend.transferPointBetweenXY') }}" method="GET">
                           <label for="">Điểm bắt đầu:</label>
                            <div class="d-inline-block">
                                <input type="number" class="form-control ml-1 mr-1" name="start" placeholder="Nhập STT bắt đầu" value="{{ old('start') }}">
                                @error('start')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                           <label for="">Điểm kết thúc:</label>
                          <div class="d-inline-block">
                                <input type="number" class="form-control ml-1 mr-1" name="end" placeholder="Nhập STT kết thúc" value="{{ old('end') }}">
                                @error('end')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                          </div>
                           <button type="submit" class="btn btn-primary">Bắn điểm hàng loạt</button>
                       </form>
                       @if (session('transferPointBetweenXY'))
                        <div class="alert alert-success">
                            {{session("transferPointBetweenXY")}}
                        </div>
                       @elseif(session('transferPointBetweenXYError'))
                        <div class="alert alert-warning">
                            {{session("transferPointBetweenXYError")}}
                        </div>
                       @endif
                   </div>
                    <div class="card-body table-responsive p-0 lb-list-category">
                        <table class="table table-head-fixed" style="font-size:13px;">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Username</th>
                                    <th>Họ và tên</th>
                                    <th>Email</th>
                                    <th>Số điểm đã nạp</th>
                                    <th>Trạng thái</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                <tr>
                                    <td>{{$item->order}}</td>
                                    <td>{{$item->username}}</td>
                                    <td><a href="{{ route('admin.user_frontend.detail',['id'=>$item->id]) }}">{{$item->name}}</a></td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->points()->where(['type'=>4])->select(\App\Models\Point::raw('SUM(point) as total'))->first()->total }}</td>
                                    <td class="wrap-load-active" data-url="{{ route('admin.user_frontend.load.active',['id'=>$item->id]) }}">
                                        @include('admin.components.load-change-active-user',['data'=>$item,'type'=>'user'])
                                     </td>
                                    <td>
                                        <a  class="btn btn-sm btn-info" id="btn-load-transaction-detail" data-url="{{route('admin.user_frontend.loadUserDetail',['id'=>$item->id])}}" ><i class="fas fa-eye"></i></a>

                                        <a  class="btn btn-sm btn-danger" id="btnTranferPoint" data-url="{{route('admin.user_frontend.transferPoint',['id'=>$item->id])}}" >Bắn điểm</a>

                                        {{-- <a href="{{route('admin.user.edit',['id'=>$adminItem->id])}}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                        <a data-url="{{route('admin.user.destroy',['id'=>$adminItem->id])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i></a> --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                {{$data->links()}}
            </div>
        </div>
      </div>
    </div>
</div>

<div class="modal fade in" id="transactionDetail">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Thông tin chi tiết thành viên</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
         <div class="content" id="loadTransactionDetail">

         </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('js')
{{-- <script src="{{asset('')}}"></script> --}}
<script src="{{asset('lib/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('admin_asset/ajax/deleteAdminAjax.js')}}"></script>
<script>
    $(function(){
        $(document).on('click','#btnTranferPoint',function(){
            event.preventDefault();
            let urlRequest = $(this).data("url");
            let title = '';
            title ='Bạn có chắc chắn muốn bắn điểm';
            $this=$(this);
            Swal.fire({
                title: title,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, next step!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: urlRequest,
                        success: function(data) {
                            if (data.code == 200) {
                                $this.text('Đã bắn');
                                $this.removeClass('btn-danger').addClass('btn-info');
                            }else{
                                Swal.fire({
                                    position: 'center',
                                    icon: 'warning',
                                    title: 'Bắn điểm không thành công',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        }
                    });
                }
            });
        });
    });
</script>

@endsection
