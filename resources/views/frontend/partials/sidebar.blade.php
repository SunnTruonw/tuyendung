<div id="side-bar">
    {{-- <div class="side-bar">
        @foreach ($categoryProduct as $categoryItem)
        <div class="title-h">
           <span> {{ $categoryItem->name }}</span>
        </div>
        <div class="list-category pt-2">
            @include('frontend.components.category',[
                'data'=>$categoryItem->childs()->get(),
                'type'=>"category_products",
            ])
        </div>
        @endforeach
    </div> --}}

    {{-- @isset($address)
        <div class="side-bar">
            <div class="title-h">
                <span><i class="fas fa-laptop-house"></i> {{ $address->name }}</span>
            </div>
            <div class="list-category pt-2">
                @foreach ($address->childs()->where('active', 1)->get()
    as $item)
                <li class="nav_item">

                    <a href="{{ $item->slug }}"><span>{{ $item->name }}</span>
                    </a>
                </li>
                @endforeach
            </div>
        </div>
    @endisset --}}

    <div class="side-bar">
        @if (isset($categoryProduct)&&$categoryProduct&&$categoryProduct->childs()->where('active',1)->count()>0)
        <div class="title-sider-bar">
           <span> {{ $categoryProduct->name }}</span>
        </div>
        <div class="list-category pt-2">
            @include('frontend.components.category',[
                'data'=>$categoryProduct->childs()->where('active',1)->orderby('order')->latest()->get(),
                'type'=>"category_products",
            ])
        </div>
        @endif
    </div>
    <div class="side-bar">
        @if (isset($supplier)&&$supplier)
        <div class="title-sider-bar">
           <span>Lọc sản phẩm</span>
        </div>
        <div class="list-fill">
            <div class="type-fill">
                Lọc theo cửa hàng
            </div>
            <div  id="myDataAddress">
                <input class="form-control" id="myInputAddress" type="text" placeholder="Lọc khu vực..">
                @php
                @endphp
                <div class="addressItem">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input checkA field-form" form="formfill" name="supplier_id" value="0"
                            {{ old('supplier_id')?'':'checked' }}
                                >
                            Tất cả
                        </label>
                    </div>
                </div>
                @foreach ($supplier as $item)
                <div class="addressItem">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input checkA field-form" name="supplier_id" form="formfill" value="{{ $item->id }}"
                            {{ old('supplier_id') == $item->id?'checked':'' }}
                                >
                            {{ $item->name }}
                        </label>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        @endif

        <div class="list-fill">
            <div class="type-fill">
                Lọc theo giá
            </div>
            <div class="form-group">
                @foreach ( $priceSearch as $item)
                <div class="price_check">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input field-form" name="price" form="formfill" value="{{ $item['value'] }}"
                            {{ $item['value']==($priceS??'')?'checked':'' }}
                                >
                            {{ $item['name'] }}
                        </label>
                    </div>
                </div>
                @endforeach
                {{--
                <select form="formfill" class="form-control field-form" name="price" >
                    <option value="">Giá</option>
                   <option value="{{ $item['value'] }}" {{ $item['value']==($priceS??"")?"selected":"" }}>
                      {{ $item['name'] }}
                    </option>
                </select>
                --}}
            </div>
        </div>
    </div>

    {{-- <div class="side-bar">
        <div class="title-h">
            <span> Tin tức nổi bật</span>
        </div>
        <div class="list-news-sidebar pt-2">
            <ul>
                @foreach ($news as $newsItem)

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
    </div> --}}
</div>
