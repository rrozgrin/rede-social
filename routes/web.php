<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');
Route::get('/u/{user:username}', [ProfileController::class, 'index'])->name('perfil');

Route::middleware('auth')->group(function () {
    Route::get('u/', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('u/', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('u/', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';