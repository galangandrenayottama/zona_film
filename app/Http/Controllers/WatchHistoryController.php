<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Models\WatchHistory;

    class WatchHistoryController extends Controller
{
    /**
     * Menampilkan daftar riwayat tontonan milik pengguna yang sedang login.
     */
    public function index()
    {
        // Ambil riwayat milik user yang terautentikasi,
        // urutkan dari yang terbaru.
        $histories = WatchHistory::where('user_id', Auth::id())
                                 ->orderBy('updated_at', 'desc') // Gunakan updated_at agar yang baru ditonton ulang naik
                                 ->get();

        return response()->json($histories);
    }

    /**
     * Menyimpan riwayat tontonan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tmdb_id' => 'required|integer',
            'movie_title' => 'required|string|max:255',
            'poster_url' => 'required|string|max:255',
        ]);

        $history = WatchHistory::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'tmdb_id' => $request->tmdb_id,
            ],
            [
                'movie_title' => $request->movie_title,
                'poster_url' => $request->poster_url,
            ]
        );

        return response()->json($history, 200);
    }

        /**
         * Menghapus item dari riwayat tontonan.
         */
        public function destroy($id)
        {
            if (!Auth::check()) {
                return response()->json(['message' => 'Tidak terautentikasi.'], 401);
            }

            // Cari item histori berdasarkan ID dan pastikan itu milik pengguna yang login
            $historyItem = Auth::user()->watchHistories()->find($id);

            if ($historyItem) {
                $historyItem->delete();
                return response()->json(['message' => 'Item histori berhasil dihapus.'], 200);
            }

            return response()->json(['message' => 'Item histori tidak ditemukan atau bukan milik Anda.'], 404);
        }
    }
    