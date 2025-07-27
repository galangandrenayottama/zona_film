<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PlaylistController extends Controller
{
    /**
     * Menampilkan halaman playlist (view).
     */
    public function index()
    {
        // Method ini hanya menampilkan file view-nya saja.
        // Data akan dimuat secara dinamis oleh JavaScript.
        return view('playlist');
    }

    /**
     * PERUBAHAN: Method baru untuk mengambil data playlist dalam format JSON.
     * Method ini akan dipanggil oleh JavaScript (fetch).
     */
    public function fetchData()
    {
        $playlists = Playlist::where('user_id', Auth::id())->latest()->get();
        return response()->json($playlists);
    }

    /**
     * Menyimpan film baru ke playlist user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'poster_url' => 'required|url',
            'tmdb_id' => [
                'required',
                'string',
                Rule::unique('playlists')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })
            ],
        ]);

        $playlist = Playlist::create([
            'user_id' => Auth::id(), // <-- Kunci Penyimpanan
            'title' => $request->title,
            'poster_url' => $request->poster_url,
            'tmdb_id' => $request->tmdb_id,
        ]);

        // Sertakan data user agar bisa digunakan jika perlu di frontend
        $playlist->load('user');

        return response()->json([
            'message' => 'Film berhasil ditambahkan ke playlist!',
            'playlist' => $playlist
        ], 201);
    }

    /**
     * Menghapus film dari playlist.
     */
    public function destroy($tmdbId)
    {
        Playlist::where('user_id', Auth::id())
                ->where('tmdb_id', $tmdbId)
                ->delete();

        return response()->json(['message' => 'Film berhasil dihapus.']);
    }
}
