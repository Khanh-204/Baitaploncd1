@extends('layouts.admin') 

@section('content')
<div class="container-fluid py-4">
    <a href="{{ route('admin.stores.index') }}" class="text-dark text-decoration-none fw-bold mb-4 d-inline-block">
        <i class="bi bi-arrow-left me-2"></i> Trở về danh sách
    </a>
    
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form action="{{ route('admin.stores.store') }}" method="POST">
                @csrf
                
                @if ($errors->any())
                    <div class="alert alert-danger shadow-sm rounded-3 mb-4 fw-medium">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <h5 class="fw-bold mb-4 text-uppercase" style="letter-spacing: 1px;"><i class="bi bi-info-circle me-2"></i>1. Thông tin chi nhánh</h5>
                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tên chi nhánh <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="VD: Kính Mắt Anna - Chùa Bộc" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Khu vực <span class="text-danger">*</span></label>
                            <select name="city" class="form-select" required>
                                <option value="">-- Chọn khu vực --</option>
                                <option value="Hà Nội" {{ old('city') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                <option value="TP.HCM" {{ old('city') == 'TP.HCM' ? 'selected' : '' }}>TP.HCM</option>
                                <option value="Vĩnh Phúc" {{ old('city') == 'Vĩnh Phúc' ? 'selected' : '' }}>Vĩnh Phúc</option>
                                <option value="Đà Nẵng" {{ old('city') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                <option value="Lào Cai" {{ old('city') == 'Lào Cai' ? 'selected' : '' }}>Lào Cai</option>
                                <option value="Hải Phòng" {{ old('city') == 'Hải Phòng' ? 'selected' : '' }}>Hải Phòng</option>
                                <option value="Cần Thơ" {{ old('city') == 'Cần Thơ' ? 'selected' : '' }}>Cần Thơ</option>
                                <option value="Khác" {{ old('city') == 'Khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="VD: Số 15 Chùa Bộc, Đống Đa..." required>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-4 text-uppercase border-top pt-4" style="letter-spacing: 1px;"><i class="bi bi-telephone me-2"></i>2. Thông tin liên hệ</h5>
                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">SĐT Hotline <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="phone-input" class="form-control" value="{{ old('phone') }}" placeholder="VD: 0987654321" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Giờ mở cửa <span class="text-danger">*</span></label>
                            <input type="text" name="open_time" class="form-control" value="{{ old('open_time', '09:00 - 22:00') }}" placeholder="VD: 09:00 - 22:00" required>
                        </div>
                    </div>

                    <h5 class="fw-bold mb-4 text-uppercase border-top pt-4" style="letter-spacing: 1px;"><i class="bi bi-map me-2"></i>3. Định vị Bản đồ</h5>
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Link Embed Google Maps <span class="text-danger">*</span></label>
                            <input type="text" name="map_url" id="map-input" class="form-control" value="{{ old('map_url') }}" placeholder="Dán link bắt đầu bằng https://..." required>
                            <small class="text-muted fst-italic mt-2 d-block">Mẹo: Lên Google Maps > Tìm địa chỉ > Nút Chia sẻ > Nhúng bản đồ > Copy link trong thẻ src="..."</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold mb-2">Xem trước bản đồ (Preview)</label>
                            <div class="border rounded-4 overflow-hidden bg-light d-flex align-items-center justify-content-center" style="height: 350px;">
                                <iframe id="map-preview" src="{{ old('map_url') }}" width="100%" height="100%" style="border:0; {{ old('map_url') ? '' : 'display: none;' }}" allowfullscreen="" loading="lazy"></iframe>
                                <div id="map-placeholder" class="text-muted fw-medium" style="{{ old('map_url') ? 'display: none;' : '' }}">
                                    <i class="bi bi-geo-alt display-4 d-block text-center mb-2"></i>
                                    Bản đồ sẽ hiển thị tại đây khi Sếp dán link
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mb-5">
                    <button type="submit" class="btn btn-dark px-5 py-3 fw-bold rounded-pill shadow-sm fs-5">
                        <i class="bi bi-save me-2"></i> LƯU CHI NHÁNH
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mapInput = document.getElementById('map-input');
        const mapPreview = document.getElementById('map-preview');
        const mapPlaceholder = document.getElementById('map-placeholder');

        const defaultPlaceholderHtml = `
            <i class="bi bi-geo-alt display-4 d-block text-center mb-2"></i>
            Bản đồ sẽ hiển thị tại đây khi Sếp dán link
        `;

        mapInput.addEventListener('input', function() {
            let val = this.value.trim();
            
            if (!val) {
                mapPreview.style.display = 'none';
                mapPlaceholder.innerHTML = defaultPlaceholderHtml;
                mapPlaceholder.style.display = 'block';
                return;
            }

            // AUTO-EXTRACT: Nếu Sếp lỡ dán cả cục <iframe src="...">, hệ thống tự động bóc lấy link
            let iframeMatch = val.match(/src="([^"]+)"/);
            if (iframeMatch) {
                val = iframeMatch[1]; // Lấy đường link bên trong chữ src=""
                this.value = val;     // Tự động dọn dẹp luôn ô nhập liệu cho Sếp
            }

            // Kiểm tra xem có phải link nhúng (embed) chuẩn của Google Maps không
            if(val.includes('google.com/maps/embed')) {
                mapPreview.src = val;
                mapPreview.style.display = 'block';
                mapPlaceholder.style.display = 'none';
            } else {
                mapPreview.style.display = 'none';
                mapPlaceholder.innerHTML = `
                    <div class="text-danger text-center">
                        <i class="bi bi-exclamation-triangle-fill display-4 d-block mb-2"></i>
                        <h6 class="fw-bold">LỖI: ĐÂY KHÔNG PHẢI LINK NHÚNG (EMBED)</h6>
                        <small>Vui lòng lấy link trong tab "Nhúng bản đồ", phải chứa chữ <b>google.com/maps/embed</b></small>
                    </div>
                `;
                mapPlaceholder.style.display = 'block';
            }
        });

        const phoneInput = document.getElementById('phone-input');
        phoneInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
</script>
@endsection