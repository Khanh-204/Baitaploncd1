<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kính Mắt Anna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; background: #f5f6fa; }
        /* Sidebar Styles */
        .sidebar { width: 260px; background: #111; min-height: 100vh; color: #fff; position: fixed; top: 0; left: 0; z-index: 100;}
        .sidebar-logo { font-weight: 800; font-size: 24px; padding: 20px; text-align: center; border-bottom: 1px solid #333; letter-spacing: 2px;}
        
        .nav-admin .nav-link { 
            color: #a0a0a0; 
            padding: 15px 25px; 
            font-weight: 500; 
            transition: 0.3s; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            border-left: 4px solid transparent;
        }

        /* Khi di chuột hoặc trang đang active sẽ sáng lên */
        .nav-admin .nav-link:hover, 
        .nav-admin .nav-link.active { 
            background: #222; 
            color: #fff !important; 
            border-left: 4px solid #fff; 
        }

        /* Main Content */
        .main-content { margin-left: 260px; min-height: 100vh; }
        .topbar { background: #fff; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: flex-end; align-items: center;}
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-logo">ANNA ADMIN</div>
        <ul class="nav flex-column nav-admin mt-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Tổng quan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                    <i class="bi bi-box-seam"></i> Quản lý Sản phẩm
                </a>
            </li>
            <li class="nav-item">
                 <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                    <i class="bi bi-receipt"></i> Quản lý Đơn hàng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.stores.*') ? 'active' : '' }}" href="{{ route('admin.stores.index') }}">
                    <i class="bi bi-shop"></i> Quản lý Cửa hàng
                </a>
            </li>
            
            <li class="nav-item mt-5">
                <a class="nav-link text-danger" href="{{ route('home') }}">
                    <i class="bi bi-arrow-left-circle"></i> Về cửa hàng
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="topbar mb-4">
            <div class="dropdown">
                <a href="#" class="text-dark text-decoration-none fw-bold dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-5 align-middle me-1"></i> Sếp {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger fw-bold">
                                <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="container-fluid px-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session('success'))
            Swal.fire({
                toast: true, 
                position: 'top-end', 
                icon: 'success',
                title: "{{ session('success') }}", 
                showConfirmButton: false, 
                timer: 3000,
                timerProgressBar: true,
            });
        @endif

        @if(session('error'))
            Swal.fire({
                toast: true, 
                position: 'top-end', 
                icon: 'error',
                title: "{{ session('error') }}", 
                showConfirmButton: false, 
                timer: 3000,
                timerProgressBar: true,
            });
        @endif
    });
</script>
</html>