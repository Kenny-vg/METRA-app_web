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

// Olvidé mi contraseña
Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword']);

// Restablecer contraseña
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);

// Planes públicos 
Route::get('/planes-publicos', [RegistroNegocioController::class, 'planesPublicos']);

// Información de pago
Route::get('/configuracion-pago', [ConfiguracionController::class, 'showPublic']);

// Cafeterías activas (uso público: landing page)
Route::get('/cafeterias-publicas', function () {
    $cafeterias = \App\Models\Cafeteria::where('estado', 'activa')
        ->select(
            'id',
            'nombre',
            'descripcion',
            'calle',
            'num_exterior',
            'colonia',
            'foto_url'
        )
        ->get();

    return ApiResponse::success($cafeterias);
});

Route::get('/cafeterias-publicas/{id}', function ($id) {
    $cafeteria = \App\Models\Cafeteria::findOrFail($id);

    return ApiResponse::success($cafeteria);
});

// Auto-registro de negocio por el propio gerente/dueño
Route::post('/registro-negocio', [RegistroNegocioController::class, 'store']);
Route::post('/registro-negocio/{cafeteria}/comprobante', [RegistroNegocioController::class, 'subirComprobante']);
//consultar si existe registro pendiente
Route::post('/registro-pendiente', [RegistroNegocioController::class, 'registroPendiente']);


//Ver menú
Route::get('/cafeterias/{id}/menu', function ($id) {

    $menu = \App\Models\Menu::where('cafe_id',$id)
        ->where('activo',true)
        ->orderBy('nombre_producto')
        ->get();

    return ApiResponse::success($menu);
});

//Ver ocasiones especiales
Route::get('/cafeterias/{id}/ocasiones', function ($id) {

    $ocasiones = \App\Models\OcasionEspecial::where('cafe_id',$id)
        ->where('activo',true)
        ->orderBy('nombre')
        ->get();

    return ApiResponse::success($ocasiones);
});

//ver promociones ligadas a ocasiones
Route::get('/cafeterias/{id}/ocasiones/{ocasion}/promociones', function ($id,$ocasion) {

    $promociones = \App\Models\Promocion::where('cafe_id',$id)
        ->where('activo',true)
        ->whereHas('ocasiones', function ($q) use ($ocasion) {
            $q->where('ocasion_especials.id', $ocasion);
        })
        ->orderBy('nombre_promocion')
        ->get();

    return ApiResponse::success($promociones);
});

// Zonas activas (público — para el formulario de reserva)
Route::get('/cafeterias/{id}/zonas', function ($id) {
    $zonas = \App\Models\Zona::where('cafe_id', $id)
        ->where('activo', true)
        ->orderBy('nombre_zona')
        ->get(['id', 'nombre_zona']);
    return ApiResponse::success($zonas);
});

// Horarios activos (público)
Route::get('/cafeterias/{id}/horarios', function ($id) {
    $horarios = \App\Models\Horario::where('cafe_id', $id)
        ->where('activo', true)
        ->orderBy('hora_apertura')
        ->get(['id', 'dia_semana', 'hora_apertura', 'hora_cierre']);
    return ApiResponse::success($horarios);
});

//Ver promociones
Route::get('/cafeterias/{id}/promociones', function ($id) {

    $promociones = \App\Models\Promocion::where('cafe_id',$id)
        ->where('activo',true)
        ->orderBy('nombre_promocion')
        ->get();

    return ApiResponse::success($promociones);
});

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
    'role:superadmin',
    'check.suscripcion'
])->prefix('superadmin')->group(function () {

    // CAFETERÍAS — listar, crear, eliminar
    Route::get('/cafeterias', [CafeteriaController::class, 'index']);
    Route::post('/cafeterias', [CafeteriaController::class, 'store']);
    Route::get('/cafeterias/{cafeteria}', [CafeteriaController::class, 'show']);
    Route::delete('/cafeterias/{cafeteria}', [CafeteriaController::class, 'destroy']);

    // CAFETERÍAS — revisión de registros auto-gestionados
    Route::get('/cafeterias/{cafeteria}/comprobante', [CafeteriaController::class, 'verComprobante']);

    Route::get('/suscripciones/{suscripcion}/comprobante', function (\App\Models\Suscripcion $suscripcion) {
        // Buscar el comprobante en la suscripción o en la cafetería vinculada (por retrocompatibilidad)
        $comprobante = $suscripcion->comprobante_url ?: ($suscripcion->cafeteria ? $suscripcion->cafeteria->comprobante_url : null);
        
        if (!$comprobante) abort(404, 'No hay comprobante registrado');
        
        $exists = \Illuminate\Support\Facades\Storage::disk('local')->exists($comprobante);
        if (!$exists) abort(404, 'Archivo no encontrado físicamente');
        
        $path = \Illuminate\Support\Facades\Storage::disk('local')->path($comprobante);
        return ApiResponse::success(response()->file($path));
    });


    // PLANES
    Route::get('/planes', [PlanController::class, 'index']);
    Route::post('/planes', [PlanController::class, 'store']);
    Route::put('/planes/{plan}', [PlanController::class, 'update']);
    Route::delete('/planes/{plan}', [PlanController::class, 'destroy']);

    // SUSCRIPCIONES
    Route::get('/suscripciones', [SuscripcionController::class, 'index']);
    Route::post('/suscripciones', [SuscripcionController::class, 'store']);
    // Aprobar renovación de suscripción pendiente (cafeteria activa que renueva)
    Route::patch('/suscripciones/{suscripcion}/aprobar-renovacion', [SuscripcionController::class, 'aprobarRenovacion']);
    // Ver comprobante de una suscripción
    Route::get('/suscripciones/{suscripcion}/comprobante', [SuscripcionController::class, 'verComprobante']);

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

    //VER COMPROBANTE
    Route::get(
        '/admin/comprobante/{cafeteria}',
        [RegistroNegocioController::class, 'verComprobante']
    )->middleware('auth:sanctum');



/*
|------------------------------------------
| RUTAS GERENTE
|------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    'role:gerente',
    'check.suscripcion'
])->prefix('gerente')->group(function () {

    // Perfil de la cafetería
    Route::get('mi-cafeteria', [CafeteriaPerfilController::class, 'show']);
    Route::post('mi-cafeteria', [CafeteriaPerfilController::class, 'update']);
    Route::put('mi-cafeteria', [CafeteriaPerfilController::class, 'update']);
    

    Route::apiResource('zonas', ZonaController::class);
    Route::apiResource('mesas', MesaController::class);
    Route::apiResource('horarios', HorarioController::class);
    
    // Rutas para el menú (Permite spoofing method _method=PUT para imágenes)
    Route::post('menu/{menu}', [MenuController::class, 'update']);
    Route::apiResource('menu', MenuController::class);
    Route::apiResource('promociones', PromocionController::class)->parameters([
        'promociones' => 'promocion'
    ]);

    // Rutas para ocasiones especiales
    Route::apiResource('ocasiones', OcasionController::class)->parameters([
        'ocasiones' => 'ocasion'
    ]);


    //Activar registros
    Route::patch('zonas/{id}/activar', [ZonaController::class, 'activar']);
    Route::patch('mesas/{id}/activar', [MesaController::class, 'activar']);
    Route::patch('horarios/{id}/activar', [HorarioController::class, 'activar']);
    Route::patch('menu/{id}/activar', [MenuController::class, 'activar']);
    Route::patch('promociones/{id}/activar', [PromocionController::class, 'activar']);
    Route::patch('ocasiones/{id}/activar', [OcasionController::class, 'activar']);

});

// Renovación de suscripción — para que gerentes con sub
// vencida también puedan renovar desde el panel
Route::middleware(['auth:sanctum', 'role:gerente'])
    ->prefix('gerente')
    ->group(function () {
        Route::post('renovar-suscripcion', [RenovarSuscripcionController::class, 'store']);
    });

/*
|------------------------------------------
| RUTAS STAFF (APP MOVIL)
|------------------------------------------
*/

Route::middleware([
    'auth:sanctum',
    'role:gerente,personal',
    'check.suscripcion'
])->prefix('staff')->group(function () {

    Route::get('/mesas', [MesaController::class,'index']);
    Route::get('/zonas', [ZonaController::class,'index']);
    Route::get('/promociones', [PromocionController::class,'index']);
    Route::get('/horarios', [HorarioController::class,'index']);

});