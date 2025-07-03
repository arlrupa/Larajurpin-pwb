@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Konfirmasi Peminjaman</h1>
    </div>

    {{-- FORM FILTER TANGGAL --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('riwayatpeminjaman') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="tanggal" class="form-label fw-semibold">Filter Tanggal Peminjaman</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ request('tanggal') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i>
                    </button>
                    <a href="{{ route('riwayatpeminjaman') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>


    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="text-white" style="background-color: #034078;">
                <tr>
                    <th>No</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Fasilitas / Jumlah Unit</th>
                    <th>Peminjam</th>
                    <th>No. Telepon</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pending as $index => $pinjam)
                <tr style="background-color: #E8EAEB;">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pinjam->start_date }}</td>
                    <td>{{ $pinjam->end_date }}</td>
                    <td>{{ $pinjam->fasilitas->name ?? '-' }} / {{ $pinjam->unit_amount }}</td>
                    <td>{{ $pinjam->user->name }}</td>
                    <td>{{ $pinjam->user->phone }}</td>
                    <td>
                        <span class="badge bg-warning text-dark">Menunggu</span>
                    </td>
                    <td>
                        <a href="{{ route('peminjaman.terima', $pinjam->id) }}" class="btn btn-success btn-sm" title="Terima Peminjaman">
                            <i class="bi bi-check-circle"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTolak{{ $pinjam->id }}">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </td>
                </tr>

                <!-- Modal Tolak -->
                <div class="modal fade" id="modalTolak{{ $pinjam->id }}" tabindex="-1" aria-labelledby="modalTolakLabel{{ $pinjam->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('peminjaman.tolak', $pinjam->id) }}">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="modalTolakLabel{{ $pinjam->id }}">Tolak Peminjaman</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Nama:</strong> {{ $pinjam->user->name }}</p>
                                    <p><strong>Fasilitas:</strong> {{ $pinjam->fasilitas->name ?? '-' }}</p>

                                    <div class="mb-3">
                                        <label for="keterangan_penolakan" class="form-label">Alasan Penolakan</label>
                                        <textarea name="keterangan_penolakan" class="form-control" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Tolak Peminjaman</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Peminjaman</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="text-white" style="background-color: #034078;">
                <tr>
                    <th>No</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Fasilitas / Jumlah Unit</th>
                    <th>Peminjam</th>
                    <th>No. Telepon</th>
                    <th>Status</th>
                    <th>Pengembalian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($approved as $index => $pinjam)
                <tr style="background-color: #E8EAEB;">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pinjam->start_date }}</td>
                    <td>{{ $pinjam->end_date }}</td>
                    <td>{{ $pinjam->fasilitas->name ?? '-' }} / {{ $pinjam->unit_amount }}</td>
                    <td>{{ $pinjam->user?->name ?? '-' }}</td>
                    <td>{{ $pinjam->user?->phone ?? '-' }}</td>
                    <td>
                        <span class="badge bg-success text-dark">Diterima</span>
                    </td>
                    <td>
                        @if ($pinjam->status_pengembalian === 'belum')
                        <span class="badge bg-danger text-white">Belum Dikembalikan</span>
                        @else
                        <span class="badge bg-warning text-dark">Sudah Dikembalikan</span>
                        @endif
                    </td>
                    <td>
                        @if ($pinjam->status_pengembalian === 'belum')
                        <a href="{{ route('peminjaman.kembalikan', $pinjam->id) }}" class="btn btn-primary btn-sm" title="Tandai sebagai dikembalikan">
                            <i class="bi bi-arrow-return-left"></i> Kembalikan
                        </a>
                        @else
                        <span class="text-muted">Selesai</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection