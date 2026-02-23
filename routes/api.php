<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CafeteriaController;
use App\Http\Controllers\Api\Gerente\CafeteriaPerfilController;


/*
|------------------------------------------
| RUTAS PÚBLICAS
|------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);

//Activar cuenta
Route::post('/activar-cuenta',[
    AuthController::class,
    'activarCuenta'
]);

//Registro cliente
Route::post('/register-cliente', [AuthController::class, 'registerCliente']);


/*
|------------------------------------------
| RUTAS PROTEGIDAS (TODOS LOS USUARIOS)
|------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/mi-perfil', [AuthController::class, 'miPerfil']);
    Route::post('/logout', [AuthController::class, 'logout']);

});



/*
|------------------------------------------
| RUTAS SUPERADMIN
|------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    'role:superadmin'
])->prefix('superadmin')->group(function () {

    Route::get('/cafeterias', [CafeteriaController::class, 'index']);
    Route::post('/cafeterias', [CafeteriaController::class, 'store']);
    Route::delete('/cafeterias/{cafeteria}', [CafeteriaController::class, 'destroy']);

});


/*
|------------------------------------------
| RUTAS GERENTE
|------------------------------------------
*/

Route::middleware([ 
    'auth:sanctum', 
    'role:gerente'
])->prefix('gerente')->group(function(){
    Route::get('/mi-cafeteria',[CafeteriaPerfilController::class,'show']);
    Route::put('/mi-cafeteria', [CafeteriaPerfilController::class, 'update']);
});
    