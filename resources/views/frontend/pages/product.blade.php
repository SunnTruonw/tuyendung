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
            <div class="wrap-content-main wrap-template-product template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-sm-12  block-content-right">
                            <h3 class="title-template-news">{{ $category->name??"" }}</h3>
                            @isset($data)
                                <div class="wrap-list-product">
                                    <div class="list-product-card">
                                        <div class="row">
                                            @foreach($data as $product)
                                            <div class="col-md-4 col-sm-4 col-xs-6">
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
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        @if (count($data))
                                        {{$data->links()}}
                                        @endif

                                    </div>
                                </div>
                            @endisset

                        </div>
                        <div class="col-lg-3 col-sm-12 col-xs-12 block-content-left">
                            @isset($sidebar)
                                @include('frontend.components.sidebar',[
                                    "categoryProduct"=>$sidebar['categoryProduct'],
                                    "categoryPost"=>$sidebar['categoryPost'],
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
<script>
    $(function(){
        $(document).on('click','.pt_icon_right',function(){
            event.preventDefault();
            $(this).parentsUntil('ul','li').children("ul").slideToggle();
            $(this).parentsUntil('ul','li').toggleClass('active');
        })
    })
</script>
@endsection
