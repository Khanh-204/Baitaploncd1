<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Hiển thị trang tài khoản (Gồm Thông tin & Lịch sử đơn)
    public function index()
    {
        $user = Auth::user();
        
        // CẬP NHẬT 1: Dùng with() để Eager Loading (Chống N+1 Query)
        // CẬP NHẬT 2: Dùng paginate(5) để phân trang (5 đơn / 1 trang) thay vì get() toàn bộ
        $orders = Order::with('orderDetails.product')
                       ->where('user_id', $user->id)
                       ->latest()
                       ->paginate(5); 

        return view('profile.index', compact('user', 'orders'));
    }

    // Cập nhật thông tin cơ bản (Tên, SĐT, Địa chỉ)
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            // CẬP NHẬT 3: Validate chuẩn định dạng Số điện thoại Việt Nam (10 số, đúng đầu mạng)
            'phone' => ['nullable', 'regex:/^(0[3|5|7|8|9])+([0-9]{8})$/'],
            'address' => 'nullable|string|max:500',
        ], [
            'phone.regex' => 'Số điện thoại không đúng định dạng. Vui lòng nhập đúng 10 số hợp lệ.'
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Đã cập nhật thông tin thành công!');
    }

    // Xử lý đổi mật khẩu riêng biệt
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.'
        ]);

        $user = Auth::user();

        // Kiểm tra mật khẩu cũ
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác!']);
        }

        // Lưu mật khẩu mới
        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Đã đổi mật khẩu thành công!');
    }
}