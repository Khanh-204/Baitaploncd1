@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Playfair+Display:ital,wght@0,700;1,700&display=swap');

    /* TỔNG QUAN */
    body { background-color: #1a1a1a; } /* Set nền tối tổng thể cho mượt */
    .anna-teal-text { color: #85d6c3 !important; }

    /* HERO BANNER */
    .hero-journey {
        background: url('https://kinhmatanna.com/_next/image?url=https%3A%2F%2Fcms.kinhmatanna.com%2Fwp-content%2Fuploads%2F2024%2F07%2Fbanner_desktop.jpg&w=3840&q=75') no-repeat center 30%;
        background-size: cover; height: 85vh; min-height: 600px;
        display: flex; align-items: center; margin-top: -20px; position: relative;
    }
    .hero-overlay-custom {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to right, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.1) 100%);
    }
    .hero-content { position: relative; z-index: 2; padding-left: 5%; }
    .title-serif { font-family: 'Playfair Display', serif; font-size: 5rem; color: #85d6c3; line-height: 0.95; letter-spacing: 2px; }
    .title-script { font-family: 'Dancing Script', cursive; font-size: 7.5rem; color: #85d6c3; line-height: 0.8; margin-left: 50px; position: relative; }
    .title-script::before { content: ''; position: absolute; bottom: 25px; left: -60px; width: 50px; height: 3px; background-color: #85d6c3; border-radius: 5px; }
    .title-by { font-family: 'Montserrat', sans-serif; font-size: 1.5rem; color: #fff; font-style: italic; font-weight: 600; margin-left: 200px; margin-top: -15px; }

    /* CÁC HOẠT ĐỘNG CHÍNH (CHUẨN WEB GỐC) */
    .activities-section { background-color: #71b9a5; padding: 100px 0; }
    .activity-btn { border: 1px solid rgba(255,255,255,0.5); color: #fff; border-radius: 50px; padding: 8px 24px; font-size: 14px; transition: 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
    .activity-btn:hover { background: #fff; color: #71b9a5; }
    .dark-card { background-color: #222; border-radius: 24px; padding: 40px; color: #fff; height: 100%; display: flex; flex-direction: column; transition: 0.3s; border: none; }
    .dark-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
    .dark-card img { border-radius: 16px; object-fit: cover; width: 100%; height: 250px; margin-top: 30px; }

    /* LÁ LÀNH ĐÙM LÁ RÁCH */
    .stats-section { background-color: #fcfcfc; padding: 90px 0; }
    .stat-number { font-size: 55px; font-weight: 800; color: #111; margin-bottom: 5px; }
    .stat-title { font-size: 15px; color: #000; font-weight: 700; text-transform: uppercase; margin-bottom: 10px; }

    /* CHIA SẺ VỀ HÀNH TRÌNH */
    .testimonial-section { background-color: #4a534c; padding: 120px 0; color: #fff; overflow: hidden; }
    .testi-img-grid { display: flex; align-items: center; gap: 15px; justify-content: center; }
    .testi-img-1 { width: 30%; height: 250px; object-fit: cover; border-radius: 20px; opacity: 0.8; }
    .testi-img-2 { width: 40%; height: 450px; object-fit: cover; border-radius: 24px; z-index: 2; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
    .testi-img-3 { width: 30%; height: 300px; object-fit: cover; border-radius: 20px; opacity: 0.8; }
    .play-btn-overlay { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: rgba(255,255,255,0.8); font-size: 60px; z-index: 3; transition: 0.3s; cursor: pointer; }
    .play-btn-overlay:hover { color: #fff; transform: translate(-50%, -50%) scale(1.1); }
    .quote-mark { font-size: 100px; color: #85d6c3; opacity: 0.3; position: absolute; top: -40px; right: 0; font-family: serif; line-height: 1; }

    /* ĐỐI TÁC & KẾT NỐI */
    .partner-section { background-color: #1e1e1e; padding: 80px 0; color: #fff; }
    .partner-circle { width: 140px; height: 140px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 20px; transition: 0.3s; }
    .partner-circle:hover { transform: scale(1.05); }
    .partner-circle img { max-width: 100%; max-height: 100%; object-fit: contain; }
</style>

<div class="hero-journey">
    <div class="hero-overlay-custom"></div>
    <div class="container hero-content">
        <div class="mb-4">
            <div class="title-serif">Hành</div>
            <div class="title-serif ms-5">trình</div>
            <div class="title-script">Tử tế</div>
            <div class="title-by">by Anna</div>
        </div>
        <p class="fs-6 text-white fw-medium" style="line-height: 1.9; max-width: 550px;">
            Là một dự án phi lợi nhuận hướng đến cộng đồng và xã hội, chúng mình mong muốn <strong class="anna-teal-text">lan toả giá trị nhân ái</strong>, tiếp thêm động lực cộng đồng, và cùng nhau tiến về phía <strong class="anna-teal-text">tương lai tốt đẹp hơn.</strong>
        </p>
    </div>
</div>

<div class="activities-section">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 pb-3">
            <div>
                <h2 class="display-5 fw-bold text-white mb-2" style="letter-spacing: -1px;">Các Hoạt Động Chính</h2>
                <p class="text-white opacity-75 fs-5">"Hành Trình Tử Tế" được khởi hành với 3 nhóm hoạt động chính</p>
            </div>
            <a href="#" class="activity-btn mt-3 mt-md-0">Cộng đồng sống tử tế <i class="bi bi-chevron-right"></i></a>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="dark-card">
                    <h2 class="fw-bold mb-3">Đôi Mắt Mặt Trời</h2>
                    <p class="opacity-75" style="line-height: 1.8; font-size: 15px;">
                        Tài trợ các ca mổ mắt dị tật bẩm sinh cho các em nhỏ có hoàn cảnh khó khăn
                    </p>
                    <img src="https://kinhmatanna.com/_next/image?url=https%3A%2F%2Fcms.kinhmatanna.com%2Fwp-content%2Fuploads%2F2024%2F07%2Feye.jpg&w=1200&q=75" alt="Đôi mắt mặt trời" class="mt-auto">
                </div>
            </div>
            <div class="col-md-6">
                <div class="dark-card">
                    <h2 class="fw-bold mb-3">Túi Tử Tế</h2>
                    <p class="opacity-75" style="line-height: 1.8; font-size: 15px;">
                        Anna sẽ in 1,000,000 chiếc túi tử tế nhằm lan toả câu chuyện tìm người thân thất lạc, cùng hy vọng phép màu sẽ xảy ra.
                    </p>
                    <img src="https://kinhmatanna.com/_next/image?url=https%3A%2F%2Fcms.kinhmatanna.com%2Fwp-content%2Fuploads%2F2024%2F07%2Faction.png&w=1200&q=75" alt="Túi tử tế" class="mt-auto">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="stats-section text-center">
    <div class="container">
        <h2 class="fw-bold text-uppercase mb-3" style="letter-spacing: 2px;">Lá Lành Đùm Lá Rách</h2>
        <p class="text-muted mx-auto mb-5 pb-3" style="max-width: 650px; line-height: 1.8;">
            Chuyến hành trình của “Hành trình tử tế by Anna” sẽ luôn tiếp tục tiến về phía trước. Chúng mình rất mong sự chung tay giúp sức của tất cả các bạn.
        </p>
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <div class="stat-number">30</div>
                <div class="stat-title">EM NHỎ</div>
                <p class="text-muted small">Được tài trợ chi phí phẫu thuật mắt</p>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">1.000.000</div>
                <div class="stat-title">TÚI TỬ TẾ</div>
                <p class="text-muted small">Được phát tặng tìm người thân thất lạc</p>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">1.046</div>
                <div class="stat-title">LƯỢT CHIA SẺ</div>
                <p class="text-muted small">Các câu chuyện của Hành trình Tử tế</p>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-number">7</div>
                <div class="stat-title">TỈNH THÀNH</div>
                <p class="text-muted small">Hành trình Tử tế có mặt</p>
            </div>
        </div>
    </div>
</div>

<div class="testimonial-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="testi-img-grid">
                    <img src="https://kinhmatanna.com/_next/image?url=https%3A%2F%2Fcms.kinhmatanna.com%2Fwp-content%2Fuploads%2F2024%2F01%2F401736895_184805081364216_1953410982539591792_n.jpg&w=828&q=75" class="testi-img-1">
                    <div class="position-relative" style="width: 40%;">
                        <img src="https://kinhmatanna.com/_next/image?url=%2Fimg%2Fhttt%2Fstory1.png&w=828&q=75" class="testi-img-2 w-100">
                        <i class="bi bi-play-circle play-btn-overlay"></i>
                    </div>
                    <img src="https://kinhmatanna.com/_next/image?url=https%3A%2F%2Fcms.kinhmatanna.com%2Fwp-content%2Fuploads%2F2024%2F01%2Fimage3.png&w=828&q=75" class="testi-img-3">
                </div>
            </div>
            
            <div class="col-lg-6 position-relative ps-lg-5 text-center text-lg-start">
                <div class="quote-mark">"</div>
                <h2 class="display-4 fw-bold anna-teal-text mb-5">Chia Sẻ Về Hành Trình</h2>
                
                <h4 class="fw-bold mb-1">Tun Phạm</h4>
                <p class="font-italic opacity-75 mb-4">Diễn viên, 24 tuổi</p>
                
                <h5 class="fw-bold mb-3 fs-4" style="line-height: 1.5;">Hành trình này cần được kéo dài mãi</h5>
                <p class="opacity-75 fs-6" style="line-height: 1.8; text-align: justify;">
                    Tun sẽ không bao giờ dừng lại trên Hành trình Tử tế by Anna, đây là một hành trình nhân ái, tiếp sức cộng đồng đầy ý nghĩa và cần được nối dài mãi mãi để mang lại hy vọng cho những hoàn cảnh kém may mắn.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="partner-section text-center">
    <div class="container">
        <h2 class="fw-bold mb-5" style="letter-spacing: 1px;">Những đối tác đồng hành trên <br><span class="anna-teal-text">Hành trình tử tế</span></h2>
        
        <div class="d-flex justify-content-center align-items-center gap-4 gap-md-5 flex-wrap">
            <div class="partner-circle">
                <h4 class="fw-bold text-dark m-0" style="font-family: 'Dancing Script', cursive; line-height: 0.8;">Hành Trình Tử Tế<br><span style="font-family: sans-serif; font-size: 12px;"> by Anna</span></h4>
            </div>
            <div class="partner-circle">
                <img src="data:image/jpeg;base64,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">
            </div>
            <div class="partner-circle">
                <img src="https://kinhmatanna.com/_next/image?url=https%3A%2F%2Fcms.kinhmatanna.com%2Fwp-content%2Fuploads%2F2024%2F07%2Fdgm_nttt_vnio_icon.png&w=384&q=75" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
            </div>
        </div>
    </div>
</div>

@endsection