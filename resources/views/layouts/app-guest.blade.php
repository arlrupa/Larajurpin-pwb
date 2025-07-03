<!-- resources/views/layouts/app-guest.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'JURPIN')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles') {{-- << tambahkan ini --}}
    @stack('scripts')
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
        padding: 5px 10px;
        border-radius: 5px;
        border: none;
        font-size: 16px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-fasilitas:hover {
        background-color: #C7CCCE;
        color: white;
    }
</style>
</head>

<body class="d-flex flex-column min-vh-100">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand text-white" href="#"><strong>JURPIN</strong></a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <strong>Home</strong>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('peminjaman.fasilitas') ? 'active' : '' }}" href="{{ route('peminjaman.fasilitas') }}">
                            Fasilitas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten --}}
    <main class="flex-fill">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="text-center p-3 mt-auto">
        Copyright © 2025 Jurnal Pinjam
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>