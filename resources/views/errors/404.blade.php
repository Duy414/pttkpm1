@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="alert alert-danger text-center">
        <h1><i class="fas fa-ban"></i> 403 Forbidden</h1>
        <p class="lead">Bạn không có quyền truy cập trang này</p>
        <button onclick="window.history.back()" class="btn btn-primary mt-3">
            <i class="fas fa-arrow-left"></i> Quay lại
        </button>
    </div>
</div>
@endsection