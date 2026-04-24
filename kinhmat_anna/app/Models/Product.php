<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Cho phép thêm dữ liệu vào các cột này (Đã bổ sung các cột E-commerce mới)
    protected $fillable = [
        'name', 'slug', 'category_id', 'price', 'description', 'image', 'stock',
        'sale_price', 'is_featured', 'sold', 'rating'
    ];

    // Mối quan hệ: Một sản phẩm thuộc về một danh mục
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ==========================================
    // CÁC HÀM ACCESSOR (TỰ ĐỘNG XỬ LÝ LOGIC)
    // ==========================================

    // Định dạng giá gốc (VD: 850.000đ)
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.') . 'đ';
    }

    // Định dạng giá Sale (nếu có)
    public function getFormattedSalePriceAttribute()
    {
        return $this->sale_price ? number_format($this->sale_price, 0, ',', '.') . 'đ' : null;
    }

    // Tự động tính % giảm giá
    public function getDiscountPercentAttribute()
    {
        if (!$this->sale_price || $this->price == 0) return 0;
        return round(100 - ($this->sale_price / $this->price * 100));
    }

    // Xử lý link ảnh thông minh (chống gãy link)
    public function getImageUrlAttribute()
    {
        if (!$this->image) return 'https://placehold.co/500x500?text=No+Image';
        $cleanImg = trim($this->image);
        return str_starts_with($cleanImg, 'http') ? $cleanImg : asset('storage/' . $cleanImg);
    }
}