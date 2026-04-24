<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // 1. Hiển thị trang giỏ hàng
    public function index()
    {
        $relatedProducts = Product::inRandomOrder()->take(4)->get();
        return view('cart.index', compact('relatedProducts'));
    }

    // 2. Thêm sản phẩm vào giỏ (Xử lý cả Mua ngay & AJAX)
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $quantity = $request->quantity ?? 1;

        // Cập nhật giỏ hàng trong Session
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->sale_price ?? $product->price,
                "image" => $product->image_url
            ];
        }

        session()->put('cart', $cart);

        // LOGIC 1: Nếu khách bấm "MUA NGAY" -> Bay thẳng đến trang Thanh toán
        if ($request->has('buy_now')) {
            return redirect()->route('checkout.index');
        }

        // LOGIC 2: Nếu là yêu cầu AJAX (Thêm vào giỏ không load trang)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm ' . $product->name . ' vào giỏ hàng!',
                'cart_count' => count(session('cart'))
            ]);
        }

        // LOGIC 3: Mặc định redirect về trang trước kèm thông báo
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Đã cập nhật giỏ hàng!');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Đã xóa sản phẩm!');
        }
    }
}