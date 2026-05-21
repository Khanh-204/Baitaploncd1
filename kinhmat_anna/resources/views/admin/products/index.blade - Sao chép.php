@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Quản lý Sản phẩm</h3>
    <a href="{{ route('admin.products.create') }}" class="btn btn-dark fw-bold shadow-sm"><i class="bi bi-plus-lg me-1"></i> Thêm SP mới</a>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-3 shadow-sm border-0 animate__animated animate__fadeIn">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Tìm theo tên hoặc slug..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="category" class="form-select border-dark-subtle">
                    <option value="">-- Danh mục --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="stock_status" class="form-select border-dark-subtle">
                    <option value="">-- Trạng thái kho --</option>
                    <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Sắp hết hàng</option>
                    <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Đã hết hàng</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="sort" class="form-select border-dark-subtle">
                    <option value="">-- Sắp xếp --</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp -> Cao</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao -> Thấp</option>
                    <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Tồn kho giảm dần</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-dark w-100 fw-bold">LỌC</button>
                @if(request()->anyFilled(['search', 'category', 'stock_status', 'sort']))
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-danger" title="Xóa lọc"><i class="bi bi-arrow-counterclockwise"></i></a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3">ID</th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá bán</th>
                        <th>Tồn kho</th>
                        <th class="text-end pe-4">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $item)
                    <tr>
                        <td class="ps-4 fw-bold text-muted">#{{ $item->id }}</td>
                        <td>
                            <img src="{{ $item->image_url }}" class="rounded shadow-sm border" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td class="fw-semibold text-dark">{{ $item->name }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $item->category->name ?? 'N/A' }}</span></td>
                        <td class="text-danger fw-bold">
                            {{ $item->formatted_sale_price ?? $item->formatted_price }}
                        </td>
                        
                        <td>
                            @if($item->stock == 0)
                                <span class="badge bg-danger rounded-pill px-3">Hết hàng</span>
                            @elseif($item->stock < 10)
                                <span class="badge bg-warning text-dark rounded-pill px-3">Sắp hết ({{ $item->stock }})</span>
                            @else
                                <span class="badge bg-success rounded-pill px-3">Còn hàng ({{ $item->stock }})</span>
                            @endif
                        </td>
                        
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.products.edit', $item->id) }}" class="btn btn-sm btn-primary shadow-sm px-3" title="Chỉnh sửa">
                                <i class="bi bi-pencil-square me-1"></i> Sửa
                            </a>
                            
                            <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa [{{ $item->name }}] không? Dữ liệu không thể khôi phục!');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger px-3" title="Xóa">
                                    <i class="bi bi-trash me-1"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                            Không tìm thấy sản phẩm nào phù hợp.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card-footer bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <small class="text-muted">Hiển thị {{ $products->firstItem() }} - {{ $products->lastItem() }} trong tổng số {{ $products->total() }} sản phẩm</small>
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection