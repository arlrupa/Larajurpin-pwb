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
            'end_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $user = Auth::user();

        Booking::create([
            'user_id' => $user->id ?? 1,
            'instansi' => $validated['instansi'],
            'activity_description' => $validated['activity_description'],
            'fasilitas_id' => $validated['fasilitas_id'],
            'unit_amount' => $validated['unit_amount'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);


        return redirect()->route('pages.user.riwayat')->with('success', 'Peminjaman berhasil diajukan!');
    }

    // Tampilkan Riwayat Peminjaman
    public function riwayat()
    {
        $userId = Auth::id();

        $bookings = Booking::with(['fasilitas', 'user'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $notifications = Auth::user()->notifications;

        return view('pages.user.riwayat', compact('bookings', 'notifications'));
    }

    public function terima($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'diterima';
        $booking->save();

        return redirect()->back()->with('success', 'Peminjaman telah diterima.');
    }

    public function tolak(Request $request, $id)
    {

        $request->validate([
            'keterangan_penolakan' => 'required|string|max:500',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = 'ditolak';
        $booking->keterangan_penolakan = $request->keterangan_penolakan;
        $booking->save();

        return redirect()->route('riwayatpeminjaman')->with('success', 'Peminjaman telah ditolak dengan alasan.');
    }

    public function kembalikan($id)
    {
        $pinjam = Booking::findOrFail($id);

        if ($pinjam->status_pengembalian === 'sudah') {
            return redirect()->back()->with('info', 'Fasilitas ini sudah dikembalikan.');
        }

        $pinjam->status_pengembalian = 'sudah';
        $pinjam->save();

        return redirect()->back()->with('success', 'Status pengembalian berhasil diperbarui.');
    }
}
