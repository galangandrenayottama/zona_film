<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function showDetail($id)
    {
        // Di sini Anda bisa menambahkan logika untuk mengambil data film dari TMDb API
        // atau sumber lain jika Anda menyimpan data film di database lokal.
        // Untuk saat ini, kita hanya akan melewatkan ID film ke view.

        return view('detail', ['movieId' => $id]);
    }
}