@extends(Auth::check() ? 'layouts.app-user' : 'layouts.app-guest')

@section('title', 'Home')

@section('content')
{{-- HERO SECTION --}}
<div class="tagline text-center p-5 mt-5" style="background-color: #1282A2;">
    <h2>Kemudahan Akses Fasilitas Jurnalistik<br> dalam Satu Platform Terpadu</h2>
    <a href="peminjaman-fasilitas" class="btn-selengkapnya mt-3">Selengkapnya</a>
</div>

{{-- FASILITAS --}}
<div class="container py-5">
    <h2 class="text-center mb-4">Fasilitas JURPIN</h2>
    <div class="row justify-content-center">
        @foreach ($fasilitas->take (3) as $item)
        <div class="col-md-4 mb-4">
            <div class="card h-100 p-2">
                <div class="d-flex justify-content-center align-items-center" style="height: 240px; overflow: hidden;">
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
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p>Stok: {{ $item->stock }}</p>
                    <p>Kondisi: {{ $item->condition }}</p>
                    <div class="text-start">
                        <a href="{{ route('fasilitas.show', $item->id) }}" class="btn btn-fasilitas">Pinjam</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- EVENTS CALENDAR --}}
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 p-4">
                <h2 class="text-center mb-4">Kalender Peminjaman</h2>
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>



@push('scripts')
<!-- FullCalendar CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/locales-all.global.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.17/index.global.min.js'></script>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap5',
            locale: 'id',
            events: @json($events),
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            }
        });

        calendar.render();
    });
</script> -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap5',
            locale: 'id',
            events: @json($events), // <-- ini ambil dari controller
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            }
        });

        calendar.render();
    });
</script>

@endpush

@endsection