@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chi tiết Phản hồi #{{ $feedback->id }}</h1>
        <a href="{{ route('admin.feedbacks.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm"></i> Quay lại
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin phản hồi</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h5 class="text-primary">Thông tin người gửi</h5>
                        <p><strong>Tên:</strong> {{ $feedback->user->name }}</p>
                        <p><strong>Email:</strong> {{ $feedback->user->email }}</p>
                        <p><strong>Ngày gửi:</strong> {{ $feedback->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <h5 class="text-primary">Nội dung phản hồi</h5>
                    <div class="border p-4 rounded bg-light">
                        {{ $feedback->message }}
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa phản hồi này?')">
                        <i class="fas fa-trash"></i> Xóa phản hồi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection