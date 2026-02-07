@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px);">
                
                <div class="bg-primary" style="height: 6px;"></div>

                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <i class="fa-solid fa-paper-plane text-primary fa-3x mb-3"></i>
                        <h2 class="fw-bold">Gửi phản hồi</h2>
                        <p class="text-muted">Ý kiến của bạn giúp chúng tôi hoàn thiện dịch vụ mỗi ngày.</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show rounded-3" role="alert">
                            <i class="fa-solid fa-circle-check me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('feedback.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="message" class="form-label fw-bold">Nội dung phản hồi</label>
                            <textarea class="form-control border-0 bg-light @error('message') is-invalid @enderror" 
                                id="message" 
                                name="message" 
                                rows="6" 
                                style="border-radius: 12px; transition: all 0.3s ease;"
                                placeholder="Chia sẻ ý kiến của bạn với chúng tôi..."
                                required>{{ old('message') }}</textarea>
                            
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm py-3 transition-hover">
                                <i class="fa-solid fa-paper-plane me-2"></i>Gửi phản hồi ngay
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light border-0 py-3 text-center">
                    <small class="text-muted"><i class="fa-solid fa-shield-halved me-1"></i> Chúng tôi luôn trân trọng mọi ý kiến đóng góp</small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Hiệu ứng khi nhấn vào ô nhập liệu */
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1) !important;
        border: 1px solid #0d6efd !important;
    }

    /* Hiệu ứng khi di chuột vào nút */
    .transition-hover {
        transition: all 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3) !important;
    }
</style>
@endsection