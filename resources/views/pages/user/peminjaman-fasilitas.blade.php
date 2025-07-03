@extends(Auth::check() ? 'layouts.app-user' : 'layouts.app-guest')

@section('title', 'Peminjaman Fasilitas')

@section('content')
<!-- Facilities Section -->
<div class="container mt-2 pt-2">

    <div class="container py-5">
        <h2 class="text-center mb-4">Fasilitas JURPIN</h2>
        <div class="row justify-content-center">
            @foreach ($fasilitas as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100 p-2">
                    <!-- Gambar dibungkus agar selalu seragam -->
                    <div class="d-flex justify-content-center align-items-center"
                        style="height: 240px; overflow: hidden;">
                        @if ($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}"
                            alt="{{ $item->name }}"
                            style="width: 180px; height: 180px; object-fit: cover;">
                        @else
                        <img src="{{ asset('default-image.jpg') }}"
                            alt="Default"
                            style="width: 180px; height: 180px; object-fit: cover;">
                        @endif
                    </div>

                    <div class="card-body">
                        <h5 class="card-title text-start">{{ $item->name }}</h5>
                        <p class="text-start">Stok: {{ $item->stock }}</p>
                        <p class="text-start">Kondisi: {{ $item->condition }}</p>
                        <div class="text-start">
                            <a href="{{ route('fasilitas.show', $item->id) }}" class="btn btn-fasilitas">Pinjam</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection