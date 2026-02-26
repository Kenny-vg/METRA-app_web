<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // If user exists, update their google_id and avatar if needed
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                ]);
            } else {
                // Determine user role based on your logic, perhaps default is 'cliente'
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => bcrypt(Str::random(16)), 
                    'role' => 'cliente', // Default role for new users
                    'estado' => 'activo'
                ]);
            }

            Auth::login($user);

            // Redirect based on role
            if ($user->role == 'superadmin') {
                return redirect('/superadmin/dashboard');
            } elseif ($user->role == 'gerente') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/public/perfil');
            }

        } catch (Exception $e) {
            \Log::error('Google Login Error: ' . $e->getMessage());
            return redirect('/login')->withErrors(['error' => 'No se pudo iniciar sesión con Google: ' . $e->getMessage()]);
        }
    }
}
