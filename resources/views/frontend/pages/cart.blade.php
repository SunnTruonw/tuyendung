@extends('frontend.layouts.main')
@section('title', 'Trang chủ')
@section('css')
   <style>
        .container-cart{
            max-width: 600px;
        }
        .template-search{
            background: #eee;
        }
        .title-cart{
            font-size: 15px;
            font-weight: 600;
            margin: 0;
            margin-bottom: 20px;
        }
        .bg-cart{
            background: #fff;
        }
        .bg-address{
            background: #eee;
            padding: 10px;
        }
        .form-buy{
            padding: 30px;
        }
        .buy-more:before {
            content: "";
            width: 8px;
            height: 8px;
            border-top: 1px solid #288ad6;
            border-left: 1px solid #288ad6;
            display: inline-block;
            vertical-align: middle;
            margin: 0 3px 2px 0;
            transform: rotate(-45deg);
        }
        .buy-more {
          color:  #288ad6;
        }
   </style>
@endsection



@section('content')
    <div class="content-wrapper">
        <div class="main">
            <div class="container container-cart">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex justify-content-between align-item-center pt-3 pb-3">
                            <a href="{{ route('home.index') }}" class="buy-more">Xem thêm sản phẩm</a>
                            <a data-url="{{ route('cart.clear') }}" class="clear-cart">Xóa tất cả</a>
                        </div>
                        <div class="bg-cart">
                            <div class="row">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="panel panel-danger">
                                        @include('frontend.components.cart-component',[
                                        ])
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-buy">
                                        <form action="{{ route('cart.order.submit') }}" method="POST" enctype="multipart/form-data" id="buynow">
                                            @csrf
                                            <h2 class="title-cart">
                                                Điền thông tin người mua
                                            </h2>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">Họ và tên</label>
                                                        <input type="text" class="form-control" id="" name="name" placeholder="Họ và tên">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Email</label>
                                                        <input type="email" class="form-control" id="" name="email" placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Số điện thoại</label>
                                                        <input type="text" class="form-control" id="" name="phone" placeholder="Số điện thoại">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-address">
                                                <h2 class="title-cart">
                                                    Địa chỉ người nhận
                                                </h2>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Tỉnh/Thành phố</label>
                                                            <select name="city_id" id="city" class="form-control" required="required" data-url="{{ route('ajax.address.districts') }}">
                                                                <option value="">Chọn tỉnh/thành phố</option>
                                                                {!! $cities !!}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Quận/huyện</label>
                                                            <select name="district_id" id="district" class="form-control" required="required" data-url="{{ route('ajax.address.communes') }}">
                                                                <option value="">Chọn quận/huyện</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Xã/phường/thị trấn </label>
                                                            <select name="commune_id" id="commune" class="form-control" required="required">
                                                                <option value="">Chọn xã/phường/thị trấn</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Địa chỉ cụ thể </label>
                                                            <input type="text" name="address_detail" class="form-control" id="" placeholder="Địa chỉ cụ thể">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="">Yêu cầu khác </label>
                                                            <input type="text" name="note" class="form-control" id="" placeholder="Yêu cầu khác (không bắt buộc)">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary d-block w-100">Submit</button>
                                        </form>
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
<script src="{{ asset('frontend/js/load-address.js') }}"></script>
@endsection
