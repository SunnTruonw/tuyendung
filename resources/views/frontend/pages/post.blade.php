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
            @include('frontend.partials.header-post')
            @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset

            <div class="wrap-content-main">
                <div class="container">
                    <div class="row row-75">
                        <div class="col-lg-8 col-md-12 col-sm-12 left-1">
                            <div class="content-home">
                                <div class="title-detail">
                                    <span> {{ $category->name??"" }}</span>
                                </div>
                                <div class="list-post">
                                    <div class="row row-75">
                                        @foreach ($data as $post)
                                        <div class="col-lg-4  col-md-6 col-sm-6 col-12 fo-03-col-news">
                                            <div class="fo-03-news">
                                                <div class="box">
                                                    <div class="image">
                                                        <a href="{{ makeLink('post',$post->id,$post->slug) }}"><img src="{{ asset($post->avatar_path) }}" alt="{{ $post->name }}"></a>
                                                    </div>
                                                    <div class="content">
                                                        <h3><a href="{{ makeLink('post',$post->id,$post->slug) }}">{{ $post->name }}</a></h3>
                                                        <div class="desc">{!! $post->description  !!}</div>
                                                        <div class="block-action-news">
                                                            <a href="{{ makeLink('post',$post->id,$post->slug) }}" class="xemthem">Xem thêm</a>
                                                            <span class="date">{{ date_format($post->updated_at,"d/m/Y")}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                @if (count($data))
                                    {{$data->links()}}
                                @endif
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
