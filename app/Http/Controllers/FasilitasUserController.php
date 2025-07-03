<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasUserController extends Controller
{
    public function indexHome()
    {
        $$fasilitas = Fasilitas::take(3)->get();

        return view('pages.user.home', compact('fasilitas'));
    }

    public function indexFasilitas()
    {
        $fasilitas = Fasilitas::all();
        return view('pages.user.peminjaman-fasilitas', compact('fasilitas'));
    }

    public function show($id)
    {
        $fasilitas = \App\Models\Fasilitas::findOrFail($id);
        return view('pages.user.show', compact('fasilitas'));
    }

}
