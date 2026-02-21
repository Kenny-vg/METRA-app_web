<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CafeteriaController;

/*
|------------------------------------------
| RUTAS PÚBLICAS
|------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);


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

    /*Route::get('/cafeterias', [CafeteriaController::class, 'index']);
    Route::post('/cafeterias', [CafeteriaController::class, 'store']);
    Route::put('/cafeterias/{id}', [CafeteriaController::class, 'update']);
    Route::delete('/cafeterias/{id}', [CafeteriaController::class, 'destroy']);*/

});