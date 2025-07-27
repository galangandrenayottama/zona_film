<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Subscription; // Pastikan model Subscription di-import
use App\Models\User;
class AccountController extends Controller
{
    // Pastikan hanya user terautentikasi yang bisa mengakses halaman ini
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();

        // Ambil semua riwayat langganan (transaksi) untuk pengguna ini
        $subscriptions = Subscription::where('user_id', $user->id)
                                     ->orderBy('created_at', 'desc') // Urutkan dari yang terbaru
                                     ->get();

        // Kirim data user dan subscriptions ke view
        return view('account', [
            'user' => $user,
            'subscriptions' => $subscriptions
        ]);

        // Melewatkan variabel $user ke view 'account'
        return view('account', ['user' => $user]);
    }

    public function update(Request $request)
    {
        // Dapatkan user yang sedang login
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20', // Sesuaikan validasi phone
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone; // Pastikan kolom 'phone' ada di tabel 'users'

        // Handle upload foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada dan bukan default.jpg
            if ($user->photo && $user->photo != 'default.jpg') {
                // Pastikan Anda memiliki storage link: php artisan storage:link
                // unlink(storage_path('app/public/photos/' . $user->photo)); // Hapus dari disk
            }
            $photoName = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('public/photos', $photoName);
            $user->photo = $photoName;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
    // hapus alkun
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Hapus foto profil dari storage jika ada
        if ($user->photo) {
            Storage::delete('public/photos/' . $user->photo);
        }

        // Logout sebelum menghapus data
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Hapus data pengguna dari database
        // Relasi (seperti subscriptions) akan terhapus otomatis karena 'onDelete('cascade')' pada migration.
        $user->delete();

        return redirect()->route('welcome')->with('success', 'Akun Anda telah berhasil dihapus secara permanen.');
    }
}
