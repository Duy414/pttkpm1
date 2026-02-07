@extends('layouts.app')

@section('content')

{{-- CSS Riêng cho bảng đơn hàng --}}
<style>
    /* 1. Khung chứa bảng (Glass Card) */
    .order-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.5);
        overflow: hidden; /* Để bo góc bảng không bị lòi ra */
    }

    /* 2. Tùy chỉnh Table */
    .table-custom th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
        color: #6c757d;
        font-weight: 700;
        padding: 15px 20px;
        border-bottom: 2px solid #e9ecef;
    }

    .table-custom td {
        padding: 15px 20px;
        vertical-align: middle;
        color: #495057;
        font-weight: 500;
        border-bottom: 1px solid #f0f0f0;
    }

    .table-custom tr:last-child td {
        border-bottom: none;
    }

    /* Hiệu ứng hover từng dòng */
    .table-custom tbody tr {
        transition: all 0.2s ease;
    }
    .table-custom tbody tr:hover {
        background-color: #f0f9ff;
        transform: scale(1.005); /* Phóng to cực nhẹ */
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        z-index: 10;
        position: relative;
    }

    /* 3. Trang trí ID đơn hàng */
    .order-id {
        font-family: 'Courier New', monospace;
        font-weight: 700;
        color: #0d6efd;
        background: #e7f1ff;
        padding: 5px 10px;
        border-radius: 8px;
    }

    /* 4. Giá tiền */
    .total-price {
        font-weight: 800;
        color: #2d3748;
    }

    /* 5. Nút Xem chi tiết */
    .btn-view-detail {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        border: 1px solid #dee2e6;
        color: #6c757d;
        transition: all 0.3s;
    }
    .btn-view-detail:hover {
        background-color: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
        transform: rotate(90deg);
    }

    /* 6. Pagination */
    .pagination-wrapper .page-link {
        border-radius: 50%;
        margin: 0 5px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        color: #495057;
        font-weight: 600;
    }
    .pagination-wrapper .page-item.active .page-link {
        background-color: #0d6efd;
        color: #fff;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
    }
</style>

<div class="container py-5">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold mb-1 text-white" style="text-shadow: 0 2px 4px rgba(0,0,0,0.2);">Lịch sử đơn hàng</h1>
            <p class="text-white-50 mb-0">Theo dõi trạng thái các chuyến đi của bạn</p>
        </div>
        <div class="bg-white bg-opacity-25 p-3 rounded-circle text-white shadow-sm d-none d-md-block">
            <i class="fas fa-history fs-3"></i>
        </div>
    </div>
    
    {{-- Bảng danh sách --}}
    <div class="order-card shadow-sm">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Tổng thanh toán</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <span class="order-id">#{{ $order->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center text-muted">
                                <i class="far fa-calendar-alt me-2"></i>
                                {{ $order->created_at->format('d/m/Y') }}
                            </div>
                        </td>
                        <td>
                            <span class="total-price">{{ number_format($order->total) }} đ</span>
                        </td>
                        <td>
                            {{-- Logic hiển thị màu trạng thái --}}
                            @if($order->status == 'completed')
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                    <i class="fas fa-check-circle me-1"></i> Hoàn thành
                                </span>
                            @elseif($order->status == 'pending')
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">
                                    <i class="fas fa-hourglass-half me-1"></i> Chờ xử lý
                                </span>
                            @elseif($order->status == 'cancelled')
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                                    <i class="fas fa-times-circle me-1"></i> Đã hủy
                                </span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">
                                    {{ $order->status }}
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('user.orders.show', $order) }}" class="btn-view-detail ms-auto" data-bs-toggle="tooltip" title="Xem chi tiết">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted opacity-50 mb-3">
                                <i class="fas fa-box-open fa-3x"></i>
                            </div>
                            <h5 class="fw-bold text-muted">Bạn chưa có đơn hàng nào</h5>
                            <a href="/products" class="btn btn-primary btn-sm rounded-pill mt-2">Đặt vé ngay</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4 pagination-wrapper">
        {{ $orders->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection