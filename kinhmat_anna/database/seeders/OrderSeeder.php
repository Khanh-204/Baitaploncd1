<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User; // Nhớ thêm dòng này để gọi Model User

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Lấy thằng User đầu tiên (thường là Sếp)
        $user = User::first();

        // Nếu chưa có User nào thì tạo tạm một ông khách để gán đơn
        if (!$user) {
            $user = User::create([
                'name' => 'Khách Hàng Mẫu',
                'email' => 'khachhang@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('123456'),
                'role' => 'user'
            ]);
        }

        Order::create([
            'order_number' => 'ANNA' . strtoupper(\Illuminate\Support\Str::random(8)),
            'user_id' => $user->id, // Dùng ID của thằng User vừa tìm được
            'total_amount' => 1500000,
            'status' => 'pending',
            'address' => '123 Đường ABC, Hà Nội',
            'phone' => '0987654321'
        ]);
    }
}