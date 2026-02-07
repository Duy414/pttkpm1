@extends('layouts.app')

@section('content')

{{-- CSS Riêng cho trang Chi tiết đơn hàng --}}
<style>
    /* 1. Glass Card Effect */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.5);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .glass-header {
        background: rgba(248, 249, 250, 0.6);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 20px 25px;
    }

    /* 2. Badges & Text */
    .status-badge {
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .text-price {
        background: linear-gradient(135deg, #dc3545, #ff6b6b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        font-size: 1.5rem;
    }

    /* 3. Table Styling */
    .table-modern th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        color: #6c757d;
        border-bottom-width: 1px;
    }
    .table-modern td {
        vertical-align: middle;
        padding: 15px 10px;
    }

    /* 4. Review Section Styling */
    .review-section-wrapper {
        border: 2px dashed #cbd5e0;
        background-color: #f7fafc;
        border-radius: 20px;
        padding: 30px;
    }
    
    .item-review-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        transition: transform 0.2s;
        border: 1px solid #edf2f7;
    }
    .item-review-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px rgba(0,0,0,0.05);
    }

    /* 5. Buttons */
    .btn-back {
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-back:hover {
        background-color: #e2e6ea;
        transform: translateX(-3px);
    }
</style>

<div class="container py-5">
    {{-- Header Page --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">
                <i class="fa-solid fa-ticket text-primary me-2"></i>Chi tiết đặt vé <span class="text-muted">#{{ $order->id }}</span>
            </h1>
            <p class="text-muted mb-0">Xem lại thông tin chuyến đi và đánh giá dịch vụ</p>
        </div>
        <a href="{{ route('user.orders.index') }}" class="btn btn-outline-secondary btn-back border-0 bg-white shadow-sm">
            <i class="fa-solid fa-arrow-left me-2"></i>Quay lại danh sách
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm rounded-3 border-0 bg-success-subtle text-success">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    {{-- Card 1: Thông tin đơn hàng --}}
    <div class="glass-card">
        <div class="glass-header">
            <h5 class="mb-0 fw-bold text-primary"><i class="fa-solid fa-circle-info me-2"></i>Thông tin đơn hàng</h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <p class="mb-2 text-muted small text-uppercase fw-bold">Trạng thái</p>
                    @if($order->status == 'completed')
                        <span class="status-badge bg-success-subtle text-success border border-success-subtle">
                            <i class="fa-solid fa-check me-1"></i> Hoàn thành
                        </span>
                    @elseif($order->status == 'pending')
                        <span class="status-badge bg-warning-subtle text-warning border border-warning-subtle">
                            <i class="fa-solid fa-hourglass-half me-1"></i> Chờ xử lý
                        </span>
                    @elseif($order->status == 'cancelled')
                        <span class="status-badge bg-danger-subtle text-danger border border-danger-subtle">
                            <i class="fa-solid fa-ban me-1"></i> Đã hủy
                        </span>
                    @else
                        <span class="status-badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                            {{ $order->status }}
                        </span>
                    @endif
                </div>
                <div class="col-md-4">
                    <p class="mb-2 text-muted small text-uppercase fw-bold">Ngày đặt vé</p>
                    <span class="fw-bold fs-5 text-dark">{{ $order->created_at->format('d/m/Y') }}</span>
                    <small class="text-muted ms-1">{{ $order->created_at->format('H:i') }}</small>
                </div>
                <div class="col-md-4">
                    <p class="mb-2 text-muted small text-uppercase fw-bold">Tổng thanh toán</p>
                    <span class="text-price">{{ number_format($order->total) }}₫</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2: Danh sách Tour --}}
    <div class="glass-card">
        <div class="glass-header">
            <h5 class="mb-0 fw-bold text-primary"><i class="fa-solid fa-list-check me-2"></i>Danh sách Tour / Dịch vụ</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-modern align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Tên Tour / Dịch vụ</th>
                        <th>Giá vé</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-end pe-4">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold text-dark d-block">{{ $item->product->name }}</span>
                            {{-- <small class="text-muted"><i class="far fa-calendar me-1"></i>Khởi hành: ...</small> --}}
                        </td>
                        <td>{{ number_format($item->price) }}₫</td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border px-3">{{ $item['quantity'] }}</span>
                        </td>
                        <td class="text-end pe-4 fw-bold text-primary">{{ number_format($item->price * $item['quantity']) }}₫</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- SECTION: HỦY VÉ (Chỉ hiện khi Pending) --}}
    @if($order->status == 'pending')
    <div class="card border-danger border-opacity-50 shadow-sm mb-5" style="border-radius: 16px; overflow:hidden;">
        <div class="card-body p-4 bg-danger bg-opacity-10">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-start gap-3">
                    <div class="bg-white p-2 rounded-circle text-danger shadow-sm">
                        <i class="fa-solid fa-triangle-exclamation fs-4"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-danger mb-1">Bạn muốn hủy vé này?</h6>
                        <p class="mb-0 text-secondary small">
                            Đơn hàng đang chờ xử lý. Hành động này không thể hoàn tác.
                        </p>
                    </div>
                </div>
                <form action="{{ route('user.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">
                        <i class="fa-solid fa-xmark me-2"></i>Xác nhận Hủy
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- SECTION: ĐÁNH GIÁ (GIỮ LẠI THEO YÊU CẦU) --}}
    @if($order->status == 'completed')
        <div class="review-section-wrapper mb-5">
            <div class="text-center mb-4">
                <div class="d-inline-block p-3 rounded-circle bg-warning bg-opacity-10 text-warning mb-3">
                    <i class="fa-solid fa-star fs-2"></i>
                </div>
                <h4 class="fw-bold text-dark">Đánh giá trải nghiệm của bạn</h4>
                <p class="text-muted">Cảm ơn bạn đã sử dụng dịch vụ! Hãy chia sẻ cảm nhận về các tour bạn đã đi nhé.</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @foreach($order->orderItems as $item)
                        <div class="item-review-card p-4 mb-4">
                            <h6 class="fw-bold text-primary mb-3 border-bottom pb-2">
                                <i class="fa-solid fa-map-location-dot me-2"></i>{{ $item->product->name }}
                            </h6>
                            
                            {{-- Form đánh giá (Include) --}}
                            @include('products._review_form', ['product' => $item->product])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @elseif($order->status == 'cancelled')
        <div class="alert alert-secondary d-flex align-items-center rounded-4 p-4 shadow-sm" role="alert">
            <div class="bg-secondary text-white rounded-circle p-3 me-3">
                <i class="fa-solid fa-ban fs-4"></i>
            </div>
            <div>
                <h5 class="alert-heading fw-bold mb-1">Đơn hàng đã bị hủy</h5>
                <p class="mb-0 small">Nếu bạn cần hỗ trợ hoặc muốn đặt lại, vui lòng liên hệ hotline <strong>1900 1900</strong>.</p>
            </div>
        </div>
    @else
        <div class="alert alert-info d-flex align-items-center rounded-4 p-4 shadow-sm" role="alert">
            <div class="bg-info text-white rounded-circle p-3 me-3">
                <i class="fa-solid fa-info fs-4"></i>
            </div>
            <div>
                <h5 class="alert-heading fw-bold mb-1">Chuyến đi chưa hoàn thành</h5>
                <p class="mb-0 small">Bạn có thể viết đánh giá sau khi chuyến đi kết thúc và trạng thái đơn hàng chuyển sang "Hoàn thành".</p>
            </div>
        </div>
    @endif

</div>
@endsection