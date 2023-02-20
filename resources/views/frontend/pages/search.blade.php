@extends('frontend.layouts.main')
@section('title', $seo['title'] ?? 'Kết quả tìm kiếm')
@section('keywords', $seo['keywords'] ?? 'Kết quả tìm kiếm')
@section('description', $seo['description'] ?? 'Kết quả tìm kiếm')
@section('abstract', $seo['abstract'] ?? 'Kết quả tìm kiếm')
@section('image', $seo['image'] ?? 'Kết quả tìm kiếm')
@section('content')
    <div class="content-wrapper">
        <div class="main">
            <div class="content-search">
                <div class="wrap-content-search">
                    <div class="box-content-search">
                        <div class="line_top"></div>
                        <div class="logo-s">
                            <a href="{{ makeLink('home') }}"><img src="{{ asset($header['logo']->image_path) }}"
                                    alt="Logo" /></a>
                        </div>
                        <h3>{{ $contentSearch->name }}</h3>
                        <div class="desc-s">
                            {!! $contentSearch->value !!}
                        </div>
                        @if (isset($dataFirst) && $dataFirst)
                            <div class="info-pro">

                                <div class="thongtin_left">
                                    <h2>THÔNG TIN KHÁCH HÀNG</h2>
                                    <ul>
                                        @if (!empty($dataFirst->name_chunha) && $dataFirst->name_chunha && strlen($dataFirst->name_chunha) > 0)
                                            <li>Họ và tên: <strong>{{ $dataFirst->name_chunha }}</strong></li>
                                        @else
                                            @if(!empty($data[1]) && strlen($data[1]->name_chunha) > 0)<li>Họ và tên: <strong>{{  $data[1]->name_chunha  }}</strong></li> @endif
                                        @endif

                                        @if (!empty($dataFirst->phone_chunha) && $dataFirst->phone_chunha && strlen($dataFirst->phone_chunha) > 0)
                                            <li>Số điện thoại: <strong>{{ $dataFirst->phone_chunha }}</strong></li>
                                        @else
                                            @if(!empty($data[1]) && strlen($data[1]->phone_chunha) > 0)<li>Số điện thoại: <strong>{{  $data[1]->phone_chunha  }}</strong></li> @endif
                                        @endif

                                        @if (!empty($dataFirst->city) && $dataFirst->city && strlen($dataFirst->city->name) > 0) 
                                            <li>Địa chỉ: <strong>{{ $dataFirst->city->name }}</strong></li>
                                        @else
                                            @if(!empty($data[1]->city))<li>Địa chỉ: <strong>{{  $data[1]->city->name ?? ''  }}</strong></li> @endif
                                        @endif
                                        @if (!empty($dataFirst->donvithicong) && $dataFirst->donvithicong)
                                            <li>Địa điểm thi công: <strong> {{ $dataFirst->donvithicong }}</strong></li>
                                        @else
                                            @if(!empty($data[1]))<li>Địa chỉ: <strong>{{  $data[1]->donvithicong  }}</strong></li> @endif
                                        @endif
                                        @if (!empty($dataFirst->type_car) && $dataFirst->type_car)
                                            <li>Dòng xe: <strong> {{ $dataFirst->type_car }}</strong></li>
                                        @else
                                            @if(!empty($data[1]))<li>Địa chỉ: <strong>{{  $data[1]->type_car  }}</strong></li> @endif
                                        @endif
                                        <li>
                                            Số khung/ Biển số: <strong><span
                                                    class="hot-text">{{ $dataFirst->masp }}</span></strong>
                                        </li>
                                    </ul>
                                </div>

                                <div class="thongtin_right">
                                    <img src="{{ asset('frontend/images/oto-xpel-icon.png') }}" alt="oto-xpel-icon" />
                                </div>
                                @foreach ($data as $product)
                                    <div class="use_services">
                                        @if ($loop->first)
                                            <h2>Dịch vụ sử dụng</h2>
                                        @elseif($loop->index === 1)
                                            <h2>Dịch vụ phát sinh</h2>
                                        @else
                                        @endif
                                        <div class="box-service-product">
                                            <div class="item-service-product">
                                                <div class="d-flex">
                                                    <div class="col-item-3 bg_active">
                                                        <div class="warpper-title">
                                                            <span class="title-use-services">Tên sản phẩm</span>
                                                        </div>
                                                    </div>
                                                    @if (isset($attributes) && $attributes)
                                                        @foreach ($attributes as $attribute)
                                                            <div class="col-item-3">
                                                                <div class="warpper-title">
                                                                    <span
                                                                        class="title-use-services">{{ $attribute->name }}</span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="item-service-product">
                                                <div class="d-flex">
                                                    <div class="col-item-3 bg_active">
                                                        <div class="warpper-title">
                                                            <span class="title-use-services active">Gói dịch vụ</span>
                                                        </div>
                                                    </div>

                                                    @if (isset($attributes) && $attributes && count($product->attributes) > 0)
                                                        @foreach ($attributes as $attribute)
                                                            <div class="col-item-3">
                                                                <div class="warpper-title">
                                                                    @foreach ($attribute->childs()->orderby('id')->get() as $k => $attr)
                                                                        <span
                                                                            class="title-use-services2">{{ $product->attributes->pluck('id')->contains($attr->id) ? $attr->name : '' }}</span>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        @if ($product->check_btn == 1 || $product->time_buy)
                                                            <div class="col-item-3">
                                                                <div class="warpper-title">
                                                                    <span class="title-use-services2">Phim cách nhiệt ô
                                                                        tô</span>
                                                                </div>
                                                            </div>
                                                            @if ($product->check_btn2 == 1 || $product->time_buy1)
                                                                <div class="col-item-3">
                                                                    <div class="warpper-title">
                                                                        <span class="title-use-services2">Phim bảo vệ bề
                                                                            mặt</span>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-item-3">
                                                                    <div class="warpper-title">
                                                                        <span class="title-use-services2"></span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if ($product->check_btn3 == 1 || $product->time_buy2)
                                                                <div class="col-item-3">
                                                                    <div class="warpper-title">
                                                                        <span class="title-use-services2">Phim bảo vệ
                                                                            sơn</span>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <div class="col-item-3">
                                                                    <div class="warpper-title">
                                                                        <span class="title-use-services2"></span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endif

                                                    {{-- @if (isset($product->attributes) && $product->attributes)
                                                        @foreach ($product->attributes()->orderBy('order')->get() as $attr)
                                                        <div class="col-item-3">
                                                            <div class="warpper-title">
                                                            <span class="title-use-services">{{$attr->name}}</span>
                                                            
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    @endif --}}
                                                </div>
                                            </div>
                                            <div class="item-service-product">
                                                <div class="d-flex">
                                                    <div class="col-item-3 bg_active">
                                                        <div class="warpper-title">
                                                            <span class="title-use-services active">Vị trí </span>
                                                        </div>
                                                    </div>
                                                    @php
                                                        // $dataAttr = \App\Models\ProductAttributeChild::where('product_id', $product->id)->get();
                                                        // // list taat car attribute co
                                                        // $listIdAttr = $dataAttr->pluck('attribute_id')->unique()->toArray();
                                                        // //get id attrbite
                                                        // $childAttr1 = \App\Models\Attribute::where('parent_id', 2)->pluck('id')->toArray();
                                                        // $childAttr2 = \App\Models\Attribute::where('parent_id', 4)->pluck('id')->toArray();
                                                        // $childAttr3 = \App\Models\Attribute::where('parent_id', 3)->pluck('id')->toArray();
                                                        // //filter data mapching
                                                        // $mappching1 = array_intersect($childAttr1, $listIdAttr);
                                                        // $mappching2 = array_intersect($childAttr2, $listIdAttr);
                                                        // $mappching3 = array_intersect($childAttr3, $listIdAttr);
                                                    @endphp
                                                    @if (isset($attributes) && $attributes)
                                                        @foreach ($attributes as $attribute)
                                                            <div class="col-item-3">
                                                                <div class="warpper-title">
                                                                    @foreach ($attribute->childs()->orderby('id')->get() as $k => $attr)
                                                                        @foreach ($attr->options as $item)
                                                                            @php
                                                                                $checkAttrId = $product->attributeChilds->pluck('attribute_product_id')->contains($item->id);
                                                                            @endphp
                                                                            @if ($checkAttrId)
                                                                                <div class="warpper-title2">
                                                                                    <span
                                                                                        class="attribite-item">{{ $item->name }}
                                                                                        {{-- - <span
                                                                                            style="color: red">{{ number_format($item->value ?? 0, 0, ',', '.') }}</span> --}}</span>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    {{-- @if (isset($product->attributes) && $product->attributes)
                                        @foreach ($product->attributes as $attr)
                                          <div class="col-item-3">
                                              @foreach ($dataAttr as $item)
                                                @if ($item->attribute_id == $attr->id)
                                                  <div class="warpper-title">
                                                    <span class="attribite-item">{{ $item->name }} - <span style="color: red">{{number_format($item->value ?? 0, 0, ',', '.')}}</span></span>
                                                  </div>
                                                @endif
                                              @endforeach
                                          </div>
                                        @endforeach
                                      @endif --}}
                                                </div>
                                            </div>

                                            <div class="item-service-product">
                                                <div class="d-flex">
                                                    <div class="col-item-3 bg_active">
                                                        <div class="warpper-title">
                                                            <span class="title-use-services active">Ngày thi công</span>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-item-3">
                                        <div class="warpper-title">

                                          @if ((!empty($product->attributes) && count($product->attributes) > 0 && count($mappching1) > 0) || $product->check_btn == 1)
                                              <span class="title-use-services2">{{ Carbon::parse($product->time_buy)->format('d/m/Y') }}</span>
                                          @else
                                              <span class="title-use-services3">Đang cập nhật!</span>
                                          @endif
                                        </div>
                                      </div> --}}

                                                    @if (isset($attributes) && $attributes)
                                                        @foreach ($attributes as $attribute)
                                                            @php
                                                                $time_start = $attribute->time_start;

                                                                if (!empty($product->$time_start)){
                                                                    $krr    = explode('/', $product->$time_start);
                                                                    if (!empty($krr[2]) && strlen($krr[2]) == 4) {
                                                                        $date_return = $product->$time_start;
                                                                        list($month, $day, $year) = explode('/', $date_return);
                                                                        $__time_start =  $month.'/'.$day.'/'.$year;
                                                                    }else{
                                                                        $date_return = \Carbon\Carbon::parse($product->$time_start)->format('d/m/Y');
                                                                        list($month, $day, $year) = explode('/', $date_return);
                                                                        $__time_start =  $month.'/'.$day.'/'.$year;
                                                                    }
                                                                }
                                                            @endphp
                                                            <div class="col-item-3">
                                                                <div class="warpper-title">
                                                                    {{-- @if ($product->attributes->pluck('parent_id')->contains($attribute->id)) --}}
                                                                    @if ($product->$time_start)
                                                                        <span
                                                                            class="title-use-services2">{{ $__time_start ?? '' }}</span>
                                                                    @else
                                                                        <span class="title-use-services3"></span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>


                                            <div class="item-service-product">
                                                <div class="d-flex">
                                                    <div class="col-item-3 bg_active">
                                                        <div class="warpper-title">
                                                            <span class="title-use-services active">Thời gian bảo
                                                                hành</span>
                                                        </div>
                                                    </div>

                                                    @if (isset($attributes) && $attributes)
                                                        @foreach ($attributes as $attribute)
                                                            @php
                                                                $time_start = $attribute->time_start;

                                                                if (!empty($product->$time_start)){
                                                                    $krr    = explode('/', $product->$time_start);
                                                                    if (!empty($krr[2]) && strlen($krr[2]) == 4) {
                                                                        $date_return = $product->$time_start;
                                                                        list($month, $day, $year) = explode('/', $date_return);
                                                                        $_time_start =  $month.'/'.$day.'/'.$year;
                                                                    }else{
                                                                        $date_return = \Carbon\Carbon::parse($product->$time_start)->format('d/m/Y');
                                                                        list($month, $day, $year) = explode('/', $date_return);
                                                                        $_time_start =  $month.'/'.$day.'/'.$year;
                                                                    }
                                                                }

                                                            @endphp
                                                            <div class="col-item-3">
                                                                <div class="warpper-title">
                                                                    {{-- @if ($product->attributes->pluck('parent_id')->contains($attribute->id)) --}}
                                                                    @if ($product->$time_start)
                                                                        <span class="title-use-services2">{{ $_time_start ?? '' }}</span>
                                                                    @else
                                                                        <span class="title-use-services3"></span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="item-service-product">
                                                <div class="d-flex">
                                                    <div class="col-item-3 bg_active">
                                                        <div class="warpper-title">
                                                            <span class="title-use-services active">Thời gian kết
                                                                thúc</span>
                                                        </div>
                                                    </div>

                                                    @if (isset($attributes) && $attributes)
                                                        @foreach ($attributes as $attribute)
                                                            @php
                                                                $time_end = $attribute->time_end;

                                                                if (!empty($product->$time_end)){
                                                                    $krr    = explode('/', $product->$time_end);
                                                                    if (!empty($krr[2]) && strlen($krr[2]) == 4) {
                                                                        $date_return = $product->$time_end;
                                                                        list($month, $day, $year) = explode('/', $date_return);
                                                                        $_time_end =  $month.'/'.$day.'/'.$year;
                                                                    }else{
                                                                        $date_return = \Carbon\Carbon::parse($product->$time_end)->format('d/m/Y');
                                                                        list($month, $day, $year) = explode('/', $date_return);
                                                                        $_time_end =  $month.'/'.$day.'/'.$year;
                                                                    }
                                                                }
                                                            @endphp
                                                            <div class="col-item-3">
                                                                <div class="warpper-title">
                                                                    @if ($product->$time_end)
                                                                        <span
                                                                            class="title-use-services2">{{ $_time_end ?? '' }}</span>
                                                                    @else
                                                                        <span class="title-use-services3"></span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="item-service-product">
                                                <div class="d-flex">
                                                    <div class="col-item-3 bg_active">
                                                        <div class="warpper-title">
                                                            <span class="title-use-services active">Thời gian còn lại</span>
                                                        </div>
                                                    </div>
                                                    @if (isset($attributes) && $attributes)
                                                        @foreach ($attributes as $attribute)
                                                            @php
                                                                $time_end = $attribute->time_end;

                                                                if (!empty($product->$time_end)){
                                                                    $krr    = explode('/', $product->$time_end);
                                                                    $startTime = \Carbon\Carbon::now()->subDays(1);

                                                                    if (!empty($krr[2]) && strlen($krr[2]) == 4) {
                                                                        $date_return = $product->$time_end;
                                                                        list($month, $day, $year) = explode('/', $date_return);
                                                                        $date =  \Carbon\Carbon::createFromFormat('d/m/Y', $month.'/'.$day.'/'.$year);
                                                                    }else{

                                                                        $date_return = \Carbon\Carbon::parse($product->$time_end)->format('d/m/Y');
                                                                        list($month, $day, $year) = explode('/', $date_return);
                                                                        $date =  \Carbon\Carbon::createFromFormat('d/m/Y', $month.'/'.$day.'/'.$year);
                                                                    }
                                                                }
                                                                // dd($date, $startTime, $date->diffInDays($startTime));

                                                            @endphp
                                                            <div class="col-item-3">
                                                                <div class="warpper-title">
                                                                    @if(isset($startTime) && isset($date) && $product->$time_end && $startTime->gt($date))
                                                                        <span class="title-use-services2">Đã hết hạn</span>
                                                                    @elseif(isset($startTime) && isset($date) && $product->$time_end)
                                                                        <span class="title-use-services2">{{$date->diffInDays($startTime)}} ngày</span>
                                                                    @else
                                                                        <span class="title-use-services2"></span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($product->content)
                                        <div class="note">
                                            <div class="d-flex">
                                                <div class="col-item-3">
                                                    <div class="label-note">
                                                        <span>Ghi chú</span>
                                                    </div>
                                                </div>
                                                <div class="col-item-9">
                                                    <div class="content-note">
                                                        {!! $product->content !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="tks">
                                <img src="{{ asset('frontend/images/tks.png') }}" alt="tks" />
                            </div>
                        @else
                            <h3>"Số Khung bạn tìm không có. Xin vui lòng kiểm tra lại"</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
