<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GalleryVideoController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\FormerPrincipalController;
use App\Http\Controllers\Admin\PpdbController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\AcademicSettingController;
use App\Http\Controllers\Admin\HomeSliderController;
use App\Http\Controllers\Admin\UserManagementController;

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
Route::prefix('admin')->middleware(['auth','admin'])->name('admin.')->group(function() {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('school-profile', [SchoolProfileController::class, 'edit'])->name('profile.edit');
    Route::put('school-profile', [SchoolProfileController::class, 'update'])->name('profile.update');
    Route::get('academic', [AcademicSettingController::class, 'edit'])->name('academic.edit');
    Route::put('academic', [AcademicSettingController::class, 'update'])->name('academic.update');
    Route::resource('former-principals', FormerPrincipalController::class)->except(['show']);
    Route::resource('home-sliders', HomeSliderController::class)->except(['show']);
    Route::post('posts/bulk-action', [PostController::class, 'bulkAction'])->name('posts.bulk');
    Route::resource('posts', PostController::class);
    Route::post('teachers/import', [TeacherController::class, 'import'])->name('teachers.import');
    Route::delete('teachers/bulk-delete', [TeacherController::class, 'bulkDestroy'])->name('teachers.bulk-destroy');
    Route::resource('teachers', TeacherController::class)->except(['show']);
    Route::resource('facilities', FacilityController::class)->except(['show']);
    Route::resource('ppdb', PpdbController::class)->except(['show']);
    Route::resource('galleries', GalleryController::class)->except(['show']);
    Route::resource('gallery-videos', GalleryVideoController::class)->except(['show']);
    Route::resource('messages', MessageController::class)->only(['index','show','destroy']);
    Route::get('logs', [ActivityLogController::class, 'index'])->name('logs.index');
    Route::resource('users', UserManagementController::class)->except(['show']);
    Route::post('users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
});
