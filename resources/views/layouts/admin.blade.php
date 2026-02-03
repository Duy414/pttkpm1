<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Đổi title cho chuyên nghiệp hơn --}}
    <title>Travel Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <div class="bg-dark text-white vh-100 p-3" style="width: 250px; position: fixed;">
            <div class="text-center py-3">
                <i class="bi bi-airplane-engines fs-1"></i>
                <h4 class="mt-2">Travel Admin</h4>
            </div>
            <hr>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link text-white">
                        <i class="bi bi-speedometer2 me-2"></i> Tổng quan
                    </a>
                </li>
                <li>
                    {{-- Sản Phẩm -> Quản lý Tour --}}
                    <a href="{{ route('admin.products.index') }}" class="nav-link text-white">
                        <i class="bi bi-map me-2"></i> Quản lý Tour
                    </a>
                </li>
                <li>
                    {{-- Đơn Hàng -> Quản lý Đặt Vé (Booking) --}}
                    <a href="{{ route('admin.orders.index') }}" class="nav-link text-white">
                        <i class="bi bi-ticket-perforated me-2"></i> Quản lý Đặt Vé
                    </a>
                </li>
                <li>
                    {{-- Người Dùng -> Khách Hàng --}}
                    <a href="{{ route('admin.users.index') }}" class="nav-link text-white">
                        <i class="bi bi-people me-2"></i> Khách Hàng
                    </a>
                </li>
                <li>
                    {{-- Phản Hồi -> Đánh Giá Tour --}}
                    <a href="{{ route('admin.feedbacks.index') }}" class="nav-link text-white">
                        <i class="bi bi-chat-heart me-2"></i> Đánh Giá Tour
                    </a>
                </li>
            
            </ul>
        </div>
        
        <div class="flex-grow-1" style="margin-left: 250px;">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow-sm">
                <div class="container-fluid justify-content-end">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <span class="me-2 d-none d-lg-inline text-gray-600 small">Xin chào,</span>
                                <i class="bi bi-person-circle me-1"></i> <strong>{{ Auth::user()->name }}</strong>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end border-0 shadow">
                                <a class="dropdown-item" href="{{ route('user.profile.edit') }}">
                                    <i class="bi bi-person me-2 text-primary"></i> Hồ sơ cá nhân
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <main class="container-fluid p-4">
                @yield('content')
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>