@extends('layouts.auth')

@section('content')
    <div class="container py-5">
        <h3 class="mt-3 text-center">Đăng nhập</h3>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mt-3 text-center">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </div>
        </form>
        <p class="mt-3 text-center">
            Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a>
        </p>
    </div>
@endsection
