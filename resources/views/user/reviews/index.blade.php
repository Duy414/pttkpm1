@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            @include('user.partials.sidebar')
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-star"></i> Đánh giá của tôi
                    </h4>
                </div>
                
                <div class="card-body">
                    @if($reviews->isEmpty())
                        <div class="alert alert-info">
                            Bạn chưa có đánh giá nào.
                            <a href="{{ route('products.index') }}" class="text-primary">
                                Khám phá sản phẩm ngay
                            </a>
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($reviews as $review)
                                @include('user.reviews._review_item', ['review' => $review])
                            @endforeach
                        </div>
                        
                        <div class="mt-4">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection