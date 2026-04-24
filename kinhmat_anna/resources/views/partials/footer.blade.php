<style>
    /* CSS FOOTER THEME MÀU XÁM KÍNH MẮT ANNA (#dedddb) */
    .footer-dark { background-color: #dedddb; color: #000000; padding: 60px 0 20px; font-family: 'Montserrat', sans-serif; }
    .footer-dark a { color: #333333; text-decoration: none; font-size: 13px; transition: 0.3s; display: block; margin-bottom: 10px; font-weight: 500;}
    .footer-dark a:hover { color: #3cb3b0; }
    .footer-title { font-size: 16px; font-weight: 700; margin-bottom: 20px; color: #000000; text-transform: uppercase; }
    
    .btn-teal { background-color: #3cb3b0; color: #ffffff; border: none; padding: 10px 24px; font-weight: 600; text-transform: uppercase; font-size: 13px; transition: 0.3s; border-radius: 8px; }
    .btn-teal:hover { background-color: #2c8c89; color: #fff; }
    
    .social-icons a { display: inline-block; color: #444444; font-size: 28px; margin-right: 15px; transition: 0.3s; }
    .social-icons a:hover { color: #3cb3b0; }
    
    .footer-bottom { border-top: 1px solid rgba(0,0,0,0.1); margin-top: 40px; padding-top: 20px; font-size: 12px; color: #555555; }

    /* CSS RIÊNG CHO MODAL GÓP Ý (NỀN TRẮNG - CHỮ ĐEN) */
    .custom-modal-dark .modal-content { background-color: #ffffff; color: #000000; border: none; border-radius: 16px; box-shadow: 0 20px 50px rgba(0,0,0,0.15); } 
    .custom-modal-dark .modal-header { border-bottom: 1px solid rgba(0,0,0,0.05); padding: 20px 25px; } 
    .custom-modal-dark .modal-footer { border-top: none; padding: 0 25px 25px; }
    
    /* Input nền xám nhạt, chữ đen */
    .dark-input { background-color: #f9f9f9; border: 1px solid #dddddd; color: #000000; padding: 12px 15px; border-radius: 10px; transition: 0.3s; } 
    .dark-input:focus { background-color: #ffffff; border-color: #3cb3b0; color: #000000; box-shadow: 0 0 0 4px rgba(60, 179, 176, 0.15); outline: none; } 
    .dark-input::placeholder { color: #999999; font-size: 13px; }
    
    .btn-teal-outline { border: 1px solid #dddddd; color: #555555; background: transparent; padding: 10px 20px; border-radius: 10px; font-weight: 600; transition: 0.3s; }
    .btn-teal-outline:hover { background: #f1f1f1; color: #000000; } 
    .btn-teal-solid { background: #3cb3b0; color: #ffffff; border: none; padding: 10px 30px; border-radius: 10px; font-weight: 600; transition: 0.3s; } 
    .btn-teal-solid:hover { background: #2c8c89; transform: translateY(-2px); } 
</style>

<footer class="footer-dark">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-title">Góp ý</h5>
                <p style="font-size: 13px; color: #555555; line-height: 1.6; margin-bottom: 20px;">
                    Anna luôn lắng nghe để tốt hơn mỗi ngày. Hãy để lại góp ý để chúng tôi cải thiện sản phẩm và dịch vụ.
                </p>
                <button type="button" class="btn-teal" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                    ĐÓNG GÓP Ý KIẾN
                </button>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="footer-title">Hotline</h5>
                <p class="fw-bold fs-4 text-dark mb-4">1900 0359</p>
                <h5 class="footer-title">Email</h5>
                <p class="fw-bold" style="font-size: 15px; color: #3cb3b0;">marketing@kinhmatanna.com</p>
                <div class="social-icons mt-4">
                    <a href="tel:0989310104" title="Gọi ngay"><i class="bi bi-telephone-fill"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=61566285841160" target="_blank" title="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="https://kinhmatanna.com/" title="Website"><i class="bi bi-globe"></i></a>
                    <a href="https://www.instagram.com/ng_quoc.khanh/?hl=vi" target="_blank" title="Instagram"><i class="bi bi-instagram"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="footer-title">Giới thiệu</h5>
                <p style="font-size: 12px; color: #555555; line-height: 1.8;">
                    <strong class="text-dark">CÔNG TY CỔ PHẦN JQK</strong><br>
                    Địa chỉ: Số 320 Xuân Phương, Từ Liêm, Hà Nội<br>
                    Người đại diện: NGUYỄN QUỐC KHÁNH<br>
                    Mã số doanh nghiệp: 0110489312
                </p>
            </div>

           <div class="col-lg-3 col-md-6 d-flex gap-5">
                <div>
                    <h5 class="footer-title">Chính sách</h5>
                    <a href="{{ route('policy.payment') }}">Chính sách thanh toán</a>
                    <a href="{{ route('policy.warranty') }}">Chính sách bảo hành, đổi trả</a>
                    <a href="{{ route('policy.shipping') }}">Chính sách vận chuyển</a>
                    <a href="{{ route('policy.privacy') }}">Chính sách bảo mật</a>
                </div>
                <div>
                    <h5 class="footer-title">Danh mục</h5>
                    <a href="{{ route('products.index', ['category' => 1]) }}">Gọng Kính</a>
                    <a href="{{ route('products.index', ['category' => 3]) }}">Tròng Kính</a>
                    <a href="{{ route('products.index', ['category' => 2]) }}">Kính râm</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom text-center">
            <p class="m-0">© 2026 Anna Eyewear. Designed by JQK. Bản quyền thuộc về JQK.</p>
        </div>
    </div>
</footer>

<div class="modal fade custom-modal-dark" id="feedbackModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="color: #3cb3b0;">
                    <i class="bi bi-chat-right-heart-fill me-2"></i> Gửi góp ý cho Anna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('feedback.send') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">Họ và tên của bạn <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control dark-input" required placeholder="VD: Nguyễn Văn A">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-dark">Số điện thoại (Không bắt buộc)</label>
                        <input type="text" name="phone" class="form-control dark-input" placeholder="VD: 0989xxxxxx">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-dark">Nội dung góp ý <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control dark-input" rows="4" required placeholder="Bạn muốn Anna cải thiện điều gì..."></textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end gap-2">
                    <button type="button" class="btn-teal-outline" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn-teal-solid"><i class="bi bi-send-fill me-2"></i> GỬI GÓP Ý</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: '#ffffff', /* Đổi popup báo thành công sang nền trắng */
            color: '#000000',      /* Chữ đen */
            iconColor: '#3cb3b0'
        });
    });
</script>
@endif