@extends('admin.layouts.main')
@section('title',"Danh sach menu")

@section('css')

@endsection
@section('content')
<div class="content-wrapper">

    @include('admin.partials.content-header',['name'=>"Menu","key"=>"Danh sách menu"])

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
                <a href="{{route('admin.menu.create')}}" class="btn  btn-info btn-md mb-2">+ Thêm mới</a>

                    <div class="card card-outline card-primary">
                        <div class="card-body table-responsive lb-list-category">
                            @include('admin.components.category', [
                                'data' => $data,
                                'routeNameEdit'=>'admin.menu.edit',
                                'routeNameAdd'=>'admin.menu.create',
                                'routeNameDelete'=>'admin.menu.destroy',
                            ])
                        </div>
                    </div>

            </div>
            <div class="col-md-12">
                {{$data->links()}}
            </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('js')
@endsection
