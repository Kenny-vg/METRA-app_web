@extends('superadmin.menu')

@section('title', 'Suscripciones')

@section('content')
    <header class="mb-5">
        <h2 class="fw-bold">Gestión de Suscripciones</h2>
        <p class="text-muted">Control de ingresos y estados de cuenta de los negocios en METRA.</p>
    </header>

    <!-- Loading overlay -->
    <div id="overlay-loading" style="display:none !important; position:fixed; top:0;left:0;width:100%;height:100%; z-index:9999; align-items:center; justify-content:center; background: rgba(255,255,255,0.8);">
        <div class="text-center">
            <div class="spinner-border mb-3" style="width:3rem;height:3rem;"></div>
            <p class="fw-bold">Procesando...</p>
        </div>
    </div>

    <!-- SECCIÓN DE SOLICITUDES PENDIENTES (Oculta por defecto) -->
    <div id="seccion-pendientes" class="mb-4 d-none">
        <div class="alert" style="background-color: #FFF8E1; border: 1px solid #FFC107; border-radius: 12px;">
            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-bell-fill fs-4 me-3" style="color: #FF8F00;"></i>
                <h5 class="fw-bold m-0" style="color: #FF8F00;">Solicitudes Pendientes de Revisión (<span id="contador-pendientes">0</span>)</h5>
            </div>
            <p class="small text-muted mb-3">Los siguientes negocios han subido su comprobante de pago para renovación de suscripción y esperan tu aprobación.</p>
            
            <div class="row g-3" id="contenedor-tarjetas-pendientes">
                <!-- Las tarjetas se generan dinámicamente aquí -->
            </div>
        </div>
    </div>

    <div class="premium-card p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <h5 class="fw-bold m-0" style="color: var(--black-primary);"><i class="bi bi-credit-card-2-front me-2" style="color: var(--accent-gold);"></i>Control de Pagos y Planes</h5>
            <div class="input-group" style="max-width: 300px;">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="small text-muted text-uppercase">
                        <th>Negocio</th>
                        <th>Plan Actual</th>
                        <th>Monto Mensual</th>
                        <th>Próximo Pago</th>
                        <th>Estado</th>
                        <th class="text-center">Historial</th>
                        <th class="text-center pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-suscripciones">
                    <tr><td colspan="6" class="text-center text-muted py-4"><div class="spinner-border spinner-border-sm me-2"></div>Cargando...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL: Detalle de Cafetería -->
    <div class="modal fade" id="modalDetalle" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 p-4">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary);">Detalle de Negocio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    <div id="detalle-body" class="text-center">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Historial de Suscripciones -->
    <div class="modal fade" id="modalHistorial" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary);">Historial de <span id="historial-cafe-nombre"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="small text-muted text-uppercase">
                                    <th>Periodo</th>
                                    <th>Plan</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th class="text-center">Comprobante</th>
                                </tr>
                            </thead>
                            <tbody id="historial-body">
                                <tr><td colspan="5" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
.cafe-name-cell {
    text-decoration: none !important;
    transition: color 0.2s ease;
}
.cafe-name-cell:hover {
    color: var(--accent-gold) !important;
}
</style>
<script>
const API = '/api';
let authToken = localStorage.getItem('token') || '';

if (!authToken) {
    window.location.href = '/login';
}

function authHeaders() {
    return {
        'Authorization': `Bearer ${authToken}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    };
}

async function cargarSuscripciones() {
    try {
        // Cargar pendientes
        cargarPendientes();

        const res = await fetch(`${API}/superadmin/suscripciones`, { headers: authHeaders() });
        const json = await res.json();
        if (!res.ok) throw new Error("Error del servidor");

        renderTabla(json.data || []);
    } catch (e) {
        document.getElementById('tabla-suscripciones').innerHTML = 
            '<tr><td colspan="6" class="text-danger text-center py-4">Ocurrió un problema al procesar la solicitud. Intenta nuevamente.</td></tr>';
    }
}

async function cargarPendientes() {
    const seccion = document.getElementById('seccion-pendientes');
    const contenedor = document.getElementById('contenedor-tarjetas-pendientes');
    const contador = document.getElementById('contador-pendientes');

    try {
        const res = await fetch(`${API}/superadmin/suscripciones-pendientes`, { headers: authHeaders() });
        const json = await res.json();
        
        if (res.ok && json.data && json.data.length > 0) {
            const pendientes = json.data;
            contador.innerText = pendientes.length;
            seccion.classList.remove('d-none');
            
            contenedor.innerHTML = pendientes.map(p => {
                const cafeNombre = escapeHTML(p.cafeteria?.nombre || 'Cafetería Desconocida');
                const planNombre = escapeHTML(p.plan?.nombre_plan || 'Plan');
                const monto = p.monto ? `$${parseFloat(p.monto).toFixed(2)}` : 'N/A';
                // Fecha desde la tabla de suscripción principal que acaba de ser actualizada
                const fechaSolicitud = p.updated_at ? new Date(p.updated_at).toLocaleDateString('es-ES', { day: 'numeric', month: 'short', year: 'numeric' }) : 'Reciente';

                return `
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius: 10px; border-left: 4px solid #FFC107 !important;">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-1">${cafeNombre}</h6>
                            <p class="small text-muted mb-2"><i class="bi bi-calendar-event me-1"></i>Solicitado el: ${fechaSolicitud}</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge" style="background: #FFF8E1; color: #FFA000; border: 1px solid #FFE082;">${planNombre}</span>
                                <span class="fw-bold" style="color: var(--black-primary);">${monto}</span>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-secondary w-50" onclick="verComprobanteSub(${p.id})">
                                    <i class="bi bi-receipt me-1"></i>Ver Ticket
                                </button>
                                <button class="btn btn-sm btn-success w-50" style="background-color: #2E7D32; border-color: #2E7D32;" onclick="aprobarRenovacion(${p.id})">
                                    <i class="bi bi-check-lg me-1"></i>Aprobar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>`;
            }).join('');
        } else {
            seccion.classList.add('d-none');
        }
    } catch (e) {
        console.error('Error cargando solicitudes pendientes', e);
    }
}

function renderTabla(suscripciones) {
    const tbody = document.getElementById('tabla-suscripciones');
    if (!suscripciones.length) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">No hay suscripciones registradas.</td></tr>';
        return;
    }
    
    tbody.innerHTML = suscripciones.map(s => {
        const cafe = escapeHTML(s.cafeteria?.nombre || '—');
        const safeName = cafe;
        const plan = escapeHTML(s.plan?.nombre_plan || '—');
        const monto = s.monto ? `$${parseFloat(s.monto).toFixed(2)}` : '—';
        // Parseo robusto de la fecha de fin para evitar errores con formatos ISO (p.ej. 2026-03-10T23:59:59.000Z)
        const fFinDate = s.fecha_fin ? new Date(s.fecha_fin) : null;
        const isFFinValid = fFinDate instanceof Date && !isNaN(fFinDate);
        const fechaFin = isFFinValid
            ? fFinDate.toLocaleDateString('es-ES', { day: 'numeric', month: 'short', year: 'numeric' })
            : '—';

        let badgePlan = `<span class="badge rounded-pill px-3 py-2" style="background: #FFF8E1; color: #FFA000; border: 1px solid #FFE082;">${plan}</span>`;
        
        // Lógica de Estado Mejorada (evaluando fecha en HTML)
        let badgeEstado = '';
        // Si la fecha es válida, considerar vencida cuando el momento actual supera la fecha de fin.
        const isVencida = isFFinValid && (new Date() > fFinDate);

        if (s.estado_pago === 'pendiente') {
            badgeEstado = `<span class="badge rounded-pill px-3 py-2 d-inline-flex align-items-center" style="background: #FFF8E1; color: #FFA000; border: 1px solid #FFE082;">● Pendiente</span>`;
            if (s.comprobante_url) {
                badgeEstado += ` <button type="button" class="btn btn-sm btn-link p-0 ms-2 text-primary align-baseline" onclick="verComprobanteSub(${s.id})" title="Ver Comprobante" data-bs-toggle="tooltip"><i class="bi bi-receipt fs-5"></i></button>`;
            }
        } else if (isVencida) {
            badgeEstado = `<span class="badge rounded-pill px-3 py-2" style="background: #FFEBEE; color: #C62828; border: 1px solid #EF9A9A;">● Vencida</span>`;
        } else if (s.estado_pago === 'pagado') {
            badgeEstado = `<span class="badge rounded-pill px-3 py-2" style="background: #E8F5E9; color: #2E7D32; border: 1px solid #A5D6A7;">● Pagada</span>`;
        } else if (s.estado_pago === 'cancelado') {
            badgeEstado = `<span class="badge rounded-pill px-3 py-2" style="background: #F5F5F5; color: #757575; border: 1px solid #E0E0E0;">● Cancelada</span>`;
        }

        return `<tr class="${s.estado_pago === 'cancelado' ? 'opacity-75' : ''}">
            <td class="fw-bold cafe-name-cell" style="color: var(--black-primary); cursor: pointer;" onclick="verDetalle(${s.cafe_id})">${cafe}</td>
            <td>${badgePlan}</td>
            <td class="fw-bold" style="color: var(--black-primary);">${monto}</td>
            <td style="color: var(--text-muted);">${fechaFin}</td>
            <td>${badgeEstado}</td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-primary rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Historial" onclick="verHistorial(${s.cafe_id}, '${safeName}')"><i class="bi bi-clock-history"></i></button>
            </td>
            <td class="text-center pe-4">
                <div class="d-flex justify-content-center gap-3 text-nowrap">
                    ${
                          // Registro inicial pendiente de aprobar
                          (s.cafeteria?.estado === 'en_revision')
                            ? `<span class="btn btn-sm btn-outline-warning rounded-pill px-3 disabled" style="width: 110px; opacity: 0.8; pointer-events: none; border-color: #ffc107; color: #ffc107;">Pendiente</span>`
                          // Cualquier suscripción pendiente (renovación o vencida) → botón Aprobar Pago
                          : (s.estado_pago === 'pendiente')
                            ? `<button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3" style="width: 130px;" onclick="aprobarRenovacion(${s.id})"><i class="bi bi-check-circle me-1"></i>Aprobar Pago</button>`
                          // Sin suscripción activa -> suspendida o cancelada
                          : (s.estado_pago !== 'cancelado' && s.cafeteria?.estado !== 'suspendida'
                            ? `<button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" style="width: 110px;" onclick="cambiarEstado(${s.cafe_id}, 'suspendida')">Suspender</button>`
                            : `<button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3" style="width: 110px;" onclick="cambiarEstado(${s.cafe_id}, 'activa')">Reactivar</button>`)
                        }
                    </div>
                </td>
            </tr>`;

    }).join('');
}

async function cambiarEstado(cafeteriaId, nuevoEstado) {
    const accion = nuevoEstado === 'suspendida' ? 'SUSPENDER' : 'REACTIVAR';
    
    Swal.fire({
        title: `¿Deseas ${accion} esta cafetería?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#382C26',
        cancelButtonColor: '#6c757d',
        confirmButtonText: `Sí, ${accion.toLowerCase()}`,
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            document.getElementById('overlay-loading').style.setProperty('display', 'flex', 'important');
            try {
                const endpointAccion = nuevoEstado === 'suspendida' ? 'rechazar' : 'aprobar';
                const res  = await fetch(`${API}/superadmin/solicitudes/${cafeteriaId}/${endpointAccion}`, {
                    method: 'PATCH',
                    headers: authHeaders()
                });
                
                if (!res.ok) { 
                    if(res.status >= 500) {
                        throw new Error('Ocurrió un problema al procesar la solicitud. Intenta nuevamente.');
                    }
                    throw new Error('Algo salió mal. Intenta de nuevo.');
                }
                
                await cargarSuscripciones();
                Swal.fire('¡Éxito!', `Cafetería ${accion.toLowerCase()} correctamente.`, 'success');
            } catch (e) {
                if(e.message === 'Ocurrió un problema al procesar la solicitud. Intenta nuevamente.' || e.message === 'Algo salió mal. Intenta de nuevo.') {
                    Swal.fire('Atención', e.message, 'warning');
                } else {
                    Swal.fire('Error de conexión', 'No pudimos conectar con el servidor. Verifica tu internet.', 'error');
                }
            } finally {
                document.getElementById('overlay-loading').style.setProperty('display', 'none', 'important');
            }
        }
    });
}

async function verDetalle(cafeteriaId) {
    const modal = new bootstrap.Modal(document.getElementById('modalDetalle'));
    const body = document.getElementById('detalle-body');
    body.innerHTML = '<div class="spinner-border text-primary" role="status"></div>';
    modal.show();

    try {
        const res = await fetch(`${API}/superadmin/cafeterias/${cafeteriaId}`, { headers: authHeaders() });
        const json = await res.json();
        if (!res.ok) {
            body.innerHTML = '<p class="text-danger">Algo salió mal. Intenta de nuevo.</p>';
            return;
        }

        const c = json.data;
        const gerente = c.gerente ? escapeHTML(c.gerente.name) + ' (' + escapeHTML(c.gerente.email) + ')' : 'Sin gerente';
        const plan = escapeHTML(c.suscripcion_actual?.plan?.nombre_plan || 'Sin plan');
        
        body.innerHTML = `
            <div class="text-start">
                <div class="card border-0 bg-light rounded-4 mb-3">
                    <div class="card-body p-4">
                        <h6 class="text-muted small text-uppercase fw-bold mb-3" style="letter-spacing: 0.5px;">Información del Negocio</h6>
                        <div class="d-flex justify-content-between mb-2"><span class="text-muted">Nombre</span><span class="fw-bold text-dark">${escapeHTML(c.nombre)}</span></div>
                        <div class="d-flex justify-content-between mb-2"><span class="text-muted">Estado</span><span class="badge bg-secondary rounded-pill">${c.estado}</span></div>
                        <div class="d-flex justify-content-between"><span class="text-muted">Gerente</span><span class="fw-bold">${gerente}</span></div>
                    </div>
                </div>
                <div class="card border-0 bg-light rounded-4">
                    <div class="card-body p-4">
                        <h6 class="text-muted small text-uppercase fw-bold mb-3" style="letter-spacing: 0.5px;">Detalle de Suscripción</h6>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Plan Actual</span>
                            <span class="fw-bold" style="color: var(--accent-gold);">${plan}</span>

                    </div>
                </div>
            </div>
        `;

    } catch (e) {
        body.innerHTML = '<p class="text-danger">No pudimos conectar con el servidor. Verifica tu internet.</p>';
    }
}

async function verComprobante(cafeteriaId) {
    const modal = new bootstrap.Modal(document.getElementById('modalComprobante'));
    const body = document.getElementById('detalle-body');
    
    // We reuse the modal for the receipt as well, or we can use another one. 
    // Given the current structure, let's keep it simple.
    
    body.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Cargando comprobante...</p></div>';
    
    try {
        const url = `${API}/superadmin/cafeterias/${cafeteriaId}/comprobante`;
        const response = await fetch(url, { headers: authHeaders() });
        
        if (!response.ok) throw new Error('Error al cargar el comprobante');
        
        const blob = await response.blob();
        const blobUrl = URL.createObjectURL(blob);
        const contentType = response.headers.get('content-type');
        
        if (contentType && contentType.includes('pdf')) {
            body.innerHTML = `
                <div class="text-center p-4">
                    <i class="bi bi-file-earmark-pdf fs-1 text-danger mb-3 d-block"></i>
                    <a href="${blobUrl}" target="_blank" class="btn btn-dark px-4 rounded-pill">
                        <i class="bi bi-box-arrow-up-right me-2"></i>Abrir PDF
                    </a>
                </div>
            `;
        } else {
            body.innerHTML = `
                <div class="text-center">
                    <img src="${blobUrl}" class="img-fluid rounded-3 shadow-sm mb-3" style="max-height: 400px;" alt="Comprobante">
                    <div>
                        <a href="${blobUrl}" download="comprobante" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="bi bi-download me-1"></i>Descargar
                        </a>
                    </div>
                </div>
            `;
        }
    } catch (e) {
        body.innerHTML = '<p class="text-danger text-center">No pudimos cargar el comprobante.</p>';
    }
}

async function verComprobanteSub(suscripcionId) {
    const modal = new bootstrap.Modal(document.getElementById('modalDetalle'));
    const body = document.getElementById('detalle-body');
    
    body.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Cargando comprobante...</p></div>';
    modal.show();
    
    try {
        const url = `${API}/superadmin/suscripciones/${suscripcionId}/comprobante`;
        const response = await fetch(url, { headers: authHeaders() });
        
        if (!response.ok) throw new Error('Error al cargar el comprobante');
        
        const blob = await response.blob();
        const blobUrl = URL.createObjectURL(blob);
        const contentType = response.headers.get('content-type');
        
        if (contentType && contentType.includes('pdf')) {
            body.innerHTML = `
                <div class="text-center p-4">
                    <i class="bi bi-file-earmark-pdf fs-1 text-danger mb-3 d-block"></i>
                    <a href="${blobUrl}" target="_blank" class="btn btn-dark px-4 rounded-pill">
                        <i class="bi bi-box-arrow-up-right me-2"></i>Abrir PDF
                    </a>
                </div>
            `;
        } else {
            body.innerHTML = `
                <div class="text-center">
                    <img src="${blobUrl}" class="img-fluid rounded-3 shadow-sm mb-3" style="max-height: 400px;" alt="Comprobante">
                    <div>
                        <a href="${blobUrl}" download="comprobante" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="bi bi-download me-1"></i>Descargar
                        </a>
                    </div>
                </div>
            `;
        }
    } catch (e) {
        body.innerHTML = '<p class="text-danger text-center">No pudimos cargar el comprobante.</p>';
    }
}

async function verHistorial(cafeteriaId, nombre) {
    const modal = new bootstrap.Modal(document.getElementById('modalHistorial'));
    document.getElementById('historial-cafe-nombre').innerHTML = nombre;
    const tbody = document.getElementById('historial-body');
    tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted">Cargando historial...</p></td></tr>';
    modal.show();

    try {
        const res = await fetch(`${API}/superadmin/suscripciones?cafe_id=${cafeteriaId}`, { headers: authHeaders() });
        const json = await res.json();
        if (!res.ok) throw new Error("Error del servidor");
        
        const historial = json.data || [];
        
        if (!historial.length) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">No hay historial registrado para esta cafetería.</td></tr>';
            return;
        }

        tbody.innerHTML = historial.map(s => {
            const plan = escapeHTML(s.plan?.nombre_plan || '—');
            const monto = s.monto ? `$${parseFloat(s.monto).toFixed(2)}` : '—';
            
            const fFinDate = s.fecha_fin ? new Date(s.fecha_fin) : null;
            const isFFinValid = fFinDate instanceof Date && !isNaN(fFinDate);

            const fechaInicio = s.fecha_inicio
                ? new Date(s.fecha_inicio).toLocaleDateString('es-ES', { day: 'numeric', month: 'short', year: 'numeric' })
                : '—';
            const fechaFin = isFFinValid
                ? fFinDate.toLocaleDateString('es-ES', { day: 'numeric', month: 'short', year: 'numeric' })
                : '—';
            
            let badgePlan = `<span class="badge bg-light text-dark border">${plan}</span>`;
            
            const isVencida = isFFinValid && (new Date() > fFinDate);

            let badgeEstado = `<span class="badge rounded-pill px-3 py-2" style="background: #E8F5E9; color: #2E7D32; border: 1px solid #A5D6A7;">● Pagado</span>`;
            if (s.estado_pago === 'pendiente') {
                badgeEstado = `<span class="badge rounded-pill px-3 py-2" style="background: #FFF8E1; color: #FFA000; border: 1px solid #FFE082;">● Pendiente</span>`;
            } else if (isVencida) {
                badgeEstado = `<span class="badge rounded-pill px-3 py-2" style="background: #FFEBEE; color: #C62828; border: 1px solid #EF9A9A;">● Vencida</span>`;
            } else if (s.estado_pago === 'cancelado') {
                badgeEstado = `<span class="badge rounded-pill px-3 py-2" style="background: #F5F5F5; color: #757575; border: 1px solid #E0E0E0;">● Cancelada</span>`;
            }

            let btnComprobante = '';
            if (s.comprobante_url) {
                if (s.tipo === 'historial') {
                    btnComprobante = `<button type="button" class="btn btn-sm btn-outline-dark rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Ver Recibo Histórico" onclick="verComprobanteHis(${s.id})"><i class="bi bi-file-earmark-text"></i></button>`;
                } else {
                    btnComprobante = `<button type="button" class="btn btn-sm btn-outline-dark rounded-circle" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;" title="Ver Recibo Actual" onclick="verComprobanteSub(${s.id})"><i class="bi bi-file-earmark-text"></i></button>`;
                }
            } else {
                btnComprobante = '<span class="text-muted small">—</span>';
            }

            return `<tr>
                <td style="color: var(--text-muted); font-size: 0.9rem;">
                    <span class="fw-bold text-dark">Inicio:</span> ${fechaInicio} <br> 
                    <span class="fw-bold text-dark">Vence:</span>  ${fechaFin}
                </td>
                <td>${badgePlan}</td>
                <td class="fw-bold" style="color: var(--black-primary);">${monto}</td>
                <td>${badgeEstado}</td>
                <td class="text-center">${btnComprobante}</td>
            </tr>`;
        }).join('');

    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-danger text-center py-4">Ocurrió un problema al cargar el historial. Intenta nuevamente.</td></tr>';
    }
}

async function verComprobanteHis(historialId) {
    const modal = new bootstrap.Modal(document.getElementById('modalDetalle'));
    const body = document.getElementById('detalle-body');
    
    body.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Cargando comprobante histórico...</p></div>';
    modal.show();
    
    try {
        const url = `${API}/superadmin/suscripciones-historial/${historialId}/comprobante`;
        const response = await fetch(url, { headers: authHeaders() });
        
        if (!response.ok) throw new Error('Error al cargar el comprobante histórico');
        
        const blob = await response.blob();
        const blobUrl = URL.createObjectURL(blob);
        const contentType = response.headers.get('content-type');
        
        if (contentType && contentType.includes('pdf')) {
            body.innerHTML = `
                <div class="text-center p-4">
                    <i class="bi bi-file-earmark-pdf fs-1 text-danger mb-3 d-block"></i>
                    <a href="${blobUrl}" target="_blank" class="btn btn-dark px-4 rounded-pill">
                        <i class="bi bi-box-arrow-up-right me-2"></i>Abrir PDF
                    </a>
                </div>
            `;
        } else {
            body.innerHTML = `
                <div class="text-center">
                    <img src="${blobUrl}" class="img-fluid rounded-3 shadow-sm mb-3" style="max-height: 400px;" alt="Comprobante Histórico">
                    <div>
                        <a href="${blobUrl}" download="comprobante_historico" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="bi bi-download me-1"></i>Descargar
                        </a>
                    </div>
                </div>
            `;
        }
    } catch (e) {
        body.innerHTML = '<p class="text-danger text-center">No pudimos cargar el comprobante histórico.</p>';
    }
}

// Init
cargarSuscripciones();

async function aprobarRenovacion(suscripcionId) {
    const result = await Swal.fire({
        title: '¿Aprobar esta renovación?',
        text: 'La suscripción quedará activa a partir de su fecha de inicio programada.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#382C26',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, aprobar',
        cancelButtonText: 'Cancelar'
    });
    if (!result.isConfirmed) return;

    document.getElementById('overlay-loading').style.setProperty('display', 'flex', 'important');
    try {
        const res = await fetch(`${API}/superadmin/suscripciones/${suscripcionId}/aprobar-renovacion`, {
            method: 'PATCH',
            headers: authHeaders()
        });
        const json = await res.json();
        if (!res.ok) throw new Error(json.message || 'Error al aprobar.');

        await cargarSuscripciones();
        Swal.fire('¡Aprobado!', json.message || 'Renovación aprobada correctamente.', 'success');
    } catch (e) {
        Swal.fire('Error', e.message, 'error');
    } finally {
        document.getElementById('overlay-loading').style.setProperty('display', 'none', 'important');
    }
}

// Initialize tooltips after rendering the table
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// We need to re-initialize tooltips dynamically when the table is re-rendered
function reinitializeTooltips() {
    // Dispose old tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        const instance = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
        if (instance) {
            instance.dispose();
        }
    });

    // Initialize new tooltips
    const newTooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    newTooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}
// Hook into renderTabla implicitly by calling reinitializeTooltips at the end of renderTabla
const originalRenderTabla = renderTabla;
renderTabla = function(suscripciones) {
    originalRenderTabla(suscripciones);
    setTimeout(reinitializeTooltips, 100); // Small delay to ensure DOM is updated
};

</script>
@endsection