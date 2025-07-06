<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Fasilitas;
use Carbon\Carbon;

class DashboardController extends Controller
{


public function index()
{
    $jumlahFasilitas = Fasilitas::count();
    $totalUsers = User::count();
    $totalPeminjaman = Booking::count();

    // Ambil data booking untuk kalender
    $events = Booking::with('fasilitas')->get()->map(function ($booking) {
        return [
            'id' => $booking->id,
            'title' => $booking->fasilitas->name ?? 'Tidak diketahui',
            'start' => $booking->start_date,
            'end' => $booking->end_date,
        ];
    });

    return view('pages.fasilitas.dashboard', compact('jumlahFasilitas', 'totalPeminjaman', 'totalUsers', 'events'));
}

}
