@extends('layouts.admin')

@section('content')
<style>
    /* BẢNG MÀU PASTEL CHUYÊN NGHIỆP CHO ADMIN */
    .status-badge { padding: 6px 12px; border-radius: 50px; font-weight: 600; font-size: 13px; display: inline-block; white-space: nowrap;}
    
    .status-pending { background-color: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6; } /* Xám nhạt */
    .status-pending_payment { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; } /* Vàng nhạt */
    .status-processing { background-color: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; } /* Xanh ngọc nhạt */
    .status-shipped { background-color: #cce5ff; color: #004085; border: 1px solid #b8daff; } /* Xanh dương nhạt */
    .status-completed { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; } /* Xanh lá nhạt */
    .status-refund_pending { background-color: #fff3cd; color: #d39e00; border: 1px solid #ffeeba; border-left: 4px solid #ffc107; } /* Cam cảnh báo */
    .status-refunded { background-color: #e2e3e5; color: #383d41; border: 1px solid #d6d8db; } /* Xám đậm */
    .status-cancelled { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; } /* Đỏ nhạt */
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Quản lý Đơn hàng</h3>
        <span class="badge bg-primary rounded-pill px-3 py-2">Tổng đơn: {{ $orders->total() ?? 0 }}</span>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control bg-light border-0" placeholder="Tìm mã đơn hoặc tên, SĐT khách..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select bg-light border-0">
                        <option value="">-- Tất cả trạng thái --</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận (COD)</option>
                        <option value="pending_payment" {{ request('status') == 'pending_payment' ? 'selected' : '' }}>Chờ thanh toán (Bank)</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý / Đã thu tiền</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Đang giao hàng</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="refund_pending" {{ request('status') == 'refund_pending' ? 'selected' : '' }}>Yêu cầu hoàn tiền</option>
                        <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Đã hoàn tiền</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-dark w-100 fw-bold rounded-3">LỌC</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-muted small text-uppercase">Mã đơn</th>
                            <th class="py-3 text-muted small text-uppercase">Khách hàng</th>
                            <th class="py-3 text-muted small text-uppercase">Ngày đặt</th>
                            <th class="py-3 text-muted small text-uppercase text-end">Tổng tiền</th>
                            <th class="py-3 text-muted small text-uppercase text-center">Trạng thái</th>
                            <th class="px-4 py-3 text-muted small text-uppercase text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            @php
                                $statusLabels = [
                                    'pending'         => ['label' => 'Chờ xác nhận', 'class' => 'status-pending'],
                                    'pending_payment' => ['label' => 'Chờ thanh toán', 'class' => 'status-pending_payment'],
                                    'processing'      => ['label' => 'Đang xử lý', 'class' => 'status-processing'],
                                    'shipped'         => ['label' => 'Đang giao', 'class' => 'status-shipped'],
                                    'completed'       => ['label' => 'Hoàn thành', 'class' => 'status-completed'],
                                    'refund_pending'  => ['label' => 'Yêu cầu hoàn tiền', 'class' => 'status-refund_pending'],
                                    'refunded'        => ['label' => 'Đã hoàn tiền', 'class' => 'status-refunded'],
                                    'cancelled'       => ['label' => 'Đã hủy', 'class' => 'status-cancelled'],
                                ];
                                $currentStatus = $statusLabels[$order->status] ?? ['label' => $order->status, 'class' => 'status-pending'];
                                
                                $cleanTotal = (int) preg_replace('/[^0-9]/', '', (string) ($order->total_amount ?? $order->total_price ?? $order->total ?? 0));
                            @endphp
                            <tr>
                                <td class="px-4 fw-bold">#{{ $order->order_number ?? $order->id }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $order->customer_name ?? $order->user->name ?? 'N/A' }}</div>
                                    <div class="small text-muted">{{ $order->customer_phone ?? $order->user->phone ?? 'Không có số' }}</div>
                                </td>
                                <td class="text-muted small">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-end fw-bold text-primary">{{ number_format($cleanTotal, 0, '.', ',') }}đ</td>
                                <td class="text-center">
                                    <span class="status-badge {{ $currentStatus['class'] }}">{{ $currentStatus['label'] }}</span>
                                </td>
                                <td class="px-4 text-end">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                        <i class="bi bi-eye me-1"></i> Chi tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                    Không tìm thấy đơn hàng nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 d-flex justify-content-end rounded-bottom-4">
                {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection