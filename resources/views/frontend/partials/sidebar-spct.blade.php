<div class="side-bar">
    <div class="title-h">
        <span>Tin nổi bật</span>
    </div>
    <div class="list-news-sidebar pt-2">
        <ul>
            @foreach ($dataNewHot as $newsItem)
                <li>
                    <div class="box">
                        <div class="image">
                            <a href="{{ $newsItem->slug_full }}">
                                <img src="{{ $newsItem->avatar_path }}" alt="{{ $newsItem->name }}">
                            </a>
                        </div>
                        <div class="content">
                            <h3><a href="{{ $newsItem->slug_full }}">{{ $newsItem->name }}</a></h3>
                            <div class="date">
                                Ngày đăng {{ date_format($newsItem->created_at, 'd/m/Y') }}
                            </div>
                        </div>

                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="side-bar">
    <div class="title-h">
        <span>Sản phẩm đáng quan tâm</span>
    </div>
    <div class="list-news-sidebar pt-2">
        <ul>
            @foreach ($dataProductHot as $product)
                <li>
                    <div class="box">
                        <div class="image">
                            <a href="{{ $product->slug_full }}">
                                <img src="{{ $product->avatar_path }}" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="content">
                            <h3><a href="{{ $product->slug_full }}">{{ $product->name }}</a></h3>
                            <div class="price-pro">
                                @if ($product->price)
                                    @if ($product->sale)
                                    <div class="new_price">
                                        <span>Giá: </span>
                                        <strong class="number-price">{{ number_format($product->price_after_sale) }}</strong>
                                        <span class="unit">đ</span>
                                    </div>
                                    <div class="old_price">
                                        <strong class="number-price">{{ number_format($product->price) }}</strong>
                                        <span class="unit">đ</span>
                                    </div>
                                    @else
                                    <div class="new_price">
                                        <span>Giá: </span>
                                        <strong class="number-price">{{ number_format($product->price_after_sale) }}</strong>
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
                        </div>

                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
