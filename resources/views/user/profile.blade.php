@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card mb-4"> <div class="card-header">Chỉnh sửa hồ sơ</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Tên hiển thị</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Địa chỉ Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Cập nhật hồ sơ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <i class="fas fa-key"></i> Đổi mật khẩu
                </div>

                <div class="card-body">
                    {{-- Hiển thị thông báo thành công riêng cho phần password --}}
                    @if (session('password_success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('password_success') }}
                        </div>
                    @endif
                    
                    {{-- Hiển thị lỗi chung nếu có --}}
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Bạn cần tạo Route tên là user.password.update --}}
                    <form method="POST" action="{{ route('user.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-3">
                            <label for="current_password" class="col-md-4 col-form-label text-md-right">Mật khẩu hiện tại</label>
                            <div class="col-md-6">
                                <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="new_password" class="col-md-4 col-form-label text-md-right">Mật khẩu mới</label>
                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required>
                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-right">Xác nhận mật khẩu mới</label>
                            <div class="col-md-6">
                                <input id="new_password_confirmation" type="password" class="form-control" name="new_password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-warning">
                                    Lưu mật khẩu mới
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-4"> <div class="card-header">Xóa tài khoản</div>

                <form action="{{ route('admin.users.destroy', $user) }}"
                    method="POST"
                    onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger btn-sm">
                        Xóa
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection