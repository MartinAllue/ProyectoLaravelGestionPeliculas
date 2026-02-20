<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Redirige la raíz al listado de películas
Route::get('/', function () {
    return redirect()->route('movies.index');
});

// Dashboard protegido por auth y verified
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {

    // CRUD completo de películas
    Route::resource('movies', MovieController::class);

    // Valoraciones
    Route::post('/movies/{movie}/rating', [RatingController::class, 'store'])
        ->name('movies.rating.store');

    // Comentarios / Reviews
    Route::post('/movies/{movie}/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])
        ->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
        ->name('reviews.destroy');
});

Route::get('/admin-test', function () {
    return "Bienvenido administrador";
})->middleware('admin');

require __DIR__.'/auth.php';
