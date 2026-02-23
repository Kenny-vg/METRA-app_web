<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-admin" style="background-color: #F5EFE6;">

    <div class="d-md-none p-3 text-white d-flex justify-content-between align-items-center" style="background-color: #4E342E;">
        <h4 class="fw-bold m-0" style="color: #FFAB40;">METRA</h4>
        <button class="btn btn-outline-warning" onclick="document.querySelector('.sidebar').classList.toggle('active')">
            <i class="bi bi-list fs-4"></i>
        </button>
    </div>

    <aside class="sidebar">
        <h2 class="fw-bold mb-5 text-center d-none d-md-block" style="color: #FFAB40;">METRA</h2>
        <nav>
            <a href="/admin/dashboard" class="nav-link-admin {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <a href="/admin/gestion_negocio" class="nav-link-admin {{ request()->is('admin/gestion_negocio') ? 'active' : '' }}">
                <i class="bi bi-shop me-2"></i> Gestión
            </a>
            <a href="/admin/reservaciones" class="nav-link-admin {{ request()->is('admin/reservaciones') ? 'active' : '' }}">
                <i class="bi bi-calendar3 me-2"></i> Reservaciones
            </a>
            <a href="/admin/perfil" class="nav-link-admin {{ request()->is('admin/perfil') ? 'active' : '' }}">
                <i class="bi bi-person-circle me-2"></i> Perfil
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
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
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