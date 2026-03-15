<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Servicio Confirmado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #fdfcfb 0%, #e2d1c3 100%); 
            color: #111; 
            min-height: 100vh;
        }
        
        .ticket-container {
            background: #ffffff; 
            border-radius: 16px; 
            padding: 3rem 2.5rem; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.08); 
            border: 1px solid rgba(212,175,55,0.15); 
            position: relative;
            overflow: hidden;
        }

        /* Adorno dorado superior */
        .ticket-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: #d4af37;
        }
        
        .check-icon {
            background: #111; 
            width: 80px; 
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            margin-top: -10px;
        }
        
        .ticket-title {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            color: #111;
            font-size: 2.2rem;
            letter-spacing: -0.5px;
        }

        .folio-badge {
            background: #faf9f7;
            border: 1px dashed #d4af37;
            color: #111;
            font-family: 'monospace';
            font-size: 1.25rem;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            letter-spacing: 1px;
        }

        .data-row {
            border-bottom: 1px solid #f0ecdf;
            padding-bottom: 0.85rem;
            margin-bottom: 1rem;
        }
        
        .data-label {
            color: #7b7871;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .data-label i {
            color: #d4af37;
            margin-right: 8px;
            font-size: 1.2rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .data-value {
            color: #111;
            font-weight: 600;
            font-size: 1.05rem;
            text-align: right;
        }

        .btn-metra-main { 
            background: linear-gradient(135deg, #2a2a2a 0%, #111 100%);
            color: #ffffff !important; 
            border-radius: 10px; 
            font-weight: 600; 
            padding: 1.1rem; 
            border: 1px solid #111; 
            transition: all 0.3s ease; 
            letter-spacing: 0.5px; 
            text-transform: uppercase;
            font-size: 0.95rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
        
        .btn-metra-main:hover { 
            background: #111; 
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.2);
            border-color: #000;
        }
    </style>
</head>
<body class="zona-comensal">

    <nav class="navbar py-3" style="background: transparent;">
        <div class="container text-center">
            <span class="fw-bold fs-3" style="color: #111; margin: 0 auto; letter-spacing: -0.5px; font-family: 'Inter', sans-serif;">
                <i class="bi bi-hexagon-fill me-2" style="color: #d4af37; font-size: 1.2rem;"></i>METRA
            </span>
        </div>
    </nav>

    <main class="container mb-5 mt-2" style="min-height: 70vh; display: flex; align-items: center; justify-content: center;">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                
                <div class="ticket-container text-center">
                    <div class="check-icon mx-auto mb-4">
                        <i class="bi bi-check2 text-white" style="font-size: 2.5rem;"></i>
                    </div>
                    
                    <div class="ticket-header mb-5">
                        <h2 class="ticket-title mb-2">Servicio Confirmado</h2>
                        <p style="color: #555; font-size: 1.05rem;">
                            <strong style="color: #111;">{{ $reservacion->nombre_cliente }}</strong>, su reserva ha sido procesada exitosamente.
                        </p>
                        <div class="mt-4 mb-2">
                            <span class="small fw-bold" style="color: #7b7871; letter-spacing: 1.5px;">CÓDIGO DE ACCESO</span><br>
                            <span class="folio-badge d-inline-block mt-2">{{ $reservacion->folio }}</span>
                        </div>
                    </div>

                    <div class="ticket-data text-start px-md-3 mt-4">
                        <div class="d-flex justify-content-between align-items-center data-row">
                            <span class="data-label"><i class="bi bi-shop"></i> Destino:</span>
                            <span class="data-value">{{ $reservacion->cafeteria ? $reservacion->cafeteria->nombre : 'Sucursal METRA' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center data-row">
                            <span class="data-label"><i class="bi bi-calendar-event"></i> Fecha del servicio:</span>
                            <span class="data-value">{{ \Carbon\Carbon::parse($reservacion->fecha)->locale('es')->translatedFormat('d \d\e F, Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center data-row">
                            <span class="data-label"><i class="bi bi-clock"></i> Horario:</span>
                            <span class="data-value">{{ substr($reservacion->hora_inicio, 0, 5) }} hrs</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center data-row">
                            <span class="data-label"><i class="bi bi-people"></i> Invitados:</span>
                            <span class="data-value">{{ $reservacion->numero_personas }} {{ $reservacion->numero_personas > 1 ? 'Personas' : 'Persona' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center data-row" style="border-bottom: none;">
                            <span class="data-label"><i class="bi bi-geo-alt"></i> Área preferente:</span>
                            <span class="data-value">{{ $zonaPreferida }}</span>
                        </div>
                    </div>

                    <div class="mt-5">
                            <button onclick="window.location.href='/'" class="btn btn-metra-main w-100" style="color: #ffffff !important;">
                                Finalizar y volver al Inicio
                            </button>
                            <p class="mt-4 small fw-bold" style="color: #7b7871; letter-spacing: 0.5px;">
                                <i class="bi bi-shield-check me-1" style="color: #d4af37;"></i> METRA Hospitality Security
                            </p>
                    </div>
                </div>

            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>