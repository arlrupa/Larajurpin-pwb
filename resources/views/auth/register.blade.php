@extends('layouts.app-user')

@section('content')
<style>
    .register-container {
        min-height: calc(100vh - 80px);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .register-box {
        width: 100%;
        max-width: 420px;
    }

    .register-box h5 {
        font-weight: bold;
        text-align: center;
        color: #001F3F;
    }

    .form-control {
        border: 1px solid #00a1c9;
        border-radius: 12px;
        padding: 10px 15px;
        font-size: 14px;
    }

    .btn-register {
        background-color: #007ca6;
        color: white;
        font-weight: 500;
        border-radius: 12px;
        padding: 10px;
        width: 100%;
        border: none;
    }

    .login-link {
        font-size: 12px;
        text-align: center;
        margin-top: 8px;
    }

    .login-link a {
        text-decoration: none;
        color: #007ca6;
    }
</style>

<div class="register-container">
    <div class="register-box">
        <h5 class="text-uppercase mb-4">Registrasi</h5>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="/register">
            @csrf
            <input type="hidden" name="role" value="user">

            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="name" required>
            </div>
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="username" required>
            </div>
            <div class="mb-3">
                <input type="text" name="phone" class="form-control" placeholder="no telepon" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="email" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="password" required>
            </div>

            <button type="submit" class="btn-register">REGISTRASI</button>
        </form>

        <div class="login-link">
            <p>Sudah punya akun? <a href="/login">Login disini</a></p>
        </div>
    </div>
</div>
@endsection