@extends('layouts.admin')

@section('content')

{{-- CSS Custom cho trang Phản hồi --}}
<style>
    /* Card Container */
    .feedback-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    /* Table Styling */
    .table-modern thead th {
        background-color: #f8f9fc;
        color: #858796;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #eaecf4;
        padding: 16px;
        white-space: nowrap;
    }

    .table-modern tbody td {
        vertical-align: middle;
        padding: 16px;
        color: #5a5c69;
        border-top: 1px solid #eaecf4;
    }

    .table-modern tbody tr {
        transition: all 0.2s;
    }

    .table-modern tbody tr:hover {
        background-color: #fdfdfe;
        transform: scale(1.005);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        z-index: 5;
        position: relative;
    }

    /* ID Badge */
    .id-badge {
        background-color: #eaecf4;
        color: #4e73df;
        font-weight: 800;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
    }

    /* User Name */
    .user-name {
        font-weight: 700;
        color: #4e73df;
    }

    /* Message Preview */
    .message-preview {
        font-style: italic;
        color: #858796;
        background: #f8f9fc;
        padding: 8px 12px;
        border-radius: 6px;
        border-left: 3px solid #4e73df;
    }

    /* Action Buttons */
    .btn-action {
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 6px 16px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
</style>

<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-2">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            <i class="fas fa-comments text-primary mr-2"></i>Quản lý Phản hồi
        </h1>
    </div>

    {{-- Main Card --}}
    <div class="card feedback-card mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" width="80">ID</th>
                            <th width="200">Người gửi</th>
                            <th>Nội dung</th>
                            <th width="180">Ngày gửi</th>
                            <th width="220" class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($feedbacks as $feedback)
                        <tr>
                            <td class="text-center">
                                <span class="id-badge">#{{ $feedback->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle mr-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 0.9rem;">
                                        {{ substr($feedback->user->name, 0, 1) }}
                                    </div>
                                    <span class="user-name">{{ $feedback->user->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="message-preview">
                                    "{{ Str::limit($feedback->message, 80) }}"
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center text-secondary small font-weight-bold">
                                    <i class="far fa-clock mr-2"></i>
                                    {{ $feedback->created_at->format('d/m/Y H:i') }}
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.feedbacks.show', $feedback->id) }}" class="btn btn-sm btn-info btn-action mr-1" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>
                                <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-action" title="Xóa" onclick="return confirm('Bạn chắc chắn muốn xóa phản hồi này?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            @if($feedbacks->hasPages())
            <div class="d-flex justify-content-center py-4 bg-light border-top">
                {{ $feedbacks->links('pagination::bootstrap-4') }}
            </div>
            @endif

        </div>
    </div>
</div>
@endsection