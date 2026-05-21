@extends('layouts.app')

@section('content')
<style>
    /* NHÚNG FONT CHỮ SANG CHẢNH */
    @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Playfair+Display:ital,wght@0,500;0,700;1,600&display=swap');

    :root {
        --anna-teal: #3cb3b0;
        --anna-dark-green: #1b3a32; 
        --anna-black: #1a1a1a; 
    }

    /* TYPOGRAPHY CHUẨN MẪU */
    .font-serif { font-family: 'Playfair Display', serif; }
    .font-script { font-family: 'Dancing Script', cursive; }
    .text-teal { color: var(--anna-teal) !important; }
    .bg-teal { background-color: var(--anna-teal) !important; }
    
    .section-title { 
        font-family: 'Playfair Display', serif; 
        font-weight: 700; 
        font-size: 2.5rem; 
        color: var(--anna-black);
        margin-bottom: 40px;
    }

    /* HERO SLIDER */
    .hero-slide { position: relative; height: 85vh; min-height: 600px; overflow: hidden; }
    .hero-slide img { width: 100%; height: 100%; object-fit: cover; transition: transform 8s ease; }
    .carousel-item.active img { transform: scale(1.05); }
    .hero-overlay { background: linear-gradient(to top, rgba(0,0,0,0.6), rgba(0,0,0,0.2)); position: absolute; inset: 0; z-index: 1; }
    .hero-content { position: absolute; inset: 0; z-index: 2; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; color: white; }
    
    .btn-anna-light { background: #fff; color: #000; padding: 12px 35px; border-radius: 50px; font-weight: 600; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; transition: 0.3s; border: none; }
    .btn-anna-light:hover { background: var(--anna-teal); color: #fff; transform: translateY(-3px); }

    /* DANH MỤC CATEGORY */
    .category-circle { width: 150px; height: 150px; object-fit: cover; border-radius: 50%; margin: 0 auto 15px; transition: 0.4s; padding: 4px; border: 1px dashed transparent; }
    .category-item:hover .category-circle { transform: scale(1.05); border-color: var(--anna-teal); padding: 8px; }
    .category-name { font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; }
    .category-item:hover .category-name { color: var(--anna-teal) !important; }

    /* SẢN PHẨM CARD */
    .product-card { border: none; transition: 0.3s; background: transparent; }
    .product-card:hover { transform: translateY(-5px); }
    .img-wrapper { border-radius: 16px; overflow: hidden; position: relative; aspect-ratio: 1/1; background: #f8f8f8; }
    .main-img, .hover-img { width: 100%; height: 100%; object-fit: cover; transition: 0.7s ease; position: absolute; inset: 0; }
    .hover-img { opacity: 0; transform: scale(1.1); }
    .product-card:hover .main-img { opacity: 0; }
    .product-card:hover .hover-img { opacity: 1; transform: scale(1); }
    
    .btn-quick-add { position: absolute; bottom: -50px; left: 50%; transform: translateX(-50%); width: 80%; background: #fff; color: #000; font-weight: 700; padding: 12px 0; border-radius: 30px; transition: 0.4s; opacity: 0; font-size: 12px; border: none; cursor: pointer; text-transform: uppercase; }
    .btn-quick-add:hover { background: var(--anna-teal); color: #fff; }
    .product-card:hover .btn-quick-add { bottom: 20px; opacity: 1; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

    /* HÀNH TRÌNH TỬ TẾ - TEASER */
    .journey-teaser { background-color: var(--anna-dark-green); padding: 100px 0; color: #fff; overflow: hidden; position: relative; }
    .journey-title-teaser { font-size: 4.5rem; line-height: 0.9; color: var(--anna-teal); text-shadow: 2px 2px 10px rgba(0,0,0,0.2); }
    .btn-outline-teal { border: 1px solid var(--anna-teal); color: var(--anna-teal); padding: 10px 30px; border-radius: 50px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; }
    .btn-outline-teal:hover { background: var(--anna-teal); color: #fff; }
    
    .collage-img { border-radius: 16px; object-fit: cover; box-shadow: 0 15px 30px rgba(0,0,0,0.3); transition: 0.5s; }
    .collage-img:hover { transform: scale(1.05) rotate(-2deg); z-index: 10; position: relative; }

    /* HỆ THỐNG CỬA HÀNG - TEASER */
    .store-teaser { background-color: var(--anna-black); padding: 120px 0; color: #fff; text-align: center; }
    .store-link { color: #fff; text-decoration: none; border-bottom: 1px solid #fff; padding-bottom: 2px; transition: 0.3s; font-weight: 500; font-size: 15px; letter-spacing: 1px; }
    .store-link:hover { color: var(--anna-teal); border-color: var(--anna-teal); }
</style>

<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active hero-slide">
            <img src="https://images.unsplash.com/photo-1511499767150-a48a237f0083?q=80&w=2070" alt="Kính cận">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <p class="mb-3 fw-bold" style="letter-spacing: 3px; font-size: 13px;">PHONG CÁCH XUÂN HÈ</p>
                <h1 class="font-serif mb-4" style="font-size: 4.5rem; text-transform: uppercase;">Kính Gọng Tròn</h1>
                <a href="{{ route('products.index') }}" class="btn-anna-light">Khám Phá Ngay</a>
            </div>
        </div>
        <div class="carousel-item hero-slide">
            <img src="https://images.unsplash.com/photo-1577803645773-f96470509666?q=80&w=2070" alt="Kính râm">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <p class="mb-3 fw-bold" style="letter-spacing: 3px; font-size: 13px;">DEAL XINH LUNG LINH</p>
                <h1 class="font-serif mb-4" style="font-size: 4.5rem; text-transform: uppercase;">Chào Hè Rực Rỡ</h1>
                <a href="{{ route('products.index') }}" class="btn-anna-light">Mua Sắm Ngay</a>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<div class="border-bottom py-4 bg-white shadow-sm">
    <div class="container text-center">
        <div class="row g-3">
            <div class="col-6 col-md-3 border-end">
                <i class="bi bi-shield-check fs-3 text-teal mb-2 d-block"></i>
                <h6 class="fw-bold mb-0 fs-6">100% CHÍNH HÃNG</h6>
                <span class="text-muted small">Cam kết chất lượng</span>
            </div>
            <div class="col-6 col-md-3 border-end">
                <i class="bi bi-tools fs-3 text-teal mb-2 d-block"></i>
                <h6 class="fw-bold mb-0 fs-6">BẢO HÀNH TRỌN ĐỜI</h6>
                <span class="text-muted small">Thay ốc, đệm mũi miễn phí</span>
            </div>
            <div class="col-6 col-md-3 border-end">
                <i class="bi bi-arrow-repeat fs-3 text-teal mb-2 d-block"></i>
                <h6 class="fw-bold mb-0 fs-6">ĐỔI TRẢ 15 NGÀY</h6>
                <span class="text-muted small">Lỗi từ nhà sản xuất</span>
            </div>
            <div class="col-6 col-md-3">
                <i class="bi bi-truck fs-3 text-teal mb-2 d-block"></i>
                <h6 class="fw-bold mb-0 fs-6">FREESHIP TOÀN QUỐC</h6>
                <span class="text-muted small">Đơn hàng trên 500k</span>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top: 80px;">
    <div class="text-center"><h3 class="section-title">Khám Phá Anna</h3></div>
    <div class="row text-center justify-content-center g-4">
        @php $cats = [
            ['id' => 1, 'name' => 'Gọng Kính', 'img' => 'https://kinhmatanna.com/_next/image?url=https%3A%2F%2Fcms.kinhmatanna.com%2Fwp-content%2Fuploads%2F2025%2F02%2F1080_TN3269_4372_3_11zon-1-scaled.webp&w=384&q=75'],
            ['id' => 2, 'name' => 'Kính Râm', 'img' => 'https://kinhmatanna.com/_next/image?url=https%3A%2F%2Fcms.kinhmatanna.com%2Fwp-content%2Fuploads%2F2026%2F01%2Fimage_5-26-scaled.jpg&w=384&q=75'],
            ['id' => 3, 'name' => 'Tròng Kính', 'img' => 'https://kinhmatanna.com/_next/image?url=https%3A%2F%2Fcms.kinhmatanna.com%2Fwp-content%2Fuploads%2F2024%2F07%2Fz5682064731999_055f91212de0f5e7d8595f73285c8387.jpg&w=384&q=75'],
            ['id' => 4, 'name' => 'Phụ Kiện', 'img' => 'https://images.unsplash.com/photo-1614715838608-dd527c46231d?w=400']
        ]; @endphp
        @foreach($cats as $cat)
        <div class="col-6 col-md-3">
            <a href="{{ route('products.index', ['category' => $cat['id']]) }}" class="category-item text-dark text-decoration-none d-block">
                <img src="{{ $cat['img'] }}" class="category-circle">
                <h6 class="category-name mt-2">{{ $cat['name'] }}</h6>
            </a>
        </div>
        @endforeach
    </div>
</div>

<div class="container" style="margin-top: 100px; margin-bottom: 80px;">
    <div class="d-flex justify-content-between align-items-end mb-5">
        <h3 class="section-title mb-0">Hàng Mới Về</h3>
        <a href="{{ route('products.index') }}" class="text-muted text-decoration-none fw-semibold">Xem tất cả <i class="bi bi-arrow-right"></i></a>
    </div>

    <div class="row g-4">
        @foreach($newProducts as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card h-100">
                    <div class="img-wrapper mb-3">
                        <span class="badge bg-dark position-absolute top-0 start-0 m-3 px-2 py-1 fw-normal" style="z-index:2; font-size: 11px; letter-spacing: 1px;">MỚI</span>
                        
                        <a href="{{ route('products.show', $product->slug) }}">
                            @php
                                $imgUrlHome = 'https://placehold.co/500x500?text=No+Image';
                                if (!empty($product->image)) {
                                    if (filter_var(trim($product->image), FILTER_VALIDATE_URL)) {
                                        $imgUrlHome = trim($product->image);
                                    } else {
                                        $imgUrlHome = asset('storage/' . $product->image);
                                    }
                                }
                            @endphp
                            <img src="{{ $imgUrlHome }}" class="main-img" alt="{{ $product->name }}">
                            <img src="{{ $imgUrlHome }}" class="hover-img" alt="{{ $product->name }}">
                        </a>
                        
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="ajax-add-to-cart">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-quick-add">THÊM VÀO GIỎ</button>
                        </form>
                    </div>
                    <div class="text-center px-2">
                        <h6 class="fw-bold text-truncate mb-2" style="font-size: 15px;">
                            <a href="{{ route('products.show', $product->slug) }}" class="text-dark text-decoration-none">{{ $product->name }}</a>
                        </h6>
                        <span class="text-muted text-decoration-line-through me-2" style="font-size: 14px;">{{ number_format($product->price * 1.3, 0, ',', '.') }}đ</span>
                        <span class="text-teal fw-bold" style="font-size: 16px;">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="journey-teaser">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 position-relative z-3">
                <h2 class="font-serif journey-title-teaser mb-0">Hành</h2>
                <h2 class="font-serif journey-title-teaser mb-0 ms-5">trình</h2>
                <h2 class="font-script journey-title-teaser mb-2" style="font-size: 5.5rem;">Tử tế <span class="fs-5 text-white font-serif" style="font-style: italic;">by Anna</span></h2>
                
                <p class="fs-5 mt-4 mb-5" style="line-height: 1.8; opacity: 0.9; max-width: 500px;">
                    Mỗi đơn hàng mua tại Anna tức là bạn đang cùng Anna bước đi trên Hành trình tử tế, mang mắt sáng đến mọi miền đất nước và giúp đỡ nhiều người kém may mắn.
                </p>
                <a href="{{ route('journey') }}" class="btn-outline-teal">CẢM ƠN BẠN <i class="bi bi-heart-fill ms-2"></i></a>
            </div>
            
            <div class="col-lg-6 position-relative d-none d-lg-block" style="height: 500px;">
                <img src="https://kinhmatanna.com/_next/image?url=%2Fimg%2Fhome%2Fjourney-right.png&w=640&q=75" class="collage-img position-absolute" style="width: 250px; height: 350px; top: 0; right: 20px; z-index: 2;">
                <img src="https://kinhmatanna.com/_next/image?url=%2Fimg%2Fhome%2Fjourney-left.png&w=640&q=75" class="collage-img position-absolute" style="width: 280px; height: 280px; bottom: 0; left: 20px; z-index: 3;">
                
                <div class="position-absolute rounded-circle" style="width: 40px; height: 40px; background: #e07a5f; top: 40%; left: 0; z-index: 4;"></div>
                <div class="position-absolute rounded-circle" style="width: 60px; height: 60px; background: #f4d06f; bottom: -20px; right: -10px; z-index: 1;"></div>
            </div>
        </div>
    </div>
</div>

<div class="store-teaser">
    <div class="container">
        <h2 class="font-serif display-4 fw-bold mb-4" style="letter-spacing: 1px;">GHÉ THĂM HỆ THỐNG</h2>
        <a href="{{ route('stores.index') }}" class="store-link text-uppercase">Tìm cửa hàng gần nhất <i class="bi bi-chevron-right ms-1 small"></i></a>
    </div>
</div>

@endsection