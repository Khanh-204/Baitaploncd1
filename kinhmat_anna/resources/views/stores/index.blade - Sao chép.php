@extends('layouts.app')

@section('content')
<style>
    /* 1. LÀM ĐẸP TIÊU ĐỀ CHUẨN ANNA (Dùng font Playfair sang trọng) */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&display=swap');

    .store-title-premium {
        font-family: 'Playfair Display', serif;
        font-weight: 800;
        font-size: 2.5rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #1a1a1a;
        position: relative;
        display: inline-block;
        margin-bottom: 2rem;
    }
    
    /* Đường gạch ngang màu xanh ngọc ở dưới chữ */
    .store-title-premium::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: #3cb3b0; 
        border-radius: 2px;
    }

    /* 2. KHẮC PHỤC LỖI BẢN ĐỒ ĐÈ MENU (Ép z-index xuống thấp) */
    .map-container-fix {
        position: relative;
        /* Ép layer bản đồ nằm thấp hẳn xuống để Menu của Header nổi lên trên */
        z-index: 1 !important; 
    }
    
    .map-container-fix iframe {
        width: 100%;
        position: relative;
        z-index: 1 !important; 
    }

    /* 3. CSS TÙY CHỈNH CHO DANH SÁCH CỬA HÀNG */
    .store-list-container { max-height: 600px; overflow-y: auto; padding-right: 10px; }
    .store-list-container::-webkit-scrollbar { width: 6px; }
    .store-list-container::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .store-list-container::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
    .store-list-container::-webkit-scrollbar-thumb:hover { background: #999; }
    
    .store-item { transition: all 0.3s ease; cursor: pointer; border: 2px solid transparent !important; }
    .store-item:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    .store-item.active { border-color: #000 !important; background-color: #f8f9fa !important; }
</style>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="store-title-premium text-center">Danh Sách Cửa Hàng</h2>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-light">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <select id="city-filter" class="form-select border-0 shadow-sm rounded-3 py-2 fw-medium">
                            <option value="">🗺️ Toàn quốc</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="position-relative">
                        <input type="text" id="search-input" class="form-control border-0 shadow-sm rounded-pill ps-4 py-2" placeholder="Tìm tên đường, tên chi nhánh...">
                        <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                    </div>
                </div>
            </div>

            <div id="store-list" class="store-list-container">
                @if($stores->isNotEmpty())
                    @foreach($stores as $index => $store)
                        <div class="card store-item border-0 shadow-sm rounded-4 mb-3 p-4 {{ $index == 0 ? 'active' : '' }}" 
                             data-map="{{ $store->map_url }}" onclick="changeMap(this)">
                            <h6 class="fw-bold text-uppercase mb-2 text-dark">{{ $store->name }}</h6>
                            <div class="d-flex align-items-start mb-2 text-muted small">
                                <i class="bi bi-geo-alt-fill me-2 mt-1 text-danger"></i>
                                <span>{{ $store->address }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2 text-muted small">
                                <i class="bi bi-telephone-fill me-2 text-success"></i>
                                <span>{{ $store->phone }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge bg-light text-dark border px-2 py-1"><i class="bi bi-clock me-1"></i>{{ $store->open_time }}</span>
                                <a href="tel:{{ $store->phone }}" class="btn btn-sm btn-dark rounded-pill px-3 shadow-sm" onclick="event.stopPropagation();">
                                    <i class="bi bi-telephone me-1"></i> Gọi điện
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-shop display-4 text-muted opacity-50 mb-3"></i>
                        <h6 class="text-muted">Hệ thống đang cập nhật danh sách cửa hàng.</h6>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-7">
            <div id="map-container" class="card map-container-fix border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 100px; height: 600px; background-color: #f8f9fa;">
                @if($stores->isNotEmpty())
                    <iframe id="store-map" 
                        src="{{ $stores->first()->map_url }}" 
                        width="100%" height="100%" style="border:0;" 
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                @else
                    <div class="d-flex h-100 align-items-center justify-content-center text-muted fw-bold">
                        Bản đồ sẽ hiển thị khi có dữ liệu cửa hàng
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    const cityFilter = document.getElementById('city-filter');
    const searchInput = document.getElementById('search-input');
    const storeListContainer = document.getElementById('store-list');
    const mapContainer = document.getElementById('map-container');
    let mapIframe = document.getElementById('store-map');

    // Hàm gọi API lấy dữ liệu
    function fetchStores() {
        let city = cityFilter.value;
        let search = searchInput.value;

        // Bật loading mờ mờ cho có hiệu ứng xịn
        storeListContainer.style.opacity = '0.5';

        fetch(`/stores/filter?city=${city}&search=${search}`)
            .then(response => response.json())
            .then(stores => {
                renderStores(stores);
                storeListContainer.style.opacity = '1';
            })
            .catch(error => {
                console.error('Lỗi khi lọc cửa hàng:', error);
                storeListContainer.style.opacity = '1';
            });
    }

    // Hàm vẽ lại danh sách cửa hàng
    function renderStores(stores) {
        storeListContainer.innerHTML = '';
        
        if (stores.length === 0) {
            storeListContainer.innerHTML = `
                <div class="text-center py-5">
                    <i class="bi bi-search display-4 text-muted opacity-25 mb-3"></i>
                    <h6 class="text-muted">Không tìm thấy cửa hàng nào phù hợp!</h6>
                </div>`;
            mapContainer.innerHTML = `<div class="d-flex h-100 align-items-center justify-content-center text-muted fw-bold">Không có dữ liệu bản đồ</div>`;
            return;
        }

        let html = '';
        stores.forEach((store, index) => {
            let activeClass = index === 0 ? 'active' : '';
            html += `
                <div class="card store-item border-0 shadow-sm rounded-4 mb-3 p-4 ${activeClass}" 
                     data-map="${store.map_url}" onclick="changeMap(this)">
                    <h6 class="fw-bold text-uppercase mb-2 text-dark">${store.name}</h6>
                    <div class="d-flex align-items-start mb-2 text-muted small">
                        <i class="bi bi-geo-alt-fill me-2 mt-1 text-danger"></i>
                        <span>${store.address}</span>
                    </div>
                    <div class="d-flex align-items-center mb-2 text-muted small">
                        <i class="bi bi-telephone-fill me-2 text-success"></i>
                        <span>${store.phone}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="badge bg-light text-dark border px-2 py-1"><i class="bi bi-clock me-1"></i>${store.open_time}</span>
                        <a href="tel:${store.phone}" class="btn btn-sm btn-dark rounded-pill px-3 shadow-sm" onclick="event.stopPropagation();">
                            <i class="bi bi-telephone me-1"></i> Gọi điện
                        </a>
                    </div>
                </div>
            `;
        });
        
        storeListContainer.innerHTML = html;

        // Vẽ lại bản đồ theo cửa hàng đầu tiên trong danh sách lọc
        mapContainer.innerHTML = `
            <iframe id="store-map" 
                src="${stores[0].map_url}" 
                width="100%" height="100%" style="border:0;" 
                allowfullscreen="" loading="lazy">
            </iframe>`;
        mapIframe = document.getElementById('store-map');
    }

    // Hàm đổi bản đồ khi click chuột
    window.changeMap = function(element) {
        let newMapUrl = element.getAttribute('data-map');
        if(mapIframe && newMapUrl) {
            mapIframe.src = newMapUrl;
        }
        let allStores = document.querySelectorAll('.store-item');
        allStores.forEach(store => store.classList.remove('active'));
        element.classList.add('active');
    };

    // Hàm Debounce chống request liên tục
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Gắn sự kiện thay đổi
    cityFilter.addEventListener('change', fetchStores);
    searchInput.addEventListener('input', debounce(fetchStores, 500)); 
</script>
@endsection