<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::query();

        // ==========================================
        // MỚI THÊM: XỬ LÝ TÌM KIẾM
        // ==========================================
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        // ==========================================

        // Lọc theo Danh mục
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Lọc theo Giá
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sắp xếp
        if ($request->sort) {
            if ($request->sort == 'price_asc') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort == 'price_desc') {
                $query->orderBy('price', 'desc');
            } else {
                $query->latest(); // Mới nhất
            }
        } else {
            $query->latest();
        }

        // CHÚ Ý CHỖ NÀY: Để 8 hoặc 12 thì thanh phân trang mới hiện ra 
        // (vì tổng kho đang có 15 cái kính)
        $products = $query->paginate(8); 

        return view('products.index', compact('categories', 'products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        
        // Lấy 4 sản phẩm liên quan (cùng danh mục, khác sản phẩm hiện tại)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder() // Lấy ngẫu nhiên cho phong phú
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
// Xử lý Thả tim / Bỏ tim bằng Session (Có tự động cứu hộ dữ liệu)
    public function toggleLike($id)
    {
        try {
            $product = \App\Models\Product::findOrFail($id);

            // [QUAN TRỌNG] Tự động sửa lỗi: Nếu sản phẩm cũ bị rỗng tim (NULL), ép nó về 0
            if (is_null($product->likes_count)) {
                $product->likes_count = 0;
                $product->save();
            }

            $likedProducts = session()->get('liked_products', []);

            if (in_array($id, $likedProducts)) {
                // Khách đã thả tim -> Bấm lần nữa là Bỏ tim (Trừ 1)
                if ($product->likes_count > 0) {
                    $product->decrement('likes_count');
                }
                $likedProducts = array_diff($likedProducts, [$id]);
                $status = 'unliked';
            } else {
                // Khách chưa thả tim -> Cộng 1
                $product->increment('likes_count');
                $likedProducts[] = $id;
                $status = 'liked';
            }

            // Lưu lại bộ nhớ Session
            session()->put('liked_products', $likedProducts);

            // Tải lại dữ liệu kính mắt mới nhất từ Database
            $product->refresh();

            return response()->json([
                'status' => $status,
                // Ép kiểu (int) để đảm bảo không bao giờ bị lỗi format số
                'likes_count' => number_format((int) $product->likes_count) 
            ]);

        } catch (\Exception $e) {
            // Nếu có lỗi khác, báo thẳng ra để Sếp dễ bắt bệnh
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}