<?php


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

// Login (solo vista)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Registro (solo vista)
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Logout manejado por frontend API
Route::get('/logout', function () {
    return redirect('/login');
})->name('logout');
/*
|--------------------------------------------------------------------------
| LÓGICA DE REDIRECCIÓN (HOME)
|--------------------------------------------------------------------------
*/

Route::get('/home', function () {
    return redirect('/login');
})->name('home');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS POR ROL (Dashboards)
|--------------------------------------------------------------------------
*/

// --- ZONA CLIENTE ---
Route::get('/public/perfil', function () {
    return view('public.perfil');
});


// --- ZONA GERENTE (ADMIN) ---
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/gestion_negocio', function () {
    return view('admin.gestion_negocio');
});

Route::get('/admin/reservaciones', function () {
    return view('admin.reservaciones');
});

Route::get('/admin/reportes', function () {
    return view('admin.reportes');
});

Route::get('/admin/perfil', function () {
    return view('admin.perfil');
});



// --- ZONA SUPERADMIN ---
Route::get('/superadmin/dashboard', function () {
    return view('superadmin.dashboard');
});

Route::get('/superadmin/suscripciones', function () {
    return view('superadmin.suscripciones');
});

Route::get('/superadmin/planes', function () {
    return view('superadmin.planes');
});

Route::get('/superadmin/ajustes', function () {
    return view('superadmin.ajustes');
});

Route::post('/superadmin/guardar-ajustes', function () {
    return redirect('/superadmin/ajustes')->with('success', 'Ajustes guardados correctamente.');
});