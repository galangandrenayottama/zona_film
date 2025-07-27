<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    /**
     * Atribut yang boleh diisi secara massal.
     * Pastikan 'user_id' ada di sini.
     */
    protected $fillable = [
        'title',
        'poster_url',
        'tmdb_id',
        'user_id',
    ];

    /**
     * Mendefinisikan relasi bahwa setiap Playlist milik satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
