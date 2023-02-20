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

            <div class="blog-about-us">

                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                           <div class="bg-while p-3">
                            <div class="about-text">

                                <div class="title-h mb-3">
                                    <span> {{$data->name}}</span>
                                 </div>
                                <div class="desc-about">
                                   {!! $data->content !!}
                                </div>
                            </div>

                            <div class="contact-form">
                                <div class="desc-form mb-2">
                                    @if (isset($contactContentForm)&&$contactContentForm)
                                    {!! $contactContentForm->value !!}
                                    @endif

                                </div>
                                <div class="form" >


                                    <form  action="{{ route('contact.storeAjax') }}"  data-url="{{ route('contact.storeAjax') }}" data-ajax="submit" data-target="alert" data-href="#modalAjax" data-content="#content" data-method="POST" method="POST">
                                        @csrf
                                        <input type="text" placeholder="Họ và tên" required="required" name="name">
                                        {{-- <input type="text" placeholder="Email" required="required" name="email"> --}}
                                        <input type="text" placeholder="Số điện thoại" required="required" name="phone">
                                        <textarea class="tinymce_editor_init_s" name="content" placeholder="Thông tin thêm" id="noidung" cols="30" rows="5"></textarea>
                                        <button class="hvr-float-shadow"  >Gửi thông tin</button>
                                    </form>
                                </div>
                            </div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12" >
                            @isset($sidebar)
                                @include('frontend.components.sidebar',[
                                    "categoryProduct"=>$sidebar['categoryProduct'],
                                // "categoryPost"=>$sidebar['categoryPost'],
                                "news"=>$sidebar['news'],
                                "address"=> $sidebar['address'],
                                "bannerTop"=>$sidebar['bannerTop'],
                                "bannerBot"=>$sidebar['bannerBot'],
                                ])
                            @endisset
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



@endsection
@section('js')
<script src="https://cdn.tiny.cloud/1/si5evst7s8i3p2grgfh7i5gdsk2l26daazgefvli0hmzapgn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  
  <script>
        $(function(){
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

            let editor_config = {
                path_absolute: "/",
                selector: 'textarea.tinymce_editor_init_s',
                relative_urls: false,
                plugins: [
                    "advlist autolink lists link  charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime  nonbreaking save table directionality",
                    "emoticons template paste textpattern"
                ],
                toolbar: " undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link ",

            };
        if ($("textarea.tinymce_editor_init_s").length) {
            tinymce.init(editor_config);
        }
        });
    </script>
@endsection
