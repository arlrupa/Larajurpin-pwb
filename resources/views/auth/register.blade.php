@extends('layouts.app-user')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 100px);">
        <div class="w-100" style="max-width: 400px;">
            <h5 class="text-center text-uppercase fw-bold text-dark mb-4">REGISTRASI</h5>

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
                    <input type="text" name="name" class="form-control rounded-pill border border-info" placeholder="name" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="username" class="form-control rounded-pill border border-info" placeholder="username" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="phone" class="form-control rounded-pill border border-info" placeholder="no telepon" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control rounded-pill border border-info" placeholder="email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control rounded-pill border border-info" placeholder="password" required>
                </div>

                <button type="submit" class="btn w-100 rounded-pill text-white fw-semibold" style="background-color: #007ca6;">REGISTRASI</button>
            </form>

            <div class="text-center mt-2">
                <small>Sudah punya akun? <a href="/login" class="text-decoration-none">Login</a></small>
            </div>
        </div>
    </div>
@endsection
