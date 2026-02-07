@extends('layouts.app')

@section('content')

{{-- CSS Riêng cho trang này --}}
<style>
    /* 1. Khu vực bộ lọc (Filter Box) */
    .filter-box {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    
    .form-control-custom, .form-select-custom {
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        padding: 12px 15px;
        background-color: #f8f9fa;
        transition: all 0.3s;
    }

    .form-control-custom:focus, .form-select-custom:focus {
        background-color: #fff;
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }

    /* 2. Thẻ sản phẩm (Product Card) */
    .product-card {
        border: none;
        border-radius: 20px;
        background: #fff;
        transition: all 0.4s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        height: 100%;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    /* Hiệu ứng Zoom ảnh */
    .img-wrapper {
        overflow: hidden;
        height: 220px;
        position: relative;
    }
    
    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .product-card:hover .product-img {
        transform: scale(1.1);
    }

    /* Nút xem chi tiết ẩn hiện */
    .overlay-btn {
        position: absolute;
        bottom: -50px;
        left: 0;
        right: 0;
        padding: 15px;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        display: flex;
        justify-content: center;
        transition: bottom 0.3s ease;
    }
    
    .product-card:hover .overlay-btn {
        bottom: 0;
    }

    /* Typography & Badges */
    .card-title {
        font-weight: 700;
        color: #2d3748;
        font-size: 1.1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .price-tag {
        color: #0d6efd;
        font-weight: 800;
        font-size: 1.25rem;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Pagination Custom */
    .pagination-wrapper .page-link {
        border-radius: 50%;
        margin: 0 5px;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        color: #4a5568;
        font-weight: 600;
    }
    .pagination-wrapper .page-item.active .page-link {
        background-color: #0d6efd;
        color: #fff;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
    }
</style>

<div class="container py-5">
    {{-- Tiêu đề trang trí --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold display-6 text-white" style="text-shadow: 0 2px 10px rgba(0,0,0,0.3);">Danh sách sản phẩm</h1>
        <div class="bg-white mx-auto rounded-pill mt-2" style="width: 80px; height: 4px; opacity: 0.8"></div>
    </div>

    {{-- Form lọc (Filter Box) --}}
    <form action="{{ route('products.index') }}" method="GET" class="mb-5 filter-box">
        <div class="row g-4 align-items-end">
            <div class="col-md-4">
                <label for="search" class="form-label fw-bold text-secondary small text-uppercase">Tìm kiếm</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-0 ps-0 text-muted"><i class="fas fa-search"></i></span>
                    <input type="text" 
                        name="search" 
                        id="search"
                        class="form-control form-control-custom" 
                        placeholder="Nhập tên sản phẩm..." 
                        value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-3">
                <label for="price_range" class="form-label fw-bold text-secondary small text-uppercase">Khoảng giá</label>
                <select name="price_range" id="price_range" class="form-select form-select-custom">
                    <option value="">Tất cả</option>
                    <option value="1" {{ request('price_range') == '1' ? 'selected' : '' }}>Dưới 5.000.000đ</option>
                    <option value="2" {{ request('price_range') == '2' ? 'selected' : '' }}>5.000.000đ - 10.000.000đ</option>
                    <option value="3" {{ request('price_range') == '3' ? 'selected' : '' }}>Trên 10.000.000đ</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="stock" class="form-label fw-bold text-secondary small text-uppercase">Tình trạng</label>
                <select name="stock" id="stock" class="form-select form-select-custom">
                    <option value="">Tất cả</option>
                    <option value="in" {{ request('stock') == 'in' ? 'selected' : '' }}>Còn vé</option>
                    <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Hết vé</option>
                </select>
            </div>

            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm py-2" type="submit">Lọc</button>
                    <a href="{{ route('products.index') }}" class="btn btn-light w-100 rounded-pill border text-muted py-2" data-bs-toggle="tooltip" title="Làm mới"><i class="fas fa-sync-alt"></i></a>
                </div>
            </div>
        </div>
    </form>
    
    {{-- Danh sách sản phẩm --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
        @foreach($products as $product)
        <div class="col">
            <div class="card h-100 product-card d-flex flex-column">
                <div class="img-wrapper">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" class="product-img">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center h-100">
                            <i class="fas fa-image fa-3x text-muted opacity-25"></i>
                        </div>
                    @endif
                    
                    {{-- Nút xem nhanh khi hover --}}
                    <div class="overlay-btn">
                        <a href="{{ route('products.show', $product['id']) }}" class="btn btn-light btn-sm rounded-pill px-3 fw-bold shadow">
                            Xem chi tiết <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body d-flex flex-column p-4">
                    {{-- Tên và Giá --}}
                    <div class="mb-3">
                        <h5 class="card-title mb-2">{{ $product->name }}</h5>
                        <p class="price-tag mb-0">{{ number_format($product->price) }} <small class="fs-6 text-muted fw-normal">VNĐ</small></p>
                    </div>

                    {{-- Mô tả ngắn --}}
                    <p class="card-text text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">
                        {{ Str::limit($product->description, 80) }}
                    </p>

                    {{-- Footer Card: Status & Button --}}
                    <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-auto">
                        @if($product->stock > 0)
                            <span class="status-badge bg-success-subtle text-success border border-success-subtle">
                                <i class="fas fa-check-circle me-1"></i> Còn vé ({{ $product->stock }})
                            </span>
                        @else
                            <span class="status-badge bg-danger-subtle text-danger border border-danger-subtle">
                                <i class="fas fa-times-circle me-1"></i> Hết vé
                            </span>
                        @endif
                        
                        <a href="{{ route('products.show', $product['id']) }}" class="btn btn-outline-primary rounded-circle btn-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination đẹp --}}
    <div class="d-flex justify-content-center pagination-wrapper">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection