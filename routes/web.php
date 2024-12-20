<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/contents', [ContentController::class, 'index'])->name('contents.index');
    Route::get('/contents/{id}', [ContentController::class, 'show'])->name('contents.show');
    Route::post('/contents', [ContentController::class, 'store'])->name('contents.store');
    Route::put('/contents/{id}', [ContentController::class, 'update'])->name('contents.update');
    Route::delete('/contents/{id}', [ContentController::class, 'destroy'])->name('contents.destroy');
});

require __DIR__.'/auth.php';
