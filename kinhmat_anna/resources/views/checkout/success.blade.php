@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <div class="bg-white p-5 rounded-4 shadow-sm border">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 80px;"></i>
                <h2 class="fw-bold mt-4 mb-3">Đặt Hàng Thành Công!</h2>
                <p class="text-secondary mb-4">Cảm ơn bạn đã tin tưởng và mua sắm tại Kính Mắt Anna. Đơn hàng của bạn đang được xử lý và sẽ được giao trong thời gian sớm nhất.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('home') }}" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold">Về Trang Chủ</a>
                    <a href="{{ route('products.index') }}" class="btn btn-dark rounded-pill px-4 py-2 fw-bold">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection