@extends('admin.layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('lib/char\js\Chart.min.css') }}">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #fff !important;
        }

        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap');

        /* width */
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        ul {
            padding-left: 20px;
        }

        .status>span {
            cursor: pointer;
        }

        .card {
            box-shadow: 0 0 0px rgb(0 0 0 / 13%), 0 0px 0px rgb(0 0 0 / 20%);
            margin-bottom: 1rem;
            background: #f4f6f9;
        }

        .content-wrapper>.content {
            padding: 25px .5rem;
            margin: 0 !important;
        }

        .navbar {
            padding: 13px 0;
        }

        .card-body {
            background: #fff;
        }

        ul {
            padding-left: 0px;
            margin-bottom: 0;
        }

        .card-header {
            background: #333;
        }

        .card-title {
            float: left;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }

        .list-news-home {}

        .list-news-home li a {}

    </style>
@endsection
@section('title', 'Trang chủ admin')
@section('content')
    <div class="content-wrapper">

        <div class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-12 card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Thống kê chung</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning"><i class="fas fa-newspaper"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Tổng số sản phẩm</span>
                                        <span class="info-box-number">{{ number_format($totalProduct) }}</span>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-danger"><i class="far fa-newspaper"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Tổng số tin tức</span>
                                        <span class="info-box-number">{{ number_format($totalPost) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-danger"><i class="far fa-newspaper"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Tổng số review</span>
                                        <span class="info-box-number">{{ number_format($totalReview) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-cart-plus"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Thông tin liên hệ</span>
                                        <span class="info-box-number">{{ number_format($countContact) }}</span>
                                    </div>
                                </div>
                            </div> --}}

                        </div>
                    </div>
                </div>
                <div class="row">

                    {{-- <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Top 10 review mới nhất</h3>
                            </div>
                            <div class="card-body table-responsive p-0" style="height: 345px;">
                                <ul class="list-news-home list-group">
                                    @foreach ($reviewNews as $item)
                                        <li class="list-group-item">
                                            <a href="{{ route('review.detail', ['id' => $item->id, 'slug' => $item->slug]) }}"
                                                target="_blank"> <i class="fas fa-caret-right"></i> {{ $item->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Top 10 sản phẩm mới nhất</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="height: 345px;">
                                <ul class="list-news-home list-group">

                                    @foreach ($productNews as $item)
                                        <li class="list-group-item">
                                            <a href="{{ route('home.search', ['keyword' => $item->masp]) }}"
                                                target="_blank"> <i class="fas fa-caret-right"></i> {{ $item->masp }}</a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>


                <!-- /.row -->
            </div>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('js')
    <script src="{{ asset('lib/char\js\Chart.min.js') }}"></script>
    {{-- <script>
        var areaChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                    label: 'Digital Goods',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [28, 48, 40, 19, 86, 27, 90]
                },
                // {
                //     label: 'Electronics',
                //     backgroundColor: 'rgba(210, 214, 222, 1)',
                //     borderColor: 'rgba(210, 214, 222, 1)',
                //     pointRadius: false,
                //     pointColor: 'rgba(210, 214, 222, 1)',
                //     pointStrokeColor: '#c1c7d1',
                //     pointHighlightFill: '#fff',
                //     pointHighlightStroke: 'rgba(220,220,220,1)',
                //     data: [65, 59, 80, 81, 56, 55, 40]
                // },
            ]
        }
        var areaChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false,
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: false,
                    }
                }]
            }
        }

        //-------------
        //- LINE CHART -
        //--------------
        var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
        var lineChartOptions = $.extend(true, {}, areaChartOptions);
        var lineChartData = $.extend(true, {}, areaChartData);
        lineChartData.datasets[0].fill = false;
        //    lineChartData.datasets[1].fill = false;
        lineChartOptions.datasetFill = false;

        var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
        });



        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var donutData = {
            labels: [
                'Đặt hàng thành công',
                'Tiếp nhận đơn hàng',
                'Đang vận chuyển',
                'Hoàn thành',
                'Hủy bỏ',
            ],
            datasets: [{
                data: [
                    {{ $countTransaction[1] }},
                    {{ $countTransaction[2] }},
                    {{ $countTransaction[3] }},
                    {{ $countTransaction[4] }},
                    {{ $countTransaction[-1] }}
                ],
                backgroundColor: ['#c3e6cb', '#ffc107', '#17a2b8', '#28a745', '#dc3545'],
            }]
        }
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieData = donutData;
        var pieOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })
    </script> --}}

@endsection
