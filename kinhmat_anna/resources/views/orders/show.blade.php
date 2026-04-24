@extends('layouts.app')

@section('content')
<style>
    /* CSS TRANG CHI TIẾT ĐƠN HÀNG */
    .order-container { max-width: 800px; margin: 0 auto; min-height: 60vh;}
    .order-header { background-color: #1a1a1a; color: #fff; border-radius: 16px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);}
    
    .info-card { background: #fff; border-radius: 16px; border: 1px solid #eee; padding: 30px; margin-bottom: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.02);}
    .section-title { font-weight: 800; text-transform: uppercase; font-size: 16px; letter-spacing: 1px; border-bottom: 2px solid #f5f5f5; padding-bottom: 15px; margin-bottom: 20px; color: #111;}
    
    /* HIỆU ỨNG NÚT THANH TOÁN NHẤP NHÁY */
    .btn-pay-now { background-color: #3cb3b0; color: #fff; border: none; border-radius: 50px; padding: 10px 25px; font-weight: bold; transition: 0.3s; animation: pulse-btn 2s infinite; }
    .btn-pay-now:hover { background-color: #2c8c89; transform: translateY(-2px); color: #fff;}
    @keyframes pulse-btn { 
        0% { box-shadow: 0 0 0 0 rgba(60, 179, 176, 0.5); } 
        70% { box-shadow: 0 0 0 12px rgba(60, 179, 176, 0); } 
        100% { box-shadow: 0 0 0 0 rgba(60, 179, 176, 0); } 
    }
    
    /* MODAL QR CODE */
    .qr-container { border: 2px dashed #3cb3b0; border-radius: 12px; padding: 15px; background: #fff; display: inline-block;}
    .btn-copy { background: #f0f0f0; border: none; padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; color: #555; transition: 0.2s; }
    .btn-copy:hover { background: #3cb3b0; color: #fff; }
</style>

@php
    $finalTotal = 0;
    
    // 1. Cố gắng lấy tổng tiền trực tiếp từ đơn hàng
    $rawTotal = $order->total_amount ?? $order->total_price ?? $order->total ?? 0;
    $finalTotal = (int) preg_replace('/[^0-9]/', '', (string) $rawTotal);

    // 2. Dự phòng: Nếu tổng tiền bị lỗi bằng 0, tự động lôi từng sản phẩm ra nhân lên
    if ($finalTotal === 0 && isset($order->orderDetails)) {
        foreach($order->orderDetails as $item) {
            // Quét giá ở bảng chi tiết HOẶC bảng sản phẩm gốc
            $itemPrice = $item->price ?? $item->product->price ?? 0;
            $cleanPrice = (int) preg_replace('/[^0-9]/', '', (string) $itemPrice);
            $finalTotal += ($cleanPrice * (int) $item->quantity);
        }
    }
@endphp

<div class="container py-5 order-container">
    <div class="mb-4">
        <a href="{{ route('profile.index') }}#orders-tab" class="text-dark text-decoration-none fw-bold hover-danger" style="transition: 0.2s;">
            <i class="bi bi-arrow-left me-2"></i> Quay lại lịch sử đơn hàng
        </a>
    </div>

    <div class="order-header d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Chi tiết đơn hàng #{{ $order->order_number ?? $order->id }}</h4>
            <p class="text-muted small mb-0" style="opacity: 0.8;">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <div class="mt-3 mt-md-0 text-md-end">
            <span class="badge bg-white text-dark px-3 py-2 rounded-pill fs-6 shadow-sm border d-inline-block">
                @if($order->status == 'pending')
                    <i class="bi bi-clock-history text-warning me-1"></i> Chờ xác nhận
                @elseif($order->status == 'pending_payment')
                    <i class="bi bi-hourglass-split text-danger me-1"></i> Chờ thanh toán
                @elseif($order->status == 'processing')
                    <i class="bi bi-box-seam text-info me-1"></i> Đã thanh toán - Đang chuẩn bị hàng
                @elseif($order->status == 'shipped')
                    <i class="bi bi-truck text-primary me-1"></i> Đang giao hàng
                @elseif($order->status == 'completed')
                    <i class="bi bi-check-circle-fill text-success me-1"></i> Hoàn thành
                @elseif($order->status == 'cancelled')
                    <i class="bi bi-x-circle text-danger me-1"></i> Đã hủy
                @else
                    {{ $order->status_name ?? $order->status }}
                @endif
            </span>
            
            @if($order->status == 'pending_payment')
                <div class="mt-3">
                    <button class="btn-pay-now" data-bs-toggle="modal" data-bs-target="#qrModal">
                        <i class="bi bi-qr-code-scan me-1"></i> THANH TOÁN NGAY
                    </button>
                </div>
            @elseif($order->status == 'processing')
                <div class="mt-3">
                    <span class="badge bg-success px-4 py-2 rounded-pill fs-6 shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i> ĐÃ THANH TOÁN
                    </span>
                </div>
            @endif
        </div>
    </div>

    <div class="info-card">
        <h5 class="section-title">Thông tin nhận hàng</h5>
        <div class="row mb-3">
            <div class="col-4 col-md-3 text-muted">Người nhận:</div>
            <div class="col-8 col-md-9 fw-bold">{{ $order->customer_name ?? $order->user->name ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-4 col-md-3 text-muted">Số điện thoại:</div>
            <div class="col-8 col-md-9 fw-bold">{{ $order->customer_phone ?? $order->phone ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-4 col-md-3 text-muted">Địa chỉ:</div>
            <div class="col-8 col-md-9 fw-bold">{{ $order->customer_address ?? $order->address ?? 'N/A' }}</div>
        </div>
        <div class="row">
            <div class="col-4 col-md-3 text-muted">Ghi chú:</div>
            <div class="col-8 col-md-9 {{ $order->notes ? 'fw-bold' : 'text-danger font-italic small' }}">
                {{ $order->notes ?? 'Không có ghi chú' }}
            </div>
        </div>
    </div>

    <div class="info-card">
        <h5 class="section-title">Sản phẩm đã đặt</h5>
        @foreach($order->orderDetails as $item)
            @php
                $cleanImg = trim($item->product->image ?? '');
                $imgSrc = str_starts_with($cleanImg, 'http') ? $cleanImg : asset('storage/' . $cleanImg);
                if(!$cleanImg) $imgSrc = 'https://placehold.co/100x100?text=No+Image';
                
                // Lọc giá trị của từng sản phẩm để hiển thị
                $itemSinglePrice = (int) preg_replace('/[^0-9]/', '', (string) ($item->price ?? $item->product->price ?? 0));
            @endphp
            <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                <div class="d-flex align-items-center">
                    <img src="{{ $imgSrc }}" class="rounded-3 border shadow-sm" style="width: 70px; height: 70px; object-fit: cover;">
                    <div class="ms-3">
                        <h6 class="fw-bold mb-1">{{ $item->product->name ?? 'Sản phẩm đã ngừng kinh doanh' }}</h6>
                        <span class="text-muted small">Đơn giá: {{ number_format($itemSinglePrice, 0, '.', ',') }} VNĐ</span>
                    </div>
                </div>
                <div class="text-end">
                    <div class="fw-bold fs-6">x{{ $item->quantity }}</div>
                    <div class="text-danger fw-bold mt-1">{{ number_format($itemSinglePrice * $item->quantity, 0, '.', ',') }} VNĐ</div>
                </div>
            </div>
        @endforeach
        
        <div class="d-flex justify-content-between align-items-center mt-4 pt-2">
            <span class="fw-bold fs-5">TỔNG CỘNG</span>
            <span class="fw-bold fs-3 text-danger">{{ number_format($finalTotal, 0, '.', ',') }} VNĐ</span>
        </div>
    </div>
</div>

@if($order->status == 'pending_payment')
<div class="modal fade" id="qrModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold fs-4 text-dark"><i class="bi bi-qr-code-scan text-primary me-2"></i>Thanh toán đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="qr-container shadow-sm mb-4">
                    <img src="https://img.vietqr.io/image/MB-01888831012004-compact2.jpg?amount={{ $finalTotal }}&addInfo=ANNA{{ $order->id }}&accountName=NGUYEN QUOC KHANH" alt="Mã QR Thanh Toán" class="img-fluid" style="max-width: 220px;">
                </div>
                
                <div class="bg-light p-3 rounded-4 text-start border">
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                        <span class="text-muted small">Chủ tài khoản:</span>
                        <span class="fw-bold">NGUYEN QUOC KHANH</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                        <span class="text-muted small">Số tài khoản (MB):</span>
                        <div>
                            <span class="fw-bold me-2" id="modal-stk">01888831012004</span>
                            <button class="btn-copy shadow-sm" onclick="copyText('modal-stk')"><i class="bi bi-copy"></i></button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                        <span class="text-muted small">Số tiền:</span>
                        <div>
                            <span class="fw-bold text-danger me-2">{{ number_format($finalTotal, 0, '.', ',') }} VNĐ</span>
                            
                            <span id="modal-amount-raw" class="d-none">{{ $finalTotal }}</span>
                            
                            <button class="btn-copy shadow-sm" onclick="copyText('modal-amount-raw')"><i class="bi bi-copy"></i></button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Nội dung chuyển:</span>
                        <div>
                            <span class="fw-bold text-primary me-2" id="modal-content">Thanh toan Kinh Mat ANNA{{ $order->id }}</span>
                            <button class="btn-copy shadow-sm" onclick="copyText('modal-content')"><i class="bi bi-copy"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 px-4 justify-content-center">
                <button type="button" class="btn btn-dark rounded-pill px-5 fw-bold" data-bs-dismiss="modal">Tôi đã thanh toán</button>
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
@endif
@endsection