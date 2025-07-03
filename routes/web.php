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

// kode yang sebelumnya (bisa dihapus)
// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
// }); 

/*
| Public Routes
*/
// Home
Route::get('/', function () {
    $fasilitas = Fasilitas::all();
    $events = Booking::select(
        'id',
        'activity_description as title',
        'start_date as start',
        'end_date as end'
    )->get();
    return view('pages.user.home', compact('fasilitas', 'events'));
})->name('home');

// Peminjaman Fasilitas
Route::get('/peminjaman-fasilitas', function () {
    $fasilitas = Fasilitas::all();
    return view('pages.user.peminjaman-fasilitas', compact('fasilitas'));
})->name('peminjaman.fasilitas');

Route::get('/detail/{id}', [FasilitasUserController::class, 'show'])->name('fasilitas.show');

// kode fasilitas user yang sebelumnya (bisa dihapus)
// Route::get('/home', [FasilitasUserController::class, 'indexHome'])->middleware('auth')->name('home');
// Route::get('/peminjaman-fasilitas', [FasilitasUserController::class, 'indexFasilitas'])->middleware('auth');

/*
| Protected Routes (auth middleware)
*/
Route::middleware(['auth'])->group(function () {

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
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/users', [UserController::class, 'index']);

// Riwayat Semua Peminjaman (Admin)
Route::get('/riwayat-peminjaman', [RiwayatPinjamController::class, 'index'])->name('riwayatpeminjaman');

// Konfirmasi dan Pengembalian Peminjaman
Route::get('/peminjaman/{id}/terima', [BookingController::class, 'terima'])->name('peminjaman.terima');
//Route::get('/peminjaman/{id}/tolak', [BookingController::class, 'tolak'])->name('peminjaman.tolak');
Route::patch('/booking/{id}/kembalikan', [BookingController::class, 'kembalikan'])->name('booking.kembalikan');
Route::get('/peminjaman/kembalikan/{id}', [BookingController::class, 'kembalikan'])->name('peminjaman.kembalikan');

// Tampilkan form alasan penolakan (jika masih dipakai)
Route::get('peminjaman/{id}/tolak', [BookingController::class, 'formTolak'])->name('peminjaman.tolakForm');

// Proses penolakan
Route::post('peminjaman/{id}/tolak', [BookingController::class, 'tolak'])->name('peminjaman.tolak');


// contoh
Route::get('/test-email', function () {
    Mail::raw('Ini adalah email percobaan dari JURPIN', function ($message) {
        $message->to('wulanviniaprilia@gmail.com') // Ganti dengan email kamu
                ->subject('Cek Email dari JURPIN');
    });

    return 'Email dikirim!';
});