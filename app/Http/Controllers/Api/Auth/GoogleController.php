<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Helpers\ApiResponse;

class GoogleController extends Controller
{
    //
    public function loginGoogle(Request $request)
    {
        $data = $request->validate([
            'email'=>'required|email',
            'name'=>'required|string',
            'google_id'=>'required|string',
            'avatar'=>'nullable|string'
        ]);

        $user = User::where('email',$data['email'])->first();

        if (!$user) {
            return ApiResponse::error(
                'Primero debes registrarte con email y contraseña',
                422
            );
        }
        
        if($user){
            $user->update([
                'google_id'=>$data['google_id'],
                'avatar'=>$data['avatar']
            ]);
        }
        
        if(!$user->estado){
            return ApiResponse::error('Usuario inactivo',403);
        }

        $token = $user->createToken('metra_token')->plainTextToken;

        return ApiResponse::success([
            'token'=>$token,
            'usuario'=>$user
        ],'Login con Google exitoso');
    }
}
