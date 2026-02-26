<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-admin" style="background-color: var(--off-white); font-family: 'Inter', sans-serif;">

    <!-- Navbar Móvil -->
    <div class="d-md-none p-3 text-white d-flex justify-content-between align-items-center" style="background-color: var(--black-primary); border-bottom: 1px solid var(--gray-dark);">
        <h4 class="fw-bold m-0 d-flex align-items-center" style="letter-spacing: -0.5px;">
            <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold); font-size: 1.2rem;"></i>METRA
        </h4>
        <button class="btn btn-sm btn-outline-light border-0" onclick="document.querySelector('.sidebar').classList.toggle('active')">
            <i class="bi bi-list fs-3"></i>
        </button>
    </div>

    <!-- Sidebar SaaS -->
    <aside class="sidebar" style="background-color: var(--black-primary); border-right: 1px solid var(--gray-dark);">
        <div class="d-flex align-items-center justify-content-center mb-5 mt-3 d-none d-md-flex">
             <h2 class="fw-bold m-0 d-flex align-items-center text-white" style="letter-spacing: -1px;">
                <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold); font-size: 1.5rem;"></i>METRA
            </h2>
        </div>
        <nav class="d-flex flex-column gap-2 px-3">
            <span class="small fw-bold text-uppercase mb-2 ms-3" style="color: var(--text-muted); font-size: 0.7rem; letter-spacing: 1px;">Operaciones</span>
            
            <a href="/admin/dashboard" class="nav-link-admin {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-3"></i>Métricas
            </a>
            <a href="/admin/gestion_negocio" class="nav-link-admin {{ request()->is('admin/gestion_negocio') ? 'active' : '' }}">
                <i class="bi bi-shop me-3"></i>Gestión de Menú
            </a>
            <a href="/admin/reservaciones" class="nav-link-admin {{ request()->is('admin/reservaciones') ? 'active' : '' }}">
                <i class="bi bi-calendar3 me-3"></i>Reservaciones
            </a>
            
            <span class="small fw-bold text-uppercase mt-4 mb-2 ms-3" style="color: var(--text-muted); font-size: 0.7rem; letter-spacing: 1px;">Configuración</span>
            
            <a href="/admin/perfil" class="nav-link-admin {{ request()->is('admin/perfil') ? 'active' : '' }}">
                <i class="bi bi-person-circle me-3"></i>Cuenta
            </a>
            
            <div class="mt-auto pt-5">
                <a href="/logout" id="btnCerrarSesion" class="btn-logout d-flex align-items-center justify-content-center w-100" style="padding: 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); transition: 0.2s;">
                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                </a>
            </div>
        </nav>
    </aside>

    <main class="main-content-admin" style="margin-left: 280px; min-height: 100vh;">
        <div class="p-4 p-md-5">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Adaptación móvil
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.querySelector('.d-md-none .btn');
            
            if (window.innerWidth < 768 && 
                sidebar && toggleBtn &&
                !sidebar.contains(event.target) && 
                !toggleBtn.contains(event.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Limpieza de sesión
        document.getElementById('btnCerrarSesion')?.addEventListener('click', function(e) {
            e.preventDefault();
            localStorage.removeItem('token');
            localStorage.clear();
            window.location.href = '/logout';
        });
    </script>
</body>
</html>