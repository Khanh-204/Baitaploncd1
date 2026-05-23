@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">Thêm Sản Phẩm Mới</h3>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark fw-bold"><i class="bi bi-arrow-left me-1"></i> Quay lại</a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-body p-4">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3" placeholder="Nhập tên kính..." required value="{{ old('name') }}">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Giá gốc (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control rounded-3" required value="{{ old('price') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Giá khuyến mãi (VNĐ)</label>
                            <input type="number" name="sale_price" class="form-control rounded-3" placeholder="Để trống nếu không giảm giá" value="{{ old('sale_price') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả sản phẩm</label>
                        <textarea name="description" class="form-control rounded-3" rows="4" placeholder="Viết vài dòng giới thiệu về sản phẩm này...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Danh mục <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select rounded-3" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Số lượng tồn kho <span class="text-danger">*</span></label>
                        <input type="number" name="stock" class="form-control rounded-3" value="{{ old('stock', 0) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Hình ảnh sản phẩm</label>
                        <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                        <div class="form-text text-muted small mt-1">Hỗ trợ JPG, PNG, WEBP. Tối đa 2MB.</div>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" {{ old('is_featured') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold text-danger" for="isFeatured">Đánh dấu HOT</label>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 fw-bold py-2 rounded-3 shadow-sm">LƯU SẢN PHẨM</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection