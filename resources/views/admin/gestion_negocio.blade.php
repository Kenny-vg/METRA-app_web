@extends('admin.menu')
@section('title', 'Gestión del Negocio')

@section('content')
    <header class="mb-5 border-bottom pb-4" style="border-color: var(--border-light) !important;">
        <h2 class="fw-bold" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Gestión del Negocio</h2>
        <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Administración de estructura y configuración operativa.</p>
    </header>

    <ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
    <li class="nav-item">
        <button class="nav-link active rounded-pill px-4" id="zonas-tab" data-bs-toggle="pill" data-bs-target="#zonas" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
            <i class="bi bi-geo-alt me-2"></i>Zonas
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link rounded-pill px-4" id="mesas-tab" data-bs-toggle="pill" data-bs-target="#mesas" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
            <i class="bi bi-layout-three-columns me-2"></i>Mesas
        </button>
    </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-4" id="meseros-tab" data-bs-toggle="pill" data-bs-target="#meseros" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
                <i class="bi bi-people me-2"></i>Personal
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-4" id="reviews-tab" data-bs-toggle="pill" data-bs-target="#reviews" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
                <i class="bi bi-star me-2"></i>Reseñas
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-4" id="horarios-tab" data-bs-toggle="pill" data-bs-target="#horarios" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
                <i class="bi bi-clock me-2"></i>Horarios
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- ZONAS -->
        <div class="tab-pane fade show active" id="zonas">
            <div class="card border-0 p-4 p-md-5 premium-card">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Distribución de Áreas</h5>
                    <button class="btn-admin-primary" onclick="openModalZona()">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Zona
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table-metra mt-2">
                        <thead>
                            <tr>
                                <th>Nombre de la Zona</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-zonas-body">
                            <!-- Zonas cargadas por JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MESAS -->
        <div class="tab-pane fade" id="mesas">
             <div class="card border-0 p-4 p-md-5 premium-card">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Inventario de Mesas</h5>
                    <button class="btn-admin-primary" onclick="openModalMesa()">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Mesa
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table-metra mt-2">
                        <thead>
                            <tr>
                                <th># Mesa</th>
                                <th>Zona</th>
                                <th>Capacidad</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-mesas-body">
                            <!-- Mesas cargadas por JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- PERSONAL -->
        <div class="tab-pane fade" id="meseros">
             <!-- ... contenido igual ... -->
        </div>

        <!-- REVIEWS -->
        <div class="tab-pane fade" id="reviews">
             <!-- ... contenido igual ... -->
        </div>

        <!-- HORARIOS -->
        <div class="tab-pane fade" id="horarios">
            <div class="card border-0 p-4 p-md-5 premium-card">
                <div class="mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0 mb-1" style="color: var(--black-primary); letter-spacing: -0.5px;">Horarios de Atención</h5>
                    <p class="m-0" style="color: var(--text-muted); font-size: 0.9rem;">Configura los días y horas de operación de tu negocio.</p>
                </div>
                <div class="row g-3" id="horarios-container">
                    <!-- Horarios cargados por JS -->
                </div>
                <div class="mt-5 pt-4 border-top d-flex flex-wrap flex-md-nowrap gap-3 justify-content-between" style="border-color: var(--border-light) !important;">
                    <button class="btn-admin-secondary px-4 py-2 w-100 w-md-auto" onclick="openModalHorario()">
                        <i class="bi bi-plus-lg me-2"></i>Añadir Horario
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="modalZona" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold m-0" id="modalZonaTitle" style="color: var(--black-primary); letter-spacing: -0.5px;">Nueva Zona de Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-3">
                    <form id="formZona">
                        <input type="hidden" id="zona-id">
                        <p class="small text-muted mb-4">La zonificación ayuda a distribuir mejor a sus clientes.</p>
                        <div class="mb-4">
                            <label class="form-label small fw-bold" style="color: var(--text-main); letter-spacing: 0.5px;">DENOMINACIÓN</label>
                            <input type="text" id="zona-nombre" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" placeholder="Ej. Balcón Este" required>
                        </div>
                        <button type="submit" class="btn-admin-primary w-100 py-3 mt-3">Guardar Zona</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMesa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold m-0" id="modalMesaTitle" style="color: var(--black-primary); letter-spacing: -0.5px;">Añadir Mesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-4">
                    <form id="formMesa">
                        <input type="hidden" id="mesa-id">
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">NÚMERO</label>
                                <input type="number" id="mesa-numero" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" placeholder="Ej. 1" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">ZONA</label>
                                <select id="mesa-zona-id" class="form-select border-0 shadow-sm rounded-3" style="background: var(--off-white);" required>
                                    <option value="">Cargando zonas...</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">CAPACIDAD</label>
                                <input type="number" id="mesa-capacidad" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" placeholder="Personas" required>
                            </div>
                        </div>
                        <button type="submit" class="btn-admin-primary w-100 py-3 mt-3">Guardar Mesa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHorario" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold m-0" id="modalHorarioTitle" style="color: var(--black-primary); letter-spacing: -0.5px;">Configurar Horario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-4">
                    <form id="formHorario">
                        <input type="hidden" id="horario-id">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">DÍA DE LA SEMANA</label>
                            <select id="horario-dia" class="form-select border-0 shadow-sm rounded-3" style="background: var(--off-white);" required>
                                <option value="">Seleccione día...</option>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miercoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sabado">Sábado</option>
                                <option value="Domingo">Domingo</option>
                            </select>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">APERTURA</label>
                                <input type="time" id="horario-apertura" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">CIERRE</label>
                                <input type="time" id="horario-cierre" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" required>
                            </div>
                        </div>
                        <button type="submit" class="btn-admin-primary w-100 py-3 mt-3">Guardar Horario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mismo modal de meseros pero vacío / igual que antes para evitar breaking -->
    <div class="modal fade" id="modalMesero" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0"><h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Integrar Colaborador</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body pt-4">
                    <input type="text" class="form-control border-0 shadow-sm rounded-3 mb-3" style="background: var(--off-white);" placeholder="Nombre completo del colaborador">
                    <input type="tel" class="form-control border-0 shadow-sm rounded-3 mb-4" style="background: var(--off-white);" placeholder="Teléfono de contacto">
                    <button class="btn-admin-primary w-100 py-3 mt-3">Agregar al equipo</button>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer_admin')

    <script>
        let modalZonaInst;
        let modalMesaInst;
        let modalHorarioInst;

        document.addEventListener('DOMContentLoaded', () => {
            modalZonaInst = new bootstrap.Modal(document.getElementById('modalZona'));
            modalMesaInst = new bootstrap.Modal(document.getElementById('modalMesa'));
            modalHorarioInst = new bootstrap.Modal(document.getElementById('modalHorario'));
            
            loadZonas();
            loadMesas();
            loadHorarios();
        });

        const API_URL = '/api/gerente';
        const getToken = () => localStorage.getItem('token');

        const headers = () => ({
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${getToken()}`
        });

        const showToast = (icon, title) => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 3000
            });
        };

        // --- ZONAS ---
        async function loadZonas() {
            try {
                const res = await fetch(`${API_URL}/zonas`, { headers: headers() });
                if (!res.ok) throw new Error('Error al cargar zonas');
                
                const response = await res.json();
                // Extract array depending on how API is structuring it (often response.data)
                const zonas = Array.isArray(response) ? response : (response.data || []);
                
                const tbody = document.getElementById('tabla-zonas-body');
                tbody.innerHTML = '';
                
                // Also update Mesas select
                const selectZona = document.getElementById('mesa-zona-id');
                selectZona.innerHTML = '<option value="">Seleccione zona...</option>';

                zonas.forEach(z => {
                    const opacityClass = z.activo ? '' : 'opacity-50';
                    const bgClass = z.activo ? '' : 'table-secondary';
                    const badge = !z.activo ? `<span class="badge bg-secondary ms-2">Inactivo</span>` : '';
                    const actions = z.activo 
                        ? `<button class="btn btn-sm btn-outline-dark rounded-circle me-1" onclick="editZona(${z.id}, '${z.nombre_zona}')" title="Editar"><i class="bi bi-pencil"></i></button>
                           <button class="btn btn-sm btn-outline-danger rounded-circle" onclick="deleteZona(${z.id})" title="Desactivar"><i class="bi bi-trash"></i></button>`
                        : `<button class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" onclick="reactivateZona(${z.id})" title="Reactivar"><i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar</button>`;

                    tbody.innerHTML += `
                        <tr class="${bgClass} ${opacityClass}">
                            <td class="fw-bold" style="color: var(--black-primary);">${z.nombre_zona} ${badge}</td>
                            <td class="text-end">
                                ${actions}
                            </td>
                        </tr>
                    `;
                    if(z.activo) {
                        selectZona.innerHTML += `<option value="${z.id}">${z.nombre_zona}</option>`;
                    }
                });
            } catch (error) {
                console.error(error);
                document.getElementById('tabla-zonas-body').innerHTML = '<tr><td colspan="2" class="text-danger text-center py-4">Error de conexión al cargar zonas.</td></tr>';
                showToast('error', 'No se pudieron cargar las zonas');
            }
        }

        function openModalZona() {
            document.getElementById('formZona').reset();
            document.getElementById('zona-id').value = '';
            document.getElementById('modalZonaTitle').innerText = 'Nueva Zona de Servicio';
            modalZonaInst.show();
        }

        function editZona(id, nombre) {
            document.getElementById('zona-id').value = id;
            document.getElementById('zona-nombre').value = nombre;
            document.getElementById('modalZonaTitle').innerText = 'Editar Zona';
            modalZonaInst.show();
        }

        document.getElementById('formZona').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('zona-id').value;
            const nombre_zona = document.getElementById('zona-nombre').value;
            
            const method = id ? 'PUT' : 'POST';
            const url = id ? `${API_URL}/zonas/${id}` : `${API_URL}/zonas`;

            try {
                const res = await fetch(url, {
                    method,
                    headers: headers(),
                    body: JSON.stringify({ nombre_zona })
                });

                if (res.ok) {
                    showToast('success', id ? 'Zona actualizada' : 'Zona creada');
                    modalZonaInst.hide();
                    loadZonas();
                    loadMesas(); // Mesas could depend on it
                } else {
                    const errorData = await res.json();
                    Swal.fire('Error', errorData.message || 'Error al guardar zona', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Error de conexión', 'error');
            }
        });

        async function deleteZona(id) {
            Swal.fire({
                title: '¿Desactivar Zona?',
                text: 'Esta zona dejará de estar disponible.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, desactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/zonas/${id}`, { method: 'DELETE', headers: headers() });
                        if (res.ok) {
                            showToast('success', 'Zona desactivada');
                            loadZonas();
                            loadMesas();
                        } else {
                            const err = await res.json();
                            Swal.fire('Error', err.message || 'Error al desactivar zona', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }

        async function reactivateZona(id) {
            Swal.fire({
                title: '¿Reactivar Zona?',
                text: 'Esta zona volverá a estar disponible.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, reactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/zonas/${id}/activar`, { method: 'PATCH', headers: headers() });
                        if (res.ok) {
                            showToast('success', 'Zona reactivada');
                            loadZonas();
                            loadMesas();
                        } else {
                            const err = await res.json();
                            Swal.fire('Error', err.message || 'Error al reactivar zona', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }

        // --- MESAS ---
        async function loadMesas() {
            try {
                const res = await fetch(`${API_URL}/mesas`, { headers: headers() });
                if (!res.ok) throw new Error('Error al cargar mesas');
                
                const response = await res.json();
                const mesas = Array.isArray(response) ? response : (response.data || []);
                
                const tbody = document.getElementById('tabla-mesas-body');
                tbody.innerHTML = '';

                mesas.forEach(m => {
                    const zonaNombre = m.zona ? m.zona.nombre_zona : 'N/A';
                    const opacityClass = m.activo ? '' : 'opacity-50';
                    const bgClass = m.activo ? '' : 'table-secondary';
                    const badge = !m.activo ? `<span class="badge bg-secondary ms-2">Inactiva</span>` : '';
                    const actions = m.activo
                        ? `<button class="btn btn-sm btn-outline-dark rounded-circle me-1" onclick='editMesa(${JSON.stringify(m)})' title="Editar"><i class="bi bi-pencil"></i></button>
                           <button class="btn btn-sm btn-outline-danger rounded-circle" onclick="deleteMesa(${m.id})" title="Desactivar"><i class="bi bi-trash"></i></button>`
                        : `<button class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" onclick="reactivateMesa(${m.id})" title="Reactivar"><i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar</button>`;

                    tbody.innerHTML += `
                        <tr class="${bgClass} ${opacityClass}">
                            <td class="fw-bold" style="color: var(--black-primary);">
                                <div class="d-inline-flex align-items-center justify-content-center text-white rounded-circle me-2 shadow-sm" style="background: var(--black-primary); width: 25px; height: 25px; font-size: 0.75rem;">
                                    ${m.numero_mesa}
                                </div>
                                ${badge}
                            </td>
                            <td><span class="badge" style="background: var(--off-white); border: 1px solid var(--border-light); color: var(--text-main);">${zonaNombre}</span></td>
                            <td class="text-muted">${m.capacidad} Personas</td>
                            <td class="text-end">
                                ${actions}
                            </td>
                        </tr>
                    `;
                });
            } catch (error) {
                console.error(error);
                document.getElementById('tabla-mesas-body').innerHTML = '<tr><td colspan="4" class="text-danger text-center py-4">Error de conexión al cargar mesas.</td></tr>';
                showToast('error', 'No se pudieron cargar las mesas');
            }
        }

        function openModalMesa() {
            document.getElementById('formMesa').reset();
            document.getElementById('mesa-id').value = '';
            document.getElementById('modalMesaTitle').innerText = 'Añadir Mesa';
            modalMesaInst.show();
        }

        function editMesa(m) {
            document.getElementById('mesa-id').value = m.id;
            document.getElementById('mesa-numero').value = m.numero_mesa;
            document.getElementById('mesa-zona-id').value = m.zona_id;
            document.getElementById('mesa-capacidad').value = m.capacidad;
            document.getElementById('modalMesaTitle').innerText = 'Editar Mesa';
            modalMesaInst.show();
        }

        document.getElementById('formMesa').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('mesa-id').value;
            const data = {
                numero_mesa: document.getElementById('mesa-numero').value,
                zona_id: document.getElementById('mesa-zona-id').value,
                capacidad: document.getElementById('mesa-capacidad').value
            };
            
            const method = id ? 'PUT' : 'POST';
            const url = id ? `${API_URL}/mesas/${id}` : `${API_URL}/mesas`;

            try {
                const res = await fetch(url, {
                    method,
                    headers: headers(),
                    body: JSON.stringify(data)
                });

                if (res.ok) {
                    showToast('success', id ? 'Mesa actualizada' : 'Mesa creada');
                    modalMesaInst.hide();
                    loadMesas();
                } else {
                    const errorData = await res.json();
                    Swal.fire('Error', errorData.message || 'Error al guardar mesa', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Error de conexión', 'error');
            }
        });

        async function deleteMesa(id) {
            Swal.fire({
                title: '¿Desactivar Mesa?',
                text: 'Esta mesa dejará de estar disponible.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, desactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/mesas/${id}`, { method: 'DELETE', headers: headers() });
                        if (res.ok) {
                            showToast('success', 'Mesa desactivada');
                            loadMesas();
                        } else {
                            const err = await res.json();
                            Swal.fire('Error', err.message || 'Error al desactivar mesa', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }

        async function reactivateMesa(id) {
            Swal.fire({
                title: '¿Reactivar Mesa?',
                text: 'Esta mesa volverá a estar disponible.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, reactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/mesas/${id}/activar`, { method: 'PATCH', headers: headers() });
                        if (res.ok) {
                            showToast('success', 'Mesa reactivada');
                            loadMesas();
                        } else {
                            const err = await res.json();
                            Swal.fire('Error', err.message || 'Error al reactivar mesa. Verifica la zona', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }

        // --- HORARIOS ---
        async function loadHorarios() {
            try {
                const res = await fetch(`${API_URL}/horarios`, { headers: headers() });
                if (!res.ok) throw new Error('Error al cargar horarios');
                
                const response = await res.json();
                const horarios = Array.isArray(response) ? response : (response.data || []);
                
                const container = document.getElementById('horarios-container');
                container.innerHTML = '';

                if (horarios.length === 0) {
                    container.innerHTML = '<div class="col-12 text-center text-muted py-4">No hay horarios configurados aún.</div>';
                    return;
                }

                // Opcional: ordenar por día
                const ordenDias = { "Lunes": 1, "Martes": 2, "Miercoles": 3, "Jueves": 4, "Viernes": 5, "Sabado": 6, "Domingo": 7 };
                horarios.sort((a, b) => (ordenDias[a.dia_semana] || 99) - (ordenDias[b.dia_semana] || 99));

                horarios.forEach(h => {
                    const apertura = h.hora_apertura.substring(0, 5); // Mostrar HH:MM
                    const cierre = h.hora_cierre.substring(0, 5);
                    const opacityClass = h.activo ? '' : 'opacity-50';
                    const badge = !h.activo ? `<span class="badge bg-secondary ms-2" style="font-size:0.7rem;">Inactivo</span>` : '';
                    const actions = h.activo
                        ? `<button class="btn btn-sm btn-outline-dark rounded-circle" onclick='editHorario(${JSON.stringify(h)})' title="Editar"><i class="bi bi-pencil"></i></button>
                           <button class="btn btn-sm btn-outline-danger rounded-circle" onclick="deleteHorario(${h.id})" title="Desactivar"><i class="bi bi-trash"></i></button>`
                        : `<button class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" onclick="reactivateHorario(${h.id})" title="Reactivar"><i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar</button>`;

                    container.innerHTML += `
                        <div class="col-md-6 col-lg-4">
                            <div class="p-3 rounded-4 d-flex justify-content-between align-items-center h-100 ${opacityClass}" style="background: var(--off-white); border: 1px solid var(--border-light);">
                                <div>
                                    <span class="fw-bold d-block mb-1" style="color: var(--black-primary); font-size: 1.05rem;">${h.dia_semana} ${badge}</span>
                                    <span class="small d-block text-muted"><i class="bi bi-clock me-1"></i> ${apertura} - ${cierre}</span>
                                </div>
                                <div class="d-flex gap-2">
                                    ${actions}
                                </div>
                            </div>
                        </div>
                    `;
                });
            } catch (error) {
                console.error(error);
                document.getElementById('horarios-container').innerHTML = '<div class="col-12 text-center text-danger py-4">Error de conexión al cargar horarios.</div>';
                showToast('error', 'No se pudieron cargar los horarios');
            }
        }

        function openModalHorario() {
            document.getElementById('formHorario').reset();
            document.getElementById('horario-id').value = '';
            document.getElementById('horario-dia').disabled = false; // Permitir seleccionar día en nuevo
            document.getElementById('modalHorarioTitle').innerText = 'Añadir Horario';
            modalHorarioInst.show();
        }

        function editHorario(h) {
            document.getElementById('horario-id').value = h.id;
            document.getElementById('horario-dia').value = h.dia_semana;
            document.getElementById('horario-dia').disabled = true; // Deshabilitar cambio de día en edición
            
            // Format HH:MM from HH:MM:SS
            document.getElementById('horario-apertura').value = h.hora_apertura.substring(0, 5);
            document.getElementById('horario-cierre').value = h.hora_cierre.substring(0, 5);
            
            document.getElementById('modalHorarioTitle').innerText = 'Editar Horario';
            modalHorarioInst.show();
        }

        document.getElementById('formHorario').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('horario-id').value;
            const data = {
                dia_semana: document.getElementById('horario-dia').value, // Aunque disabled, leer el value funciona, pero disabled inputs don't submit in normal forms. we read it manually anyway.
                hora_apertura: document.getElementById('horario-apertura').value,
                hora_cierre: document.getElementById('horario-cierre').value
            };
            
            const method = id ? 'PUT' : 'POST';
            const url = id ? `${API_URL}/horarios/${id}` : `${API_URL}/horarios`;

            try {
                const res = await fetch(url, {
                    method,
                    headers: headers(),
                    body: JSON.stringify(data)
                });

                if (res.ok) {
                    showToast('success', id ? 'Horario actualizado' : 'Horario creado');
                    modalHorarioInst.hide();
                    loadHorarios();
                } else {
                    const errorData = await res.json();
                    Swal.fire('Error', errorData.message || 'Error al guardar horario (quizá ya existe)', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Error de conexión', 'error');
            }
        });

        async function deleteHorario(id) {
            Swal.fire({
                title: '¿Desactivar Horario?',
                text: 'Este horario dejará de estar disponible.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, desactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/horarios/${id}`, { method: 'DELETE', headers: headers() });
                        if (res.ok) {
                            showToast('success', 'Horario desactivado');
                            loadHorarios();
                        } else {
                            const err = await res.json();
                            Swal.fire('Error', err.message || 'Error al desactivar horario', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }

        async function reactivateHorario(id) {
            Swal.fire({
                title: '¿Reactivar Horario?',
                text: 'Este horario volverá a estar disponible.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, reactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/horarios/${id}/activar`, { method: 'PATCH', headers: headers() });
                        if (res.ok) {
                            showToast('success', 'Horario reactivado');
                            loadHorarios();
                        } else {
                            const err = await res.json();
                            Swal.fire('Error', err.message || 'Error al reactivar horario', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }
    </script>
@endsection