

@extends('frontend.layouts.main')
@section('title', 'Trang chủ')

@section('content')
    <div class="content-wrapper">
        <div class="main">
            <h1 class="d-none">
                {h1trangchu}
            </h1>
            <h2 class="d-none">
                {h2trangchu}
            </h2>
            <div class="slide">
                @isset($slider)
                    <div class="box-slide faded">
                        @foreach ($slider as $item)
                            <div class="item-slide">
                                <a href="{link}"><img src="{{ $item->image_path }}" alt="{{ $item->name }}"></a>
                            </div>
                        @endforeach
                    </div>
                @endisset
            </div>
            <div class="section-1">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="group-title">
                                <h3 class="title title-underline">Danh mục sản phẩm</h3>
                                <div class="desc">
                                    Chúng tôi cung cấp đa dạng các dòng nội thất khác nhau trong các lĩnh vực từ văn phòng, trường học, gia đình cho đến các công trình công cộng.
                                </div>
                            </div>
                            @isset($listCategory)
                                <div class="list-card">
                                    <div class="row">
                                        @foreach ($listCategory as $category)
                                            <div class="col-md-2 col-sm-4 col-xs-6">
                                                <div class="card">
                                                    <a href="{{ $category->slug_full }}" class="box">
                                                        <div class="image">
                                                            <img src="{{  $category->avatar_path }}" alt="{{  $category->name }}">
                                                        </div>
                                                        <h3>{{  $category->name }}</h3>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="group-title">
                                <h3 class="title title-underline">Sản phẩm nổi bật</h3>
                            </div>
                            <div class="row">
                                @isset($productHot)
                                    @foreach($productHot as $product)
                                    <div class="col-lg-3 col-md-4 col-sm-6">
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
                                @endisset
                            </div>
                            <div class="box-view-all hidden-xs hidden-sm box-view-all-mobile">
                                <a href="{linkhost}/san-pham.html" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="section-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="group-title">
                                <h3 class="title title-underline">Sản phẩm mới</h3>
                            </div>
                            <div class="row">
                                @isset($productNew)
                                    @foreach($productNew as $product)
                                    <div class="col-lg-3 col-md-4 col-sm-6">
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
                                @endisset
                            </div>
                            <div class="box-view-all hidden-xs hidden-sm box-view-all-mobile">
                                <a href="{linkhost}/san-pham.html" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="section-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="group-title">
                                <h3 class="title title-underline">Sản phẩm xem nhiều</h3>
                            </div>
                            <div class="row">
                                @isset($productView)
                                    @foreach($productView as $product)
                                    <div class="col-lg-3 col-md-4 col-sm-6">
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
                                @endisset
                            </div>
                            <div class="box-view-all hidden-xs hidden-sm box-view-all-mobile">
                                <a href="{linkhost}/san-pham.html" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="section-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="group-title">
                                <h3 class="title title-underline">Sản phẩm mua nhiều</h3>
                            </div>
                            <div class="row">
                                @isset($productPay)
                                    @foreach($productPay as $product)
                                    <div class="col-lg-3 col-md-4 col-sm-6">
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
                                @endisset
                            </div>
                            <div class="box-view-all hidden-xs hidden-sm box-view-all-mobile">
                                <a href="{linkhost}/san-pham.html" class="view-all">Xem tất cả <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="section-2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            @isset($bannerHome)
                                <!-- START BLOCK : quang_cao_home -->
                                <div class="banner">
                                    <a href="{{ $bannerHome->slug }}"><img src="{{ $bannerHome->image_path }}" alt="{{ $bannerHome->name }}"> </a>
                                </div>
                                <!-- END BLOCK : quang_cao_home -->
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
            <!--
            <div class="section-6">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">

                            <div class="box-text">
                                <h4>OUR STORIES</h4>
                                <h3>We design <br> everything we make.
                                </h3>
                                <div class="desc">
                                    Sed cursus turpis vitae tortor. Curabitur ligula sapien, tincidunt non, euismod posuere imperdiet, leo. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Nullam cursus lacinia erat. Nulla sit amet est.
                                </div>
                                <div class="box-about">
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" id="Capa_1" height="512" viewBox="0 0 512 512" width="512"><g><path d="m373.489 364.092c-33.329-8.401-58.793-14.952-68.238-45.384 28.932-15.432 49.831-44.01 54.673-77.708h1.076c33.423 0 60-28.112 60-61 0-10.925-2.949-21.167-8.072-30h23.072c8.284 0 15-6.716 15-15s-6.716-15-15-15h-75v-45c0-41.355-33.645-75-75-75h-60c-41.355 0-75 33.645-75 75v45c-33.084 0-60 26.916-60 60 0 32.894 26.584 61 60 61h1.076c4.842 33.698 25.74 62.276 54.673 77.708-9.473 30.52-35.346 37.093-68.238 45.384-51.068 12.874-107.511 29.199-107.511 132.908 0 8.284 6.716 15 15 15h420c8.284 0 15-6.716 15-15 0-95.348-45.592-117.298-107.511-132.908zm-222.489 27.784c10.202-2.599 20.486-5.39 30.305-9.194 3.332 38.256 35.336 69.318 74.695 69.318 39.338 0 71.361-31.038 74.695-69.317 9.818 3.804 20.103 6.594 30.305 9.194v90.123h-210zm240-211.876c0 16.804-13.738 31-30 31v-61c16.542 0 30 13.458 30 30zm-210-105c0-24.813 20.187-45 45-45h60c24.813 0 45 20.187 45 45v45h-30v-45c0-8.284-6.716-15-15-15h-60c-8.284 0-15 6.716-15 15v45h-30zm90 45h-30v-30h30zm-150 60c0-16.542 13.458-30 30-30v61c-16.262 0-30-14.196-30-31zm60 46v-76h150v76c0 41.355-33.645 75-75 75s-75-33.645-75-75zm75 105c7.206 0 14.244-.731 21.045-2.12 4.899 14.946 12.828 27.07 23.955 36.647v10.473c0 24.935-20.607 46-45 46s-45-21.065-45-46v-10.473c11.127-9.578 19.055-21.701 23.955-36.647 6.801 1.389 13.839 2.12 21.045 2.12zm-135 68.987v82.013h-59.516c3.416-50.491 22.941-70.304 59.516-82.013zm270 82.013v-82.013c36.415 11.658 56.081 31.242 59.516 82.013z"></path></g></svg>
                                        <span>About us</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            -->
            <section class="pt_section_62">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="group-title">
                                <h3 class="title title-underline">Tin tức nổi bật</h3>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 wrap-news-card">

                                <div class="row">
                                    @isset($postsHot)
                                        <!-- START BLOCK : tin_tuc -->
                                        @foreach ($postsHot as $item)
                                        <div class="fo-03-news col-lg-4 col-md-6 col-sm-6">
                                            <div class="box">
                                                <div class="image">
                                                    <a href="{{ $item->slug_full }}"><img src="{{ asset($item->avatar_path) }}" alt="{{ $item->name }}"></a>
                                                </div>
                                                <h3><a href="{{ $item->slug_full }}">{{ $item->name }}</a></h3>
                                                <div class="date">{{ date_format($item->updated_at,"d/m/Y")}} - Admin Bivaco</div>
                                                <div class="desc">
                                                    {!! $item->description  !!}
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <!-- END BLOCK : tin_tuc -->
                                    @endisset

                                </div>

                        </div>
                    </div>
                </div>
            </section>

            <script type="text/javascript">
                function scrollToAboutUs() {
                    $('html, body').animate({
                        scrollTop: $(".du_an3").offset().top - 90
                    }, 1000);
                }
            </script>

            <!--
            <div class="section-6">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="wrap-left">
                                <div class="wrap-1">
                                    <div class="wrap-email">
                                        <div class="box">
                                            <div class="icon">
                                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                            </div>
                                            <h3>Join now and get 10% off your next purchase!</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="wrap-2">
                                    <div class="text">
                                        Subscribe to the weekly newsletter for all the latest updates
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-7 col-xs-12">
                            <div class="box-form">
                                <form action="/action_page.php">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="search">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        -->
        </div>
    </div>
@endsection
@section('js')

@endsection
