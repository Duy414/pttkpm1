<div class="list-group-item">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h5 class="mb-1">
                <a href="{{ route('products.show', $review->product) }}">
                    {{ $review->product->name }}
                </a>
            </h5>
            
            <div class="d-flex align-items-center mb-2">
                @include('partials.star_rating', ['rating' => $review->rating])
                <span class="ms-2 text-muted">{{ $review->created_at->format('d/m/Y') }}</span>
            </div>
            
            <p class="mb-1">
                <strong>{{ $review->title }}</strong>
            </p>
            <p class="mb-1">{{ $review->comment }}</p>
            
            @if($review->approved)
                <span class="badge bg-success">Đã được duyệt</span>
            @else
                <span class="badge bg-warning">Chờ duyệt</span>
            @endif
        </div>
        
        <div class="btn-group">
            <button class="btn btn-sm btn-outline-primary edit-review-btn"
                data-review-id="{{ $review->id }}"
                data-rating="{{ $review->rating }}"
                data-title="{{ $review->title }}"
                data-comment="{{ $review->comment }}">
                <i class="fas fa-edit"></i> Sửa
            </button>
            
            <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"
                        onclick="return confirm('Bạn chắc chắn muốn xóa đánh giá này?')">
                    <i class="fas fa-trash"></i> Xóa
                </button>
            </form>
        </div>
    </div>
</div>