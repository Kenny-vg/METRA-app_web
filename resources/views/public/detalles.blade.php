<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Café Central</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal">

    <nav class="navbar navbar-expand-lg py-3 py-lg-4" style="background: rgba(248, 249, 250, 0.9); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border-light); position: sticky; top: 0; z-index: 1000;">
        <div class="container">
            <a href="/" class="navbar-brand fw-bold fs-3 text-decoration-none" style="color: var(--black-primary); letter-spacing: -0.5px;">
                <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold); font-size: 1.2rem;"></i>METRA
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navDetalles">
                <i class="bi bi-list fs-2" style="color: var(--black-primary);"></i>
            </button>

            <div class="collapse navbar-collapse" id="navDetalles">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2 gap-lg-4 mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a href="/admin-login" class="nav-link fw-bold small text-uppercase" style="color: var(--text-muted); letter-spacing: 1px;">Portal Gerente</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="btn-metra-main px-4 py-2" style="font-size: 0.85rem; background: transparent; color: var(--black-primary) !important; border-color: var(--border-light); box-shadow: none;">
                            <i class="bi bi-arrow-left-short"></i> Volver al Inicio
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
   
    <main class="container my-5">
    <div class="row g-4 g-lg-5">
        
        <div class="col-12 col-lg-8">
            <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&q=80&w=1200" 
                 class="img-detalles mb-4" alt="Interior Exclusivo">

            <div class="d-flex justify-content-between align-items-center mb-2">
                 <h1 class="fw-bold display-5 m-0" style="letter-spacing: -1px;">Café Central</h1>
                 <span class="badge" style="background: var(--off-white); color: var(--text-main); border: 1px solid var(--border-light); padding: 8px 16px;">Cafetería Destacada</span>
            </div>
            <p class="fs-5 mb-5" style="color: var(--text-muted);">El mejor ambiente • Tehuacán Centro</p>

            <div class="info-card">
                <h5 class="fw-bold mb-4" style="color: var(--black-primary);">Disponibilidad de Mesas</h5>
                <div class="d-flex flex-wrap gap-2">
                    <div class="time-slot">08:30 AM</div>
                    <div class="time-slot">09:00 AM</div>
                    <div class="time-slot">11:30 AM</div>
                    <div class="time-slot">01:00 PM</div>
                    <div class="time-slot">04:30 PM</div>
                    <div class="time-slot">07:00 PM</div>
                    <div class="time-slot">08:30 PM</div>
                </div>
                <small class="d-block mt-3 fw-bold" style="color: var(--accent-gold);"><i class="bi bi-star-fill me-1"></i> Horarios de mayor demanda</small>
            </div>

            <div class="info-card">
                <h4 class="fw-bold mb-4" style="letter-spacing: -0.5px;">Nuestro Menú</h4>
                <div class="row g-4 text-center">
                    <div class="col-6 col-md-3">
                        <img src="https://images.unsplash.com/photo-1541167760496-1628856ab772?w=300&q=80" class="img-menu-item shadow-sm">
                        <p class="small fw-bold mt-3 mb-0">Flat White</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <img src="https://images.unsplash.com/photo-1550461716-bf5ce596f280?w=300&q=80" class="img-menu-item shadow-sm">
                        <p class="small fw-bold mt-3 mb-0">Brunch Benedictino</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=300&q=80" class="img-menu-item shadow-sm">
                        <p class="small fw-bold mt-3 mb-0">Bowl Orgánico</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <img src="https://images.unsplash.com/photo-1544145945-f90425340c7e?w=300&q=80" class="img-menu-item shadow-sm">
                        <p class="small fw-bold mt-3 mb-0">Matcha Ceremonial</p>
                    </div>
                </div>
            </div>

            <div class="info-card border-0 shadow-none p-0 bg-transparent">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h4 class="fw-bold m-0" style="letter-spacing: -0.5px;">Combos Exclusivos</h4>
                    <span class="badge rounded-pill bg-danger shadow-sm">¡Solo por tiempo limitado!</span>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <div class="p-4 rounded-4 bg-white h-100" style="border: 1px solid var(--border-light); box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="fw-bold fs-5 mb-0">Desayuno Central</h6>
                                <span class="fw-bold text-success" style="font-size: 1.1rem;">$149</span>
                            </div>
                            <p class="small mb-3" style="color: var(--text-muted); line-height: 1.6;">Chilaquiles rojos o verdes + Café del día + Pan artesanal.</p>
                            <span class="badge" style="background: rgba(197, 160, 89, 0.15); color: var(--accent-gold); border: 1px solid rgba(197, 160, 89, 0.3);">EL FAVORITO</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-4 rounded-4 bg-white h-100" style="border: 1px solid var(--border-light); box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="fw-bold fs-5 mb-0">Tarde de Matcha</h6>
                                <span class="fw-bold text-success" style="font-size: 1.1rem;">$185</span>
                            </div>
                            <p class="small mb-3" style="color: var(--text-muted); line-height: 1.6;">2 Matcha Lattes (fríos o calientes) + Rebanada de Pastel de Elote.</p>
                            <span class="badge bg-info-subtle text-dark">IDEAL PARA COMPARTIR</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-4 rounded-4 bg-white h-100" style="border: 1px solid var(--border-light); box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="fw-bold fs-5 mb-0">Combo Estudiante</h6>
                                <span class="fw-bold text-success" style="font-size: 1.1rem;">$95</span>
                            </div>
                            <p class="small mb-3" style="color: var(--text-muted); line-height: 1.6;">Expreso Doble o Americano + Galleta de Avena + WiFi Ilimitado.</p>
                            <span class="badge bg-success-subtle text-dark">FOCO TOTAL</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-4 rounded-4 bg-white h-100" style="border: 1px solid var(--border-light); box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                            <div class="d-flex justify-content-between mb-2">
                                <h6 class="fw-bold fs-5 mb-0">Brunch Especial</h6>
                                <span class="fw-bold text-success" style="font-size: 1.1rem;">$220</span>
                            </div>
                            <p class="small mb-3" style="color: var(--text-muted); line-height: 1.6;">Huevos Benedictinos + Jugo de Naranja + Capuchino Grande.</p>
                            <span class="badge bg-primary-subtle text-dark">PREMIUM</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-card mt-5">
                <h4 class="fw-bold mb-4" style="letter-spacing: -0.5px;">Lo que dicen los clientes</h4>
                <div class="review-item">
                    <div class="stars mb-1" style="color: var(--accent-gold); letter-spacing: 2px;">★★★★★</div>
                    <p class="mb-1 text-muted small fw-bold">Reseña del 25 de Enero, 2026</p>
                    <p class="small" style="color: var(--text-muted);">"Excelente lugar para estudiar, el WiFi es rápido y el café delicioso."</p>
                </div>
                <div class="review-item">
                    <div class="stars mb-1" style="color: var(--accent-gold); letter-spacing: 2px;">★★★★★</div>
                    <p class="mb-1 text-muted small fw-bold">Reseña del 25 de Enero, 2026</p>
                    <p class="small" style="color: var(--text-muted);">"Excelente lugar para estudiar, el WiFi es rápido y el café delicioso."</p>
                </div>
                <div class="review-item">
                    <div class="stars mb-1" style="color: var(--accent-gold); letter-spacing: 2px;">★★★★★</div>
                    <p class="mb-1 text-muted small fw-bold">Reseña del 25 de Enero, 2026</p>
                    <p class="small" style="color: var(--text-muted);">"Excelente lugar para estudiar, el WiFi es rápido y el café delicioso."</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="info-card border-0 sticky-top p-4 p-lg-5" style="top: 100px; z-index: 10; box-shadow: 0 20px 40px rgba(0,0,0,0.04);">
                <h4 class="fw-bold mb-4 text-center" style="letter-spacing: -0.5px;">Haz una reservación</h4>
                <button onclick="window.location.href='/reservar'" class="btn-metra-main w-100 py-3 fs-5 mb-4">
                    Continuar con la reserva →
                </button>
                <hr class="my-4" style="opacity: 0.1;">
                <h6 class="fw-bold small mb-3 text-center" style="color: var(--text-muted); letter-spacing: 1.5px;">DETALLES ADICIONALES</h6>
                
                <div class="d-flex align-items-start mb-3">
                    <i class="bi bi-geo-alt fs-5 me-3" style="color: var(--black-primary);"></i>
                    <div>
                        <p class="mb-0 fw-bold fs-6">Ubicación</p>
                        <p class="small m-0" style="color: var(--text-muted);">Calle 123 Col. Centro</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-start mb-3">
                    <i class="bi bi-wallet2 fs-5 me-3" style="color: var(--black-primary);"></i>
                    <div>
                        <p class="mb-0 fw-bold fs-6">Precios</p>
                        <p class="small m-0" style="color: var(--text-muted);">De $300 a $500 MXN<br>Contamos con opciones de Pago</p>
                    </div>
                </div>

                <div class="mt-4 p-3 rounded" style="background: var(--off-white); border: 1px solid var(--border-light);">
                    <p class="small mb-2 fw-bold" style="letter-spacing: 0.5px;"><i class="bi bi-shield-check me-2"></i>POLÍTICAS</p>
                    <ul class="list-unstyled small m-0" style="color: var(--text-muted); max-width: 90%;">
                        <li class="mb-1"><i class="bi bi-check2-circle me-1"></i> 15 min de tolerancia</li>
                        <li><i class="bi bi-check2-circle me-1"></i> Enviamos sus datos al email</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </main>
    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>