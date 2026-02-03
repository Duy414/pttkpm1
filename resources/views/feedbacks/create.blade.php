@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Gửi phản hồi</h5>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('feedback.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="message" class="form-label">Nội dung phản hồi</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                id="message" 
                                name="message" 
                                rows="5" 
                                placeholder="Chia sẻ ý kiến của bạn với chúng tôi..."
                                required>{{ old('message') }}</textarea>
                            
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Gửi phản hồi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection