<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Términos y Condiciones | METRA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: var(--off-white); display: flex; flex-direction: column; min-height: 100vh;">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg py-3 py-lg-4" style="background: rgba(248, 249, 250, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border-light); position: sticky; top: 0; z-index: 1000;">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="{{ url('/') }}" style="color: var(--black-primary); letter-spacing: -0.5px;">
                <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold); font-size: 1.2rem;"></i>METRA
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navTerminos">
                <i class="bi bi-list fs-2" style="color: var(--black-primary);"></i>
            </button>
            <div class="collapse navbar-collapse" id="navTerminos">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2 gap-lg-4 mt-3 mt-lg-0">
                    <li class="nav-item"><a href="{{ url('/') }}" class="nav-link nav-link-custom">Inicio</a></li>
                    <li class="nav-item"><a href="{{ url('/#cafeterias') }}" class="nav-link nav-link-custom">Ver Cafeterías</a></li>
                    <li class="nav-item"><a href="{{ url('/registro-negocio') }}" class="nav-link nav-link-custom">Sumar Cafetería</a></li>
                    <li class="nav-item">
                        <a href="{{ url('/login') }}" class="btn-metra-main px-4 py-2" style="font-size: 0.9rem; border-radius: 6px;">Iniciar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5 flex-grow-1" style="max-width: 800px;">
        <h1 class="fw-bold mb-4" style="color: var(--black-primary);">Términos y Condiciones de Uso</h1>
        <p class="text-muted mb-5">Última actualización: Marzo 2026</p>

        <section class="mb-5">
            <h4 class="fw-bold mb-3">1. Aceptación de los Términos</h4>
            <p style="color: var(--text-muted); line-height: 1.7;">
                Al acceder y utilizar los servicios de METRA, usted acepta estar sujeto a estos términos y condiciones. Si no está de acuerdo con alguna parte de los términos, no podrá acceder al servicio.
            </p>
        </section>

        <section class="mb-5">
            <h4 class="fw-bold mb-3">2. Descripción del Servicio</h4>
            <p style="color: var(--text-muted); line-height: 1.7;">
                METRA es un software como servicio (SaaS) diseñado para la gestión de reservas y ocupación de mesas en establecimientos gastronómicos. Las características específicas dependen del plan de suscripción contratado.
            </p>
        </section>

        <section class="mb-5">
            <h4 class="fw-bold mb-3">3. Cuentas de Usuario</h4>
            <ul style="color: var(--text-muted); line-height: 1.7;">
                <li class="mb-2">Debe proporcionar información precisa, completa y actualizada en todo momento al crear una cuenta.</li>
                <li class="mb-2">Es responsable de salvaguardar la contraseña que utiliza para acceder al servicio.</li>
                <li class="mb-2">Usted acepta no revelar su contraseña a terceros.</li>
            </ul>
        </section>

        <section class="mb-5">
            <h4 class="fw-bold mb-3">4. Pagos y Suscripciones</h4>
            <p style="color: var(--text-muted); line-height: 1.7;">
                Algunas partes del servicio se facturan mediante planes de suscripción. Su cuenta solo será activada tras la verificación manual de sus comprobantes de transferencia por nuestro equipo administrativo.
            </p>
        </section>

        <section class="mb-5">
            <h4 class="fw-bold mb-3">5. Limitación de Responsabilidad</h4>
            <p style="color: var(--text-muted); line-height: 1.7;">
                En ningún caso METRA, ni sus directores, empleados o afiliados serán responsables por daños indirectos, incidentales, especiales, o consecuentes que surjan del uso de nuestro servicio.
            </p>
        </section>
    </main>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
