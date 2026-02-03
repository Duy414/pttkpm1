@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Danh sách sản phẩm</h1>
    <form action="{{ route('products.index') }}" method="GET" class="mb-4">
        <div class="row g-2 align-items-end">
            <!-- Ô tìm kiếm -->
            <div class="col-md-4">
                <label for="search" class="form-label fw-bold">Tìm kiếm</label>
                <input type="text" 
                    name="search" 
                    id="search"
                    class="form-control" 
                    placeholder="Nhập tên sản phẩm..." 
                    value="{{ request('search') }}">
            </div>

            
            <!-- Lọc theo giá -->
            <div class="col-md-4">
                <label for="price_range" class="form-label fw-bold">Khoảng giá</label>
                <select name="price_range" id="price_range" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="1" {{ request('price_range') == '1' ? 'selected' : '' }}>Dưới 5.000.000đ</option>
                    <option value="2" {{ request('price_range') == '2' ? 'selected' : '' }}>5.000.000đ - 10.000.000đ</option>
                    <option value="3" {{ request('price_range') == '3' ? 'selected' : '' }}>Trên 10.000.000đ</option>
                </select>
            </div>

            <!-- Lọc theo tình trạng -->
            <div class="col-md-4">
                <label for="stock" class="form-label fw-bold">Tình trạng</label>
                <select name="stock" id="stock" class="form-select">
                    <option value="">Tất cả</option>
                    <option value="in" {{ request('stock') == 'in' ? 'selected' : '' }}>Còn hàng</option>
                    <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Hết hàng</option>
                </select>
            </div>

            <!-- Nút tìm -->
            <div class="col-md-12 mt-2 text-end">
                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Lọc</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Làm mới</a>
            </div>
        </div>
    </form>

    
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($products as $product)
        <div class="col">
            <div class="card h-100 shadow-sm d-flex flex-column">
                @if($product->image)
                    <a href="{{ route('products.show', $product['id']) }}">
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" class="card-img-top" style="height:200px; object-fit:cover;">
                    </a>
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <span class="text-muted">Không có ảnh</span>
                    </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-success fw-bold">{{ number_format($product->price) }} VNĐ</p>
                    <p class="card-text mb-2">
                        @if($product->stock > 0)
                            <span class="badge bg-success">Còn hàng ({{ $product->stock }})</span>
                        @else
                            <span class="badge bg-danger">Hết hàng</span>
                        @endif
                    </p>
                    <p class="card-text text-truncate">{{ $product->description }}</p>
                    <a href="{{ route('products.show', $product['id']) }}" class="btn btn-primary mt-auto">Xem chi tiết</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
