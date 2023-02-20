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
            @include('frontend.partials.header-1')
            @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset


            <div class="wrap-content-main blog-news-detail">
                <div class="container">
                    <div class="row row-75">
                        <div class="col-lg-8 col-md-12 col-sm-12 left-1">
                            <div class="content-detail-news">
                                {{-- <div class="title-h mb-3">
                                    <span> {{ $category->name??"" }}</span>
                                </div> --}}

                                <div class="title-detail">
                                    {{ $data->name }}
                                </div>
                                <div class="author">
                                    <div class="date">
                                        <div class="year">{{ date_format($data->created_at,"d/m/Y") }}</div>
                                    </div>
                                </div>
                                <div class="image">
                                    <img src=" {{ $data->avatar_path }}" alt="{{ $data->name }}">
                                </div>
                                <div class="box_content">

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
                                    @if ($dataRelate)
                                        @if ($dataRelate->count())

                                        <div class="news_rale">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="title-headding mb-2">
                                                        <div class="bg_img">
                                                            <div class="title-relate">
                                                                <span>Tin tức liên quan</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <ul class="list_news_lq">
                                                        @foreach ($dataRelate as $item)
                                                        <li><a href="{{ makeLink('post',$item->id,$item->slug) }}">{{ $item->name }}</a></li>
                                                        @endforeach

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endif
                                @endisset
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 right-1" >
                            @if (isset($dataProductHot)&&$dataProductHot)
                            @include('frontend.partials.sidebar-spct',[
                                'dataProductHot'=>$dataProductHot,
                                'dataNewHot'=>$dataNewHot,
                            ])
                        @endif

                        @include('frontend.partials.sidebar-review-top')
                        @include('frontend.partials.sidebar-user-top')
                        </div>
                    </div>
                </div>
            </div>



            {{-- <div class="blog-news-detail">
                <div class="container">
                    <div class="row p-75 d-flex before-after-unset">
                        <div class="col-md-8 col-sm-12 col-xs-12 block-content-left p-75">
                            <div class="news-detail shadow padding-content">
                                <div class="title-detail">
                                    {{ $data->name }}
                                </div>
                                <div class="author">
                                    <div class="date">
                                        <div class="year">{{ date_format($data->created_at,"d/m/Y") }}</div>
                                    </div>
                                </div>
                                <div class="image">
                                    <img src=" {{ $data->avatar_path }}" alt="{{ $data->name }}">
                                </div>
                                <div class="box_content">

                                    <div class="content-news">

                                        {!! $data->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 block-content-right p-75" id="side-bar">
                            <div class="fix-sidebar">
                                <div class="side-bar shadow">
                                    <div class="title-sider-bar">
                                        <span>Tin tức nổi bật</span>
                                    </div>
                                    <div class="list-trending">

                                        <ul>
                                            @isset($post_hot)
                                            @foreach ($post_hot as $item)
                                            <li>
                                                <div class="box">
                                                    <div class="icon">
                                                        <a href="{{ makeLink('post',$item->id,$item->slug) }}"><img src="{{ $item->avatar_path }}" alt="{{ $item->name }}"></a>
                                                    </div>
                                                    <div class="content">

                                                        <h3 class="name">
                                                            <a href="{{ makeLink('post',$item->id,$item->slug) }}">{{ $item->name }}</a>
                                                        </h3>
                                                        <div class="desc">
                                                            {{ $item->description }}
                                                        </div>
                                                        <div class="text-right">
                                                            <div class="date">
                                                                {{ date_format($item->created_at,"d/m/Y") }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                            @endisset
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div> --}}

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
<script src="{{ asset('frontend/js/Comment.js') }}">
</script>
<script>
    console.log($('div').createFormComment());
</script>
@endsection
