<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('message');

            // Foreign key untuk menghubungkan dengan film (asumsi Anda punya tabel films)
            // Jika tidak, Anda bisa menggunakan integer biasa.
            $table->unsignedBigInteger('movie_id');

            // Foreign key yang menghubungkan ke tabel 'users'
            // onDelete('cascade') berarti jika user dihapus, semua komentarnya juga ikut terhapus.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
