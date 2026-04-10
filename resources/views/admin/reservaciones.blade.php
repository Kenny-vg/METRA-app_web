@extends('admin.menu')
@section('title', 'Dashboard de Reservaciones')

@section('content')
    <header
        class="mb-4 border-bottom pb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3"
        style="border-color: var(--border-light) !important;">
        <div>
            <h2 class="fw-bold"
                style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Monitor Tactico
            </h2>
            <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Dashboard de alto rendimiento en tiempo
                real.</p>
        </div>
        <button class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center"
            onclick="abrirModalConfigReservas()"
            style="background: var(--black-primary); font-family: 'Inter', sans-serif;">
            <i class="bi bi-gear-fill me-2" style="color: var(--accent-gold);"></i> Configuración
        </button>
    </header>

    {{-- ── Banner de uso de reservaciones del plan ───────────────────── --}}
    <div id="banner-uso-reservas" class="mb-4"></div>

    <!-- Header Stats (Hoy de un vistazo) -->
    <div class="row mb-5 g-3">
        <div class="col-md-3">
            <div class="p-4 rounded-4 shadow-sm"
                style="background: var(--white-pure); border: 1px solid var(--border-light); height: 100%;">
                <div class="d-flex align-items-center mb-2">
                    <div style="width: 40px; height: 40px; background: rgba(212,175,55,0.1); border-radius: 50%; color: #d4af37;"
                        class="d-flex align-items-center justify-content-center me-3">
                        <i class="bi bi-people-fill fs-5"></i>
                    </div>
                    <span class="text-muted fw-bold"
                        style="letter-spacing: 0.5px; font-size: 0.85rem; text-transform: uppercase;">Aforo Esperado</span>
                </div>
                <h3 class="fw-bold m-0" style="color: var(--black-primary); font-size: 2rem;" id="statTotalPersonas">...
                </h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 rounded-4 shadow-sm"
                style="background: var(--white-pure); border: 1px solid var(--border-light); height: 100%;">
                <div class="d-flex align-items-center mb-2">
                    <div style="width: 40px; height: 40px; background: rgba(0,0,0,0.05); border-radius: 50%; color: var(--black-primary);"
                        class="d-flex align-items-center justify-content-center me-3">
                        <i class="bi bi-clock-history fs-5"></i>
                    </div>
                    <span class="text-muted fw-bold"
                        style="letter-spacing: 0.5px; font-size: 0.85rem; text-transform: uppercase;">Proxima Reserva</span>
                </div>
                <h5 class="fw-bold m-0" style="color: var(--black-primary); font-size: 1.2rem;" id="statProxima">...</h5>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 rounded-4 shadow-sm"
                style="background: var(--white-pure); border: 1px solid var(--border-light); height: 100%;">
                <div class="d-flex align-items-center mb-2">
                    <div style="width: 40px; height: 40px; background: rgba(46,125,50,0.1); border-radius: 50%; color: #2e7d32;"
                        class="d-flex align-items-center justify-content-center me-3">
                        <i class="bi bi-cup-hot-fill fs-5"></i>
                    </div>
                    <span class="text-muted fw-bold"
                        style="letter-spacing: 0.5px; font-size: 0.85rem; text-transform: uppercase;">En curso</span>
                </div>
                <h3 class="fw-bold m-0" style="color: var(--black-primary); font-size: 2rem;" id="statEnCurso">...</h3>
            </div>
        </div>
        <div class="col-md-3" id="panel-selector-dia">
            <div class="p-4 rounded-4 shadow-sm d-flex flex-column justify-content-center"
                style="background: linear-gradient(135deg, #111, #2a2a2a); border: 1px solid #000; height: 100%;">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div>
                        <span class="text-white-50 fw-bold d-block mb-1"
                            style="letter-spacing: 0.5px; font-size: 0.8rem; text-transform: uppercase;">Selector de
                            Dia</span>
                        <div class="d-flex align-items-center" style="cursor: pointer;"
                            onclick="document.getElementById('inputDate').showPicker()">
                            <h5 class="fw-bold m-0 text-white" id="dateDisplay" style="font-family: 'Inter', sans-serif;">
                                Cargando...</h5>
                            <i class="bi bi-calendar-event ms-2 text-warning"></i>
                        </div>
                        <input type="date" id="inputDate"
                            style="position: absolute; opacity: 0; width: 0; height: 0; padding: 0; border: none;">
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <button
                            class="btn btn-sm btn-outline-light rounded-circle btn-day-nav d-flex align-items-center justify-content-center"
                            data-offset="-1" style="width: 32px; height: 32px;"><i class="bi bi-chevron-up"></i></button>
                        <button
                            class="btn btn-sm btn-outline-light rounded-circle btn-day-nav d-flex align-items-center justify-content-center"
                            data-offset="1" style="width: 32px; height: 32px;"><i class="bi bi-chevron-down"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leyenda de colores -->
    <div class="d-flex flex-wrap gap-3 mb-4 px-2" style="font-size: 0.85rem; font-weight: 600;">
        <span class="d-flex align-items-center text-muted"><i class="bi bi-circle-fill me-2 border border-secondary"
                style="color: #fff; border-radius: 50%;"></i> Pendiente</span>
        <span class="d-flex align-items-center text-muted"><i class="bi bi-circle-fill me-2 p-1"
                style="background: #e8f5e9; color: #2e7d32; border-radius: 50%;"></i> En curso</span>
        <span class="d-flex align-items-center text-muted"><i class="bi bi-circle-fill me-2 p-1"
                style="background: #f5f5f5; color: #9e9e9e; border-radius: 50%;"></i> Finalizada</span>
        <span class="d-flex align-items-center text-muted"><i class="bi bi-circle-fill me-2 p-1"
                style="background: #fce4e4; color: #c62828; border-radius: 50%;"></i> No Show</span>
        <span class="d-flex align-items-center text-muted"><i class="bi bi-circle-fill me-2 p-1"
                style="background: #ffebee; color: #d32f2f; border-radius: 50%;"></i> Cancelada</span>
    </div>

    <!-- Tabs Navegacion -->
    <div class="d-flex gap-2 mb-4 px-2">
        <button class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm" id="btn-modo-dia" onclick="cambiarModo('dia')"
            style="font-family: 'Inter', sans-serif;">Vista por Dia</button>
        <button class="btn btn-outline-dark rounded-pill px-4 fw-bold shadow-sm" id="btn-modo-futuras"
            onclick="cambiarModo('futuras')" style="font-family: 'Inter', sans-serif;">Proximas Reservas</button>
    </div>

    <!-- Grid Layout -->
    <div class="card p-0 border-0 bg-transparent mb-5">
        <div id="reservaciones-grid" class="row g-4">
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-muted" role="status"></div>
                <p class="mt-2 text-muted fw-bold small">SINCRONIZANDO AGENDA...</p>
            </div>
        </div>
    </div>

    <!-- Plantilla para Tarjeta de Reserva -->
    <template id="reserva-template">
        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div class="card h-100 position-relative js-card"
                style="cursor:pointer; border-radius:14px; transition:transform .2s ease,box-shadow .2s ease;">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex flex-column">
                            <span class="fw-bold fs-4 js-hora"
                                style="letter-spacing:-1px;font-family:'Inter',sans-serif;"></span>
                            <span class="badge mt-1 js-badge"
                                style="align-self:flex-start;padding:4px 8px;border-radius:6px;"></span>
                        </div>
                        <div class="js-personas-wrapper"
                            style="background:rgba(255,255,255,.8);border:1px solid rgba(0,0,0,.05);padding:5px 12px;border-radius:20px;font-weight:bold;font-size:.9rem;">
                            <i class="bi bi-people-fill me-1"></i> <span class="js-personas"></span>
                        </div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1 text-truncate js-nombre" style="font-size:1.1rem;"></h5>
                        <p class="m-0 text-truncate js-detalles" style="opacity:.75;font-size:.85rem;"></p>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Modal Detalles de Reserva -->
    <div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
                <div class="modal-header border-bottom flex-column align-items-start"
                    style="background: linear-gradient(135deg, #fdfcfb, #e2d1c3); border-radius: 16px 16px 0 0; padding: 2rem;">
                    <button type="button" class="btn-close ms-auto position-absolute" style="top: 15px; right: 15px;"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <span class="badge bg-dark fw-bold px-3 py-2 mb-3 shadow-sm rounded-pill font-monospace"
                        id="m_folio">#FOLIO</span>
                    <h3 class="modal-title fw-bold" id="m_nombre"
                        style="font-family: 'Inter', sans-serif; color: var(--black-primary);">Nombre del Cliente</h3>
                    <p class="m-0 text-muted fw-bold" id="m_estado_texto"><i class="bi bi-circle-fill me-1"></i> Estado</p>
                </div>
                <div class="modal-body p-4 text-start">
                    <div class="row g-3">
                        <div class="col-6">
                            <p class="text-muted small mb-1 fw-bold">HORARIO</p>
                            <p class="fw-bold fs-5 shadow-sm rounded-3 p-2 bg-light text-center"
                                style="border: 1px solid var(--border-light);" id="m_hora">00:00</p>
                        </div>
                        <div class="col-6">
                            <p class="text-muted small mb-1 fw-bold">INVITADOS</p>
                            <p class="fw-bold fs-5 shadow-sm rounded-3 p-2 bg-light text-center"
                                style="border: 1px solid var(--border-light);" id="m_pax">0</p>
                        </div>
                        <div class="col-12 mt-4">
                            <p class="text-muted small mb-1 fw-bold">CONTACTO</p>
                            <div class="d-flex align-items-center mb-2 px-3 py-2 rounded-3"
                                style="background: rgba(0,0,0,0.02); border: 1px solid var(--border-light);">
                                <i class="bi bi-telephone-fill me-3" style="color: #d4af37;"></i>
                                <span class="fw-bold" id="m_telefono">...</span>
                            </div>
                            <div class="d-flex align-items-center px-3 py-2 rounded-3"
                                style="background: rgba(0,0,0,0.02); border: 1px solid var(--border-light);">
                                <i class="bi bi-envelope-fill me-3" style="color: #d4af37;"></i>
                                <span class="fw-bold" id="m_email">...</span>
                            </div>
                        </div>
                        <div class="col-12 mt-3" id="m_comentarios_box">
                            <p class="text-muted small mb-1 fw-bold">NOTAS/OCASIÓN</p>
                            <p class="fst-italic p-3 rounded-3" style="background: #fff8e1; border-left: 4px solid #d4af37;"
                                id="m_comentarios">...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0 flex-column">
                    <button type="button" id="btnCancelarReserva"
                        class="btn btn-outline-danger w-100 fw-bold py-2 rounded-3 mb-2 shadow-sm d-none"
                        style="border-width: 2px;">
                        <i class="bi bi-x-circle me-2"></i>CANCELAR RESERVACIÓN
                    </button>
                    <button type="button" class="btn text-white w-100 fw-bold py-2 rounded-3 shadow-sm"
                        style="background: #111;" data-bs-dismiss="modal">CERRAR DETALLES</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Configuración de Reservas -->
    <div class="modal fade" id="modalConfigReservas" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
                <div class="modal-header border-bottom flex-column align-items-start"
                    style="background: var(--off-white); border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                    <button type="button" class="btn-close ms-auto position-absolute" style="top: 15px; right: 15px;"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <h4 class="modal-title fw-bold m-0"
                        style="font-family: 'Inter', sans-serif; color: var(--black-primary);"><i
                            class="bi bi-gear-fill me-2" style="color: var(--accent-gold);"></i>Configuración de Reservas
                    </h4>
                </div>
                <div class="modal-body p-4 text-start">
                    <form id="formConfigReservas">
                        <div id="configWarning"
                            class="alert alert-warning border-0 rounded-3 mb-4 d-none align-items-center"
                            style="background: #fff8e1; color: #b78a00;">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <span class="fw-bold small">Tienes cambios sin guardar</span>
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold mb-2 text-uppercase text-muted"
                                style="letter-spacing: 1px; font-size: 0.7rem;">Duración promedio por mesa</label>
                            <select class="form-select border-0 shadow-sm rounded-3 p-3 fw-bold" id="conf_duracion"
                                style="background: var(--off-white); color: var(--black-primary);" required
                                onchange="marcarCambiosConfig()">
                                <option value="60">60 minutos</option>
                                <option value="90">90 minutos</option>
                                <option value="120">120 minutos</option>
                                <option value="150">150 minutos</option>
                                <option value="180">180 minutos</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold mb-2 text-uppercase text-muted"
                                style="letter-spacing: 1px; font-size: 0.7rem;">Tolerancia No-Show</label>
                            <div class="input-group">
                                <span class="input-group-text border-0" style="background: #eee;"><i
                                        class="bi bi-hourglass-split"></i></span>
                                <input type="number" id="conf_tolerancia"
                                    class="form-control border-0 shadow-sm p-3 fw-bold"
                                    style="background: var(--off-white); color: var(--black-primary);" min="5" max="60"
                                    onchange="marcarCambiosConfig()">
                                <span class="input-group-text border-0 fw-bold"
                                    style="background: #eee; font-size: 0.8rem;">MIN</span>
                            </div>
                            <small class="text-muted mt-2 d-block" style="font-size: 0.7rem;">Tiempo de espera antes de
                                marcar como No-Show y liberar mesa.</small>
                        </div>

                        <div class="mb-4">
                            <label class="small fw-bold mb-2 text-uppercase text-muted"
                                style="letter-spacing: 1px; font-size: 0.7rem;">Intervalos de agendamiento</label>
                            <select class="form-select border-0 shadow-sm rounded-3 p-3 fw-bold" id="conf_intervalo"
                                style="background: var(--off-white); color: var(--black-primary);" required
                                onchange="marcarCambiosConfig()">
                                <option value="15">Cada 15 minutos</option>
                                <option value="30">Cada 30 minutos</option>
                                <option value="45">Cada 45 minutos</option>
                                <option value="60">Cada 60 minutos</option>
                            </select>
                        </div>

                        <div class="mb-2 mt-4 pt-2 border-top">
                            <label class="small fw-bold mb-2 text-uppercase text-muted mt-3"
                                style="letter-spacing: 1px; font-size: 0.7rem;">Porcentaje de reservas</label>
                            <p class="small text-muted mb-3">Capacidad dedicada a reservas vs. clientes sin reserva
                                (walk-ins).</p>

                            <div class="d-flex align-items-center mb-2">
                                <input type="range" class="form-range" id="conf_porcentaje" min="0" max="100" step="1"
                                    value="{{ $cafeteria->porcentaje_reserva ?? 50 }}" style="flex: 1;"
                                    data-capacidad="{{ $cafeteria->capacidad_total ?? 100 }}"
                                    oninput="actualizarDashboardUI(this.value, this.dataset.capacidad); marcarCambiosConfig();">

                                <div class="ms-4 text-center"
                                    style="min-width: 150px; padding: 8px 12px; background: var(--off-white); border-radius: 10px; border: 1px solid #ddd;">
                                    <span id="porcentajeValueLabel" class="fw-bold fs-6 text-nowrap"
                                        style="color: var(--black-primary);">
                                        {{ $cafeteria->porcentaje_reserva ?? 50 }}%
                                        ({{ round(($cafeteria->capacidad_total ?? 100) * (($cafeteria->porcentaje_reserva ?? 50) / 100)) }}
                                        pers.)
                                    </span>
                                </div>
                            </div>

                            <div class="alert border-0 rounded-3 p-3 mt-3 d-flex align-items-center"
                                style="background: rgba(212, 175, 55, 0.08); border-left: 4px solid var(--accent-gold) !important;">
                                <i class="bi bi-info-circle-fill me-3 fs-5" style="color: var(--accent-gold);"></i>
                                <span class="small fw-bold text-dark" id="txtDinamicoConfigPorcentaje">Desliza para ajustar
                                    el cupo de reservaciones.</span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 p-4 pt-0 d-flex gap-2">
                    <button type="button" class="btn text-muted fw-bold py-2 rounded-3 shadow-sm px-4"
                        style="background: var(--off-white);" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnGuardarConfigReservas"
                        class="btn fw-bold py-2 px-4 rounded-3 shadow-sm flex-grow-1"
                        style="background: var(--accent-gold); color: var(--black-primary);"
                        onclick="guardarConfigReservas()">Guardar Cambios <i class="bi bi-check-circle ms-1"></i></button>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Modal: Límite de reservaciones alcanzado ───────────────────── --}}
    <div class="modal fade" id="modalLimiteAlcanzado" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                            style="width:72px;height:72px;background:rgba(198,40,40,0.1);">
                            <i class="bi bi-slash-circle-fill" style="font-size:2.2rem;color:#c62828;"></i>
                        </span>
                        <h4 class="fw-bold" style="color:var(--black-primary);">Límite de Reservaciones Alcanzado</h4>
                        <p class="text-muted mb-4" id="modal-limite-texto">
                            Has utilizado el 100% de las reservaciones incluidas en tu plan este mes.
                            Para continuar aceptando nuevas reservas, actualiza tu suscripción.
                        </p>
                    </div>
                    <a href="/admin/dashboard" class="btn fw-bold px-5 py-2 rounded-pill"
                        style="background:var(--accent-gold);color:var(--black-primary);">
                        <i class="bi bi-arrow-up-circle-fill me-2"></i>Actualizar Plan
                    </a>
                    <button type="button" class="btn btn-link text-muted d-block mx-auto mt-3 small"
                        data-bs-dismiss="modal">Cerrar y seguir revisando</button>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer_admin')

    <script>
        let currentDate = new Date();
        let modoVista = 'dia';

        // Array visible actual (el que muestra el grid y usa el modal)
        let reservasGlobales = [];

        // ------------------------------------------------------------------
        // Helpers de fecha/hora
        // ------------------------------------------------------------------
        function toIsoLocal(dateObj) {
            const off = dateObj.getTimezoneOffset();
            return new Date(dateObj.getTime() - off * 60000).toISOString().split('T')[0];
        }

        function formatDisplayDate(dateObj) {
            const todayStr = new Date().toDateString();
            if (dateObj.toDateString() === todayStr) return 'HOY';
            return dateObj.toLocaleDateString('es-ES',
                { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
            ).toUpperCase();
        }

        /** Construye un Date real combinando la fecha de la reserva con su hora HH:MM:SS */
        function buildDateTime(fechaStr, horaStr) {
            // 'fechaStr' = "2026-03-17", 'horaStr' = "14:30:00"
            return new Date(`${fechaStr}T${horaStr}`);
        }

        function calcularEstadoReserva(r) {
            return r.estado || 'pendiente';
        }

        function getStatusStyling(estado) {
            switch (estado) {
                case 'en_curso': return { bg: '#e8f5e9', border: '#81c784', text: '#2e7d32', shadow: '0 5px 15px rgba(46,125,50,0.1)', badgeBg: '#2e7d32', badgeText: '#fff', label: 'En Curso' };
                case 'pendiente': return { bg: '#ffffff', border: '#e6e6e6', text: '#111', shadow: '0 4px 10px rgba(0,0,0,0.03)', badgeBg: '#f0f0f0', badgeText: '#555', label: 'Pendiente' };
                case 'finalizada': return { bg: '#f9f9f9', border: '#e0e0e0', text: '#9e9e9e', shadow: 'none', badgeBg: '#e0e0e0', badgeText: '#757575', label: 'Finalizada' };
                case 'no_show': return { bg: '#fce4e4', border: '#f5c6c6', text: '#c62828', shadow: 'none', badgeBg: '#c62828', badgeText: '#fff', label: 'No Show' };
                case 'cancelada': return { bg: '#ffebee', border: '#ffcdd2', text: '#d32f2f', shadow: 'none', badgeBg: '#d32f2f', badgeText: '#fff', label: 'Cancelada' };
                default: return { bg: '#ffffff', border: '#e6e6e6', text: '#111', shadow: '0 4px 10px rgba(0,0,0,0.03)', badgeBg: '#f0f0f0', badgeText: '#555', label: 'Pendiente' };
            }
        }

        // ------------------------------------------------------------------
        // Modal de detalles
        // ------------------------------------------------------------------
        function abrirDetalles(idReserva) {
            const r = reservasGlobales.find(x => x.id === idReserva);
            if (!r) return;

            const estilos = getStatusStyling(calcularEstadoReserva(r));

            document.getElementById('m_folio').textContent = r.folio || '#N/A';
            document.getElementById('m_nombre').textContent = r.nombre_cliente;
            document.getElementById('m_estado_texto').innerHTML =
                `<i class="bi bi-circle-fill me-1" style="color:${estilos.badgeBg};"></i> ${estilos.label}`;
            document.getElementById('m_hora').textContent = r.hora_inicio.substring(0, 5) + ' hrs';
            document.getElementById('m_pax').textContent = r.numero_personas + ' Personas';
            document.getElementById('m_telefono').textContent = r.telefono;
            document.getElementById('m_email').textContent = r.email;

            let notas = [];
            if (r.zona && r.zona.nombre_zona) notas.push('Zona: ' + r.zona.nombre_zona);
            if (r.ocasion && r.ocasion.nombre) notas.push('Ocasión: ' + r.ocasion.nombre);
            if (r.comentarios) notas.push(r.comentarios);

            if (notas.length > 0) {
                document.getElementById('m_comentarios').textContent = notas.join(' | ');
                document.getElementById('m_comentarios_box').style.display = 'block';
            } else {
                document.getElementById('m_comentarios_box').style.display = 'none';
            }

            // Control de botón cancelar
            const btnCancel = document.getElementById('btnCancelarReserva');
            if (r.estado === 'pendiente') {
                btnCancel.classList.remove('d-none');
                btnCancel.onclick = () => confirmarCancelacion(r.id);
            } else {
                btnCancel.classList.add('d-none');
            }

            new bootstrap.Modal(document.getElementById('modalReserva')).show();
        }

        async function confirmarCancelacion(id) {
            const { isConfirmed } = await Swal.fire({
                title: '¿Confirmar Cancelación?',
                text: "Se notificará al cliente por correo electrónico y la mesa será liberada.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#212529',
                confirmButtonText: 'Sí, cancelar ahora',
                cancelButtonText: 'No, mantener'
            });

            if (!isConfirmed) return;

            const btn = document.getElementById('btnCancelarReserva');
            const originalContent = btn.innerHTML;

            // ACTIVAR SPINNER
            btn.disabled = true;
            btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> PROCESANDO...`;

            try {
                // LLAMADA A LA API UNIFICADA
                await MetraAPI.patch(`/gerente/reservaciones/${id}/cancelar`);

                Swal.fire({
                    title: '¡Cancelada!',
                    text: 'La reservación ha sido cancelada y el cliente notificado.',
                    icon: 'success',
                    timer: 2500,
                    showConfirmButton: false
                });

                // Cerrar modal y refrescar grid
                bootstrap.Modal.getInstance(document.getElementById('modalReserva')).hide();
                if (modoVista === 'dia') cargarDia(true);
                else cargarProximas(true);

            } catch (e) {
                Swal.fire('Error', e.data?.message || 'No se pudo completar la cancelación.', 'error');
                btn.disabled = false;
                btn.innerHTML = originalContent;
            }
        }

        // ------------------------------------------------------------------
        // Render de tarjetas
        // ------------------------------------------------------------------
        function renderizarTarjetas(reservaciones) {
            const grid = document.getElementById('reservaciones-grid');
            reservasGlobales = reservaciones;

            grid.innerHTML = '';

            let reservasMostradas = 0;
            const template = document.getElementById('reserva-template');
            const fragment = document.createDocumentFragment();

            reservaciones.forEach(r => {
                const estado = calcularEstadoReserva(r);
                // En modo futuras, excluir las completamente finalizadas
                if (modoVista === 'futuras' && estado === 'finalizada') return;

                reservasMostradas++;

                const estilos = getStatusStyling(estado);
                const opacidadBaja = estado === 'finalizada' ? '0.75' : '1';
                const rsrvDate = new Date(r.fecha + 'T00:00:00');
                const datePrefix = modoVista === 'futuras'
                    ? rsrvDate.toLocaleDateString('es-ES', { month: 'short', day: 'numeric' }).toUpperCase() + ' - '
                    : '';

                const clone = template.content.cloneNode(true);
                const card = clone.querySelector('.js-card');

                card.style.background = estilos.bg;
                card.style.border = `1px solid ${estilos.border}`;
                card.style.boxShadow = estilos.shadow;
                card.style.opacity = opacidadBaja;
                card.addEventListener('click', () => abrirDetalles(r.id));

                const horaElem = clone.querySelector('.js-hora');
                horaElem.textContent = r.hora_inicio.substring(0, 5);
                horaElem.style.color = estilos.text;

                // Integración Fase 5: Evidencia de Subconsulta DB para verificar en tiempo real si el cliente ya fue asignado a mesa física
                if (r.mesa_asignada_fisicamente > 0) {
                    horaElem.innerHTML += ' <i class="bi bi-person-check-fill ms-2 text-success shadow-sm" style="font-size: 1.1rem; padding: 2px 5px; border-radius: 4px; background: rgba(0,255,0,0.1);" title="¡Cliente en Mesa Física!"></i>';
                }

                const badge = clone.querySelector('.js-badge');
                badge.textContent = datePrefix + estilos.label;
                badge.style.background = estilos.badgeBg;
                badge.style.color = estilos.badgeText;

                const pw = clone.querySelector('.js-personas-wrapper');
                pw.style.color = estilos.text;
                clone.querySelector('.js-personas').textContent = r.numero_personas;

                const nombreElem = clone.querySelector('.js-nombre');
                nombreElem.textContent = r.nombre_cliente;
                nombreElem.title = r.nombre_cliente;
                nombreElem.style.color = estilos.text;

                const detallesElem = clone.querySelector('.js-detalles');
                detallesElem.style.color = estilos.text;
                let detallesHtml = `<i class="bi bi-hash me-1"></i> ${escapeHTML(r.folio || 'N/A')}`;
                if (r.zona && r.zona.nombre_zona) {
                    detallesHtml += ` | <i class="bi bi-geo-alt-fill mx-1"></i> ${escapeHTML(r.zona.nombre_zona)}`;
                }
                detallesElem.innerHTML = detallesHtml;

                fragment.appendChild(clone);
            });

            if (reservasMostradas === 0) {
                grid.innerHTML = `
                                    <div class="col-12 text-center py-5 text-muted">
                                        <i class="bi bi-calendar-check fs-1 d-block mb-2" style="opacity:.3;"></i>
                                        <p class="fw-bold">No hay reservas activas en esta vista.</p>
                                    </div>`;
            } else {
                grid.appendChild(fragment);
            }
        }

        // ------------------------------------------------------------------
        // Calculo de metricas: Aforo y En Curso dependen de la vista
        // Proxima Reserva sigue siendo global para el monitor tactico
        // ------------------------------------------------------------------
        // Métricas: calculadas sobre las reservas visibles en pantalla
        // ------------------------------------------------------------------
        function actualizarMetricas(reservasVisibles = []) {
            const now = new Date();
            const todayIso = toIsoLocal(now);

            // 1. Aforo Esperado — pendientes visibles
            const totalAforo = reservasVisibles
                .filter(r => calcularEstadoReserva(r) === 'pendiente')
                .reduce((sum, r) => sum + r.numero_personas, 0);
            document.getElementById('statTotalPersonas').textContent = totalAforo;

            // 2. En Curso — visibles
            const totalEnCurso = reservasVisibles
                .filter(r => calcularEstadoReserva(r) === 'en_curso')
                .reduce((sum, r) => sum + r.numero_personas, 0);
            document.getElementById('statEnCurso').textContent = totalEnCurso;

            // 3. Próxima Reserva — la siguiente pendiente con hora de fin > ahora
            const pendientes = reservasVisibles
                .filter(r => {
                    if (calcularEstadoReserva(r) !== 'pendiente') return false;
                    const end = r.hora_fin
                        ? buildDateTime(r.fecha, r.hora_fin)
                        : new Date(buildDateTime(r.fecha, r.hora_inicio).getTime() + 2 * 60 * 60 * 1000);
                    return end > now;
                })
                .sort((a, b) => buildDateTime(a.fecha, a.hora_inicio) - buildDateTime(b.fecha, b.hora_inicio));

            if (pendientes.length === 0) {
                document.getElementById('statProxima').textContent = 'Sin reservas futuras';
            } else {
                const prox = pendientes[0];
                const proxDate = new Date(prox.fecha + 'T00:00:00');
                const esHoy = toIsoLocal(proxDate) === todayIso;
                const nombre = (prox.nombre_cliente || '').split(' ')[0];

                if (esHoy) {
                    const label = calcularEstadoReserva(prox) === 'en_curso' ? 'En curso' : 'Siguiente';
                    document.getElementById('statProxima').textContent =
                        `${label}: ${nombre} a las ${prox.hora_inicio.substring(0, 5)}`;
                } else {
                    const fechaLabel = proxDate.toLocaleDateString('es-ES',
                        { weekday: 'short', day: 'numeric', month: 'short' }).toUpperCase();
                    document.getElementById('statProxima').textContent =
                        `${fechaLabel} - ${nombre} ${prox.hora_inicio.substring(0, 5)}`;
                }
            }
        }

        // ------------------------------------------------------------------
        // Fetch por rango de fechas — cada vista pide exactamente lo que necesita
        // ------------------------------------------------------------------
        function mostrarSpinner() {
            document.getElementById('reservaciones-grid').innerHTML =
                '<div class="col-12 text-center py-5"><div class="spinner-border text-muted"></div>' +
                '<p class="mt-2 text-muted fw-bold small">SINCRONIZANDO AGENDA...</p></div>';
            document.getElementById('statTotalPersonas').textContent = '...';
            document.getElementById('statProxima').textContent = '...';
            document.getElementById('statEnCurso').textContent = '...';
        }

        function mostrarError() {
            document.getElementById('reservaciones-grid').innerHTML =
                '<div class="col-12 text-center py-5 text-danger">' +
                '<i class="bi bi-shield-exclamation fs-1"></i>' +
                '<p class="fw-bold mt-2">Error de conexion al obtener la agenda.</p></div>';
        }

        async function fetchReservaciones(desde, hasta, silencioso = false) {
            if (!silencioso) mostrarSpinner();
            try {
                const url = `/gerente/reservaciones?desde=${desde}&hasta=${hasta}&t=${Date.now()}`;
                const res = await MetraAPI.get(url);

                const data = res.data || [];
                actualizarMetricas(data);
                renderizarTarjetas(data);

            } catch (e) {
                console.error(e);
                if (!silencioso) mostrarError();
            }
        }

        /** Vista por Día: fetch solo del día seleccionado */
        function cargarDia(silencioso = false) {
            const iso = toIsoLocal(currentDate);
            fetchReservaciones(iso, iso, silencioso);
        }

        /** Vista Próximas: fetch desde hoy + 30 días (default del backend) */
        function cargarProximas(silencioso = false) {
            const hoy = toIsoLocal(new Date());
            fetchReservaciones(hoy, '', silencioso); // sin hasta → backend usa hoy+30d
        }

        // ------------------------------------------------------------------
        // Configuracion Modal Logica
        // ------------------------------------------------------------------
        let cafeConfigId = null;
        let configModificada = false;

        async function abrirModalConfigReservas() {
            try {
                const btn = document.querySelector('button[onclick="abrirModalConfigReservas()"]');
                const prev = btn.innerHTML;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                btn.disabled = true;

                try {
                    const res = await MetraAPI.get('/gerente/mi-cafeteria');
                    btn.innerHTML = prev;
                    btn.disabled = false;

                    const cafe = res.data || res;
                    cafeConfigId = cafe.id;

                    document.getElementById('conf_duracion').value = cafe.duracion_reserva_min || 90;
                    document.getElementById('conf_intervalo').value = cafe.intervalo_reserva_min || 30;
                    document.getElementById('conf_tolerancia').value = cafe.tolerancia_reserva_min || 15;

                    // Localiza dónde estabas inyectando el valor inicial (document.getElementById('conf_porcentaje').value = pct;)
                    // Asigna y selecciona el slider
                    const pct = cafe.porcentaje_reservas !== null && cafe.porcentaje_reservas !== undefined ? cafe.porcentaje_reservas : 50;
                    const sliderEl = document.getElementById('conf_porcentaje');
                    sliderEl.value = pct;

                    // Extraer la capacidad real sumada desde el backend de todas las mesas activas
                    const capacidadReal = cafe.capacidad_total || 0;

                    // Inyectar al slider local para que UI dependa siempre de éste
                    sliderEl.setAttribute('data-capacidad', capacidadReal);

                    // Leer la capacidad directamente del DOM para actualizar el badge de ocupación
                    actualizarDashboardUI(pct, sliderEl.getAttribute('data-capacidad'));

                    configModificada = false;
                    document.getElementById('configWarning').classList.add('d-none');
                    document.getElementById('configWarning').classList.remove('d-flex');

                    new bootstrap.Modal(document.getElementById('modalConfigReservas')).show();
                } catch (e) {
                    btn.innerHTML = prev;
                    btn.disabled = false;
                    console.error('Error al cargar config:', e);
                }
            } catch (e) { console.error('Error general:', e); }
        }

        function actualizarDashboardUI(porcentaje, capacidadIgnorada) {
            // Regla crítica: Leer SIEMPRE del atributo del dom para priorizar la dinamicidad del Admin
            const sliderEl = document.getElementById('conf_porcentaje');
            let capacidad = parseInt(sliderEl.getAttribute('data-capacidad')) || 0;

            // Cálculo de ocupación
            if (capacidad > 0) {
                const personas = Math.round((capacidad * porcentaje) / 100);
                document.getElementById('porcentajeValueLabel').innerText = `${porcentaje}% (${personas} pers.)`;
            } else {
                document.getElementById('porcentajeValueLabel').innerText = porcentaje + '%';
            }

            // Lógica original dinámica
            const msj = document.getElementById('txtDinamicoConfigPorcentaje');
            if (msj) {
                if (porcentaje <= 30) {
                    msj.innerText = "Más espacio para clientes sin reserva";
                } else if (porcentaje <= 70) {
                    msj.innerText = "Balance entre reservas y walk-ins";
                } else {
                    msj.innerText = "Alta prioridad a reservas";
                }
            }
        }

        function marcarCambiosConfig() {
            if (!configModificada) {
                configModificada = true;
                const warn = document.getElementById('configWarning');
                warn.classList.remove('d-none');
                warn.classList.add('d-flex');
            }
        }

        async function guardarConfigReservas() {
            try {
                const btn = document.getElementById('btnGuardarConfigReservas');
                const prev = btn.innerHTML;

                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';
                btn.disabled = true;

                const payload = {
                    duracion_reserva_min: document.getElementById('conf_duracion').value,
                    intervalo_reserva_min: document.getElementById('conf_intervalo').value,
                    porcentaje_reservas: document.getElementById('conf_porcentaje').value,
                    tolerancia_reserva_min: document.getElementById('conf_tolerancia').value
                };

                try {
                    await MetraAPI.put('/gerente/mi-cafeteria', payload);

                    btn.innerHTML = prev;
                    btn.disabled = false;

                    bootstrap.Modal.getInstance(document.getElementById('modalConfigReservas')).hide();

                    Swal.fire({
                        title: '¡Guardado!',
                        text: 'Configuración de reservas actualizada correctamente',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } catch (e) {
                    btn.innerHTML = prev;
                    btn.disabled = false;
                    const fallbackMsg = e.data?.message || Object.values(e.data?.errors || {}).join(' | ') || e.message || 'Error al guardar';
                    Swal.fire('Error', fallbackMsg, 'error');
                }
            } catch (e) {
                Swal.fire('Error', e.message, 'error');
            }
        }

        // ------------------------------------------------------------------
        // Cambio de modo (botones Vista por Dia / Próximas)
        // ------------------------------------------------------------------
        function cambiarModo(modo) {
            modoVista = modo;
            if (modo === 'dia') {
                document.getElementById('btn-modo-dia').classList.replace('btn-outline-dark', 'btn-dark');
                document.getElementById('btn-modo-futuras').classList.replace('btn-dark', 'btn-outline-dark');
                document.getElementById('panel-selector-dia').style.display = 'flex';
                cargarDia();
            } else {
                document.getElementById('btn-modo-futuras').classList.replace('btn-outline-dark', 'btn-dark');
                document.getElementById('btn-modo-dia').classList.replace('btn-dark', 'btn-outline-dark');
                document.getElementById('panel-selector-dia').style.display = 'none';
                cargarProximas();
            }
        }

        // ------------------------------------------------------------------
        // Selector de dia
        // ------------------------------------------------------------------
        function updateDateUI() {
            document.getElementById('dateDisplay').textContent = formatDisplayDate(currentDate);
            document.getElementById('inputDate').value = toIsoLocal(currentDate);
            cargarDia(); // fetch del día seleccionado
        }

        // ------------------------------------------------------------------
        // Bootstrap
        // ------------------------------------------------------------------
        document.addEventListener('DOMContentLoaded', () => {
            // Mostrar fecha inicial en el selector
            document.getElementById('dateDisplay').textContent = formatDisplayDate(currentDate);
            document.getElementById('inputDate').value = toIsoLocal(currentDate);

            // Carga inicial (modo dia por defecto)
            cargarDia();
            cargarBannerUsoReservas();

            document.querySelectorAll('.btn-day-nav').forEach(btn => {
                btn.addEventListener('click', () => {
                    currentDate.setDate(currentDate.getDate() + parseInt(btn.getAttribute('data-offset')));
                    updateDateUI();
                });
            });

            document.getElementById('inputDate').addEventListener('change', e => {
                if (e.target.value) {
                    currentDate = new Date(e.target.value + 'T00:00:00');
                    updateDateUI();
                }
            });

            // Re-fetch silencioso cada 60 s - usa la vista activa
            setInterval(() => {
                if (modoVista === 'dia') cargarDia(true);
                else cargarProximas(true);
            }, 60000);
        });

        // ── Banner de uso de reservaciones ──────────────────────────────────
        async function cargarBannerUsoReservas() {
            try {
                const res = await MetraAPI.get('/gerente/analytics/stats');
                const uso = res?.data?.suscripcion_uso;
                if (!uso) return;

                const { plan_nombre, reservas_usadas, reservas_limite, porcentaje_uso } = uso;
                const disponibles = Math.max(0, reservas_limite - reservas_usadas);
                const banner = document.getElementById('banner-uso-reservas');

                // Colores según porcentaje
                const isLleno   = porcentaje_uso >= 100;
                const isWarning = porcentaje_uso >= 80 && !isLleno;

                const bgColor     = isLleno ? 'rgba(198,40,40,0.07)' : isWarning ? 'rgba(212,175,55,0.1)' : 'rgba(56,44,38,0.04)';
                const borderColor = isLleno ? '#c62828' : isWarning ? 'var(--accent-gold)' : 'var(--border-light)';
                const barColor    = isLleno ? '#c62828' : isWarning ? '#d4af37' : '#2e7d32';
                const textColor   = isLleno ? '#c62828' : isWarning ? '#9a6800' : 'var(--text-muted)';

                let mensajeBanner = '';
                if (isLleno) {
                    mensajeBanner = `<span class="fw-bold" style="color:#c62828;">Límite alcanzado.</span> No se pueden crear nuevas reservaciones este mes. <a href="/admin/dashboard" class="fw-bold" style="color:#c62828;">Actualiza tu plan →</a>`;
                } else if (isWarning) {
                    mensajeBanner = `<span class="fw-bold" style="color:#9a6800;">¡Atención!</span> Te quedan solo <strong>${disponibles}</strong> reservaciones disponibles este mes. <a href="/admin/dashboard" class="fw-bold" style="color:#9a6800;">Actualizar plan</a>`;
                } else {
                    mensajeBanner = `Reservaciones disponibles este mes: <strong>${disponibles}</strong> de ${reservas_limite}`;
                }

                banner.innerHTML = `
                    <div class="d-flex align-items-center gap-3 p-3 rounded-4" style="background:${bgColor};border:1px solid ${borderColor};">
                        <div class="flex-shrink-0 d-none d-md-block" style="width:120px;">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="fw-bold" style="color:${textColor};font-size:0.7rem;text-transform:uppercase;letter-spacing:1px;">Plan ${escapeHTML(plan_nombre)}</small>
                                <small class="fw-bold" style="color:${textColor};font-size:0.7rem;">${reservas_usadas}/${reservas_limite}</small>
                            </div>
                            <div class="progress" style="height:6px;border-radius:10px;">
                                <div class="progress-bar" role="progressbar"
                                    style="width:${Math.min(porcentaje_uso,100)}%;background:${barColor};border-radius:10px;"
                                    aria-valuenow="${porcentaje_uso}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <p class="m-0 small">${mensajeBanner}</p>
                        ${isLleno ? '' : ''}
                    </div>
                `;

                // Si limite al 100%, mostrar modal bloqueante (una sola vez por carga)
                if (isLleno && !sessionStorage.getItem('limiteModalMostrado')) {
                    sessionStorage.setItem('limiteModalMostrado', '1');
                    document.getElementById('modal-limite-texto').innerHTML =
                        `Has utilizado las <strong>${reservas_limite}</strong> reservaciones incluidas en tu plan <strong>${escapeHTML(plan_nombre)}</strong> este mes.
                        Para continuar aceptando nuevas reservas, actualiza tu suscripción.`;
                    new bootstrap.Modal(document.getElementById('modalLimiteAlcanzado')).show();
                }

            } catch(e) {
                console.warn('No se pudo cargar el banner de uso:', e);
            }
        }
    </script>
@endsection