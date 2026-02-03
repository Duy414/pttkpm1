@extends('layouts.app') {{-- Sử dụng layout chung --}}

@section('content')
<div class="container py-5">
    <!-- Banner/Slider -->
    <div class="mb-5">
        <div class="bg-dark text-white p-5 rounded text-center">
            <h1>Chào mừng đến với cửa hàng</h1>
            <p class="lead">Khám phá các sản phẩm mới nhất với giá tốt nhất</p>
        </div>
    </div>

    <!-- Sản phẩm nổi bật -->
    <section class="mb-5">
        <h2 class="mb-4">Sản Phẩm Nổi Bật</h2>
        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-danger fw-bold">{{ number_format($product->price) }} VNĐ</p>
                        <a href="#" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Phản hồi khách hàng -->
    <section class="mb-5">
        <h2 class="mb-4">Khách Hàng Nói Gì</h2>
        <div class="row">
            @foreach($recentFeedbacks as $feedback)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <p class="card-text">"{{ $feedback->message }}"</p>
                    </div>
                    <div class="card-footer bg-light">
                        <small class="text-muted">
                            {{ $feedback->user->name }} - 
                            {{ $feedback->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection