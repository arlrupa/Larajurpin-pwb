@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Fasilitas</h1>
        <a href="/fasilitas/create" class="d-none d-sm-inline-block btn btn-sm shadow-sm" style="background-color: #1282A2; color: white"><i
                class="fas fa-plus fa-sm" style="color: white"></i> Tambah </a>
    </div>

    {{-- Table --}}
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-responsive table-boardered table-hovered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Stok</th>
                                <th>Kondisi</th>
                                <th>Kelengkapan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        @if (count($fasilitas) < 1)
                        <tbody>
                            <tr>
                                <td colspan="5">
                                    <p class="text-center">Tidak ada data</p>
                                </td>
                            </tr>
                        </tbody>
                        @else
                            <tbody>
                                @foreach ($fasilitas as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if (isset($item->image))
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="Gambar" style="max-width: 120px; max-height: 120px; object-fit: cover;">

                                            
                                        @else
                                            Tidak ada
                                        @endif
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->stock }}</td>
                                    <td>{{ $item->condition }}</td>
                                    <td>{{ $item->completeness }}</td>
                                    
                                    <td>
                                        <div class="d-flex">
                                            <a href="/fasilitas/{{ $item->id }}" class="d-inline-block mr-2 btn btn-sm btn-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @include('pages.fasilitas.confirmation-delete')
                                @endforeach
                                
                            </tbody>
                            
                        @endif
                        
                    </table>

                </div>
                
            </div>
        </div>
    </div>
@endsection