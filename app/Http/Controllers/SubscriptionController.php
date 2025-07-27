<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    /**
     * Membatalkan langganan aktif pengguna, melakukan logout,
     * dan mengarahkannya ke halaman welcome.
     */
    public function cancel(Request $request)
    {
        // Dapatkan pengguna yang sedang login
        $user = Auth::user();

        // Cari langganan aktif milik pengguna
        $subscription = Subscription::where('user_id', $user->id)
                                    ->where('status', 'active')
                                    ->first();

        if ($subscription) {
            // Ubah status menjadi 'cancelled'
            $subscription->status = 'cancelled';
            $subscription->save();

            // Hapus juga paket saat ini dari data user
            $user->current_package = null;
            $user->save();

            // Logout pengguna
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Arahkan ke halaman welcome dengan pesan sukses
            return redirect()->route('welcome')->with('success', 'Anda telah berhasil berhenti berlangganan. Sampai jumpa lagi!');
        }

        // Jika tidak ada langganan aktif, kembalikan ke halaman akun dengan error
        return redirect()->route('account')->with('error', 'Tidak ada langganan aktif yang ditemukan.');
    }
}
