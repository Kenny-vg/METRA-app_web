<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

//  Ruta temporal para entrar directo a GERENTE POR SI NO DEJA ENTRAR POR EL CACHE 
//Route::get('/entrar-ya', function () {
   // return view('admin.dashboard'); 
//});
/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin Login)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('public.bienvenida');
});

Route::get('/detalles', function () {
    return view('public.detalles');
});

Route::get('/reservar', function () {
    return view('public.reservar');
});

Route::get('/confirmacion', function () {
    return view('public.confirmacion');
});

// Landing de registro de negocios (pública, sin login)
Route::get('/registro-negocio', function () {
    return view('public.registro-negocio');
});

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

// Salida oficial del sistema (Limpieza de sesión y token)
Route::get('/logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken(); 
    return redirect('/login');
})->name('logout');

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Google Auth
use App\Http\Controllers\Auth\GoogleController;
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

/*
|--------------------------------------------------------------------------
| LÓGICA DE REDIRECCIÓN (HOME)
|--------------------------------------------------------------------------
*/

Route::get('/home', function () {
    $user = auth()->user();
    
    if ($user->role == 'superadmin') {
        return redirect('/superadmin/dashboard');
    } elseif ($user->role == 'gerente') {
        return redirect('/admin/dashboard');
    } else {
        return redirect('/public/perfil');
    }
})->middleware(['auth']);

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS POR ROL (Dashboards)
|--------------------------------------------------------------------------
*/

// --- ZONA CLIENTE ---
Route::get('/public/perfil', function () {
    return view('public.perfil');
})->middleware(['auth']);


// --- ZONA GERENTE (ADMIN) ---
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth']);

Route::get('/admin/gestion_negocio', function () {
    return view('admin.gestion_negocio');
})->middleware(['auth']);

Route::get('/admin/reservaciones', function () {
    return view('admin.reservaciones');
})->middleware(['auth']);

Route::get('/admin/reportes', function () {
    return view('admin.reportes');
})->middleware(['auth']);

Route::get('/admin/perfil', function () {
    return view('admin.perfil');
})->middleware(['auth']);



// --- ZONA SUPERADMIN ---
Route::get('/superadmin/dashboard', function () {
    return view('superadmin.dashboard');
})->middleware(['auth']);

Route::get('/superadmin/suscripciones', function () {
    return view('superadmin.suscripciones');
})->middleware(['auth']);

Route::get('/superadmin/ajustes', function () {
    return view('superadmin.ajustes');
})->middleware(['auth']);

Route::post('/superadmin/guardar-ajustes', function () {
    return redirect('/superadmin/ajustes')->with('success', 'Ajustes guardados correctamente.');
})->middleware(['auth']);