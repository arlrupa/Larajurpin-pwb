<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'JURPIN')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @stack('styles') {{-- << tambahkan ini --}}
    @stack('scripts')
    <style>
        html,
        body {
            background-color: #f9f9f9;
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        main {
            flex: 1;
        }

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

        .navbar-nav .nav-link {
            color: white;
        }

        .navbar-nav .nav-link.active {
            font-weight: bold;
            color: #FFD700 !important;
        }


        .tagline h2 {
            color: white;
        }

        .btn-selengkapnya {
            background-color: white;
            color: #007B8A;
            padding: 10px 20px;
            border-radius: 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-selengkapnya:hover {
            background-color: #007B8A;
            color: white;
        }

        .btn-fasilitas {
            background-color: #1282A2;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
            border: none;
        }

        .btn-fasilitas:hover {
            background-color: #0a6c88;
            color: #fff;
        }

        /* form button css */

        .form-section {
            background-color: white;
            padding: 30px;
            border: 1px solid #cce;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .form-title {
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            font-size: 24px;
        }

        .btn-submit {
            background-color: #007B8A;
            color: white;
            border: none;
        }

        .btn-submit:hover {
            background-color: #005f6b;
        }

        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            /* horizontal center */
            align-items: center;
            /* vertical center */
            padding-top: 31px;
        }

        .container.border.p-5 {
            max-width: 900px;
            width: 100%;
            color: white;
            border-radius: 12px;
            padding: 30px !important;
            border: none !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .container.border.p-5 table {
            background-color: transparent !important;
        }

        .container.border.p-5 img {
            border: 1px solid white;
            padding: 10px;
            border-radius: 8px;
            background-color: #E8EAEB;
        }

        .btn-back {
            background-color: #E8EAEB;
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-back:hover {
            background-color: #C7CCCE;
            color: white;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark px-4" style="background-color: #003366;">
        <a class="navbar-brand fw-bold text-white" href="#">JURPIN</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('peminjaman.fasilitas') ? 'active' : '' }}" href="{{ route('peminjaman.fasilitas') }}">
                        Fasilitas
                    </a>
                </li>

                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('pages.user.profile') }}">Profil Saya</a></li>
                        <li><a class="dropdown-item" href="{{ route('pages.user.riwayat') }}">Riwayat Peminjaman Saya</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth

                @guest
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('login') }}">Login</a></li>
                @endguest
            </ul>
        </div>
    </nav>

    {{-- Konten --}}
    <main class="flex-fill">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="text-white text-center py-2 mt-auto" style="background-color: #003366;">
        Copyright © 2025 Jurnalistik Pinjam
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>