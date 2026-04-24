<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hóa đơn #{{ $order->order_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff; font-family: 'DejaVu Sans', sans-serif; font-size: 14px; }
        .invoice-box { padding: 30px; border: 1px solid #eee; max-width: 800px; margin: auto; }
        .logo { font-size: 28px; font-weight: 800; letter-spacing: 2px; }
        .table thead { background: #f8f9fa; }
        .total-row { font-size: 18px; font-weight: 800; color: #dc3545; }
        
        /* CSS dành riêng khi in */
        @media print {
            .no-print { display: none; }
            .invoice-box { border: none; padding: 0; }
            body { margin: 0; }
        }
    </style>
</head>
<body onload="window.print();"> <div class="no-print text-center py-3">
    <button onclick="window.print()" class="btn btn-primary">Bấm vào đây nếu máy in không tự hiện</button>
    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-secondary">Quay lại chi tiết đơn</a>
</div>

<div class="invoice-box">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <div class="logo">ANNA</div>
            <p class="text-muted mb-0">Hệ thống kính mắt của sự tử tế</p>
        </div>
        <div class="text-end">
            <h4 class="fw-bold text-uppercase">Hóa đơn bán hàng</h4>
            <p class="mb-0">Mã đơn: <strong>#{{ $order->order_number }}</strong></p>
            <p class="mb-0">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-6">
            <h6 class="fw-bold text-muted border-bottom pb-2">THÔNG TIN CỬA HÀNG</h6>
            <p class="mb-1 fw-bold">Chi nhánh: Kính mắt Anna - Tam Đảo</p>
            <p class="mb-1">Địa chỉ: Đường Km11 - TT. Hợp Châu - Vĩnh Phúc</p>
            <p class="mb-1">Hotline: 1900 0359</p>
        </div>
        <div class="col-6">
            <h6 class="fw-bold text-muted border-bottom pb-2">THÔNG TIN NGƯỜI NHẬN</h6>
            <p class="mb-1">Khách hàng: <strong>{{ $order->name ?? $order->user->name }}</strong></p>
            <p class="mb-1">Điện thoại: {{ $order->phone ?? $order->user->phone }}</p>
            <p class="mb-1">Địa chỉ: {{ $order->address }}</p>
        </div>
    </div>

    <table class="table table-bordered align-middle">
        <thead>
            <tr class="text-center">
                <th style="width: 50px;">STT</th>
                <th>Tên sản phẩm</th>
                <th style="width: 120px;">Đơn giá</th>
                <th style="width: 80px;">SL</th>
                <th style="width: 150px;">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderDetails as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <div class="fw-bold">{{ $item->product->name }}</div>
                </td>
                <td class="text-center">{{ number_format($item->price, 0, ',', '.') }}đ</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-end fw-bold">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-end fw-bold pt-3">Tổng cộng thanh toán:</td>
                <td class="text-end total-row pt-3">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
            </tr>
        </tfoot>
    </table>

    <div class="mt-5 row">
        <div class="col-6 text-center">
            <p class="mb-5">Người mua hàng</p>
            <p class="mt-5 text-muted small">(Ký và ghi rõ họ tên)</p>
        </div>
        <div class="col-6 text-center">
            <p class="mb-5">Người lập hóa đơn</p>
            <p class="mt-5 fw-bold">Admin ANNA JQK</p>
        </div>
    </div>

    <div class="text-center mt-5 pt-5 border-top">
        <p class="fst-italic text-muted">Cảm ơn quý khách đã tin tưởng lựa chọn Kính Mắt Anna!</p>
    </div>
</div>

</body>
</html>