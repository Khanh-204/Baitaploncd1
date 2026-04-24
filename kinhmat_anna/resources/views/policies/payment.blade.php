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
        <h1 class="policy-title">Chính sách thanh toán</h1>
        <h3 class="policy-heading">I. Thanh toán khi nhận hàng (COD)</h3>
        <p>Khi mua hàng từ xa, Quý khách có thể lựa chọn hình thức thanh toán khi nhận hàng (COD) tại địa điểm giao hàng đã thỏa thuận.</p>
        <p>Chi phí vận chuyển sẽ được áp dụng theo chính sách vận chuyển của Kính mắt Anna hoặc theo thỏa thuận cụ thể giữa các bên.</p>
        <p class="text-white fw-bold mt-4">Lưu ý:</p>
        <ul>
            <li>Đối với các đơn hàng cắt kính theo độ (cắt cận), Quý khách vui lòng chuyển khoản đặt cọc từ 50% đến 100% tổng giá trị đơn hàng trước khi tiến hành thực hiện.</li>
            <li>Quý khách có trách nhiệm thanh toán đầy đủ giá trị còn lại của đơn hàng cho nhân viên giao hàng hoặc đơn vị vận chuyển ngay sau khi kiểm tra hàng hóa và nhận hóa đơn.</li>
        </ul>
        <h3 class="policy-heading mt-5">II. Thanh toán chuyển khoản ngân hàng</h3>
        <p>Quý khách có thể thanh toán bằng hình thức chuyển khoản theo thông tin số tài khoản chính thức do Anna cung cấp trong quá trình đặt hàng.</p>
    </div>
</div>
@endsection