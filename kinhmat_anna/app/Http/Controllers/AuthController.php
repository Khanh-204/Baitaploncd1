<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Gọi model User ra để tạo tài khoản

class AuthController extends Controller
{
    // =====================================
    // 1. HIỂN THỊ FORM ĐĂNG NHẬP
    // =====================================
    public function showLogin()
    {
        return view('auth.login');
    }

    // =====================================
    // 2. XỬ LÝ ĐĂNG NHẬP (KIỂM TRA TÀI KHOẢN)
    // =====================================
    public function processLogin(Request $request)
    {
        // Kiểm tra người dùng đã nhập đủ chưa
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        // Bắt đầu check với Database
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Xịn xò: Nếu là Admin thì văng thẳng vào trang Quản trị
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Xin chào Sếp! Đăng nhập quản trị thành công.');
            }
            
            // Nếu là Khách thì về trang chủ mua kính
            return redirect()->route('home')->with('success', 'Đăng nhập thành công! Chào mừng bạn đến với Anna.');
        }

        // Nếu nhập sai thì báo lỗi
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác. Vui lòng kiểm tra lại!',
        ])->onlyInput('email');
    }

    // =====================================
    // 3. HIỂN THỊ FORM ĐĂNG KÝ
    // =====================================
    public function showRegister()
    {
        return view('auth.register');
    }

    // =====================================
    // 4. XỬ LÝ ĐĂNG KÝ (TẠO MỚI TÀI KHOẢN)
    // =====================================
    public function processRegister(Request $request)
    {
        // Kiểm tra tính hợp lệ của dữ liệu
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'email.unique' => 'Email này đã được sử dụng. Vui lòng chọn email khác!',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự để bảo mật.'
        ]);

        // Tạo tài khoản mới lưu vào DB
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
            'role' => 'user' // Mặc định người mới đăng ký là user thường
        ]);

        // Đăng nhập luôn cho tiện
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Tạo tài khoản thành công! Anna tặng bạn một nụ cười nha.');
    }

    // =====================================
    // 5. XỬ LÝ ĐĂNG XUẤT
    // =====================================
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Đã đăng xuất tài khoản thành công, hẹn gặp lại bạn sớm nha!');
    }
}