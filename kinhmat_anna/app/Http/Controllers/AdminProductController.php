<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category; // Gọi Model Danh mục
use Illuminate\Support\Str; // Hỗ trợ tạo Link thân thiện (Slug)
use Illuminate\Support\Facades\Storage; // Hỗ trợ xóa ảnh cũ

class AdminProductController extends Controller
{
    // ==========================================
    // 1. HIỂN THỊ DANH SÁCH & TÌM KIẾM
    // ==========================================
    public function index(Request $request) {
        $query = Product::with('category');

        // 1. Search đa trường
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('slug', 'like', "%{$request->search}%");
            });
        }

        // 2. Lọc theo danh mục
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // 3. Lọc tồn kho
        if ($request->stock_status == 'low') {
            $query->where('stock', '>', 0)->where('stock', '<', 10);
        } elseif ($request->stock_status == 'out') {
            $query->where('stock', 0);
        }

        // 4. Sắp xếp
        if ($request->sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort == 'stock_desc') {
            $query->orderBy('stock', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(10)->appends($request->query());
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    // ==========================================
    // 2. MỞ FORM THÊM SẢN PHẨM
    // ==========================================
    public function create() {
        $categories = Category::all(); 
        return view('admin.products.create', compact('categories'));
    }

    // ==========================================
    // 3. LƯU SẢN PHẨM VÀ UPLOAD ẢNH (HỖ TRỢ .AVIF)
    // ==========================================
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            // Đổi 'image' thành 'file' và thêm 'avif', tăng max lên 5MB
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:5120', 
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->name) . '-' . time(); 

        // Lưu ảnh thẳng vào biến $data['image'] để Create luôn 1 thể
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Đã thêm sản phẩm mới thành công!');
    }
    
    // Hiện form chỉnh sửa
    public function edit($id) {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Xử lý cập nhật dữ liệu (ĐÃ NÂNG CẤP ĐỂ NHẬN FILE .AVIF)
    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            // Cập nhật giống hàm Store: cho phép .avif và file 5MB
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:5120',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->name) . '-' . $product->id;

        if ($request->hasFile('image')) {
            // Dùng Storage::disk để xóa ảnh cũ (chuẩn Laravel)
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            
            // Lưu ảnh mới
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    // ==========================================
    // 4. XÓA SẢN PHẨM
    // ==========================================
    public function destroy($id) {
        $product = Product::findOrFail($id);
        
        // Nên xóa luôn ảnh gốc khi xóa sản phẩm để đỡ nặng ổ cứng
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        return back()->with('success', 'Đã xóa sản phẩm thành công!');
    }
}