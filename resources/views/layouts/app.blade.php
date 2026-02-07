<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Vé Du Lịch') }} - @yield('title')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #0dcaf0;
            --dark-bg: #0f172a;
            --glass-bg: rgba(255, 255, 255, 0.9);
            --glass-border: rgba(255, 255, 255, 0.2);
            --nav-bg: rgba(15, 23, 42, 0.85);
        }

        body {
            font-family: 'Inter', sans-serif;
            /* Background với lớp phủ tối nhẹ để làm nổi bật nội dung */
            background-image: linear-gradient(rgb(96, 93, 93), rgba(0, 255, 251, 0.4)), url('{{ asset('storage/backgrounds/bg.jpg') }}');
            background-size: cover; 
            background-repeat: no-repeat;
            background-attachment: fixed; 
            background-position: center;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #333;
        }

        /* Tùy chỉnh thanh cuộn (Scrollbar) */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #888; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555; 
        }

        /* Navbar Glassmorphism */
        .navbar {
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            background-color: var(--nav-bg) !important;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 15px 0;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: 0.5px;
            background: linear-gradient(45deg, #fff, #a5f3fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            font-weight: 500;
            font-size: 0.95rem;
            margin: 0 8px;
            transition: color 0.3s;
        }
        
        .nav-link:hover, .nav-link.active {
            color: #0dcaf0 !important;
        }

        /* Main Content Animation */
        main {
            flex: 1;
            padding-top: 40px;
            padding-bottom: 60px;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Custom Cards */
        .card-custom, .card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }

        /* Buttons Styling */
        .btn {
            border-radius: 50px; /* Bo tròn hoàn toàn */
            padding: 8px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        /* Nút Đăng ký (Gradient nổi bật) */
        .btn-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.4);
        }
        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.6);
            color: white;
        }

        /* Nút Đăng nhập (Outline trắng) */
        .btn-outline-light-custom {
            border: 2px solid rgba(255,255,255,0.6);
            color: white;
            background: transparent;
        }
        .btn-outline-light-custom:hover {
            background: white;
            color: var(--dark-bg);
            border-color: white;
        }

        /* Footer */
        footer {
            background: #0b1120 !important;
            color: #94a3b8;
            font-size: 0.9rem;
            position: relative;
            overflow: hidden;
        }
        
        .footer-heading {
            color: white;
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }
        
        .footer-heading::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 40px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .social-link {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            margin-right: 10px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .social-link:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <i class="fa-solid fa-plane-departure fs-4"></i>
                <span>VÉ DU LỊCH</span>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="/products">Tour & Vé</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('user/orders*') ? 'active' : '' }}" href="/user/orders">Tra cứu vé</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('feedback*') ? 'active' : '' }}" href="/feedback">Liên hệ</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <a href="/cart" class="position-relative text-white text-decoration-none me-2 opacity-75 hover-opacity-100 transition">
                        <i class="bi bi-cart3 fs-5"></i>
                        </a>
                    
                    @guest
                        <div class="d-flex gap-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-light-custom">
                                Đăng Nhập
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-gradient-primary">
                                Đăng Ký
                            </a>
                        </div>
                    @endguest

                    @auth
                        <div class="dropdown">
                            <button class="btn btn-dark bg-transparent border-0 d-flex align-items-center gap-2 text-white p-0" type="button" data-bs-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="Avatar" class="rounded-circle border border-2 border-white" width="35" height="35">
                                <span class="d-none d-lg-block fw-medium">{{ Auth::user()->name }}</span>
                                <i class="bi bi-chevron-down small opacity-50"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow-lg border-0 mt-2 rounded-3 overflow-hidden">
                                <li>
                                    <div class="px-3 py-2 border-bottom border-secondary">
                                        <small class="text-muted d-block">Xin chào,</small>
                                        <span class="fw-bold text-white">{{ Auth::user()->name }}</span>
                                    </div>
                                </li>
                                <li><a class="dropdown-item py-2" href="/user/profile"><i class="bi bi-person-gear me-2 text-primary"></i>Hồ sơ cá nhân</a></li>
                                <li><a class="dropdown-item py-2" href="/user/orders"><i class="bi bi-ticket-detailed me-2 text-success"></i>Vé đã đặt</a></li>
                                <li><hr class="dropdown-divider bg-secondary"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger fw-bold">
                                            <i class="bi bi-box-arrow-right me-2"></i>Đăng Xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer class="pt-5 pb-3">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-heading">VỀ CHÚNG TÔI</h5>
                    <p class="mb-4 text-secondary">
                        Tự hào là đơn vị cung cấp giải pháp đặt vé du lịch trực tuyến hàng đầu. Chúng tôi cam kết mang lại những trải nghiệm an toàn, nhanh chóng và tiện lợi nhất cho khách hàng.
                    </p>
                    <div class="d-flex">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-heading">THÔNG TIN LIÊN HỆ</h5>
                    <ul class="list-unstyled text-secondary">
                        <li class="mb-3 d-flex"><i class="fas fa-map-marker-alt text-primary mt-1 me-3"></i> Đại học Phenikaa, Yên Nghĩa, Hà Đông, Hà Nội</li>
                        <li class="mb-3 d-flex"><i class="fas fa-phone-alt text-primary mt-1 me-3"></i> 0123.456.789</li>
                        <li class="mb-3 d-flex"><i class="fas fa-envelope text-primary mt-1 me-3"></i> 23015552@st.phenikaa-uni.edu.vn</li>
                    </ul>
                </div>
                
                
            </div>
            
            <hr class="my-5 border-secondary opacity-25">
            
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <small class="text-secondary">&copy; {{ date('Y') }} <strong>Vé Du Lịch</strong>. Designed by Phenikaa Students.</small>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-decoration-none text-secondary me-3 small">Điều khoản</a>
                    <a href="#" class="text-decoration-none text-secondary small">Chính sách bảo mật</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>