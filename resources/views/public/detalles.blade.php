<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Café Central</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal">

    <nav class="navbar navbar-expand-lg py-3 py-lg-4">
        <div class="container">
            <a href="/" class="navbar-brand fw-bold fs-2 text-decoration-none" style="color: #4E342E;">METRA</a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navDetalles" aria-controls="navDetalles" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-1" style="color: #4E342E;"></i>
            </button>

            <div class="collapse navbar-collapse" id="navDetalles">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2 gap-lg-3 mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a href="/admin-login" class="nav-link fw-bold small text-uppercase" style="color: #6D4C41;">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="btn-volver-chic d-block text-center">
                            <i class="bi bi-arrow-left-short"></i> Volver
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <hr class="m-0" style="opacity: 0.1;">
   

    <main class="container my-5">
    <div class="row g-4 g-lg-5">
        
        <div class="col-12 col-lg-8">
            <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&q=80&w=1200" 
                 class="img-detalles mb-4" alt="Café Central">

            <h1 class="fw-bold display-5">Café Central Tehuacán</h1>
            <p class="text-muted fs-5">Cafetería de Especialidad • • Tehuacán Centro</p>

            <div class="info-card">
                <h5 class="fw-bold mb-3">Horarios disponibles:</h5>
                <div class="d-flex flex-wrap">
                    <div class="time-slot">08:30 AM</div>
                    <div class="time-slot">09:00 AM</div>
                    <div class="time-slot">11:30 AM</div>
                    <div class="time-slot">01:00 PM</div>
                    <div class="time-slot">04:30 PM</div>
                    <div class="time-slot">07:00 PM</div>
                    <div class="time-slot">08:30 PM</div>
                </div>
                <small class="text-muted d-block mt-2">★ Lo mejor para ti</small>
            </div>

            <div class="info-card">
                <h4 class="fw-bold mb-4">Platillos destacados</h4>
                <div class="row g-3 text-center">
                    <div class="col-6 col-md-3">
                        <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=300" class="img-menu-item">
                        <p class="small fw-bold mt-2">Expreso Doble</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?w=300" class="img-menu-item">
                        <p class="small fw-bold mt-2">Chilaquiles</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <img src="https://images.unsplash.com/photo-1517433367423-c7e5b0f35086?w=300" class="img-menu-item">
                        <p class="small fw-bold mt-2">Pan Artesanal</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=300" class="img-menu-item">
                        <p class="small fw-bold mt-2">Matcha Latte</p>
                    </div>
                </div>
            </div>

            <div class="info-card mt-5" style="border-left: 5px solid var(--ambar);">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold m-0"><i ></i>Combos Exclusivos</h4>
                    <span class="badge rounded-pill bg-danger shadow-sm">¡Solo por tiempo limitado!</span>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded-4 bg-white shadow-sm h-100 border-start border-4 border-warning">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-bold mb-1">Desayuno Central</h6>
                                <span class="fw-bold text-success">$149</span>
                            </div>
                            <p class="text-muted small mb-2">Chilaquiles rojos o verdes + Café del día + Pan artesanal.</p>
                            <span class="badge bg-warning-subtle text-dark small" style="font-size: 0.7rem;">EL FAVORITO</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded-4 bg-white shadow-sm h-100 border-start border-4 border-info">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-bold mb-1">Tarde de Matcha</h6>
                                <span class="fw-bold text-success">$185</span>
                            </div>
                            <p class="text-muted small mb-2">2 Matcha Lattes (fríos o calientes) + Rebanada de Pastel de Elote.</p>
                            <span class="badge bg-info-subtle text-dark small" style="font-size: 0.7rem;">IDEAL PARA COMPARTIR</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded-4 bg-white shadow-sm h-100 border-start border-4 border-success">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-bold mb-1">Combo Estudiante</h6>
                                <span class="fw-bold text-success">$95</span>
                            </div>
                            <p class="text-muted small mb-2">Expreso Doble o Americano + Galleta de Avena + WiFi Ilimitado.</p>
                            <span class="badge bg-success-subtle text-dark small" style="font-size: 0.7rem;">FOCO TOTAL</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded-4 bg-white shadow-sm h-100 border-start border-4 border-primary">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-bold mb-1">Brunch Especial</h6>
                                <span class="fw-bold text-success">$220</span>
                            </div>
                            <p class="text-muted small mb-2">Huevos Benedictinos + Jugo de Naranja + Capuchino Grande.</p>
                            <span class="badge bg-primary-subtle text-dark small" style="font-size: 0.7rem;">PREMIUM</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <h4 class="fw-bold mb-4">Lo que dicen los clientes</h4>
                <div class="review-item">
                    <div class="stars">★★★★★</div>
                    <p class="mb-1 text-muted small fw-bold">Reseña del 25 de Enero, 2026</p>
                    <p class="text-muted small">"Excelente lugar para estudiar, el WiFi es rápido y el café delicioso."</p>
                </div>
                <div class="review-item">
                    <div class="stars">★★★★★</div>
                    <p class="mb-1 text-muted small fw-bold">Reseña del 25 de Enero, 2026</p>
                    <p class="text-muted small">"Excelente lugar para estudiar, el WiFi es rápido y el café delicioso."</p>
                </div>
                <div class="review-item">
                    <div class="stars">★★★★★</div>
                    <p class="mb-1 text-muted small fw-bold">Reseña del 25 de Enero, 2026</p>
                    <p class="text-muted small">"Excelente lugar para estudiar, el WiFi es rápido y el café delicioso."</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="info-card shadow-sm border-0 sticky-top" style="top: 20px; z-index: 10;">
                <h5 class="fw-bold mb-4">Haz una reservación</h5>
                <button onclick="window.location.href='/reservar'" class="btn-ambar">
                    Continuar con la reserva →
                </button>
                <hr class="my-4">
                <h6 class="fw-bold small text-muted">DETALLES ADICIONALES</h6>
                <p class="small mb-1"><strong>Ubicación:</strong> Calle 123 Col. Centro</p>
                <p class="small mb-1"><strong>Precios:</strong> De $300 a $500 MXN</p>
                <p class="small">Contamos con opciones de Pago</p>
                <p class="text-muted small mb-2 text-uppercase fw-bold" style="letter-spacing: 1px;">Políticas</p>
                  <ul class="list-unstyled small color-cafe-suave">
                     <li><i class="bi bi-check2-circle me-2"></i> 15 min de tolerancia</li>
                      <li><i class="bi bi-check2-circle me-2"></i> Enviamos sus datos al email</li>
                  </ul>
            </div>
        </div>
    </div>
    </main>
    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>