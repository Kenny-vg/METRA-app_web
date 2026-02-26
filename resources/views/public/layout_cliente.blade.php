<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}?v={{ time() }}"> 
</head>
<body style="background-color: var(--off-white); font-family: 'Inter', sans-serif;">
    <nav class="navbar navbar-expand-lg sticky-top py-3" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border-light);">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="/" style="color: var(--black-primary); letter-spacing: -0.5px;">
                <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold); font-size: 1.2rem;"></i>METRA
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-2" style="color: var(--black-primary);"></i>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center mt-3 mt-lg-0 gap-3">
                    <li class="nav-item">
                        <a class="btn-metra-main px-4 py-2" href="/reservar" style="font-size: 0.85rem; border-radius: 8px;">
                            <i class="bi bi-calendar-plus me-2"></i> Nueva Reserva
                        </a>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <div style="height: 30px; width: 1px; background-color: var(--border-light);"></div>
                    </li>
                    <li class="nav-item d-flex align-items-center bg-white px-3 py-2 rounded-pill" style="border: 1px solid var(--border-light); cursor: pointer; box-shadow: 0 2px 10px rgba(0,0,0,0.02)">
                        <div class="me-3 text-end d-none d-sm-block">
                            <p class="m-0 fw-bold small" style="color: var(--black-primary); line-height: 1;">Maria</p>
                            <span style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">Miembro Black</span>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=Maria&background=0A0A0A&color=FFFFFF" class="rounded-circle" width="36" style="border: 2px solid var(--white-pure); box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>