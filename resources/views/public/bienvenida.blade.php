<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Bienvenido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal">

    <nav class="navbar navbar-expand-lg py-3 py-lg-4">
        <div class="container">
            <a class="navbar-brand fw-bold fs-2" href="/" style="color: #4E342E;">METRA</a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navBienvenida" aria-controls="navBienvenida" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-1" style="color: #4E342E;"></i>
            </button>

            <div class="collapse navbar-collapse" id="navBienvenida">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2 gap-lg-3 mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a href="/detalles#info" class="nav-link nav-link-custom">Conócenos</a>
                    </li>
                    <li class="nav-item">
                        <a href="/detalles#ubicacion" class="nav-link nav-link-custom">Ubicación</a>
                    </li>
                    <li class="nav-item">
                        <a href="/login" class="nav-link nav-link-custom">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a href="/reservar" class="btn-nav-reserva d-block text-center">Terminar Reserva</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <hr class="m-0" style="opacity: 0.1;">

    <main class="hero-container">
        <div class="container">
            <div class="row align-items-center">
                
                <div class="col-lg-6 text-start">
                    <h1 class="hero-title">METRA<br>
                        <span style="color: #6D4C41; font-size: 3rem;">Olvídate de las esperas</span>
                    </h1>
                    <p class="fs-5 mb-5" style="color: #795548; max-width: 500px;">
                        Reserva tu mesa en segundos y disfruta de tu experiencia gastronómica desde el primer momento.
                    </p>
                    <a href="/detalles" class="btn-metra-main">Reservar ahora →</a>
                </div>

                <div class="col-lg-6">
                    <div class="image-wrapper text-center">
                        <div class="image-bg-decoration"></div>
                        <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&q=80&w=800" 
                             class="img-restaurante img-fluid rounded shadow-lg" alt="Restaurante" style="max-width: 100%; height: auto;">
                    </div>
                </div>

            </div>
        </div>
    </main>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>