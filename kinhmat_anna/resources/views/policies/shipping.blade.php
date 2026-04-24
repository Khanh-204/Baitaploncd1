@extends('layouts.app')
@section('content')
<style>
    body { background-color: #ffffff; }
    .policy-wrapper { color: #000000; padding: 80px 0; min-height: 70vh; font-family: 'Montserrat', sans-serif; }
    .policy-title { font-size: 40px; font-weight: 700; color: #000000; margin-bottom: 40px; }
    .policy-heading { font-size: 20px; font-weight: 600; color: #000000; margin-top: 30px; margin-bottom: 15px; text-transform: uppercase; }
    .policy-wrapper p, .policy-wrapper li { font-size: 15px; line-height: 1.8; margin-bottom: 15px; }
</style>
<div class="policy-wrapper">
    <div class="container" style="max-width: 900px;">
        <h1 class="policy-title">Chính sách vận chuyển</h1>
        <h3 class="policy-heading">I. Cước phí vận chuyển</h3>
        <p>Giao hàng thông thường qua đơn vị vận chuyển, tùy thuộc vào khoảng cách vị trí và trọng lượng đơn hàng sau đóng gói.</p>
        
        <p class="text-white fw-bold mt-4">Hà Nội:</p>
        <ul>
            <li>Từ 0 - 2kg: 16,500đ</li>
            <li>Từ 2kg trở lên: 24,000đ</li>
            <li>Từ 5kg trở lên: 32,000đ</li>
            <li>Từ 8kg trở lên: 45,000đ</li>
            <li>Từ 10kg trở lên: 60,000đ</li>
            <li>Từ 12kg trở lên: 100,000đ</li>
        </ul>
    </div>
</div>
@endsection