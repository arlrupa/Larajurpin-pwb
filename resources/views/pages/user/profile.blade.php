@extends('layouts.app-user')

@section('title', 'Profil')

@push('styles')
<style>
    .navbar,
    footer {
        background-color: #003366;
        color: white;
    }

    .navbar-nav .nav-link {
        position: relative;
        color: white;
        transition: color 0.3s ease;
    }

    .navbar-nav .nav-link::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0;
        height: 2px;
        background-color: white;
        transition: width 0.3s ease;
    }

    .navbar-nav .nav-link:hover::after,
    .navbar-nav .nav-link.active::after {
        width: 100%;
    }

    .navbar-nav .nav-link.active {
        font-weight: bold;
        color: #FFD700 !important;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3" style="width: 70px; height: 70px; font-size: 24px;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="mb-0">{{ Auth::user()->name }}</h4>
                            <span class="text-muted">Akun Pengguna</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">
                            <i class="bi bi-person-fill me-1"></i> Username
                        </div>
                        <div class="col-sm-8">
                            {{ Auth::user()->username }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">
                            <i class="bi bi-telephone-fill me-1"></i> No Telepon
                        </div>
                        <div class="col-sm-8">
                            {{ Auth::user()->phone }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-muted">
                            <i class="bi bi-envelope-fill me-1"></i> Email
                        </div>
                        <div class="col-sm-8">
                            {{ Auth::user()->email }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection