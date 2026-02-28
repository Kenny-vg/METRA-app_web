<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\GoogleController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\RegistroNegocioController;
use App\Http\Controllers\Api\Gerente\CafeteriaPerfilController;
use App\Http\Controllers\Api\Superadmin\PlanController;
use App\Http\Controllers\Api\Superadmin\SuscripcionController;
use App\Http\Controllers\Api\Superadmin\DashboardController;
use App\Http\Controllers\Api\Superadmin\SolicitudesController;
use App\Http\Controllers\Api\Superadmin\AprobacionController;
use App\Http\Controllers\Api\Superadmin\CafeteriaController;
use App\Http\Controllers\Api\Superadmin\ConfiguracionController;
/*
|------------------------------------------
| RUTAS PÚBLICAS
|------------------------------------------
*/
Route::post('/login', [LoginController::class, 'login']);

// Activar cuenta
Route::post('/activar-cuenta', [RegisterController::class, 'activarCuenta']);

// Registro cliente
Route::post('/register-cliente', [RegisterController::class, 'registerCliente']);

//Login con Google
Route::post('/auth/google', [GoogleController::class, 'loginGoogle']);

// Planes públicos 
Route::get('/planes-publicos', [RegistroNegocioController::class, 'planesPublicos']);

// Información de pago
Route::get('/configuracion-pago', [ConfiguracionController::class, 'showPublic']);

// Auto-registro de negocio por el propio gerente/dueño
Route::post('/registro-negocio', [RegistroNegocioController::class, 'store']);
Route::post('/registro-negocio/{cafeteria}/comprobante', [RegistroNegocioController::class, 'subirComprobante']);


/*
|------------------------------------------
| RUTAS PROTEGIDAS (TODOS LOS USUARIOS)
|------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/mi-perfil', [ProfileController::class, 'miPerfil']);
    Route::post('/logout', [LoginController::class, 'logout']);
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

    // CAFETERÍAS — listar, crear, eliminar
    Route::get('/cafeterias', [CafeteriaController::class, 'index']);
    Route::post('/cafeterias', [CafeteriaController::class, 'store']);
    Route::get('/cafeterias/{cafeteria}', [CafeteriaController::class, 'show']);
    Route::delete('/cafeterias/{cafeteria}', [CafeteriaController::class, 'destroy']);

    // CAFETERÍAS — revisión de registros auto-gestionados
    Route::patch('/cafeterias/{cafeteria}/estado', [CafeteriaController::class, 'cambiarEstado']);
    Route::get('/cafeterias/{cafeteria}/comprobante', [CafeteriaController::class, 'verComprobante']);

    // PLANES
    Route::get('/planes', [PlanController::class, 'index']);
    Route::post('/planes', [PlanController::class, 'store']);
    Route::put('/planes/{plan}', [PlanController::class, 'update']);
    Route::delete('/planes/{plan}', [PlanController::class, 'destroy']);

    // SUSCRIPCIONES
    Route::get('/suscripciones', [SuscripcionController::class, 'index']);
    Route::post('/suscripciones', [SuscripcionController::class, 'store']);

    //DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index']);

    //SOLICITUDES
    Route::get('/solicitudes', [SolicitudesController::class, 'index']);

    //APROBACION
    Route::patch('/solicitudes/{cafeteria}/aprobar', 
        [AprobacionController::class, 'aprobar']);
    Route::patch('/solicitudes/{cafeteria}/rechazar', 
        [AprobacionController::class, 'rechazar']);

    // CONFIGURACIÓN PAGO
    Route::put('/configuracion-pago', [ConfiguracionController::class, 'update']);    
});


/*
|------------------------------------------
| RUTAS GERENTE
|------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    'role:gerente'
])->prefix('gerente')->group(function () {
    Route::get('/mi-cafeteria', [CafeteriaPerfilController::class, 'show']);
    Route::put('/mi-cafeteria', [CafeteriaPerfilController::class, 'update']);
});