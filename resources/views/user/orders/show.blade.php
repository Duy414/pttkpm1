@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fa-solid fa-ticket me-2"></i>Chi tiết đặt vé #{{ $order->id }}
        </h1>
        <a href="{{ route('user.orders.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Quay lại danh sách
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0 fw-bold text-primary">Thông tin đơn hàng</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Trạng thái:</p>
                    @if($order->status == 'completed')
                        <span class="badge bg-success fs-6"><i class="fa-solid fa-check me-1"></i>Hoàn thành</span>
                    @elseif($order->status == 'pending')
                        <span class="badge bg-warning text-dark fs-6"><i class="fa-solid fa-hourglass-half me-1"></i>Chờ xử lý</span>
                    @elseif($order->status == 'cancelled')
                        <span class="badge bg-danger fs-6"><i class="fa-solid fa-ban me-1"></i>Đã hủy</span>
                    @else
                        <span class="badge bg-secondary fs-6">{{ $order->status }}</span>
                    @endif
                </div>
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Ngày đặt vé:</p>
                    <span class="fw-bold">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="col-md-4">
                    <p class="mb-1 text-muted">Tổng thanh toán:</p>
                    <span class="text-danger fw-bold fs-5">{{ number_format($order->total) }}₫</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0 fw-bold text-primary">Danh sách Tour / Dịch vụ</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
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
                        <td class="ps-4 fw-bold text-primary">
                            {{ $item->product->name }}
                            {{-- Nếu có ngày đi được lưu trong pivot table hoặc attributes, hiển thị ở đây --}}
                            {{-- <div class="small text-muted font-normal">Khởi hành: ...</div> --}}
                        </td>
                        <td>{{ number_format($item->price) }}₫</td>
                        <td class="text-center">{{ $item['quantity'] }}</td>
                        <td class="text-end pe-4 fw-bold">{{ number_format($item->price * $item['quantity']) }}₫</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($order->status == 'pending')
    <div class="card border-danger shadow-sm mb-4">
        <div class="card-header bg-danger text-white py-2">
            <h5 class="mb-0 fs-6"><i class="fa-solid fa-triangle-exclamation me-2"></i>Hủy đặt vé</h5>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <p class="mb-0 text-muted small">
                    Đơn hàng đang ở trạng thái <strong>Chờ xử lý</strong>. Bạn có thể hủy vé ngay bây giờ nếu thay đổi kế hoạch.<br>
                    <em>Lưu ý: Hành động này không thể hoàn tác.</em>
                </p>
                <form action="{{ route('user.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fa-solid fa-xmark me-2"></i>Xác nhận Hủy Vé
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    @if($order->status == 'completed')
        <div class="card border-primary shadow-sm mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="fa-solid fa-star me-2"></i>Đánh giá chuyến đi của bạn</h5>
            </div>
            <div class="card-body bg-light">
                <p class="text-center mb-4">Cảm ơn bạn đã sử dụng dịch vụ! Hãy chia sẻ cảm nhận về các tour bạn đã trải nghiệm nhé.</p>
                
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        {{-- Hiển thị danh sách các tour để đánh giá --}}
                        @foreach($order->orderItems as $item)
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3">
                                        <i class="fa-solid fa-map-location-dot me-2"></i>{{ $item->product->name }}
                                    </h6>
                                    
                                    {{-- Include form đánh giá --}}
                                    {{-- Truyền biến $product vào để form biết đang đánh giá cái nào --}}
                                    @include('products._review_form', ['product' => $item->product])
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    @elseif($order->status == 'cancelled')
        <div class="alert alert-secondary d-flex align-items-center" role="alert">
            <i class="fa-solid fa-ban me-3 fs-4"></i>
            <div>
                <strong>Đơn hàng đã bị hủy.</strong>
                <div class="small">Nếu bạn cần hỗ trợ, vui lòng liên hệ hotline 1900 xxxx.</div>
            </div>
        </div>
    @else
        <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="fa-solid fa-info-circle me-3 fs-4"></i>
            <div>
                <strong>Chuyến đi chưa hoàn thành.</strong>
                <div class="small">Bạn có thể viết đánh giá sau khi chuyến đi kết thúc và trạng thái đơn hàng chuyển sang "Hoàn thành".</div>
            </div>
        </div>
    @endif
</div>
@endsection