<style>
    /* Bổ sung hiệu ứng Hover mượt mà cho Header */
    .navbar-nav .nav-link { transition: 0.3s ease; }
    .navbar-nav .nav-link:hover { color: #d68787 !important; transform: translateY(-2px); }
    .nav-icon-hover { transition: 0.3s; }
    .nav-icon-hover:hover { color: #d68787 !important; transform: scale(1.1); }
</style>

<div class="bg-dark text-white text-center py-2" style="font-size: 12px; font-weight: 600; letter-spacing: 1px;">
    MIỄN PHÍ ĐO MẮT | FREESHIP TOÀN QUỐC CHO ĐƠN TỪ 500K
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3 text-dark" href="{{ route('home') }}" style="letter-spacing: 3px;">
            ANNA
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav gap-4 text-uppercase fw-semibold" style="font-size: 13px;">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'text-danger' : 'text-dark' }}" href="{{ route('home') }}">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') ? 'text-danger' : 'text-dark' }}" href="{{ route('products.index') }}">Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('journey') ? 'text-danger' : 'text-dark' }}" href="{{ route('journey') }}">Hành trình tử tế</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('stores.*') ? 'text-danger' : 'text-dark' }}" href="{{ route('stores.index') }}">Cửa hàng</a>
                </li>
            </ul>
        </div>

        <div class="d-flex align-items-center gap-3">
            
            <div class="nav-item dropdown">
                <a class="nav-link text-dark fs-5 nav-icon-hover" href="#" id="searchDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-search"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end p-3 shadow-lg border-0" aria-labelledby="searchDropdown" style="width: 320px; border-radius: 12px; mt-3;">
                    <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control rounded-start-pill border-dark" placeholder="Tìm kính râm, gọng kim loại..." value="{{ request('search') }}" required>
                        <button type="submit" class="btn btn-dark rounded-end-pill px-3"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a class="nav-link text-dark fs-5 nav-icon-hover" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3" aria-labelledby="userDropdown" style="border-radius: 12px;">
                    @auth
                        <li><h6 class="dropdown-header text-dark fw-bold">Xin chào, {{ Auth::user()->name }}!</h6></li>
                        
                        @if(Auth::user()->role == 'admin')
                            <li><a class="dropdown-item py-2 text-primary fw-bold" href="{{ route('admin.dashboard') }}"><i class="bi bi-shield-lock me-2"></i>Trang Quản Trị</a></li>
                        @endif
                        
                        <li><a class="dropdown-item py-2" href="{{ route('profile.index') }}"><i class="bi bi-person-circle me-2"></i>Tài khoản của tôi</a></li>
                        
                        <li>
                            <a class="dropdown-item py-2 d-flex justify-content-between align-items-center" href="{{ route('profile.index') }}#orders-tab">
                                <span><i class="bi bi-box-seam me-2"></i>Đơn hàng</span>
                                @php
                                    // Đếm các đơn hàng đang active
                                    $activeOrders = \App\Models\Order::where('user_id', Auth::id())
                                        ->whereIn('status', ['pending', 'processing', 'shipped'])
                                        ->count();
                                @endphp
                                @if($activeOrders > 0)
                                    <span class="badge bg-danger rounded-pill" style="font-size: 10px;">{{ $activeOrders }}</span>
                                @endif
                            </a>
                        </li>
                        
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger fw-medium"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</button>
                            </form>
                        </li>
                   @else
                        <li><a class="dropdown-item py-2 fw-bold" href="{{ Route::has('login') ? route('login') : '#' }}"><i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập</a></li>
                        <li><a class="dropdown-item py-2" href="{{ Route::has('register') ? route('register') : '#' }}"><i class="bi bi-person-plus me-2"></i>Đăng ký</a></li>
                    @endauth
                </ul>
            </div>

            <a href="{{ route('cart.index') }}" class="nav-link text-dark fs-5 position-relative nav-icon-hover">
                <i class="bi bi-bag"></i>
                @php
                    $cartCount = 0;
                    if(session('cart')) {
                        foreach(session('cart') as $details) {
                            $cartCount += $details['quantity'];
                        }
                    }
                @endphp
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge" style="font-size: 9px; padding: 4px 6px;">
                    {{ $cartCount }}
                </span>
            </a>
            
        </div>
    </div>
</nav>