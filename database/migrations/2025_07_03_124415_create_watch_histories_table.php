<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('watch_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('tmdb_id');
            $table->string('movie_title');
            $table->string('poster_url')->nullable();
            $table->timestamp('watched_at')->useCurrent();
            $table->timestamps();

            // PERBAIKAN: Mencegah satu user memiliki riwayat film yang sama berulang kali.
            $table->unique(['user_id', 'tmdb_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('watch_histories');
    }
};