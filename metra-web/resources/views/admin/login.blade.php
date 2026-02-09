<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>METRA - Acceso Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilos.css?v=' . time()) }}">
</head>
<body class="zona-admin">

    <main class="login-container">
        <div class="login-card text-center">
            
            <span class="login-logo">METRA</span>
            <h5 class="fw-bold mb-4" style="color: #6D4C41;">Panel de Administración</h5>
            
            <p class="text-muted small mb-5">Bienvenido</p>

            <form action="/admin/dashboard" method="GET">
                <div class="text-start mb-4">
                    <label class="form-label small fw-bold" style="color: #4E342E;">Correo Electrónico</label>
                    <input type="email" class="form-control input-metra" placeholder="admin@metra.com">
                </div>

                <div class="text-start mb-4">
                    <label class="form-label small fw-bold" style="color: #4E342E;">Contraseña</label>
                    <input type="password" class="form-control input-metra" placeholder="••••••••">
                </div>

                <button type="submit" class="btn-login">
                    Acceder al Panel →
                </button>
                <a href="/login/google" class="btn btn-outline-dark w-100 rounded-pill py-2 shadow-sm">
                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="20" class="me-2">
                     Continuar con Google
                </a>
            </form>

            <div class="mt-5">
                <a href="/" class="text-muted small text-decoration-none">← Volver a la web principal</a>
            </div>
        </div>
    </main>
 @include('partials.footer_admin')
</body>
</html>