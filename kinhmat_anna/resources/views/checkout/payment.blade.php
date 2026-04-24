@extends('layouts.app')

@section('content')
<style>
    body { background-color: #f4f6f8; }
    .payment-box { background: #fff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); padding: 40px; border: 1px solid #eee; margin-top: 50px; margin-bottom: 50px;}
    .qr-container { background: #fff; padding: 15px; border-radius: 16px; border: 2px dashed #3cb3b0; display: inline-block; }
    .info-row { display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px dashed #eee; align-items: center;}
    .info-row:last-child { border-bottom: none; }
    .btn-copy { background: #f0f0f0; border: none; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; color: #555; transition: 0.2s; }
    .btn-copy:hover { background: #3cb3b0; color: #fff; }
    .btn-finish { background: #3cb3b0; color: #fff; border: none; border-radius: 50px; padding: 15px 40px; font-weight: 700; text-transform: uppercase; transition: 0.3s; width: 100%; letter-spacing: 1px;}
    .btn-finish:hover { background: #2c8c89; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(60, 179, 176, 0.2); color: #fff;}
    
    .pulsing-dot { width: 10px; height: 10px; background-color: #ffc107; border-radius: 50%; display: inline-block; animation: pulse 1.5s infinite; }
    @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7); } 70% { box-shadow: 0 0 0 10px rgba(255, 193, 7, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); } }
</style>

@php
    $realTotal = 0;
    if(isset($order->orderDetails)) {
        foreach($order->orderDetails as $item) {
            $realTotal += ($item->price * $item->quantity);
        }
    }
    if($realTotal == 0) {
        $realTotal = $order->total_amount ?? $order->total_price ?? $order->total ?? 0;
    }
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="payment-box">
                <div class="text-center mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 50px;"></i>
                    <h3 class="fw-bold mt-3 text-dark">Đặt hàng thành công!</h3>
                    <p class="text-muted">Vui lòng thanh toán để Anna chuẩn bị hàng cho bạn nhé.</p>
                </div>

                <div class="row g-4 align-items-center mt-2">
                    <div class="col-md-5 text-center border-end">
                        <h6 class="fw-bold mb-3 text-uppercase text-secondary" style="font-size: 13px;">Quét mã qua App Ngân hàng</h6>
                        <div class="qr-container shadow-sm mb-3">
                            <img src="https://img.vietqr.io/image/MB-01888831012004-compact2.jpg?amount={{ $realTotal }}&addInfo=ANNA{{ $order->id }}&accountName=NGUYEN QUOC KHANH" alt="QR Code" class="img-fluid" style="max-width: 200px;">
                        </div>
                        <div class="d-flex align-items-center justify-content-center text-warning fw-bold small">
                            <span class="pulsing-dot me-2"></span> Đang chờ thanh toán...
                        </div>
                    </div>

                    <div class="col-md-7 ps-md-4">
                        <h5 class="fw-bold mb-4" style="color: #3cb3b0;">Thông tin chuyển khoản</h5>
                        
                        <div class="info-row pt-0">
                            <span class="text-muted small">Ngân hàng</span>
                            <span class="fw-bold text-dark">MB Bank</span>
                        </div>
                        <div class="info-row">
                            <span class="text-muted small">Chủ tài khoản</span>
                            <span class="fw-bold text-dark">NGUYEN QUOC KHANH</span>
                        </div>
                        <div class="info-row">
                            <span class="text-muted small">Số tài khoản</span>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold fs-5" id="stk">01888831012004</span>
                                <button class="btn-copy" onclick="copyText('stk')"><i class="bi bi-copy"></i> Copy</button>
                            </div>
                        </div>
                        <div class="info-row">
                            <span class="text-muted small">Số tiền</span>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold text-danger fs-5">{{ number_format($realTotal, 0, '.', ',') }} VNĐ</span>
                                <span id="amount-raw" class="d-none">{{ $realTotal }}</span>
                                <button class="btn-copy" onclick="copyText('amount-raw')"><i class="bi bi-copy"></i> Copy</button>
                            </div>
                        </div>
                        <div class="info-row pb-0">
                            <span class="text-muted small">Nội dung (Bắt buộc)</span>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold text-primary fs-5" id="content">Thanh toan Kinh Mat ANNA{{ $order->id }}</span>
                                <button class="btn-copy" onclick="copyText('content')"><i class="bi bi-copy"></i> Copy</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning mt-4 border-0 rounded-3 small fw-medium" style="background-color: #fff8e1; color: #b78103;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Lưu ý: Vui lòng nhập chính xác <b>Nội dung chuyển khoản</b> để hệ thống duyệt đơn tự động.
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('profile.index') }}#orders-tab" class="btn btn-finish">Tôi đã thanh toán / Theo dõi đơn hàng</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyText(elementId) {
        var text = document.getElementById(elementId).innerText;
        navigator.clipboard.writeText(text).then(function() {
            Swal.fire({
                toast: true, position: 'top-end', icon: 'success',
                title: 'Đã copy thành công!', showConfirmButton: false, timer: 2000,
                background: '#3cb3b0', color: '#fff'
            });
        });
    }
</script>
@endsection