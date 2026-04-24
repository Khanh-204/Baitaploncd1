<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    // Hiển thị trang giao diện gốc
    public function index()
    {
        $stores = Store::orderBy('city')->get();
        // Lấy danh sách thành phố độc nhất để hiển thị ra ô Lọc
        $cities = Store::select('city')->distinct()->whereNotNull('city')->pluck('city');
        
        return view('stores.index', compact('stores', 'cities'));
    }

    // Xử lý Lọc dữ liệu qua AJAX (Không load trang)
    public function filter(Request $request)
    {
        $query = Store::query();

        // Lọc theo khu vực (Thành phố)
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Lọc theo từ khóa (Tìm tên hoặc địa chỉ)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $stores = $query->orderBy('city')->get();
        
        // Trả về dữ liệu dạng JSON cho Javascript xử lý
        return response()->json($stores);
    }
}