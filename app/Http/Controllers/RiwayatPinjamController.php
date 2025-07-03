<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\PeminjamanStatusNotification;
use Illuminate\Support\Facades\Log;

class RiwayatPinjamController extends Controller
{
    // Menampilkan halaman riwayat peminjaman admin
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');

        if ($tanggal && !strtotime($tanggal)) {
            return redirect()->back()->with('error', 'Format tanggal tidak valid.');
        }

        $pending = Booking::with(['user', 'fasilitas'])
            ->whereHas('user')
            ->when($tanggal, function ($query) use ($tanggal) {
                $query->whereDate('start_date', $tanggal);
            })
            ->where('status', 'menunggu')
            ->get();

        $approved = Booking::with(['user', 'fasilitas'])
            ->whereHas('user')
            ->when($tanggal, function ($query) use ($tanggal) {
                $query->whereDate('start_date', $tanggal);
            })
            ->whereIn('status', ['diterima', 'dipinjam', 'selesai'])
            ->get();

        return view('pages.fasilitas.riwayatpeminjaman', compact('pending', 'approved'));
    }

    // Mengubah status peminjaman dan mengirim notifikasi ke user
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak,dipinjam,selesai',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->keterangan_penolakan = $request->keterangan;
        $booking->save();

        if ($booking->user) {
            try {
                Log::info("Proses kirim notifikasi email ke user: " . $booking->user->email);

                $booking->user->notify(new PeminjamanStatusNotification(
                    $booking->status,
                    $booking->keterangan_penolakan
                ));

                Log::info("Notifikasi berhasil dikirim ke: " . $booking->user->email);
            } catch (\Exception $e) {
                Log::error("Gagal mengirim notifikasi ke " . $booking->user->email . ': ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Status peminjaman berhasil diperbarui dan notifikasi dikirim.');
    }
}
