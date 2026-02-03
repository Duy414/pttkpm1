@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-file-invoice-dollar me-2"></i>Chi tiết Booking #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4 h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Thông tin khách đặt</h5>
                </div>
                <div class="card-body">
                    {{-- Prioritize saved order info, fallback to user account info, then "Guests" --}}
                    <p class="mb-2">
                        <strong>Họ tên:</strong> 
                        {{ $order->customer_name ?: ($order->user ? $order->user->name : 'Khách vãng lai') }}
                    </p>
                    <p class="mb-2">
                        <strong>Số điện thoại:</strong> 
                        {{ $order->customer_phone ?: ($order->user ? $order->user->phone : 'Chưa cập nhật') }}
                    </p>
                    <p class="mb-2">
                        <strong>Email:</strong> 
                        {{ $order->customer_email ?: ($order->user ? $order->user->email : 'Chưa cập nhật') }}
                    </p>
                    <p class="mb-0">
                        <strong>Địa chỉ liên hệ:</strong> 
                        {{ $order->customer_address ?: ($order->user ? $order->user->address : 'Chưa cập nhật') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm mb-4 h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Thông tin Booking</h5>
                </div>
                <div class="card-body">
                    <p class="mb-3"><strong>Trạng thái hiện tại:</strong> 
                        @if($order->status == 'completed')
                            <span class="badge bg-success fs-6">Hoàn thành</span>
                        @elseif($order->status == 'pending')
                            <span class="badge bg-warning text-dark fs-6">Chờ xử lý</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge bg-danger fs-6">Đã hủy</span>
                        @else
                            <span class="badge bg-secondary fs-6">{{ $order->status }}</span>
                        @endif
                    </p>
                    <p class="mb-2"><strong>Tổng thanh toán:</strong> <span class="text-danger fw-bold fs-5">{{ number_format($order->total) }} ₫</span></p>
                    <p class="mb-0"><strong>Ngày đặt vé:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Chi tiết Tour / Dịch vụ đã chọn</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tên Tour / Dịch vụ</th>
                            <th class="text-center">Số vé (Người)</th>
                            <th class="text-end">Giá vé</th>
                            <th class="text-end pe-4">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td class="ps-4 align-middle fw-bold">
                                {{ $item->product ? $item->product->name : 'Sản phẩm đã bị xóa' }}
                            </td>
                            <td class="text-center align-middle">{{ $item->quantity }}</td>
                            <td class="text-end align-middle">{{ number_format($item->price) }} ₫</td>
                            <td class="text-end pe-4 align-middle">{{ number_format($item->price * $item->quantity) }} ₫</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="card shadow-sm border-warning">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Xử lý Booking</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
                @csrf
                <div class="row align-items-end">
                    <div class="col-md-8">
                        <label for="status" class="form-label fw-bold">Cập nhật trạng thái Booking:</label>
                        <select name="status" id="status" class="form-select form-select-lg">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>
                                ⏳ Chờ xử lý (Mới đặt)
                            </option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>
                                ✅ Hoàn thành (Đã thanh toán / Đã đi Tour)
                            </option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>
                                ❌ Hủy Booking (Khách hủy / Hết chỗ)
                            </option>
                        </select>
                        <div class="form-text text-muted">
                            Lưu ý: Thay đổi trạng thái sẽ cập nhật ngay lập tức trên hệ thống.
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-check-circle me-2"></i> Cập nhật ngay
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection