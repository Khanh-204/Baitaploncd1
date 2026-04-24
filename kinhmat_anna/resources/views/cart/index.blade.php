@extends('layouts.app')

@section('content')
<style>
    /* CSS CHO GIỎ HÀNG CHUẨN E-COMMERCE */
    .cart-title { font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }
    .cart-img { width: 100px; height: 100px; object-fit: cover; border-radius: 12px; border: 1px solid #eaeaea; }
    
    .cart-item { padding: 20px 0; border-bottom: 1px solid #f0f0f0; transition: 0.3s; }
    .cart-item:last-child { border-bottom: none; }
    .cart-item:hover { background-color: #fdfdfd; }
    
    /* Input số lượng */
    .qty-control { display: inline-flex; align-items: center; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #fff;}
    .qty-btn { background: transparent; border: none; padding: 5px 12px; font-weight: bold; cursor: pointer; transition: 0.2s; color: #555;}
    .qty-btn:hover { background: #f0f0f0; color: #000; }
    .qty-input { width: 45px; border: none; text-align: center; font-size: 15px; font-weight: 600; outline: none; -moz-appearance: textfield; pointer-events: none;}
    .qty-input::-webkit-outer-spin-button, .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    
    /* Nút Xóa */
    .btn-delete { background: #fff; border: 1px solid #eee; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #aaa; transition: 0.3s; cursor: pointer;}
    .btn-delete:hover { background: #fee2e2; color: #dc2626; border-color: #fca5a5; transform: scale(1.1); }

    /* Box Tổng tiền */
    .summary-box { background: #fff; border-radius: 16px; padding: 25px; border: 1px solid #eaeaea; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
    .btn-checkout { background: #000; color: #fff; padding: 15px; font-weight: 700; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; border: none; font-size: 15px;}
    .btn-checkout:hover { background: #333; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); color: #fff;}
    
    .coupon-input { border-radius: 50px 0 0 50px; border-right: none; padding-left: 20px;}
    .coupon-input:focus { box-shadow: none; border-color: #ced4da; }
    .btn-coupon { border-radius: 0 50px 50px 0; background: #f8f9fa; border: 1px solid #ced4da; border-left: none; font-weight: 600; padding: 0 20px; transition: 0.2s;}
    .btn-coupon:hover { background: #e9ecef; }
    
    /* Cross-sell Card */
    .cross-sell-card { border-radius: 16px; transition: 0.3s; border: 1px solid #eee; overflow: hidden;}
    .cross-sell-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); }

    /* TRỊ BỆNH HỞ CHÂN KHI GIỎ HÀNG TRỐNG */
    .empty-cart-container { min-height: 55vh; display: flex; align-items: center; justify-content: center; }
</style>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Giỏ hàng</li>
        </ol>
    </nav>

    @php
        $totalQty = 0;
        $total = 0;
        if(session('cart')) {
            foreach(session('cart') as $details) {
                $totalQty += $details['quantity'];
                $total += $details['price'] * $details['quantity'];
            }
        }
        
        // Cấu hình logic Freeship
        $freeShipThreshold = 500000; // 500k Freeship
        $progress = min(100, ($total / $freeShipThreshold) * 100);
        $remainingToFreeship = max(0, $freeShipThreshold - $total);
    @endphp

    <h3 class="cart-title mb-4">Giỏ hàng <span class="text-muted fw-normal fs-5">({{ $totalQty }} sản phẩm)</span></h3>

    @if(session('cart') && count(session('cart')) > 0)
        <div class="row g-5">
            <div class="col-lg-8">
                
                <div class="bg-light p-3 rounded-4 border mb-4 shadow-sm">
                    <div class="d-flex justify-content-between mb-2 small fw-semibold">
                        <span class="text-dark"><i class="bi bi-truck text-success me-1"></i> Chính sách Freeship toàn quốc</span>
                        @if($remainingToFreeship > 0)
                            <span class="text-danger">Mua thêm <b>{{ number_format($remainingToFreeship, 0, ',', '.') }}đ</b> để được Freeship</span>
                        @else
                            <span class="text-success"><i class="bi bi-check-circle-fill"></i> Chúc mừng! Đơn hàng được Freeship</span>
                        @endif
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-dark progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $progress }}%;"></div>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-4 border shadow-sm">
                    <div class="d-flex justify-content-between border-bottom pb-3 text-muted fw-semibold text-uppercase" style="font-size: 13px; letter-spacing: 0.5px;">
                        <span style="width: 45%;">Sản phẩm</span>
                        <div class="d-flex justify-content-between" style="width: 55%;">
                            <span class="text-center w-50">Số lượng</span>
                            <span class="text-end w-50 pe-3">Tạm tính</span>
                        </div>
                    </div>

                    @foreach(session('cart') as $id => $details)
                        @php 
                            $subtotal = $details['price'] * $details['quantity'];
                            $cleanImg = trim($details['image']);
                            $imgSrc = str_starts_with($cleanImg, 'http') ? $cleanImg : asset('storage/' . $cleanImg);
                        @endphp

                        <div class="cart-item d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3" style="width: 45%;">
                                <img src="{{ $imgSrc }}?v={{ time() }}" alt="{{ $details['name'] }}" class="cart-img shadow-sm">
                                <div>
                                    <h6 class="fw-bold mb-1" style="font-size: 15px; line-height: 1.4;">
                                        <a href="{{ route('products.show', Str::slug($details['name'])) }}" class="text-dark text-decoration-none hover-danger">{{ $details['name'] }}</a>
                                    </h6>
                                    <div class="text-muted small mb-2">Phân loại: Freesize / Tiêu chuẩn</div>
                                    <div class="text-danger fw-bold">{{ number_format($details['price'], 0, ',', '.') }}đ</div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between" style="width: 55%;">
                                <div class="w-50 d-flex justify-content-center">
                                    <form action="{{ route('cart.update') }}" method="POST" class="update-form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <div class="qty-control shadow-sm">
                                            <button type="button" class="qty-btn btn-minus">-</button>
                                            <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="qty-input" min="1">
                                            <button type="button" class="qty-btn btn-plus">+</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="w-50 d-flex align-items-center justify-content-end gap-3">
                                    <div class="fw-bold fs-6 text-dark">{{ number_format($subtotal, 0, ',', '.') }}đ</div>
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="btn-delete shadow-sm" title="Xóa khỏi giỏ">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4">
                <div class="summary-box sticky-top" style="top: 100px;">
                    <h5 class="fw-bold mb-4 text-uppercase border-bottom pb-3" style="letter-spacing: 1px;">Tóm tắt đơn hàng</h5>
                    
                    <div class="mb-4">
                        <label class="form-label small text-muted fw-semibold">Mã giảm giá</label>
                        <div class="input-group mb-3 shadow-sm" style="border-radius: 50px;">
                            <input type="text" class="form-control coupon-input" placeholder="Nhập mã...">
                            <button class="btn btn-coupon" type="button">Áp dụng</button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-3 text-secondary" style="font-size: 15px;">
                        <span>Tạm tính</span>
                        <span class="fw-semibold text-dark">{{ number_format($total, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-secondary" style="font-size: 15px;">
                        <span>Phí vận chuyển</span>
                        @if($remainingToFreeship > 0)
                            <span class="fw-bold text-dark">30.000đ</span>
                        @else
                            <span class="text-success fw-bold">Miễn phí</span>
                        @endif
                    </div>
                    
                    <div class="border-top border-2 border-dark my-4"></div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold fs-5">TỔNG CỘNG</span>
                        @php $finalTotal = $remainingToFreeship > 0 ? $total + 30000 : $total; @endphp
                        <span class="fw-bold fs-3 text-danger">{{ number_format($finalTotal, 0, ',', '.') }}đ</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-checkout w-100 d-block text-center text-decoration-none">
                        Tiến hành thanh toán <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                    
                    <div class="text-center mt-4">
                        <div class="d-flex justify-content-center gap-2 mb-2">
                            <img src="https://tse4.mm.bing.net/th/id/OIP.B2eN46zF0bixOiFzRfFMOQHaHa?rs=1&pid=ImgDetMain&o=7&rm=3" height="40">
                            <img src="https://vinadesign.vn/uploads/images/2023/05/vnpay-logo-vinadesign-25-12-57-55.jpg" height="40">
                            <img src="https://developers.momo.vn/v3/assets/images/icon-52bd5808cecdb1970e1aeec3c31a3ee1.png" height="40">
                            <img src="https://png.pngtree.com/png-clipart/20230805/original/pngtree-bank-transfer-icon-office-message-economy-vector-picture-image_9730137.png" height="40">
                        </div>
                        <span class="small text-muted"><i class="bi bi-shield-check text-success"></i> Thanh toán an toàn & bảo mật 100%</span>
                    </div>
                </div>
            </div>
        </div>
        
        @if(isset($relatedProducts) && count($relatedProducts) > 0)
        <div class="mt-5 pt-4">
            <h4 class="fw-bold mb-4 text-uppercase border-bottom pb-3" style="letter-spacing: 1px;">Có thể bạn sẽ thích</h4>
            <div class="row g-4">
                @foreach($relatedProducts as $p)
                    @php
                        $cleanImg = trim($p->image);
                        $imgSrc = str_starts_with($cleanImg, 'http') ? $cleanImg : asset('storage/' . $cleanImg);
                    @endphp
                    <div class="col-6 col-md-3">
                        <div class="cross-sell-card bg-white h-100">
                            <a href="{{ route('products.show', $p->slug) }}" class="text-decoration-none text-dark">
                                <img src="{{ $imgSrc }}" class="w-100" style="aspect-ratio: 1/1; object-fit: cover;">
                                <div class="p-3 text-center">
                                    <h6 class="fw-semibold mb-1 text-truncate" style="font-size: 14px;">{{ $p->name }}</h6>
                                    <p class="text-danger fw-bold mb-0">{{ number_format($p->sale_price ?? $p->price, 0, ',', '.') }}đ</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    @else
        <div class="empty-cart-container w-100">
            <div class="text-center py-5 bg-white rounded-4 border shadow-sm w-100">
                <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" width="120" class="mb-4 opacity-50">
                <h4 class="fw-bold text-dark">Giỏ hàng của bạn đang trống</h4>
                <p class="text-secondary mb-4">Bạn chưa chọn sản phẩm nào. Hãy khám phá các bộ sưu tập ngay!</p>
                <a href="{{ route('products.index') }}" class="btn btn-dark rounded-pill px-5 py-3 fw-bold text-uppercase" style="letter-spacing: 1px;">Tiếp tục mua sắm</a>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const minusBtns = document.querySelectorAll('.btn-minus');
        const plusBtns = document.querySelectorAll('.btn-plus');

        minusBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                let input = this.nextElementSibling;
                let currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                    this.closest('form').submit(); 
                }
            });
        });

        plusBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                let input = this.previousElementSibling;
                input.value = parseInt(input.value) + 1;
                this.closest('form').submit(); 
            });
        });
    });
</script>
@endsection