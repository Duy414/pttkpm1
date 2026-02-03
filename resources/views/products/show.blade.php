@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            @if($product->image)
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('storage/' . $product->image) }}" alt="Ảnh sản phẩm">
            </div>
            @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                    <span class="text-muted fs-5">Không có ảnh sản phẩm</span>
                </div>
            @endif
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h1 class="card-title">{{ $product->name }}</h1>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="text-success fw-bold">{{ number_format($product->price) }} VNĐ</h2>
                        <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }} fs-6">
                            {{ $product->stock > 0 ? 'Còn hàng' : 'Hết hàng' }}
                        </span>
                    </div>
                    
                    <hr>
                    
                    <h4 class="mt-4">Mô tả sản phẩm</h4>
                    <p class="card-text">{{ $product->description }}</p>
                    
                    <div class="mt-4">
                        <h5>Thông tin chi tiết</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Mã sản phẩm:</span>
                                <span class="fw-bold">#{{ $product['id'] }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Số lượng tồn kho:</span>
                                <span class="fw-bold">{{ $product->stock }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Ngày tạo:</span>
                                <span class="fw-bold">{{ $product->created_at->format('d/m/Y') }}</span>
                            </li>
                        </ul>
                    </div>
                    
                    <form action="{{ route('cart.add', $product['id']) }}" method="POST">
                        @csrf
                        <div class="mt-4 d-grid gap-2">
                            @if($product->stock > 0)
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-cart-plus me-2"></i> Thêm vào giỏ hàng
                                </button>
                            @else
                                <button class="btn btn-secondary btn-lg disabled">
                                    <i class="bi bi-exclamation-circle me-2"></i> Tạm hết hàng
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Đánh giá sản phẩm -->
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Danh sách đánh giá -->
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