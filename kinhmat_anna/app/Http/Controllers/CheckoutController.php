<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!session('cart') || count(session('cart')) == 0) {
            return redirect()->route('products.index')
                ->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        return view('checkout.index');
    }

    public function process(Request $request)
    {
        // 1. Validate
        $request->validate([
            'customer_name'   => 'required|string|max:255',
            'customer_phone'  => 'required|string|max:20',
            'customer_address'=> 'required|string|max:500',
        ]);

        $cart = session()->get('cart');
        if (!$cart || count($cart) == 0) {
            return redirect()->route('home')
                ->with('error', 'Giỏ hàng trống!');
        }

        DB::beginTransaction();

        try {
            // 2. Tính tổng tiền CHUẨN
            $totalAmount = 0;

            foreach ($cart as $details) {
                $price = (float) $details['price'];
                $qty   = (int) $details['quantity'];

                $totalAmount += $price * $qty;
            }

            // ⚠️ Bảo vệ: không cho đơn = 0
            if ($totalAmount <= 0) {
                throw new \Exception('Tổng tiền không hợp lệ');
            }

            // 3. Tạo đơn hàng
            $order = Order::create([
                'order_number' => 'ANNA' . strtoupper(Str::random(8)),
                'user_id'      => auth()->id(),
                'phone'        => $request->customer_phone,
                'address'      => $request->customer_address,
                'total_amount' => $totalAmount, // ✅ CHUẨN FIELD
                'notes'        => $request->notes,
                'status'       => $request->payment_method == 'bank'
                                    ? 'pending_payment'
                                    : 'pending',
            ]);

            // 4. Lưu order items
            foreach ($cart as $id => $details) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $id,
                    'quantity'   => (int) $details['quantity'],
                    'price'      => (float) $details['price'],
                ]);
            }

            DB::commit();

            // 5. Xóa giỏ
            session()->forget('cart');

            // 6. Điều hướng
            if ($request->payment_method == 'bank') {
                return redirect()->route('orders.payment', $order->id);
            }

            return redirect()->route('checkout.success')
                ->with('success', 'Đặt hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();

            // Debug nếu cần:
            // dd($e->getMessage());

            return back()->with('error', 'Có lỗi khi xử lý đơn hàng!');
        }
    }

    public function updateQuantity(Request $request)
    {
        $cart = session()->get('cart');

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = max(1, (int)$request->quantity);
            session()->put('cart', $cart);
        }

        return back();
    }

    public function removeItem($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        if (empty($cart)) {
            return redirect()->route('home')
                ->with('info', 'Giỏ hàng của bạn đang trống.');
        }

        return back();
    }

    public function success()
    {
        return view('checkout.success');
    }

    public function payment($id)
    {
        $order = Order::findOrFail($id);

        // 🔥 FIX CHÍNH: đảm bảo view nhận đúng biến
        $order->total_price = $order->total_amount;

        return view('checkout.payment', compact('order'));
    }
}
