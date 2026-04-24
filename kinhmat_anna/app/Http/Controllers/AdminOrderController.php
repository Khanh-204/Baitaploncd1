<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
  // ==========================================
    // HIỂN THỊ DANH SÁCH & LỌC ĐƠN HÀNG
    // ==========================================
    public function index(Request $request)
    {
        // Khởi tạo query, lấy kèm thông tin User và sắp xếp mới nhất lên đầu
        $query = \App\Models\Order::with('user')->latest();

        // 1. Xử lý LỌC THEO TRẠNG THÁI
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 2. Xử lý LỌC THEO TỪ KHÓA (Mã đơn, Tên khách hoặc SĐT)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                // ĐÃ SỬA: Dùng đúng tên cột 'customer_name' và 'customer_phone' trong DB
                $q->where('order_number', 'like', "%{$searchTerm}%")
                  ->orWhere('customer_name', 'like', "%{$searchTerm}%")
                  ->orWhere('customer_phone', 'like', "%{$searchTerm}%")
                  
                  // Tìm cả trong bảng Users liên kết (dành cho khách có tài khoản)
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', "%{$searchTerm}%")
                                ->orWhere('phone', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // 3. Phân trang và GIỮ LẠI tham số lọc trên URL khi chuyển trang
        $orders = $query->paginate(10)->appends($request->query());

        return view('admin.orders.index', compact('orders'));
    }

    // 2. Xem chi tiết 1 đơn hàng
    public function show(Order $order)
    {
        $order->load(['orderDetails.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    // 3. Xử lý cập nhật trạng thái đơn
   // Cập nhật trạng thái đơn hàng (Có xử lý hoàn kho)
    public function updateStatus(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);

        // 1. Cập nhật bộ Validate: Bổ sung thêm các trạng thái mới để hệ thống không chặn
        $request->validate([
            'status' => 'required|in:pending,pending_payment,processing,shipped,completed,cancelled,refund_pending,refunded'
        ]);

        $newStatus = $request->status;

        // 2. LOGIC HOÀN KHO: Nếu chuyển sang "Đã hoàn tiền" hoặc "Đã hủy"
        // (Và đảm bảo trạng thái trước đó chưa bị hủy/hoàn tiền để tránh cộng khống kho 2 lần)
        if (in_array($newStatus, ['cancelled', 'refunded']) && !in_array($order->status, ['cancelled', 'refunded'])) {
            try {
                \Illuminate\Support\Facades\DB::transaction(function () use ($order, $newStatus) {
                    // Hoàn lại số lượng sản phẩm vào kho
                    foreach ($order->orderDetails as $item) {
                        if ($item->product) {
                            $item->product->increment('stock', $item->quantity);
                        }
                    }
                    // Cập nhật trạng thái
                    $order->update(['status' => $newStatus]);
                });

                $msg = $newStatus == 'refunded' ? 'Đã xác nhận hoàn tiền cho khách & cộng lại kho thành công!' : 'Đã hủy đơn hàng & cộng lại kho thành công!';
                return back()->with('success', $msg);

            } catch (\Exception $e) {
                return back()->with('error', 'Có lỗi xảy ra khi hoàn kho. Vui lòng thử lại!');
            }
        }

        // 3. Với các trạng thái bình thường (Đang xử lý, Đang giao...) thì chỉ việc cập nhật
        $order->update(['status' => $newStatus]);

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
    // Hàm xuất giao diện hóa đơn để in
public function printInvoice(Order $order)
{
    $order->load(['orderDetails.product', 'user']);
    return view('admin.orders.print', compact('order'));
}
// Hàm xác nhận đã nhận được tiền chuyển khoản
    public function confirmPayment($id) {
        $order = \App\Models\Order::findOrFail($id);
        
        // Kiểm tra xem đơn có đúng là đang chờ thanh toán không
        if($order->status == 'pending_payment') {
            $order->update([
                'status' => 'processing', // Đổi sang trạng thái Đang xử lý / Đã thanh toán
            ]);
            return back()->with('success', 'Đã xác nhận thanh toán! Đơn hàng đang được chuẩn bị giao.');
        }
        
        return back()->with('error', 'Đơn hàng không ở trạng thái chờ thanh toán!');
    }
}