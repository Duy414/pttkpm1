@extends('layouts.app')

@section('content')

{{-- CSS Riêng cho trang chi tiết sản phẩm --}}
<style>
    /* 1. Layout & Glass Effect */
    .glass-panel {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
        border-radius: 24px;
    }

    /* 2. Hình ảnh sản phẩm */
    .product-img-wrapper {
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        position: relative;
        background: #fff;
    }

    .product-detail-img {
        width: 100%;
        height: auto;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-img-wrapper:hover .product-detail-img {
        transform: scale(1.03); /* Zoom nhẹ khi hover */
    }

    /* Placeholder khi không có ảnh */
    .no-image-placeholder {
        height: 450px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        border-radius: 24px;
    }

    /* 3. Typography & Badges */
    .product-title {
        font-weight: 800;
        color: #2d3748;
        letter-spacing: -0.5px;
    }

    .price-text {
        background: linear-gradient(135deg, #0d6efd, #0dcaf0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        font-size: 2rem;
    }

    .stock-badge {
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }
    
    .stock-in {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    
    .stock-out {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* 4. Feature List (Thông tin chi tiết) */
    .feature-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px dashed #e2e8f0;
    }
    .feature-item:last-child {
        border-bottom: none;
    }
    .feature-icon {
        width: 36px;
        height: 36px;
        background-color: #eff6ff;
        color: #3b82f6;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }

    /* 5. Nút bấm */
    .btn-action-lg {
        border-radius: 50px;
        padding: 14px 20px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
    }
    
    .btn-action-lg:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(13, 110, 253, 0.5);
    }

    .divider-custom {
        height: 2px;
        background: linear-gradient(to right, transparent, #e2e8f0, transparent);
        margin: 40px 0;
    }
</style>

<div class="container py-5">
    <div class="row g-5 align-items-start">
        <div class="col-lg-6 mb-4 mb-lg-0">
            @if($product->image)
                <div class="product-img-wrapper">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-detail-img">
                </div>
            @else
                <div class="no-image-placeholder shadow-sm">
                    <i class="bi bi-image fs-1 mb-3 opacity-50"></i>
                    <span class="fs-5 fw-medium">Không có ảnh sản phẩm</span>
                </div>
            @endif
        </div>
        
        <div class="col-lg-6">
            <div class="glass-panel p-4 p-md-5 h-100">
                <h1 class="product-title display-6 mb-3">{{ $product->name }}</h1>
                
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                    <h2 class="price-text mb-0">{{ number_format($product->price) }} <span class="fs-4 text-muted fw-normal">VNĐ</span></h2>
                    
                    @if($product->stock > 0)
                        <span class="stock-badge stock-in">
                            <i class="bi bi-check-circle-fill me-1"></i> Còn vé
                        </span>
                    @else
                        <span class="stock-badge stock-out">
                            <i class="bi bi-x-circle-fill me-1"></i> Hết vé
                        </span>
                    @endif
                </div>
                
                <div class="mb-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-card-text me-2 text-primary"></i>Mô tả sản phẩm</h5>
                    <p class="text-secondary" style="line-height: 1.7;">{{ $product->description }}</p>
                </div>
                
                <div class="mb-4 bg-white rounded-4 p-3 border border-light">
                    <h6 class="fw-bold text-muted text-uppercase small mb-3 ls-1 ps-2">Thông tin chi tiết</h6>
                    
                    <div class="feature-item">
                        <div class="feature-icon"><i class="bi bi-upc-scan"></i></div>
                        <div class="flex-grow-1 text-secondary">Mã sản phẩm</div>
                        <div class="fw-bold text-dark">#{{ $product['id'] }}</div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon"><i class="bi bi-box-seam"></i></div>
                        <div class="flex-grow-1 text-secondary">Số lượng tồn kho</div>
                        <div class="fw-bold text-dark">{{ $product->stock }}</div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon"><i class="bi bi-calendar3"></i></div>
                        <div class="flex-grow-1 text-secondary">Ngày tạo</div>
                        <div class="fw-bold text-dark">{{ $product->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
                
                <form action="{{ route('cart.add', $product['id']) }}" method="POST">
                    @csrf
                    <div class="d-grid gap-2 mt-4">
                        @if($product->stock > 0)
                            <button type="submit" class="btn btn-primary btn-action-lg">
                                <i class="bi bi-cart-plus me-2"></i> Thêm vào giỏ hàng
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary btn-action-lg disabled" style="opacity: 0.7;">
                                <i class="bi bi-exclamation-circle me-2"></i> Tạm hết vé
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="divider-custom"></div>

    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="text-center mb-5">
                <h3 class="fw-bold">Đánh giá từ khách hàng</h3>
                <p class="text-muted">Những chia sẻ thực tế từ người đã trải nghiệm</p>
            </div>
            
            @include('products._reviews_list')
        </div>
    </div>
</div>
@endsection

@section('scripts')
@auth
<script>
    $(document).ready(function() {
        // Xử lý sự kiện sửa đánh giá
        $('.edit-review-btn').click(function() {
            const reviewId = $(this).data('review-id');
            const rating = $(this).data('rating');
            const title = $(this).data('title');
            const comment = $(this).data('comment');
            
            // Cập nhật form modal
            $('#editReviewForm').attr('action', `/reviews/${reviewId}`);
            $(`#editReviewForm input[name="rating"][value="${rating}"]`).prop('checked', true);
            $('#edit-title').val(title);
            $('#edit-comment').val(comment);
            
            // Hiển thị modal
            $('#editReviewModal').modal('show');
        });
    });
</script>
@endauth
@endsection