<style>
    /* Tổng thể list */
    .reviews-container {
        max-width: 800px; /* Giới hạn chiều rộng để dễ đọc */
    }

    /* Tiêu đề mục */
    .section-title {
        font-weight: 800;
        color: #2d3748;
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 30px !important;
    }
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 4px;
        background: linear-gradient(90deg, #3182ce, #63b3ed); /* Màu xanh hiện đại */
        border-radius: 2px;
    }

    /* Card đánh giá từng người */
    .review-card {
        border: none !important; /* Bỏ viền mặc định */
        border-radius: 16px !important;
        background-color: #fff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); /* Bóng đổ mờ */
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        overflow: hidden;
    }

    .review-card:hover {
        transform: translateY(-3px); /* Bay nhẹ lên khi hover */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
    }

    /* Phần Header của card (Tên + Sao) */
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .user-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a202c;
        display: flex;
        align-items: center;
    }
    
    /* Tạo avatar giả bằng icon */
    .user-avatar-icon {
        width: 40px;
        height: 40px;
        background-color: #ebf8ff;
        color: #3182ce;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1.2rem;
    }

    .review-date {
        font-size: 0.85rem;
        color: #a0aec0;
        font-weight: 500;
    }

    /* Sao đánh giá */
    .rating-stars i {
        font-size: 0.9rem;
        margin-right: 2px;
    }
    .text-warning {
        color: #ecc94b !important; /* Màu vàng sang trọng hơn mặc định */
    }
    .text-muted-star {
        color: #e2e8f0; /* Màu sao rỗng */
    }

    /* Nội dung đánh giá */
    .review-title {
        font-weight: 700;
        font-size: 1rem;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .review-comment {
        color: #4a5568;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* Empty State (Khi chưa có đánh giá) */
    .empty-state-custom {
        background-color: #f7fafc;
        border: 2px dashed #cbd5e0;
        border-radius: 12px;
        color: #718096;
        text-align: center;
        padding: 40px 20px;
    }
</style>

<div class="mt-5 reviews-container">
    <h4 class="mb-4 section-title">Đánh giá sản phẩm</h4>
    
    @if($product->reviews->count() > 0)
        <div class="reviews-list">
            @foreach($product->reviews as $review)
                <div class="card mb-4 review-card">
                    <div class="card-body p-4">
                        <div class="review-header">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 user-name">{{ $review->user->name }}</h5>
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="fas fa-star text-muted-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <small class="review-date">
                                <i class="far fa-clock me-1"></i> {{ $review->created_at->format('d/m/Y') }}
                            </small>
                        </div>
                        
                        <div class="ms-0 ms-md-5 ps-md-2 border-start-md"> <h6 class="review-title">{{ $review->title }}</h6>
                            <p class="mb-0 review-comment">{{ $review->comment }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state-custom">
            <i class="far fa-comment-dots fa-3x mb-3 text-muted"></i>
            <p class="mb-0 fw-bold">Chưa có đánh giá nào cho sản phẩm này.</p>
            <small>Hãy là người đầu tiên chia sẻ trải nghiệm!</small>
        </div>
    @endif
</div>