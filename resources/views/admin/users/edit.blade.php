@extends('layouts.admin')

@section('title', 'Chỉnh sửa Người dùng')

@section('content')

{{-- CSS Custom cho Form Edit User --}}
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
        background: rgba(246, 194, 62, 0.1);
        color: #f6c23e;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
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
        border-color: #f6c23e;
        box-shadow: 0 0 0 4px rgba(246, 194, 62, 0.1);
    }
    .checkbox-wrapper {
        background-color: #fff8e1;
        border: 1px solid #ffeec2;
        padding: 15px;
        border-radius: 10px;
        transition: all 0.2s;
    }
    .checkbox-wrapper:hover {
        background-color: #fff3cd;
        border-color: #f6c23e;
    }
    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.15em;
        cursor: pointer;
    }
    .form-check-label {
        font-weight: 600;
        color: #856404;
        cursor: pointer;
        margin-left: 8px;
    }
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
        box-shadow: 0 6px 20px rgba(246, 194, 62, 0.4);
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
                <i class="fas fa-user-edit"></i>
            </div>
            <div>
                <h6 class="m-0 font-weight-bold text-dark" style="font-size: 1.1rem;">
                    Chỉnh sửa Người dùng
                </h6>
                <p class="m-0 small text-muted">
                    Cập nhật thông tin tài khoản:
                    <span class="text-primary font-weight-bold">{{ $user->name }}</span>

                    {{-- SỬA 1: Kiểm tra trạng thái is_active --}}
                    @if(!$user->is_active)
                        <span class="badge bg-danger ms-2">Đã khóa</span>
                    @else
                        <span class="badge bg-success ms-2">Đang hoạt động</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="card-body p-4 p-md-5">

            {{-- FORM UPDATE --}}
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Cột Trái --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Họ và Tên</label>
                        <input type="text" name="name" class="form-control form-control-modern" 
                               value="{{ old('name', $user->name) }}" required>
                    </div>

                    {{-- Cột Phải --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Địa chỉ Email</label>
                        <input type="email" name="email" class="form-control form-control-modern" 
                               value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                {{-- Mật khẩu (Không bắt buộc) --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Mật khẩu mới (Để trống nếu không đổi)</label>
                        <input type="password" name="password" class="form-control form-control-modern">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Xác nhận mật khẩu</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-modern">
                    </div>
                </div>

                <div class="mb-4">
                    <div class="checkbox-wrapper">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_admin" value="1" id="isAdminCheck" 
                                   {{ $user->is_admin ? 'checked' : '' }}>
                            <label class="form-check-label" for="isAdminCheck">
                                Cấp quyền Quản trị viên (Admin)
                            </label>
                        </div>
                    </div>
                </div>

                <hr class="my-4" style="opacity: 0.1;">

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light-custom btn-rounded">
                        <i class="fas fa-arrow-left me-2"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-gradient-warning btn-rounded px-5">
                        <i class="fas fa-save me-2"></i> Cập nhật
                    </button>
                </div>
            </form>

            {{-- KHU VỰC KHÓA / MỞ KHÓA --}}
            @if(Auth::id() !== $user->id)
                <hr class="my-4">

                <div class="d-flex justify-content-end">
                    
                    {{-- SỬA 2: Logic Khóa / Mở khóa dựa trên is_active --}}
                    @if($user->is_active)
                        {{-- Nút KHÓA --}}
                        <form action="{{ route('admin.users.lock', $user) }}" method="POST">
                            @csrf
                            {{-- Lưu ý: Không dùng @method('DELETE') ở đây nữa --}}
                            <button class="btn btn-outline-danger btn-rounded"
                                    onclick="return confirm('Bạn có chắc muốn khóa tài khoản {{ $user->name }} không?')">
                                <i class="fas fa-lock me-2"></i> Khóa tài khoản
                            </button>
                        </form>
                    @else
                        {{-- Nút MỞ KHÓA --}}
                        <form action="{{ route('admin.users.unlock', $user) }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-success btn-rounded">
                                <i class="fas fa-unlock me-2"></i> Mở khóa tài khoản
                            </button>
                        </form>
                    @endif

                </div>
            @endif

        </div>
    </div>
</div>
@endsection