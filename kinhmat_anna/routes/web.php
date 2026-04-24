<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\ProfileController;

// ==========================================
// 1. CÁC TRANG CÔNG KHAI (Ai cũng xem được)
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home'); // Trang chủ
Route::get('/products', [ProductController::class, 'index'])->name('products.index');// Trang danh sách sản phẩm
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');// Trang chi tiết sản phẩm
Route::post('/feedback', [App\Http\Controllers\HomeController::class, 'sendFeedback'])->name('feedback.send'); // Xử lý gửi góp ý/feedback từ khách hàng
Route::get('/order/{id}/payment', [App\Http\Controllers\CheckoutController::class, 'payment'])->name('orders.payment'); // Trang thanh toán cho đơn hàng đã đặt (dùng khi khách chọn "Đặt hàng sau, thanh toán sau")

// [ĐÃ SỬA]: Chuyển trang Hành Trình Tử Tế ra ngoài để ai cũng xem được
Route::get('/hanh-trinh-tu-te', function () {
    return view('journey');
})->name('journey');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');//    Trang giỏ hàng
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');// Thêm sản phẩm vào giỏ hàng
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');// Cập nhật số lượng sản phẩm trong giỏ hàng
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');// Xóa sản phẩm khỏi giỏ hàng

// Hệ thống cửa hàng
Route::get('/stores', [App\Http\Controllers\StoreController::class, 'index'])->name('stores.index'); // Trang danh sách cửa hàng
Route::get('/stores/filter', [App\Http\Controllers\StoreController::class, 'filter'])->name('stores.filter'); // Route này sẽ được gọi qua AJAX 
Route::post('/products/{id}/like', [App\Http\Controllers\ProductController::class, 'toggleLike'])->name('products.like'); // Xử lý yêu thích sản phẩm

// Các trang Chính sách
Route::get('/chinh-sach-thanh-toan', function () { return view('policies.payment'); })->name('policy.payment');
Route::get('/chinh-sach-bao-hanh', function () { return view('policies.warranty'); })->name('policy.warranty');
Route::get('/chinh-sach-giao-hang', function () { return view('policies.shipping'); })->name('policy.shipping');
Route::get('/chinh-sach-bao-mat', function () { return view('policies.privacy'); })->name('policy.privacy');

// ==========================================
// 2. KHÁCH CHƯA ĐĂNG NHẬP (Guest)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');// Trang đăng nhập
    Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');// Xử lý đăng nhập
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');// Trang đăng ký
    Route::post('/register', [AuthController::class, 'processRegister'])->name('register.process');// Xử lý đăng ký
});


// ==========================================
// 3. USER ĐÃ ĐĂNG NHẬP (Khách hàng & Admin)
// ==========================================
Route::middleware('auth')->group(function () { 
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Xử lý đăng xuất
    
    // Quy trình thanh toán
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index'); // Trang thanh toán
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process'); // Xử lý thanh toán
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success'); // Trang thanh toán thành công
    
    // Quản lý đơn hàng (Phía khách hàng)
    Route::get('/orders/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show'); // Trang chi tiết đơn hàng
    Route::post('/orders/{id}/cancel', [App\Http\Controllers\OrderController::class, 'cancel'])->name('orders.cancel'); // Hủy đơn hàng
    Route::post('/orders/{id}/reorder', [App\Http\Controllers\OrderController::class, 'reorder'])->name('orders.reorder'); // Đặt lại đơn hàng cũ

    // Chỉnh sửa đơn khi thanh toán
    Route::post('/checkout/update', [CheckoutController::class, 'updateQuantity'])->name('checkout.update'); 
    Route::delete('/checkout/remove/{id}', [CheckoutController::class, 'removeItem'])->name('checkout.remove'); 
    
    // Trang Cá nhân & Lịch sử đơn hàng
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index'); // Trang cá nhân
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update'); // Cập nhật thông tin cá nhân
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password'); // Cập nhật mật khẩu
});


// ==========================================
// 4. KHU VỰC TỐI MẬT: CHỈ DÀNH CHO ADMIN
// ==========================================
Route::middleware(['auth', 'admin'])->group(function () { 
    
    // Trang Bảng điều khiển (Tổng quan)
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard'); 
    
    // Quản lý Sản phẩm
    Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index'); 
    Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create'); 
    Route::post('/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store'); 
    Route::delete('/admin/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy'); 
    Route::get('/admin/products/{id}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit'); 
    Route::put('/admin/products/{id}', [AdminProductController::class, 'update'])->name('admin.products.update'); 

    // Quản lý đơn hàng
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index'); 
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show'); 
    Route::post('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus'); 
    Route::get('/admin/orders/{order}/print', [AdminOrderController::class, 'printInvoice'])->name('admin.orders.print'); 
    // Route để Admin xác nhận khách đã chuyển khoản
Route::post('/admin/orders/{id}/confirm-payment', [App\Http\Controllers\AdminOrderController::class, 'confirmPayment'])->name('admin.orders.confirm_payment');

    // Quản lý Cửa hàng
    Route::get('/admin/stores', [App\Http\Controllers\AdminStoreController::class, 'index'])->name('admin.stores.index');   
    Route::get('/admin/stores/create', [App\Http\Controllers\AdminStoreController::class, 'create'])->name('admin.stores.create');  
    Route::post('/admin/stores', [App\Http\Controllers\AdminStoreController::class, 'store'])->name('admin.stores.store'); 
    Route::get('/admin/stores/{store}/edit', [App\Http\Controllers\AdminStoreController::class, 'edit'])->name('admin.stores.edit'); 
    Route::put('/admin/stores/{store}', [App\Http\Controllers\AdminStoreController::class, 'update'])->name('admin.stores.update'); 
    Route::post('/admin/stores/{store}/delete', [App\Http\Controllers\AdminStoreController::class, 'destroy'])->name('admin.stores.destroy'); 
});