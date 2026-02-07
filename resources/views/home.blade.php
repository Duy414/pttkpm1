@extends('layouts.app')

@section('content')

{{-- Thêm chút CSS nội bộ để xử lý hiệu ứng hover mượt mà --}}
<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .img-wrapper {
        overflow: hidden;
        border-radius: 1rem 1rem 0 0;
    }
    .img-zoom {
        transition: transform 0.5s ease;
    }
    .hover-card:hover .img-zoom {
        transform: scale(1.05);
    }
    .hero-section {
        background: linear-gradient(rgb(20, 102, 78), rgba(4, 222, 255, 0.5)), url('https://images.unsplash.com/photo-1500835595353-b0ad2427a191?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
    }
</style>

<div class="container py-5">
    {{-- Banner Section --}}
    <div class="mb-5">
        <div class="hero-section text-white p-5 rounded-4 text-center shadow-lg d-flex flex-column justify-content-center align-items-center" style="min-height: 300px;">
            <h1 class="display-4 fw-bold mb-3" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Khám Phá Hành Trình Mới</h1>
            <p class="lead fs-4" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">Hệ thống đặt vé du lịch trực tuyến nhanh chóng và uy tín</p>
        </div>
    </div>

    {{-- Featured Tours Section --}}
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-end mb-4 px-2">
            <div>
                <h2 class="mb-1 fw-bold text-dark">Tour Du Lịch Bán Chạy</h2>
                <div class="bg-primary pt-1 rounded" style="width: 60px;"></div> {{-- Đường gạch chân trang trí --}}
            </div>
            <span class="text-muted d-none d-md-block">Khám phá các điểm đến hấp dẫn nhất</span>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($featuredProducts as $product)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm hover-card rounded-4">
                    <a href="{{ route('products.show', $product['id']) }}" class="position-relative img-wrapper">
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="card-img-top img-zoom" 
                             style="height:220px; object-fit:cover;">
                        
                        {{-- Nhãn giá được làm đẹp hơn --}}
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-danger text-white shadow rounded-pill px-3 py-2">
                                <i class="fa-solid fa-fire me-1"></i> Hot Deal
                            </span>
                        </div>
                    </a>
                    
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title fw-bold text-dark mb-3" style="font-size: 1.15rem; line-height: 1.4;">
                            <a href="{{ route('products.show', $product['id']) }}" class="text-decoration-none text-dark stretched-link">
                                {{ $product->name }}
                            </a>
                        </h5>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted small">Giá vé:</span>
                                <span class="text-primary fw-bold fs-5">
                                    {{ number_format($product->price) }} <small class="fs-6">VNĐ</small>
                                </span>
                            </div>
                            
                            <a href="{{ route('products.show', $product['id']) }}" class="btn btn-outline-primary w-100 rounded-pill fw-bold py-2 position-relative z-2">
                                Xem lịch trình <i class="fa-solid fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection