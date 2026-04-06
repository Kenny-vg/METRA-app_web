<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;
use App\Helpers\PasswordHelper;

class RegisterController extends Controller
{
    //
    public function registerCliente(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:100',
            'email'=>'required|email:dns|unique:users,email',
            'password'=>['required', PasswordHelper::securePasswordPolicy()]
        ], array_merge([
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder los 100 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no tiene un formato válido.',
            'email.unique' => 'El correo electrónico ya se encuentra registrado.',
            'password.required' => 'La contraseña es obligatoria.',
        ], PasswordHelper::messages()));

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
            'role'=>'cliente',
            'estado'=>true
        ]);

        return ApiResponse::success([
            'usuario'=>$user
        ], 'Cuenta creada correctamente');
    }

    public function activarCuenta(Request $request)
    {
        $data = $request->validate([
            'email'=>'required|email',
            'token'=>'required',
            'password'=>['required', PasswordHelper::securePasswordPolicy()]
        ], PasswordHelper::messages());

        $user= User::where('email',$data['email'])
        ->where('activation_token', $data['token'])
        ->first();

        if(!$user){
            return ApiResponse::error('Token de activacion invalido');
        }

        $user->update([
            'password'=>Hash::make($data['password']),
            'activation_token'=>null,
            'estado'=>true
        ]);

        return ApiResponse::success([
            'usuario'=>$user
        ], 'Cuenta activada correctamente');
    }
}
