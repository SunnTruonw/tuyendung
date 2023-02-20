@extends('admin.layouts.main')
@section('title',"Danh sách bảo hành")
@section('css')

@endsection
@section('control')
@endsection
@section('content')
<style>
.juti-betwen{
    justify-content: space-between;
    align-items: center;
}



</style>
<div class="content-wrapper lb_template_list_product">
    
    @include('admin.partials.content-header',['name'=>"Bảo hành","key"=>"Danh sách bảo hành"])
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row juti-betwen">
                <div>
                    <a href="{{route('admin.product.create')}}" class="btn btn-info btn-md mb-2">+ Thêm mới</a>
                </div>
                <div class="group-button-right d-flex">
                    <form id="import-excel" action="{{route('admin.product.import.excel.database')}}" class="form-inline" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group" style="max-width: 250px">
                            <input id="file-eccel" type="file" class="form-control-file" name="fileExcel" accept=".xlsx" required>
                            </div>
                        <input type="submit" value="Import Excel" class=" btn btn-info ml-1 import-excel">
                    </form>
                </div>
                
            </div>

        <div class="row">
            @if(session("alert"))
            <div class="alert alert-success">
                {{session("alert")}}
            </div>
            @elseif(session('error'))
            <div class="alert alert-warning">
                {{session("error")}}
            </div>
            @endif
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <div class="card-tools w-100 mb-3">
                            <form action="{{ route('admin.product.index') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="form-group col-md-3 mb-0">
                                                <input id="keyword" value="{{ $keyword }}" name="keyword"
                                                    type="text" class="form-control"
                                                    placeholder="Nhập số khung, dòng xe">
                                                <div id="keyword_feedback" class="invalid-feedback">

                                                </div>
                                            </div>
                                            <div class="form-group col-md-2 mb-0" style="min-width:100px;">
                                                <input type="date"
                                                    class="form-control @error('start') is-invalid  @enderror"
                                                    placeholder="" id="" name="start"
                                                    value="{{ $start }}">
                                            </div>

                                            <div class="form-group col-md-2 mb-0" style="min-width:100px;">
                                                <input type="date"
                                                    class="form-control @error('end') is-invalid  @enderror"
                                                    placeholder="" id="" name="end"
                                                    value="{{ $end }}">
                                            </div>

                                            <div class="form-group col-md-2 mb-0" style="min-width:100px;">
                                                <select  name="city_id" class="form-control">
                                                    <option value="">-- Tỉnh thành phố --</option>
                                                    @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}" {{ $city->id==request()->city_id?'selected':'' }} >{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 mb-0" style="min-width:100px;">
                                                <select id="categoryProduct" name="category" class="form-control">
                                                    <option value="">-- Tất cả danh mục --</option>
                                                    {!!$option!!}
                                                </select>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-1 mb-0">
                                        <button type="submit" class="btn btn-success w-100">Tìm</button>
                                    </div>
                                    <div class="col-md-1 mb-0">
                                        <button type="submit" target="blank" name="btnExcel" class="btn btn-success"
                                            value="1">Xuất excel</button>
                                    </div>
                                    <div class="col-md-1 mb-0">
                                        <a  class="btn btn-danger w-100" href="{{ route('admin.product.index') }}">Làm mới</a>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0 lb-list-category">
                        <table class="table table-head-fixed" style="font-size: 13px;">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Thông tin</th>
                                    <th>Số khung/Biển số</th>
                                    <th>Dòng xe</th>
                                    <th>Đơn vị thi công</th>
                                    <th>Ngày mua</th>
                                    <th>Ngày hết bảo hành</th>
                                    <th>Tỉnh/Thành phố</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $productItem)
                                    <tr>
                                        <th>{{$loop->index}}</th>
                                        <td>
                                            <ul>
                                                @if (isset($productItem->name_chunha) && $productItem->name_chunha)
                                                    <li><strong>Họ tên</strong> {{ $productItem->name_chunha }}</li>
                                                @endif
                                                @if (isset($productItem->phone_chunha) && $productItem->phone_chunha)
                                                    <li><strong>Điện thoại</strong> {{ $productItem->phone_chunha  }}
                                                    </li>
                                                @endif
                                                @if (isset($productItem->city) && $productItem->city)
                                                    <li><strong>Địa chỉ</strong> {{ $productItem->donvithicong ?? '' }}, {{$productItem->city->name}}
                                                    </li>
                                                @else
                                                    @if (isset($productItem->donvithicong) && $productItem->donvithicong)
                                                        <li><strong>Địa chỉ</strong> {{ $productItem->donvithicong }}
                                                        </li>
                                                    @endif
                                                @endif
                                            </ul>
                                        </td>
                                        <td>{{ $productItem->masp }}</td>
                                        <td>{{ $productItem->type_car }}</td>
                                        <td>{{ $productItem->donvithicong }}</td>
                                        <td>{{ $productItem->time_buy }}</td>
                                        <td>{{ $productItem->time_expires }}</td>

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
                                            <a href="{{route('admin.product.edit',['id'=>$productItem->id])}}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                            <a class="btn btn-sm btn-primary" id="btn-load-detail" data-id="{{$productItem->id}}" data-url="{{route('admin.product.detail',['id'=>$productItem->id])}}"><i class="fas fa-eye"></i></a>
                                            <a data-url="{{route('admin.product.destroy',['id'=>$productItem->id])}}" class="btn btn-sm btn-danger lb_delete"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>


                                    <!-- The Modal chi tiết -->
                                    <div class="modal fade in" id="productDetail{{$productItem->id}}">
                                        <div class="modal-dialog modal-dialog-centered modal-xl">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                            <h4 class="modal-title">Chi tiết bảo hành</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div class="content" id="loadProductDetail{{$productItem->id}}">
                                                    
                                                </div>
                                            </div>

                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
                {{$data->appends(request()->input())->links()}}
            </div>
        </div>
      </div>
    </div>
</div>


@endsection

@section('js')

<script>
    // js load ajax detail
    $(document).on("click", "#btn-load-detail", function() {
        let urlRequest = $(this).data("url");
        let id = $(this).data("id");

        let contentWrap = $('#loadProductDetail'+id);

        $.ajax({
            type: "GET",
            url: urlRequest,
            success: function(data) {
                if (data.code == 200) {
                    let html = data.htmlLoadProductService;
                    contentWrap.html(html);
                    $('#productDetail'+id).modal('show');
                }
            }
        });
    });
// end js load ajax detail

    $('#import-excel').validate({
        rules: {
            resume: {
                required: true,
                extension: "xlsx|xls|xlsm"
            }
        },
        messages: {
            resume: {
                required: "file .xlsx, .xlsm, .xls only.",
                extension: "Vui lòng tải lên các định dạng tệp hợp lệ .xlsx, .xlsm, .xls only."
            }
        }
    });
</script>

@endsection
