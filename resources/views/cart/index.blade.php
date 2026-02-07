@extends('layouts.app')

@section('title', 'Giỏ hàng của bạn')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-4 p-4 rounded-4 shadow-sm" 
         style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
        <div class="d-flex align-items-center">
            <div class="icon-box bg-primary text-white rounded-3 p-3 me-3">
                <i class="fa-solid fa-cart-flatbed-suitcase fs-4"></i>
            </div>
            <div>
                <h1 class="h3 mb-0 fw-bold text-dark">Giỏ Tour Du Lịch</h1>
                <p class="text-muted mb-0">{{ count($cartItems) }} tour trong danh sách chờ</p>
            </div>
        </div>
        @if (count($cartItems) > 0)
        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa sạch giỏ hàng?');">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm border-0">
                <i class="fa-solid fa-trash-can me-1"></i> Làm trống giỏ
            </button>
        </form>
        @endif
    </div>

    @if (session('error') || session('success'))
        <div class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }} border-0 shadow-sm alert-dismissible fade show rounded-3" role="alert">
            <i class="fa-solid {{ session('success') ? 'fa-check-circle' : 'fa-circle-exclamation' }} me-2"></i>
            {{ session('error') ?? session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (count($cartItems) > 0)
        <div class="row g-4">
            <div class="col-lg-8">
                @foreach ($cartItems as $item)
                <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden item-card">
                    <div class="card-body p-0">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-5 p-4">
                                <h5 class="fw-bold text-primary mb-1">{{ $item['name'] }}</h5>
                                <div class="mb-2">
                                    <span class="badge bg-light text-dark border"><i class="fa-solid fa-tag me-1 text-primary"></i> {{ number_format($item['price']) }}₫ / khách</span>
                                </div>
                                <form action="{{ route('cart.remove', $item['id']) }}"
                                    method="POST"
                                    onsubmit="return confirm('Xóa tour này khỏi giỏ hàng?')"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-link text-danger small text-decoration-none hover-underline p-0">
                                        <i class="fa-solid fa-trash-can me-1"></i> Loại bỏ
                                    </button>
                                </form>
                            </div>

                            <div class="col-md-7 bg-light p-4">
                                <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="row g-3 align-items-center">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-6">
                                        <label class="small fw-bold text-muted">Ngày đi</label>
                                        <input type="date" name="departure_date" 
                                               class="form-control form-control-sm border-0 shadow-sm" 
                                               value="{{ $item['attributes']['departure_date'] ?? date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-4">
                                        <label class="small fw-bold text-muted">Số người</label>
                                        <input type="number" name="quantity" 
                                               class="form-control form-control-sm border-0 shadow-sm text-center" 
                                               value="{{ $item['quantity'] }}" min="1">
                                    </div>
                                    <div class="col-2 pt-4">
                                        <button type="submit" class="btn btn-primary btn-sm w-100 shadow-sm" title="Cập nhật">
                                            <i class="fa-solid fa-rotate"></i>
                                        </button>
                                    </div>
                                </form>
                                <div class="text-end mt-3">
                                    <span class="text-muted small">Thành tiền:</span>
                                    <span class="h5 fw-bold text-dark ms-2">{{ number_format($item['price'] * $item['quantity']) }}₫</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-link text-white text-decoration-none p-0">
                        <i class="fa-solid fa-chevron-left me-2"></i> Tiếp tục tìm kiếm Tour khác
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-lg rounded-4 sticky-top" style="top: 100px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 border-bottom pb-3">Chi tiết đơn hàng</h5>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Tạm tính ({{ count($cartItems) }} tour)</span>
                            <span class="fw-bold">{{ number_format($total) }}₫</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Phí dịch vụ</span>
                            <span class="text-success">Miễn phí</span>
                        </div>
                        
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h6 mb-0 fw-bold">Tổng thanh toán:</span>
                                <span class="h4 mb-0 fw-bold text-primary">{{ number_format($total) }}₫</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow mb-3">
                            TIẾN HÀNH ĐẶT VÉ <i class="fa-solid fa-arrow-right-long ms-2"></i>
                        </a>
                        
                        <div class="text-center small">
                            <p class="text-muted mb-0"><i class="fa-solid fa-lock me-1 text-success"></i> Thanh toán an toàn qua SSL</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5 rounded-4 shadow-sm" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px);">
            <div class="empty-cart-animation mb-4">
                <i class="fa-solid fa-cart-shopping text-muted opacity-25" style="font-size: 100px;"></i>
            </div>
            <h3 class="fw-bold text-dark">Giỏ hàng đang trống!</h3>
            <p class="text-muted mb-4">Bạn chưa chọn được điểm đến nào ưng ý sao?</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
                <i class="fa-solid fa-magnifying-glass me-2"></i> Khám phá Tour ngay
            </a>
        </div>
    @endif
</div>

<style>
    /* Hiệu ứng hover cho card tour */
    .item-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .item-card:hover {
        transform: translateX(10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    /* Hiệu ứng cho nút xóa */
    .hover-underline:hover {
        text-decoration: underline !important;
    }

    /* Bo góc cho input */
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        border-color: #0d6efd;
    }

    .icon-box {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection