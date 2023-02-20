@extends('frontend.layouts.main-profile')
@section('title', 'Danh sach đơn hàng')
@section('css')
@endsection
@section('content')

    <div class="content-wrapper lb_template_list_post">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @isset($dataTransactionGroupByStatus)
                        <div class="col-sm-12">
                            <div class="list-count">
                                <div class="row">
                                    @foreach ($dataTransactionGroupByStatus as $item)

                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="info-box">
                                                <span class="info-box-icon bg-info"><i class="fas fa-calculator"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">Số giao dịch {{ $item['name'] }} </span>
                                                    <span
                                                        class="info-box-number"><strong>{{ number_format($item['total'] ?? 0) }}</strong>
                                                        / tổng số {{ $totalTransaction }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endisset

                    <div class="col-sm-12">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Danh sách đơn hàng mới</h3>
                                <div class="card-tools w-60">
                                    <form action="{{ route('profile.transaction') }}" method="GET">

                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="form-group col-md-4 mb-0">
                                                        <input id="keyword" value="{{ $keyword }}" name="keyword"
                                                            type="text" class="form-control"
                                                            placeholder="Mã/tên/SĐT/Email">
                                                        <div id="keyword_feedback" class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4 mb-0" style="min-width:100px;">
                                                        <select id="order" name="order_with" class="form-control">
                                                            <option value="">Sắp xếp theo</option>
                                                            <option value="dateASC"
                                                                {{ $order_with == 'dateASC' ? 'selected' : '' }}>Ngày đặt
                                                                hàng
                                                                tăng dần</option>
                                                            <option value="dateDESC"
                                                                {{ $order_with == 'dateDESC' ? 'selected' : '' }}>Ngày đặt
                                                                hàng
                                                                giảm dần</option>
                                                            <option value="statusASC"
                                                                {{ $order_with == 'statusASC' ? 'selected' : '' }}>Trạng
                                                                thái
                                                                1-n</option>
                                                            <option value="statusDESC"
                                                                {{ $order_with == 'statusDESC' ? 'selected' : '' }}>Trạng
                                                                thái
                                                                n-1</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-md-4 mb-0" style="min-width:100px;">
                                                        <select id="status" name="status" class="form-control">
                                                            <option value="">Tình trang đơn hàng</option>
                                                            @foreach ($listStatus as $status)
                                                                <option value="{{ $status['status'] }}"
                                                                    {{ $status['status'] == $statusCurrent ? 'selected' : '' }}>
                                                                    Đơn hàng {{ $status['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-3 text-right">
                                                <button type="submit" class="btn btn-success">Tìm kiếm</button>
                                                <a href="{{ route('profile.transaction') }}" class="btn btn-danger">Làm
                                                    lại</a>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <table class="table table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="text-nowrap">Thông tin</th>
                                            <th class="text-nowrap">Tổng tiền</th>
                                            <th class="text-nowrap">Tài khoản</th>
                                            <th class="text-nowrap">Trạng thái</th>
                                            <th>Thời gian</th>
                                            <th class="text-nowrap">Trang thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $transaction)
                                            <tr>
                                                <td>{{ $transaction->id }}</td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <strong>MGD:</strong> {{ $transaction->code }}
                                                        </li>
                                                        <li>
                                                            <strong>Name:</strong> {{ $transaction->name }}
                                                        </li>
                                                        {{-- <li>
                                                            <strong>Phone:</strong> {{ $transaction->phone }}
                                                        </li>
                                                        <li>
                                                            <strong>Email:</strong> {{ $transaction->email }}
                                                        </li> --}}
                                                    </ul>
                                                </td>
                                                <td class="">
                                                    {{-- <span class="tag tag-success"></span> --}}
                                                    <ul>
                                                        <li>
                                                            {{-- <strong>Tổng giá trị đơn hàng:</strong> --}}
                                                            {{ number_format($transaction->total) }} đ
                                                        </li>

                                                    </ul>
                                                </td>
                                                <td class="
                                                    text-nowrap">
                                                    {{ $transaction->user_id ? 'Thành viên' : 'Khách vãng lai' }}</td>
                                                <td class="text-nowrap">
                                                    <a class="show-status"
                                                        data-url="{{ route('profile.editStatus', ['id' => $transaction->id]) }}"
                                                        data-id="{{ $transaction->id }}">
                                                        @include('admin.components.status',[
                                                        'dataStatus'=>$transaction,
                                                        'listStatus'=>$listStatus,
                                                        ])
                                                    </a>

                                                </td>
                                                <td class="text-nowrap">{{ $transaction->created_at }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-info btn-load-transaction-detail"
                                                        data-url="{{ route('profile.transaction.detail', ['id' => $transaction->id]) }}">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a data-url="{{ route('admin.transaction.destroy', ['id' => $transaction->id]) }}"
                                                        class="btn btn-sm btn-info btn-danger lb_delete">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-md-12">
                        {{ $data->appends(request()->input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal chi tiết đơn hàng -->
    <div class="modal fade in" id="transactionDetail">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Chi tiết đơn hàng</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="content" id="loadTransactionDetail">

                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal chọn trạng thái đơn hàng --}}
    <div class="modal fade" id="statusTransaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Trạng thái đơn hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="loadListErrorStatus"></div>
                    <div id="loadTransactionStatus">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('lib/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
    {{-- <script src="{{asset('lib/tinymce5/js/tinymce.min.js')}}"></script> --}}
    <script src="https://cdn.tiny.cloud/1/si5evst7s8i3p2grgfh7i5gdsk2l26daazgefvli0hmzapgn/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    {{-- <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script> --}}
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin_asset/ajax/deleteAdminAjax.js') }}"></script>
    <script src="{{ asset('admin_asset/js/function.js') }}"></script>
    <script>
        // js load change tráº¡ng thĂ¡i hot vĂ  active
        $(document).on('click', '.lb-active', function() {
            event.preventDefault();
            let wrapActive = $(this).parents('.wrap-load-active');
            let urlRequest = wrapActive.data("url");
            let value = $(this).data("value");
            let type = $(this).data("type");
            let title = '';
            if (value) {
                title = 'Bạn có chắc chắn muốn ẩn ' + type;
            } else {
                title = 'Bạn có chắc chắn muốn hiện ' + type;
            }
            Swal.fire({
                title: title,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tôi đồng ý'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: urlRequest,
                        success: function(data) {
                            if (data.code == 200) {
                                let html = data.html;
                                wrapActive.html(html);
                            }
                        }
                    });
                }
            })
        });

        $(document).on('click', '.lb-hot', function() {
            event.preventDefault();
            let wrapActive = $(this).parents('.wrap-load-hot');
            let urlRequest = wrapActive.data("url");
            let value = $(this).data("value");
            let type = $(this).data("type");
            let title = '';
            if (value) {
                title = 'Bạn có chắc chắn muốn bỏ trạng thái nổi bật ' + type;
            } else {
                title = 'Bạn có chắc chắn muốn chuyển  ' + type + ' sang nổi bật';
            }
            Swal.fire({
                title: title,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, next step!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: urlRequest,
                        success: function(data) {
                            if (data.code == 200) {
                                let html = data.html;
                                wrapActive.html(html);
                            }
                        }
                    });
                }
            })
        });

        // end  js load change tráº¡ng thĂ¡i hot vĂ  active
        // js load ajax chuyển trạng thái đơn hàng
        $(document).on("click", ".load-status span", loadNextStepStatus);

        function loadNextStepStatus(event) {
            event.preventDefault();
            let statusWrap = $(this).parents('.load-status');
            // get url load ajax
            let urlRequest = statusWrap.data("url");
            // get giá trị status hiện tại
            let statusCurrent = parseInt($(this).data("status"));

            // set giá trị các trạng thái
            let arrListStatus = [{
                    status: 'hủy bỏ',
                    nextstep: 'Đơn hàng đã bị hủy bỏ không thể chuyển đến trạng thái tiếp theo'
                },
                {
                    status: 'Đặt hàng thành công chờ xử lý',
                    nextstep: 'Bạn có muốn chuyển đơn hàng sang trang thái đã tiếp nhận đơn hàng'
                },
                {
                    status: 'Đã tiếp nhận',
                    nextstep: 'Bạn có muốn chuyển đơn hàng sang trang thái đang vận chuyển'
                },
                {
                    status: 'Đang vận chuyển',
                    nextstep: 'Bạn có muốn chuyển đơn hàng sang trang thái hoàn thành'
                },
                {
                    status: 'Hoàn thành',
                    nextstep: 'Đơn hàng đã hoàn thành'
                },
            ]

            let swalOption = {
                //  title: "test",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                // confirmButtonText: 'Yes, next step!'
            }
            if (statusCurrent > 0 && statusCurrent < 4) {
                swalOption.confirmButtonText = 'Tôi đồng ý!';
                swalOption.title = arrListStatus[statusCurrent].nextstep;
            } else if (statusCurrent < 0) {
                swalOption.title = arrListStatus[0].nextstep;
                swalOption.showCancelButton = false;
            } else {
                swalOption.title = arrListStatus[statusCurrent].nextstep;
                swalOption.showCancelButton = false;
                swalOption.icon = 'success';
            }

            Swal.fire(swalOption).then((result) => {
                if (result.isConfirmed && statusCurrent > 0 && statusCurrent < 4) {
                    $.ajax({
                        type: "GET",
                        url: urlRequest,
                        success: function(data) {
                            if (data.code == 200) {
                                let html = data.htmlStatus;
                                statusWrap.html(html);
                            }
                        }
                    });
                }
            })
        }
        // end js load ajax chuyển trạng thái đơn hàng
        // js load ajax Ä‘Æ¡n hĂ ng
        $(document).on("click", ".btn-load-transaction-detail", function() {
            let contentWrap = $('#loadTransactionDetail');
            let urlRequest = $(this).data("url");
            $.ajax({
                type: "GET",
                url: urlRequest,
                success: function(data) {
                    if (data.code == 200) {
                        let html = data.html;
                        contentWrap.html(html);
                        $('#transactionDetail').modal('show');
                    }
                }
            });
        });
        // show modal status transaction
        $(document).on("click", ".show-status", function() {
            // get url load ajax
            let myThis = $(this);
            let urlRequest = myThis.data("url");
            $.ajax({
                type: "GET",
                url: urlRequest,
                success: function(data) {
                    if (data.code == 200) {
                        let html = data.html;
                        $('#loadTransactionStatus').html(html);
                        $('#statusTransaction').modal('show');
                    }
                }
            });
        });

        $(document).on('submit', '#formTransactionStatus', function() {
            event.preventDefault();
            let myThis = $(this);
            //  let formData = new FormData(this);
            let formData = new FormData(this);
            //  formData.append('content', $('#content').val());
            let urlRequest = $(this).data("url");
            let id = $(this).find('[name=id]').val();
            let my = $('[data-id=' + id + ']');
            console.log(my);
            $.ajax({
                type: "POST",
                url: urlRequest,
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.code == 200) {
                        my.html(response.html);
                        $('#statusTransaction').modal('hide');
                    } else {
                        alert('Thay đổi trạng thái không thành công');
                    }
                }
            });
        });
    </script>

@endsection
