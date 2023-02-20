
@extends('frontend.layouts.main')
@section('title', $data->name  ?? '' )
@section('keywords', $data->name ??'')
@section('description',$data->description??'')
@section('abstract',$data->name??'')
@section('image', $data->avatar_path?$data->avatar_path:asset('/frontend/images/logo.jpg'))

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('lib/sweetalert2/css/sweetalert2.min.css') }}">
<style>


    @media (max-width: 550px){
        .wrap-slide-home{
            display: none;
        }
    }

</style>
    <div class="content-wrapper">
        <div class="main">
            @include('frontend.partials.header-1')
            @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset

            <div class="wrap-content-main blog-product-detail">
                <div class="container">
                    <div class="row row-75">

                        <div class="col-lg-8 col-md-12 col-sm-12 left-1">
                            <div class="wrap-box-product-detail-top">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="box-image-product">
                                            <div class="image-main block">
                                                <a class="hrefImg" href="{{ asset($data->avatar_path) }}" data-lightbox="image">
                                                    <i class="fas fa-expand-alt"></i>
                                                    <img id="expandedImg" src="{{  asset($data->avatar_path) }}">
                                                </a>
                                                @if ($data->sale)
                                                    <span class="sale"> {{  $data->sale." %"}}</span>
                                                @endif
                                            </div>
                                            @if ($data->images()->count())
                                            <div class="list-small-image">
                                                <div class="pt-box autoplay5-product-detail">
                                                    <div class="small-image column">
                                                        <img src="{{ asset($data->avatar_path) }}" alt="{{ asset($data->name) }}">
                                                    </div>
                                                    @foreach ($data->images as $image)
                                                    <div class="small-image column">
                                                        <img src="{{ asset($image->image_path) }}" alt="{{ asset($image->name) }}">
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="infor-detail-product">
                                            <div class="title-detail">
                                                {{ $data->name }}
                                            </div>
                                            
                                            <div class="wrap-price">
                                                <div class="attr-item">
                                                    <h3>Giá sản phẩm</h3>
                                                    <div class="price">
                                                        @if ($data->price_after_sale)
                                                        <span>Giá:</span> <span id="priceChange">{{ number_format($data->price_after_sale) }} <span class="donvi">VNĐ</span></span>
                                                            @if ($data->sale)
                                                                <span class="old-price">
                                                                    {{ number_format($data->price) }}
                                                                </span>
                                                            @endif
                                                        @else
                                                        Liên hệ
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="desc-pro-detail">
                                                    {{ $data->description }}
                                                </div>
                                                <div class="list-attr">
                                                    {{-- <div class="attr-item">
                                                        <div class="form-group">
                                                            <label for="">Charm</label>
                                                            <select name="" id="input" class="form-control" required="required">
                                                                <option value="">Vui lòng chọn</option>
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                    
                                                    <div class="attr-item">
                                                        <div class="form-group">
                                                            <label for="">Số lượng</label>
                                                            <div class="wrap-add-cart" id="product_add_to_cart">
                                                                <div class="box-add-cart">

                                                                    <div class="pro_mun">
                                                                        <a class="cart_qty_reduce cart_reduce">
                                                                            <span class="iconfont icon fas fa-minus" aria-hidden="true"></span>
                                                                        </a>
                                                                        <input type="text" value="1" class="" name="cart_quantity" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" maxlength="5" min="1" id="cart_quantity" placeholder="">

                                                                        <a class="cart_qty_add">
                                                                            <span class="iconfont icon fas fa-plus" aria-hidden="true"></span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="attr-item">
                                                        <div class="text-left">
                                                            <div class="box-buy">
                                                                <a class="add-to-cart" id="addCart" data-url="{{ route('cart.add',['id' => $data->id,]) }}" data-start="{{ route('cart.add',['id' => $data->id,]) }}">Thêm vào giỏ hàng</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        @if (isset($listOption)&&$listOption->count())
                                        <div class="list-option">
                                            <div class="slider slide_pro_option category-dot-1">
                                                @foreach ($listOption as $option)
                                                <div class="col-item-product-option">
                                                    <div class="item-product-option">
                                                        <div class="box">
                                                            <div class="image">
                                                                <a href="{{ $option->slug }}">
                                                                    <img src="{{ asset(optional($option->supplier)->logo_path) }}" alt="{{ optional($option->supplier)->name }}">
                                                                </a>
                                                            </div>
                                                            <span class="brand">Đề xuất</span>
                                                            <div class="price-pro-option">
                                                                @if ($option->price)
                                                                <span>{{ number_format($option->price) }}</span><span class="unit">đ</span>
                                                                @else
                                                                <span>Liên hệ</span>
                                                                @endif
                                                            </div>
                                                            <div class="text-center">
                                                                <a href="{{ $option->slug }}" class="btn-xemngay">Xem ngay</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="info-product-detail">
                                <h2>Thông tin mô tả: </h2>
                                <div class="content-news">
                                    {!! $data->content !!}
                                </div>
                                <div class="share-with">
                                    <div class="share-article">
                                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-591d2f6c5cc3d5e5"></script>
                                        <div class="addthis_inline_share_toolbox"></div>
                                    </div>
                                </div>
                            </div>

                            @isset($dataRelate)
                                @if ($dataRelate&&$dataRelate->count())

                                    <div class="product-relate">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="title-headding mb-2">
                                                    <div class="bg_img">
                                                        <div class="title-relate">
                                                            <span>Sản phẩm cùng danh mục</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="row">
                                                    <div class="col-sm-12 col-12">
                                                        <div class="list-product-relate autoplay4-pro category-dot-1 row-10">
                                                            @foreach ($dataRelate as $product)
                                                            <div class="col-md-12 col-sm-12 col-12 col-item-product p10">
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
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endif
                            @endisset
                            @include('frontend.components.comment.comment',[
                                'settingComment'=>config('comment.product')
                            ])
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12  right-1" >
                            @if (isset($dataProductHot)&&$dataProductHot)
                                @include('frontend.partials.sidebar-spct',[
                                    'dataProductHot'=>$dataProductHot,
                                    'dataNewHot'=>$dataNewHot,
                                ])
                             @endif
                            {{-- @isset($sidebar)
                                @include('frontend.components.sidebar',[
                                    "categoryProduct"=>$sidebar['categoryProduct'],
                                // "categoryPost"=>$sidebar['categoryPost'],
                                "news"=>$sidebar['news'],
                                "address"=> $sidebar['address'],
                                "bannerTop"=>$sidebar['bannerTop'],
                                "bannerBot"=>$sidebar['bannerBot'],
                                ])
                            @endisset --}}
                        </div>
                        
                        
                    </div>
                </div>
            </div>



        </div>
    </div>


@endsection
@section('js')
<script src="https://cdn.tiny.cloud/1/si5evst7s8i3p2grgfh7i5gdsk2l26daazgefvli0hmzapgn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript" src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.column').click(function() {
                var src = $(this).find('img').attr('src');
                $(".hrefImg").attr("href", src);
                $("#expandedImg").attr("src", src);
            });
        $('.slide_small').slick({
            dots: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 2000,
            responsive: [{
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                }
            }]
        });
        $('.autoplay5-product-detail').slick({
                dots: false,
                vertical:true,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                responsive: [{
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        }
                    }
                ]
            });
    });
</script>
<script>
    var boxnumber = $(' input').val();
            parseInt(boxnumber);
            $('.cart_qty_add').click(function() {
                if ($(this).parent().parent().find('input').val() < 50) {
                    var a = $(this).parent().parent().find('input').val(+$(this).parent().parent().find(
                        'input').val() + 1);
                         let url = $('#addCart').data('start');
                         url += "?quantity=" + $('#cart_quantity').val();
                         $('#addCart').attr('data-url',url);

                }
            });
            $('.cart_qty_reduce').click(function() {
                if ($(this).parent().parent().find('input').val() > 1) {
                    if ($(this).parent().parent().find('input').val() > 1) $(this).parent().parent().find(
                        'input').val(+$(this).parent().parent().find('input').val() - 1);
                        let url = $('#addCart').data('start');
                        url += "?quantity=" + $('#cart_quantity').val();

                        $('#addCart').attr('data-url',url);

                }
            });
</script>
@endsection
