<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA SaaS - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-superadmin">
    <div class="d-md-none p-3 text-white d-flex justify-content-between align-items-center bg-dark">
        <h4 class="fw-bold m-0">METRA <small style="font-size: 0.6rem;" class="text-muted">SaaS</small></h4>
        <button class="btn btn-outline-secondary" onclick="document.querySelector('.sidebar-super').classList.toggle('active')">
            <i class="bi bi-list fs-4"></i>
        </button>
    </div>

    <aside class="sidebar-super">
        <div class="p-4 text-white d-none d-md-block">
            <h2 class="fw-bold m-0">METRA</h2>
            <span class="badge bg-primary" style="font-size: 0.6rem;">SaaS Master</span>
        </div>
        <nav class="mt-4">
            <a href="/superadmin/dashboard" class="nav-link-super {{ request()->is('superadmin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill me-2"></i> Clientes Globales
            </a>
            <a href="/superadmin/suscripciones" class="nav-link-super {{ request()->is('superadmin/suscripciones') ? 'active' : '' }}">
                <i class="bi bi-wallet2 me-2"></i> Suscripciones
            </a>
            <a href="/superadmin/ajustes" class="nav-link-super {{ request()->is('superadmin/ajustes') ? 'active' : '' }}">
                <i class="bi bi-gear me-2"></i> Ajustes Sistema
            </a>
           <a href="/logout" id="btnCerrarSesion" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </a>
        </nav>
    </aside>

    <main style="margin-left: 280px;" class="p-4 p-md-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar-super');
            const toggleBtn = document.querySelector('.d-md-none .btn');
            
            if (window.innerWidth < 768 && 
                !sidebar.contains(event.target) && 
                !toggleBtn.contains(event.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    </script>
    <script>
document.getElementById('btnCerrarSesion')?.addEventListener('click', function(e) {
    e.preventDefault();
    
    // 1. Borramos el rastro de la API
    localStorage.removeItem('token');
    localStorage.clear();
    
    // 2. Nos vamos a la ruta de Laravel para cerrar la sesión del servidor
    window.location.href = '/logout';
});
</script>
</body>
</html>