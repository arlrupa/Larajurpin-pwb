<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\PeminjamanStatusNotification;
use Illuminate\Support\Facades\Log;


class RiwayatPinjamController extends Controller
{
    // halaman admin: riwayat peminjaman
    public function index(Request $request)
    {
        // filter data berdasarkan tgl
        $tanggal = $request->input('tanggal');

        if ($tanggal && !strtotime($tanggal)) {
            return redirect()->back()->with('error', 'Format tanggal tidak valid.');
        }

        // mengambil data dengan status menunggu, menggunakan Eloquent
        $pending = Booking::with(['user', 'fasilitas'])
            ->whereHas('user')
            ->when($tanggal, function ($query) use ($tanggal) {
                $query->whereDate('start_date', $tanggal);
            })
            ->where('status', 'menunggu')
            ->orderBy('created_at', 'desc') // urut dari yang terbaru
            ->get();

        // mengambil data dengan status   
        $approved = Booking::with(['user', 'fasilitas'])
            ->whereHas('user')
            ->when($tanggal, function ($query) use ($tanggal) {
                $query->whereDate('start_date', $tanggal);
            })
            ->whereIn('status', ['diterima', 'selesai'])
            ->get();

        return view('pages.fasilitas.riwayatpeminjaman', compact('pending', 'approved'));
    }

    // Ubah status peminjaman (admin)
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak,selesai',
            'keterangan_penolakan' => 'nullable|string|max:255',
        ]);

        $booking = Booking::findOrFail($id); // berdasarkan id

        // Cek stok saat ingin menerima
        if ($request->status === 'diterima') {
            if ($booking->fasilitas->stock < $booking->unit_amount) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk menyetujui peminjaman.');
            }

            $booking->fasilitas->decrement('stock', $booking->unit_amount); // stok berubah kalau udh disetujui
        }

        $booking->status = $request->status;

        if ($request->status === 'diterima') {
            $booking->keterangan_penolakan = 'Silahkan ambil barang di Sekretariat UKM Jurnalistik';
        } else {
            $booking->keterangan_penolakan = $request->keterangan_penolakan;
        }

        $booking->save();

        // Kirim notifikasi ke user
        if ($booking->user) {
            try {
                $booking->user->notify(new PeminjamanStatusNotification(
                    $booking->status,
                    $booking->keterangan_penolakan
                ));
            } catch (\Exception $e) {
                Log::error("Gagal kirim notifikasi ke {$booking->user->email}: {$e->getMessage()}");
            }
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui dan notifikasi dikirim.');
    }
}
