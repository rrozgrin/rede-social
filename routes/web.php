<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');
Route::get('/u/{user:username}', [ProfileController::class, 'index'])->name('perfil');

Route::middleware('auth')->group(function () {
    Route::post('/profile/update-image', [ProfileController::class, 'updateImages'])->name('profile.updateImage');
    Route::patch('profile/', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('/post', [PostController::class, 'store'])->name('post.create');
    Route::put('/post/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.destroy');

    Route::post('/post/reaction/{post}', [PostController::class, 'postReaction'])->name('post.reaction');
});

require __DIR__ . '/auth.php';