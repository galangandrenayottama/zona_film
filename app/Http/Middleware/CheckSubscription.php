<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $status)
    {
        $user = Auth::user();

        // Cek apakah pengguna memiliki paket aktif di tabel 'users'
        $isSubscribed = !is_null($user->current_package);

        // Logika untuk rute yang MEMERLUKAN langganan
        if ($status === 'subscribed') {
            if ($isSubscribed) {
                // Jika pengguna berlangganan, izinkan akses
                return $next($request);
            } else {
                // Jika tidak, arahkan ke halaman pemilihan paket
                return redirect()->route('paket')->with('error', 'Anda harus berlangganan untuk mengakses halaman ini.');
            }
        }

        // Logika untuk rute yang TIDAK MEMERLUKAN langganan (misal: halaman pembayaran)
        if ($status === 'not_subscribed') {
            if (!$isSubscribed) {
                // Jika pengguna belum berlangganan, izinkan akses
                return $next($request);
            } else {
                // Jika sudah, arahkan ke home karena mereka tidak perlu memilih paket lagi
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
