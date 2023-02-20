<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title') </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="vi" />
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="@yield('description')" />
    <meta name="abstract" content="@yield('abstract')" />
    <meta name="ROBOTS" content="Metaflow" />
    <meta name="ROBOTS" content="index, follow, all" />
    <meta name="AUTHOR" content="batdongsannamdo.vn" />
    <meta name="revisit-after" content="1 days" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta property="og:image" content="@yield('image')" />
    <meta property="og:image:alt" content="@yield('image')" />

    <meta property="og:url" content="{{ makeLink('home') }}" />
    <meta property="og:type" content="article">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('description')">
    <link rel="canonical" href="{{ makeLink('home') }}" />
    <link rel="shortcut icon" href="{{URL::to('/favicon.ico')}}" />
    <script type="text/javascript" src="{{ asset('lib/jquery/jquery-3.2.1.min.js') }} "></script>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/bootstrap-4.5.3-dist/css/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('font/fontawesome-5.13.1/css/all.min.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('font/font-awesome-4.7.0/css/font-awesome.min.css') }}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/wow/css/animate.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('lib/slick-1.8.1/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/slick-1.8.1/css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/lightbox-plus/css/lightbox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/reset.css') }}">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/stylesheet.css') }}"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/stylesheet-2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/footer.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/cart.css') }}">


	<!-- Global site tag (gtag.js) - Google Ads: 939741330 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-939741330"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){
dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-939741330');
</script>
<!-- Event snippet for Lu?t xem trang conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-939741330/wikbCNjFuMECEJKhjcAD'});
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P3HTS75');</script>
<!-- End Google Tag Manager -->
<style>

.block-thongbao{
    display: flex;
    align-items: center;
    min-height: 100vh;
    justify-content: center;
}
.block-thongbao .container{

max-width: 500px;
}
.box-thongbao{
    background-color: #fff;
    padding: 50px;
    text-align: center;
}
.box-thongbao .title{
    font-size: 30px;
    font-weight: bold;
    margin-bottom: 40px;
}
.box-thongbao .title strong{
    color:red;
}
.box-thongbao .link-list{}
.box-thongbao .link-list ul{
    display: flex;
    justify-content: space-between;
}
.box-thongbao .link-list ul li{}
.box-thongbao .link-list ul li a{}



</style>
</head>

<body class="template-search">

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P3HTS75"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

    <div class="wrapper home">
        <div class="block-thongbao">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box-thongbao">
                            <h3 class="title">
                               {{ $mes1 }}
                            </h3>
                            <div class="link-list">
                                <ul>
                                    <li>
                                        <a href="{{ $urlBack }}" class="btn btn-danger">Trở lại</a>
                                    </li>
                                    <li>
                                        <a href="{{ $urlNext }}" class="btn btn-success">Tiếp tục</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->


    <script type="text/javascript" src="{{ asset('lib/lightbox-plus/js/lightbox-plus-jquery.min.js') }}"></script>

    <!-- Bootstrap 3 -->
    <script type="text/javascript" src="{{ asset('lib/bootstrap-4.5.3-dist/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/wow/js/wow.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('lib/slick-1.8.1/js/slick.min.js') }}"></script>
    <script src="{{asset('lib/sweetalert2/js/sweetalert2.all.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/main.js') }}"></script>
    <script src="{{ asset('lib/components/js/Cart.js') }}"></script>
    <script src="{{ asset('frontend/js/load-address.js') }}"></script>



</body>
</html>
