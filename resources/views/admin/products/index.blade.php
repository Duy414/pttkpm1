@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý Tour & Dịch vụ</h1>
        <a href="{{ route('admin.products.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Thêm Tour mới
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Tên Tour/Dịch vụ</th>
                            <th>Giá vé</th>
                            <th>Số chỗ trống</th>
                            <th>Ngày đăng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product['id'] }}</td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="80" class="img-thumbnail shadow-sm">
                                @else
                                    <div class="bg-light text-muted p-2" style="width:80px;height:60px;display:flex;align-items:center;justify-content:center;border-radius:5px;">
                                        <i class="fas fa-plane"></i>
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $product->name }}</strong></td>
                            <td class="text-primary font-weight-bold">{{ number_format($product->price) }} ₫</td>
                            <td>
                                @if($product->stock <= 5)
                                    <span class="text-danger fw-bold">
                                        <i class="bi bi-exclamation-circle me-1"></i>Chỉ còn {{ $product->stock }} chỗ
                                    </span>
                                @else
                                    <span class="text-primary fw-bold">
                                        <i class="bi bi-people-fill me-1"></i>{{ $product->stock }} chỗ trống
                                    </span>
                                @endif
                            </td>
                            <td>{{ $product->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.products.edit', $product['id']) }}" class="btn btn-sm btn-outline-primary" title="Sửa thông tin">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product['id']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa Tour" onclick="return confirm('Bạn chắc chắn muốn xóa tour này khỏi hệ thống?')">
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
            
           <div class="d-flex justify-content-center mt-4">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection