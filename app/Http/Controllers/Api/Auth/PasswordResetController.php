<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Helpers\ApiResponse;
use App\Mail\ResetPasswordMail;

class PasswordResetController extends Controller
{
    // ENVIAR LINK AL CORREO
    public function forgotPassword(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $data['email'])->first();

        // seguridad: no revelar si existe o no
        if (!$user) {
            return ApiResponse::success([], 'Si el correo existe, se enviará un enlace.');
        }

        $token = Str::random(60);

        $user->update([
            'activation_token' => $token
        ]);

        $url = env('FRONTEND_URL') .
            "/reset-password?token={$token}&email={$user->email}";

        Mail::to($user->email)->send(
            new ResetPasswordMail($url, $user->email)
        );

        return ApiResponse::success([], 'Correo enviado correctamente.');
    }

    // CAMBIAR CONTRASEÑA
    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::where('email', $data['email'])
            ->where('activation_token', $data['token'])
            ->first();

        if (!$user) {
            return ApiResponse::error('El enlace no es válido o expiró.');
        }

        $user->update([
            'password' => Hash::make($data['password']),
            'activation_token' => null
        ]);

        return ApiResponse::success([], 'Contraseña actualizada correctamente.');
    }
}
