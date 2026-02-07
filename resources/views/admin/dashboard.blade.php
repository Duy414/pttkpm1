@extends('layouts.admin')

@section('content')

{{-- CSS Custom cho Dashboard --}}
<style>
    /* Tổng thể */
    .dashboard-container {
        font-family: 'Inter', sans-serif; /* Hoặc font mặc định của bạn */
    }

    /* 1. Cards thống kê */
    .stats-card {
        border: none;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .icon-box {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Màu sắc riêng cho từng loại card */
    .bg-soft-primary { background-color: rgba(78, 115, 223, 0.1); color: #4e73df; }
    .bg-soft-success { background-color: rgba(28, 200, 138, 0.1); color: #1cc88a; }
    .bg-soft-info { background-color: rgba(54, 185, 204, 0.1); color: #36b9cc; }
    .bg-soft-warning { background-color: rgba(246, 194, 62, 0.1); color: #f6c23e; }

    .card-title-text {
        color: #858796;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .card-value-text {
        color: #2e384d;
        font-size: 1.75rem;
        font-weight: 800;
        line-height: 1.2;
    }

    /* 2. Card Lọc & Doanh thu */
    .filter-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .form-control-custom {
        border-radius: 10px;
        border: 1px solid #e3e6f0;
        padding: 10px 15px;
        transition: all 0.2s;
    }
    
    .form-control-custom:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
    }

    .btn-gradient-success {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(28, 200, 138, 0.3);
        transition: all 0.3s;
    }
    
    .btn-gradient-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(28, 200, 138, 0.4);
        color: white;
    }

    .revenue-display {
        background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
        border-radius: 12px;
        padding: 20px;
        border: 1px dashed #d1d3e2;
    }

    .revenue-text {
        background: linear-gradient(135deg, #4e73df, #224abe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 2.5rem;
        font-weight: 800;
    }

    /* 3. Bảng booking */
    .table-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    
    .table-modern thead th {
        background-color: #f8f9fc;
        color: #858796;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        border-top: none;
        border-bottom: 2px solid #e3e6f0;
        padding: 15px;
    }
    
    .table-modern tbody td {
        vertical-align: middle;
        padding: 15px;
        border-top: 1px solid #f0f1f5;
        color: #45474e;
    }

    .booking-id {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        color: #4e73df;
        background: rgba(78, 115, 223, 0.1);
        padding: 4px 8px;
        border-radius: 6px;
    }

    /* Badge trạng thái kiểu pill mềm */
    .badge-pill-soft {
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    
    .btn-action {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
</style>

<div class="container-fluid dashboard-container">
    
    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Dashboard</h1>
            <p class="text-muted mb-0">Tổng quan tình hình kinh doanh du lịch</p>
        </div>
        {{-- Có thể thêm nút Export report ở đây nếu cần --}}
    </div>

    {{-- Stats Row --}}
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card h-100 py-2">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="card-title-text text-primary mb-1">Khách hàng</div>
                            <div class="card-value-text">{{ $userCount }}</div>
                        </div>
                        <div class="icon-box bg-soft-primary">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card h-100 py-2">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="card-title-text text-success mb-1">Tour & Dịch vụ</div>
                            <div class="card-value-text">{{ $productCount }}</div>
                        </div>
                        <div class="icon-box bg-soft-success">
                            <i class="bi bi-map"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card h-100 py-2">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="card-title-text text-info mb-1">Tổng Booking</div>
                            <div class="card-value-text">{{ $orderCount }}</div>
                        </div>
                        <div class="icon-box bg-soft-info">
                            <i class="bi bi-ticket-perforated"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card h-100 py-2">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="card-title-text text-warning mb-1">Chờ xử lý</div>
                            <div class="card-value-text">{{ $pendingOrderCount }}</div>
                        </div>
                        <div class="icon-box bg-soft-warning">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter & Revenue Section --}}
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card filter-card">
                <div class="card-header py-3 bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-success d-flex align-items-center">
                        <i class="bi bi-funnel me-2 mr-2"></i> Lọc doanh thu theo thời gian
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.dashboard') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="small font-weight-bold text-muted">Từ ngày:</label>
                                <input type="date" name="start_date" class="form-control form-control-custom" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="small font-weight-bold text-muted">Hết ngày:</label>
                                <input type="date" name="end_date" class="form-control form-control-custom" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-gradient-success w-100 py-2" type="submit">
                                    <i class="bi bi-search mr-1"></i> Thống kê doanh thu
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="revenue-display mt-4 text-center">
                        <span class="text-uppercase text-muted small font-weight-bold ls-1">Tổng doanh thu</span>
                        <h2 class="revenue-text mt-2 mb-0">{{ number_format($totalRevenue) }}₫</h2>
                        @if(request('start_date') && request('end_date'))
                            <p class="text-info small mt-2 mb-0 bg-soft-info d-inline-block px-3 py-1 rounded-pill">
                                <i class="bi bi-calendar-check mr-1"></i> {{ date('d/m/Y', strtotime(request('start_date'))) }} - {{ date('d/m/Y', strtotime(request('end_date'))) }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="card table-card mb-4">
        <div class="card-header py-3 bg-white d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Booking mới nhất</h6>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light text-primary font-weight-bold">Xem tất cả <i class="bi bi-arrow-right ml-1"></i></a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-modern mb-0" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã Booking</th>
                            <th>Khách hàng</th>
                            <th>Tổng thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                            <th class="text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td><span class="booking-id">#{{ $order->id }}</span></td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $order->user->name ?? 'Khách vãng lai' }}</div>
                            </td>
                            <td class="font-weight-bold text-success">{{ number_format($order->total) }}₫</td>
                            <td>
                                {{-- Giữ nguyên logic status_color nhưng style lại class --}}
                                <span class="badge badge-pill-soft bg-soft-{{ $order->status_color == 'success' ? 'success' : ($order->status_color == 'warning' ? 'warning' : ($order->status_color == 'danger' ? 'danger' : 'info')) }} text-{{ $order->status_color }}">
                                    {{ $order->status_text }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                <i class="bi bi-calendar3 mr-1"></i> {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info btn-action d-inline-flex" title="Xem chi tiết">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection