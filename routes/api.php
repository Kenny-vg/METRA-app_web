<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CafeteriaController;
use App\Http\Controllers\Api\Gerente\CafeteriaPerfilController;
use App\Http\Controllers\Api\Superadmin\PlanController;
use App\Http\Controllers\Api\Superadmin\SuscripcionController;

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

    //CREAR, ELIMINAR, LISTAR CAFETERIAS
    Route::get('/cafeterias', [CafeteriaController::class, 'index']);
    Route::post('/cafeterias', [CafeteriaController::class, 'store']);
    Route::delete('/cafeterias/{cafeteria}', [CafeteriaController::class, 'destroy']);

    //CREAR, ELIMINAR, LISTAR PLANES
    Route::get('/planes',[PlanController::class,'index']);
    Route::post('/planes',[PlanController::class,'store']);
    Route::put('/planes/{plan}',[PlanController::class,'update']);
    Route::delete('/planes/{plan}',[PlanController::class,'destroy']);


    //CREAR, ELIMINAR, LISTAR SUSCRIPCIONES
    Route::get('/suscripciones',[SuscripcionController::class,'index']);
    Route::post('/suscripciones',[SuscripcionController::class,'store']);
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
    