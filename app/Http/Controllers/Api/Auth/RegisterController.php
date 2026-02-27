<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;

class RegisterController extends Controller
{
    //
    public function registerCliente(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max100',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6'
        ]);

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
            'password'=>'requiired|min:6'
        ]);

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

        return ApiResonse::success([
            'usuario'=>$user
        ], 'Cuenta activada correctamente');
    }
}
