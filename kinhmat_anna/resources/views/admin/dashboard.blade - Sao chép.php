@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0" style="letter-spacing: 1px;">Bảng Điều Khiển</h3>
        <span class="text-muted fw-medium"><i class="bi bi-calendar3 me-2"></i>Hôm nay: {{ date('d/m/Y') }}</span>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100" style="background: linear-gradient(135deg, #111 0%, #333 100%); color: white;">
                <div class="card-body p-4 position-relative">
                    <p class="text-white-50 fw-semibold mb-1 text-uppercase" style="letter-spacing: 1px; font-size: 13px;">Tổng doanh thu</p>
                    <h3 class="fw-bold mb-0">{{ number_format($totalRevenue, 0, ',', '.') }}đ</h3>
                    <i class="bi bi-cash-coin position-absolute opacity-25" style="font-size: 80px; bottom: -15px; right: -10px;"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted fw-semibold mb-1 text-uppercase" style="letter-spacing: 1px; font-size: 13px;">Đơn hàng mới</p>
                        <h3 class="fw-bold mb-0 text-dark">{{ $totalOrders }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-cart-check fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted fw-semibold mb-1 text-uppercase" style="letter-spacing: 1px; font-size: 13px;">Tổng sản phẩm</p>
                        <h3 class="fw-bold mb-0 text-dark">{{ $totalProducts }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted fw-semibold mb-1 text-uppercase" style="letter-spacing: 1px; font-size: 13px;">Khách hàng</p>
                        <h3 class="fw-bold mb-0 text-dark">{{ $totalCustomers }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0">Biểu đồ doanh thu (7 ngày qua)</h5>
                    <button class="btn btn-sm btn-outline-dark rounded-pill px-3">Tải báo cáo</button>
                </div>
                <div style="height: 300px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
<div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                <h5 class="fw-bold mb-4">Đơn hàng vừa tạo</h5>
                
                @forelse($recentOrders as $order)
                <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                    <div class="bg-light rounded-3 p-2 me-3"><i class="bi bi-box text-dark fs-5"></i></div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold">#ORD-{{ $order->id }} 
                            @if($order->status == 'completed' || $order->status == 'Hoàn thành')
                                <span class="badge bg-success ms-2 small">Hoàn thành</span>
                            @elseif($order->status == 'cancelled' || $order->status == 'Đã hủy')
                                <span class="badge bg-danger ms-2 small">Đã hủy</span>
                            @else
                                <span class="badge bg-warning text-dark ms-2 small">Đang xử lý</span>
                            @endif
                        </h6>
                        <small class="text-muted">Khách: {{ $order->name ?? 'Khách lẻ' }} - {{ $order->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="fw-bold text-danger">{{ number_format($order->total_amount ?? 0, 0, ',', '.') }}đ</div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-inbox display-4 opacity-25 d-block mb-2"></i>
                    Chưa có đơn hàng nào!
                </div>
                @endforelse

                <a href="{{ route('admin.orders.index') }}" class="btn btn-light border w-100 mt-auto rounded-pill fw-medium text-dark hover-shadow">Xem tất cả đơn hàng</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Nhận dữ liệu từ Controller truyền sang
    const labels = {!! json_encode($chartLabels) !!};
    const dataPoints = {!! json_encode($chartData) !!};

    // Khởi tạo Chart.js
    new Chart(ctx, {
        type: 'line', // Biểu đồ đường
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: dataPoints,
                borderColor: '#000', // Màu đường vẽ đen tuyền
                backgroundColor: 'rgba(0, 0, 0, 0.05)', // Đổ bóng mờ phía dưới
                borderWidth: 3,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#000',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true, // Kích hoạt đổ bóng
                tension: 0.4 // Làm cong đường vẽ cho mượt
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ' ₫';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5], color: '#eee' },
                    ticks: {
                        callback: function(value) {
                            return value / 1000000 + ' Tr'; // Rút gọn số trên cột Y
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endsection