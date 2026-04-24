<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_number', 'user_id', 'phone', 'address', 'total_amount', 'notes', 'status'];

    // Quan hệ
    public function user() { return $this->belongsTo(User::class); }
    public function orderDetails() { return $this->hasMany(OrderItem::class); }

    // ====== THÊM 3 HÀM NÀY VÀO =======
    
    // 1. Lấy class màu sắc của trạng thái
    public function getStatusBadgeAttribute()
    {
        return [
            'pending' => 'bg-warning text-dark',
            'processing' => 'bg-info',
            'shipped' => 'bg-primary',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger',
        ][$this->status] ?? 'bg-secondary';
    }

    // 2. Lấy tên tiếng Việt của trạng thái
    public function getStatusNameAttribute()
    {
        return [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đang giao',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
        ][$this->status] ?? $this->status;
    }

    // 3. Format tiền tệ chuẩn
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_amount, 0, ',', '.') . 'đ';
    }
    // Kiểm tra xem đơn hàng có được phép hủy hay không
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending']);
    }

}