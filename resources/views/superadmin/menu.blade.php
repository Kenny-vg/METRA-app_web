<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA SaaS - @yield('title')</title>
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

</head>
<body class="zona-superadmin" style="font-family: 'Inter', sans-serif;">
    
    <!-- Overlay para navegación móvil -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Header móvil elegante -->
    <div class="d-lg-none p-3 text-dark d-flex justify-content-between align-items-center bg-white border-bottom shadow-sm fixed-top" style="z-index: 1060;">
        <h4 class="fw-bold m-0 d-flex align-items-center" style="color: var(--black-primary); letter-spacing: -0.5px;">
            <i class="bi bi-hexagon-fill me-2" style="color: #3b82f6; font-size: 1.2rem;"></i>METRA
            <small style="font-size: 0.65rem; color: var(--text-muted) !important;" class="ms-1 text-uppercase fw-bold">SaaS</small>
        </h4>
        <button class="btn btn-light border-0" onclick="toggleSidebar()">
            <i class="bi bi-list fs-3"></i>
        </button>
    </div>

    <!-- Sidebar SaaS -->
    <aside class="sidebar-super d-flex flex-column min-vh-100" style="border-right: 1px solid var(--gray-dark);">
        <div class="d-flex flex-column align-items-center justify-content-center mb-4 mt-3 d-none d-lg-flex">
            <h2 class="fw-bold m-0 d-flex align-items-center text-white" style="letter-spacing: -1px;">
                <i class="bi bi-hexagon-fill me-2" style="color: #3b82f6; font-size: 1.5rem;"></i>METRA
            </h2>
            <span class="badge rounded-pill mt-2" style="font-size: 0.65rem; background: rgba(59,130,246,0.15); color: #3b82f6; font-weight: 700; letter-spacing: 1px; padding: 5px 12px;">SAAS MASTER</span>
        </div>
        <nav class="d-flex flex-column gap-2 px-3 flex-grow-1">
            <span class="small fw-bold text-uppercase mt-2 mb-2 ms-3" style="color: var(--text-muted); font-size: 0.7rem; letter-spacing: 1px;">Administración</span>
            
            <a href="/superadmin/dashboard" class="nav-link-super {{ request()->is('superadmin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill me-3"></i>Dashboard
            </a>
            <a href="/superadmin/suscripciones" class="nav-link-super {{ request()->is('superadmin/suscripciones') ? 'active' : '' }}">
                <i class="bi bi-wallet2 me-3"></i>Suscripciones
            </a>
            <a href="/superadmin/planes" class="nav-link-super {{ request()->is('superadmin/planes') ? 'active' : '' }}">
                <i class="bi bi-stack me-3"></i>Planes
            </a>
            <a href="/superadmin/ajustes" class="nav-link-super {{ request()->is('superadmin/ajustes') ? 'active' : '' }}">
                <i class="bi bi-gear me-3"></i>Ajustes Sistema
            </a>
        </nav>
        
        <div class="mt-auto p-3">
            <a href="/logout" id="btnCerrarSesion" class="btn btn-outline-danger d-flex align-items-center justify-content-center w-100" style="padding: 12px; border-radius: 8px; font-weight: 500; transition: all 0.2s;">
                <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
            </a>
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
            const sidebar = document.querySelector('.sidebar-super');
            const overlay = document.querySelector('.sidebar-overlay');
            if (sidebar && overlay) {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }
        }

        document.getElementById('btnCerrarSesion')?.addEventListener('click', function(e) {
            e.preventDefault();
            localStorage.clear();
            sessionStorage.clear();
            window.location.href = '/logout';
        });
    </script>
</body>
</html>