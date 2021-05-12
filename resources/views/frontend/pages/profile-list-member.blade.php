@extends('frontend.layouts.main-profile')

@section('title', $seo['title'] ?? '' )
@section('keywords', $seo['keywords']??'')
@section('description', $seo['description']??'')
@section('abstract', $seo['abstract']??'')
@section('image', $seo['image']??'')
@section('content')
    <div class="content-wrapper">
        <div class="main">
            {{-- @isset($breadcrumbs,$typeBreadcrumb)
                @include('frontend.components.breadcrumbs',[
                    'breadcrumbs'=>$breadcrumbs,
                    'type'=>$typeBreadcrumb,
                ])
            @endisset --}}
            <div class="wrap-content-main wrap-template-product template-detail">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1>Danh sách hoa hồng</h1>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th>Tên </th>
                                      <th>SỐ CMT</th>
                                      <th>Level</th>
                                      <th>R</th>
                                    </tr>
                                  </thead>
                                  <tbody>

                                      @isset($data)
                                          @foreach ($data as $item)
                                             <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td>
                                                    {{ $item['cmt']??"" }}
                                                </td>
                                                <td>{{ $item['active']?'CVKD':'CTV' }}</td>
                                                <td>R{{ $item['level'] }}</td>
                                            </tr>
                                            @endforeach
                                        @endisset

                                  </tbody>
                                </table>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
