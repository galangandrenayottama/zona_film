<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan halaman akun
    public function show()
    {
        return view('account', ['user' => Auth::user()]);
    }

    // Menyimpan perubahan data profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Jika ada upload foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo && Storage::exists('public/photos/' . $user->photo)) {
                Storage::delete('public/photos/' . $user->photo);
            }

            // Simpan foto baru
            $filename = time() . '.' . $request->photo->extension();
            $request->photo->storeAs('public/photos', $filename);
            $user->photo = $filename;
        }

        // Update data lainnya
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'photo' => $user->photo,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
