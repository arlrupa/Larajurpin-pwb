<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

        $allowedRoutes = [
            'admin' => [
                'dashboard*',
                'users*',
                'fasilitas*',
                'riwayat-peminjaman*',
                'peminjaman/*/terima',
                'peminjaman/*/tolak',
                'peminjaman/kembalikan/*',
                'booking/*/kembalikan',
            ],
            'user' => [
                'profile*',
                'pinjam*',
                'riwayat*',
                'user/riwayat*',
            ],
        ];

        foreach ($allowedRoutes[$role] ?? [] as $pattern) {
            if ($request->is($pattern)) {
                return $next($request);
            }
        }

        abort(403, 'Akses ditolak: Anda tidak memiliki izin ke halaman ini.');
    }
}
