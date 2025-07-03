@extends('layouts.app-user')

@section('content')
<style>
    .login-container {
        min-height: calc(100vh - 80px);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-box {
        width: 100%;
        max-width: 420px;
    }

    .login-box h5 {
        font-weight: bold;
        text-align: center;
        color: #001F3F;
    }

    .form-control, .form-select {
        border: 1px solid #00a1c9;
        border-radius: 12px;
        padding: 10px 15px;
        font-size: 14px;
    }

    .btn-login {
        background-color: #007ca6;
        color: white;
        font-weight: 500;
        border-radius: 12px;
        padding: 10px;
        width: 100%;
        border: none;
    }

    .register-link {
        font-size: 12px;
        text-align: center;
        margin-top: 8px;
    }

    .register-link a {
        text-decoration: none;
        color: #007ca6;
    }
</style>

<div class="login-container">
    <div class="login-box">
        <h5 class="text-uppercase mb-4">Login</h5>

        {{-- Pesan sukses --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Pesan error --}}
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Validasi error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/login" id="loginForm">
            @csrf
            {{-- <div class="mb-3">
                <select id="roleSelect" name="role" class="form-select" required>
                    <option value="user" selected>User</option>
                    <option value="admin">Admin</option>
                </select>
            </div> --}}
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="password" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>
            <button type="submit" class="btn-login">LOGIN</button>
        </form>

        <div id="registerSection" class="register-link">
            <p id="registerText">
                Belum punya akun? <a href="/register">Daftar disini</a>
            </p>
        </div>
    </div>
</div>
@endsection
