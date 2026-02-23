<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Muestra tu diseño de resources/views/auth/register.blade.php
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Registra al nuevo usuario en la base de datos
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cliente', // Por defecto se registran como clientes
            'estado' => true,
        ]);

        Auth::login($user);

        return redirect('/home'); // Los manda a la lógica de roles que ya tienes
    }
}