@extends('frontend.layouts.main')
@section('title', optional($header['seoHome'])->name)
@section('keywords', optional($header['seoHome'])->slug)
@section('description', optional($header['seoHome'])->value)
@section('image', asset(optional($header['seoHome'])->image_path))
@section('content')
    <div class="content-wrapper">
        <div class="main">
            <div class="box-home" style="background-image: url({{ asset(optional($contentHome)->image_path) }})">
				<div class="box-home-in">
					<div class="content-home">
						<div class="logo">
							<img src="{{ asset($header['logo']->image_path) }}" alt="Logo">
						</div>
						<h3>{{ optional($contentHome)->name }}</h3>
						<div class="box-form-search">
							<form action="{{ route('home.search') }}" id="form_check" method="GET" role="form">
								<div class="box_search">
									<i class="fa fa-user" aria-hidden="true"></i>
									<input type="text" class="form-control keyword" name="keyword" placeholder="Quý khách vui lòng nhập Số khung tại đây!">
								</div>
								<input type="hidden" name="check" value="1">
								<div class="form-dn"><button type="submit" class="btn btn-primary">Check ngay <i class="fa fa-caret-right" aria-hidden="true"></i></button></div>
							</form>
							<div class="text_nd text-center">
								Khách hàng vui lòng điền thông tin theo mẫu</br> Số khung: RLM0G4CB8KV007xxx
								{{--@auth
								<a href="{{ route('profile.index') }}" class="btn btn-default dang-nhap">Đại lý: {{ auth()->user()->name }}</a>
								@else
								<a href="{{ route('login') }}" class="btn btn-default dang-nhap">ĐĂNG KÝ - ĐĂNG NHẬP</a>
								@endauth--}}
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
@endsection
{{-- @guest

@else
    @if(Auth::guard('web')->check())
    <li>
        <div class="dropdown-login">
            <a class="dropdown-toggle" href="{{ route('profile.editInfo') }}">
                <i class="fas fa-user"></i> {{ auth()->user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('profile.index') }}">  <i class="fas fa-user"></i>  Tài khoản</a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Thoát
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </li>
    @endif
@endguest --}}

@section('js')
	<script>
		$(document).on('submit','#form_check',function(){
            let keyword = $('.keyword').val();
            let check = $('.check').val();
			let urlRequest = '{{route('home.search')}}';

			if(keyword == '' || keyword.replace(/\s/g, '').length < 1){
				var errorName = false;
			}

			if(errorName == false){
				formError();
				$('.text_nd').text('"Số khung bạn tìm không có. Xin vui lòng kiểm tra lại!"');
				return false;
			}

			$.ajax({
				type: "GET",
				url: urlRequest,
				data:{keyword, check},
				success: function(data) {
					window.location.href = "/search?keyword="+keyword;
				},
				error: function(data) {
					formError();
					$('.text_nd').text('"Số khung bạn tìm không có. Xin vui lòng kiểm tra lại!"');
				},
			});
			return false;
		});

		function formError(){
			$(".text_nd").addClass('red shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
				$(this).removeClass('shake animated');
			});
		}

		
	</script>

{{-- <script>
	$(document).on('submit','#form_check',function(){
		let keyword = $('.keyword').val();
		let urlRequest = 'route('product.search')';

		console.log(keyword);

		return false;

		if(!keyword || keyword == '' || keyword.length == 0){
			$('.text_nd').addClass('red').text('"Số khung bạn tìm không có. Xin vui lòng kiểm tra lại!"');
			return false;
		}else{
			// $.ajax({
			// 	type: "GET",
			// 	url: urlRequest,
			// 	data:keyword,
			// 	success: function(data) {
			// 		if (data.code == 200) {
			// 		}else{
			// 			$('.text_nd').addClass('red').text('"Số khung bạn tìm không có. Xin vui lòng kiểm tra lại!"');
			// 		}
			// 	},
			// 	error: function(data) {
			// 		$('.text_nd').addClass('red').text('"Số khung bạn tìm không có. Xin vui lòng kiểm tra lại!"');
			// 	},
			// });
			// return false;
		}

		return false;
	});
</script> --}}
@endsection



