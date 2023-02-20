<style>
    .info-order {}

    .info-order .money {
        margin-top: 0;
        text-align: center;
        margin-bottom: 15px;
    }

    .info-order .money strong {
        color: red;
        display: block;
        /* margin-bottom: 5px; */
        font-size: 35px;
    }

    .info-order .money span {
        font-size: 16px;
    }
    .info-order ul{
        margin-bottom: 15px;
    }
    .info-order ul li{

    }

</style>
<div class="info-order">
    <h4 class="money">
        <strong>{{ number_format($transaction->total) }} <small> đ</small></strong>
        @if ($orders->where('new_price', 0)->sum('quantity'))
        <span>Sản phẩm giá liên hệ: {{ $orders->where('new_price', 0)->sum('quantity') }} sản phẩm</span>
        @endif
       <div class="status-transaction">
        @include('admin.components.status',[
            'dataStatus'=>$transaction,
            'listStatus'=>config('web_default.statusTransaction'),
            ])
       </div>
    </h4>
    <ul class="row">
        <li class="col-md-6 col-sm-6 col-12">
            <strong>Họ và tên: </strong> {{ $transaction->name }}
        </li>
        <li class="col-md-6 col-sm-6 col-12">
            <strong>Số điện thoại: </strong> {{ $transaction->phone }}
        </li>
        <li class="col-md-6 col-sm-6 col-12">
            <strong>Email: </strong> {{ $transaction->email }}
        </li>
        <li class="col-md-6 col-sm-6 col-12">
            @if ($transaction->user)
                <strong>Tên shop</strong> {{ $transaction->user->name_store }}
            @else
                <strong>Tên shop</strong> Muagiatotnhat.vn
            @endif
        </li>

        <li class="col-md-12 col-sm-12 col-12">
            <strong>Địa chỉ nhận: </strong>
            {{ $transaction->address_detail ? $transaction->address_detail . ', ' : '' }}
            @if ($transaction->city_id && $transaction->district_id && $transaction->commune_id)
                {{ optional($transaction->commune)->name }}, {{ optional($transaction->district)->name }},
                {{ optional($transaction->city)->name }}
            @endif
        </li>
        <li class="col-md-12 col-sm-12 col-12">
            <strong>Ghi chú của người mua: </strong> {{ $transaction->note ?? 'Không' }}
        </li>

        <li class="col-md-12 col-sm-12 col-12">
            <strong>Ghi chú của shop: </strong> {{ $transaction->note_shop ?? 'Không' }}
        </li>


    </ul>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 10px">STT</th>
            <th>Avatar</th>
            <th>Name</th>
            <th class="text-nowrap">Số lượng</th>
            <th class="text-nowrap">Total</th>
            {{-- <th>Action</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $loop->index }}</td>
                <td>
                    <img src="{{ $order->avatar_path }}" alt="{{ $order->name }}" style="width:80px;">
                </td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ number_format($order->new_price) }}</td>
                {{-- <td>
                <a href="" class="btn btn-sm btn-infor btn-danger">
                <i class="far fa-trash-alt"></i>
                </a>
            </td> --}}
            </tr>
        @endforeach
    </tbody>
</table>
