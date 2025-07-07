<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\FasilitasUserController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\RiwayatPinjamController;
use App\Http\Controllers\UserController;
use App\Models\Fasilitas;
use App\Models\Booking;

// Auth Route
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Public Routes
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

Route::get('/peminjaman-fasilitas', function () {
    $fasilitas = Fasilitas::all();
    return view('pages.user.peminjaman-fasilitas', compact('fasilitas'));
})->name('peminjaman.fasilitas');

Route::get('/detail/{id}', [FasilitasUserController::class, 'show'])->name('fasilitas.show');

// Protected Routes (Role-based with role.access middleware)
Route::middleware(['auth', 'role.access'])->group(function () {

    // USER Routes
    Route::get('/profile', fn() => view('pages.user.profile'))->name('pages.user.profile');

    Route::get('/user/riwayat', [BookingController::class, 'riwayat'])->name('pages.user.riwayat');

    Route::get('/pinjam', [BookingController::class, 'create'])->name('peminjaman.create');
    Route::post('/pinjam', [BookingController::class, 'store'])->name('peminjaman.store');

    // ADMIN Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');
    Route::get('/fasilitas/create', [FasilitasController::class, 'create'])->name('fasilitas.create');
    Route::get('/fasilitas/{id}', [FasilitasController::class, 'edit'])->name('fasilitas.edit');
    Route::post('/fasilitas', [FasilitasController::class, 'store'])->name('fasilitas.store');
    Route::put('/fasilitas/{id}', [FasilitasController::class, 'update'])->name('fasilitas.update');
    Route::delete('/fasilitas/{id}', [FasilitasController::class, 'destroy'])->name('fasilitas.destroy');

    Route::get('/riwayat-peminjaman', [RiwayatPinjamController::class, 'index'])->name('riwayatpeminjaman');

    Route::post('/peminjaman/{id}/update', [RiwayatPinjamController::class, 'update'])->name('peminjaman.update');
    Route::get('/peminjaman/kembalikan/{id}', [BookingController::class, 'kembalikan'])->name('peminjaman.kembalikan');

    Route::get('/peminjaman/{id}/tolak', [BookingController::class, 'formTolak'])->name('peminjaman.tolakForm');
    Route::post('/peminjaman/{id}/tolak', [BookingController::class, 'tolak'])->name('peminjaman.tolak');
});

// Notifikasi Peminjaman di Web
Route::post('/notifications/{id}/read', [NotifikasiController::class, 'markAsRead'])->middleware('auth')->name('notifications.read');


// Test Email Route (Contoh)
use App\Models\User;
use App\Notifications\PeminjamanStatusNotification;
use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    Mail::raw('Ini email test', function ($message) {
        $message->to('wulanviniaprilia@gmail.com')->subject('Tes SMTP');
    });

    return 'Email test dikirim!';
});
