<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Muestra tu diseño bonito que ya tienes en resources/views/auth/login.blade.php
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Esta función es la que "trabaja" cuando le das clic al botón
    public function login(Request $request)
    {
        // 1. Validamos que no vengan vacíos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Intentamos entrar a la base de datos
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Si todo bien, lo mandamos a /home (donde tú ya pusiste la lógica de roles en web.php)
            return redirect()->intended('/home');
        }

        // 4. Si el correo o la contraseña están mal, regresamos con error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    // Para cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}