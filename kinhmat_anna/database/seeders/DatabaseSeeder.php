<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ===== 1. TẠO DANH MỤC =====
        $kimLoai = Category::create([
            'name' => 'Gọng Kính Kim Loại',
            'slug' => 'gong-kim-loai',
            'description' => 'Thanh lịch, nhẹ, phù hợp dân văn phòng'
        ]);

        $kinhRam = Category::create([
            'name' => 'Kính Râm Thời Trang',
            'slug' => 'kinh-ram',
            'description' => 'Chống UV, thời trang cao cấp'
        ]);

        $nhua = Category::create([
            'name' => 'Gọng Kính Nhựa Dẻo',
            'slug' => 'gong-nhua',
            'description' => 'Trẻ trung, giá tốt, dễ phối đồ'
        ]);

        $trong = Category::create([
            'name' => 'Tròng Kính & Phụ Kiện',
            'slug' => 'trong-kinh',
            'description' => 'Bảo vệ mắt, chống ánh sáng xanh'
        ]);

        // ===== 2. DATA SẢN PHẨM CHUẨN LOGIC =====
        $products = [
            // KIM LOẠI (Phân khúc Trung - Cao cấp)
            [
                'name' => 'Gọng Titan Siêu Nhẹ T100',
                'category_id' => $kimLoai->id,
                'price' => 850000,
                'image' => 'https://images.unsplash.com/photo-1582142306909-195724d33ffc?w=500',
                'desc' => 'Gọng titan cao cấp siêu nhẹ, chống gỉ, phù hợp dân văn phòng.'
            ],
            [
                'name' => 'Gọng Tròn Vintage Classic',
                'category_id' => $kimLoai->id,
                'price' => 450000,
                'image' => 'https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=500',
                'desc' => 'Phong cách cổ điển, phù hợp học sinh sinh viên.'
            ],
            [
                'name' => 'Gọng Kim Loại Hàn Quốc Slim',
                'category_id' => $kimLoai->id,
                'price' => 650000,
                'image' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=500',
                'desc' => 'Thiết kế mảnh, nhẹ, phong cách Hàn Quốc.'
            ],

            // KÍNH RÂM (Phân khúc Cao cấp, ảnh Lifestyle)
            [
                'name' => 'Kính Râm Chống UV400 R05',
                'category_id' => $kinhRam->id,
                'price' => 950000,
                'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=500',
                'desc' => 'Chống tia UV400, thiết kế thời thượng, phù hợp đi biển, du lịch.'
            ],
            [
                'name' => 'Kính Mát Thời Trang Oversize',
                'category_id' => $kinhRam->id,
                'price' => 1200000,
                'image' => 'https://images.unsplash.com/photo-1509695507497-903c140c43b0?w=500',
                'desc' => 'Form lớn, phong cách thời trang cao cấp che khuyết điểm khuôn mặt.'
            ],
            [
                'name' => 'Kính Râm Nam Polarized',
                'category_id' => $kinhRam->id,
                'price' => 1100000,
                'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=500',
                'desc' => 'Tròng kính phân cực chống chói, phù hợp lái xe đường dài.'
            ],

            // NHỰA (Phân khúc Giá rẻ, Trẻ trung)
            [
                'name' => 'Gọng Nhựa Dẻo Basic Đen',
                'category_id' => $nhua->id,
                'price' => 300000,
                'image' => 'https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=500',
                'desc' => 'Giá rẻ, siêu bền, chịu va đập tốt, phù hợp học sinh.'
            ],
            [
                'name' => 'Gọng Nhựa Trong Suốt HQ',
                'category_id' => $nhua->id,
                'price' => 380000,
                'image' => 'https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=500',
                'desc' => 'Phong cách trong suốt trẻ trung, đang là hot trend hiện nay.'
            ],
            [
                'name' => 'Gọng Nhựa Vuông Cá Tính',
                'category_id' => $nhua->id,
                'price' => 350000,
                'image' => 'https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?w=500',
                'desc' => 'Form vuông cá tính, dễ phối đồ, phù hợp mặt tròn.'
            ],

            // TRÒNG KÍNH (Ảnh cận cảnh)
            [
                'name' => 'Tròng Chống Ánh Sáng Xanh',
                'category_id' => $trong->id,
                'price' => 650000,
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500',
                'desc' => 'Bảo vệ mắt tối đa khi dùng máy tính, điện thoại thời gian dài.'
            ],
            [
                'name' => 'Tròng Đổi Màu Đi Nắng',
                'category_id' => $trong->id,
                'price' => 1100000,
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500',
                'desc' => 'Ra nắng tự đổi màu thành kính râm, chống UV tuyệt đối.'
            ],
            [
                'name' => 'Tròng Cận Siêu Mỏng 1.67',
                'category_id' => $trong->id,
                'price' => 1500000,
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500',
                'desc' => 'Dành cho người cận nặng, siêu mỏng nhẹ, hạn chế tăng độ.'
            ],
        ];

        // ===== 3. INSERT DATA KÈM LOGIC BÁN HÀNG =====
        foreach ($products as $p) {
            
            // Logic tạo Giá Sale ngẫu nhiên (50% cơ hội giảm từ 10% - 30%)
            $hasSale = rand(0, 1);
            $salePrice = $hasSale ? ($p['price'] * (rand(70, 90) / 100)) : null; 

            Product::create([
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'category_id' => $p['category_id'],
                'price' => $p['price'],
                'image' => $p['image'],
                'description' => $p['desc'], // Đã map đúng cột mô tả chi tiết
                'stock' => rand(20, 100),
                
                // Các trường dữ liệu E-commerce thực tế
                'sale_price' => $salePrice,
                'is_featured' => rand(0, 1), 
                'sold' => rand(50, 1500), 
                'rating' => rand(40, 50) / 10 
            ]);
        }
    }
}