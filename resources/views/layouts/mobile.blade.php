<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#2D1F1A">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>METRA Staff - @yield('title')</title>

    <link rel="manifest" href="/manifest.json">
    <link rel="icon" href="{{ asset('favicon.png') }}?v=6" type="image/png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lato:wght@300;400;700&family=Lora:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile-app.css') }}?v={{ time() }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.API_URL = "{{ url('/api') }}";
        window.FILE_URL = "{{ url('/') }}";
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="mobile-app-body">

    <div class="adaptive-container">
        <!-- Header / Top Bar (Desktop only or for contextual info) -->
        <header class="mobile-top-bar d-flex align-items-center justify-content-between px-3">
            <h1 class="logo-text m-0"><i class="bi bi-hexagon-fill me-2 text-gold"></i>METRA</h1>
            <div class="user-action">
                <button class="btn btn-link text-white p-0" onclick="logoutStaff()">
                    <i class="bi bi-box-arrow-right fs-4"></i>
                </button>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="mobile-content-wrapper">
            @yield('content')
        </main>

        <!-- iOS Install Guide -->
        <div id="ios-install-guide" class="d-none px-4 py-3 bg-white border-top shadow-lg" style="position: absolute; bottom: var(--nav-height); left: 0; right: 0; z-index: 100;">
            <div class="d-flex align-items-center">
                <i class="bi bi-apple fs-1 me-3 text-dark"></i>
                <div class="flex-grow-1">
                    <p class="small m-0 fw-bold">Instalar METRA en tu iPhone</p>
                    <p class="small m-0 text-muted" style="font-size: 0.7rem;">Toca <i class="bi bi-share"></i> y selecciona <strong>"Añadir a la pantalla de inicio"</strong>.</p>
                </div>
                <button class="btn-close" onclick="closeInstallGuide()"></button>
            </div>
        </div>

        <!-- Bottom Navigation Bar (Mobile-first) -->
        <nav class="mobile-bottom-nav">
            <a href="/staff/inicio" class="nav-item {{ request()->is('staff/inicio') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i>
                <span>Inicio</span>
            </a>
            <a href="/staff/reservas" class="nav-item {{ request()->is('staff/reservas') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                <span>Reservas</span>
            </a>
            <a href="/staff/mesas" class="nav-item {{ request()->is('staff/mesas') ? 'active' : '' }}">
                <i class="bi bi-ui-checks-grid"></i>
                <span>Mesas</span>
            </a>
            <a href="/staff/registro" class="nav-item {{ request()->is('staff/registro') ? 'active' : '' }}">
                <i class="bi bi-person-plus"></i>
                <span>Registro</span>
            </a>
        </nav>
    </div>

    <!-- Modals -->
    @stack('modals')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/js/api.js'])
    <script>
        // Service Worker Registration
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .then(reg => console.log('SW Registered', reg))
                .catch(err => console.log('SW Error', err));
        }

        function logoutStaff() {
            Swal.fire({
                title: '¿Cerrar sesión?',
                text: "Se cerrará tu sesión operativa.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2D1F1A',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.clear();
                    sessionStorage.clear();
                    window.location.href = '/logout';
                }
            });
        }

        // Token check
        document.addEventListener('DOMContentLoaded', () => {
            if (!localStorage.getItem('token')) {
                window.location.href = '/login';
            }

            // iOS Install Presence Logic
            const isIos = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
            const isStandalone = window.navigator.standalone === true || window.matchMedia('(display-mode: standalone)').matches;

            if (isIos && !isStandalone) {
                document.getElementById('ios-install-guide').classList.remove('d-none');
            }
        });

        function closeInstallGuide() {
            document.getElementById('ios-install-guide').classList.add('d-none');
        }
    </script>
    @stack('scripts')
</body>
</html>
