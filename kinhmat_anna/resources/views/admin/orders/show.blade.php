@extends('layouts.admin')

@section('content')
<style>
    /* BẢNG MÀU PASTEL CHUYÊN NGHIỆP CHO ADMIN */
    .status-badge { padding: 8px 16px; border-radius: 50px; font-weight: 600; font-size: 14px; display: inline-block; width: 100%; text-align: center;}
    
    .status-pending { background-color: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6; } 
    .status-pending_payment { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; } 
    .status-processing { background-color: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; } 
    .status-shipped { background-color: #cce5ff; color: #004085; border: 1px solid #b8daff; } 
    .status-completed { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; } 
    .status-refund_pending { background-color: #fff3cd; color: #d39e00; border: 1px solid #ffeeba; border-left: 4px solid #ffc107; } 
    .status-refunded { background-color: #e2e3e5; color: #383d41; border: 1px solid #d6d8db; } 
    .status-cancelled { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; } 

    .info-label { color: #888; font-weight: 500; font-size: 14px; margin-bottom: 4px; display: block;}
    .info-value { color: #222; font-weight: 600; font-size: 15px;}
    .product-img-mini { width: 65px; height: 65px; object-fit: cover; border-radius: 10px; border: 1px solid #eee; }
    
    /* Làm đẹp Select box */
    .custom-select-box { border: 2px solid #eee; border-radius: 12px; padding: 12px 15px; font-weight: 600; color: #333; cursor: pointer; transition: 0.2s;}
    .custom-select-box:focus { border-color: #3cb3b0; box-shadow: 0 0 0 4px rgba(60, 179, 176, 0.1); }
</style>

<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('admin.orders.index') }}" class="text-dark text-decoration-none fw-bold hover-danger transition-200">
            <i class="bi bi-arrow-left me-2"></i> Quay lại danh sách
        </a>
    </div>

    @if($order->status == 'pending_payment')
        <div class="alert alert-warning border-warning shadow-sm rounded-4 mb-4 d-flex align-items-center">
            <i class="bi bi-hourglass-split fs-3 me-3 text-warning"></i>
            <div>
                <h6 class="fw-bold mb-1">Đơn hàng đang chờ thanh toán (Quét QR)</h6>
                <span class="small">Vui lòng kiểm tra biến động số dư trên App Ngân hàng trước khi chuyển trạng thái sang "Đang xử lý".</span>
            </div>
        </div>
    @endif

    @if($order->status == 'refund_pending')
        <div class="alert alert-danger border-danger shadow-sm rounded-4 mb-4 d-flex align-items-center">
            <i class="bi bi-exclamation-octagon-fill fs-3 me-3 text-danger"></i>
            <div>
                <h6 class="fw-bold mb-1">YÊU CẦU HOÀN TIỀN TỪ KHÁCH HÀNG</h6>
                <span class="small">Khách hàng đã yêu cầu hủy đơn đã thanh toán. Vui lòng hoàn tiền cho khách và cập nhật trạng thái thành "Đã hoàn tiền".</span>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Đơn hàng #{{ $order->order_number ?? $order->id }}</h3>
                <span class="text-muted small"><i class="bi bi-clock me-1"></i> {{ $order->created_at->format('H:i - d/m/Y') }}</span>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-lg-5">
                    <h5 class="fw-bold mb-4">Thông tin khách hàng</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <span class="info-label">Họ và tên</span>
                            <span class="info-value">{{ $order->customer_name ?? ($order->user->name ?? 'N/A') }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="info-label">Số điện thoại</span>
                            <span class="info-value">{{ $order->customer_phone ?? ($order->user->phone ?? 'N/A') }}</span>
                        </div>
                        <div class="col-md-6">
                            <span class="info-label">Phương thức thanh toán</span>
                            <span class="info-value text-primary text-uppercase">{{ $order->payment_method == 'bank' ? 'Chuyển khoản (QR)' : 'Tiền mặt (COD)' }}</span>
                        </div>
                        <div class="col-md-12">
                            <span class="info-label">Địa chỉ giao hàng</span>
                            <span class="info-value">{{ $order->customer_address ?? $order->address ?? 'N/A' }}</span>
                        </div>
                        @if(!empty($order->notes))
                        <div class="col-md-12 p-3 bg-light rounded-3 border mt-3">
                            <span class="info-label text-danger mb-1"><i class="bi bi-chat-quote-fill me-1"></i> Ghi chú của khách:</span>
                            <span class="info-value fst-italic">{{ $order->notes }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-lg-5">
                    <h5 class="fw-bold mb-4">Chi tiết sản phẩm</h5>
                    <div class="table-responsive">
                        <table class="table align-middle table-borderless">
                            <thead class="border-bottom">
                                <tr>
                                    <th class="text-muted small text-uppercase pb-3">Sản phẩm</th>
                                    <th class="text-center text-muted small text-uppercase pb-3">SL</th>
                                    <th class="text-end text-muted small text-uppercase pb-3">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $finalTotal = 0; @endphp
                                @foreach($order->orderDetails as $item)
                                @php
                                    $itemCleanPrice = (int) preg_replace('/[^0-9]/', '', (string) ($item->price ?? $item->product->price ?? 0));
                                    $finalTotal += ($itemCleanPrice * $item->quantity);
                                    
                                    $cleanImg = trim($item->product->image ?? '');
                                    $imgSrc = str_starts_with($cleanImg, 'http') ? $cleanImg : asset('storage/' . $cleanImg);
                                    if(!$cleanImg) $imgSrc = 'https://placehold.co/100';
                                @endphp
                                <tr class="border-bottom">
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $imgSrc }}" class="product-img-mini me-3 shadow-sm">
                                            <div>
                                                <div class="fw-bold text-dark fs-6">{{ $item->product->name ?? 'Sản phẩm đã xóa' }}</div>
                                                <small class="text-muted">{{ number_format($itemCleanPrice, 0, '.', ',') }}đ</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold py-3">x{{ $item->quantity }}</td>
                                    <td class="text-end fw-bold text-dark py-3">{{ number_format($itemCleanPrice * $item->quantity, 0, '.', ',') }}đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end fw-bold pt-4 fs-5 text-uppercase">Tổng thanh toán:</td>
                                    <td class="text-end fw-bold text-danger pt-4 fs-4">
                                        {{ number_format($finalTotal > 0 ? $finalTotal : (int)preg_replace('/[^0-9]/', '', (string)($order->total_amount ?? $order->total_price ?? 0)), 0, '.', ',') }} đ
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-1 shadow-sm rounded-4 p-4 sticky-top" style="top: 20px; border-color: #f0f0f0;">
                <h5 class="fw-bold mb-4 border-bottom pb-3"><i class="bi bi-sliders me-2 text-primary"></i>Tiến trình đơn hàng</h5>
                
                @php
                    // ĐÃ RÚT GỌN CHỮ CHO ĐỠ RỐI MẮT
                    $statusLabels = [
                        'pending'         => ['label' => 'Chờ xác nhận', 'class' => 'status-pending'],
                        'pending_payment' => ['label' => 'Chờ thanh toán', 'class' => 'status-pending_payment'],
                        'processing'      => ['label' => 'Đang xử lý', 'class' => 'status-processing'],
                        'shipped'         => ['label' => 'Đang giao hàng', 'class' => 'status-shipped'],
                        'completed'       => ['label' => 'Hoàn thành', 'class' => 'status-completed'],
                        'refund_pending'  => ['label' => 'Yêu cầu hoàn tiền', 'class' => 'status-refund_pending'],
                        'refunded'        => ['label' => 'Đã hoàn tiền', 'class' => 'status-refunded'],
                        'cancelled'       => ['label' => 'Đã hủy', 'class' => 'status-cancelled'],
                    ];
                    $current = $statusLabels[$order->status] ?? ['label' => $order->status, 'class' => 'status-pending'];
                    $isLocked = in_array($order->status, ['cancelled', 'refunded', 'completed']);
                @endphp
                
                <div class="mb-4 pb-4 border-bottom">
                    <span class="text-muted small fw-bold text-uppercase d-block mb-2">Đang ở trạng thái:</span>
                    <span class="status-badge {{ $current['class'] }}">{{ $current['label'] }}</span>
                </div>

                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-2">Chuyển sang:</label>
                        <select name="status" class="form-select custom-select-box" {{ $isLocked ? 'disabled' : '' }}>
                            @foreach($statusLabels as $key => $val)
                                <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                                    {{ $val['label'] }}
                                </option>
                            @endforeach
                        </select>
                        @if($isLocked)
                            <div class="text-danger small mt-2 fw-medium"><i class="bi bi-lock-fill me-1"></i>Đơn hàng đã đóng, không thể thay đổi.</div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-dark w-100 py-3 rounded-pill fw-bold shadow-sm" {{ $isLocked ? 'disabled' : '' }}>
                        CẬP NHẬT NGAY
                    </button>
                </form>

                <div class="mt-4 pt-4 border-top">
                    <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="btn btn-light border w-100 py-2 rounded-pill fw-bold text-dark hover-primary">
                        <i class="bi bi-printer me-2"></i> Xuất hóa đơn
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection