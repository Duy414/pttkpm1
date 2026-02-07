@extends('layouts.admin')

@section('content')

{{-- CSS Custom cho trang Booking --}}
<style>
    /* Card Styles */
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background: #fff;
        overflow: hidden;
    }

    /* Revenue Card Special */
    .revenue-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
        border-left: 5px solid #1cc88a;
    }
    
    .revenue-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(28, 200, 138, 0.15);
    }

    .revenue-text {
        font-size: 1.8rem;
        background: linear-gradient(45deg, #1cc88a, #13855c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        background-color: rgba(28, 200, 138, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Table Styles */
    .table-modern thead th {
        background-color: #f8f9fc;
        color: #858796;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        border-bottom: 2px solid #e3e6f0;
        padding: 16px;
    }

    .table-modern tbody td {
        vertical-align: middle;
        padding: 16px;
        border-top: 1px solid #f0f1f5;
        color: #5a5c69;
    }

    .table-modern tbody tr:hover {
        background-color: #fafbfc;
    }

    /* Badge Styles (Soft Pill) */
    .badge-soft {
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
    }
    /* Ghi đè màu mặc định để tạo hiệu ứng soft */
    .bg-success { background-color: rgba(28, 200, 138, 0.1) !important; color: #1cc88a; }
    .bg-warning { background-color: rgba(246, 194, 62, 0.1) !important; color: #f6c23e; }
    .bg-danger { background-color: rgba(231, 74, 59, 0.1) !important; color: #e74a3b; }
    .bg-info { background-color: rgba(54, 185, 204, 0.1) !important; color: #36b9cc; }
    .bg-secondary { background-color: rgba(133, 135, 150, 0.1) !important; color: #858796; }

    /* Button Styles */
    .btn-action {
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        padding: 8px 16px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        transition: all 0.2s;
    }
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(54, 185, 204, 0.2);
    }
    
    .booking-id {
        font-family: 'Courier New', monospace;
        background: #f1f3f9;
        padding: 4px 8px;
        border-radius: 4px;
        color: #4e73df;
    }
</style>

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            <i class="bi bi-journal-check text-primary me-2"></i>Quản lý Booking & Vé
        </h1>
    </div>

    {{-- Revenue Card --}}
    <div class="row mb-4">
        <div class="col-md-6 col-xl-4">
            <div class="card card-modern revenue-card h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="letter-spacing: 0.5px;">
                                Tổng doanh thu (Booking hoàn tất)
                            </div>
                            <div class="revenue-text mb-0">
                                {{ number_format($totalRevenue) }} ₫
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle">
                                <i class="bi bi-cash-stack fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card card-modern mb-4">
        <div class="card-header py-3 bg-white border-bottom-0 d-flex align-items-center">
            <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center">
                <i class="bi bi-list-stars me-2"></i>Danh sách lịch đặt chỗ mới nhất
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
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
                            <td>
                                <span class="booking-id fw-bold">#{{ $order->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                        {{ substr($order->user->name, 0, 1) }}
                                    </div>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-dark">{{ $order->user->name }}</span>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ $order->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-success">{{ number_format($order->total) }} ₫</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-soft bg-{{ $order->status_color }}">
                                    {{ $order->status_text }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column small text-muted">
                                    <span><i class="bi bi-calendar3 me-1"></i> {{ $order->created_at->format('d/m/Y') }}</span>
                                    <span><i class="bi bi-clock me-1"></i> {{ $order->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-action text-white">
                                    <i class="fas fa-eye me-1"></i> Xử lý
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination Wrapper (Optional styling if needed) --}}
            <div class="p-3">
                 {{-- Giữ nguyên pagination logic của bạn --}}
            </div>
        </div>
    </div>
</div>
@endsection