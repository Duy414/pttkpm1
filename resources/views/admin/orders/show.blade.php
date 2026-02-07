@extends('layouts.admin')

@section('content')

{{-- CSS Custom cho trang Chi tiết Booking --}}
<style>
    /* Card Styles */
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        background: #fff;
        transition: transform 0.2s;
    }
    
    .card-header-modern {
        background-color: #fff;
        border-bottom: 1px solid #f0f2f5;
        padding: 20px 25px;
        border-radius: 16px 16px 0 0 !important;
    }

    /* Icon Circles */
    .icon-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-right: 15px;
    }
    .icon-primary { background-color: rgba(78, 115, 223, 0.1); color: #4e73df; }
    .icon-success { background-color: rgba(28, 200, 138, 0.1); color: #1cc88a; }
    .icon-warning { background-color: rgba(246, 194, 62, 0.1); color: #f6c23e; }

    /* Typography */
    .label-text {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #858796;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .value-text {
        font-size: 1rem;
        color: #2e384d;
        font-weight: 600;
        margin-bottom: 16px;
    }

    /* Table Styles */
    .table-modern thead th {
        background-color: #f8f9fc;
        color: #858796;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e3e6f0;
        padding: 15px 25px;
    }
    .table-modern tbody td {
        vertical-align: middle;
        padding: 15px 25px;
        border-top: 1px solid #f0f1f5;
        color: #5a5c69;
    }

    /* Badges */
    .badge-soft {
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
    }
    .bg-soft-success { background-color: rgba(28, 200, 138, 0.1); color: #1cc88a; }
    .bg-soft-warning { background-color: rgba(246, 194, 62, 0.1); color: #f6c23e; }
    .bg-soft-danger { background-color: rgba(231, 74, 59, 0.1); color: #e74a3b; }
    .bg-soft-secondary { background-color: rgba(133, 135, 150, 0.1); color: #858796; }

    /* Action Card */
    .action-card {
        border: 2px solid rgba(246, 194, 62, 0.3);
        background: linear-gradient(to right, #fff, #fffbf2);
    }
    
    .btn-rounded {
        border-radius: 50px;
        padding: 8px 24px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-rounded:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
</style>

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                Chi tiết Booking <span class="text-primary">#{{ $order->id }}</span>
            </h1>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-rounded shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Quay lại
        </a>
    </div>
    
    <div class="row">
        {{-- Card: Thông tin khách hàng --}}
        <div class="col-md-6 mb-4">
            <div class="card card-modern h-100">
                <div class="card-header-modern d-flex align-items-center">
                    <div class="icon-circle icon-primary">
                        <i class="fas fa-user"></i>
                    </div>
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin khách đặt</h6>
                </div>
                <div class="card-body px-4 pt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="label-text">Họ tên</div>
                            <div class="value-text">
                                {{ $order->customer_name ?: ($order->user ? $order->user->name : 'Khách vãng lai') }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="label-text">Số điện thoại</div>
                            <div class="value-text">
                                {{ $order->customer_phone ?: ($order->user ? $order->user->phone : 'Chưa cập nhật') }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="label-text">Email</div>
                            <div class="value-text">
                                {{ $order->customer_email ?: ($order->user ? $order->user->email : 'Chưa cập nhật') }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="label-text">Địa chỉ liên hệ</div>
                            <div class="value-text mb-0">
                                {{ $order->customer_address ?: ($order->user ? $order->user->address : 'Chưa cập nhật') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Thông tin Booking --}}
        <div class="col-md-6 mb-4">
            <div class="card card-modern h-100">
                <div class="card-header-modern d-flex align-items-center">
                    <div class="icon-circle icon-success">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <h6 class="m-0 font-weight-bold text-success">Thông tin Booking</h6>
                </div>
                <div class="card-body px-4 pt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="label-text">Ngày đặt vé</div>
                            <div class="value-text">
                                <i class="far fa-calendar-alt me-1 text-gray-400"></i>
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="label-text">Trạng thái hiện tại</div>
                            <div class="value-text">
                                @if($order->status == 'completed')
                                    <span class="badge badge-soft bg-soft-success">Hoàn thành</span>
                                @elseif($order->status == 'pending')
                                    <span class="badge badge-soft bg-soft-warning">Chờ xử lý</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="badge badge-soft bg-soft-danger">Đã hủy</span>
                                @else
                                    <span class="badge badge-soft bg-soft-secondary">{{ $order->status }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="p-3 bg-light rounded-3 border d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold text-gray-600">Tổng thanh toán:</span>
                                <span class="h4 mb-0 font-weight-bold text-success">{{ number_format($order->total) }} ₫</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Table: Chi tiết Tour --}}
    <div class="card card-modern mb-4">
        <div class="card-header-modern d-flex align-items-center">
             <div class="icon-circle icon-warning" style="background-color: rgba(54, 185, 204, 0.1); color: #36b9cc;">
                <i class="fas fa-list"></i>
            </div>
            <h6 class="m-0 font-weight-bold text-info">Chi tiết Tour / Dịch vụ đã chọn</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
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
                            <td class="ps-4">
                                <span class="fw-bold text-dark d-block">
                                    {{ $item->product ? $item->product->name : 'Sản phẩm đã bị xóa' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border">{{ $item->quantity }}</span>
                            </td>
                            <td class="text-end">{{ number_format($item->price) }} ₫</td>
                            <td class="text-end pe-4 fw-bold text-primary">{{ number_format($item->price * $item->quantity) }} ₫</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    {{-- Card: Xử lý Booking (Action) --}}
    <div class="card card-modern action-card mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-4">
                <div class="icon-circle icon-warning">
                    <i class="fas fa-cogs"></i>
                </div>
                <div>
                    <h5 class="m-0 font-weight-bold text-warning">Xử lý Booking</h5>
                    <small class="text-muted">Thay đổi trạng thái đơn hàng</small>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
                @csrf
                <div class="row align-items-end">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <label for="status" class="label-text">Cập nhật trạng thái:</label>
                        <select name="status" id="status" class="form-select form-control-lg border-warning" style="background-color: #fff;">
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
                        <div class="small text-muted mt-2">
                            <i class="fas fa-info-circle me-1"></i> Lưu ý: Thay đổi trạng thái sẽ cập nhật ngay lập tức trên hệ thống.
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="submit" class="btn btn-primary btn-lg btn-rounded w-100 shadow-sm">
                            <i class="fas fa-check-circle me-2"></i> Cập nhật ngay
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection