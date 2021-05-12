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
                            <a class="btn btn-info" href="{{ route('profile.editInfo') }}">Chỉnh sửa thông tin</a> <br>
                            <a class="btn btn-info" href="{{ route('profile.listRose') }}">Danh sách hoa hồng</a> <br>
                            <a class="btn btn-info" href="{{ route('profile.listMember') }}">Danh sách thành viên</a> <br>
                            <a class="btn btn-info" href="{{ route('profile.createMember') }}">Them thanh vien</a> <br>
                            <h1>Thống kê điểm</h1>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 ">
                           Tổng số điểm hiện có
                            Số điểm : {{ $sumPointCurrent  }}
                        </div>
                        @isset($sumEachType)
                            @foreach ($sumEachType as $item)
                                <div class="col-lg-3 col-md-6 col-sm-12 ">
                                    Kiểu : {{ $typePoint[$item->type]['name']  }} <br>
                                    Số điểm : {{ $item->total  }}
                                </div>
                            @endforeach
                        @endisset
                    </div>
                </div>
            </div>
            @if ($openPay)
                <div class="wrap-pay">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                @if(session("alert"))
                                  <div class="alert alert-success">
                                      {{session("alert")}}
                                  </div>
                                @elseif(session('error'))
                                  <div class="alert alert-warning">
                                      {{session("error")}}
                                  </div>
                                @endif

                                <form action="{{route('profile.drawPoint')}}" method="POST">
                                  @csrf
                                  <div class="row">
                                      <div class="col-md-8">
                                          <div class="card card-outline card-primary">
                                              <div class="card-header">
                                                  <h3 class="card-title">Rút điểm</h3>
                                                  <div class="desc">Rút điểm chỉ được mở từ ngày 1- 2 hàng tháng</div>
                                              </div>
                                              <div class="card-body table-responsive p-3">
                                                  <div class="form-group">
                                                      <label for="">Số điểm rút</label>
                                                      <input
                                                          type="text"
                                                          class="form-control"
                                                          id=""
                                                          value="{{ old('pay') }}"  name="pay"
                                                          placeholder="Nhập số điểm"
                                                      >
                                                      @error('pay')
                                                          <div class="alert alert-danger">{{ $message }}</div>
                                                      @enderror
                                                  </div>

                                                  <div class="form-group form-check">
                                                    <input type="checkbox" class="form-check-input" name="checkrobot" id="checkrobot" required>
                                                    <label class="form-check-label" for="checkrobot">Check me out</label>
                                                  </div>
                                                  @error('checkrobot')
                                                  <div class="alert alert-danger">{{ $message }}</div>
                                                  @enderror
                                                  <div class="form-group">
                                                     <button type="submit" class="btn btn-primary">Chấp nhận</button>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </form>
                              </div>
                        </div>
                    </div>
                </div>
            @endif


        </div>
    </div>
@endsection
@section('js')
<script>
    $(function(){
        $(document).on('click','.pt_icon_right',function(){
            event.preventDefault();
            $(this).parentsUntil('ul','li').children("ul").slideToggle();
            $(this).parentsUntil('ul','li').toggleClass('active');
        })
    })
</script>
@endsection
