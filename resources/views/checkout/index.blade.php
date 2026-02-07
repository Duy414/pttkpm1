@extends('layouts.app')

@section('title', 'Xác nhận & Thanh toán')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5 p-4 rounded-4 shadow-sm" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
        <h1 class="h3 mb-0 fw-bold text-dark text-uppercase letter-spacing-1">
            <i class="fa-solid fa-shield-check text-success me-2"></i>Xác nhận & Thanh toán
        </h1>
        <p class="text-muted mt-2 mb-0">Chỉ một bước nữa để bắt đầu chuyến hành trình của bạn.</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show rounded-3 mb-4">
            <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @php $cartItems = session()->get('cart', []); @endphp

    @if(empty($cartItems))
        <div class="text-center py-5 rounded-4 shadow-sm bg-white">
            <div class="mb-4">
                <i class="fa-solid fa-cart-arrow-down fa-4x text-muted opacity-25"></i>
            </div>
            <h3 class="fw-bold">Giỏ hàng đang trống!</h3>
            <p class="text-muted">Hình như bạn chưa chọn được tour nào cho mình.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill px-5 mt-3">Quay lại chọn Tour</a>
        </div>
    @else
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 fw-bold text-primary"><i class="fa-solid fa-user-tag me-2"></i>Thông tin liên hệ</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Họ và tên (*)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user text-muted"></i></span>
                                        <input type="text" name="name" class="form-control border-0 bg-light shadow-none" 
                                               value="{{ auth()->check() ? auth()->user()->name : old('name') }}" required placeholder="Nguyễn Văn A">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Số điện thoại (*)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-phone text-muted"></i></span>
                                        <input type="text" name="phone" class="form-control border-0 bg-light shadow-none" 
                                               value="{{ auth()->check() ? auth()->user()->phone : old('phone') }}" required placeholder="09xxxxxxxx">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Email nhận vé (*)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control border-0 bg-light shadow-none" 
                                           value="{{ auth()->check() ? auth()->user()->email : old('email') }}" required placeholder="email@example.com">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Địa chỉ</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="fa-solid fa-location-dot text-muted"></i></span>
                                    <input type="text" name="address" class="form-control border-0 bg-light shadow-none" 
                                           value="{{ auth()->check() ? auth()->user()->address : old('address') }}" required placeholder="Số nhà, Đường, Quận/Huyện...">
                                </div>
                            </div>
                            
                            <div class="mb-0">
                                <label class="form-label small fw-bold text-muted text-uppercase">Ghi chú (Nếu có)</label>
                                <textarea name="note" class="form-control border-0 bg-light shadow-none" rows="3" placeholder="Yêu cầu đặc biệt về chỗ ngồi, ăn uống..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 fw-bold text-primary"><i class="fa-solid fa-wallet me-2"></i>Phương thức thanh toán</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="payment-option mb-3">
                                <input class="form-check-input d-none" type="radio" name="payment_method" id="payment_cod" value="cod" checked>
                                <label class="payment-card border rounded-4 p-3 d-flex align-items-center w-100 cursor-pointer transition-all" for="payment_cod">
                                    <div class="icon-box-sm rounded-circle bg-light text-primary me-3">
                                        <i class="fa-solid fa-building-columns fs-5"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="d-block fw-bold text-dark mb-0">Thanh toán tại văn phòng</span>
                                        <small class="text-muted">Đến trực tiếp văn phòng để nhận vé cứng</small>
                                    </div>
                                    <div class="check-mark"><i class="fa-solid fa-circle-check text-primary"></i></div>
                                </label>
                            </div>

                            <div class="payment-option">
                                <input class="form-check-input d-none" type="radio" name="payment_method" id="payment_online" value="online">
                                <label class="payment-card border rounded-4 p-3 d-flex align-items-center w-100 cursor-pointer transition-all" for="payment_online">
                                    <div class="icon-box-sm rounded-circle bg-light text-success me-3">
                                        <i class="fa-solid fa-credit-card fs-5"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="d-block fw-bold text-dark mb-0">Thanh toán trực tuyến (VNPAY / Banking)</span>
                                        <div class="mt-2">
                                            <img src="https://vnpay.vn/assets/images/logo-icon/logo-primary.svg" height="20" class="me-2">
                                            <i class="fa-brands fa-cc-visa text-primary me-2"></i>
                                            <i class="fa-brands fa-cc-mastercard text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="check-mark"><i class="fa-solid fa-circle-check text-primary"></i></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden sticky-top" style="top: 100px;">
                        <div class="card-header bg-dark text-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-receipt me-2"></i>Đơn hàng của bạn</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        @foreach($cartItems as $item)
                                        <tr class="border-bottom">
                                            <td class="p-4">
                                                <div class="fw-bold text-dark mb-1">{{ $item['name'] }}</div>
                                                <div class="d-flex gap-3 small text-muted">
                                                    <span><i class="fa-regular fa-calendar-check me-1"></i> {{ isset($item['attributes']['departure_date']) ? \Carbon\Carbon::parse($item['attributes']['departure_date'])->format('d/m/Y') : 'Chưa chọn' }}</span>
                                                    <span><i class="fa-solid fa-ticket me-1"></i> x{{ $item['quantity'] }} vé</span>
                                                </div>
                                            </td>
                                            <td class="text-end p-4 align-middle">
                                                <span class="fw-bold">{{ number_format($item['price'] * $item['quantity']) }}₫</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light p-4 border-0">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tạm tính:</span>
                                <span class="fw-bold text-dark">{{ number_format(collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity'])) }}₫</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Phí xử lý:</span>
                                <span class="text-success fw-bold">0₫</span>
                            </div>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="h5 mb-0 fw-bold">Tổng số tiền:</span>
                                <span class="h3 mb-0 text-primary fw-bold">
                                    {{ number_format(collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity'])) }}₫
                                </span>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm mb-3 text-uppercase">
                                <i class="fa-solid fa-lock me-2"></i>Xác nhận & Thanh toán ngay
                            </button>
                            
                            <a href="{{ route('cart.index') }}" class="btn btn-link w-100 text-decoration-none text-muted small">
                                <i class="fa-solid fa-chevron-left me-1"></i> Sửa lại giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>

<style>
    /* CSS Tùy chỉnh cho Checkout */
    .cursor-pointer { cursor: pointer; }
    
    .letter-spacing-1 { letter-spacing: 1px; }

    .icon-box-sm {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Hiệu ứng chọn phương thức thanh toán */
    .payment-card {
        transition: all 0.2s ease-in-out;
        position: relative;
    }

    .payment-card:hover {
        background-color: #f8f9fa;
        border-color: #0d6efd !important;
    }

    .check-mark {
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    /* Logic khi radio được check */
    .payment-option input:checked + .payment-card {
        background-color: #f0f7ff;
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 1px #0d6efd;
    }

    .payment-option input:checked + .payment-card .check-mark {
        opacity: 1;
    }

    /* Tinh chỉnh input form */
    .form-control:focus {
        background-color: #fff !important;
        border: 1px solid #0d6efd !important;
    }

    .transition-all {
        transition: all 0.3s ease;
    }
</style>
@endsection