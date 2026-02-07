@extends('layouts.admin')

@section('content')

{{-- CSS Custom cho Form Thêm mới --}}
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
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
        border-bottom: 1px solid #f1f3f9;
        padding: 25px 30px;
    }

    /* Icon Header */
    .header-icon {
        width: 50px;
        height: 50px;
        background-color: rgba(28, 200, 138, 0.1); /* Màu xanh success nhạt */
        color: #1cc88a;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 15px;
        box-shadow: 0 4px 10px rgba(28, 200, 138, 0.2);
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
        border-color: #1cc88a;
        box-shadow: 0 0 0 4px rgba(28, 200, 138, 0.1);
    }

    .input-group-text-custom {
        background-color: #f8f9fc;
        border: 1px solid #e3e6f0;
        border-right: none;
        border-radius: 12px 0 0 12px;
        color: #858796;
        font-weight: 600;
    }
    
    /* Fix border radius for input group */
    .input-group .form-control-custom {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-left: none;
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
        border-color: #1cc88a;
        background-color: #f0fdf9;
    }

    /* Buttons */
    .btn-rounded {
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-gradient-success {
        background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(28, 200, 138, 0.3);
    }
    .btn-gradient-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(28, 200, 138, 0.4);
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
                        <i class="bi bi-plus-lg"></i>
                    </div>
                    <div>
                        <h3 class="mb-1 fs-5 fw-bold text-dark">Thiết lập Tour / Dịch vụ mới</h3>
                        <p class="mb-0 text-muted small">Điền thông tin chi tiết để phát hành tour mới</p>
                    </div>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-light btn-sm btn-rounded shadow-sm text-secondary fw-bold">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
            </div>
        </div>
        
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-4">
                    {{-- Cột Trái --}}
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="name" class="form-label-custom">
                                <i class="bi bi-tag-fill me-1 text-success"></i> Tên Tour / Gói dịch vụ
                            </label>
                            <input type="text" class="form-control form-control-custom @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="Ví dụ: Tour Khám Phá Đảo Phú Quốc 3N2Đ" required>
                            @error('name')
                                <div class="invalid-feedback ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="price" class="form-label-custom">
                                <i class="bi bi-currency-dollar me-1 text-success"></i> Giá vé trọn gói (VNĐ)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-custom">₫</span>
                                <input type="number" step="1000" class="form-control form-control-custom @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price') }}" 
                                       placeholder="Ví dụ: 2500000" required min="1000">
                            </div>
                            @error('price')
                                <div class="invalid-feedback d-block ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="stock" class="form-label-custom">
                                <i class="bi bi-people-fill me-1 text-success"></i> Số lượng vé phát hành
                            </label>
                            <input type="number" class="form-control form-control-custom @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock') }}" 
                                   placeholder="Ví dụ: 30" required min="1">
                            <div class="form-text mt-2 ms-1 text-muted"><small><i class="bi bi-info-circle me-1"></i>Tổng số khách tối đa cho chuyến đi này.</small></div>
                            @error('stock')
                                <div class="invalid-feedback ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- Cột Phải --}}
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="image" class="form-label-custom">
                                <i class="bi bi-image-fill me-1 text-success"></i> Hình ảnh quảng bá
                            </label>
                            <div class="file-input-wrapper">
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" accept="image/*" style="background: transparent; border: none;">
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block ps-2">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-center mt-2 fst-italic text-muted">Nên chọn ảnh chất lượng cao để thu hút khách hàng.</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label-custom">
                                <i class="bi bi-file-text-fill me-1 text-success"></i> Chương trình Tour & Mô tả
                            </label>
                            <textarea class="form-control form-control-custom @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="6" 
                                      placeholder="Mô tả sơ lược lịch trình, bao gồm: xe đưa đón, ăn uống, các điểm tham quan..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <hr class="my-4" style="opacity: 0.1">

                <div class="d-flex justify-content-end gap-3">
                    <button type="reset" class="btn btn-light btn-rounded px-4 text-muted border">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Làm mới
                    </button>
                    <button type="submit" class="btn btn-gradient-success btn-rounded px-5">
                        <i class="bi bi-check-lg me-2"></i> Phát hành Tour ngay
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection