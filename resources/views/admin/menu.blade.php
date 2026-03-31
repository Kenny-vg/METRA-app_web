<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA Admin - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/responsive_tables.css') }}?v={{ time() }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.API_URL = "{{ url('/api') }}";
        window.FILE_URL = "{{ url('/') }}";
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .custom-scrollbar {
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #8c714a transparent;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #8c714a;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background-color: var(--accent-gold);
        }
    </style>
</head>

<body class="zona-admin" style="background-color: var(--off-white); font-family: 'Inter', sans-serif;">

    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <div class="d-lg-none p-3 text-dark d-flex justify-content-between align-items-center bg-white border-bottom shadow-sm fixed-top"
        style="z-index: 1050;">
        <h4 class="fw-bold m-0 d-flex align-items-center">
            <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold);"></i>METRA
        </h4>
        <button class="btn btn-light border-0" onclick="toggleSidebar()">
            <i class="bi bi-list fs-3"></i>
        </button>
    </div>

    <aside class="sidebar d-flex flex-column min-vh-100"
        style="background-color: var(--black-primary); border-right: 1px solid var(--gray-dark);">

        <div class="d-flex flex-column align-items-center justify-content-center mb-4 mt-3 d-none d-lg-flex">
            <h2 class="fw-bold text-white">
                <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold);"></i>METRA
            </h2>

            <div id="sidebar-user-name" class="mt-2 text-white small fw-bold d-none text-uppercase text-center"></div>

            <div id="sidebar-cafe-name" class="mt-1 px-3 py-1 rounded-pill fw-bold d-none"
                style="background: rgba(181,146,126,0.15); color: var(--accent-gold); font-size: 0.65rem; max-width: 180px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-align: center;">
            </div>
        </div>

        <nav class="d-flex flex-column gap-2 px-3 flex-grow-1 custom-scrollbar">

            <span class="small fw-bold text-uppercase mt-2 mb-2 ms-3">Operaciones</span>

            <a href="/admin/dashboard" class="nav-link-admin {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-3"></i>Métricas
            </a>

            <a href="/admin/gestion_negocio"
                class="nav-link-admin {{ request()->is('admin/gestion_negocio') ? 'active' : '' }}">
                <i class="bi bi-shop me-3"></i>Gestión del Negocio
            </a>

            <a href="/admin/carta" class="nav-link-admin {{ request()->is('admin/carta') ? 'active' : '' }}">
                <i class="bi bi-book-half me-3"></i>Menú Digital
            </a>

            <a href="/admin/reservaciones"
                class="nav-link-admin {{ request()->is('admin/reservaciones') ? 'active' : '' }}">
                <i class="bi bi-calendar3 me-3"></i>Reservaciones
            </a>

            <a href="/admin/resenas" class="nav-link-admin {{ request()->is('admin/resenas') ? 'active' : '' }}">
                <i class="bi bi-star-half me-3"></i>Reseñas
            </a>

            <a href="/admin/marketing" class="nav-link-admin {{ request()->is('admin/marketing') ? 'active' : '' }}">
                <i class="bi bi-megaphone me-3"></i>Eventos y Promos
            </a>

            <span class="small fw-bold text-uppercase mt-4 mb-2 ms-3">Configuración</span>

            <a href="/admin/perfil" class="nav-link-admin {{ request()->is('admin/perfil') ? 'active' : '' }}">
                <i class="bi bi-person-circle me-3"></i>Cuenta
            </a>

        </nav>

        <div class="mt-auto p-3">
            <button type="button" id="btnCerrarSesion" class="btn btn-outline-danger w-100">
                <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
            </button>
        </div>

    </aside>

    <main class="main-content-admin">
        <div class="p-4 p-md-5">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        window.escapeHTML = function(str) {
            if (str === null || str === undefined) return '';
            return String(str).replace(/[&<>'"]/g, tag => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;'
            }[tag] || tag));
        };

        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');

            if (!sidebar || !overlay) return;

            const isActive = sidebar.classList.contains('active');

            if (isActive) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            } else {
                sidebar.classList.add('active');
                overlay.classList.add('active');
            }
        }

        document.getElementById('btnCerrarSesion')?.addEventListener('click', function (e) {
            e.preventDefault();
            localStorage.clear();
            sessionStorage.clear();
            window.location.href = '/logout';
        });
    </script>

</body>

</html>