@extends('layouts.admin')

@section('content')

{{-- CSS Custom cho Form Chỉnh sửa --}}
<style>
    /* Card Styles */
    .card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.05);
        background: #fff;
        overflow: hidden;
    }

    .card-header-modern {
        background: linear-gradient(135deg, #ffffff 0%, #fefcf3 100%); /* Màu nền hơi vàng nhẹ gợi ý Edit */
        border-bottom: 1px solid #f1f3f9;
        padding: 25px 30px;
    }

    /* Icon Header */
    .header-icon {
        width: 50px;
        height: 50px;
        background-color: rgba(246, 194, 62, 0.1); /* Màu vàng warning nhạt */
        color: #f6c23e;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 15px;
        box-shadow: 0 4px 10px rgba(246, 194, 62, 0.2);
    }

    /* Form Styles */
    .form-label-custom {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #858796;
        margin-bottom: 8px;
    }

    .form-control-custom {
        border-radius: 12px;
        border: 1px solid #e3e6f0;
        padding: 12px 18px;
        background-color: #fdfdfe;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control-custom:focus {
        background-color: #fff;
        border-color: #f6c23e;
        box-shadow: 0 0 0 4px rgba(246, 194, 62, 0.1);
    }
    
    .input-group-text-custom {
        background-color: #f8f9fc;
        border: 1px solid #e3e6f0;
        border-right: none;
        border-radius: 12px 0 0 12px;
        color: #858796;
        font-weight: 600;
    }
    
    .input-group .form-control-custom {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-left: none;
    }

    /* Image Preview */
    .img-preview-wrapper {
        border: 2px solid #eaecf4;
        border-radius: 16px;
        padding: 10px;
        background: #fff;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .img-preview {
        border-radius: 12px;
        max-height: 200px;
        object-fit: cover;
    }

    /* File Input Styling */
    .file-input-wrapper {
        position: relative;
        padding: 20px;
        border: 2px dashed #e3e6f0;
        border-radius: 12px;
        background-color: #f8f9fc;
        text-align: center;
        transition: all 0.3s;
    }
    .file-input-wrapper:hover {
        border-color: #f6c23e;
        background-color: #fffdf5;
    }

    /* Buttons */
    .btn-rounded {
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-gradient-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(246, 194, 62, 0.3);
    }
    .btn-gradient-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(246, 194, 62, 0.4);
        color: white;
    }
</style>

<div class="container py-4">
    <div class="card card-modern">
        {{-- Header --}}
        <div class="card-header-modern">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="header-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <h3 class="mb-1 fs-5 fw-bold text-dark">Chỉnh sửa Tour / Dịch vụ</h3>
                        <p class="mb-0 text-muted small">Cập nhật thông tin cho tour <span class="fw-bold text-dark">#{{ $product['id'] }}</span></p>
                    </div>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm btn-rounded shadow-sm text-secondary fw-bold">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
            </div>
        </div>
        
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('admin.products.update', $product['id']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row g-5">
                    {{-- Cột Trái --}}
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="name" class="form-label-custom">
                                <i class="bi bi-geo-alt-fill me-1 text-warning"></i> Tên Tour / Điểm đến
                            </label>
                            <input type="text" class="form-control form-control-custom @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $product->name) }}" 
                                   placeholder="Ví dụ: Tour Hạ Long 2 ngày 1 đêm" required>
                            @error('name')
                                <div class="invalid-feedback ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="price" class="form-label-custom">
                                <i class="bi bi-tag-fill me-1 text-warning"></i> Giá vé niêm yết (VNĐ)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom">₫</span>
                                <input type="number" step="0.01" class="form-control form-control-custom @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price', $product->price) }}" required min="0.01">
                            </div>
                            @error('price')
                                <div class="invalid-feedback d-block ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="stock" class="form-label-custom">
                                <i class="bi bi-ticket-perforated-fill me-1 text-warning"></i> Số chỗ còn nhận
                            </label>
                            <input type="number" class="form-control form-control-custom @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0">
                            <div class="form-text mt-2 ms-1 text-muted"><small><i class="bi bi-info-circle me-1"></i>Số lượng khách tối đa có thể đặt thêm.</small></div>
                            @error('stock')
                                <div class="invalid-feedback ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Cột Phải --}}
                    <div class="col-md-6">
                        <div class="mb-4 text-center">
                            <label class="form-label-custom d-block text-start mb-3">
                                <i class="bi bi-image-fill me-1 text-warning"></i> Hình ảnh hiện tại
                            </label>
                            
                            @if($product->image)
                                <div class="img-preview-wrapper position-relative">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="img-preview" alt="Tour image">
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success border border-light">
                                        Active
                                    </span>
                                </div>
                            @else
                                <div class="file-input-wrapper d-flex align-items-center justify-content-center" style="height: 150px;">
                                    <div class="text-muted">
                                        <i class="bi bi-image fs-1 d-block mb-2 opacity-50"></i>
                                        Chưa có hình ảnh
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label-custom">Thay đổi ảnh bìa</label>
                            <div class="file-input-wrapper py-3">
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*" style="background: transparent; border: none;">
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block ps-2">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-center mt-2 fst-italic text-muted">Chỉ chọn file nếu bạn muốn thay đổi ảnh cũ.</div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4 mt-2">
                    <label for="description" class="form-label-custom">
                        <i class="bi bi-file-earmark-text-fill me-1 text-warning"></i> Lịch trình chi tiết / Mô tả
                    </label>
                    <textarea class="form-control form-control-custom @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="6" 
                              placeholder="Nhập thông tin chi tiết về chuyến đi, các điểm tham quan..." required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <hr class="my-4" style="opacity: 0.1">
                
                <div class="d-flex justify-content-end gap-3">
                    <button type="reset" class="btn btn-light btn-rounded px-4 text-muted border">
                        <i class="bi bi-x-circle me-1"></i> Hủy thay đổi
                    </button>
                    <button type="submit" class="btn btn-gradient-warning btn-rounded px-5">
                        <i class="bi bi-check-circle-fill me-2"></i> Lưu thông tin Tour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection