@extends('frontend.layouts.main')
@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')

@section('content')
    <div class="content-wrapper">
        <div class="main">
            @include('frontend.components.breadcrumbs',[
                'breadcrumbs'=>$breadcrumbs,
                'breadcrumbs'=>$breadcrumbs,
                'type'=>$typeBreadcrumb,
            ])

            <div class="blog-lienhe-hoptac">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="shadow  padding-content">
                                <div class="group-title">
                                    <div class="title text-left title-red">
                                        {{ $data->name }}
                                    </div>
                                </div>
                                <div class="content-lienhe-hoptac">
                                    {!! $data->content !!}
                                </div>
                                <div class="form-contact-hoptac">
                                    <form  action="{{ route('contact.storeAjax') }}"  data-url="{{ route('contact.storeAjax') }}" data-ajax="submit" data-target="alert" data-href="#modalAjax" data-content="#content" data-method="POST" method="POST" class="row p-75">
                                        @csrf
                                        <div class="col-xs-12 p-75">
                                            <div class="title-form">Thông tin cá nhân</div>
                                        </div>
                                        <div class="form-group col-xs-12 p-75">
                                            <label for="">Họ và tên</label>
                                            <input name="name" type="text" class="form-control" placeholder="Họ và tên" required>
                                        </div>

                                        <div class="form-group col-md-8 col-sm-8 col-xs-12 p-75">
                                            <label for="">Số điện thoại</label>
                                            <input name="phone" type="text" class="form-control" placeholder="Số điện thoại" required>
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-12 p-75">
                                            <label for="" style="width: 100%;">Giới tính</label>
                                            <div class="border-input">
                                                <label class="radio-inline">
                                                    <input type="radio" name="sex" value="Nam">
                                                    <span class="design"></span>
                                                    <span class="text">Nam</span>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="sex" value="Nữ">
                                                    <span class="design"></span>
                                                    <span class="text">Nữ</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 col-sm-12 col-xs-12 p-75">
                                            <label for="">Email</label>
                                            <input name="email" type="text" class="form-control" placeholder="Email">
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12 p-75">
                                            <label for="">Dịch vụ khách hàng quan tâm</label>
                                            <select name="service" class="form-control">
                                                <option value="0" disabled>Chọn dịch vụ</option>
                                                @isset($listCategoryHome)
                                                @foreach ($listCategoryHome as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12 p-75">
                                            <label for="">Tuyến dự định vận chuyển</label>
                                            <div class="row p-75">
                                                <div class="col-md-6 col-sm-6 col-xs-6  p-75">
                                                    <input name="from" type="text" class="form-control" placeholder="Từ">
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6  p-75">
                                                    <input name="to" type="text" class="form-control" placeholder="Đến">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12 p-75">
                                            <label for="">Mong muốn của khách hàng</label>
                                            <textarea name="content" class="form-control" rows="8" placeholder="Mong muốn của khách hàng"></textarea>
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12 p-75">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="" id="agree">Tôi đồng ý với <a href="" target="_blank">Điều khoản dịch vụ</a> </label>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 p-75">
                                            <div class="text-center">
                                                <button name="gone" type="submit" class="btn-view">Gửi yêu cầu</button>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $("#form-contact").submit(function(event) {
                if ($("#agree").prop("checked")) {
                    return true
                } else {
                    alert("Ban phải đồng ý với các điều khoản dịch vụ để tiếp tục");
                    return false;
                }
            });
        });
    </script>


@endsection
@section('js')
<script>

        // ajax load form
        $(document).on('submit',"[data-ajax='submit']",function(){
            let formValues = $(this).serialize();
            let dataInput=$(this).data();
            // dataInput= {content: "#content", href: "#modalAjax", target: "modal", ajax: "submit", url: "http://127.0.0.1:8000/contact/store-ajax"}

            $.ajax({
                type: dataInput.method,
                url: dataInput.url,
                data: formValues,
                dataType: "json",
                success: function (response) {
                    if(response.code==200){
                        if(dataInput.content){
                            $(dataInput.content).html(response.html);
                        }
                        if(dataInput.target){
                            switch (dataInput.target) {
                                case 'modal':
                                    $(dataInput.href).modal();
                                    break;
                                case 'alert':
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: response.html,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                default:
                                    break;
                            }
                        }
                    }else{
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: response.html,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                   // console.log( response.html);
                },
                error:function(response){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
            return false;
        });
    </script>
@endsection
