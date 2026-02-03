@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-header bg-success text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0 fs-4"><i class="bi bi-plus-square-fill me-2"></i>Thiết lập Tour / Dịch vụ mới</h3>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách
                </a>
            </div>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Tên Tour / Gói dịch vụ</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="Ví dụ: Tour Khám Phá Đảo Phú Quốc 3N2Đ" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label fw-bold">Giá vé trọn gói (VNĐ)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">₫</span>
                                <input type="number" step="1000" class="form-control @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price') }}" 
                                       placeholder="Ví dụ: 2500000" required min="1000">
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="stock" class="form-label fw-bold">Số lượng vé phát hành (Chỗ trống)</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock') }}" 
                                   placeholder="Ví dụ: 30" required min="1">
                            <div class="form-text">Tổng số khách tối đa cho chuyến đi này.</div>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold">Hình ảnh quảng bá Tour</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text italic text-muted">Nên chọn ảnh chất lượng cao để thu hút khách hàng.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Chương trình Tour & Mô tả dịch vụ</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" 
                                      placeholder="Mô tả sơ lược lịch trình, bao gồm: xe đưa đón, ăn uống, các điểm tham quan..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="reset" class="btn btn-light px-4">Làm mới form</button>
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class="bi bi-send-check-fill me-2"></i> Phát hành Tour ngay
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection