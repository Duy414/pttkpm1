@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0 fs-4"><i class="bi bi-geo-alt-fill me-2"></i>Chỉnh sửa Tour / Dịch vụ</h3>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách
                </a>
            </div>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('admin.products.update', $product['id']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Tên Tour / Điểm đến</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $product->name) }}" 
                                   placeholder="Ví dụ: Tour Hạ Long 2 ngày 1 đêm" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label fw-bold">Giá vé niêm yết (VNĐ)</label>
                            <div class="input-group">
                                <span class="input-group-text">₫</span>
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price', $product->price) }}" required min="0.01">
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="stock" class="form-label fw-bold">Số chỗ còn nhận (Số vé)</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0">
                            <div class="form-text">Số lượng khách tối đa có thể đặt thêm.</div>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3 text-center">
                            <label class="form-label fw-bold d-block text-start">Hình ảnh đại diện Tour</label>
                            @if($product->image)
                                <div class="position-relative d-inline-block mb-3">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="img-thumbnail shadow-sm" 
                                         style="max-height: 180px; width: auto;"
                                         alt="Tour image">
                                </div>
                            @else
                                <div class="alert alert-light border text-muted py-4">
                                    <i class="bi bi-image-fill fs-1 d-block mb-2"></i>
                                    Chưa có hình ảnh cho dịch vụ này
                                </div>
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold">Thay đổi ảnh bìa</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text italic">Chọn file mới nếu bạn muốn thay đổi hình ảnh quảng bá.</div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Lịch trình chi tiết / Mô tả dịch vụ</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="6" 
                              placeholder="Nhập thông tin chi tiết về chuyến đi, các điểm tham quan..." required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="reset" class="btn btn-outline-secondary px-4">Hủy thay đổi</button>
                    <button type="submit" class="btn btn-warning px-5 fw-bold">
                        <i class="bi bi-cloud-arrow-up-fill me-2"></i>Lưu thông tin Tour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection