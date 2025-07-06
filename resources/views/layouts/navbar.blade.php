<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    @if (Request::is('fasilitas') || Request::is('fasilitas*') || Request::is('riwayat-peminjaman'))
    <form action="{{ Request::is('riwayat-peminjaman') ? route('riwayatpeminjaman') : route('fasilitas.index') }}" method="GET"
        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input
                type="{{ Request::is('riwayat-peminjaman') ? 'date' : 'text' }}"
                name="{{ Request::is('riwayat-peminjaman') ? 'tanggal' : 'search' }}"
                id="search-navbar"
                class="form-control bg-light border-0 small"
                placeholder="{{ Request::is('riwayat-peminjaman') ? 'Cari Tanggal...' : 'Cari...' }}"
                autocomplete="off"
                value="{{ Request::is('riwayat-peminjaman') ? request('tanggal') : request('search') }}">
            <div class="input-group-append">
                <button class="btn" type="submit" style="background: #E8EAEB">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>
    @endif


    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                <img class="img-profile rounded-circle"
                    src="{{ asset('template/img/profile.png')}}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">

                {{-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a> --}}

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>