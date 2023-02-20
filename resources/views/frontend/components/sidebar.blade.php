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
        <div class="title-h">
            <span><i class="fas fa-laptop-house"></i> Tìm nhà theo nhu cầu</span>
        </div>
        <div class="box-form-search-sidebar">
            <form class="" action="{{ makeLink('search') }}">
                <div class="form-group">
                    <select class="form-control" value="{{ old('category_id') }}" name="category_id">
                        <option value="">-- Loại hình --</option>
                        @if (isset($optionCategorySearch))
                            {!! $optionCategorySearch !!}
                        @else
                            {!! $header['htmlselect'] !!}
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <select name="city_id" id="" class="form-control city_s2"
                        data-url="{{ route('ajax.address.districts') }}">
                        <option value="">-- Tỉnh/Thành phố --</option>

                        @if (isset($cityOption))
                            {!! $cityOption !!}
                        @else
                            {!! $header['cities'] !!}
                        @endif

                    </select>
                </div>
                <div class="form-group">
                    <select name="district_id" id="" class="form-control district_s2"
                        data-url="{{ route('ajax.address.communes') }}">
                        <option value="">-- Quận/Huyện --</option>
                        @if (isset($city_id) && $city_id)
                            @foreach (\App\Models\City::find($city_id)->districts as $item)
                                <option value="{{ $item->id }}" {{ $item->id == ($district_id ?? '') ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Tìm kiếm</button>
                </div>
            </form>
        </div>
    </div>
    @isset($bannerTop)
        <div class="side-bar">
            @foreach ($bannerTop->childs()->where('active', 1)->get()
        as $banner)
                <div class="banner-sidebar">
                    <a href="{{ $banner->slug }}">
                        <img src="{{ $banner->image_path }}" alt="{{ $banner->name }}">
                    </a>
                </div>
            @endforeach
        </div>
    @endisset

    {{-- <div class="side-bar">
        @foreach ($categoryPost as $categoryItem)
        <div class="title-sider-bar">
            {{ $categoryItem->name }}
        </div>
        <div class="list-category">
            @include('frontend.components.category',[
                'data'=>$categoryItem->childs,
                'type'=>"category_posts",
            ])
        </div>
        @endforeach
    </div> --}}

    <div class="side-bar">
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

    </div>

    @isset($bannerBot)
        <div class="side-bar">
            @foreach ($bannerBot->childs()->where('active', 1)->get()
              as $banner)
                <div class="banner-sidebar">
                    <a href="{{ $banner->slug }}">
                        <img src="{{ $banner->image_path }}" alt="{{ $banner->name }}">
                    </a>
                </div>
            @endforeach
        </div>
    @endisset

</div>
