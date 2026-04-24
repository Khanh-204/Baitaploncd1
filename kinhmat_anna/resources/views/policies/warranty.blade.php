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
        <h1 class="policy-title">Chính sách bảo hành, đổi trả</h1>
        <p class="text-uppercase fw-bold text-white">Chế độ bảo hành tại Kính Mắt Anna</p>
        
        <h3 class="policy-heading">Một số lưu ý với kính mới</h3>
        <ul>
            <li>Đối với kính mới thường có hiện tượng choáng, lóa, nhức và mỏi mắt.</li>
            <li>Đây là các hiện tượng hoàn toàn bình thường và sẽ giảm dần theo thời gian từ 4 đến 7 ngày khi bạn thích nghi với kính mới.</li>
        </ul>

        <h3 class="policy-heading mt-5">Nguyên nhân</h3>
        <ul>
            <li>Do có sự thay đổi về độ rộng mắt kính giữa gọng kính mới và gọng kính cũ đang đeo.</li>
            <li>Do độ mới của khách hàng tăng nhiều so với độ kính cũ.</li>
            <li>Do lần đầu tiên sử dụng kính có độ.</li>
            <li>Đeo kính gọng kính mới khác nhiều so với gọng kính cũ.</li>
            <li>Do tròng kính mới có độ trong suốt tốt hơn so với tròng kính cũ.</li>
            <li>Do làm quen các thiết bị điện tử.</li>
        </ul>
    </div>
</div>
@endsection