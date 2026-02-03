@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Đơn đặt hàng của bạn</h1>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID đơn hàng</th>
                <th>Ngày</th>
                <th>Tổng cộng</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>{{ number_format($order->total) }} VND</td>
                <td>{{ $order->status }}</td>
                <td>
                    <a href="{{ route('user.orders.show', $order) }}" class="btn btn-info">Xem chi tiết</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $orders->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection