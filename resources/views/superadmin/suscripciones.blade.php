@extends('superadmin.menu')

@section('title', 'Suscripciones')

@section('content')
    <header class="mb-5">
        <h2 class="fw-bold">Gestión de Suscripciones</h2>
        <p class="text-muted">Control de ingresos y estados de cuenta de los negocios en METRA.</p>
    </header>

    <!-- Loading overlay -->
    <div id="overlay-loading" style="display:none !important; position:fixed; top:0;left:0;width:100%;height:100%; z-index:9999; align-items:center; justify-content:center;">
        <div class="text-center">
            <div class="spinner-border mb-3" style="width:3rem;height:3rem;"></div>
            <p class="fw-bold">Procesando...</p>
        </div>
    </div>

    <div class="premium-card p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <h5 class="fw-bold m-0" style="color: var(--black-primary);"><i class="bi bi-credit-card-2-front me-2" style="color: var(--accent-gold);"></i>Control de Pagos y Planes</h5>
            <div class="input-group" style="max-width: 300px;">
                <span class="input-group-text bg-light border-0" style="background: var(--off-white) !important; border-radius: 8px 0 0 8px;"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar negocio..." style="border-radius: 0 8px 8px 0; background: var(--off-white) !important;">
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
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-suscripciones">
                    <tr><td colspan="6" class="text-center text-muted py-4"><div class="spinner-border spinner-border-sm me-2"></div>Cargando...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL: Detalle de Cafetería -->
    <div class="modal fade" id="modalDetalle" tabindex="-1" aria-hidden="true">
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
        const res = await fetch(`${API}/superadmin/suscripciones`, { headers: authHeaders() });
        const json = await res.json();
        if (!res.ok) throw new Error("Error del servidor");

        renderTabla(json.data || []);
    } catch (e) {
        document.getElementById('tabla-suscripciones').innerHTML = 
            '<tr><td colspan="6" class="text-danger text-center py-4">Ocurrió un problema al procesar la solicitud. Intenta nuevamente.</td></tr>';
    }
}

function renderTabla(suscripciones) {
    const tbody = document.getElementById('tabla-suscripciones');
    if (!suscripciones.length) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">No hay suscripciones registradas.</td></tr>';
        return;
    }
    
    tbody.innerHTML = suscripciones.map(s => {
        const cafe = s.cafeteria?.nombre || '—';
        const plan = s.plan?.nombre_plan || '—';
        const monto = s.monto ? `$${parseFloat(s.monto).toFixed(2)}` : '—';
        const fechaFin = new Date(s.fecha_fin).toLocaleDateString('es-ES', { day: 'numeric', month: 'short', year: 'numeric' });
        
        let badgePlan = `<span class="badge rounded-pill px-3 py-2" style="background: #FFF8E1; color: #FFA000; border: 1px solid #FFE082;">${plan}</span>`;
        let badgeEstado = `<span class="badge rounded-pill px-3 py-2" style="background: #E8F5E9; color: #2E7D32; border: 1px solid #A5D6A7;">● Pagado</span>`;
        if(s.estado_pago === 'cancelado') {
            badgeEstado = `<span class="badge rounded-pill px-3 py-2" style="background: #FFEBEE; color: #C62828; border: 1px solid #EF9A9A;">● Cancelado</span>`;
        }

        return `<tr class="${s.estado_pago === 'cancelado' ? 'opacity-75' : ''}">
            <td class="fw-bold" style="color: var(--black-primary); cursor: pointer; text-decoration: underline;" onclick="verDetalle(${s.cafe_id})">${cafe}</td>
            <td>${badgePlan}</td>
            <td class="fw-bold" style="color: var(--black-primary);">${monto}</td>
            <td style="color: var(--text-muted);">${fechaFin}</td>
            <td>${badgeEstado}</td>
            <td class="text-end">
                ${s.estado_pago !== 'cancelado' && s.cafeteria?.estado !== 'suspendida'
                    ? `<button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="cambiarEstado(${s.cafe_id}, 'suspendida')">Suspender</button>`
                    : `<button class="btn btn-sm btn-outline-success rounded-pill px-3" onclick="cambiarEstado(${s.cafe_id}, 'activa')">Reactivar</button>`
                }
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
        const gerente = c.gerente ? c.gerente.name + ' (' + c.gerente.email + ')' : 'Sin gerente';
        const plan = c.suscripcion_actual?.plan?.nombre_plan || 'Sin plan';
        
        body.innerHTML = `
            <div class="text-start">
                <div class="card border-0 bg-light rounded-4 mb-3">
                    <div class="card-body p-4">
                        <h6 class="text-muted small text-uppercase fw-bold mb-3" style="letter-spacing: 0.5px;">Información del Negocio</h6>
                        <div class="d-flex justify-content-between mb-2"><span class="text-muted">Nombre</span><span class="fw-bold text-dark">${c.nombre}</span></div>
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
                        ${c.comprobante_url ? `<a href="/storage/${c.comprobante_url.replace('public/', '')}" target="_blank" class="btn btn-outline-secondary w-100 rounded-pill"><i class="bi bi-file-earmark-text me-2"></i>Ver Comprobante de Pago</a>` : '<p class="text-muted small text-center m-0">Sin comprobante subido</p>'}
                    </div>
                </div>
            </div>
        `;

    } catch (e) {
        body.innerHTML = '<p class="text-danger">No pudimos conectar con el servidor. Verifica tu internet.</p>';
    }
}

// Init
cargarSuscripciones();
</script>
@endsection