@extends('layouts.app-user')

@section('title', 'Riwayat Pengguna')

@section('content')
{{-- Main Content --}}
<main class="container my-4">
    <h4 class="text-center mb-4">Riwayat Peminjaman</h4>

    {{-- Tampilkan notifikasi email --}}
    @foreach($notifications as $notif)
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <strong>Status:</strong> {{ $notif->data['status'] }}<br>
        <strong>Keterangan:</strong> {{ $notif->data['keterangan'] }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endforeach

    <table class="table table-bordered text-center">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Tanggal Peminjaman & Pengembalian</th>
                <th>Fasilitas/Jumlah Unit</th>
                <th>Peminjam</th>
                <th>No. Telepon</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $index => $booking)
            <tr style="background-color: #f2f2f2">
                <td>{{ $index + 1 }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($booking->start_date)->format('d-m-Y') }} {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($booking->end_date)->format('d-m-Y') }} {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                </td>
                <td>{{ $booking->fasilitas->name ?? '-' }} ({{ $booking->unit_amount }})</td>
                <td>{{ $booking->user->name }}</td>
                <td>{{ $booking->user->phone }}</td>
                <td>
                    @if($booking->status == 'diterima')
                    <span class="badge bg-info text-dark">Diterima</span>
                    @elseif($booking->status == 'dipinjam')
                    <span class="badge bg-warning text-dark">Dipinjam</span>
                    @elseif($booking->status == 'ditolak')
                    <span class="badge bg-danger text-white">Ditolak</span><br>
                    <small class="text-danger"><i class="bi bi-exclamation-circle"></i> {{ $booking->keterangan_penolakan }}</small>
                    @else
                    <span class="badge bg-secondary">Menunggu</span>
                    @endif
                </td>
                <td>
                    @if($booking->status == 'dipinjam')
                    <form action="{{ route('booking.kembalikan', $booking->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengembalikan?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-danger">Kembalikan</button>
                    </form>
                    @else
                    <span class="text-muted">Selesai</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</main>
@endsection