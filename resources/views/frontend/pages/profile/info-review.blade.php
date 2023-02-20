@extends('frontend.layouts.main')

@section('title', optional($header['seoHome'])->name)
@section('keywords', optional($header['seoHome'])->slug)
@section('description', optional($header['seoHome'])->value)
@section('image', asset(optional($header['seoHome'])->image_path))
@section('css')
    <style>
        .list-link-info{
            display: flex;
    justify-content: center;
        }
        .list-link-info li {
             margin: 0 5px;
        }
.list-link-info li a {
    border: 1px solid #ccc;
}
.list-link-info li.active a {
    background-color: #f38c13;
    border-color: #f38c13;
    color: #fff;
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
                                    <li class="breadcrumbs-item active"><a href="" class="currentcat">{{ $data->username }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrap-content-main">
                <div class="container">

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="content-home">
                                <ul class="list-link-info">

                                    @if ($data->isCreateShop())
                                    <li class="{{ Route::currentRouteName()=="profile.infoProduct"?'active':'' }}"><a href="{{ route('profile.infoProduct',['username'=>$data->username,'id'=>$data->id]) }}"  class="btn btn-default">Sản phẩm của shop</a></li>
                                    @endif

                                    <li class="{{ Route::currentRouteName()=="profile.infoReview"?'active':'' }}"><a href="{{ route('profile.infoReview',['username'=>$data->username,'id'=>$data->id]) }}" class="btn btn-default">Các bài review</a></li>
                                </ul>

                                <div class="row row-75">
                                    <div class="list-review col-sm-12 col-12" id="dataReviewSearch">
                                        @include('frontend.components.ajax-search.load-review',['data'=>$dataReview])
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
