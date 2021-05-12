@extends('admin.layouts.main')
@section('title',"danh sach danh mục sản phẩm")
@section('css')

@endsection
@section('content')
<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>"Danh mục sản phẩm","key"=>"Danh sách danh mục"])

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if(session("alert"))
                <div class="alert alert-success">
                    {{session("alert")}}
                </div>
                @elseif(session('error'))
                <div class="alert alert-warning">
                    {{session("error")}}
                </div>
                @endif
                <div class="d-flex justify-content-between ">
                    <a href="{{route('admin.categoryproduct.create')}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>
                    <div class="group-button-right d-flex">
                        <form action="{{route('admin.categoryproduct.import.excel.database')}}" class="form-inline" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group" style="max-width: 250px">
                                <input type="file" class="form-control-file" name="fileExcel" accept=".xlsx" required>
                              </div>
                            <input type="submit" value="Import Execel" class=" btn btn-info ml-1">
                        </form>
                        <form class="form-inline ml-3" action="{{route('admin.categoryproduct.export.excel.database')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="submit" value="Export Execel" class=" btn btn-danger">
                        </form>
                    </div>
                </div>


                <div class="card card-outline card-primary">
                    <div class="card-body table-responsive lb-list-category">
                        @include('admin.components.category', [
                            'data' => $data,
                            'routeNameEdit'=>'admin.categoryproduct.edit',
                            'routeNameAdd'=>'admin.categoryproduct.create',
                            'routeNameDelete'=>'admin.categoryproduct.destroy',
                        ])
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                {{$data->links()}}
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>

@endsection

@section('js')

@endsection
