@extends('layouts.admin')

@section('title', 'Thêm Người dùng Mới')

@section('content')

{{-- CSS Custom cho Form --}}
<style>
    /* Card Styles */
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        background: #fff;
        overflow: hidden;
    }

    .card-header-modern {
        background: linear-gradient(135deg, #ffffff 0%, #f4f6f9 100%);
        border-bottom: 1px solid #eaecf4;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .header-icon-box {
        width: 45px;
        height: 45px;
        background: rgba(78, 115, 223, 0.1);
        color: #4e73df;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
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

    .form-control-modern {
        border-radius: 10px;
        border: 1px solid #d1d3e2;
        padding: 12px 15px;
        font-size: 0.95rem;
        transition: all 0.2s;
        background-color: #fcfcfc;
    }

    .form-control-modern:focus {
        background-color: #fff;
        border-color: #4e73df;
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
    }

    /* Checkbox Style */
    .checkbox-wrapper {
        background-color: #f8f9fc;
        border: 1px solid #eaecf4;
        padding: 15px;
        border-radius: 10px;
        transition: all 0.2s;
    }
    .checkbox-wrapper:hover {
        background-color: #f1f3f9;
        border-color: #4e73df;
    }
    
    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.15em;
        cursor: pointer;
    }
    .form-check-label {
        font-weight: 600;
        color: #5a5c69;
        cursor: pointer;
        margin-left: 8px;
    }

    /* Buttons */
    .btn-rounded {
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
    }
    
    .btn-gradient-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4);
        color: white;
    }
    
    .btn-light-custom {
        background: #f8f9fc;
        border: 1px solid #e3e6f0;
        color: #858796;
    }
    .btn-light-custom:hover {
        background: #eaecf4;
        color: #5a5c69;
    }
</style>

<div class="container-fluid py-4">
    <div class="card card-modern mb-4">
        {{-- Header --}}
        <div class="card-header-modern">
            <div class="header-icon-box">
                <i class="fas fa-user-plus"></i>
            </div>
            <div>
                <h6 class="m-0 font-weight-bold text-primary" style="font-size: 1.1rem;">Thêm Người dùng Mới</h6>
                <p class="m-0 small text-muted">Nhập thông tin chi tiết để tạo tài khoản thành viên</p>
            </div>
        </div>

        <div class="card-body p-4 p-md-5">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                {{-- Hàng 1: Tên & Email --}}
                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="form-group">
                            <label for="name" class="form-label-custom">
                                <i class="fas fa-signature me-1 text-gray-400"></i> Họ và tên
                            </label>
                            <input type="text" class="form-control form-control-modern" id="name" name="name" required placeholder="Nhập họ tên đầy đủ">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label-custom">
                                <i class="fas fa-envelope me-1 text-gray-400"></i> Email
                            </label>
                            <input type="email" class="form-control form-control-modern" id="email" name="email" required placeholder="example@email.com">
                        </div>
                    </div>
                </div>
                
                {{-- Hàng 2: Mật khẩu --}}
                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="form-group">
                            <label for="password" class="form-label-custom">
                                <i class="fas fa-lock me-1 text-gray-400"></i> Mật khẩu
                            </label>
                            <input type="password" class="form-control form-control-modern" id="password" name="password" required placeholder="••••••••">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label-custom">
                                <i class="fas fa-check-circle me-1 text-gray-400"></i> Xác nhận Mật khẩu
                            </label>
                            <input type="password" class="form-control form-control-modern" id="password_confirmation" name="password_confirmation" required placeholder="Nhập lại mật khẩu">
                        </div>
                    </div>
                </div>
                
                {{-- Hàng 3: SĐT & Địa chỉ --}}
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="form-group">
                            <label for="phone" class="form-label-custom">
                                <i class="fas fa-phone-alt me-1 text-gray-400"></i> Số điện thoại
                            </label>
                            <input type="text" class="form-control form-control-modern" id="phone" name="phone" placeholder="09xx xxx xxx">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address" class="form-label-custom">
                                <i class="fas fa-map-marker-alt me-1 text-gray-400"></i> Địa chỉ
                            </label>
                            <input type="text" class="form-control form-control-modern" id="address" name="address" placeholder="Nhập địa chỉ liên hệ">
                        </div>
                    </div>
                </div>
                
                {{-- Checkbox Admin --}}
                <div class="mb-4">
                    <div class="checkbox-wrapper d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_admin" name="is_admin" value="1">
                            <label class="form-check-label" for="is_admin">
                                Cấp quyền Quản trị viên (Admin)
                            </label>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4" style="opacity: 0.1;">
                
                {{-- Buttons --}}
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light-custom btn-rounded">
                        <i class="fas fa-arrow-left me-2"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-gradient-primary btn-rounded px-5">
                        <i class="fas fa-save me-2"></i> Tạo Người dùng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection