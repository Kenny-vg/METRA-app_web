<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Acceso Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal">

    <main class="login-container">
        <div class="login-card text-center" style="border-top: 5px solid var(--ambar);">
            
            <span class="login-logo">METRA</span>
            <h5 class="fw-bold mb-4" style="color: #6D4C41;">Panel de Administración</h5>
            
            <p class="text-muted small mb-5">Accede para gestionar tu restaurante</p>

            <form action="/admin/dashboard" method="GET">
                <div class="text-start mb-4">
                    <label class="form-label small fw-bold" style="color: #4E342E;">Correo Electrónico</label>
                    <input type="email" class="form-control input-metra" placeholder="admin@metra.com">
                </div>

                <div class="text-start mb-4">
                    <label class="form-label small fw-bold" style="color: #4E342E;">Contraseña</label>
                    <input type="password" class="form-control input-metra" placeholder="••••••••">
                </div>

                <button type="submit" class="btn-metra-main w-100 rounded-3">
                    Acceder al Panel →
                </button>
                
                <div class="my-4 d-flex align-items-center">
                    <hr class="flex-grow-1 opacity-25">
                    <span class="mx-3 small text-muted">o continúa con</span>
                    <hr class="flex-grow-1 opacity-25">
                </div>

                <a href="/login/google" class="btn btn-outline-dark w-100 rounded-pill py-2 shadow-sm">
                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="20" class="me-2">
                     Google
                </a>
            </form>

            <div class="mt-5">
                <a href="/" class="text-muted small text-decoration-none">← Volver a la web principal</a>
            </div>
        </div>
    </main>

</body>
</html>