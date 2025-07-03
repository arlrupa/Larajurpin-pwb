@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2 bg-primary text-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-lg font-weight-bold mb-1">Jumlah Fasilitas</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $jumlahFasilitas }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-layer-group fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2 bg-info text-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-lg font-weight-bold mb-1">Total Peminjaman</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $totalPeminjaman }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow h-100 py-2 bg-dark text-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-lg font-weight-bold mb-1">Total Users</div>
                            <div class="h4 mb-0 font-weight-bold">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kalender -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Kalender Peminjaman</h6>
            <div>
                <button class="btn btn-sm btn-outline-primary active">Per Bulan</button>
                <button class="btn btn-sm btn-outline-secondary">Per Minggu</button>
                <button class="btn btn-sm btn-outline-secondary">Per Tahun</button>
            </div>
        </div>
        <div class="card-body">
            <!-- Placeholder kalender -->
            <div style="height: 500px; background-color: #f8f9fc; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center;">
                <span class="text-muted">Kalender akan ditampilkan di sini</span>
            </div>
        </div>
    </div>
</div>
@endsection