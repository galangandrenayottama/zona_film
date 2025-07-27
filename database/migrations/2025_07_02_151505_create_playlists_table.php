<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->id();

            // Kolom ini SANGAT PENTING untuk menghubungkan playlist ke user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('title');
            $table->string('poster_url');
            $table->string('tmdb_id');
            $table->timestamps();

            // Mencegah satu user menambahkan film yang sama berulang kali
            $table->unique(['user_id', 'tmdb_id']);
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlists');
    }
};
