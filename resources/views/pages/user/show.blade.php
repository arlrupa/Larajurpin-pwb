@extends('layouts.app-user')

@section('title', 'Deskripsi Fasilitas')

@section('content')
<div class="main-content">
    <div class="container border p-5">
        <div class="row align-items-center">
            <div class="col-md-5 text-center">
                <img src="{{ asset('storage/' . $fasilitas->image) }}"
                    alt="{{ $fasilitas->name }}"
                    style="max-width: 280px; height: auto;">
            </div>

            <div class="col-md-7">
                <table class="table table-borderless" style="font-size: 14px;">
                    <tr>
                        <th style="width: 150px;">Nama Barang</th>
                        <td>: {{ $fasilitas->name }}</td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>: {{ $fasilitas->stock }}</td>
                    </tr>
                    <tr>
                        <th>Kondisi</th>
                        <td>: {{ $fasilitas->condition }}</td>
                    </tr>
                    <tr>
                        <th style="vertical-align: top;">Kelengkapan</th>
                        <td>: {!! nl2br(e($fasilitas->completeness)) !!}</td>
                    </tr>
                </table>

                {{-- <a href="" class="btn btn-fasilitas">Pinjam Sekarang</a> --}}
                <a href="{{ route('peminjaman.create', ['facility_id' => $fasilitas->id]) }}" class="btn btn-fasilitas">Pinjam</a>
            </div>
        </div>
    </div>
</div>

<div class="mt-3 text-start ms-5">
    <a href="/peminjaman-fasilitas" class="btn-back">
        <i class="fa-solid fa-arrow-left me-1"></i>
    </a>
</div>
@endsection