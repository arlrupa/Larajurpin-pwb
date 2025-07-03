<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Fasilitas;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahFasilitas = Fasilitas::count();
        $totalUsers = User::count();
        $totalPeminjaman = Booking::count();

        // // Dummy data kalender
        // $events = [
        //     [
        //         'title' => 'Peminjaman Kamera',
        //         'start' => '2025-06-01',
        //         'end'   => '2025-06-02'
        //     ],
        //     [
        //         'title' => 'Peminjaman Tripod',
        //         'start' => '2025-06-05',
        //     ]
        // ];


        return view('pages.fasilitas.dashboard', compact('jumlahFasilitas', 'totalPeminjaman', 'totalUsers',));
    }
}
