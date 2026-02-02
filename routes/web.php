<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\PostController;

Auth::routes(['register' => false]);

// Public
Route::controller(PublicController::class)->group(function() {
    Route::get('/', 'index')->name('home');
    Route::get('/profil', 'profil')->name('profil');
    Route::get('/pendidik-tenaga-kependidikan', 'guru')->name('guru');
    Route::get('/akademik', 'akademik')->name('akademik');
    Route::get('/sarana-prasarana', 'sarpras')->name('sarpras');
    Route::get('/informasi', 'informasi')->name('informasi');
    Route::get('/ppdb', 'ppdb')->name('ppdb');
    Route::get('/galeri', 'galeri')->name('galeri');
    Route::get('/kontak', 'kontak')->name('kontak');
    Route::post('/kontak', 'kirimPesan')->name('kontak.kirim');
    Route::get('/berita/{slug}', 'beritaDetail')->name('berita.detail');
});

// Admin
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function() {
    Route::get('/dashboard', function() { return view('admin.dashboard'); })->name('dashboard');
    Route::resource('posts', PostController::class);
});
