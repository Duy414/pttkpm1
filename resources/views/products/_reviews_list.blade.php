<div class="mt-5">
    <h4 class="mb-4">Đánh giá sản phẩm</h4>
    
    @if($product->reviews->count() > 0)
        <div class="reviews-list">
            @foreach($product->reviews as $review)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h5 class="mb-0">{{ $review->user->name }}</h5>
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <small class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                        </div>
                        
                        <h6>{{ $review->title }}</h6>
                        <p class="mb-0">{{ $review->comment }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            Chưa có đánh giá nào cho sản phẩm này.
        </div>
    @endif
</div>