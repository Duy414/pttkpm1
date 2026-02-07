@extends('layouts.admin')

@section('content')

{{-- CSS Custom cho trang Quản lý Tour --}}
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

    /* Image Thumbnail */
    .img-thumb-custom {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .img-thumb-custom:hover {
        transform: scale(1.1);
    }
    
    .no-img-placeholder {
        width: 80px;
        height: 60px;
        background-color: #f1f3f9;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b7b9cc;
        font-size: 1.2rem;
    }

    /* Badges */
    .badge-soft {
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
    }
    .bg-soft-success { background-color: rgba(28, 200, 138, 0.1); color: #1cc88a; }
    .bg-soft-danger { background-color: rgba(231, 74, 59, 0.1); color: #e74a3b; }

    /* ID Badge */
    .id-badge {
        font-family: 'Courier New', monospace;
        background: #f1f3f9;
        padding: 4px 8px;
        border-radius: 6px;
        color: #4e73df;
        font-weight: 700;
        font-size: 0.85rem;
    }

    /* Action Buttons */
    .btn-action-group .btn {
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
    }
    .btn-action-group .btn:hover {
        transform: translateY(-2px);
    }
    
    /* Header Button */
    .btn-add-new {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        box-shadow: 0 4px 10px rgba(78, 115, 223, 0.3);
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-add-new:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(78, 115, 223, 0.4);
        color: #fff;
    }
</style>

<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            <i class="fas fa-map-marked-alt text-primary mr-2"></i>Quản lý Tour & Dịch vụ
        </h1>
        <a href="{{ route('admin.products.create') }}" class="d-none d-sm-inline-block btn btn-primary btn-add-new text-white">
            <i class="fas fa-plus fa-sm mr-2"></i> Thêm Tour mới
        </a>
    </div>

    <div class="card card-modern mb-4">
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-4 shadow-sm" role="alert" style="border-radius: 10px;">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-modern mb-0" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" width="80">ID</th>
                            <th width="120">Hình ảnh</th>
                            <th>Tên Tour / Dịch vụ</th>
                            <th width="150">Giá vé</th>
                            <th width="150">Số chỗ trống</th>
                            <th width="150">Ngày đăng</th>
                            <th class="text-center" width="180">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td class="text-center">
                                <span class="id-badge">#{{ $product['id'] }}</span>
                            </td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumb-custom">
                                @else
                                    <div class="no-img-placeholder">
                                        <i class="fas fa-plane"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $product->name }}</div>
                            </td>
                            <td>
                                <span class="text-primary font-weight-bold">{{ number_format($product->price) }} ₫</span>
                            </td>
                            <td>
                                @if($product->stock <= 5)
                                    <span class="badge badge-soft bg-soft-danger">
                                        <i class="fas fa-fire mr-1"></i>Chỉ còn {{ $product->stock }} chỗ
                                    </span>
                                @else
                                    <span class="badge badge-soft bg-soft-success">
                                        <i class="fas fa-check-circle mr-1"></i>{{ $product->stock }} chỗ trống
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                <i class="far fa-calendar-alt mr-1"></i> {{ $product->created_at->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-action-group" role="group">
                                    <a href="{{ route('admin.products.edit', $product['id']) }}" class="btn btn-outline-primary shadow-sm" title="Sửa thông tin">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product['id']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger shadow-sm ml-2" title="Xóa Tour" onclick="return confirm('Bạn chắc chắn muốn xóa tour này khỏi hệ thống?')">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination Wrapper --}}
            @if($products->hasPages())
                <div class="d-flex justify-content-center py-4 bg-light border-top">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection