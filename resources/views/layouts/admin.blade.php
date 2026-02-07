<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản trị - @yield('title', 'Admin Panel')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #4e73df;
            --sidebar-bg: #111827; /* Dark slate */
            --sidebar-hover: #1f2937;
            --body-bg: #f3f4f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
            overflow-x: hidden;
        }

        /* 1. Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #000000 100%);
            color: #fff;
            z-index: 1000;
            transition: all 0.3s;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar-brand {
            padding: 1.5rem 1rem;
            text-align: center;
            font-weight: 800;
            font-size: 1.2rem;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
        }

        .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            border-left: 4px solid transparent;
        }

        .nav-link:hover {
            color: #fff;
            background-color: var(--sidebar-hover);
            padding-left: 1.8rem; /* Hiệu ứng trượt nhẹ */
        }

        .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--primary-color);
            box-shadow: inset 5px 0 10px -5px rgba(0,0,0,0.2);
        }

        .nav-link i {
            width: 25px;
            font-size: 1.1rem;
        }

        /* 2. Content Wrapper */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s;
        }

        /* 3. Top Navbar */
        .top-navbar {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid #e5e7eb;
            padding: 0.8rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        /* 4. Dropdown User */
        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 30px;
            transition: background 0.2s;
        }
        .user-dropdown-toggle:hover {
            background-color: #f3f4f6;
        }
        .user-avatar {
            width: 35px;
            height: 35px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Responsive Fix */
        @media (max-width: 768px) {
            .sidebar { margin-left: calc(var(--sidebar-width) * -1); }
            .main-content { margin-left: 0; }
            .sidebar.active { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="sidebar d-flex flex-column flex-shrink-0" id="sidebar">
        <div class="sidebar-brand">
            <div class="d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-airplane-engines-fill text-primary"></i>
                <span>TRAVEL ADMIN</span>
            </div>
        </div>
        
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    Tổng quan
                </a>
            </li>

            <li class="nav-item mt-3 px-3 text-uppercase text-white-50 small fw-bold" style="font-size: 0.75rem;">Quản lý Dịch vụ</li>

            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                    <i class="bi bi-map"></i>
                    Tour & Dịch vụ
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="bi bi-ticket-perforated"></i>
                    Quản lý Booking
                </a>
            </li>

            <li class="nav-item mt-3 px-3 text-uppercase text-white-50 small fw-bold" style="font-size: 0.75rem;">Người dùng & Phản hồi</li>

            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    Khách Hàng
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                    <i class="bi bi-star"></i>
                    Đánh giá Tour
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.feedbacks.index') }}" class="nav-link {{ request()->routeIs('admin.feedbacks*') ? 'active' : '' }}">
                    <i class="bi bi-chat-heart"></i>
                    Góp ý Website
                </a>
            </li>
        </ul>

        <div class="p-3 text-center text-white-50 small border-top border-secondary mt-auto">
            &copy; {{ date('Y') }} Travel System
        </div>
    </nav>

    <div class="main-content">
        
        <nav class="navbar navbar-expand top-navbar shadow-sm">
            <div class="container-fluid">
                <button class="btn btn-link d-md-none me-3" id="sidebarToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>

                

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle user-dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-none d-lg-flex flex-column text-end me-2">
                                <span class="text-dark fw-bold small">{{ Auth::user()->name }}</span>
                                <span class="text-muted small" style="font-size: 0.7rem;">Quản lý</span>
                            </div>
                            <div class="user-avatar">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in border-0 mt-2" aria-labelledby="userDropdown">
                            
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger fw-bold">
                                    <i class="bi bi-box-arrow-right fa-sm fa-fw me-2"></i>
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="flex-grow-1">
            @yield('content')
        </main>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Script toggle sidebar cho mobile --}}
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    @stack('scripts')
</body>
</html>