<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth; // ✅ Perbaikan di sini
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Ambil role user yang sedang login
        $userRole = Auth::user()->role;

        // Cek apakah role user ada di dalam daftar role yang diizinkan
        if (in_array($userRole, $roles)) {
            // Jika ya, lanjutkan request
            return $next($request);
        }

        // Jika tidak, kembalikan halaman error 403 (Forbidden)
        abort(403, 'UNAUTHORIZED ACTION.');
    }
}
