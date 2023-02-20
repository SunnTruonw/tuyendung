{{-- @extends('layouts.app') --}}
@extends('frontend.layouts.main')
@section('title', 'Đăng nhập tài khoản')
@section('keywords', 'Đăng nhập tài khoản')
@section('description', 'Đăng nhập tài khoản')
@section('abstract', 'Đăng nhập tài khoản')
@section('image', asset(optional($header['seoHome'])->image_path))
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/auth.css') }}">
@endsection
@section('content')
<div class="wrapper-in">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-warning">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('statusSuccess'))
                    <div class="alert alert-success">
                        {{ session('statusSuccess') }}
                    </div>
                @endif
                <div class="box-auth" id="login">
                    <div class="box-center__body">
                        <div class="box-center__form auth">
                            <div class="auth-right">
								<div class="auth-image">
                                    <img src="{{ asset(optional($data)->image_path) }}" alt="{{ optional($data)->name }}">
                                </div>
                                <div class="auth-title">ĐẠI LÝ ĐÃ CÓ TÀI KHOẢN VUI LÒNG ĐĂNG NHẬP:</div>
                                <div class="auth-form">
                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Tên đăng nhập :</label>
                                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                                placeholder="Tên đăng nhập" required="" value="{{ old('username') }}">
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Mật khẩu:</label>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Mật khẩu" required="">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <a href="{{ route('password.request') }}" target="blank"
                                                class="forgot-password">Quên mật khẩu?</a>
                                        </div>
                                        <div class="form-group checkbox">
                                            <input type="checkbox" class="btn-checkbox" name="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label for="remember-me">Ghi nhớ đăng nhập</label>
                                        </div>
                                        <div class="form-submit">
                                            {{-- <input type="hidden" id="has_comment" value="false"> --}}
                                            <button type="submit" class="btn btn-primary">Đăng nhập</button>
                                        </div>
                                    </form>
                                </div>
								<div class="auth-title">ĐẠI LÝ CHƯA CÓ TÀI KHOẢN:</div>
                                <div class="auth-action">
                                    <a href="{{ route('register') }}" class="btn btn-blue">Đăng ký tài khoản</a>
                                </div>
                                {{-- <div class="auth-title">Đăng nhập với:</div>
                                <div class="auth-social">
                                    <a href="{{ route('login.social', ['social' => 'facebook']) }}"
                                        class="btn btn-blue">
                                        <i class="fab fa-facebook-f"></i>
                                        Đăng nhập với Facebook</a>
                                    <a href="{{ route('login.social', ['social' => 'google']) }}" class="btn btn-red">
                                        <i class="fab fa-google"></i> Đăng nhập với Google</a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
