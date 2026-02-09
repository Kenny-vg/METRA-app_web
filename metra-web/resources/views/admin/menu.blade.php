<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>METRA Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body class="zona-admin" style="background-color: #F5EFE6;">

    <aside class="sidebar">
        <h2 class="fw-bold mb-5 text-center" style="color: #FFAB40;">METRA</h2>
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
            <hr style="border-color: rgba(255,255,255,0.1);">
            <a href="/" class="nav-link-admin text-danger"><i class="bi bi-door-open me-2"></i> Salir</a>
        </nav>
    </aside>

    <main style="margin-left: 260px;" class="p-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>