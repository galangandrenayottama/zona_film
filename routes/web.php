<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\WatchHistoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController; // Tambahkan ini
use App\Http\Middleware\CheckSubscription;

// ===================================================================
// RUTE UNTUK PENGGUNA YANG BELUM LOGIN (GUEST)
// ===================================================================
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Registrasi
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Komentar publik
Route::get('/comments/{movieId}', [CommentController::class, 'index']);


// ===================================================================
// RUTE UNTUK PENGGUNA YANG SUDAH LOGIN
// ===================================================================
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/pembayaran/selesai', [PaymentController::class, 'showSelesai'])->name('pembayaran.selesai');

    // ================================================================
    // TAHAP PEMILIHAN PAKET (belum berlangganan)
    // ================================================================
    Route::middleware(['check.subscription:not_subscribed'])->group(function () {
        Route::get('/pilih-paket', [PaymentController::class, 'showPaket'])->name('paket');
        Route::post('/pilih-paket', [PaymentController::class, 'processPaketSelection'])->name('paket.process');

        Route::get('/pembayaran', [PaymentController::class, 'showPembayaran'])->name('pembayaran');
        Route::post('/pembayaran', [PaymentController::class, 'processPembayaran'])->name('pembayaran.process');

        
    });

    // ================================================================
    // RUTE UNTUK PENGGUNA YANG SUDAH BERLANGGANAN
    // ================================================================
    Route::middleware(['check.subscription:subscribed'])->group(function () {

        // Home (setelah selesai pembayaran)
        Route::get('/home', function () {
            return view('home');
        })->name('home');

        // Profil Akun
        Route::get('/account', [AccountController::class, 'show'])->name('account');
        Route::post('/account/update', [AccountController::class, 'update'])->name('account.update');

        // --- RUTE BARU UNTUK HAPUS AKUN ---
        Route::delete('/account/delete', [AccountController::class, 'destroy'])->name('account.delete');

        // --- RUTE BARU UNTUK BERHENTI LANGGANAN ---
        Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');

        // Detail Film
        Route::get('/movie/{id}', [MovieController::class, 'showDetail'])->name('movie.detail');

        // Playlist
        Route::get('/playlist', [PlaylistController::class, 'index'])->name('playlist');
        Route::post('/playlist', [PlaylistController::class, 'store'])->name('playlist.store');
        Route::delete('/playlist/{tmdbId}', [PlaylistController::class, 'destroy'])->name('playlist.destroy');
        Route::get('/playlist/data', [PlaylistController::class, 'fetchData'])->name('playlist.data');

        // Riwayat Tontonan
        Route::get('/riwayat', function () {
            return view('riwayat');
        })->name('riwayat.index');

        Route::get('/api/watch-history', [WatchHistoryController::class, 'index'])->name('api.watch_history.index');
        Route::post('/api/watch-history', [WatchHistoryController::class, 'store'])->name('api.watch_history.store');
        Route::delete('/api/watch-history/{id}', [WatchHistoryController::class, 'destroy'])->name('api.watch_history.destroy');

        // Komentar (CRUD)
        Route::post('/comments', [CommentController::class, 'store']);
        Route::put('/comments/{comment}', [CommentController::class, 'update']);
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
    });
});
