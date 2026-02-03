@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bảng điều khiển quản trị du lịch</h1>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng Khách hàng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tour & Dịch vụ</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $productCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-map fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tổng Booking</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orderCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-ticket-perforated fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Yêu cầu chờ xử lý</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingOrderCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock-history fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Lọc doanh thu theo thời gian</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.dashboard') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="small font-weight-bold">Từ ngày:</label>
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="small font-weight-bold">Đến ngày:</label>
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success w-100" type="submit">
                                    <i class="bi bi-search"></i> Thống kê doanh thu
                                </button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="mt-3">
                        <span class="text-uppercase text-muted small">Kết quả doanh thu:</span>
                        <h2 class="text-gray-800 font-weight-bold">{{ number_format($totalRevenue) }}₫</h2>
                        @if(request('start_date') && request('end_date'))
                            <p class="text-info small">Đang xem từ {{ request('start_date') }} đến {{ request('end_date') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách Booking mới nhất</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Mã Booking</th>
                            <th>Khách hàng</th>
                            <th>Tổng thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->user->name ?? 'Khách vãng lai' }}</td>
                            <td>{{ number_format($order->total) }}₫</td>
                            <td>
                                <span class="badge bg-{{ $order->status_color }}">
                                    {{ $order->status_text }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Chi tiết
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