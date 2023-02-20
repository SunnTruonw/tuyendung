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
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap-content-main block-review">
                <div class="container">

                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-sm-12 left-1">
                            <div class="content-home">
                                @if (isset($data)&&$data)
                                <div class="list-review">
                                    <div class="row">
                                        @foreach ($data as $review)
                                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="card-item-main">
                                                <div class="box">
                                                    <div class="image">
                                                        <a href="{{ route('review.detail',['id'=>$review->id,'slug'=>$review->slug]) }}">
                                                            <img src="{{ asset($review->avatar_path) }}"   alt="{{ $review->name }}">
                                                        </a>
                                                    </div>
                                                    <div class="content">
                                                        <h3><a href="{{ route('review.detail',['id'=>$review->id,'slug'=>$review->slug]) }}">{{ $review->name }}</a>
                                                        </h3>
                                                        <ul class="list-info-post">
                                                            <li class="date">
                                                                <i class="fa fa-calendar"></i>{{ date_format($review->created_at,'d/m/Y') }}</li>
                                                            <li class="view"><i class="fas fa-eye"></i>{{ number_format($review->view) }}</li>
                                                            <li class="comment"><i class="fas fa-comment-dots"></i>{{ $review->comments()->count() }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="text-center">
                                        @if (count($data))
                                        {{$data->links()}}
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>

                        </div>
                        {{-- <div class="col-lg-4 col-md-12 col-sm-12" >

                            @isset($sidebar)
                                @include('frontend.components.sidebar',[
                                    "categoryProduct"=>$sidebar['categoryProduct'],
                                // "categoryPost"=>$sidebar['categoryPost'],
                                "news"=>$sidebar['news'],
                                "address"=> $sidebar['address'],
                                "bannerTop"=>$sidebar['bannerTop'],
                                "bannerBot"=>$sidebar['bannerBot'],
                                ])
                            @endisset
                        </div> --}}
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
