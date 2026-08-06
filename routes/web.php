<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\AcademicSettingController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\ApplicationLinkController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\FormerPrincipalController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GalleryVideoController;
use App\Http\Controllers\Admin\HomeSliderController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PpdbController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UserManagementController;

Auth::routes(['register' => false]);

// Public
Route::controller(PublicController::class)->group(function() {
    Route::get('/', 'index')->name('home');
    Route::get('/profil', 'profil')->name('profil');
    Route::get('/pendidik-tenaga-kependidikan', 'guru')->name('guru');
    Route::get('/akademik', 'akademik')->name('akademik');
    Route::get('/sarana-prasarana', 'sarpras')->name('sarpras');
    Route::get('/portal-aplikasi', 'aplikasi')->name('aplikasi');
    Route::get('/informasi', 'informasi')->name('informasi');
    Route::get('/ppdb', 'ppdb')->name('ppdb');
    Route::get('/galeri', 'galeri')->name('galeri');
    Route::get('/kontak', 'kontak')->name('kontak');
    Route::post('/kontak', 'kirimPesan')->name('kontak.kirim');
    Route::get('/berita/{slug}', 'beritaDetail')->name('berita.detail');
});

// Admin
Route::prefix('admin')->middleware(['auth','admin'])->name('admin.')->group(function() {
    Route::get('/dashboard', DashboardController::class)
        ->middleware('permission:dashboard.view')
        ->name('dashboard');

    Route::middleware('permission:profile.update')->group(function () {
        Route::get('school-profile', [SchoolProfileController::class, 'edit'])->name('profile.edit');
        Route::put('school-profile', [SchoolProfileController::class, 'update'])->name('profile.update');
        Route::resource('former-principals', FormerPrincipalController::class)->except(['show']);
    });

    Route::middleware('permission:academic.manage')->group(function () {
        Route::get('academic', [AcademicSettingController::class, 'edit'])->name('academic.edit');
        Route::put('academic', [AcademicSettingController::class, 'update'])->name('academic.update');
    });

    Route::resource('home-sliders', HomeSliderController::class)
        ->except(['show'])
        ->middleware('permission:sliders.manage');

    Route::middleware('permission:posts.manage,posts.academic,posts.sarpras')->group(function () {
        Route::post('posts/bulk-action', [PostController::class, 'bulkAction'])->name('posts.bulk');
        Route::resource('posts', PostController::class);
    });

    Route::middleware('permission:teachers.manage')->group(function () {
        Route::post('teachers/import', [TeacherController::class, 'import'])->name('teachers.import');
        Route::delete('teachers/bulk-delete', [TeacherController::class, 'bulkDestroy'])->name('teachers.bulk-destroy');
        Route::resource('teachers', TeacherController::class)->except(['show']);
    });

    Route::resource('facilities', FacilityController::class)
        ->except(['show'])
        ->middleware('permission:facilities.manage');

    Route::resource('ppdb', PpdbController::class)
        ->except(['show'])
        ->middleware('permission:ppdb.manage');

    Route::resource('galleries', GalleryController::class)
        ->except(['show'])
        ->middleware('permission:galleries.manage');

    Route::resource('gallery-videos', GalleryVideoController::class)
        ->except(['show'])
        ->middleware('permission:gallery-videos.manage');

    Route::resource('application-links', ApplicationLinkController::class)
        ->except(['show'])
        ->middleware('permission:application-links.manage');

    Route::resource('messages', MessageController::class)
        ->only(['index','show','destroy'])
        ->middleware('permission:messages.view');

    Route::get('logs', [ActivityLogController::class, 'index'])
        ->middleware('permission:activity.logs.view')
        ->name('logs.index');

    Route::resource('users', UserManagementController::class)
        ->except(['show'])
        ->middleware('permission:users.manage');
    Route::post('users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])
        ->middleware('permission:users.manage')
        ->name('users.reset-password');
    Route::post('users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])
        ->middleware('permission:users.manage')
        ->name('users.toggle-status');
});

// Robust Media & Storage file serving routes (works on Windows/Laragon/php artisan serve)
Route::get('/media/{path}', function ($path) {
    $cleanPath = ltrim($path, '/');
    $relativePath = preg_replace('/^(media\/|storage\/)+/', '', $cleanPath);

    $candidate1 = storage_path('app/public/' . $relativePath);
    if (file_exists($candidate1) && is_file($candidate1)) {
        return response()->file($candidate1, ['Cache-Control' => 'public, max-age=86400']);
    }

    $candidate2 = storage_path('app/public/media/' . $relativePath);
    if (file_exists($candidate2) && is_file($candidate2)) {
        return response()->file($candidate2, ['Cache-Control' => 'public, max-age=86400']);
    }

    $candidate3 = storage_path('app/public/' . $cleanPath);
    if (file_exists($candidate3) && is_file($candidate3)) {
        return response()->file($candidate3, ['Cache-Control' => 'public, max-age=86400']);
    }

    return response()->file(public_path('img/placeholder.jpg'));
})->where('path', '.*')->name('media.serve');

Route::get('/storage/{path}', function ($path) {
    $cleanPath = ltrim($path, '/');
    $relativePath = preg_replace('/^(media\/|storage\/)+/', '', $cleanPath);

    $candidate1 = storage_path('app/public/' . $relativePath);
    if (file_exists($candidate1) && is_file($candidate1)) {
        return response()->file($candidate1, ['Cache-Control' => 'public, max-age=86400']);
    }

    $candidate2 = storage_path('app/public/media/' . $relativePath);
    if (file_exists($candidate2) && is_file($candidate2)) {
        return response()->file($candidate2, ['Cache-Control' => 'public, max-age=86400']);
    }

    $candidate3 = storage_path('app/public/' . $cleanPath);
    if (file_exists($candidate3) && is_file($candidate3)) {
        return response()->file($candidate3, ['Cache-Control' => 'public, max-age=86400']);
    }

    return response()->file(public_path('img/placeholder.jpg'));
})->where('path', '.*');

// Temporary dev-only cache clear route
Route::get('/dev-clear-cache', function () {
    $views = glob(storage_path('framework/views/*.php'));
    $count = 0;
    foreach ($views as $f) { unlink($f); $count++; }
    return response()->json(['status' => 'ok', 'views_cleared' => $count]);
});
