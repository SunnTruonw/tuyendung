@extends('frontend.layouts.main-profile')

@section('title', $seo['title'] ?? '')
@section('keywords', $seo['keywords'] ?? '')
@section('description', $seo['description'] ?? '')
@section('abstract', $seo['abstract'] ?? '')
@section('image', $seo['image'] ?? '')
@section('css')
    <style>
        .info-box {
            box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
            border-radius: .25rem;
            background-color: #fff;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 1rem;
            min-height: 80px;
            padding: .5rem;
            position: relative;
            width: 100%;
        }

        .info-box .info-box-icon {
            border-radius: .25rem;
            -ms-flex-align: center;
            align-items: center;
            display: -ms-flexbox;
            display: flex;
            font-size: 1.875rem;
            -ms-flex-pack: center;
            justify-content: center;
            text-align: center;
            width: 60px;
            flex: 0 0 auto;
        }

        .info-box .info-box-content {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            line-height: 1.8;
            -ms-flex: 1;
            flex: 1;
            padding: 0 10px;
        }

        .info-box .info-box-text,
        .info-box .progress-description {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .info-box .info-box-number {
            display: block;
            margin-top: .25rem;
            font-weight: 700;
        }

        .card-title {
            font-size: 25px;
            font-weight: bold;
            margin-top: 0;
        }


        @media (max-width: 550px) {
            .wrap-slide-home {
                display: none;
            }
        }

    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        @if ($user->active == 0)
            <div class="col-md-12">
                <div class="alert alert-danger" style=" font-size: 150%;">
                    <strong>warning!</strong> Tài khoản của bạn chưa được kích hoạt <br>
                    <span style="font-size: 14px;">(Các thông số tài khoản sẽ là thông số của tài khoản sau khi được kích
                        hoạt)</span>
                </div>
            </div>
        @elseif($user->active==2)
            <div class="col-md-12">
                <div class="alert alert-danger" style=" font-size: 150%;">
                    <strong>warning!</strong> Tài khoản của bạn đã bị khóa <br>
                </div>
            </div>
        @endif
        @if (session('alert'))
            <div class="alert alert-success">
                {{ session('alert') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-warning">
                {{ session('error') }}
            </div>
        @endif
        <div class="item-profile">
            <h3 class="title-profile">Thống kế các mã bảo hành của tôi</h3>
            <div class="list-count">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-calculator"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Số sản phẩm đã đăng </span>
                                <span class="info-box-number"><strong>{{ $totalProduct}}</strong>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($user->active == 1)
        <div class="row">
            <div class="col-md-12">
                @if (session('alert'))
                    <div class="alert alert-success">
                        {{ session('alert') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-warning">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="d-flex justify-content-between ">
                    <a href="{{ route('profile.createProduct') }}" class="btn  btn-info btn-md mb-2">+ ĐĂNG MÃ BẢO HÀNH</a>
                </div>

                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="card-tools w-100 mb-3">
                            <form action="{{ route('profile.index') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="form-group col-md-6 mb-0">
                                                <input id="keyword" value="{{ $keyword }}" name="keyword" type="text" class="form-control" placeholder="Nhập Biển số, Số khung, số Roll">
                                                <div id="keyword_feedback" class="invalid-feedback"></div>
                                            </div>
                                            <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                <select id="order" name="order_with" class="form-control">
                                                    <option value="">-- Sắp xếp theo --</option>
                                                    <option value="dateASC" {{ $order_with == 'dateASC' ? 'selected' : '' }}>Tăng dần</option>
                                                    <option value="dateDESC" {{ $order_with == 'dateDESC' ? 'selected' : '' }}>Giảm dần</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                <select  name="city_id" class="form-control">
                                                    <option value="">-- Tỉnh thành phố --</option>
                                                    @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}" {{ $city->id==request()->city_id?'selected':'' }} >{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <div class="row">
                                                    <div class="col-md-12 mb-1">
                                                        <div class="form-group mb-0">
                                                            <label for="">Ngày bắt đầu</label>
                                                            <div class="d-inline-block mr-1">
                                                                <input type="date"
                                                                    class="form-control @error('start') is-invalid  @enderror"
                                                                    placeholder="" id="" name="start"
                                                                    value="{{ $start }}">
                                                                @error('start')
                                                                    <div class="invalid-feedback">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <label for="">Ngày Kết thúc:</label>
                                                            <div class="d-inline-block">

                                                                <input type="date"
                                                                    class="form-control @error('end') is-invalid  @enderror"
                                                                    placeholder="" id="" name="end"
                                                                    value="{{ $end }}">
                                                                @error('end')
                                                                    <div class="invalid-feedback">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                            {{-- <div class="form-group col-md-3 mb-0" style="min-width:100px; display: none">
                                            <select id="" name="fill_action" class="form-control">
                                                <option value="">-- Lọc --</option>
                                                <option value="hot" {{ $fill_action=='hot'? 'selected':'' }}>Sản phẩm hot</option>
                                                <option value="no_hot" {{ $fill_action=='no_hot'? 'selected':'' }}>Sản phẩm không hot</option>
                                                <option value="active" {{ $fill_action=='active'? 'selected':'' }}>Sản phẩm hiển thị</option>
                                                <option value="no_active" {{ $fill_action=='no_active'? 'selected':'' }}>Sản phẩm bị ẩn</option>
                                            </select>
                                        </div> --}}
                                            {{-- <div class="form-group col-md-3 mb-0" style="min-width:100px; display: none">
                                            <select id="categoryProduct" name="category" class="form-control">
                                                <option value="">-- Tất cả danh mục --</option>
                                                {!!$option!!}
                                            </select>
                                        </div> --}}
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-0 mt-2">
                                        <button type="submit" class="btn btn-success w-40"> Tìm kiếm </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-tools text-right pl-3 pr-3 pt-2 pb-2">
                        <div class="count">
                            {{-- Tổng số bản ghi <strong>{{  $data->count() }}</strong> / {{ $totalProduct }} --}}
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0 lb-list-category">
                        <table class="table table-head-fixed" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th>Thông tin</th>
                                    <th>Số khung</th>
                                    <th>Loại xe</th>
                                    <th>BKS</th>
                                    <th>Rollid</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày hết hạn</th>
                                    <th>Thành phố</th>

                                    <th style="width:100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $productItem)
                                    <tr>

                                        {{-- <td>{{$productItem->masp}}</td> --}}
                                        <td>
                                            <ul>
                                                <li><strong>Họ tên</strong> {{ $productItem->name_chunha }}</li>
                                                <li><strong>Điện thoại</strong> {{ $productItem->phone_chunha }}
                                                </li>
                                                <li><strong>Địa chỉ</strong> {{ $productItem->address_chunha }}
                                                </li>
                                            </ul>
                                        </td>
                                        <td>{{ $productItem->masp }}</td>
                                        <td>{{ $productItem->type_car }}</td>
                                        <td>{{ $productItem->bienkiemsoat }}</td>
                                        <td>{{ $productItem->rollid }}</td>
                                        <td>{{ Carbon::parse($productItem->time_buy)->format('d/m/Y') }}</td>
                                        <td>{{ Carbon::parse($productItem->time_expires)->format('d/m/Y') }}</td>

                                        {{-- <td class="text-nowrap"><strong>{{ number_format($productItem->price) }}</strong></td> --}}
                                        {{-- <td class="text-nowrap"  style="text-align: center; font-weight:600;">{{$productItem->view}}</td> --}}
                                        {{-- <td>{{$productItem->stores()->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total? $productItem->stores()->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total:0 }}</td>
                                        <td class="text-nowrap">
                                            {{$productItem->stores()->whereIn('type',[2,3])->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total? $productItem->stores()->whereIn('type',[2,3])->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total:0 }}
                                        </td> --}}
                                                {{-- <td><img src="{{ asset($productItem->avatar_path) }}"
                                                            alt="{{ $productItem->name }}" style="width:80px;"></td>
                                                    <td class="wrap-load-active"
                                                        data-url="{{ route('profile.loadActiveProduct', ['id' => $productItem->id]) }}">
                                                        @include('admin.components.load-change-active',['data'=>$productItem,'type'=>'sản
                                                        phẩm'])
                                                    </td> --}}
                                                {{-- <td class="wrap-load-hot" data-url="{{ route('profile.loadHotProduct',['id'=>$productItem->id]) }}">
                                            @include('admin.components.load-change-hot',['data'=>$productItem,'type'=>'sản phẩm'])
                                        </td> --}}
                                                {{-- <td>{{optional($productItem->category)->name}}</td> --}}
                                                {{-- <td>
                                            <ul>
                                                <li>
                                                    <strong>Tên</strong> {{optional($productItem->admin)->name}} <br>
                                                    <strong>Email</strong> {{optional($productItem->admin)->email}}
                                                </li>
                                            </ul>
                                        </td> --}}
                                        <td>{{ optional($productItem->city)->name }}</td>
                                        <td>
                                            <a href="{{ route('profile.editProduct', ['id' => $productItem->id]) }}"
                                                class="btn btn-sm btn-info">Sửa</a>
                                            {{-- <form  action="{{ route('profile.updateToTop',['id'=>$productItem->id]) }}" method="POST" class="d-inline-block">
                                               @csrf
                                               <button class="btn btn-sm btn-success">Up top</button>
                                              </form> --}}
                                            <a data-url="{{ route('profile.destroyProduct', ['id' => $productItem->id]) }}"
                                                class="btn btn-sm btn-danger lb_delete">Xoá</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                @if ($data->count()>0)
                {{$data->appends(request()->input())->links()}}
                @endif
            </div>
        </div>
        @endif
    </div>
@endsection
@section('js')
    <script>
        $(function() {
            $(document).on('click', '.pt_icon_right', function() {
                event.preventDefault();
                $(this).parentsUntil('ul', 'li').children("ul").slideToggle();
                $(this).parentsUntil('ul', 'li').toggleClass('active');
            })
        })
    </script>
@endsection
