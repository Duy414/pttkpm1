<style>
    /* 1. Làm đẹp khung Card */
    .custom-card {
        border: none !important;
        border-radius: 20px !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .custom-header {
        background-color: #fff !important;
        border-bottom: 1px solid #f0f0f0;
        padding: 20px 25px !important;
    }
    .custom-header h5 {
        font-weight: 700;
        color: #333;
    }

    /* 2. Biến Radio Button thành nút chọn đẹp mắt (Star Chips) */
    /* Ẩn nút tròn mặc định */
    .form-check-input[type="radio"] {
        display: none;
    }
    
    /* Style cho nhãn (Label) chứa số sao */
    .form-check-label {
        cursor: pointer;
        padding: 10px 20px;
        border-radius: 50px;
        background-color: #f8f9fa;
        color: #6c757d;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* Hiệu ứng khi Rê chuột vào nhãn */
    .form-check-label:hover {
        background-color: #fff3cd;
        border-color: #ffc107;
        color: #856404;
        transform: translateY(-2px);
    }

    /* Hiệu ứng khi Đã chọn (Checked) */
    .form-check-input:checked + .form-check-label {
        background: linear-gradient(45deg, #ffc107, #ffdb4d);
        color: #fff;
        border-color: #ffc107;
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        transform: scale(1.05);
    }

    /* 3. Làm đẹp ô nhập liệu (Input & Textarea) */
    .form-control {
        border-radius: 12px !important;
        border: 1px solid #e2e5e8;
        padding: 12px 15px;
        background-color: #fdfdfd;
        transition: all 0.3s;
    }
    .form-control:focus {
        background-color: #fff;
        border-color: #86b7fe;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }
    .form-label {
        color: #495057;
        font-size: 0.95rem;
    }

    /* 4. Nút Gửi */
    .btn-submit-custom {
        border-radius: 12px;
        padding: 12px;
        font-weight: bold;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
    }
    .btn-submit-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    }
</style>

<div class="card mb-4 custom-card">
    <div class="card-header bg-light custom-header">
        <h5 class="mb-0">Viết đánh giá của bạn</h5>
    </div>
    
    <div class="card-body p-4">
        <form id="reviewForm" action="{{ route('reviews.store', $product) }}" method="POST">
            @csrf
            
            <div class="mb-4 text-center">
                <label class="form-label fw-bold mb-3 d-block text-start">Đánh giá sao</label>
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    @for($i = 5; $i >= 1; $i--)
                        <div class="form-check form-check-inline m-0">
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
            
            <div class="mb-4">
                <label for="title" class="form-label fw-bold">Tiêu đề đánh giá</label>
                <input type="text" class="form-control form-control-lg" id="title" 
                       name="title" value="{{ old('title') }}" required
                       placeholder="Tiêu đề đánh giá">
                @error('title')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="comment" class="form-label fw-bold">Bình luận</label>
                <textarea class="form-control" id="comment" name="comment" 
                          rows="4" required placeholder="Bình luận của bạn...">{{ old('comment') }}</textarea>
                @error('comment')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg w-100 btn-submit-custom">
                <i class="fas fa-paper-plane me-2"></i> Gửi đánh giá
            </button>
        </form>
    </div>
</div>