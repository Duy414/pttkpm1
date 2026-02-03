@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-journal-check me-2"></i>Quản lý Booking & Vé</h1>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Tổng doanh thu (Booking hoàn tất)
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalRevenue) }} ₫
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cash-stack fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách lịch đặt chỗ mới nhất</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mã Booking</th>
                            <th>Khách hàng</th>
                            <th>Tổng thanh toán</th>
                            <th class="text-center">Trạng thái</th>
                            <th>Ngày đặt vé</th>
                            <th class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ $order->user->name }}</span>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                </div>
                            </td>
                            <td class="text-primary fw-bold">{{ number_format($order->total) }} ₫</td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-{{ $order->status_color }}">
                                    {{ $order->status_text }}
                                </span>
                            </td>
                            <td>
                                <div class="small">
                                    <i class="bi bi-calendar3 me-1"></i> {{ $order->created_at->format('d/m/Y') }}<br>
                                    <i class="bi bi-clock me-1"></i> {{ $order->created_at->format('H:i') }}
                                </div>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info shadow-sm">
                                    <i class="fas fa-eye me-1"></i> Xử lý Booking
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">Hiển thị {{ $orders->count() }} kết quả trên trang này.</div>
                {{ $orders->links('pagination::simple-bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection