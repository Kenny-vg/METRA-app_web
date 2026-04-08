@extends('layouts.mobile')

@section('title', 'Reservas')

@section('content')
    <div class="staff-header mb-4">
        <h2 class="staff-title mb-2 text-uppercase">Reservas</h2>
        <p class="text-muted small">Gestión de afluencia</p>
    </div>

    <!-- Filters & Tabs -->
    <div class="reservas-controls mb-4">
        <div class="input-group mb-3 shadow-sm rounded-pill overflow-hidden border">
            <span class="input-group-text border-0 bg-white pe-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" id="search-reserva" class="form-control border-0 py-2 ps-2"
                placeholder="Buscar reserva o folio..." style="font-size: 0.95rem;">
        </div>

        <div class="d-flex bg-white p-1 rounded-pill border shadow-sm">
            <button class="btn flex-grow-1 rounded-pill fw-bold btn-tab active" data-tab="hoy">HOY</button>
            <button class="btn flex-grow-1 rounded-pill fw-bold btn-tab" data-tab="proximas">PRÓXIMAS</button>
        </div>
    </div>

    <div id="reservas-list" class="d-flex flex-column gap-3 mt-3 pb-5 px-1">
        <!-- Loader placeholder -->
        <div class="text-center py-5 text-muted">
            <div class="spinner-border text-gold mb-3" role="status"></div>
            <p class="small fw-bold">Cargando reservaciones...</p>
        </div>
    </div>

    <!-- Modal Detalle/Accion Reserva (Revamp) -->
    <div class="modal fade" id="modalDetalleReserva" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered px-3">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <div class="modal-header border-0 bg-coffee text-white p-4 pb-3 d-flex justify-content-between align-items-center"
                    style="background: var(--app-coffee);">
                    <div>
                        <h5 class="fw-bold m-0" id="det-nombre">Nombre Cliente</h5>
                        <small class="opacity-75" id="det-folio">RSV-XXXXXX</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4 pt-4">
                    <div class="text-center mb-4">
                        <span class="staff-badge badge-pending fs-6" id="det-estado">PENDIENTE</span>
                    </div>

                    <!-- Info Grid -->
                    <div class="row g-3 mb-4 pb-3 border-bottom">
                        <div class="col-6 text-center border-end">
                            <small class="text-muted d-block mb-1"><i class="bi bi-calendar3 me-1"></i> FECHA</small>
                            <span class="fw-bold d-block" id="det-fecha">--/--/--</span>
                        </div>
                        <div class="col-6 text-center">
                            <small class="text-muted d-block mb-1"><i class="bi bi-clock me-1"></i> HORA</small>
                            <span class="fw-bold d-block" id="det-hora">--:--</span>
                        </div>
                        <div class="col-6 text-center border-end border-top pt-3">
                            <small class="text-muted d-block mb-1"><i class="bi bi-people me-1"></i> PERSONAS</small>
                            <span class="fw-bold d-block" id="det-personas">--</span>
                        </div>
                        <div class="col-6 text-center border-top pt-3">
                            <small class="text-muted d-block mb-1"><i class="bi bi-geo-alt me-1"></i> ZONA</small>
                            <span class="fw-bold d-block text-gold" id="det-zona">--</span>
                        </div>
                    </div>

                    <!-- Secondary Info -->
                    <div class="secondary-info mb-4">
                        <div class="mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">Ocasión:</small>
                            <p class="m-0 small fw-bold" id="det-ocasion">Ninguna</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">Notas:</small>
                            <p class="m-0 small italic" id="det-notas">Sin notas</p>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">Promoción:</small>
                            <p class="m-0 small text-gold fw-bold" id="det-promo">Sin promoción</p>
                        </div>
                    </div>

                    <!-- Action Logic -->
                    <div id="checkin-logic-container">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2">ACCIÓN A REALIZAR</label>
                            <select id="action-select" class="form-select rounded-pill border py-2 fw-bold">
                                <option value="checkin" selected>Llegó y asignar mesa</option>
                                <option value="cancelar">Cancelar reservación</option>
                            </select>
                        </div>

                        <!-- Table Selection (Visible when action is checkin) -->
                        <div id="table-selection-box" class="mb-4">
                            <label class="small fw-bold text-gold mb-2 d-block">SELECCIONAR MESA(S)</label>
                            <div id="mesas-available-grid" class="d-flex flex-wrap gap-2">
                                <!-- Tables loaded via JS -->
                            </div>
                            <div id="cap-warning" class="mt-2 d-none">
                                <div class="alert alert-warning py-2 mb-0" style="font-size: 0.75rem;">
                                    <i class="bi bi-exclamation-triangle-fill"></i> Capacidad seleccionada (<span
                                        id="current-cap">0</span>) insuficiente para <span id="required-cap">0</span>
                                    personas.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="d-grid mt-4">
                        <button id="btn-confirm-action" class="btn btn-dark rounded-pill py-3 fw-bold text-uppercase"
                            style="background: var(--app-coffee); letter-spacing: 1px;">
                            Confirmar
                        </button>
                        <button type="button" class="btn btn-link text-muted text-decoration-none mt-2 small fw-bold"
                            data-bs-dismiss="modal">
                            CANCELAR
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-tab {
            border-color: transparent;
            color: var(--app-text-muted);
            font-size: 0.8rem;
            padding: 8px 10px;
        }

        .btn-tab.active {
            background-color: var(--app-coffee) !important;
            color: white !important;
        }

        .reserva-card .reserva-icon {
            width: 44px;
            height: 44px;
            background: #f8f8f8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--app-text-muted);
        }

        .mesa-badge-item {
            flex: 1 0 45%;
            border: 1px solid var(--app-border);
            border-radius: 10px;
            padding: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .mesa-badge-item.selected {
            background: var(--app-coffee);
            color: white;
            border-color: var(--app-coffee);
        }

        .mesa-badge-item .cap {
            display: block;
            font-size: 0.65rem;
            opacity: 0.7;
        }
    </style>
@endsection

@push('scripts')
    <script>
        let allReservas = [];
        let allMesas = [];
        let currentTab = 'hoy';
        let currentReservaId = null;
        let selectedMesas = [];

        async function fetchData() {
            try {
                const [resR, resM] = await Promise.all([
                    MetraAPI.get('/staff/reservaciones'),
                    MetraAPI.get('/staff/mesas-estado')
                ]);
                if (resR.success) allReservas = resR.data;
                if (resM.success) allMesas = resM.data;
                renderReservas();
            } catch (e) {
                console.error('Error fetching data:', e);
            }
        }

        function renderReservas() {
            const query = document.getElementById('search-reserva').value.toLowerCase();
            const container = document.getElementById('reservas-list');

            const off = new Date().getTimezoneOffset();
            const hoyIso = new Date(Date.now() - off * 60000).toISOString().split('T')[0];

            let filtered = allReservas.filter(r => {
                const matchQuery = r.nombre_cliente.toLowerCase().includes(query) || r.folio.toLowerCase().includes(query);
                const isHoy = r.fecha === hoyIso;
                const matchTab = currentTab === 'hoy' ? isHoy : !isHoy;
                return matchQuery && matchTab;
            });

            filtered.sort((a, b) => new Date(`${a.fecha}T${a.hora_inicio}`) - new Date(`${b.fecha}T${b.hora_inicio}`));

            if (filtered.length === 0) {
                container.innerHTML = '<div class="text-center py-5 text-muted">No hay reservaciones para mostrar</div>';
                return;
            }

            container.innerHTML = filtered.map(r => {
                const statusClass = r.estado === 'pendiente' ? 'pending' : (r.estado === 'en_curso' || r.estado === 'confirmada' ? 'available' : 'occupied');
                const badgeClass = r.estado === 'pendiente' ? 'badge-pending' : (r.estado === 'no_show' ? 'badge-occupied' : 'badge-available');
                return `
                <div class="staff-card status-border active-click ${statusClass} reserva-card" onclick="verDetalleReserva(${r.id})">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <div class="reserva-icon me-3" style="width: 36px; height: 36px;">
                                <i class="bi bi-person-fill fs-6"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold m-0" style="font-size: 0.9rem;">${r.nombre_cliente}</h6>
                                <small class="text-muted d-block" style="font-size: 0.7rem;">${r.folio}</small>
                            </div>
                        </div>

                        <span class="staff-badge ${badgeClass}" style="font-size: 0.6rem;">
                            ${r.estado.replace('_', ' ').toUpperCase()}
                        </span>
                    </div>

                    <!-- INFO SIN ROW -->
                    <div class="reserva-info">
                        <div><i class="bi bi-calendar3 me-2 text-gold"></i>${r.fecha}</div>
                        <div><i class="bi bi-clock me-2 text-gold"></i>${r.hora_inicio.substring(0, 5)} - ${r.hora_fin.substring(0, 5)}</div>
                        <div><i class="bi bi-people me-2 text-gold"></i>${r.numero_personas} pers.</div>
                        <div class="text-truncate"><i class="bi bi-geo-alt me-2 text-gold"></i>${r.zona.nombre}</div>
                    </div>

                </div>
                `;
            }).join('');
        }

        function verDetalleReserva(id) {
            const r = allReservas.find(x => x.id === id);
            if (!r) return;

            currentReservaId = id;
            selectedMesas = [];

            document.getElementById('det-folio').textContent = r.folio;
            document.getElementById('det-nombre').textContent = r.nombre_cliente;
            document.getElementById('det-estado').textContent = r.estado.replace('_', ' ').toUpperCase();
            document.getElementById('det-estado').className = 'staff-badge ' + (r.estado === 'pendiente' ? 'badge-pending' : (r.estado === 'no_show' ? 'badge-occupied' : 'badge-available'));

            document.getElementById('det-fecha').textContent = r.fecha;
            document.getElementById('det-hora').textContent = `${r.hora_inicio.substring(0, 5)} - ${r.hora_fin.substring(0, 5)}`;
            document.getElementById('det-personas').textContent = r.numero_personas;
            document.getElementById('det-zona').textContent = r.zona.nombre;

            document.getElementById('det-ocasion').textContent = (r.ocasion && r.ocasion.nombre) ? r.ocasion.nombre : 'Ninguna';
            document.getElementById('det-notas').textContent = r.comentarios || 'Sin notas';
            document.getElementById('det-promo').textContent = (r.promocion && r.promocion.nombre) ? r.promocion.nombre : 'Sin promoción';

            // Reset UI actions
            const logicBox = document.getElementById('checkin-logic-container');
            const confirmBtn = document.getElementById('btn-confirm-action');

            if (r.estado === 'pendiente') {
                logicBox.classList.remove('d-none');
                confirmBtn.classList.remove('d-none');
                renderAvailableTables(r.zona.nombre, r.numero_personas);
            } else {
                logicBox.classList.add('d-none');
                confirmBtn.classList.add('d-none');
            }

            new bootstrap.Modal(document.getElementById('modalDetalleReserva')).show();
        }

        function renderAvailableTables(zonaName, requiredPeople) {
            const container = document.getElementById('mesas-available-grid');
            const availableInZone = allMesas.filter(m => m.zona_nombre === zonaName && m.estado === 'disponible');

            document.getElementById('required-cap').textContent = requiredPeople;

            if (availableInZone.length === 0) {
                container.innerHTML = '<p class="text-danger small italic py-2">No hay mesas disponibles en esta zona</p>';
                return;
            }

            container.innerHTML = availableInZone.map(m => `
                <div class="mesa-badge-item" data-id="${m.id}" data-cap="${m.capacidad}">
                    <strong>${m.nombre}</strong>
                    <span class="cap">CAP: ${m.capacidad}</span>
                </div>
            `).join('');

            document.querySelectorAll('.mesa-badge-item').forEach(item => {
                item.addEventListener('click', function () {
                    const id = parseInt(this.dataset.id);
                    if (selectedMesas.includes(id)) {
                        selectedMesas = selectedMesas.filter(x => x !== id);
                        this.classList.remove('selected');
                    } else {
                        selectedMesas.push(id);
                        this.classList.add('selected');
                    }
                    validateCapacity(requiredPeople);
                });
            });

            validateCapacity(requiredPeople);
        }

        function validateCapacity(required) {
            let total = 0;
            document.querySelectorAll('.mesa-badge-item.selected').forEach(item => {
                total += parseInt(item.dataset.cap);
            });

            document.getElementById('current-cap').textContent = total;
            const warning = document.getElementById('cap-warning');
            if (total < required && selectedMesas.length > 0) {
                warning.classList.remove('d-none');
            } else {
                warning.classList.add('d-none');
            }
        }

        document.getElementById('action-select').addEventListener('change', function () {
            const isCheckin = this.value === 'checkin';
            document.getElementById('table-selection-box').style.display = isCheckin ? 'block' : 'none';
        });

        document.getElementById('btn-confirm-action').addEventListener('click', async () => {
            const action = document.getElementById('action-select').value;
            const btn = document.getElementById('btn-confirm-action');
            const originalText = btn.innerHTML;

            if (action === 'checkin') {
                if (selectedMesas.length === 0) {
                    Swal.fire('Atención', 'Selecciona al menos una mesa.', 'warning');
                    return;
                }

                try {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

                    const r = allReservas.find(x => x.id === currentReservaId);
                    const data = {
                        reservacion_id: currentReservaId,
                        mesa_ids: selectedMesas,
                        numero_personas: r.numero_personas,
                        zona_id: r.zona_id
                    };

                    await MetraAPI.post('/staff/ocupaciones', data);
                    endAction('Check-in realizado con éxito');
                } catch (e) {
                    Swal.fire('Error', e.message, 'error');
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            } else {
                // Cancelar
                const confirm = await Swal.fire({
                    title: '¿Confirmar cancelación?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33'
                });

                if (confirm.isConfirmed) {
                    try {
                        btn.disabled = true;
                        await MetraAPI.patch(`/staff/reservaciones/${currentReservaId}/cancelar`);
                        endAction('Reservación cancelada');
                    } catch (e) {
                        Swal.fire('Error', e.message, 'error');
                    } finally {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                }
            }
        });

        function endAction(msg) {
            bootstrap.Modal.getInstance(document.getElementById('modalDetalleReserva')).hide();
            Swal.fire({ icon: 'success', title: msg, toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
            fetchData();
        }

        document.querySelectorAll('.btn-tab').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.btn-tab').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentTab = this.dataset.tab;
                renderReservas();
            });
        });

        document.getElementById('search-reserva').addEventListener('input', renderReservas);

        document.addEventListener('DOMContentLoaded', () => {
            fetchData();
            setInterval(fetchData, 60000);
        });
    </script>
@endpush