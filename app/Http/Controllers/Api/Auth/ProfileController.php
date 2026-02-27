<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class ProfileController extends Controller
{
    //
    public function miPerfil(Request $request)
    {
        return ApiResponse::success([
            'usuario'=>$request->user()
        ],'Perfil obtenido correctamente');
    }
}
