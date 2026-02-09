<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>METRA - Café Central</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css?v=' . time()) }}">
</head>
<body class="zona-comensal">

   <nav class="navbar py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="/" class="fw-bold fs-2 text-decoration-none" style="color: #4E342E;">METRA</a>
        
        <a href="{{ url('/') }}" class="btn-volver-chic">
            <i class="bi bi-arrow-left-short"></i> Volver al inicio
        </a>

        <div class="container">
            <a href="/admin-login" class="admin-link">Iniciar Sesion</a>
        </div>
    </div>
</nav>
<hr class="m-0" style="opacity: 0.1;">
   

    <main class="container my-5">
    <div class="row g-5">
        
        <div class="col-lg-8">
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
                <div class="row g-3 text-center"> <div class="col-md-3 col-6"> <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=300" class="img-menu-item">
                        <p class="small fw-bold mt-2">Expreso Doble</p>
                    </div>
                    <div class="col-md-3 col-6">
                        <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?w=300" class="img-menu-item">
                        <p class="small fw-bold mt-2">Chilaquiles</p>
                    </div>
                    <div class="col-md-3 col-6">
                        <img src="https://images.unsplash.com/photo-1517433367423-c7e5b0f35086?w=300" class="img-menu-item">
                        <p class="small fw-bold mt-2">Pan Artesanal</p>
                    </div>
                    <div class="col-md-3 col-6">
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=300" class="img-menu-item">
                        <p class="small fw-bold mt-2">Matcha Latte</p>
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

        <div class="col-lg-4">
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
</body>
</html>