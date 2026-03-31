<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidad | METRA</title>
    <link rel='icon' href='{{ asset('favicon.png') }}?v=6' type='image/png'>
    <link rel='icon' href='{{ asset('favicon.svg') }}?v=6' type='image/svg+xml'>
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
            <div class="d-flex align-items-center gap-3 order-lg-3 ms-auto ms-lg-0">
                <a href="{{ url('/login') }}" class="btn-metra-main px-4 py-2 rounded-pill" style="font-size: 0.9rem;">Iniciar Sesión</a>
                <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navPrivacidad">
                    <i class="bi bi-list fs-2" style="color: var(--black-primary);"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse order-lg-2" id="navPrivacidad">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2 gap-lg-4 mt-3 mt-lg-0 me-lg-4">
                    <li class="nav-item"><a href="{{ url('/') }}" class="nav-link nav-link-custom" style="color: #111111 !important;">Inicio</a></li>
                    <li class="nav-item"><a href="{{ url('/#cafeterias') }}" class="nav-link nav-link-custom" style="color: #111111 !important;">Ver Cafeterías</a></li>
                    <li class="nav-item"><a href="{{ url('/registro-negocio') }}" class="nav-link nav-link-custom" style="color: #111111 !important;">Sumar Cafetería</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5 flex-grow-1" style="max-width: 800px;">
        <h1 class="fw-bold mb-4" style="color: var(--black-primary);">Política de Privacidad</h1>
        <p class="text-muted mb-5">Última actualización: Marzo 2026</p>

        <section class="mb-5">
            <h4 class="fw-bold mb-3">1. Recopilación de Información</h4>
            <p style="color: var(--text-muted); line-height: 1.7;">
                Recopilamos varios tipos de información con diversos fines para proporcionar y mejorar nuestro servicio METRA, incluyendo su dirección de correo electrónico, nombre personal e información comercial sobre su cafetería o restaurante.
            </p>
        </section>

        <section class="mb-5">
            <h4 class="fw-bold mb-3">2. Uso de Datos</h4>
            <p style="color: var(--text-muted); line-height: 1.7;">
                METRA utiliza los datos recopilados para:
            </p>
            <ul style="color: var(--text-muted); line-height: 1.7;">
                <li class="mb-1">Proporcionar y mantener nuestro Servicio</li>
                <li class="mb-1">Notificarle sobre cambios en nuestro Servicio</li>
                <li class="mb-1">Permitirle participar en funciones interactivas</li>
                <li class="mb-1">Proporcionar asistencia al cliente</li>
                <li class="mb-1">Comprender los análisis o datos valiosos para que podamos mejorar</li>
            </ul>
        </section>

        <section class="mb-5">
            <h4 class="fw-bold mb-3">3. Retención de Datos</h4>
            <p style="color: var(--text-muted); line-height: 1.7;">
                Conservaremos sus datos personales solo durante el tiempo que sea necesario para los fines establecidos en esta Política de Privacidad. Podrá solicitar la eliminación de los datos de su negocio cerrando su cuenta.
            </p>
        </section>

        <section class="mb-5">
            <h4 class="fw-bold mb-3">4. Transferencia de Datos</h4>
            <p style="color: var(--text-muted); line-height: 1.7;">
                Como proveedor de software nacional (México), los datos se procesan y aseguran de acuerdo a las infraestructuras de nube de categoría empresarial de V-TECH.
            </p>
        </section>

        <section class="mb-5">
            <h4 class="fw-bold mb-3">5. Seguridad de Datos</h4>
            <p style="color: var(--text-muted); line-height: 1.7;">
                La seguridad de sus datos es importante para nosotros. Sin embargo, ningún método de transmisión por Internet o método de almacenamiento electrónico es 100 % seguro, por lo cual aplicamos mejores prácticas y cifrado de extremo a extremo.
            </p>
        </section>
    </main>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
