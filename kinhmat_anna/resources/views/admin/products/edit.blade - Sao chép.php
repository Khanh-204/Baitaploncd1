@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Chỉnh sửa: <span class="text-primary">{{ $product->name }}</span></h3>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark fw-bold shadow-sm"><i class="bi bi-arrow-left me-1"></i> Quay lại</a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-4">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Giá gốc (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control rounded-3" value="{{ old('price', $product->price) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Giá khuyến mãi (VNĐ)</label>
                            <input type="number" name="sale_price" class="form-control rounded-3" value="{{ old('sale_price', $product->sale_price) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả sản phẩm</label>
                        <textarea name="description" class="form-control rounded-3" rows="6">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light border-0 p-3 rounded-4 mb-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Danh mục <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select rounded-3">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Số lượng tồn kho <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control rounded-3" value="{{ old('stock', $product->stock) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Hình ảnh hiện tại</label>
                            <div class="mb-2">
                                <img src="{{ $product->image_url }}" class="rounded shadow-sm border" style="width: 100%; height: 200px; object-fit: cover;">
                            </div>
                            <label class="form-label fw-semibold small">Thay đổi ảnh mới (nếu muốn)</label>
                            <input type="file" name="image" class="form-control rounded-3">
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" {{ $product->is_featured ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-danger" for="isFeatured">Sản phẩm HOT</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-3 shadow">LƯU THAY ĐỔI</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection