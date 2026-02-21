<?php

namespace App\Helpers;

class ApiResponse
{
    //respuesta exitosa estándar
    public static function success($data= null, $message='Operación exitosa', $code=200)
    {
        return response()->json([
            'success'=>true,
            'message'=>$message,
            'data'=>$data
        ], $code);
    }

    //respuesta de error estándar
    public static function error($message='Error', $code=400, $data=null)
    {
        return response()->json([
            'success'=>false,
            'message'=>$message,
            'data'=>$data
        ], $code);
    }
}