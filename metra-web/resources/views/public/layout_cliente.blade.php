<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>METRA - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}"> 
</head>
<div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a class="nav-link text-white" href="/reservar"><i class="bi bi-calendar-plus me-1"></i> Nueva Reserva</a>
        </li>
    </ul>
</div>
<body style="background-color: #F5EFE6;"> <nav class="navbar navbar-expand-lg shadow-sm p-3" style="background-color: #4E342E;">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="/">METRA</a>
            
            <div class="ms-auto d-flex align-items-center">
                <span class="text-white me-3 small">Hola, Maria</span>
                <img src="https://ui-avatars.com/api/?name=Maria&background=FFAB40&color=4E342E" class="rounded-circle" width="35">
            </div>
        </div>
    </nav>

    <main class="container py-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>