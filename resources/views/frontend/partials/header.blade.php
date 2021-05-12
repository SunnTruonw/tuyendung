<div class="menu_fix_mobile">
    <div class="close-menu">
        <!-- <div class="logo_menu">
            <img class="logo-desk" src="{linkhost}/upload/images/{banner_top}">
        </div> -->
        <a href="javascript:;" id="close-menu-button">
            <i class="fa fa-times" aria-hidden="true"></i>
        </a>
    </div>
    <ul class="nav-main">

        @include('frontend.components.menu',[
            'limit'=>4,
            'icon_d'=>'<i class="fas fa-chevron-down mn-icon"></i>',
            'icon_r'=>'<i class="fas fa-chevron-down mn-icon"></i>',
            'data'=>$header['menu'],
        ])
    </ul>
</div>
<div id="header" class="header">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="box-header-top">
                        <div class="box-social-header-top">
                            <div class="box-info ">
                                <ul>
                                    <li><a href="tel:{{ $header["hotline"]->slug }}" class="phone"><i class="fa fa-phone" aria-hidden="true"></i> {{ $header["hotline"]->value }}</a></li>
                                    <li class="d-none  d-md-block"><a href="mailto:{{ $header["email"]->slug }}" class="email"><i class="fa fa-envelope" aria-hidden="true"></i> {{ $header["email"]->value }}</a></li>
                                    <li class="d-none  d-lg-block"><a href="{{ $header["address"]->slug }}" class="address"><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $header["address"]->value }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="box-social-header-top">
                            <div class="group-social">
                                <ul>
                                    @foreach($header["socialParent"]->childs as $social )
                                    <li class="social-item"><a href="{{ $social->slug }}">{!! $social->value  !!} </a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-main">
        <div class="container">
            <div class="box-header-main">
                <div class="list-bar">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
                <div class="logo-head">
                    <div class="image">
                        <a href="{{ makeLink('home') }}"><img src="{{ $header["logo"]->image_path }}"></a>
                    </div>
                </div>
                <div class="menu menu-desktop">
                    @include('frontend.components.menu',[
                        'limit'=>4,
                        'icon_d'=>'<i class="fas fa-chevron-down"></i>',
                        'icon_r'=>"<i class='fas fa-angle-right'></i>",
                        'data'=>$header['menu'],
                    ])


                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{check_link1}"><span>{name11} </span> </a>
                            <ul class="nav-sub">
                                <li class="nav-sub-item"><a href=""> Về chúng tôi</a>
                                    <ul class="nav-sub-child">
                                        <li class="nav-sub-item-child"><a href=""><i class="fa fa-angle-right" aria-hidden="true"></i> Thông tin công ty</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li> --}}

                </div>
                <div class="search" id="search">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <form class="form_search" id="form1" name="form1" method="get" action="{{ makeLink('search') }}">
                                    <input class="form-control" type="text" name="keyword" placeholder="Nhập từ khóa" required="">
                                    <button class="form-control" type="submit" name="gone22" id="gone22"><i class="fa fa-search" aria-hidden="true"></i></button>
                                    <button class="form-control close-search" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-header-main-right">
                    <ul>
                        <li class="icon-search show_search"><a><i class="fa fa-search" aria-hidden="true"></i></a></li>
                        <li class="cart">
                            <a href="{{ route("cart.list") }}"><img src="{{ asset('frontend/images/bag.png') }}" alt="bag"><span class="number-cart">{{ $header['totalQuantity'] }}</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
