@extends('layouts.app') @section('content')
<div class="container py-5">
    <h3 class="fw-bold mb-4">Quản lý đơn hàng</h3>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0 table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="py-3 px-4">Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th class="text-end px-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-4 fw-bold">#{{ $order->order_number }}</td>
                            <td>
                                <div class="fw-semibold">{{ $order->user->name ?? 'Khách vãng lai' }}</div>
                                <div class="small text-muted">{{ $order->phone }}</div>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="fw-bold text-danger">{{ $order->formatted_total }}</td>
                            <td>
                                <span class="badge {{ $order->status_badge }} px-3 py-2 rounded-pill">
                                    {{ $order->status_name }}
                                </span>
                            </td>
                            <td class="text-end px-4">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-dark rounded-pill px-3">Chi tiết</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Chưa có đơn hàng nào trong hệ thống.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white py-3">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection