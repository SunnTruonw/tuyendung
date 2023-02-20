@extends('frontend.layouts.main')
@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')

@section('content')
    <div class="content-wrapper">
        <div class="main">
            @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset

            <div class="wrap-content-main wrap-template-contact template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
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
                                        <textarea name="content" class="tinymce_editor_init_s" placeholder="Thông tin thêm" id="noidung" cols="30" rows="5"></textarea>
                                        <button class="hvr-float-shadow"  >Gửi thông tin</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="contact-infor">
                                <div class="infor">
                                    @isset($dataAddress)
                                        <div class="address">
                                            <div class="footer-layer">
                                                <div class="title">
                                                {{ $dataAddress->value }}
                                                </div>
                                                <ul class="pt_list_addres">
                                                @foreach ($dataAddress->childs as $item)
                                                <li>{!! $item->slug !!} {{ $item->value }}</li>
                                                @endforeach

                                                </ul>
                                            </div>
                                        </div>
                                    @endisset
                                    @isset($map)
                                        <div class="map">
                                            {!! $map->description !!}
                                        </div>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="modalAjax">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Chi tiết đơn hàng</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
             <div class="content" id="content">

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

<script src="https://cdn.tiny.cloud/1/si5evst7s8i3p2grgfh7i5gdsk2l26daazgefvli0hmzapgn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>

        // ajax load form


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
    </script>
@endsection
