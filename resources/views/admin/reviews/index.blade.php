@extends('layouts.admin')

@section('content')

{{-- CSS Custom cho trang Đánh giá --}}
<style>
    /* Card Styles */
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        background: #fff;
        overflow: hidden;
    }

    /* Table Styles */
    .table-modern thead th {
        background-color: #f8f9fc;
        color: #858796;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e3e6f0;
        padding: 16px;
        white-space: nowrap;
    }

    .table-modern tbody td {
        vertical-align: middle;
        padding: 16px;
        border-top: 1px solid #f0f1f5;
        color: #5a5c69;
    }

    .table-modern tbody tr {
        transition: all 0.2s;
    }
    
    .table-modern tbody tr:hover {
        background-color: #fafbfc;
        transform: scale(1.002);
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        z-index: 10;
        position: relative;
    }

    /* Row Hidden Style Override */
    .table-secondary {
        background-color: #f1f3f9 !important;
        opacity: 0.8;
    }
    .table-secondary td {
        color: #858796 !important;
    }

    /* Rating Stars */
    .text-star {
        color: #f6c23e;
        font-weight: 700;
        letter-spacing: 2px;
    }

    /* Badge Styles */
    .badge-soft {
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
    }
    .bg-soft-success { background-color: rgba(28, 200, 138, 0.1); color: #1cc88a; }
    .bg-soft-danger { background-color: rgba(231, 74, 59, 0.1); color: #e74a3b; }

    /* Button Styles */
    .btn-rounded {
        border-radius: 50px;
        padding: 6px 16px;
        font-size: 0.8rem;
        font-weight: 600;
        transition: all 0.2s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .btn-rounded:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            <i class="bi bi-star-half text-warning me-2"></i>Quản lý đánh giá
        </h1>
    </div>

    {{-- Card Table --}}
    <div class="card card-modern mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Người dùng</th>
                            <th>Sản phẩm</th>
                            <th class="text-center">Sao</th>
                            <th width="30%">Bình luận</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($reviews as $i => $review)
                        <tr class="{{ $review->is_hidden ? 'table-secondary' : '' }}">
                            <td class="text-center fw-bold text-muted">{{ $i + 1 }}</td>
                            
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <span class="fw-bold text-dark">{{ $review->user->name }}</span>
                                </div>
                            </td>
                            
                            <td>
                                <span class="text-primary fw-bold">{{ $review->product->name }}</span>
                            </td>
                            
                            <td class="text-center">
                                <span class="text-star">{{ $review->rating }} <i class="bi bi-star-fill small"></i></span>
                            </td>
                            
                            <td>
                                <div class="text-muted small fst-italic">"{{ Str::limit($review->comment, 80) }}"</div>
                            </td>

                            <td class="text-center">
                                @if($review->is_hidden)
                                    <span class="badge badge-soft bg-soft-danger">
                                        <i class="bi bi-eye-slash-fill me-1"></i>Đã ẩn
                                    </span>
                                @else
                                    <span class="badge badge-soft bg-soft-success">
                                        <i class="bi bi-eye-fill me-1"></i>Hiển thị
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">
                                <form method="POST" action="{{ route('admin.reviews.toggle', $review) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button class="btn btn-rounded {{ $review->is_hidden ? 'btn-success' : 'btn-warning text-white' }}">
                                        @if($review->is_hidden)
                                            <i class="bi bi-eye me-1"></i>Hiện
                                        @else
                                            <i class="bi bi-eye-slash me-1"></i>Ẩn
                                        @endif
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination Wrapper --}}
            @if($reviews->hasPages())
                <div class="d-flex justify-content-center py-4 bg-light border-top">
                    {{ $reviews->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection