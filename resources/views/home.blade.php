@extends('layouts.app') {{-- Sử dụng layout chung --}}

@section('content')
<div class="container py-5">
    <div class="mb-5">
        <div class="bg-primary text-white p-5 rounded text-center shadow-lg" 
             style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1500835595353-b0ad2427a191?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'); background-size: cover; background-position: center;">
            <h1 class="display-4 fw-bold">Khám Phá Hành Trình Mới</h1>
            <p class="lead">Hệ thống đặt vé du lịch trực tuyến nhanh chóng và uy tín</p>
        </div>
    </div>

    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h2 class="mb-0">Tour Du Lịch Bán Chạy</h2>
            <span class="text-muted">Khám phá các điểm đến hấp dẫn nhất</span>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($featuredProducts as $product)
            <div class="col">
                <div class="card h-100 d-flex flex-column shadow-sm border-0">
                    <a href="{{ route('products.show', $product['id']) }}" class="position-relative">
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="card-img-top" style="height:200px; object-fit:cover; border-radius: 8px 8px 0 0;">
                        {{-- Nhãn giá đè lên ảnh cho chuyên nghiệp --}}
                        <div class="position-absolute bottom-0 start-0 m-2">
                            <span class="badge bg-warning text-dark shadow-sm">Hot Deal</span>
                        </div>
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold" style="font-size: 1.1rem;">{{ $product->name }}</h5>
                        {{-- Đổi VNĐ thành Giá/Khách --}}
                        <p class="card-text text-danger fw-bold fs-5 mb-3">
                            {{ number_format($product->price) }} VNĐ
                            <small class="text-muted fw-normal" style="font-size: 0.75rem;">/ khách</small>
                        </p>
                        <a href="{{ route('products.show', $product['id']) }}" class="btn btn-primary mt-auto">Xem lịch trình</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <section class="mb-5">
        <h2 class="mb-4">Chia Sẻ Từ Khách Hàng</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($recentFeedbacks as $feedback)
            <div class="col">
                <div class="card h-100 border-0 bg-light shadow-sm">
                    <div class="card-body">
                        <div class="mb-2 text-warning">
                            <i class="bi bi-chat-quote-fill fs-3"></i>
                        </div>
                        <p class="card-text fst-italic">"{{ $feedback->message }}"</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end">
                        <small class="fw-bold text-primary">
                            {{ $feedback->user->name }}
                        </small>
                        <br>
                        <small class="text-muted" style="font-size: 0.7rem;">
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