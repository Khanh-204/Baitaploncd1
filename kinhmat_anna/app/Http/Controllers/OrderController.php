<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Xem chi tiết đơn hàng (Dùng $id thủ công để tránh lỗi Route Binding)
    public function show($id)
    {
        // 1. Tìm đúng đơn hàng theo ID
        $order = Order::findOrFail($id);

        // 2. Chặn ai không phải chủ đơn hàng thì báo lỗi 403
        if ($order->user_id != Auth::id()) {
            abort(403, 'BẠN KHÔNG CÓ QUYỀN XEM ĐƠN HÀNG NÀY.');
        }

        // 3. Load thông tin chi tiết
        $order->load(['orderDetails.product', 'user']);

        return view('orders.show', compact('order'));
    }

    // [ĐÃ NÂNG CẤP LẠI LUỒNG HỦY ĐƠN & HOÀN TIỀN]
    public function cancel($id)
    {
        // 1. Tìm đơn hàng
        $order = Order::findOrFail($id);

        // 2. Kiểm tra quyền sở hữu
        if ($order->user_id != Auth::id()) {
            abort(403, 'BẠN KHÔNG CÓ QUYỀN HỦY ĐƠN HÀNG NÀY.');
        }

        // --- TRƯỜNG HỢP 1: CHƯA THANH TOÁN (HỦY LUÔN & HOÀN KHO) ---
        if (in_array($order->status, ['pending', 'pending_payment'])) {
            try {
                DB::transaction(function () use ($order) {
                    // Hoàn số lượng về kho
                    foreach ($order->orderDetails as $item) {
                        if ($item->product) {
                            $item->product->increment('stock', $item->quantity);
                        }
                    }
                    // Cập nhật trạng thái thành Đã hủy
                    $order->update(['status' => 'cancelled']);
                });

                return back()->with('success', 'Đã hủy đơn hàng thành công!');
                
            } catch (\Exception $e) {
                return back()->with('error', 'Có lỗi xảy ra khi hủy đơn. Vui lòng thử lại.');
            }
        }

        // --- TRƯỜNG HỢP 2: ĐÃ THANH TOÁN (YÊU CẦU HOÀN TIỀN) ---
        if ($order->status == 'processing') {
            // Chỉ đổi trạng thái để Admin check, KHÔNG hoàn kho vội
            $order->update(['status' => 'refund_pending']);
            return back()->with('success', 'Yêu cầu hoàn tiền thành công và sẽ sớm được xử lý! Cảm ơn quý khách đã tin tưởng và sử dụng dịch vụ.');
        }

        // --- TRƯỜNG HỢP 3: KHÔNG ĐƯỢC HỦY NỮA ---
        return back()->with('error', 'Đơn hàng đang được giao hoặc đã hoàn thành, không thể thao tác!');
    }

    // Xử lý Mua lại đơn hàng cũ
    public function reorder($id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        $cart = session()->get('cart', []);
        $addedCount = 0;

        foreach ($order->orderDetails as $item) {
            $product = $item->product;
            
            // Kiểm tra xem sản phẩm còn trên hệ thống và còn tồn kho không
            if ($product && $product->stock > 0) {
                $prodId = $product->id;
                
                if(isset($cart[$prodId])) {
                    $cart[$prodId]['quantity'] += $item->quantity;
                } else {
                    $cart[$prodId] = [
                        "name" => $product->name,
                        "quantity" => $item->quantity,
                        "price" => $product->price, 
                        "image" => $product->image
                    ];
                }
                $addedCount++;
            }
        }

        if ($addedCount > 0) {
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Đã thêm các sản phẩm từ đơn hàng cũ vào Giỏ hàng!');
        } else {
            return back()->with('error', 'Rất tiếc, các sản phẩm trong đơn hàng này đã hết hàng hoặc ngừng kinh doanh.');
        }
    }
}