<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class EventController extends Controller
{
    public function index()
    {
        $events = Booking::select('id', 'activity_description as title', 'start_date as start', 'end_date as end')
        ->get();

        return view('calender.events', compact('events'));
}
}
