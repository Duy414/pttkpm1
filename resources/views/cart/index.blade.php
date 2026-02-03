@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-cart-flatbed-suitcase me-2"></i>Giỏ Tour Du Lịch</h1>
        <span class="badge bg-primary ms-3 rounded-pill">{{ count($cartItems) }} tour đang chọn</span>
    </div>

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (count($cartItems) > 0)
        <div class="row">
            <div class="col-lg-9">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th style="width: 35%" class="ps-4 py-3">Thông tin Tour</th>
                                    <th style="width: 20%">Ngày khởi hành</th>
                                    <th style="width: 15%">Giá vé</th>
                                    <th style="width: 15%">Số người</th>
                                    <th style="width: 15%" class="text-end pe-4">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-primary">{{ $item['name'] }}</div>
                                        <div class="small text-muted">
                                            <a href="{{ route('cart.remove', ['id' => $item['id']]) }}" 
                                               onclick="return confirm('Bạn muốn xóa tour này?')"
                                               class="text-danger text-decoration-none remove-link">
                                                <i class="fa-solid fa-trash-can me-1"></i>Xóa
                                            </a>
                                        </div>
                                    </td>
                                    
                                    <form action="{{ route('cart.update', $item['id']) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <td>
                                            <input type="date" name="departure_date" 
                                                   class="form-control form-control-sm border-primary" 
                                                   value="{{ $item['attributes']['departure_date'] ?? date('Y-m-d') }}" 
                                                   required>
                                        </td>

                                        <td>{{ number_format($item['price']) }}₫</td>

                                        <td>
                                            <div class="input-group input-group-sm" style="width: 100px;">
                                                <input type="number" name="quantity" 
                                                       class="form-control text-center" 
                                                       value="{{ $item['quantity'] }}" min="1">
                                                <button type="submit" class="btn btn-outline-secondary" title="Cập nhật">
                                                    <i class="fa-solid fa-rotate"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </form>

                                    <td class="text-end pe-4 fw-bold">
                                        {{ number_format($item['price'] * $item['quantity']) }}₫
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left me-2"></i>Tiếp tục xem Tour
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa sạch giỏ hàng?');">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fa-solid fa-trash me-2"></i>Xóa hết giỏ hàng
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Tóm tắt đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tạm tính:</span>
                            <span class="fw-bold">{{ number_format($total) }}₫</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Giảm giá:</span>
                            <span class="text-success">-0₫</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 mb-0">Tổng cộng:</span>
                            <span class="h5 mb-0 text-primary">{{ number_format($total) }}₫</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                            Tiến hành đặt vé <i class="fa-solid fa-arrow-right ms-2"></i>
                        </a>
                        
                        <div class="mt-3 text-center small text-muted">
                            <i class="fa-solid fa-shield-halved me-1"></i> Bảo mật thanh toán 100%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5 bg-white shadow-sm rounded">
            <div class="mb-4">
                <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Empty Cart" style="width: 100px; opacity: 0.5;">
            </div>
            <h3 class="fw-bold text-secondary">Giỏ hàng chưa có Tour nào</h3>
            <p class="text-muted mb-4">Hãy khám phá các điểm đến tuyệt vời và thêm vào đây nhé!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-5">
                <i class="fa-solid fa-plane-departure me-2"></i>Khám phá ngay
            </a>
        </div>
    @endif
</div>

<style>
    .remove-link { font-size: 0.85rem; cursor: pointer; }
    .remove-link:hover { text-decoration: underline !important; }
</style>
@endsection