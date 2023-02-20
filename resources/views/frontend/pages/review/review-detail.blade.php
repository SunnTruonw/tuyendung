@extends('frontend.layouts.main')

@section('title', $data->name )
@section('keywords', $data->name)
@section('description', $data->name)
@section('abstract', $data->name)
@section('image', asset($data->avatar_path))

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
@if(session("alert"))
<script>
    alert('{{session("alert")}}');
</script>
@endif
    <div class="content-wrapper">
        <div class="main">
            <div class="text-left wrap-breadcrumbs">
                <div class="breadcrumbs">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <ul>
                                    <li class="breadcrumbs-item">
                                        <a href="{{ makeLink('home') }}">Trang chủ</a>
                                    </li>
                                    <li class="breadcrumbs-item"><a href="" class="currentcat">Review</a></li>
                                    <li class="breadcrumbs-item"><a href="" class="currentcat">{{ $data->name }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap-content-main block-review-detail">
                <div class="container">
                    <div class="row row-75">
                        <div class="col-lg-8 col-md-12 col-sm-12  left-1">
                            <div class="content-home">
                                <div class="review-detail">
                                    <h1>{{ $data->name }}</h1>
                                    <ul class="list-info-post">
                                        <li class="date">
                                            <i class="fa fa-calendar"></i>{{ date_format($data->created_at,'d/m/Y') }}</li>
                                        <li class="view"><i class="fas fa-eye"></i>{{ $data->view }}</li>
                                        <li class="comment"><i class="fas fa-comment-dots"></i>{{ $data->comments()->count() }}
                                        </li>
                                    </ul>
                                    <div class="link-book">
                                        Đường dẫn sách: <a href="{{ $data->link }}">{{ $data->link }}</a>
                                    </div>
                                    <div class="desc">
                                        {{ $data->description }}
                                    </div>
                                    <div class="image">
                                        @if ($data->avatar_path)
                                            <img src="{{ asset($data->avatar_path) }}" alt="{{ $data->name }}">
                                        @endif
                                    </div>
                                    <div class="content">
                                        {!! $data->content !!}
                                    </div>
                                    <div class="image-child">
                                        @foreach ($data->images as $image)
                                            <img src="{{ asset($image->image_path) }}" alt="{{ $data->name.'-'.($loop->index+1) }}">
                                        @endforeach
                                    </div>
                                </div>
                                @include('frontend.components.comment.comment',[
                                    'settingComment'=>config('comment.review')
                                ])
                            </div>

                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 col-12 right-1">
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
<script src="https://www.google.com/recaptcha/api.js?hl=vi" async defer></script>
<script type="text/javascript">
    var onloadCallback = function() {
    };
</script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=vi" async defer>
</script>
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
