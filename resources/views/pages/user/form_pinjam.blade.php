@extends('layouts.app-user')

@section('content')
<!-- Formulir Peminjaman -->
<div class="container form-section">
    <div class="form-title">Formulir Peminjaman</div>
    <form method="POST" action="{{ route('peminjaman.store') }}">
        @csrf

        <h6><strong>Identitas Peminjam</strong></h6>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nama Lengkap</label>
                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label>Instansi<span class="text-danger">*</span></label>
                <input type="text" name="instansi" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>No. Telepon</label>
                <input type="text" class="form-control" value="{{ auth()->user()->phone }}" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
            </div>
        </div>

        <h6 class="mt-4"><strong>Peminjaman</strong></h6>
        <div class="mb-3">
            <label>Deskripsi Kegiatan<span class="text-danger">*</span></label>
            <textarea name="activity_description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="fasilitas_id" class="form-label">Fasilitas</label>
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


            <div class="col-md-6 mb-3">
                <label>Jumlah Unit<span class="text-danger">*</span></label>
                <input type="number" name="unit_amount" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Peminjaman<span class="text-danger">*</span></label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Pengembalian<span class="text-danger">*</span></label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Jam Mulai<span class="text-danger">*</span></label>
                <input type="time" name="start_time" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Jam Berakhir<span class="text-danger">*</span></label>
                <input type="time" name="end_time" class="form-control" required>
            </div>
        </div>

        <div class="clearfix mt-4">
            <button type="submit" class="btn btn-submit float-end">Ajukan Peminjaman</button>
        </div>

    </form>
</div>
@endsection