<div class="wrap-load-user">
    <div class="row">
        <div class="col-sm-12">
            <div class="list-info-user mb-5">
                <ul class="row">
                    <li class="col-sm-12">
                        <div class="avatar text-center p-3">
                            <img src="{{ $user->avatar_path?$user->avatar_path: $shareFrontend['userNoImage'] }}" alt="{{ $user->name }}" class="mb-3 rounded-circle" style="width:60px;">
                            <div class="text-center">
                                @if ($user->active===0)
                                <button class="btn btn-sm btn-warning ">Chưa kích hoạt</button>
                                @elseif($user->active===1)
                                <button class="btn btn-sm btn-success ">Kích hoạt</button>
                                @elseif ($user->active===2)
                                <button class="btn btn-sm btn-danger ">Bị khóa</button>
                                @endif
                            </div>
                        </div>
                    </li>
                    <li  class="col-sm-12 col-md-6">
                        <strong>Họ tên</strong>   {{ $user->name?$user->name:"Chưa cập nhập" }}
                    </li>
                    <li  class="col-sm-12 col-md-6">
                        <strong>Email</strong>   {{ $user->email?$user->email:"Chưa cập nhập" }}
                    </li>
                    <li class="col-sm-12 col-md-6">
                        <strong>Tài khoản</strong>    {{ $user->username?$user->username:"Chưa cập nhập" }}
                    </li>
                    <li  class="col-sm-12 col-md-6">
                        <strong>Phone</strong>   {{ $user->phone?$user->phone:"Chưa cập nhập" }}
                    </li>
{{--
                    <li  class="col-sm-12 col-md-6">
                        <strong>Sở thích</strong>   {{ $user->info_more?$user->info_more:"Chưa cập nhập" }}
                    </li>
                    <li  class="col-sm-12 col-md-6">
                        <strong>Bạn muốn trở thành</strong>   {{ $user->you_become?$user->you_become:"Chưa cập nhập" }}
                    </li>
                    <li class="col-sm-12 col-md-6"> <strong>Ngày sinh </strong>    {{$user->date_birth? $user->date_birth:"Chưa cập nhập" }}   </li>

                    @if ($user->type==1)
                    <li  class="col-sm-12 col-md-6">
                        <strong>Địa chỉ</strong>
                        @if ($user->city_id&& $user->district_id && $user->commune_id)
                        {{ optional($user->district)->name }} , {{ optional($user->city)->name }}
                        @endif
                    </li>
                    <li  class="col-sm-12 col-md-6">
                        <strong>Tài chính</strong>   {{ $user->tai_chinh?$user->tai_chinh:"Chưa cập nhập" }}
                    </li>
                    @endif --}}

                    {{-- <li class="col-sm-12 col-md-6"> <strong>Tình trạng </strong>    {{ $user->active==1?'Hiện':'Ẩn' }} </li> --}}
                    {{-- <li class="col-sm-12 col-md-6"> <strong>Người giới thiệu </strong>     {{ $user->parent_id?$user->parent->name:"Không có" }} </li> --}}
                    {{-- <li class="col-sm-12 col-md-6"> <strong>Ngày sinh </strong>    {{$user->date_birth? $user->date_birth:"Chưa cập nhập" }}   </li> --}}
                    {{-- <li class="col-sm-12 col-md-6"> <strong>HKTT </strong>     {{ $user->hktt?$user->hktt:"Chưa cập nhập" }} </li>
                    <li class="col-sm-12 col-md-6"> <strong>CMT </strong>     {{ $user->cmt?$user->cmt:"Chưa cập nhập" }} </li>
                    <li class="col-sm-12 col-md-6"> <strong>STK </strong>     {{ $user->stk?$user->stk:"Chưa cập nhập" }} </li>
                    <li class="col-sm-12 col-md-6"> <strong>CTK </strong>     {{ $user->ctk?$user->ctk:"Chưa cập nhập" }} </li>
                    <li class="col-sm-12 col-md-6"> <strong>Ngân hàng </strong>     {{ $user->bank?$user->bank->name:"Chưa cập nhập" }} </li>
                    <li class="col-sm-12 col-md-6"> <strong>Chi nhánh ngân hàng </strong>     {{ $user->bank_branch?$user->bank_branch:"Chưa cập nhập" }} </li> --}}
                    {{-- <li class="col-sm-12 col-md-6"> <strong>Giới tính </strong>     {{ $user->sex==1?"Nam":($user->sex==0?"Nữ":"Chưa  cập nhập") }} </li> --}}
                    <li class="col-sm-12 col-md-6"> <strong>Ngày tạo tài khoản </strong>     {{ $user->created_at }} </li>
                    <li class="col-sm-12 col-md-6"> <strong>Admin xử lý </strong>     {{ optional($user->admin)->name }} </li>
                </ul>
            </div>

        </div>
    </div>

</div>
