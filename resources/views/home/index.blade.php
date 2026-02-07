{{-- @extends('layouts.app')

@section('title', 'Trang chủ - Hệ Thống Vé Du Lịch')

@section('content')
<div class="container py-5">
    <div class="mb-5 position-relative overflow-hidden rounded-4 shadow-lg">
        <div class="p-5 text-center text-white" 
             style="background: linear-gradient(45deg, rgba(13,110,253,0.8), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1350&q=80'); 
                    background-size: cover; background-position: center; min-height: 350px; display: flex; flex-direction: column; justify-content: center;">
            <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown">Khám Phá Thế Giới Cùng Chúng Tôi</h1>
            <p class="lead mb-4 opacity-75">Trải nghiệm những chuyến đi mơ ước với mức giá ưu đãi nhất thị trường</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="/products" class="btn btn-primary btn-lg px-5 rounded-pill shadow">Đặt Vé Ngay</a>
                <a href="#feedback" class="btn btn-outline-light btn-lg px-5 rounded-pill">Xem Đánh Giá</a>
            </div>
        </div>
    </div>

    <section class="mb-5">
        <div class="d-flex align-items-center mb-4">
            <h2 class="fw-bold mb-0 text-white">Sản Phẩm Nổi Bật</h2>
            <div class="ms-3 flex-grow-1 border-bottom border-primary border-2 opacity-25"></div>
        </div>
        
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card transition-all">
                    <div class="position-relative">
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-primary">Nổi bật</span>
                    </div>
                    <div class="card-body d-flex flex-direction-column">
                        <h5 class="card-title fw-bold text-dark">{{ $product->name }}</h5>
                        <p class="card-text text-primary fs-5 fw-bold mb-3">{{ number_format($product->price) }}₫</p>
                        <div class="mt-auto">
                            <a href="#" class="btn btn-outline-primary w-100 rounded-pill fw-bold">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <section id="feedback" class="mb-5">
        <div class="d-flex align-items-center mb-4 text-white">
            <h2 class="fw-bold mb-0">Khách Hàng Nói Gì</h2>
            <div class="ms-3 flex-grow-1 border-bottom border-white border-2 opacity-25"></div>
        </div>

        <div class="row g-4">
            @foreach($recentFeedbacks as $feedback)
            <div class="col-md-4">
                <div class="card h-100 border-0 rounded-4 shadow-sm" 
                     style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px);">
                    <div class="card-body p-4">
                        <div class="mb-3 text-warning">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="card-text italic text-dark opacity-75">"{{ Str::limit($feedback->message, 120) }}"</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 px-4 pb-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                {{ strtoupper(substr($feedback->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark small">{{ $feedback->user->name }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">{{ $feedback->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>

<style>
    /* Hiệu ứng phóng to nhẹ cho card sản phẩm */
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2) !important;
    }
    
    /* Làm ảnh sản phẩm zoom nhẹ khi hover */
    .product-card:hover img {
        transform: scale(1.05);
        transition: transform 0.5s ease;
    }

    /* Badge bo tròn đẹp hơn */
    .badge {
        padding: 8px 12px;
        font-weight: 500;
        border-radius: 8px;
    }

    /* Tinh chỉnh tiêu đề */
    h2 {
        position: relative;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    }
</style>
@endsection --}}