@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Fasilitas</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <form action="/fasilitas" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="form-group mb-3">
                            <label for="image">Gambar</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="name">Nama Fasilitas</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback">
                                    {{ $message}}
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="stock">Stok</label>
                            <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}">
                            @error('stock')
                                <span class="invalid-feedback">
                                    {{ $message}}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="condition">Kondisi</label>
                            <input type="text" name="condition" id="condition" class="form-control @error('condition') is-invalid @enderror" value="{{ old('condition') }}">
                            @error('condition')
                                <span class="invalid-feedback">
                                    {{ $message}}
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="completeness">Kelengkapan</label>
                            <textarea name="completeness" id="completeness" cols="30" rows="10" class="form-control" value="{{ old('completeness') }}"></textarea>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-end" style="gap: 10px">
                                <a href="/fasilitas" class="btn btn-outline-secondary">
                                    kembali
                                </a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>

                    </form>
                </div>
                
            </div>
        </div>
    </div>
@endsection
