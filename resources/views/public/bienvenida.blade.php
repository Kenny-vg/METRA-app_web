<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Bienvenido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal">

    <nav class="navbar navbar-expand-lg py-3 py-lg-4" style="background: rgba(248, 249, 250, 0.9); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border-light); position: sticky; top: 0; z-index: 1000;">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="/" style="color: var(--black-primary); letter-spacing: -0.5px;">
                <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold); font-size: 1.2rem;"></i>METRA
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navBienvenida">
                <i class="bi bi-list fs-2" style="color: var(--black-primary);"></i>
            </button>

            <div class="collapse navbar-collapse" id="navBienvenida">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2 gap-lg-4 mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a href="/detalles#info" class="nav-link nav-link-custom">La Plataforma</a>
                    </li>
                    <li class="nav-item">
                        <a href="/detalles#ubicacion" class="nav-link nav-link-custom">Explorar</a>
                    </li>
                    <li class="nav-item">
                        <a href="/login" class="nav-link nav-link-custom fw-bold">Portal Restaurantes</a>
                    </li>
                    <li class="nav-item">
                        <a href="/reservar" class="btn-metra-main px-4 py-2" style="font-size: 0.9rem; border-radius: 6px;">Reservar tu Mesa</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="hero-container" style="background: linear-gradient(180deg, var(--off-white) 0%, #FFFFFF 100%);">
        <div class="container py-5">
            <div class="row align-items-center gy-5">
                
                <div class="col-lg-6 text-center text-lg-start pe-lg-5">
                    <span style="display:inline-block; background: rgba(0,0,0,0.04); color: var(--text-muted); font-size: 0.8rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 6px 16px; border-radius: 50px; margin-bottom: 24px; border: 1px solid var(--border-light);">
                        El sistema ideal para tu negocio
                    </span>
                    <h1 class="hero-title" style="font-family: 'Inter', sans-serif;">
                        METRA <br>
                        <span style="color: var(--accent-gold);">Olvídate de las esperas.</span>
                    </h1>
                    <p class="fs-5 mb-5" style="color: var(--text-muted); max-width: 520px; font-weight: 400; line-height: 1.6;">
                        Reserva tu mesa en segundos y disfruta de tu experiencia gastronómica desde el primer momento. Fácil y rápido.
                    </p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                        <a href="/detalles" class="btn-metra-main" style="padding: 16px 36px; font-size: 1.05rem;">
                            Reservar ahora <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="image-wrapper text-center position-relative">
                        <div class="image-bg-decoration" style="background: var(--gray-dark); width: 85%; height: 85%; transform: translate(15%, 15%); border-radius: 12px; opacity: 0.05;"></div>
                        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                             class="img-restaurante img-fluid shadow-lg" alt="Interior Minimalista Restaurante" 
                             style="max-width: 100%; height: auto; border-radius: 12px; object-fit: cover; aspect-ratio: 4/3; position: relative; z-index: 2;">
                    </div>
                </div>

            </div>
        </div>
    </main>


    <!-- ─── SECCIÓN PARA DUEÑOS / GERENTES ─── -->
    <section style="background: linear-gradient(135deg, var(--black-primary), var(--gray-dark)); padding: 80px 0; margin-top: 0; position: relative; overflow: hidden;">
        <!-- Elemento decorativo sutil -->
        <div style="position: absolute; top: -100px; right: -50px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(212, 175, 55, 0.08) 0%, transparent 60%); border-radius: 50%;"></div>
        
        <div class="container position-relative" style="z-index: 1;">
            <div class="row align-items-center gy-4">
                <div class="col-lg-7 text-white">
                    <span style="display:inline-block; background: rgba(212, 175, 55, 0.15); color: var(--accent-gold);
                        font-size: 0.78rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;
                        padding: 6px 18px; border-radius: 50px; margin-bottom: 20px; border: 1px solid rgba(212, 175, 55, 0.3);">
                        ¿Eres dueño de un restaurante o cafetería?
                    </span>
                    <h2 style="font-family: 'Poppins', sans-serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; line-height: 1.15; margin-bottom: 20px; letter-spacing: -0.5px;">
                        Únete a METRA y gestiona tus reservas <span style="color: var(--accent-gold);">de forma fácil</span>
                    </h2>
                    <p style="color: rgba(255,255,255,0.75); font-size: 1.1rem; max-width: 540px; margin-bottom: 0; font-weight: 300;">
                        Automatiza tus mesas y mejora el servicio de tu negocio con nuestra plataforma. Comienza hoy mismo.
                    </p>
                    <div class="d-flex flex-wrap gap-4 mt-4 pt-2">
                        <div class="d-flex align-items-center gap-2" style="color: rgba(255,255,255,0.85); font-size: 0.95rem;">
                            <i class="bi bi-check-circle-fill" style="color: var(--accent-gold);"></i> Gestión en tiempo real
                        </div>
                        <div class="d-flex align-items-center gap-2" style="color: rgba(255,255,255,0.85); font-size: 0.95rem;">
                            <i class="bi bi-check-circle-fill" style="color: var(--accent-gold);"></i> Mapas interactivos
                        </div>
                        <div class="d-flex align-items-center gap-2" style="color: rgba(255,255,255,0.85); font-size: 0.95rem;">
                            <i class="bi bi-check-circle-fill" style="color: var(--accent-gold);"></i> Bases de clientes fieles
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 text-center text-lg-end mt-5 mt-lg-0">
                    <a href="/registro-negocio" class="btn-metra-main"
                       style="padding: 18px 45px; font-size: 1.1rem; border-radius: 50px;
                              box-shadow: 0 10px 30px rgba(212, 175, 55, 0.3);">
                        <i class="bi bi-rocket-takeoff me-2"></i>Descubrir Planes
                    </a>
                    <p style="color: rgba(255,255,255,0.4); font-size: 0.85rem; margin-top: 16px; margin-bottom: 0;">
                        El sistema ideal para potenciar tu PyME gastronómica.
                    </p>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>