@extends('admin.layouts.main')
@section('title',"Edit user")
@section('css')
<link href="{{asset('lib/select2/css/select2.min.css')}}" rel="stylesheet" />
<style>
   .select2-container--default .select2-selection--multiple .select2-selection__choice{
   background-color: #000 !important;
   }
   .select2-container .select2-selection--single{
   height: auto;
   }
</style>
@endsection

@section('content')
<div class="content-wrapper">
   @include('admin.partials.content-header',['name'=>"Thành viên","key"=>"Thông tin thành viên"])
   <!-- Main content -->
   <div class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
                <div class="list-info-user mb-5">
                   <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-cart-plus"></i></span>
                                <div class="info-box-content">
                                <span class="info-box-text"> Tổng số tiền hiện có</span>
                                <span class="info-box-number"> <strong>{{ number_format($sumPointCurrent)  }}</strong> VNĐ</span>
                                </div>
                            </div>
                        </div>
                        @isset($sumEachType)
                            @foreach ($sumEachType as $item)
                                <div class="col-md-12 col-sm-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fas fa-cart-plus"></i></span>
                                        <div class="info-box-content">
                                        <span class="info-box-text"> {{ $typePoint[$item['type']]['name']  }}</span>
                                        <span class="info-box-number"> <strong>{{ number_format($item['total'])  }}</strong> VNĐ</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                   </div>
                   <div class="text-right">
                        <a href="{{ route('admin.user_frontend.detail',['id'=>$user->id]) }}" class="btn btn-success">Sản phẩm đã thêm</a>
                        @if ($user->type==4)
                        <a href="{{ route('admin.user_frontend.countBuy',['id'=>$user->id]) }}" class="btn btn-primary">Lọc số lượt mua theo ngày</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="alert alert-success">
                    Lịch sử sử dụng tiền
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed bg-while">
                       <thead>
                          <tr>
                             <th>ID</th>
                             <th class="text-nowrap">Số tiền</th>
                             <th class="text-nowrap">Loại</th>
                             <th class="text-nowrap">Thời gian</th>
                          </tr>
                       </thead>
                       <tbody>
                           @foreach ($data as $point)
                           <tr>
                               <td>{{ $point->id }}</td>
                               <td>
                                 {{ number_format($point->point) }} VNĐ
                               </td>
                               <td class="text-nowrap">
                                    {{ $typePoint[$point->type]['name'] }}
                                </td>
                                <td class="text-nowrap">
                                    {{ $point->created_at }}
                                </td>
                            </tr>
                           @endforeach

                       </tbody>
                    </table>
                 </div>
               </div>
            </div>
            <div class="col-md-12">
                {{$data->appends(request()->input())->links()}}
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('js')

{{-- <script>
   $(function(){
    $(document).on('click','.pagination a',function(){
        event.preventDefault();
        let href=$(this).attr('href');
        //alert(href);
        $.ajax({
            type: "Get",
            url: href,
           // data: "data",
            dataType: "JSON",
            success: function (response) {
                if(response.type=='rose-user_frontend'){
                    $('.wrap-rose-user-frontend').html(response.html);
                } else if(response.type=='user_frontend'){
                    $('.wrap-user-frontend').html(response.html);
                }
            }
        });
    });
   })
</script> --}}
@endsection
