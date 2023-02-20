@extends('frontend.layouts.main')

@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')

@section('css')
<style type="text/css">
    @media (max-width: 550px){
        .wrap-slide-home{
            display: none;
        }
    }
</style>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="main">

            @if (Route::currentRouteName()=='product.topBanChay')
            <div class="text-left wrap-breadcrumbs">
                <div class="breadcrumbs">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <ul>
                                    <li class="breadcrumbs-item">
                                        <a href="{{ makeLink('home') }}">Trang chủ</a>
                                    </li>
                                    <li class="breadcrumbs-item active"><a href="" class="currentcat">Top bán chạy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            @include('frontend.partials.header-1')
            @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset
            @endif
            <div class="wrap-content-main">
                <div class="container">

                    <div class="row row-75">
                        <div class="col-lg-8 col-md-12 col-sm-12 left-1">
                            <div class="content-home">
                                {{-- <div class="title-h">
                                    <span> {{ $category->name??"" }}</span>
                                 </div> --}}
                                <div class="row row-75" id="dataProductSearch">
                                    @foreach ($data as $product)
                                    <div class="col-lg-3 col-md-6 col-sm-12 col-12 col-item-product p10">
                                        <div class="item-product">
                                            <div class="box">
                                                <div class="image">
                                                    <a href="{{ $product->slug_full }}">
                                                        <img src="{{ asset($product->avatar_path) }}"
                                                            alt="{{ $product->name }}">
                                                    </a>
                                                    @if ($product->sale)
                                                    <div class="sale">
                                                        <strong>-{{ $product->sale }}%</strong>
                                                    </div>
                                                    @endif

                                                </div>
                                                <div class="content">
                                                    <h3 class="name"><a href="{{ $product->slug_full }}">{{ $product->name }}</a></h3>
                                                    <div class="price-pro">
                                                        @if ($product->price)
                                                            @if ($product->sale)
                                                            <div class="new_price">
                                                                <span>Giá: </span>
                                                                <strong class="number-price">{{ number_format($product->price_after_sale) }}</strong>
                                                                <span class="unit">đ</span>
                                                            </div>
                                                            <div class="old_price">
                                                                <strong class="number-price">{{ number_format($product->price) }}</strong>
                                                                <span class="unit">đ</span>
                                                            </div>
                                                            @else
                                                            <div class="new_price">
                                                                <span>Giá: </span>
                                                                <strong class="number-price">{{ number_format($product->price_after_sale) }}</strong>
                                                                <span class="unit">đ</span>
                                                            </div>
                                                            @endif
                                                        @else
                                                        <div class="contact_price">
                                                            <span>Giá: </span>
                                                            <strong class="number-price">Liên hệ</strong>
                                                        </div>
                                                        @endif

                                                    </div>
                                                    <div class="group-action-pro">
                                                        <a class="btn btn-light btn-cart" href="{{ $product->slug_full }}"><i
                                                                class="fas fa-shopping-cart"></i>Mua ngay</a>
                                                        <a  class="btn btn-outline-dark btn-comment"><i
                                                                class="far fa-comment-dots"></i> {{ $product->countComment() }} </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="text-center col-sm-12 col-12">
                                        @if (count($data))
                                            {{$data->links()}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 right-1" >
                            @isset($sidebar)
                                @include('frontend.partials.sidebar',[
                                    "categoryProduct"=>$category,
                                    "supplier"=>$supplier
                                ])
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="#" method="get" name="formfill" id="formfill" class="d-none">
        @csrf
    </form>
@endsection
@section('js')
<script>
    $(document).ready(function(){
      $("#myInputAddress").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myDataAddress .addressItem").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
    $(document).on('change','.field-form',function(){
          // $( "#formfill" ).submit();

           let contentWrap = $('#dataProductSearch');

            let urlRequest = '{{ url()->current() }}';
            let data=$("#formfill").serialize();
            $.ajax({
                type: "GET",
                url: urlRequest,
                data:data,
                success: function(data) {
                    if (data.code == 200) {
                        let html = data.html;
                        contentWrap.html(html);
                    }
                }
            });
        });
        $(document).on('click','.pagination a',function(){
            event.preventDefault();
            let contentWrap = $('#dataProductSearch');
            let href=$(this).attr('href');
            //alert(href);
            $.ajax({
                type: "Get",
                url: href,
            // data: "data",
                dataType: "JSON",
                success: function (response) {
                    let html = response.html;

                    contentWrap.html(html);
                }
            });
        });
    </script>
@endsection
