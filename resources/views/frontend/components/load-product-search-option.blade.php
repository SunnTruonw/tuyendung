@isset($data)
   <div class="col-sm-12 col-12">
    @if (isset($countProduct)&&$countProduct)
       <h2 class="count-search">Đã tìm thấy {{ $countProduct??0 }} sản phẩm</h2>
    @else
       <h2 class="count-search">Không tìm thấy sản phẩm nào</h2>
    @endif
   </div>
    @foreach ($data as $option)
    <div class="col-lg-3 col-md-6 col-sm-12 col-12 col-item-product p10">
        <div class="item-product">
            <div class="box">
                <div class="image">
                    <a href="{{ $option->slug }}">
                        <img src="{{ asset(optional($option->product)->avatar_path) }}"
                            alt="{{ optional($option->product)->name }}">
                    </a>
                    @if ($option->sale)
                    <div class="sale">
                        <strong>-{{ $option->sale }}%</strong>
                    </div>
                    @endif
                </div>
                <div class="content">
                    <h3 class="name"><a href="{{ $option->slug }}">{{ optional($option->product)->name }}</a></h3>
                    <div class="price-pro">
                        @if ($option->price)
                            @if ($option->sale)
                            <div class="new_price">
                                <span>Giá: </span>
                                <strong class="number-price">{{ number_format($option->price_after_sale) }}</strong>
                                <span class="unit">đ</span>
                            </div>
                            <div class="old_price">
                                <strong class="number-price">{{ number_format($option->price) }}</strong>
                                <span class="unit">đ</span>
                            </div>
                            @else
                            <div class="new_price">
                                <span>Giá: </span>
                                <strong class="number-price">{{ number_format($option->price_after_sale) }}</strong>
                                <span class="unit">đ</span>
                            </div>
                            @endif
                        @else
                        <div class="contact_price">
                            <span>Giá: </span>
                            <strong class="number-price">Liên hệ</strong>
                        </div>
                        @endif
                    </div>
                    {{-- <div class="group-action-pro">
                        <a href="" class="btn btn-light btn-cart"><i
                                class="fas fa-shopping-cart"></i>Mua ngay</a>
                        <a href="" class="btn btn-outline-dark btn-comment"><i
                                class="far fa-comment-dots"></i> 12 </a>
                    </div> --}}
                    <div class="supplier">
                        <div class="name-sup">
                            {{ $supplier->name }}
                        </div>
                        <div class="image-sup">
                            <img src="{{ asset($supplier->logo_path) }}" alt="{{ $supplier->name }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="col-md-12">
        @if (count($data))
        {{$data->appends(request()->all())->links()}}
        @endif
    </div>
@endisset
