<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Fasilitas;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Tampilkan form peminjaman, menerima ID fasilitas dari query string
    public function create(Request $request)
    {
        $daftarFasilitas = Fasilitas::all();
        $fasilitas = null;

        if ($request->has('facility_id')) {
            $fasilitas = Fasilitas::find($request->facility_id);
        }

        return view('pages.user.form_pinjam', compact('fasilitas', 'daftarFasilitas'));
    }

    // Proses form peminjaman
    public function store(Request $request)
    {
        $validated = $request->validate([
            'instansi' => 'required|string',
            'activity_description' => 'required|string',
            'fasilitas_id' => 'required|numeric',
            'unit_amount' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        // Jika di hari yang sama, pastikan jam berakhir > jam mulai
        if (
            $validated['start_date'] == $validated['end_date'] &&
            $validated['start_time'] >= $validated['end_time']
        ) {
            return redirect()->back()->withInput()->with('error', 'Jam berakhir harus lebih besar dari jam mulai.');
        }

        //$user = Auth::user();

        Booking::create([
            'user_id' => Auth::id(),
            'instansi' => $validated['instansi'],
            'activity_description' => $validated['activity_description'],
            'fasilitas_id' => $validated['fasilitas_id'],
            'unit_amount' => $validated['unit_amount'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => 'menunggu',
        ]);

        return redirect()->route('pages.user.riwayat')->with('success', 'Peminjaman berhasil diajukan!');
    }

    // Tampilkan Riwayat Peminjaman
    public function riwayat()
    {
        $user = Auth::user();

        $bookings = Booking::with(['fasilitas', 'user'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $notifications = $user->unreadNotifications;

        $user->unreadNotifications->markAsRead();

        return view('pages.user.riwayat', compact('bookings', 'notifications'));
    }


    public function kembalikan($id)
    {
        $pinjam = Booking::findOrFail($id);

        if ($pinjam->status_pengembalian === 'sudah') {
            return redirect()->back()->with('info', 'Fasilitas ini sudah dikembalikan.');
        }

        $pinjam->status_pengembalian = 'sudah';
        $pinjam->save();

        $pinjam->fasilitas->increment('stock', $pinjam->unit_amount);

        return redirect()->back()->with('success', 'Status pengembalian berhasil diperbarui, stok telah ditambahkan.');
    }
}
