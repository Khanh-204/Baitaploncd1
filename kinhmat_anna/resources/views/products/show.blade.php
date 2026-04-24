@extends('layouts.app')

@section('content')
<style>
    /* CSS CHUYÊN NGHIỆP CHO TRANG CHI TIẾT */
    .product-detail-img { width: 100%; border-radius: 24px; object-fit: cover; aspect-ratio: 1/1; background: #f8f9fa; border: 1px solid #eaeaea; }
    
    .price-old { font-size: 18px; color: #a0a0a0; text-decoration: line-through; font-weight: 500;}
    .price-new { font-size: 28px; color: #dc3545; font-weight: 800; }
    
    /* Box chọn số lượng */
    .qty-box { border: 1px solid #ddd; border-radius: 50px; overflow: hidden; display: inline-flex; background: #fff;}
    .qty-btn { width: 45px; height: 45px; border: none; background: transparent; font-size: 20px; font-weight: 600; cursor: pointer; transition: 0.2s;}
    .qty-btn:hover { background: #f0f0f0; }
    .qty-input { width: 50px; height: 45px; border: none; text-align: center; font-weight: bold; font-size: 16px; outline: none; -moz-appearance: textfield;}
    .qty-input::-webkit-outer-spin-button, .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

    /* Nút Mua hàng */
    .btn-add-cart { padding: 15px 30px; font-weight: 700; border-radius: 50px; border: 2px solid #000; background: #fff; color: #000; transition: 0.3s; letter-spacing: 1px;}
    .btn-add-cart:hover { background: #000; color: #fff; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1);}
    
    .btn-buy-now { padding: 15px 30px; font-weight: 700; border-radius: 50px; border: 2px solid #000; background: #000; color: #fff; transition: 0.3s; letter-spacing: 1px;}
    .btn-buy-now:hover { background: #333; border-color: #333; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.15);}

    /* Box chính sách */
    .policy-item { display: flex; align-items: center; gap: 15px; padding: 15px; border: 1px solid #eee; border-radius: 16px; margin-bottom: 15px; background: #fafafa; transition: 0.3s;}
    .policy-item:hover { border-color: #ddd; background: #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.05);}
    .policy-icon { font-size: 24px; color: #000; }

    .breadcrumb-link { transition: all 0.2s ease; }
    .breadcrumb-link:hover { text-decoration: underline !important; color: #000 !important; }
    
    /* Nút quay lại xịn sò */
    .btn-back-modern { transition: all 0.3s ease; background-color: #fff; border: 1px solid #e0e0e0; }
    .btn-back-modern:hover { transform: translateX(-5px); background-color: #f8f9fa; box-shadow: 0 6px 12px rgba(0,0,0,0.08) !important; border-color: #d0d0d0; }
</style>

<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <div class="text-muted small fw-medium">
            <a href="{{ route('home') }}" class="text-decoration-none text-dark breadcrumb-link">
                <i class="bi bi-house-door me-1"></i>Trang chủ
            </a>
            <span class="mx-2 text-muted">/</span>
            <a href="{{ route('products.index') }}" class="text-decoration-none text-dark breadcrumb-link">
                Sản phẩm
            </a>
            <span class="mx-2 text-muted">/</span>
            <span class="text-secondary fw-bold">{{ $product->name }}</span>
        </div>
    </nav>

    <div class="mb-5 text-start">
        <a href="{{ url()->previous() != url()->current() ? url()->previous() : route('products.index') }}" 
           class="btn btn-back-modern rounded-pill px-4 py-2 shadow-sm text-dark fw-bold text-decoration-none d-inline-flex align-items-center">
            <i class="bi bi-arrow-left me-2 fs-5"></i> Quay lại
        </a>
    </div>

    <div class="row g-5">
        <div class="col-md-6 col-lg-5">
            <div class="position-relative">
                @if($product->is_featured)
                    <span class="badge bg-dark position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm" style="z-index: 2; letter-spacing: 1px;">HOT🔥</span>
                @endif
                
                @if($product->sale_price)
                    @php $discount = round(100 - ($product->sale_price / $product->price * 100)); @endphp
                    <span class="badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill shadow-sm" style="z-index: 2;">-{{ $discount }}%</span>
                @endif

                @php
                    if ($product->image) {
                        $cleanImg = trim($product->image);
                        $mainImg = str_starts_with($cleanImg, 'http') ? $cleanImg : asset('storage/' . $cleanImg);
                    } else {
                        $mainImg = 'https://placehold.co/800x800?text=No+Image';
                    }
                @endphp
                <img src="{{ $mainImg }}?v={{ time() }}" class="product-detail-img shadow-sm" alt="{{ $product->name }}">
            </div>
        </div>

        <div class="col-md-6 col-lg-7">
            <div class="ps-md-4">
                <span class="badge bg-light text-dark border mb-3 px-3 py-2">{{ $product->category->name ?? 'Kính Mắt' }}</span>
                
                <h1 class="fw-bold mb-3 display-6">{{ $product->name }}</h1>
                
                <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                    <div class="text-warning fs-5 me-3">
                        @for($i=1; $i<=5; $i++)
                            @if($i <= round($product->rating)) <i class="bi bi-star-fill"></i> @else <i class="bi bi-star"></i> @endif
                        @endfor
                        <span class="text-dark fw-bold ms-1" style="font-size: 16px;">{{ $product->rating }}</span>
                    </div>
                    <div class="text-muted border-start ps-3 fs-6">
                        Đã bán <span class="fw-bold text-dark">{{ number_format($product->sold, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mb-4 d-flex align-items-center gap-3">
                    @if($product->sale_price)
                        <span class="price-new">{{ number_format($product->sale_price, 0, ',', '.') }} ₫</span>
                        <span class="price-old">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                    @else
                        <span class="price-new">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                    @endif
                </div>

                <div class="mb-4">
                    <p class="text-secondary" style="line-height: 1.8;">
                        {{ $product->description ?? 'Chiếc kính mang phong cách thiết kế hiện đại, phù hợp với nhiều khuôn mặt. Chất liệu cao cấp mang lại cảm giác thoải mái khi đeo cả ngày dài.' }}
                    </p>
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-5">
                    @csrf
                    <div class="d-flex align-items-center mb-4">
                        <span class="fw-semibold me-4">Số lượng:</span>
                        <div class="qty-box">
                            <button type="button" class="qty-btn" onclick="let input = document.getElementById('qty'); if(input.value > 1) input.value--;">-</button>
                            <input type="number" id="qty" name="quantity" class="qty-input" value="1" min="1" max="{{ $product->stock }}">
                            <button type="button" class="qty-btn" onclick="let input = document.getElementById('qty'); let max = {{ $product->stock }}; if(parseInt(input.value) < max) input.value = parseInt(input.value) + 1;">+</button>
                        </div>
                        <span class="text-muted ms-4 small">Sản phẩm còn lại: <strong class="text-dark">{{ $product->stock }}</strong></span>
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn-add-cart flex-fill">
                            THÊM VÀO GIỎ <i class="bi bi-cart-plus ms-2"></i>
                        </button>
                        
                        <button type="submit" name="buy_now" value="1" class="btn-buy-now flex-fill">
                            MUA NGAY <i class="bi bi-bag-check ms-2"></i>
                        </button>
                    </div>
                </form>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="policy-item">
                            <i class="bi bi-shield-check policy-icon"></i>
                            <div>
                                <h6 class="fw-bold mb-1 fs-6">Bảo hành trọn đời</h6>
                                <span class="text-muted small">Lỗi kĩ thuật, ốc vít</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="policy-item">
                            <i class="bi bi-arrow-repeat policy-icon"></i>
                            <div>
                                <h6 class="fw-bold mb-1 fs-6">Đổi trả 15 ngày</h6>
                                <span class="text-muted small">Nếu có lỗi nhà sản xuất</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mt-5 pt-5 border-top">
            <h4 class="fw-bold mb-4 text-uppercase" style="letter-spacing: 1px;">Sản phẩm liên quan</h4>
            <div class="row g-4">
                @foreach($relatedProducts as $item)
                    <div class="col-6 col-md-3">
                        <div class="product-card h-100 shadow-sm border rounded-4 overflow-hidden position-relative" style="transition: 0.3s;">
                            @php
                                $img = trim($item->image);
                                $src = str_starts_with($img, 'http') ? $img : asset('storage/' . $img);
                            @endphp
                            <a href="{{ route('products.show', $item->slug) }}" class="text-decoration-none text-dark">
                                <img src="{{ $src }}?v={{ time() }}" class="w-100" style="aspect-ratio: 1/1; object-fit: cover;">
                                <div class="p-3 text-center bg-white">
                                    <h6 class="fw-semibold text-truncate mb-1 fs-6">{{ $item->name }}</h6>
                                    <p class="text-danger fw-bold mb-0">{{ number_format($item->sale_price ?? $item->price, 0, ',', '.') }}đ</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection