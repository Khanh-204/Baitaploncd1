@extends('layouts.app')

@section('content')
<style>
    .profile-container { min-height: calc(100vh - 350px); }
    
    .profile-sidebar .list-group-item { border: none; padding: 15px 20px; color: #555; transition: 0.3s; border-radius: 10px; margin-bottom: 5px; }
    .profile-sidebar .list-group-item:hover { background-color: #f8f9fa; color: #000; transform: translateX(5px); }
    .profile-sidebar .list-group-item.active { background-color: #222 !important; border-color: #222 !important; color: #fff !important; font-weight: 700; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transform: translateX(5px); }
    
    .profile-card { border: 1px solid #f0f0f0 !important; box-shadow: 0 10px 30px rgba(0,0,0,0.03) !important; transition: 0.3s; }
    .profile-card:hover { box-shadow: 0 15px 40px rgba(0,0,0,0.06) !important; }
    
    .btn-anna-dark { background-color: #222; color: #fff; border-radius: 50px; padding: 12px 35px; font-weight: 600; transition: 0.3s; text-transform: uppercase; letter-spacing: 1px; border: none; }
    .btn-anna-dark:hover { background-color: #3cb3b0; color: #fff; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(60, 179, 176, 0.2); }
</style>

<div class="container py-5 profile-container">
    <div class="row g-4">
        <div class="col-md-3 mb-4">
            <div class="card profile-card rounded-4">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-dark text-white d-inline-flex align-items-center justify-content-center mb-3 fw-bold shadow" style="width: 80px; height: 80px; font-size: 32px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-0">{{ $user->email }}</p>
                </div>
                <div class="list-group list-group-flush profile-sidebar p-3 pt-0" role="tablist">
                    <a class="list-group-item list-group-item-action active fw-medium" data-bs-toggle="list" href="#profile-tab" role="tab">
                        <i class="bi bi-person me-2 fs-5 align-middle"></i> Hồ sơ cá nhân
                    </a>
                    <a class="list-group-item list-group-item-action fw-medium" data-bs-toggle="list" href="#orders-tab" role="tab">
                        <i class="bi bi-box-seam me-2 fs-5 align-middle"></i> Lịch sử đơn hàng
                    </a>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action fw-medium text-danger mt-4 border-top pt-3" style="border-radius: 0;">
                        <i class="bi bi-box-arrow-right me-2 fs-5 align-middle"></i> Đăng xuất
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            @if(session('success'))
                <div class="alert alert-success shadow-sm rounded-3 fw-bold">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger shadow-sm rounded-3 fw-bold">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            <div class="tab-content">
                <div class="tab-pane fade show active" id="profile-tab" role="tabpanel">
                    <div class="card profile-card rounded-4 p-4 p-lg-5">
                        <h4 class="fw-bold mb-4 border-bottom pb-3">Hồ sơ cá nhân</h4>
                        
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger shadow-sm rounded-3 mb-4">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control-lg bg-light border-0" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Số điện thoại</label>
                                    <input type="tel" name="phone" class="form-control form-control-lg bg-light border-0" value="{{ old('phone', $user->phone) }}" placeholder="VD: 0989xxxxxx">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Email (Cố định)</label>
                                    <input type="email" class="form-control form-control-lg bg-light border-0 opacity-75" value="{{ $user->email }}" readonly>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Địa chỉ giao hàng mặc định</label>
                                    <input type="text" name="address" class="form-control form-control-lg bg-light border-0" value="{{ old('address', $user->address) }}" placeholder="Nhập địa chỉ của bạn...">
                                </div>
                            </div>

                            <div class="mt-5 pt-4 border-top d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                                <button type="submit" class="btn-anna-dark w-100 w-md-auto">LƯU THAY ĐỔI</button>
                                <button type="button" class="btn btn-outline-danger px-4 py-2 fw-bold rounded-pill w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    <i class="bi bi-shield-lock me-2"></i>ĐỔI MẬT KHẨU
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="orders-tab" role="tabpanel">
                    <div class="card profile-card rounded-4 p-4 p-lg-5">
                        <h4 class="fw-bold mb-4 border-bottom pb-3">Lịch sử đơn hàng</h4>
                        
                        @if($orders->count() > 0)
                            @foreach($orders as $order)
                            <div class="card border-0 shadow-sm rounded-4 mb-4" style="background-color: #fdfdfd;">
                                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center rounded-top-4">
                                    <div>
                                        <span class="fw-bold text-dark fs-6">Mã đơn: #{{ $order->order_number }}</span>
                                        <span class="text-muted ms-2 ms-md-3 small d-block d-md-inline"><i class="bi bi-clock me-1"></i>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    
                                    @php
                                        $badgeClass = 'bg-secondary';
                                        $statusName = $order->status_name ?? $order->status;
                                        
                                        if($order->status == 'pending') { $badgeClass = 'bg-warning text-dark'; }
                                        elseif($order->status == 'pending_payment') { $badgeClass = 'bg-secondary text-white'; $statusName = 'Chờ thanh toán'; }
                                        elseif($order->status == 'processing') { $badgeClass = 'bg-info text-white'; $statusName = 'Đang xử lý'; }
                                        elseif($order->status == 'shipped') { $badgeClass = 'bg-primary text-white'; }
                                        elseif($order->status == 'completed') { $badgeClass = 'bg-success text-white'; }
                                        elseif($order->status == 'cancelled') { $badgeClass = 'bg-danger text-white'; }
                                        elseif($order->status == 'refund_pending') { $badgeClass = 'bg-warning text-dark'; $statusName = 'Đang đợi hoàn tiền'; }
                                        elseif($order->status == 'refunded') { $badgeClass = 'bg-success text-white'; $statusName = 'Hoàn tiền thành công'; }
                                    @endphp
                                    <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill shadow-sm">
                                        {{ $statusName }}
                                    </span>
                                </div>
                                
                                <div class="card-body p-4">
                                    @foreach($order->orderDetails as $item)
                                        @php
                                            $cleanImg = trim($item->product->image ?? '');
                                            $imgSrc = str_starts_with($cleanImg, 'http') ? $cleanImg : asset('storage/' . $cleanImg);
                                            if(!$cleanImg) $imgSrc = 'https://placehold.co/100x100?text=No+Image';
                                        @endphp
                                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-light">
                                            <img src="{{ $imgSrc }}" class="rounded-3 shadow-sm border" style="width: 70px; height: 70px; object-fit: cover;">
                                            <div class="ms-3 flex-grow-1">
                                                <h6 class="fw-bold mb-1"><a href="{{ route('products.show', $item->product->slug ?? '#') }}" class="text-dark text-decoration-none hover-danger">{{ $item->product->name ?? 'Sản phẩm đã ngừng kinh doanh' }}</a></h6>
                                                <span class="text-muted small bg-light px-2 py-1 rounded">SL: x{{ $item->quantity }}</span>
                                            </div>
                                            <div class="fw-bold text-dark fs-6">
                                                {{ number_format($item->price, 0, ',', '.') }}đ
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="card-footer bg-white py-3 border-top d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 rounded-bottom-4">
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-dark rounded-pill px-4 fw-medium">Xem chi tiết</a>
                                        
                                        <form method="POST" action="{{ route('orders.reorder', $order->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-dark rounded-pill px-4 shadow-sm fw-medium">
                                                <i class="bi bi-cart-plus me-1"></i> Mua lại
                                            </button>
                                        </form>

                                        @if(in_array($order->status, ['pending', 'pending_payment']))
                                            <form method="POST" action="{{ route('orders.cancel', $order->id) }}" class="d-inline form-cancel-order">
                                                @csrf
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-4 fw-medium btn-cancel-order" data-status="{{ $order->status }}">Hủy đơn</button>
                                            </form>
                                        @elseif($order->status == 'processing')
                                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline form-cancel-order">
                                                @csrf
                                                <button type="button" class="btn btn-warning btn-sm rounded-pill fw-bold btn-cancel-order" data-status="{{ $order->status }}">
                                                    {{ in_array($order->status, ['processing', 'shipped']) ? 'Yêu cầu hoàn tiền' : 'Hủy đơn' }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    
                                    <div class="text-end bg-light px-3 py-2 rounded-3 border">
                                        <span class="text-muted me-2 small fw-semibold text-uppercase">Thành tiền:</span>
                                        <span class="fw-bold fs-5 text-danger">{{ $order->formatted_total ?? number_format($order->total_price, 0, ',', '.') . 'đ' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            <div class="d-flex justify-content-center mt-5">
                                {{ $orders->links('pagination::bootstrap-5') }}
                            </div>

                        @else
                            <div class="text-center py-5 bg-light rounded-4 border">
                                <i class="bi bi-box-seam display-1 text-muted opacity-25"></i>
                                <h5 class="mt-4 fw-bold text-dark">Chưa có đơn hàng nào</h5>
                                <p class="text-muted mb-4">Bạn chưa thực hiện bất kỳ đơn hàng nào.</p>
                                <a href="{{ route('products.index') }}" class="btn-anna-dark text-decoration-none">MUA SẮM NGAY</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold fs-4" id="changePasswordModalLabel">Đổi Mật Khẩu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.password') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                        <input type="password" name="current_password" class="form-control form-control-lg bg-light border-0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mật khẩu mới <span class="text-danger">*</span></label>
                        <input type="password" name="new_password" class="form-control form-control-lg bg-light border-0" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                        <input type="password" name="new_password_confirmation" class="form-control form-control-lg bg-light border-0" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">Xác nhận đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // 1. HÀM CHUYỂN TAB MƯỢT MÀ
        function switchTab(tabId) {
            let tabTrigger = document.querySelector('a[href="' + tabId + '"]');
            if (tabTrigger) {
                let tab = new bootstrap.Tab(tabTrigger);
                tab.show();
            }
        }

        // 2. TỰ ĐỘNG MỞ TAB ĐƠN HÀNG KHI MỚI VÀO (NẾU URL CÓ #orders-tab)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('page') || window.location.hash === '#orders-tab') {
            switchTab('#orders-tab');
        }

        // 3. NẾU CÓ THÔNG BÁO VỪA HỦY HOẶC MUA LẠI ĐƠN XONG -> VỀ THẲNG TAB ĐƠN HÀNG
        @if(session('success') && (str_contains(mb_strtolower(session('success')), 'đơn') || str_contains(mb_strtolower(session('success')), 'hoàn tiền')))
            switchTab('#orders-tab');
        @endif

        // 4. LẮNG NGHE LỖI HEADER: NẾU ĐANG Ở TRANG PROFILE MÀ BẤM MENU ĐƠN HÀNG Ở TRÊN CÙNG
        window.addEventListener('hashchange', function() {
            if (window.location.hash === '#orders-tab') {
                switchTab('#orders-tab');
            } else if (window.location.hash === '#profile-tab' || window.location.hash === '') {
                switchTab('#profile-tab');
            }
        });

        // 5. CẬP NHẬT URL TRÊN THANH ĐỊA CHỈ KHI TỰ BẤM CHUYỂN TAB
        let tabLinks = document.querySelectorAll('a[data-bs-toggle="list"]');
        tabLinks.forEach(link => {
            link.addEventListener('shown.bs.tab', function (e) {
                if(history.pushState) {
                    history.pushState(null, null, e.target.hash);
                } else {
                    window.location.hash = e.target.hash;
                }
            });
        });

        // ==========================================
        // 6. XỬ LÝ POPUP HỦY ĐƠN (SWEETALERT2)
        // ==========================================
        const cancelButtons = document.querySelectorAll('.btn-cancel-order');
        
        cancelButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); 
                const form = this.closest('.form-cancel-order');
                const status = this.getAttribute('data-status');
                
                let alertTitle = 'Xác nhận hủy đơn hàng?';
                let alertText = 'Bạn có chắc chắn muốn hủy đơn hàng này không? Hành động này không thể hoàn tác.';
                let confirmBtnText = 'Vâng, Hủy đơn!';
                
                if (status === 'processing' || status === 'shipped') {
                    alertTitle = 'Yêu cầu hoàn tiền?';
                    alertText = 'Đơn hàng đã được thanh toán. Việc hủy sẽ gửi yêu cầu hoàn tiền đến cửa hàng. Bạn có chắc chắn muốn tiếp tục?';
                    confirmBtnText = 'Gửi yêu cầu hoàn tiền';
                }

                Swal.fire({
                    title: alertTitle,
                    text: alertText,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: confirmBtnText,
                    cancelButtonText: 'Không, giữ lại',
                    reverseButtons: true 
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection