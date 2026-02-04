<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>METRA - Bienvenido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>

    <nav class="navbar navbar-expand-lg py-4">
        <div class="container">
            <a class="navbar-brand fw-bold fs-2" href="/" style="color: #4E342E;">METRA</a>
            
           <div class="ms-auto d-flex align-items-center gap-3">
    <a href="/detalles#info" class="nav-link-custom">Conócenos</a>
    <a href="/detalles#ubicacion" class="nav-link-custom">Ubicación</a>
    <a href="/reservar" class="btn-nav-reserva">Terminar Reserva</a>
</div>
    </nav>
    <hr>

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
                             class="img-restaurante" alt="Restaurante">
                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="footer-admin text-center">
        <div class="container">
            <a href="/admin-login" class="admin-link">© 2026 METRA - Acceso Personal</a>
        </div>
    </footer>

</body>
</html>