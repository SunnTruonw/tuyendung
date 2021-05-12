<div class="wrap-load-user">
    <div class="row">
        <div class="col-sm-12">
         <strong>Họ tên</strong>   {{ $user->name }} <br>
         <strong>Username</strong>    {{ $user->username }} <br>
         <strong>Số điện thoại </strong>    {{ $user->phone }} <br>
         <strong>Địa chỉ </strong> {{ $user->address }} <br>
         <strong>Tình trạng </strong>    {{ $user->active==1?'Active':'Disable' }} <br>

         <strong>Người giới thiệu </strong>     {{ $user->parent_id?$user->parent->name:"" }} <br>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 ">
            Tổng số điểm hiện có
             Số điểm : {{ $sumPointCurrent  }}
         </div>
         @isset($sumEachType)
             @foreach ($sumEachType as $item)
                 <div class="col-lg-3 col-md-6 col-sm-12 ">
                     Kiểu : {{ $typePoint[$item->type]['name']  }} <br>
                     Số điểm : {{ $item->total  }}
                 </div>
             @endforeach
         @endisset
    </div>

</div>
