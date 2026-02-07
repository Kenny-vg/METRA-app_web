<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>METRA - Reserva Confirmada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilos.css?v=' . time()) }}">
</head>
<body>

    <nav class="navbar py-4">
        <div class="container text-center">
            <span class="fw-bold fs-2" style="color: #4E342E; margin: 0 auto;">METRA</span>
        </div>
    </nav>
    <hr>

    <main class="container my-5">
        <div class="ticket-container text-center">
            
            <div class="check-icon">✓</div>
            
            <div class="ticket-header">
                <h2 class="fw-bold" style="color: #4E342E;">¡Reserva Confirmada!</h2>
                <p class="text-muted">Tu mesa ha sido apartada con éxito.</p>
                <div class="mt-3">
                    <span class="small text-muted">FOLIO DE RESERVA:</span><br>
                    <span class="folio-text">#MET-2026-A7B9</span>
                </div>
            </div>

            <div class="ticket-data text-start px-3">
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Establecimiento:</span>
                    <span class="fw-bold">Café Central Tehuacán</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Fecha:</span>
                    <span class="fw-bold">30 de Enero, 2026</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Hora:</span>
                    <span class="fw-bold">08:30 PM</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Personas:</span>
                    <span class="fw-bold">2 Adultos</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Zona:</span>
                    <span class="fw-bold">Balcón / Terraza</span>
                </div>
                <hr>
            </div>

           <div class="mt-5">
    <button onclick="window.location.href='/'" 
            class="btn-metra-main border-0 px-4 py-2" 
            style="background-color: #4E342E; color: white !important; border-radius: 50px;">
        Volver al Inicio
    </button>
    <p class="mt-3 small text-muted">Gracias por reservar con nosotros!</p>
</div>

        </div>
    </main>

</body>
</html>