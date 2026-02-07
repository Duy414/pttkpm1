@extends('layouts.admin')

@section('content')

{{-- CSS Custom cho trang Chi tiết --}}
<style>
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .avatar-circle {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 15px;
        box-shadow: 0 4px 10px rgba(78, 115, 223, 0.3);
    }

    .info-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #858796;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 1rem;
        color: #3a3b45;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .message-box {
        background-color: #f8f9fc;
        border-radius: 12px;
        padding: 30px;
        border-left: 5px solid #4e73df;
        color: #5a5c69;
        line-height: 1.8;
        font-size: 1.05rem;
        position: relative;
    }

    .btn-rounded {
        border-radius: 50px;
        padding: 8px 24px;
        font-weight: 600;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    .btn-rounded:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
</style>

<div class="container-fluid">
    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            <span class="text-primary">#{{ $feedback->id }}</span> Chi tiết Phản hồi
        </h1>
        <a href="{{ route('admin.feedbacks.index') }}" class="btn btn-secondary btn-rounded">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại
        </a>
    </div>

    <div class="row">
        {{-- Cột Trái: Thông tin người gửi --}}
        <div class="col-lg-4 mb-4">
            <div class="card card-modern h-100">
                <div class="card-header py-3 bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin người gửi</h6>
                </div>
                <div class="card-body text-center pt-0">
                    <div class="d-flex flex-column align-items-center mb-4">
                        {{-- Avatar giả lập --}}
                        <div class="avatar-circle">
                            <i class="fas fa-user"></i>
                        </div>
                        <h4 class="font-weight-bold text-dark">{{ $feedback->user->name }}</h4>
                        <div class="badge badge-primary px-3 py-2 rounded-pill mt-2">Khách hàng</div>
                    </div>

                    <div class="text-left px-3">
                        <div class="mb-3">
                            <div class="info-label"><i class="fas fa-envelope mr-2"></i>Email</div>
                            <div class="info-value">{{ $feedback->user->email }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="info-label"><i class="far fa-clock mr-2"></i>Ngày gửi</div>
                            <div class="info-value">{{ $feedback->created_at->format('d/m/Y') }} <small class="text-muted ml-1">{{ $feedback->created_at->format('H:i') }}</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Cột Phải: Nội dung & Hành động --}}
        <div class="col-lg-8 mb-4">
            <div class="card card-modern h-100">
                <div class="card-header py-3 bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-primary">Nội dung phản hồi</h6>
                </div>
                <div class="card-body">
                    <div class="message-box mb-4">
                        <i class="fas fa-quote-left text-gray-300 fa-2x mb-3 d-block"></i>
                        {{ $feedback->message }}
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end align-items-center">
                        <div class="text-muted small mr-3">Hành động:</div>
                        <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-rounded" onclick="return confirm('Bạn chắc chắn muốn xóa phản hồi này?')">
                                <i class="fas fa-trash mr-2"></i> Xóa phản hồi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection