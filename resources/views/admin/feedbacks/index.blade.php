@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý Phản hồi</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Người gửi</th>
                            <th>Nội dung</th>
                            <th>Ngày gửi</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($feedbacks as $feedback)
                        <tr>
                            <td>{{ $feedback->id }}</td>
                            <td>{{ $feedback->user->name }}</td>
                            <td>{{ Str::limit($feedback->message, 80) }}</td>
                            <td>{{ $feedback->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.feedbacks.show', $feedback->id) }}" class="btn btn-sm btn-info" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>xem chi tiết
                                </a>
                                <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Xóa" onclick="return confirm('Bạn chắc chắn muốn xóa phản hồi này?')">
                                        <i class="fas fa-trash"></i>xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $feedbacks->links('pagination::simple-bootstrap-4') }}
            </div>

        </div>
    </div>
</div>
@endsection
