<?php

use Illuminate\Support\Facades\Route;
use App\Helpers\ApiResponse;
use App\Http\Middleware\CheckSuscripcionActiva;

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\GoogleController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\Auth\PasswordResetController;

use App\Http\Controllers\Api\RegistroNegocioController;
use App\Http\Controllers\Api\ReservacionController;
use App\Http\Controllers\Api\OcupacionController;
use App\Http\Controllers\Api\ResenaController;

use App\Http\Controllers\Api\Superadmin\PlanController;
use App\Http\Controllers\Api\Superadmin\SuscripcionController;
use App\Http\Controllers\Api\Superadmin\DashboardController;
use App\Http\Controllers\Api\Superadmin\SolicitudesController;
use App\Http\Controllers\Api\Superadmin\AprobacionController;
use App\Http\Controllers\Api\Superadmin\CafeteriaController;
use App\Http\Controllers\Api\Superadmin\ConfiguracionController;


use App\Http\Controllers\Api\Gerente\CafeteriaPerfilController;
use App\Http\Controllers\Api\Gerente\ZonaController;
use App\Http\Controllers\Api\Gerente\MesaController;
use App\Http\Controllers\Api\Gerente\HorarioController;
use App\Http\Controllers\Api\Gerente\MenuController;
use App\Http\Controllers\Api\Gerente\OcasionController;
use App\Http\Controllers\Api\Gerente\PromocionController;
use App\Http\Controllers\Api\Gerente\RenovarSuscripcionController;
use App\Http\Controllers\Api\Gerente\StaffController;
use App\Http\Controllers\Api\Publico\PublicCafeteriaController;

/* |------------------------------------------ | RUTAS PÚBLICAS |------------------------------------------ */
Route::post('/login', [LoginController::class , 'login']);

// Activar cuenta
Route::post('/activar-cuenta', [RegisterController::class , 'activarCuenta']);

// Registro cliente
Route::post('/register-cliente', [RegisterController::class , 'registerCliente']);

//Login con Google
Route::post('/auth/google', [GoogleController::class , 'loginGoogle']);

// Olvidé mi contraseña
Route::post('/forgot-password', [PasswordResetController::class , 'forgotPassword']);

// Restablecer contraseña
Route::post('/reset-password', [PasswordResetController::class , 'resetPassword']);

// Planes públicos 
Route::get('/planes-publicos', [RegistroNegocioController::class , 'planesPublicos']);

// Información de pago
Route::get('/configuracion-pago', [ConfiguracionController::class , 'showPublic']);

// Rutas Públicas de Cafeterías
Route::controller(PublicCafeteriaController::class)->group(function () {
    Route::get('/cafeterias-publicas', 'index');
    Route::get('/cafeterias-publicas/{cafeteria}', 'show'); // Usa slug
    Route::get('/cafeterias-publicas-id/{cafeteria:id}', 'show'); // Usa id explicitamente
    Route::get('/cafeterias/{cafeteria}/menu', 'menu');
    Route::get('/cafeterias/{cafeteria}/ocasiones', 'ocasiones');
    Route::get('/cafeterias/{cafeteria}/ocasiones/{ocasion}/promociones', 'promocionesPorOcasion');
    Route::get('/cafeterias/{cafeteria}/zonas', 'zonas');
    Route::get('/cafeterias/{cafeteria}/horarios', 'horarios');
    Route::get('/cafeterias/{cafeteria}/mesas-capacidad', 'mesasCapacidad');
    Route::get('/cafeterias/{cafeteria}/promociones', 'promociones');
});

// Auto-registro de negocio por el propio gerente/dueño
Route::post('/registro-negocio', [RegistroNegocioController::class , 'store']);
Route::post('/registro-negocio/{cafeteria:id}/comprobante', [RegistroNegocioController::class , 'subirComprobante']);
//consultar si existe registro pendiente
Route::post('/registro-pendiente', [RegistroNegocioController::class , 'registroPendiente']);


//Horarios disponibles
Route::get('cafeterias/{cafeteria}/horarios-disponibles', [ReservacionController::class , 'horariosDisponibles']);

//Crear reservación
Route::post('cafeterias/{cafeteria}/reservaciones', [ReservacionController::class , 'store']);

// Detalle y cancelación pública por folio (sin auth — folio actúa como identificador)
Route::get('reservaciones/folio/{folio}', [ReservacionController::class , 'showByFolio']);
Route::delete('reservaciones/folio/{folio}', [ReservacionController::class , 'cancelarByFolio']);

Route::get('/resena/{token}', [ResenaController::class , 'show']);
Route::post('/resena/{token}', [ResenaController::class , 'store']);

Route::get('/cafeterias/{cafeteria}/resenas',
[PublicCafeteriaController::class , 'resenas']);

/* |------------------------------------------ | RUTAS PROTEGIDAS (TODOS LOS USUARIOS) |------------------------------------------ */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/mi-perfil', [ProfileController::class , 'miPerfil']);
    Route::post('/logout', [LoginController::class , 'logout']);
    //Mis reservaciones
    Route::get('reservaciones', [ReservacionController::class , 'misReservaciones']);
    //Cancelar reservación
    Route::delete('reservaciones/{id}', [ReservacionController::class , 'cancelar']);
});


/* |------------------------------------------ | RUTAS SUPERADMIN |------------------------------------------ */
Route::middleware([
    'auth:sanctum',
    'role:superadmin',
    'check.suscripcion'
])->prefix('superadmin')->group(function () {

    // CAFETERÍAS — listar, crear, eliminar
    Route::get('/cafeterias', [CafeteriaController::class , 'index']);
    Route::post('/cafeterias', [CafeteriaController::class , 'store']);
    Route::get('/cafeterias/{cafeteria:id}', [CafeteriaController::class , 'show']);
    Route::delete('/cafeterias/{cafeteria:id}', [CafeteriaController::class , 'destroy']);

    // CAFETERÍAS — revisión de registros auto-gestionados
    Route::get('/cafeterias/{cafeteria:id}/comprobante', [CafeteriaController::class , 'verComprobante']);

    Route::get('/suscripciones/{suscripcion}/comprobante', function (\App\Models\Suscripcion $suscripcion) {
            // Buscar el comprobante en la suscripción o en la cafetería vinculada (por retrocompatibilidad)
            $comprobante = $suscripcion->comprobante_url ?: ($suscripcion->cafeteria ? $suscripcion->cafeteria->comprobante_url : null);

            if (!$comprobante)
                abort(404, 'No hay comprobante registrado');

            $exists = \Illuminate\Support\Facades\Storage::disk('local')->exists($comprobante);
            if (!$exists)
                abort(404, 'Archivo no encontrado físicamente');

            $path = \Illuminate\Support\Facades\Storage::disk('local')->path($comprobante);
            return ApiResponse::success(response()->file($path));
        }
        );


        // PLANES
        Route::get('/planes', [PlanController::class , 'index']);
        Route::post('/planes', [PlanController::class , 'store']);
        Route::put('/planes/{plan}', [PlanController::class , 'update']);
        Route::delete('/planes/{plan}', [PlanController::class , 'destroy']);

        // SUSCRIPCIONES
        Route::get('/suscripciones', [SuscripcionController::class , 'index']);
        Route::post('/suscripciones', [SuscripcionController::class , 'store']);
        // Aprobar renovación de suscripción pendiente (cafeteria activa que renueva)
        Route::patch('/suscripciones/{suscripcion}/aprobar-renovacion', [SuscripcionController::class , 'aprobarRenovacion']);
        // Ver comprobante de una suscripción
        Route::get('/suscripciones/{suscripcion}/comprobante', [SuscripcionController::class , 'verComprobante']);

        //DASHBOARD
        Route::get('/dashboard', [DashboardController::class , 'index']);

        //SOLICITUDES
        Route::get('/solicitudes', [SolicitudesController::class , 'index']);

        //APROBACION
        Route::patch('/solicitudes/{cafeteria:id}/aprobar',
        [AprobacionController::class , 'aprobar']);
        Route::patch('/solicitudes/{cafeteria:id}/rechazar',
        [AprobacionController::class , 'rechazar']);

        // CONFIGURACIÓN PAGO
        Route::put('/configuracion-pago', [ConfiguracionController::class , 'update']);

    
});

//VER COMPROBANTE
Route::get(
    '/admin/comprobante/{cafeteria:id}',
[RegistroNegocioController::class , 'verComprobante']
)->middleware('auth:sanctum');



/* |------------------------------------------ | RUTAS GERENTE |------------------------------------------ */
Route::middleware([
    'auth:sanctum',
    'role:gerente',
    'check.suscripcion'
])->prefix('gerente')->group(function () {

    // Perfil de la cafetería
    Route::get('mi-cafeteria', [CafeteriaPerfilController::class , 'show']);
    Route::post('mi-cafeteria', [CafeteriaPerfilController::class , 'update']);
    Route::put('mi-cafeteria', [CafeteriaPerfilController::class , 'update']);


    Route::apiResource('zonas', ZonaController::class); //crud zonas
    Route::apiResource('mesas', MesaController::class); //crud mesas
    Route::apiResource('horarios', HorarioController::class); //crud horarios

    Route::get('reservaciones', [ReservacionController::class , 'index']);

    Route::apiResource('staff', StaffController::class); //crud staff

    // Rutas para el menú (Permite spoofing method _method=PUT para imágenes)
    Route::post('menu/{menu}', [MenuController::class , 'update']);
    Route::apiResource('menu', MenuController::class);
    Route::apiResource('promociones', PromocionController::class)->parameters([
        'promociones' => 'promocion'
    ]);

    // Rutas para ocasiones especiales
    Route::apiResource('ocasiones', OcasionController::class)->parameters([
        'ocasiones' => 'ocasion'
    ]);


    //Activar registros
    Route::patch('zonas/{id}/activar', [ZonaController::class , 'activar']);
    Route::patch('mesas/{id}/activar', [MesaController::class , 'activar']);
    Route::patch('horarios/{id}/activar', [HorarioController::class , 'activar']);
    Route::patch('menu/{id}/activar', [MenuController::class , 'activar']);
    Route::patch('promociones/{id}/activar', [PromocionController::class , 'activar']);
    Route::patch('ocasiones/{id}/activar', [OcasionController::class , 'activar']);
    Route::patch('staff/{id}/activar', [StaffController::class , 'activar']);

    Route::patch('/reservaciones/{id}/completar', [ReservacionController::class , 'completar']);
    Route::patch('/reservaciones/{id}/cancelar', [ReservacionController::class , 'cancelarGerente']);

    Route::get('/resenas', [ResenaController::class , 'index']);
    Route::patch('/resenas/{id}/aprobar', [ResenaController::class , 'aprobar']);
    Route::patch('/resenas/{id}/ocultar', [ResenaController::class , 'ocultar']);
});

// Renovación de suscripción — para que gerentes con sub
// vencida también puedan renovar desde el panel (y desde el login sin token)
Route::post('gerente/renovar-suscripcion', [RenovarSuscripcionController::class , 'store']);



/* |------------------------------------------ | RUTAS STAFF (APP MOVIL) |------------------------------------------ */

Route::middleware([
    'auth:sanctum',
    'role:gerente,personal',
    'check.suscripcion'
])->prefix('staff')->group(function () {

    Route::get('/mesas', [MesaController::class , 'index']);
    Route::get('/zonas', [ZonaController::class , 'index']);
    Route::get('/promociones', [PromocionController::class , 'index']);
    Route::get('/horarios', [HorarioController::class , 'index']);
    Route::get('/reservaciones', [ReservacionController::class , 'index']);
    Route::get('/reservaciones/{id}', [ReservacionController::class , 'show']);
    Route::get('/ocupaciones', [OcupacionController::class , 'index']);
    Route::post('/ocupaciones', [OcupacionController::class , 'store']);
    Route::patch('/ocupaciones/{id}/finalizar', [OcupacionController::class , 'finalizar']);
    Route::patch('/reservaciones/{id}/completar', [ReservacionController::class , 'completar']);
    Route::get('/mesas-estado', [OcupacionController::class , 'estadoMesas']);
});