<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Thêm use Request nếu bạn có xử lý form gửi góp ý
use App\Models\Product; // Khai báo model Product
use Illuminate\Support\Facades\Mail; // Thêm use Mail nếu bạn có gửi email trong controller này

class HomeController extends Controller
{
    public function index()
    {
        // Lấy 8 sản phẩm mới nhất (sắp xếp giảm dần theo ngày tạo)
        $newProducts = Product::orderBy('created_at', 'desc')->take(8)->get();
        
        // Trả về view 'home.blade.php' kèm theo dữ liệu
        return view('home', compact('newProducts'));
    }
    public function sendFeedback(Request $request)
    {
        // 1. Kiểm tra dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // 2. Soạn nội dung Email
        $content = "Hệ thống cửa hàng kính mắt Anna vừa nhận được một Góp ý/Phản hồi từ khách hàng:\n\n"
                 . "👤 Khách hàng: " . $request->name . "\n"
                 . "📞 Số điện thoại: " . ($request->phone ?? 'Không cung cấp') . "\n"
                 . "📝 Nội dung góp ý:\n" . $request->message . "\n\n"
                 . "---------------------------------\n"
                 . "Được gửi từ Website Kính Mắt Anna";

        // 3. Thực hiện gửi mail về đúng địa chỉ của Sếp
        try {
            Mail::raw($content, function ($message) use ($request) {
                $message->to('quockhanh310204@gmail.com') // Trực tiếp về Gmail của Sếp
                        ->subject('[Anna Eyewear] Góp ý từ khách hàng: ' . $request->name);
            });

            return back()->with('success', 'Tuyệt vời! Góp ý của bạn đã được gửi trực tiếp đến Ban Giám Đốc Anna.');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi gửi mail: ' . $e->getMessage());
        }
    }
}
