<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Viết đánh giá của bạn</h5>
    </div>
    
    <div class="card-body">
        <form id="reviewForm" action="{{ route('reviews.store', $product) }}" method="POST">
            @csrf
            
            <!-- Đánh giá sao -->
            <div class="mb-4">
                <label class="form-label fw-bold mb-3">Đánh giá sao</label>
                <div class="d-flex justify-content-between">
                    @for($i = 5; $i >= 1; $i--)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" 
                                   id="star-{{ $i }}" value="{{ $i }}"
                                   {{ old('rating', 5) == $i ? 'checked' : '' }}>
                            <label class="form-check-label fs-5" for="star-{{ $i }}">
                                {{ $i }} ★
                            </label>
                        </div>
                    @endfor
                </div>
                @error('rating')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Tiêu đề -->
            <div class="mb-4">
                <label for="title" class="form-label fw-bold">Tiêu đề đánh giá</label>
                <input type="text" class="form-control form-control-lg" id="title" 
                       name="title" value="{{ old('title') }}" required
                       placeholder="Tiêu đề đánh giá">
                @error('title')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Bình luận -->
            <div class="mb-4">
                <label for="comment" class="form-label fw-bold">Bình luận</label>
                <textarea class="form-control" id="comment" name="comment" 
                          rows="4" required placeholder="Bình luận của bạn...">{{ old('comment') }}</textarea>
                @error('comment')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg w-100">
                <i class="fas fa-paper-plane me-2"></i> Gửi đánh giá
            </button>
        </form>
    </div>
</div>