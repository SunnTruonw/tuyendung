@foreach ($data as $product)
<div class="col-card-news-horizontal col-md-12">
    <div class="card-news-horizontal">
        <div class="box">
            <div class="d-flex">
                <div class="icon"><img src="{{ asset('frontend/images/icon-new.png') }}" alt="icon"></div>
                    <div class="content-2">
                    <h3>
                        <a href="{{ $product->slug_full }}">{{ $product->name }}</a>
                    </h3>
                    <div class="desc">
                        {{ $product->description }}
                    </div>
                    </div>
            </div>
            <div class="content">

                <div class="image">
                    <a href="{{ $product->slug_full }}"><img src="{{ $product->avatar_path?$product->avatar_path:$shareFrontend['noImage'] }}" alt="{{ $product->name }}"></a>
                </div>
                <div class="info">
                    <ul>
                        <li>
                            <ul>
                                <li class="dientich_in"><i class="fas fa-chart-area"></i> <strong>Diện tích: </strong> <span>{{ $product->dientich }} m2</span> </li>
                                <li class="price_in">
                                <i class="fas fa-dollar-sign"></i> <strong>Giá:</strong>
                                <span class="red">
                                    @if ($product->donvi==1)
                                    @else
                                    {{  transMoneyToView($product->price,$product->donvi)  }}
                                    @endif
                                    @if ($product->donvi){{$donvi[$product->donvi]['name'] }}@endif
                                </span>
                                </li>

                                <li class="phone_in">
                                    <i class="fas fa-phone-volume"></i> <strong> Hotline: </strong>
                                    <span class="red">
                                        @if ($product->user_id)
                                            <a href="tel:{{ $product->user->phone }}">
                                                {{ $product->user->phone }}
                                            </a>
                                        @endif
                                    </span>
                                </li>
                                {{-- <li class="caledar_in">
                                    <i class="fas fa-calendar-week"></i> <strong></strong> <span class="gray">{{ date_format($product->created_at,'d/m/Y') }}</span>
                                </li> --}}
                            </ul>


                        </li>

                        <li class="desc_bb">
                            <i class="fas fa-map-marker-alt"></i>
                            {{-- <strong>Khu vực</strong> <span>: {{ $product->address_detail }} ,@if ($product->commune_id)  {{ $product->commune->name }} , @endif  --}}
                                @if ($product->district_id)  {{ $product->district->name }} , @endif
                                @if ($product->city_id)  {{ $product->city->name }}  @endif </span>
                            </li>
                    </ul>
                </div>
                {{-- <div class="date">{{ date_format($product->created_at,'d/m/Y') }}</div> --}}
            </div>
        </div>
    </div>
</div>

@endforeach
<div class="col-md-12">
    {{ $data->appends(request()->all())->links() }}
</div>
