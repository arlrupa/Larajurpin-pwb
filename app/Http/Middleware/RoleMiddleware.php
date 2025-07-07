<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $role = $user->role;

        // Daftar nama route yang diizinkan per role
        $allowedRouteNames = [
            'admin' => [
                'dashboard',
                'users.*',
                'fasilitas.*',
                'riwayatpeminjaman',
                'peminjaman.update',
                'peminjaman.kembalikan',
                'peminjaman.tolakForm',
                'peminjaman.tolak',
            ],
            'user' => [
                'pages.user.profile',
                'pages.user.riwayat',
                'peminjaman.create',
                'peminjaman.store',
            ],
        ];

        // Cek apakah route saat ini cocok dengan daftar yang diizinkan
        foreach ($allowedRouteNames[$role] ?? [] as $pattern) {
            if ($request->routeIs($pattern)) {
                return $next($request);
            }
        }

        // Kalau tidak diizinkan
        abort(403, 'Akses ditolak: Anda tidak memiliki izin ke halaman ini.');
    }
}
