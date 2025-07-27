<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman pemilihan paket.
     */
    public function showPaket()
    {
        return view('jenis_paket');
    }

    /**
     * Memproses paket yang dipilih dan menyimpannya di session.
     */
    public function processPaketSelection(Request $request)
    {
        $data = $request->validate([
            'package_name' => 'required|string|in:Premium,Standar,Dasar',
            'price' => 'required|integer',
        ]);

        // Simpan paket yang dipilih ke dalam session untuk dibawa ke halaman pembayaran
        session(['selected_package' => $data]);

        return redirect()->route('pembayaran');
    }

    /**
     * Menampilkan halaman pembayaran.
     */
    public function showPembayaran()
    {
        // Ambil data paket dari session
        $package = session('selected_package');

        // Jika pengguna langsung ke halaman ini tanpa memilih paket, kembalikan
        if (!$package) {
            return redirect()->route('paket')->with('error', 'Silakan pilih paket terlebih dahulu.');
        }

        return view('pembayaran', ['package' => $package]);
    }

    /**
     * Memproses pembayaran.
     */
    public function processPembayaran(Request $request)
    {
        // Ambil paket dari session
        $package = session('selected_package');
        if (!$package) {
            return redirect()->route('paket')->with('error', 'Sesi paket tidak ditemukan. Silakan pilih ulang.');
        }

        // Validasi input dari form pembayaran
        $data = $request->validate([
            'metode' => 'required|string',
            'nomor' => 'nullable|string', // Nomor HP opsional
            'agree' => 'required',
        ]);

        // 1. Simpan data langganan ke database
        Subscription::create([
            'user_id' => Auth::id(),
            'package_name' => $package['package_name'],
            'price' => $package['price'],
            'payment_method' => $data['metode'],
            'paid_at' => now(),
        ]);

        // 2. Update status langganan di tabel user
        // CATATAN: Pastikan Anda sudah menambahkan kolom 'current_package' di tabel 'users'.
        // Jika belum, Anda bisa membuat migration baru: php artisan make:migration add_current_package_to_users_table
        $user = Auth::user();
        if ($user) {
            $user->current_package = $package['package_name'];
            $user->save();
        }

        // 3. Simpan detail pembayaran terakhir ke session untuk ditampilkan di halaman selesai
        session([
            'last_payment_amount' => $package['price'],
            'last_payment_package' => $package['package_name']
        ]);

        // 4. Hapus data paket dari session setelah berhasil diproses
        session()->forget('selected_package');

        // 5. Arahkan ke halaman sukses
        return redirect()->route('pembayaran.selesai');
    }

    /**
     * Menampilkan halaman pembayaran selesai.
     */
    public function showSelesai()
    {
        $amount = session('last_payment_amount', 0);
        $package = session('last_payment_package', 'Paket Tidak Diketahui');

        // Hapus session setelah ditampilkan agar tidak muncul lagi jika halaman di-refresh
        session()->forget(['last_payment_amount', 'last_payment_package']);

        return view('pembayaran_selesai', compact('amount', 'package'));
    }
}
