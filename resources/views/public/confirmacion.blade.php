<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Servicio Confirmado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal" style="background-color: var(--off-white) !important;">

    <nav class="navbar py-4" style="background: var(--white-pure); border-bottom: 1px solid var(--border-light);">
        <div class="container text-center">
            <span class="fw-bold fs-3" style="color: var(--black-primary); margin: 0 auto; letter-spacing: -0.5px;">
                <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold); font-size: 1.2rem;"></i>METRA
            </span>
        </div>
    </nav>

    <main class="container my-5" style="min-height: 70vh; display: flex; align-items: center; justify-content: center;">
        <div class="ticket-container text-center w-100" style="background: var(--white-pure); border: none; box-shadow: 0 20px 50px rgba(0,0,0,0.06); border-radius: 20px;">
            
            <div class="check-icon mx-auto" style="background: var(--black-primary); width: 70px; height: 70px;">
                <i class="bi bi-check2" style="font-size: 2rem;"></i>
            </div>
            
            <div class="ticket-header" style="border-bottom: 1px solid var(--border-light);">
                <h2 class="fw-bold" style="color: var(--black-primary); letter-spacing: -1px;">Servicio Confirmado</h2>
                <p style="color: var(--text-muted);">Su reserva ha sido procesada exitosamente.</p>
                <div class="mt-4 mb-2">
                    <span class="small fw-bold" style="color: var(--text-muted); letter-spacing: 1.5px;">CÓDIGO DE ACCESO:</span><br>
                    <span class="folio-text d-inline-block mt-2 fs-5" style="border: 1px solid var(--border-light);">#MET-2026-A7B9</span>
                </div>
            </div>

            <div class="ticket-data text-start px-md-4 mt-5">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom" style="border-color: var(--border-light) !important;">
                    <span style="color: var(--text-muted);"><i class="bi bi-shop me-2"></i>Destino:</span>
                    <span class="fw-bold text-end" style="color: var(--black-primary);">Café Central Tehuacán</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom" style="border-color: var(--border-light) !important;">
                    <span style="color: var(--text-muted);"><i class="bi bi-calendar3 me-2"></i>Fecha del servicio:</span>
                    <span class="fw-bold text-end" style="color: var(--black-primary);">30 de Enero, 2026</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom" style="border-color: var(--border-light) !important;">
                    <span style="color: var(--text-muted);"><i class="bi bi-clock me-2"></i>Horario:</span>
                    <span class="fw-bold text-end" style="color: var(--black-primary);">08:30 PM</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom" style="border-color: var(--border-light) !important;">
                    <span style="color: var(--text-muted);"><i class="bi bi-people me-2"></i>Invitados:</span>
                    <span class="fw-bold text-end" style="color: var(--black-primary);">2 Adultos</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom" style="border-color: var(--border-light) !important;">
                    <span style="color: var(--text-muted);"><i class="bi bi-geo-alt me-2"></i>Área preferente:</span>
                    <span class="fw-bold text-end" style="color: var(--black-primary);">Balcón / Terraza Privada</span>
                </div>
            </div>

           <div class="mt-5">
                <button onclick="window.location.href='/'" 
                        class="btn-metra-main border-0 px-5 py-3 w-100" 
                        style="border-radius: 12px; font-size: 1.05rem;">
                    Finalizar y volver al Inicio
                </button>
                <p class="mt-4 small fw-bold" style="color: var(--text-muted); letter-spacing: 0.5px;">
                    <i class="bi bi-shield-check me-1"></i> METRA Hospitality Security
                </p>
            </div>
        </div>
    </main>
@include('partials.footer')
</body>
</html>