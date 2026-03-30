<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA – Detalle de Reservación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.API_URL = "{{ url('/api') }}";
        window.FILE_URL = "{{ url('/') }}";
    </script>
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
        .ticket-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 6px;
            background: #d4af37;
        }
        .check-icon {
            background: #111;
            width: 80px; height: 80px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            margin-top: -10px;
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
            color: #7b7871; font-size: 0.95rem;
            display: flex; align-items: center;
            font-weight: 600; letter-spacing: 0.5px;
        }
        .data-label i { color: #d4af37; margin-right: 8px; font-size: 1.2rem; }
        .data-value { color: #111; font-weight: 600; font-size: 1.05rem; text-align: right; }

        .estado-badge {
            display: inline-block;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .estado-pendiente  { background: #fff8e1; color: #b58500; }
        .estado-cancelada  { background: #fce8e8; color: #c62828; }
        .estado-completada { background: #e8f5e9; color: #2e7d32; }
        .estado-pasada     { background: #f0f0f0; color: #757575; }
    </style>
</head>
<body class="zona-comensal">

    <nav class="navbar py-3" style="background: transparent;">
        <div class="container text-center">
            <a href="/" class="text-decoration-none">
                <span class="fw-bold fs-3" style="color: #111; letter-spacing: -0.5px;">
                    <i class="bi bi-hexagon-fill me-2" style="color: #d4af37; font-size: 1.2rem;"></i>METRA
                </span>
            </a>
        </div>
    </nav>

    <main class="container mb-5 mt-2" style="min-height: 70vh; display: flex; align-items: center; justify-content: center;">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

                {{-- Estado: cargando --}}
                <div id="loading-state" class="text-center py-5">
                    <div class="spinner-border" style="color: #d4af37;" role="status"></div>
                    <p class="mt-3 fw-bold text-muted">Cargando tu reservación...</p>
                </div>

                {{-- Estado: error --}}
                <div id="error-state" class="text-center py-5" style="display: none;">
                    <i class="bi bi-exclamation-triangle-fill fs-1" style="color: #d4af37;"></i>
                    <h5 class="fw-bold mt-3">Reservación no encontrada</h5>
                    <p class="text-muted">El folio ingresado no existe o es inválido.</p>
                    <a href="/" class="btn btn-dark rounded-pill px-4 mt-2">Volver al inicio</a>
                </div>

                {{-- Estado: datos cargados --}}
                <div id="detail-state" class="ticket-container text-center" style="display: none;">

                    <div id="icon-check" class="check-icon mx-auto mb-4">
                        <i class="bi bi-check2 text-white" style="font-size: 2.5rem;"></i>
                    </div>
                    <div id="icon-cancelled" class="mx-auto mb-4" style="display:none; width:80px; height:80px; background:#c62828; border-radius:50%; align-items:center; justify-content:center; box-shadow:0 10px 20px rgba(0,0,0,0.15);">
                        <i class="bi bi-x-lg text-white" style="font-size: 2rem;"></i>
                    </div>

                    <div class="ticket-header mb-5">
                        <h2 class="fw-bold mb-2" style="font-size: 2rem; letter-spacing: -0.5px;" id="card-titulo">Reservación Confirmada</h2>
                        <p style="color: #555; font-size: 1.05rem;">
                            <strong style="color: #111;" id="card-nombre"></strong>
                        </p>
                        <div class="mt-3 mb-1">
                            <span class="small fw-bold" style="color: #7b7871; letter-spacing: 1.5px;">CÓDIGO DE ACCESO</span><br>
                            <span class="folio-badge d-inline-block mt-2" id="card-folio"></span>
                        </div>
                        <div class="mt-3">
                            <span class="estado-badge" id="card-estado-badge"></span>
                        </div>
                    </div>

                    <div class="ticket-data text-start px-md-3 mt-4">
                        <div class="d-flex justify-content-between align-items-center data-row">
                            <span class="data-label"><i class="bi bi-shop"></i> Cafetería:</span>
                            <span class="data-value" id="card-cafeteria">—</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center data-row">
                            <span class="data-label"><i class="bi bi-calendar-event"></i> Fecha:</span>
                            <span class="data-value" id="card-fecha">—</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center data-row">
                            <span class="data-label"><i class="bi bi-clock"></i> Horario:</span>
                            <span class="data-value" id="card-hora">—</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center data-row" style="border-bottom: none;">
                            <span class="data-label"><i class="bi bi-people"></i> Invitados:</span>
                            <span class="data-value" id="card-pax">—</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center data-row mt-2" id="card-comentarios-row" style="display: none !important; border-bottom: none;">
                            <span class="data-label"><i class="bi bi-chat-left-text"></i> Notas:</span>
                            <span class="data-value" id="card-comentarios" style="text-align: right; max-width: 60%; font-weight: 500; color: #555;"></span>
                        </div>
                    </div>

                    <div class="mt-5 d-flex flex-column gap-3">
                        <button id="btn-cancelar" class="btn w-100 fw-bold py-3 rounded-3"
                                style="background: #fff; color: #c62828; border: 1.5px solid #c62828; font-size: 0.95rem; letter-spacing: 0.5px;">
                            <i class="bi bi-x-circle me-2"></i>Cancelar mi reservación
                        </button>
                        <a href="/" class="btn w-100 fw-bold py-3 rounded-3"
                           style="background: linear-gradient(135deg, #2a2a2a, #111); color: #fff; font-size: 0.95rem; letter-spacing: 0.5px;">
                            Volver al inicio
                        </a>
                        <p class="small fw-bold mt-1" style="color: #7b7871; letter-spacing: 0.5px;">
                            <i class="bi bi-shield-check me-1" style="color: #d4af37;"></i> METRA Hospitality Security
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </main>

    @include('partials.footer')

<script>
    const folio = '{{ $folio }}';

    const MESES = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];

    function formatFecha(isoDate) {
        const [y, m, d] = isoDate.split('-');
        const meses = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        return `${parseInt(d)} de ${meses[parseInt(m)-1]}, ${y}`;
    }

    function getEstadoBadge(reserva) {
        const { estado, fecha, hora_inicio } = reserva;
        if (estado === 'cancelada')  return { clase: 'estado-cancelada',  texto: 'Cancelada' };
        if (estado === 'completada') return { clase: 'estado-completada', texto: 'Completada' };
        const inicio = new Date(`${fecha}T${hora_inicio}`);
        if (inicio < new Date())     return { clase: 'estado-pasada',    texto: 'Pasada' };
        return                              { clase: 'estado-pendiente',  texto: 'Confirmada' };
    }

    async function cargarReservacion() {
        try {
            const json = await MetraAPI.get(`/reservaciones/folio/${folio}`);
            const r = json.data;

            // Población de datos
            document.getElementById('card-folio').textContent   = r.folio;
            document.getElementById('card-nombre').textContent  = r.nombre_cliente;
            document.getElementById('card-fecha').textContent   = formatFecha(r.fecha);
            document.getElementById('card-hora').textContent    = r.hora_inicio.substring(0,5) + ' hrs';
            document.getElementById('card-pax').textContent     = r.numero_personas + (r.numero_personas > 1 ? ' personas' : ' persona');
            document.getElementById('card-cafeteria').textContent = r.cafeteria ? r.cafeteria.nombre : 'METRA';

            if (r.comentarios) {
                document.getElementById('card-comentarios').textContent = r.comentarios;
                document.getElementById('card-comentarios-row').style.display = 'flex';
            }

            const badge = getEstadoBadge(r);
            const badgeEl = document.getElementById('card-estado-badge');
            badgeEl.textContent = badge.texto;
            badgeEl.className   = 'estado-badge ' + badge.clase;

            const isCancelledOrPast = (r.estado === 'cancelada' || r.estado === 'completada') ||
                                      (new Date(`${r.fecha}T${r.hora_inicio}`) < new Date());

            if (r.estado === 'cancelada') {
                document.getElementById('card-titulo').textContent = 'Reservación Cancelada';
                document.getElementById('icon-check').style.display   = 'none';
                document.getElementById('icon-cancelled').style.display = 'flex';
            }

            if (isCancelledOrPast) {
                document.getElementById('btn-cancelar').style.display = 'none';
            }

            // Mostrar detalle
            document.getElementById('loading-state').style.display = 'none';
            document.getElementById('detail-state').style.display  = 'block';

            // Botón cancelar
            document.getElementById('btn-cancelar').addEventListener('click', cancelarReservacion.bind(null, r));

        } catch (e) {
            document.getElementById('loading-state').style.display = 'none';
            document.getElementById('error-state').style.display   = 'block';
        }
    }

    async function cancelarReservacion(r) {
        const confirm = await Swal.fire({
            title: '¿Cancelar reservación?',
            html: `Vas a cancelar la reservación del <strong>${formatFecha(r.fecha)}</strong> a las <strong>${r.hora_inicio.substring(0,5)} hrs</strong>.<br><br>Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#c62828',
            cancelButtonColor: '#111',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No, mantener'
        });

        if (!confirm.isConfirmed) return;

        try {
            const json = await MetraAPI.delete(`/reservaciones/folio/${folio}`);
            
            await Swal.fire({
                icon: 'success',
                title: 'Reservación cancelada',
                text: 'Tu reservación ha sido cancelada exitosamente.',
                confirmButtonColor: '#111'
            });
            window.location.reload();
        } catch(error) {
            const data = error.data || {};
            Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Intenta de nuevo.', confirmButtonColor: '#111' });
        }
    }

    document.addEventListener('DOMContentLoaded', cargarReservacion);
</script>
</body>
</html>