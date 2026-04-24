<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kính Mắt Anna - Thương Hiệu Kính Mắt Của Sự Tử Tế</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; color: #333; }
        a { text-decoration: none; color: inherit; transition: 0.3s; }
        a:hover { color: #f0a8a8; }
        /* CSS cho Slider và Card */
        .carousel-item img { height: 75vh; object-fit: cover; }
        .product-img { transition: transform 0.5s ease; object-fit: cover; aspect-ratio: 1/1; }
        .product-card:hover .product-img { transform: scale(1.05); }
    </style>
</head>
<body>

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tìm tất cả các form có class 'ajax-add-to-cart'
            const addToCartForms = document.querySelectorAll('.ajax-add-to-cart');

            addToCartForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Chặn hành vi load lại trang

                    const formData = new FormData(this);
                    const url = this.getAttribute('action');

                    // Gửi request ngầm lên Server
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest', // Báo cho Laravel biết đây là AJAX
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            // Hiện thông báo góc phải màn hình
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 2000, // Tự tắt sau 2 giây
                                timerProgressBar: true,
                            });

                            // Nâng cao: Cập nhật số lượng trên icon giỏ hàng ở thanh Menu (nếu bạn có class .cart-badge)
                            const cartBadge = document.querySelector('.cart-badge');
                            if(cartBadge) cartBadge.innerText = data.cart_count;
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
</body>
</html>