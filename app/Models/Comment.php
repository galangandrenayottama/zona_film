<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * Atribut yang boleh diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'movie_id',
        'user_id',
    ];

    /**
     * Mendefinisikan relasi: Setiap komentar adalah milik satu User.
     * Ini memungkinkan kita untuk memanggil $comment->user untuk mendapatkan data user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}