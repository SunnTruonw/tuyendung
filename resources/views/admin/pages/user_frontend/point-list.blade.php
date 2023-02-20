@extends('admin.layouts.main')
@section('title',"List tiền")
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
   @include('admin.partials.content-header',['name'=>"Thành viên","key"=>"Thông tin tiền"])
   <!-- Main content -->
   <div class="content">
      <div class="container-fluid">
         <div class="row">

            <div class="col-12">
                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed bg-while">
                       <thead>
                          <tr>
                             <th>ID</th>
                             <th class="text-nowrap">Số điểm</th>
                             <th class="text-nowrap">Loại</th>
                             <th class="text-nowrap">Thành viên</th>
                             <th class="text-nowrap">Thời gian</th>
                          </tr>
                       </thead>
                       <tbody>
                           @foreach ($data as $point)
                           <tr>
                               <td>{{ $point->id }}</td>
                               <td>
                                 {{ number_format($point->point) }} điểm
                               </td>
                               <td class="text-nowrap">
                                    {{ $typePoint[$point->type]['name'] }}
                                </td>
                                <td class="text-nowrap">
                                    @if ($point->user)
                                    <a href="{{ route('admin.user_frontend.history',['id'=>optional($point->user)->id]) }}">
                                        {{ optional($point->user)->username }}
                                    </a>
                                    @endif


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
