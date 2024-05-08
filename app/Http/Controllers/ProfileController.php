<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{

    public function index(User $user)
    {
        return Inertia::render('Profile/View', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => new UserResource($user)
        ]);
    }

    /**
     * Display the user's profile form.
     */

    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $username = $request->user()->username;

        return Redirect::route('perfil', ['user' => $username]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateImages(Request $request)
{
    try {
        $user = Auth::user(); // Obter o usuário autenticado atualmente

        $data = $request->validate([
            'cover' => ['nullable', 'image'],
            'avatar' => ['nullable', 'image'],
        ]);

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('user-' . $user->id, 'public');
            $user->update(['cover_path' => $coverPath]);
            Log::info('Capa do usuário atualizada com sucesso.');
        }

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('user-' . $user->id, 'public');
            $user->update(['avatar_path' => $avatarPath]);
            Log::info('Avatar do usuário atualizado com sucesso.');
        }

        // Obter o ID do usuário autenticado
        $username = $user->username;

        return \Inertia\Inertia::location(route('perfil', ['user' => $username]));
    } catch (\Exception $e) {
        Log::error('Erro ao atualizar imagens do usuário: ' . $e->getMessage());
        throw $e;
    }
}
}
