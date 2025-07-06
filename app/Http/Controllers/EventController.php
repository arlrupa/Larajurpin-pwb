<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class EventController extends Controller
{
//     public function index()
//     {
//         $events = Booking::select('id', 'name as title', 'start_date as start', 'end_date as end')
//         ->get();

//         return view('calender.events', compact('events'));
//     }

public function index()
{
    $events = Booking::with('fasilitas')->get()->map(function ($booking) {
        return [
            'id' => $booking->id,
            'title' => $booking->fasilitas->name ?? 'Tidak diketahui',
            'start' => $booking->start_date,
            'end' => $booking->end_date,
        ];
    });

    return view('calender.events', compact('events'));
}

}