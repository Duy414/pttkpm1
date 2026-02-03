@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fa-solid fa-credit-card me-2"></i>Xác nhận & Thanh toán
        </h1>
        <p class="text-muted mt-2">Vui lòng kiểm tra kỹ thông tin trước khi đặt vé.</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @php $cartItems = session()->get('cart', []); @endphp

    @if(empty($cartItems))
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fa-solid fa-cart-arrow-down fa-3x text-muted"></i>
            </div>
            <h3>Giỏ hàng đang trống!</h3>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Quay lại chọn Tour</a>
        </div>
    @else
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-7">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-user me-2"></i>Thông tin liên hệ</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Họ và tên (*)</label>
                                    <input type="text" name="name" class="form-control" 
                                           value="{{ auth()->check() ? auth()->user()->name : old('name') }}" required placeholder="Nguyễn Văn A">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Số điện thoại (*)</label>
                                    <input type="text" name="phone" class="form-control" 
                                           value="{{ auth()->check() ? auth()->user()->phone : old('phone') }}" required placeholder="09xxxxxxxx">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email nhận vé (*)</label>
                                <input type="email" name="email" class="form-control" 
                                       value="{{ auth()->check() ? auth()->user()->email : old('email') }}" required placeholder="email@example.com">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Địa chỉ</label>
                                <input type="text" name="address" class="form-control" 
                                       value="{{ auth()->check() ? auth()->user()->address : old('address') }}" required placeholder="Số nhà, Đường, Quận/Huyện...">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Ghi chú thêm (Nếu có)</label>
                                <textarea name="note" class="form-control" rows="2" placeholder="Ví dụ: Cần xuất hóa đơn đỏ, người già đi cùng..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-money-bill-wave me-2"></i>Phương thức thanh toán</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check p-3 border rounded mb-3 bg-light">
                                <input class="form-check-input mt-2" type="radio" name="payment_method" id="payment_cod" value="cod" checked>
                                <label class="form-check-label w-100 cursor-pointer" for="payment_cod">
                                    <span class="d-block fw-bold text-dark">
                                        <i class="fa-solid fa-shop me-2"></i>Thanh toán tại văn phòng / Khi nhận vé
                                    </span>
                                    <small class="text-muted d-block mt-1">
                                        Quý khách đến văn phòng nhận vé cứng và thanh toán trực tiếp.
                                    </small>
                                </label>
                            </div>

                            <div class="form-check p-3 border rounded">
                                <input class="form-check-input mt-2" type="radio" name="payment_method" id="payment_online" value="online">
                                <label class="form-check-label w-100 cursor-pointer" for="payment_online">
                                    <span class="d-block fw-bold text-dark">
                                        <i class="fa-regular fa-credit-card me-2"></i>Thanh toán trực tuyến (VNPAY / Banking)
                                    </span>
                                    <small class="text-muted d-block mt-1">
                                        Thanh toán an toàn, nhận vé điện tử qua Email ngay lập tức.
                                    </small>
                                    <div class="mt-2">
                                        <img src="https://vnpay.vn/assets/images/logo-icon/logo-primary.svg" height="24" alt="VNPAY" class="me-2">
                                        <i class="fa-brands fa-cc-visa fa-xl text-primary me-2"></i>
                                        <i class="fa-brands fa-cc-mastercard fa-xl text-danger"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 fw-bold">Đơn hàng của bạn</h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-borderless mb-0">
                                <thead class="bg-light border-bottom">
                                    <tr>
                                        <th class="ps-3">Tour / Dịch vụ</th>
                                        <th class="text-end pe-3">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                    <tr class="border-bottom">
                                        <td class="ps-3">
                                            <div class="fw-bold text-primary">{{ $item['name'] }}</div>
                                            <small class="text-muted d-block">
                                                <i class="fa-regular fa-calendar me-1"></i>
                                                {{ isset($item['attributes']['departure_date']) ? \Carbon\Carbon::parse($item['attributes']['departure_date'])->format('d/m/Y') : 'Chưa chọn ngày' }}
                                            </small>
                                            <small class="text-muted">
                                                {{ number_format($item['price']) }}₫ x {{ $item['quantity'] }} vé
                                            </small>
                                        </td>
                                        <td class="text-end pe-3 align-middle">
                                            {{ number_format($item['price'] * $item['quantity']) }}₫
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer bg-white pt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính:</span>
                                <strong>{{ number_format(collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity'])) }}₫</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0">Tổng thanh toán:</span>
                                <span class="h4 mb-0 text-danger fw-bold">
                                    {{ number_format(collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity'])) }}₫
                                </span>
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100 py-3 mt-4 fw-bold fs-5 shadow-sm">
                                <i class="fa-solid fa-check-circle me-2"></i>Xác nhận Đặt vé
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-link w-100 mt-2 text-decoration-none text-muted">
                                <i class="fa-solid fa-arrow-left me-1"></i>Quay lại giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>

<style>
    .cursor-pointer { cursor: pointer; }
    /* Hiệu ứng khi chọn radio button */
    .form-check-input:checked + label .text-dark {
        color: #0d6efd !important; /* Đổi màu chữ khi chọn */
    }
    .form-check-input:checked + label {
        background-color: #f0f8ff; /* Đổi màu nền nhẹ khi chọn */
    }
</style>
@endsection