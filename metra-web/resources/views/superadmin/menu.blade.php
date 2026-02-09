<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>METRA SaaS - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/superadmin.css') }}">
</head>
<body class="zona-superadmin">
    <aside class="sidebar-super">
        <div class="p-4 text-white">
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
            <hr class="text-white-50 mx-3">
            <a href="/admin/login" class="nav-link-super text-danger"><i class="bi bi-door-open me-2"></i> Salir</a>
        </nav>
    </aside>

    <main style="margin-left: 260px;" class="p-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>