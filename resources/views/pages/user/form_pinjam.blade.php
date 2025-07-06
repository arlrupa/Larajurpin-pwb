@extends('layouts.app-user')

@section('content')
<div class="container my-4">
    <div class="mb-4">
        <h4 class="text-center fw-bold">Formulir Peminjaman</h4>
    </div>

    <form method="POST" action="{{ route('peminjaman.store') }}">
        @csrf

        <h6 class="fw-bold">Identitas Peminjam</h6>

        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
        </div>

        <div class="mb-3">
            <label>Instansi<span class="text-danger">*</span></label>
            <input type="text" name="instansi" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>No. Telepon</label>
            <input type="text" class="form-control" value="{{ auth()->user()->phone }}" readonly>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
        </div>

        <h6 class="fw-bold mt-4">Peminjaman</h6>

        <div class="mb-3">
            <label>Deskripsi Kegiatan<span class="text-danger">*</span></label>
            <textarea name="activity_description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label>Fasilitas<span class="text-danger">*</span></label>
            <select name="fasilitas_id" class="form-control" required>
                <option value="">-- Pilih Fasilitas --</option>
                @foreach($daftarFasilitas as $item)
                    <option value="{{ $item->id }}"
                        {{ (isset($fasilitas) && $fasilitas->id == $item->id) ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Jumlah Unit<span class="text-danger">*</span></label>
            <input type="number" name="unit_amount" class="form-control" required>
        </div>

        <!-- punya wulan -->
        <div class="mb-3">
            <label>Tanggal Mulai Peminjaman<span class="text-danger">*</span></label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jam Mulai<span class="text-danger">*</span></label>
            <input type="time" name="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tanggal Selesai Peminjaman<span class="text-danger">*</span></label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jam Selesai<span class="text-danger">*</span></label>
            <input type="time" name="end_time" class="form-control" required>
        </div>

        <small class="text-muted d-block mb-3">Contoh: dari 01/08/2025 jam 08:00 sampai 03/08/2025 jam 10:00</small>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
        </div>
    </form>
</div>
@endsection
