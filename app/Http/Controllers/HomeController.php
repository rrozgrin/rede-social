<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {   
        $userId = Auth::id();
        $posts = Post::query()
                ->withCount('reactions')
                ->with(['reactions'=>function($query) use ($userId){
                    $query->where('user_id', $userId);
                }])
                ->latest()
                ->paginate(20);

        return Inertia::render('Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'posts' => PostResource::collection($posts),
        ]);
    }
}