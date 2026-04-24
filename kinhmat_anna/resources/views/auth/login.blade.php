@extends('layouts.app')

@section('content')
<style>
    .login-container { min-height: 75vh; display: flex; align-items: center; justify-content: center; background-color: #fafafa;}
    .login-box { background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border: 1px solid #eee; width: 100%; max-width: 450px; }
    .login-title { font-family: 'Playfair Display', serif; font-weight: 800; font-size: 28px; text-align: center; margin-bottom: 30px; letter-spacing: 1px; color: #111; }
    
    .form-control { border-radius: 10px; padding: 12px 15px; border: 1px solid #ddd; background-color: #fcfcfc; transition: 0.3s;}
    .form-control:focus { border-color: #3cb3b0; box-shadow: 0 0 0 4px rgba(60, 179, 176, 0.1); background-color: #fff; }
    
    .btn-anna { background-color: #3cb3b0; color: #fff; border-radius: 50px; padding: 12px; font-weight: 700; width: 100%; border: none; transition: 0.3s; text-transform: uppercase; letter-spacing: 1px; }
    .btn-anna:hover { background-color: #2c8c89; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(60, 179, 176, 0.3); color: #fff;}
    
    .text-anna { color: #3cb3b0; font-weight: 600; text-decoration: none; transition: 0.2s;}
    .text-anna:hover { color: #2c8c89; text-decoration: underline; }
</style>

<div class="container-fluid login-container py-5">
    <div class="login-box">
        <h2 class="login-title">ĐĂNG NHẬP</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-bold small">Địa chỉ Email <span class="text-danger">*</span></label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Nhập email của bạn">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold small d-flex justify-content-between">
                    <span>Mật khẩu <span class="text-danger">*</span></span>
                    @if (Route::has('password.request'))
                        <a class="text-anna small" href="{{ route('password.request') }}">Quên mật khẩu?</a>
                    @endif
                </label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Nhập mật khẩu">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-muted small" for="remember">
                        Ghi nhớ đăng nhập
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn-anna shadow-sm">
                    ĐĂNG NHẬP NGAY
                </button>
            </div>

            <div class="text-center mt-4 pt-4 border-top">
                <span class="text-muted small">Chưa có tài khoản?</span>
                <a href="{{ route('register') }}" class="text-anna ms-1">Đăng ký ngay</a>
            </div>
        </form>
    </div>
</div>
@endsection