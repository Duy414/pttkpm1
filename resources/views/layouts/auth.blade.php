<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TravelBooking') }} - @yield('title')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            /* Đổi sang màu xanh biển/trời cho hợp du lịch */
            --primary-color: #0ea5e9; 
            --primary-hover: #0284c7;
            --text-color: #334155;
            --bg-overlay: rgba(14, 165, 233, 0.85); /* Lớp phủ màu xanh lên ảnh nền */
        }
        
        body {
            /* Hình nền du lịch mờ phía sau */
            background: url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?ixlib=rb-4.0.3&auto=format&fit=crop&w=2021&q=80') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
            font-size: 1.1rem;
            backdrop-filter: blur(5px); /* Làm mờ nền để nổi bật form */
        }
        
        .auth-container {
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }
        
        .auth-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.2);
            overflow: hidden;
            height: 100%;
            min-height: 600px;
            background: white;
        }
        
        .auth-left {
            /* Gradient kết hợp ảnh nền cho cột trái */
            background: linear-gradient(135deg, var(--primary-color) 0%, #3b82f6 100%);
            color: white;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }
        
        /* Trang trí thêm họa tiết mây/sóng nếu thích (optional) */
        .auth-left::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to top, rgba(255,255,255,0.1), transparent);
            pointer-events: none;
        }
        
        .auth-left h2 {
            font-weight: 800;
            margin-bottom: 1.5rem;
            font-size: 2.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .auth-left p {
            font-size: 1.4rem;
            opacity: 0.95;
            line-height: 1.6;
            font-weight: 500;
        }
        
        .auth-left ul {
            margin-top: 2rem;
            padding-left: 0;
            list-style: none; /* Bỏ dấu chấm mặc định */
        }
        
        .auth-left ul li {
            margin-bottom: 1.2rem;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
        }
        
        .auth-left ul li i {
            margin-right: 15px;
            background: rgba(255,255,255,0.2);
            padding: 8px;
            border-radius: 50%;
            font-size: 1rem;
        }
        
        .auth-left .icon-list {
            display: flex;
            margin-top: 3rem;
            gap: 2rem;
            justify-content: flex-start;
        }
        
        .auth-left .icon-list i {
            font-size: 2.5rem;
            opacity: 0.8;
            transition: transform 0.3s;
        }
        
        .auth-left .icon-list i:hover {
            transform: translateY(-5px) scale(1.1);
            opacity: 1;
        }
        
        .auth-right {
            padding: 4rem;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo img {
            height: 90px;
            object-fit: contain;
        }
        
        .auth-header {
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .auth-header h1 {
            font-weight: 800;
            font-size: 2.2rem;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }
        
        .auth-header p {
            color: #64748b;
            font-size: 1.2rem;
        }
        
        /* FORM STYLING */
        .form-label {
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        
        .form-control {
            padding: 1rem 1.2rem;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            font-size: 1.1rem;
            transition: all 0.2s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 1rem;
            font-size: 1.2rem;
            font-weight: 700;
            border-radius: 12px;
            letter-spacing: 0.5px;
            margin-top: 1rem;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }
        
        .auth-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 1.1rem;
            color: #64748b;
        }
        
        .auth-footer a {
            color: var(--primary-color);
            font-weight: 700;
            text-decoration: none;
        }
        
        .auth-footer a:hover {
            text-decoration: underline;
        }
        
        /* CHECKBOX & ALERTS */
        .form-check-input {
            width: 1.3em;
            height: 1.3em;
            cursor: pointer;
        }
        .form-check-label {
            cursor: pointer;
            font-size: 1.1rem;
            padding-left: 0.5rem;
            color: #64748b;
        }
        
        .alert {
            border-radius: 12px;
            font-size: 1.1rem;
            border: none;
        }
        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .alert-success {
            background-color: #dcfce7;
            color: #166534;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .auth-card {
                flex-direction: column;
            }
            .auth-left {
                padding: 3rem;
                text-align: center;
            }
            .auth-left .icon-list {
                justify-content: center;
            }
            .auth-right {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="row g-0 h-100 align-items-center justify-content-center">
            <div class="col-xl-10 col-lg-12">
                <div class="row g-0 auth-card">
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="auth-left">
                            <h2>Khám phá Thế giới cùng Phenikaa Travel</h2>
                            <p>Hệ thống đặt vé và tour du lịch trực tuyến hàng đầu. Bắt đầu hành trình mơ ước của bạn ngay hôm nay!</p>
                            
                            <ul>
                                <li><i class="fas fa-plane-departure"></i> Đặt vé máy bay & Tour giá tốt</li>
                                <li><i class="fas fa-map-marked-alt"></i> Hơn 1,000 điểm đến hấp dẫn</li>
                                <li><i class="fas fa-shield-alt"></i> Thanh toán an toàn, bảo mật</li>
                                <li><i class="fas fa-headset"></i> Hỗ trợ du khách 24/7</li>
                            </ul>
                            
                            <div class="icon-list">
                                <i class="fas fa-suitcase-rolling" title="Du lịch"></i>
                                <i class="fas fa-umbrella-beach" title="Nghỉ dưỡng"></i>
                                <i class="fas fa-camera-retro" title="Khám phá"></i>
                                <i class="fas fa-globe-asia" title="Quốc tế"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="auth-right">
                            <div class="logo">
                                <img src="{{ asset('storage/logo/phenikaa1.webp') }}" alt="Phenikaa Travel Logo">
                            </div>
                            
                            <div class="auth-header">
                                @yield('auth-header')
                            </div>
                            
                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-circle me-2 fs-4"></i>
                                        <ul class="mb-0 ps-3">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show mb-4">
                                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            @yield('content')
                            
                            <div class="auth-footer">
                                @yield('auth-footer')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.querySelectorAll('.password-toggle').forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const passwordInput = document.getElementById(this.dataset.target);
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>