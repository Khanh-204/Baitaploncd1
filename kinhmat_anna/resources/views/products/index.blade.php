@extends('layouts.app')

@section('content')
<style>
    /* TẠO BIẾN MÀU CHUẨN ANNA ĐỂ DỄ ĐỒNG BỘ */
    :root {
        --anna-teal: #3cb3b0;
        --anna-teal-hover: #2c8c89;
    }

    /* GLOBAL */
    body { background: #fff; }

    /* TITLE */
    .page-title { font-weight: 800; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 10px; }
    /* Đổi gạch chân tiêu đề sang màu xanh Anna */
    .title-line { width: 60px; height: 3px; background-color: var(--anna-teal); margin: 0 auto; border-radius: 2px; } 

    /* NÚT BẤM MÀU XANH ANNA */
    .btn-teal { background-color: var(--anna-teal); color: #fff; border: none; transition: 0.3s; }
    .btn-teal:hover { background-color: var(--anna-teal-hover); color: #fff; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(60, 179, 176, 0.3); }
    .bg-teal { background-color: var(--anna-teal) !important; color: #fff !important; }

    /* FILTER SIDEBAR */
    .filter-sidebar { background: #fff; border-radius: 16px; border: 1px solid #eee; padding: 25px; }
    .filter-title { font-weight: 700; font-size: 15px; text-transform: uppercase; margin-bottom: 20px; border-bottom: 2px solid var(--anna-teal); display: inline-block; padding-bottom: 8px;}
    
    .filter-item { margin-bottom: 10px; }
    .filter-item input { display: none; }
    .filter-item label { display: block; padding: 10px 15px; border-radius: 8px; cursor: pointer; transition: 0.2s; color: #555; font-size: 14px;}
    .filter-item label:hover { background: #f8f9fa; color: var(--anna-teal); }
    /* Label khi được chọn sẽ sáng màu Xanh Anna */
    .filter-item input:checked + label { background: var(--anna-teal); color: #fff; font-weight: 600; box-shadow: 0 4px 10px rgba(60, 179, 176, 0.2);}

    /* BỘ LỌC GIÁ */
    .input-group-price { border: 2px solid #eee; border-radius: 50px; overflow: hidden; transition: 0.3s; background: #fff; }
    .input-group-price:focus-within { border-color: var(--anna-teal); box-shadow: 0 4px 10px rgba(60, 179, 176, 0.1); }
    .price-input { box-shadow: none !important; outline: none !important; font-weight: 600; font-size: 14px; }
    .btn-step { font-weight: bold; background: #f8f9fa; border: none; width: 40px; transition: 0.2s; color: #555; }
    .btn-step:hover { background: var(--anna-teal); color: #fff; }

    /* PRODUCT CARD PRO */
    .product-card { background: #fff; border-radius: 20px; overflow: hidden; transition: 0.4s ease; position: relative; border: 1px solid transparent; }
    .product-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); border-color: #f0f0f0;}
    .product-card:hover h6 { color: var(--anna-teal); } /* Tên SP khi hover đổi màu xanh */

    /* IMAGE HOVER ĐỔI ẢNH */
    .img-wrapper { position: relative; aspect-ratio: 1/1; overflow: hidden; background: #f8f9fa; }
    .product-img, .product-img-hover { position: absolute; width: 100%; height: 100%; object-fit: cover; transition: 0.5s ease; top: 0; left: 0;}
    .product-img-hover { opacity: 0; transform: scale(1.05); }
    .product-card:hover .product-img { opacity: 0; }
    .product-card:hover .product-img-hover { opacity: 1; transform: scale(1); }

    /* BADGE SALE & HOT */
    .badge-sale { position: absolute; top: 12px; right: 12px; background: #dc3545; color: #fff; font-size: 11px; padding: 4px 8px; border-radius: 4px; font-weight: 700; z-index: 2; letter-spacing: 1px;}
    .category-badge { position: absolute; top: 54px; left: 12px; z-index: 2; border: 1px solid #ddd; padding: 4px 8px; border-radius: 4px; font-weight: 600; font-size: 11px;}

    /* WISHLIST */
    .wishlist-btn { position: absolute; top: 12px; left: 12px; background: #fff; border-radius: 20px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px; cursor: pointer; transition: 0.3s; z-index: 50 !important; color: #666; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border: none; padding: 0 12px; gap: 5px; }
    .wishlist-btn:hover { color: #e63946; transform: scale(1.05); }

    /* QUICK ADD TO CART */
    .btn-quick-add { position: absolute; bottom: -50px; left: 50%; transform: translateX(-50%); width: 85%; background: rgba(255,255,255,0.95); color: #111; font-weight: 700; padding: 10px 0; border-radius: 30px; transition: all 0.4s ease; opacity: 0; font-size: 13px; text-transform: uppercase; border: 1px solid var(--anna-teal); z-index: 10;}
    .product-card:hover .btn-quick-add { bottom: 15px; opacity: 1; }
    /* Hover Nút thêm giỏ sẽ thành Xanh ngọc */
    .btn-quick-add:hover { background: var(--anna-teal); color: #fff; box-shadow: 0 5px 15px rgba(60, 179, 176, 0.3); } 

    /* [ĐÃ SỬA] PRICE TYPOGRAPHY */
    /* Giá gốc màu đen, gạch ngang mờ đi một chút để tôn giá đỏ lên */
    .price-old { font-size: 14px; color: #000; text-decoration: line-through; opacity: 0.7; font-weight: 500;} 
    .price-new { font-weight: 800; color: #dc3545; font-size: 17px;}
    .shop-toolbar { border-bottom: 1px solid #eee; padding-bottom: 15px; }

    /* LÀM ĐẸP PHÂN TRANG (PAGINATION) MÀU XANH ANNA */
    .pagination .active .page-link { background-color: var(--anna-teal); border-color: var(--anna-teal); color: #fff; }
    .pagination .page-link { color: var(--anna-teal); font-weight: 600; }
    .pagination .page-link:hover { background-color: #e9f7f6; color: var(--anna-teal-hover); }
</style>

<div class="container py-5">
    
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none hover-danger">Trang chủ</a></li>
            <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Sản phẩm</li>
        </ol>
    </nav>

    <div class="text-center mb-5 pb-3">
        <h2 class="page-title">Tất Cả Sản Phẩm</h2>
        <div class="title-line"></div>
    </div>

    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="filter-sidebar sticky-top" style="top: 100px;">
                <h5 class="filter-title">Danh mục</h5>
                
                <form action="{{ route('products.index') }}" method="GET">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div class="mb-4">
                        @foreach($categories as $category)
                            <div class="filter-item">
                                <input type="radio" name="category" id="cat{{ $category->id }}" value="{{ $category->id }}" {{ request('category') == $category->id ? 'checked' : '' }} onchange="this.form.submit()">
                                <label for="cat{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>

                    <h5 class="filter-title mt-4">Mức giá</h5>
                    <div class="mb-4 mt-3">
                        <div class="d-flex align-items-center input-group-price mb-2">
                            <button type="button" class="btn-step border-end" onclick="adjustPrice('min', -100000)"><i class="bi bi-dash"></i></button>
                            <input type="text" id="display_min_price" class="form-control text-center border-0 price-input" placeholder="Từ (VNĐ)" value="{{ request('min_price') ? number_format(request('min_price'), 0, ',', '.') : '' }}">
                            <input type="hidden" id="real_min_price" name="min_price" value="{{ request('min_price') }}">
                            <button type="button" class="btn-step border-start" onclick="adjustPrice('min', 100000)"><i class="bi bi-plus"></i></button>
                        </div>
                        
                        <div class="text-center text-muted small mb-2"><i class="bi bi-arrow-down"></i></div>

                        <div class="d-flex align-items-center input-group-price mb-3">
                            <button type="button" class="btn-step border-end" onclick="adjustPrice('max', -100000)"><i class="bi bi-dash"></i></button>
                            <input type="text" id="display_max_price" class="form-control text-center border-0 price-input" placeholder="Đến (VNĐ)" value="{{ request('max_price') ? number_format(request('max_price'), 0, ',', '.') : '' }}">
                            <input type="hidden" id="real_max_price" name="max_price" value="{{ request('max_price') }}">
                            <button type="button" class="btn-step border-start" onclick="adjustPrice('max', 100000)"><i class="bi bi-plus"></i></button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-teal w-100 rounded-pill fw-bold mb-2 py-3 mt-2 fs-6 shadow-sm">ÁP DỤNG LỌC</button>
                    @if(request('category') || request('min_price') || request('max_price'))
                        <a href="{{ route('products.index') }}" class="btn btn-light border w-100 rounded-pill py-2 text-decoration-none text-center d-block text-danger fw-medium mt-2 hover-danger">Xóa tất cả lọc</a>
                    @endif
                </form>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center shop-toolbar mb-4">
                <p class="mb-0 text-muted fw-medium">
                    <span class="text-dark fw-bold">{{ $products->total() }}</span> sản phẩm được tìm thấy
                </p>
                
                <form method="GET" class="d-flex align-items-center">
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                    @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif
                    
                    <select name="sort" class="form-select form-select-sm rounded-pill px-4 fw-medium py-2 shadow-sm" style="border: 1px solid #3cb3b0; color: #3cb3b0; cursor: pointer; min-width: 180px;" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Sắp xếp: Mới nhất</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Tăng dần</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Giảm dần</option>
                    </select>
                </form>
            </div>

            @if(request('category') || request('min_price') || request('max_price'))
            <div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom">
                <span class="text-muted small fw-semibold">Đang lọc theo:</span>
                @if(request('category'))
                    @php $catName = \App\Models\Category::find(request('category'))->name ?? 'Danh mục'; @endphp
                    <span class="badge bg-teal rounded-pill fw-normal px-3 py-2 shadow-sm">{{ $catName }}</span>
                @endif
                @if(request('min_price') || request('max_price'))
                    <span class="badge bg-teal rounded-pill fw-normal px-3 py-2 shadow-sm">
                        Từ {{ request('min_price') ? number_format(request('min_price'),0,',','.') . 'đ' : '0đ' }} 
                        đến {{ request('max_price') ? number_format(request('max_price'),0,',','.') . 'đ' : 'Max' }}
                    </span>
                @endif
            </div>
            @endif

            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-6 col-md-4 col-lg-3"> 
                        <div class="product-card h-100 shadow-sm border">
                            <div class="img-wrapper">
                                @php
                                    $likedProducts = session()->get('liked_products', []);
                                    $isLiked = in_array($product->id, $likedProducts);
                                @endphp
                                <button type="button" class="wishlist-btn btn-like" data-id="{{ $product->id }}">
                                    <i class="bi {{ $isLiked ? 'bi-heart-fill text-danger' : 'bi-heart' }} heart-icon" style="transition: transform 0.2s; pointer-events: none;"></i>
                                    <span class="fw-bold likes-count {{ $isLiked ? 'text-danger' : '' }}" style="pointer-events: none;">{{ number_format($product->likes_count ?? 0) }}</span>
                                </button>
                                
                                @if($product->is_featured)
                                    <span class="badge bg-dark text-white position-absolute shadow-sm border" style="top: 54px; left: 12px; z-index: 2; font-size: 11px; font-weight: 600;">HOT</span>
                                @endif

                                @if($product->sale_price)
                                    <div class="badge-sale shadow-sm">-{{ $product->discount_percent }}%</div>
                                @endif
                                
                                <a href="{{ route('products.show', $product->slug) }}" class="d-block">
                                    @php
                                        $imgUrl = 'https://placehold.co/500x500?text=No+Image';
                                        if (!empty($product->image_url)) {
                                            if (filter_var(trim($product->image_url), FILTER_VALIDATE_URL)) {
                                                $imgUrl = trim($product->image_url);
                                            } else {
                                                $imgUrl = asset('storage/' . $product->image_url);
                                            }
                                        }
                                    @endphp
                                    <img src="{{ $imgUrl }}?v={{ time() }}" class="product-img" alt="{{ $product->name }}">
                                    <img src="{{ $imgUrl }}?v={{ time() }}" class="product-img-hover" style="filter: brightness(0.85);" alt="{{ $product->name }}">
                                </a>
                                
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="ajax-add-to-cart">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-light btn-quick-add shadow-sm">Thêm vào giỏ</button>
                                </form>
                            </div>
                            
                            <div class="p-3 text-center">
                                <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
                                    <h6 class="fw-semibold mb-2 text-truncate" style="font-size:14px; transition: 0.2s;">
                                        {{ $product->name }}
                                    </h6>
                                </a>

                                <div class="small mb-2" style="font-size: 12px;">
                                    <span class="text-warning">★ {{ $product->rating }}</span> 
                                    <span class="text-muted ms-1">| Đã bán {{ number_format($product->sold, 0, ',', '.') }}</span>
                                </div>

                                <div class="d-flex justify-content-center align-items-baseline">
                                    @if($product->sale_price)
                                        <span class="price-old me-2">{{ $product->formatted_price }}</span>
                                        <span class="price-new">{{ $product->formatted_sale_price }}</span>
                                    @else
                                        <span class="price-new">{{ $product->formatted_price }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/2748/2748558.png" width="100" class="mb-3 opacity-50">
                        <h5 class="fw-bold text-muted">Không tìm thấy sản phẩm nào!</h5>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>

<script>
// 1. CHỨC NĂNG BỘ LỌC GIÁ ĐỊNH DẠNG VNĐ
function formatVND(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function parseVND(str) {
    return parseInt(str.toString().replace(/\./g, '')) || 0;
}

function adjustPrice(type, amount) {
    const hiddenInput = document.getElementById('real_' + type + '_price');
    const displayInput = document.getElementById('display_' + type + '_price');
    
    let currentValue = parseVND(hiddenInput.value || '0');
    let newValue = currentValue + amount;
    
    if (newValue < 0) newValue = 0; 
    
    hiddenInput.value = newValue === 0 ? '' : newValue;
    displayInput.value = newValue === 0 ? '' : formatVND(newValue);
}

document.querySelectorAll('.price-input').forEach(input => {
    input.addEventListener('input', function(e) {
        let rawValue = this.value.replace(/[^0-9]/g, '');
        let type = this.id.replace('display_', 'real_');
        document.getElementById(type).value = rawValue;
        this.value = rawValue ? formatVND(rawValue) : '';
    });
});

// 2. CHỨC NĂNG THẢ TIM AJAX
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = '{{ csrf_token() }}';
    const likeButtons = document.querySelectorAll('.btn-like');
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); 
            e.stopPropagation();
            
            const productId = this.getAttribute('data-id');
            const icon = this.querySelector('.heart-icon');
            const countSpan = this.querySelector('.likes-count');

            this.style.pointerEvents = 'none';

            fetch(`/products/${productId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(async response => {
                const isJson = response.headers.get('content-type')?.includes('application/json');
                const data = isJson ? await response.json() : null;
                if (!response.ok) throw new Error('Lỗi hệ thống thả tim');
                return data;
            })
            .then(data => {
                countSpan.textContent = data.likes_count;
                
                if(data.status === 'liked') {
                    icon.classList.replace('bi-heart', 'bi-heart-fill');
                    icon.classList.add('text-danger');
                    countSpan.classList.add('text-danger');
                    icon.style.transform = 'scale(1.4)';
                    setTimeout(() => icon.style.transform = 'scale(1)', 200);
                } else {
                    icon.classList.replace('bi-heart-fill', 'bi-heart');
                    icon.classList.remove('text-danger');
                    countSpan.classList.remove('text-danger');
                }
            })
            .catch(error => { console.error(error); })
            .finally(() => { this.style.pointerEvents = 'auto'; });
        });
    });
});
</script>
@endsection