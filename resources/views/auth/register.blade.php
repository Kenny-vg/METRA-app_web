<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Registro de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal">

    <main class="login-container">
        <div class="login-card text-center" style="border-top: 5px solid var(--accent-gold);">
            
            <span class="login-logo">METRA</span>
            <h5 class="fw-bold mb-4" style="color: #6D4C41;">Crea tu cuenta</h5>
            
            <p class="text-muted small mb-4">Regístrate para comenzar a reservar en tus lugares favoritos</p>

            <form action="{{ route('register') }}" method="POST">
                @csrf <div class="text-start mb-3">
                    <label class="form-label small fw-bold" style="color: var(--black-primary);">Nombre Completo</label>
                    <input type="text" name="name" class="form-control input-metra" placeholder="Ej. Cristina Juárez" required>
                </div>

                <div class="text-start mb-3">
                    <label class="form-label small fw-bold" style="color: var(--black-primary);">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control input-metra" placeholder="tu@correo.com" required>
                </div>

                <div class="text-start mb-3">
                    <label class="form-label small fw-bold" style="color: var(--black-primary);">Contraseña</label>
                    <input type="password" name="password" class="form-control input-metra" placeholder="••••••••" required>
                </div>

                <div class="text-start mb-4">
                    <label class="form-label small fw-bold" style="color: var(--black-primary);">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control input-metra" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-metra-main w-100 rounded-3">
                    Crear mi cuenta
                </button>
                
                <div class="my-4 d-flex align-items-center">
                    <hr class="flex-grow-1 opacity-25">
                    <span class="mx-3 small text-muted">o regístrate con</span>
                    <hr class="flex-grow-1 opacity-25">
                </div>

                <a href="#" class="btn btn-outline-dark w-100 rounded-pill py-2 shadow-sm">
                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="20" class="me-2">
                     Google
                </a>
            </form>

            <div class="mt-5">
                <a href="{{ route('login') }}" class="text-muted small text-decoration-none">
                    ¿Ya tienes cuenta? <span class="fw-bold text-dark">Inicia Sesión</span>
                </a>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>