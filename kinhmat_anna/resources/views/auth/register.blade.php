@extends('layouts.app')

@section('content')
<style>
    .login-container { min-height: 75vh; display: flex; align-items: center; justify-content: center; background-color: #fafafa;}
    .login-box { background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border: 1px solid #eee; width: 100%; max-width: 500px; margin: 40px 0;}
    .login-title { font-family: 'Playfair Display', serif; font-weight: 800; font-size: 28px; text-align: center; margin-bottom: 30px; letter-spacing: 1px; color: #111; }
    
    .form-control { border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd; background-color: #fcfcfc; transition: 0.3s;}
    .form-control:focus { border-color: #3cb3b0; box-shadow: 0 0 0 4px rgba(60, 179, 176, 0.1); background-color: #fff; }
    
    .btn-anna { background-color: #3cb3b0; color: #fff; border-radius: 50px; padding: 12px; font-weight: 700; width: 100%; border: none; transition: 0.3s; text-transform: uppercase; letter-spacing: 1px; }
    .btn-anna:hover { background-color: #2c8c89; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(60, 179, 176, 0.3); color: #fff;}
    
    .text-anna { color: #3cb3b0; font-weight: 600; text-decoration: none; transition: 0.2s;}
    .text-anna:hover { color: #2c8c89; text-decoration: underline; }
</style>

<div class="container-fluid login-container">
    <div class="login-box">
        <h2 class="login-title">ĐĂNG KÝ TÀI KHOẢN</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label fw-bold small">Họ và tên <span class="text-danger">*</span></label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nhập họ tên của bạn">
                @error('name')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-bold small">Địa chỉ Email <span class="text-danger">*</span></label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Nhập email của bạn">
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label fw-bold small">Mật khẩu <span class="text-danger">*</span></label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Nhập mật khẩu">
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label for="password-confirm" class="form-label fw-bold small">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Nhập lại mật khẩu">
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn-anna shadow-sm">
                    TẠO TÀI KHOẢN NGAY
                </button>
            </div>

            <div class="text-center mt-4 pt-4 border-top">
                <span class="text-muted small">Đã có tài khoản?</span>
                <a href="{{ route('login') }}" class="text-anna ms-1">Đăng nhập ngay</a>
            </div>
        </form>
    </div>
</div>
@endsection