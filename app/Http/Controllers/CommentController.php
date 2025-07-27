<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    // ... method store() dan index() yang sudah ada ...

    /**
     * Menyimpan komentar baru dari pengguna yang sudah login.
     */
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|integer',
            'message' => 'required|string',
        ]);

        try {
            $comment = Comment::create([
                'movie_id' => $request->movie_id,
                'message' => $request->message,
                'user_id' => Auth::id(),
            ]);
            $comment->load('user');
            return response()->json($comment, 201);
        } catch (\Exception $e) {
            Log::error('Error saving comment: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menyimpan komentar.'], 500);
        }
    }

    /**
     * Menampilkan semua komentar untuk film tertentu.
     */
    public function index($movieId)
    {
        $comments = Comment::with('user')
                           ->where('movie_id', $movieId)
                           ->orderBy('created_at', 'desc')
                           ->get();
        return response()->json($comments);
    }

    /**
     * Memperbarui komentar yang ada.
     */
    public function update(Request $request, Comment $comment)
    {
        // 1. Otorisasi: Cek apakah user yang login adalah pemilik komentar
        $this->authorize('update', $comment);

        // 2. Validasi input
        $request->validate(['message' => 'required|string']);

        // 3. Update komentar
        $comment->update(['message' => $request->message]);

        // 4. Kembalikan komentar yang sudah diupdate (beserta data user)
        return response()->json($comment->load('user'));
    }

    /**
     * Menghapus komentar.
     */
    public function destroy(Comment $comment)
    {
        // 1. Otorisasi: Cek apakah user yang login adalah pemilik komentar
        $this->authorize('delete', $comment);

        // 2. Hapus komentar
        $comment->delete();

        // 3. Kembalikan response sukses tanpa konten
        return response()->json(null, 204);
    }
}
