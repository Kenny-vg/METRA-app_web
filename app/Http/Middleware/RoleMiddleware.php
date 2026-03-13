<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\ApiResponse;

class RoleMiddleware
{
    /**
     * Middleware para validar roles
     *
     * 
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        
        $user = $request->user();

        //Validar autenticación
        if(!$user){
            return ApiResponse::error('No autenticado', 401);
        }

        //validar usuario activo
        if(!$user->estado){
            return ApiResponse::error('Usuario inactivo', 403);
        }

        //validar si el usuario tiene permiso
        if(!in_array($user->role, $roles)){
            // Extraer debug por si no hizo el split
            $debug = 'No autorizado. Mi rol: ' . $user->role . ', Esperados: ' . json_encode($roles);
            return ApiResponse::error($debug, 403);
        }

        return $next($request);
    }
}
