<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\FasilitasUserController;
use App\Http\Controllers\RiwayatPinjamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use App\Models\Booking;
use App\Models\Fasilitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;


/*
| Authentication Routes
*/
// Login & Register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Home
Route::get('/', function () {
    $fasilitas = Fasilitas::all();

    $events = Booking::with('fasilitas')->get()->map(function ($booking) {
        return [
            'id' => $booking->id,
            'title' => $booking->fasilitas->name ?? 'Tidak diketahui',
            'start' => $booking->start_date,
            'end' => $booking->end_date,
        ];
    });

    return view('pages.user.home', compact('fasilitas', 'events'));
})->name('home');

// Peminjaman Fasilitas
Route::get('/peminjaman-fasilitas', function () {
    $fasilitas = Fasilitas::all();
    return view('pages.user.peminjaman-fasilitas', compact('fasilitas'));
})->name('peminjaman.fasilitas');

Route::get('/detail/{id}', [FasilitasUserController::class, 'show'])->name('fasilitas.show');

/*
| Protected Routes (auth middleware)
*/
Route::middleware(['role.access'])->group(function () {

    // Profil
    Route::get('/profile', function () {
        return view('pages.user.profile');
    })->name('pages.user.profile');

    // User Riwayat
    Route::get('/user/riwayat', [BookingController::class, 'riwayat'])->name('pages.user.riwayat');

    // Form Peminjaman
    Route::get('/pinjam', [BookingController::class, 'create'])->name('peminjaman.create');
    Route::post('/pinjam', [BookingController::class, 'store'])->name('peminjaman.store');

    // Riwayat Peminjaman User
    Route::get('/riwayat', [BookingController::class, 'riwayat'])->name('pages.user.riwayat');

    // Fasilitas (Admin)
    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');
    Route::get('/fasilitas/create', [FasilitasController::class, 'create'])->name('fasilitas.create');
    Route::get('/fasilitas/{id}', [FasilitasController::class, 'edit'])->name('fasilitas.edit');
    Route::post('/fasilitas', [FasilitasController::class, 'store'])->name('fasilitas.store');
    Route::put('/fasilitas/{id}', [FasilitasController::class, 'update'])->name('fasilitas.update');
    Route::delete('/fasilitas/{id}', [FasilitasController::class, 'destroy'])->name('fasilitas.destroy');
});

/*
| Admin Dashboard and Management
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/users', [UserController::class, 'index']);

// Riwayat Semua Peminjaman (Admin)
Route::get('/riwayat-peminjaman', [RiwayatPinjamController::class, 'index'])->name('riwayatpeminjaman');

// Konfirmasi dan Pengembalian Peminjaman
Route::post('/peminjaman/{id}/update', [RiwayatPinjamController::class, 'update'])->name('peminjaman.update');
Route::get('/peminjaman/kembalikan/{id}', [BookingController::class, 'kembalikan'])->name('peminjaman.kembalikan');

// Tampilkan form alasan penolakan (jika masih dipakai)
Route::get('peminjaman/{id}/tolak', [BookingController::class, 'formTolak'])->name('peminjaman.tolakForm');

// Proses penolakan
Route::post('peminjaman/{id}/tolak', [BookingController::class, 'tolak'])->name('peminjaman.tolak');


// contoh notif aja ini
use App\Models\User;
use App\Notifications\PeminjamanStatusNotification;

Route::get('/test-email', function () {
    $user = User::find(3); 

    if (!$user) {
        return 'User dengan ID 3 tidak ditemukan.';
    }

    $user->notify(new PeminjamanStatusNotification('diterima', 'Contoh keterangan'));
    return 'Email berhasil dikirim ke ' . $user->email;
});
