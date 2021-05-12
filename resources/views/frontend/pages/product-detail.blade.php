
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

             <div class="wrap-content-main wrap-template-product-detail template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <!-- START BLOCK : chitiet -->
                            <div class="wrap-top">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12 col-sm-12">
                                                <div class="product-detail-left-content">
                                                    <div class="image">
                                                        <a class="hrefImg" href="{{ asset($data->avatar_path) }}" data-lightbox="image"><img id="expandedImg" src="{{  asset($data->avatar_path) }}"></a>
                                                        @if ($data->sale)
                                                        {{  $data->sale." %"}}
                                                        @endif
                                                    </div>
                                                    <div class="list-image-small">
                                                        <div class="slider slide_small">
                                                           @foreach ($data->images as $image)
                                                           <div class="column">
                                                                 <img src="{{ asset($image->image_path) }}" alt="{name}">
                                                            </div>
                                                           @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-12 col-sm-12">
                                                <div class="product-information">
                                                    <h1 class="name-product">{{ $data->name }}</h1>
                                                    <div class="box-price-detail">
                                                        <span class="new-price">{{ $data->price." ".$unit }}</span>
                                                        <div class="desc-price">{{( $data->sale? $data->price*(100- $data->sale)/100:$data->price) ." ".$unit }}</div>
                                                    </div>
                                                    <div class="gioi_thieu">
                                                        {!! $data->description  !!}
                                                    </div>

                                                    <div class="product-action">
                                                        <div class="list-btn-action clearfix">
                                                           <a class="btn-add-cart add-to-cart" data-url="{{ route('cart.add',['id' => $data->id,]) }}">Thêm Vào Giỏ Hàng</a>
                                                           <a class="btn-buynow addnow" href="{{ route('cart.buy',['id' => $data->id,]) }}">Mua Ngay</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="wrap-tab-product-detail tab-category-1">
                                <div role="tabpanel">
                                    <!-- Nav tabs -->
                                    <!-- <div class="title">Daily Deals</div> -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="active"><a href="#tab-1" role="tab" data-toggle="tab">Chi tiết sản phẩm</a></li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active show" id="tab-1">
                                            <div class="tab-text">
                                               {!! $data->content !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END BLOCK : chitiet -->
                            <div class="product-relate">
                                <div class="title-1">Sản phẩm liên quan</div>
                                @isset($dataRelate)
                                    @if ($dataRelate->count())
                                        <div class="list-product-card autoplay4">
                                            <!-- START BLOCK : cungloai -->
                                                @foreach($dataRelate as $product)
                                                    <div class="col-md-12">
                                                        <div class="product-card">
                                                            <div class="box">
                                                                <div class="card-top">
                                                                    <div class="image">
                                                                        <a href="{{ $product->slug_full }}">
                                                                            <img src="{{ asset($product->avatar_path) }}" alt="Sofa phòng khách SF08" class="image-card image-default">
                                                                        </a>
                                                                        @if ($product->sale)
                                                                        <span class="sale-1">-{{ $product->sale }}%</span>
                                                                        @endif

                                                                    </div>
                                                                    <ul class="list-quick">
                                                                        <li class="quick-view">
                                                                            <a href="{{ $product->slug_full }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                                        </li>
                                                                        <li class="cart quick-cart">
                                                                            <a class="add-to-cart" data-url="{{ route('cart.add',['id' => $product->id,]) }}"><i class="fas fa-cart-plus"></i></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h4 class="card-name"><a href="{{ $product->slug_full }}">{{ $product->name }}</a></h4>
                                                                    <div class="card-price">
                                                                        <span class="new-price">{{ $product->price_after_sale }} {{ $unit  }}</span>
                                                                        @if ($product->sale>0)
                                                                        <span class="old-price">{{ $product->price }} {{ $unit  }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            <!-- END BLOCK : cungloai -->
                                        </div>
                                    @endif
                                @endisset

                            </div>

                            <!-- <div class="wrap-banner-product">
                                <a href="" class="image-banner">
                                    <img src="../images/banner2.png" alt="">
                                </a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
