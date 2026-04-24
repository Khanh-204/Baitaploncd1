<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order; // Bắt buộc phải gọi Model Order
use App\Models\User;  // Gọi Model User
use Carbon\Carbon;    // Gọi thư viện thời gian để vẽ biểu đồ

class AdminController extends Controller
{
    // Hàm này có thể là index() hoặc dashboard() tùy Sếp khai báo trong routes/web.php
    public function index() 
    {
        // 1. Thống kê 4 thẻ sinh tồn (Lấy số thật từ Database)
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount'); // Tổng doanh thu (tổng tiền tất cả đơn hàng)
        $totalCustomers = User::where('role', '!=', 'admin')->count(); // Đếm khách hàng

        // 2. Lấy 5 đơn hàng mới nhất vừa đặt
        $recentOrders = Order::latest()->take(5)->get();

        // 3. Xử lý dữ liệu Biểu đồ Doanh thu (7 ngày gần nhất)
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            // Lùi về từng ngày (VD: hnay, hqua, hơm kia...)
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d/m'); // Hiện nhãn: 24/04
            
            // Tính tổng tiền các đơn hàng được tạo trong ngày đó
            $dailyRevenue = Order::whereDate('created_at', $date->toDateString())->sum('total_amount');
            $chartData[] = $dailyRevenue;
        }

        // 4. Gửi toàn bộ dữ liệu xịn này sang View
        return view('admin.dashboard', compact(
            'totalProducts', 'totalOrders', 'totalCustomers', 'totalRevenue', 
            'chartLabels', 'chartData', 'recentOrders'
        ));
    }
}