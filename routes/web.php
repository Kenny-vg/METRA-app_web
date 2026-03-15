<?php


/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin Login)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('public.bienvenida');
});

Route::get('/detalles/{slug}', function ($slug) {
    return view('public.detalles', ['slug' => $slug]);
});

Route::get('/reservar/{slug}', function ($slug) {
    return view('public.reservar', ['slug' => $slug]);
});

Route::get('/confirmacion/{folio}', function ($folio) {
    if (!preg_match('/^RSV-[A-Z0-9]{6}$/', strtoupper($folio))) abort(404);
    return view('public.confirmacion', ['folio' => strtoupper($folio)]);
});

// Landing de registro de negocios (pública, sin login)
Route::get('/registro-negocio', function () {
    return view('public.registro-negocio');
});

// Pantalla para subir comprobante pendiente
Route::get('/subir-comprobante/{id}', function ($id) {
    if(!is_numeric($id)) abort(404);
    return view('public.subir-comprobante', ['id' => $id]);
});

// Condiciones y Privacidad
Route::get('/terminos', function () {
    return view('public.terminos');
});

Route::get('/privacidad', function () {
    return view('public.privacidad');
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

// Olvidé mi contraseña (vista)
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

// Restablecer contraseña (vista)
Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('password.reset');

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

Route::get('/staff-app', function () {
    return view('public.staff-app');
});


// --- ZONA GERENTE (ADMIN) ---
Route::middleware(['check.web.role:gerente'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/admin/gestion_negocio', function () {
        return view('admin.gestion_negocio');
    });

    Route::get('/admin/carta', function () {
        return view('admin.carta');
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

    Route::get('/admin/marketing', function () {
        return view('admin.marketing');
    });
});



// --- ZONA SUPERADMIN ---
Route::middleware(['check.web.role:superadmin'])->group(function () {
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
});