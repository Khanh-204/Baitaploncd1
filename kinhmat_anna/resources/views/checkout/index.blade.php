@extends('layouts.app')

@section('content')
<style>
    :root {
        --anna-teal: #3cb3b0;
        --anna-teal-hover: #2c8c89;
    }

    .form-control { border-radius: 8px; padding: 12px 15px; border: 1px solid #ddd; transition: 0.3s;}
    .form-control:focus { border-color: var(--anna-teal); box-shadow: 0 0 0 4px rgba(60, 179, 176, 0.1); }
    .form-label { font-weight: 600; font-size: 14px; margin-bottom: 8px; }
    .checkout-box { background: #fff; padding: 30px; border-radius: 16px; border: 1px solid #eee; }
    
    .checkout-item-img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; }
    
    /* Đổi nút Đặt hàng sang màu Xanh Anna */
    .btn-place-order { background: var(--anna-teal); color: #fff; padding: 16px; font-weight: 700; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; width: 100%; border: none;}
    .btn-place-order:hover { background: var(--anna-teal-hover); transform: translateY(-3px); box-shadow: 0 10px 20px rgba(60, 179, 176, 0.25); color: #fff;}

    .qty-mini { display: flex; align-items: center; gap: 5px; background: #fff; border: 1px solid #ddd; border-radius: 20px; padding: 2px 8px; width: fit-content; }
    .qty-mini-btn { border: none; background: none; padding: 0 5px; font-weight: bold; cursor: pointer; color: #555; transition: 0.2s;}
    .qty-mini-btn:hover { color: var(--anna-teal); }
    .qty-mini-btn:disabled { color: #ccc; cursor: not-allowed; }
    .qty-mini-val { font-size: 13px; font-weight: 700; min-width: 20px; text-align: center; }
    
    .btn-remove-item { font-size: 18px; color: #dc3545; transition: 0.2s; background: none; border: none; padding: 0; }
    .btn-remove-item:hover { color: #a71d2a; transform: scale(1.1); }

    /* Custom Radio Button cho phần Thanh toán */
    .payment-option { border: 1px solid #eee; transition: 0.3s; cursor: pointer; }
    .payment-option.active { border-color: var(--anna-teal); background-color: #f2fbfb !important; box-shadow: 0 4px 15px rgba(60, 179, 176, 0.1); }
    .custom-radio:checked { background-color: var(--anna-teal); border-color: var(--anna-teal); }
    
    /* Khung thông báo QR - ĐÃ SỬA LẠI */
    .qr-invoice-box { display: none; animation: fadeInDown 0.4s ease forwards; }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-uppercase" style="letter-spacing: 2px; font-family: 'Playfair Display', serif;">Thanh Toán</h2>
        <div style="width: 50px; height: 3px; background-color: var(--anna-teal); margin: 10px auto 0; border-radius: 2px;"></div>
    </div>

    @php 
        $total = 0; 
        if(session('cart')) {
            foreach(session('cart') as $details) {
                $total += $details['price'] * $details['quantity']; 
            }
        }
    @endphp

    <div class="row g-5">
        <div class="col-lg-7">
            <form action="{{ route('checkout.process') }}" method="POST" id="main-checkout-form">
                @csrf
                <div class="checkout-box shadow-sm">
                    <h5 class="fw-bold mb-4 border-bottom pb-3">Thông tin giao hàng</h5>

                    @if(session('error'))
                        <div class="alert alert-danger fw-bold shadow-sm rounded-3 mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 shadow-sm mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Nhập họ tên đầy đủ" 
                               value="{{ old('customer_name', Auth::check() ? Auth::user()->name : '') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" name="customer_phone" class="form-control" placeholder="Nhập số điện thoại liên hệ" 
                               value="{{ old('customer_phone', Auth::check() ? Auth::user()->phone : '') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                        <input type="text" name="customer_address" class="form-control" placeholder="Số nhà, tên đường, phường/xã, quận/huyện..." 
                               value="{{ old('customer_address', Auth::check() ? Auth::user()->address : '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ghi chú đơn hàng (Tùy chọn)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Giao hàng giờ hành chính, gọi trước khi giao...">{{ old('notes') }}</textarea>
                    </div>

                    <h5 class="fw-bold mb-3 mt-5 border-bottom pb-3">Phương thức thanh toán</h5>
                    
                    <div class="form-check mb-3 p-3 rounded-3 bg-light payment-option active" id="wrap-cod" onclick="selectPayment('cod')">
                        <input class="form-check-input ms-1 custom-radio" type="radio" name="payment_method" id="cod" value="cod" checked>
                        <label class="form-check-label ms-2 fw-bold w-100" for="cod" style="cursor: pointer;">
                            <i class="bi bi-cash-stack text-success me-2 fs-5 align-middle"></i> Thanh toán khi nhận hàng (COD)
                        </label>
                    </div>
                    
                    <div class="form-check p-3 rounded-3 bg-light payment-option" id="wrap-bank" onclick="selectPayment('bank')">
                        <input class="form-check-input ms-1 custom-radio" type="radio" name="payment_method" id="bank" value="bank">
                        <label class="form-check-label ms-2 fw-bold w-100" for="bank" style="cursor: pointer;">
                            <i class="bi bi-qr-code-scan text-primary me-2 fs-5 align-middle"></i> Chuyển khoản ngân hàng (Quét mã QR)
                        </label>
                        
                        <div id="bank-qr-box" class="qr-invoice-box mt-3 pt-3 border-top" style="display: none;">
                            <div class="alert alert-info mb-0 border-0 d-flex align-items-center shadow-sm" style="background-color: #f2fbfb;">
                                <i class="bi bi-info-circle-fill fs-4 me-3 text-info" style="color: #3cb3b0 !important;"></i>
                                <div>
                                    <span class="d-block fw-bold text-dark mb-1">Hướng dẫn thanh toán an toàn</span>
                                    <span class="small text-muted" style="line-height: 1.5; display: block;">Sau khi nhấn <b>"ĐẶT HÀNG NGAY"</b>, hệ thống sẽ tạo đơn và cung cấp <b>Mã QR chứa sẵn số tiền và nội dung chuyển khoản</b> để bạn thanh toán.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>

        <div class="col-lg-5">
            <div class="checkout-box shadow-sm sticky-top" style="top: 100px; background: #fafafa;">
                <h5 class="fw-bold mb-4 border-bottom pb-3">Đơn hàng của bạn</h5>
                
                <div class="mb-4" style="max-height: 300px; overflow-y: auto; padding-right: 10px;">
                    @foreach(session('cart') as $id => $details)
                        @php 
                            $cleanImg = trim($details['image']);
                            $imgSrc = str_starts_with($cleanImg, 'http') ? $cleanImg : asset('storage/' . $cleanImg);
                        @endphp
                        <div class="d-flex align-items-center mb-4 pb-3 border-bottom border-white">
                            <img src="{{ $imgSrc }}" class="checkout-item-img me-3 shadow-sm">
                            
                            <div class="flex-grow-1">
                                <h6 class="fw-semibold mb-1" style="font-size: 14px;">
                                    <a href="{{ route('products.show', \Illuminate\Support\Str::slug($details['name'])) }}" class="text-dark text-decoration-none hover-danger">{{ $details['name'] }}</a>
                                </h6>
                                
                                <div class="d-flex align-items-center justify-content-between mt-2">
                                    <form action="{{ route('checkout.update') }}" method="POST" class="qty-mini shadow-sm m-0">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" name="quantity" value="{{ $details['quantity'] - 1 }}" class="qty-mini-btn" {{ $details['quantity'] <= 1 ? 'disabled' : '' }}>-</button>
                                        <span class="qty-mini-val">{{ $details['quantity'] }}</span>
                                        <button type="submit" name="quantity" value="{{ $details['quantity'] + 1 }}" class="qty-mini-btn">+</button>
                                    </form>

                                    <div class="fw-bold text-dark ms-3" style="font-size: 14px;">
                                        {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}đ
                                    </div>
                                    
                                    <form action="{{ route('checkout.remove', $id) }}" method="POST" class="m-0 ms-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove-item" onclick="return confirm('Xóa sản phẩm này?')" title="Xóa khỏi đơn hàng">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-2 mb-3">
                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Tạm tính</span>
                        <span class="fw-medium text-dark">{{ number_format($total, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 text-muted">
                        <span>Phí vận chuyển</span>
                        <span class="text-success fw-bold"><i class="bi bi-check2-circle"></i> Miễn phí</span>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center border-top border-dark border-2 pt-3 mb-4">
                    <span class="fw-bold fs-5">Tổng cộng</span>
                    <span class="fw-bold fs-3 text-danger">{{ number_format($total, 0, ',', '.') }}đ</span>
                </div>

                <button type="submit" form="main-checkout-form" class="btn-place-order shadow">ĐẶT HÀNG NGAY <i class="bi bi-arrow-right ms-2"></i></button>
                
                <div class="text-center text-muted small mt-4">
                    <i class="bi bi-shield-check text-success fs-5 align-middle me-1"></i> Thông tin được bảo mật mã hóa SSL
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Xử lý hiệu ứng chọn phương thức thanh toán
    function selectPayment(method) {
        // Đổi nút Radio
        document.getElementById(method).checked = true;
        
        // Cập nhật giao diện khối bọc (Viền Xanh Anna)
        document.getElementById('wrap-cod').classList.remove('active');
        document.getElementById('wrap-bank').classList.remove('active');
        document.getElementById('wrap-' + method).classList.add('active');

        // Hiện/ẩn khung thông báo
        let qrBox = document.getElementById('bank-qr-box');
        if(method === 'bank') {
            qrBox.style.display = 'block';
        } else {
            qrBox.style.display = 'none';
        }
    }
</script>
@endsection