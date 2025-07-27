<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchHistory extends Model
{
    use HasFactory;

        protected $fillable = [
            'user_id',
            'tmdb_id',
            'movie_title',
            'poster_url',
            'watched_at',
        ];

        // Definisi relasi: setiap item histori tontonan dimiliki oleh satu pengguna
        public function user()
        {
            return $this->belongsTo(User::class);
        }
}
