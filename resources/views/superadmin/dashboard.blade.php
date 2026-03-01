@extends('superadmin.menu')

@section('title', 'Panel Maestro')

@section('content')

<style>
    /* Superadmin specific overrides if any, otherwise rely on estilos.css */
    .stat-card { border-radius: 16px; padding: 24px; border: 1px solid rgba(0,0,0,0.06); transition: transform 0.2s, box-shadow 0.2s; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    .stat-card h2 { font-size: 2.2rem; font-weight: 800; margin: 0; letter-spacing: -1px; }
    .comprobante-img { max-width: 100%; border-radius: 12px; max-height: 300px; object-fit: contain; }
    #overlay-loading { display:none; position:fixed; top:0;left:0;width:100%;height:100%; z-index:9999; align-items:center; justify-content:center; }
</style>

<!-- Loading overlay -->
<div id="overlay-loading" style="display:none !important;">
    <div class="text-center">
        <div class="spinner-border mb-3" style="width:3rem;height:3rem;"></div>
        <p class="fw-bold">Procesando...</p>
    </div>
</div>

<header class="mb-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
        <div>
            <h2 class="fw-bold">Panel de Control Maestro</h2>
            <p class="text-muted mb-0">Gestiona los negocios registrados en METRA.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn-admin-secondary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#nuevoNegocio">
                <i class="bi bi-plus-lg me-2"></i>Registrar manualmente
            </button>
        </div>
    </div>
</header>

<!-- STATS -->
<div class="row g-4 mb-5" id="stats-row">
    <div class="col-6 col-md-3">
        <div class="stat-card bg-white shadow-sm border-0 border-start border-4" style="border-color: var(--black-primary) !important;">
            <p class="text-muted small mb-2 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Total cafeterías</p>
            <h2 id="stat-total" class="text-dark">—</h2>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card bg-white shadow-sm border-0 border-start border-4 border-success">
            <p class="small mb-2 fw-bold text-uppercase text-success" style="letter-spacing: 0.5px;">Activas</p>
            <h2 id="stat-activas" class="text-dark">—</h2>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card bg-white shadow-sm border-0 border-start border-4 border-warning">
            <p class="small mb-2 fw-bold text-uppercase text-warning" style="letter-spacing: 0.5px;">Pendientes</p>
            <h2 id="stat-pendientes" class="text-dark">—</h2>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card bg-white shadow-sm border-0 border-start border-4 border-danger">
            <p class="small mb-2 fw-bold text-uppercase text-danger" style="letter-spacing: 0.5px;">En Revisión</p>
            <h2 id="stat-revision" class="text-dark">—</h2>
        </div>
    </div>
</div>

<!-- PENDIENTES DE REVISIÓN -->
<div class="premium-card p-4 mb-5" id="seccion-revision">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="fw-bold mb-0" style="color: var(--black-primary);">
            <span class="badge me-2 rounded-pill" id="badge-revision-count" style="background-color: var(--accent-gold); color: var(--black-primary); font-size:0.8rem; font-weight:700;"></span>
            Cafeterías en Revisión
        </h5>
    </div>
    <div id="tabla-revision">
        <div class="text-center py-4 text-muted">
            <div class="spinner-border spinner-border-sm me-2"></div>Cargando...
        </div>
    </div>
</div>

<!-- TODOS LOS NEGOCIOS -->
<div class="premium-card p-4">
    <h5 class="fw-bold mb-4" style="color: var(--black-primary);">Todos los Negocios</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr class="small text-muted text-uppercase">
                    <th>Negocio</th>
                    <th>Gerente</th>
                    <th>Plan</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-todos">
                <tr><td colspan="5" class="text-center text-muted py-4">
                    <div class="spinner-border spinner-border-sm me-2"></div>Cargando...
                </td></tr>
            </tbody>
        </table>
    </div>
</div>


<!-- MODAL: Nuevo Negocio (manual) -->
<div class="modal fade" id="nuevoNegocio" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 p-4">
                <h5 class="fw-bold m-0">Registrar Restaurante (Manual)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 pt-0">
                <!-- Alert removed manually to use SweetAlert instead -->
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nombre del Negocio</label>
                    <input type="text" class="form-control bg-light border-0 py-2" id="m-nombre" placeholder="Ej. Café Central" maxlength="100" required>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label small fw-bold">Nombre del Gerente</label>
                        <input type="text" class="form-control bg-light border-0 py-2" id="m-gerente-name" placeholder="Nombre completo" maxlength="100" required>
                    </div>
                    <div class="col">
                        <label class="form-label small fw-bold">Correo del Gerente</label>
                        <input type="email" class="form-control bg-light border-0 py-2" id="m-gerente-email" placeholder="gerente@cafe.com" maxlength="255" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Plan de Suscripción Asignado</label>
                    <select class="form-select bg-light border-0 py-2" id="m-plan">
                        <option value="">Cargando planes...</option>
                    </select>
                </div>
                <button type="button" class="btn-metra-main w-100 py-2 fw-bold" onclick="crearNegocioManual()">
                    Crear Cuenta de Negocio
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL: Ver Comprobante -->
<div class="modal fade" id="modalComprobante" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 p-4">
                <h5 class="fw-bold m-0"><i class="bi bi-receipt me-2"></i>Comprobante de Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 pt-0 text-center" id="modal-comprobante-body">
                <div class="spinner-border text-primary" role="status"></div>
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

// ────────────────────────────────────────────
// Cargar todas las cafeterías y derivar stats
// ────────────────────────────────────────────
async function cargarDashboard() {
    try {
        const [resCafes, resSols] = await Promise.all([
            fetch(`${API}/superadmin/cafeterias`, { headers: authHeaders() }),
            fetch(`${API}/superadmin/solicitudes`, { headers: authHeaders() })
        ]);

        if (resCafes.status === 401 || resSols.status === 401) {
             localStorage.removeItem('token');
             window.location.href = '/login';
             return;
        }

        if (!resCafes.ok || !resSols.ok) {
             throw new Error("El servidor respondió con un error");
        }

        const jsonCafes = await resCafes.json();
        const jsonSols  = await resSols.json();
        
        const todos = jsonCafes.data || [];
        const enRevision = jsonSols.data || [];

        // Stats
        const activas    = todos.filter(c => c.estado === 'activa').length;
        const pendientes = todos.filter(c => c.estado === 'pendiente').length;
        const revision   = enRevision.length;

        document.getElementById('stat-total').textContent    = todos.length;
        document.getElementById('stat-activas').textContent  = activas;
        document.getElementById('stat-revision').textContent = revision;
        document.getElementById('stat-pendientes').textContent = pendientes;

        if (revision > 0) {
            document.getElementById('badge-revision-count').textContent = `${revision} nuevas`;
        } else {
            document.getElementById('badge-revision-count').textContent = '';
        }

        // Tabla revisión
        renderTablaRevision(enRevision);

        // Tabla todos
        renderTablaTodos(todos);

    } catch (e) {
        console.error('API Error:', e);
        document.getElementById('tabla-revision').innerHTML =
            '<div class="text-danger text-center py-3">Ocurrió un problema al procesar la solicitud. Intenta nuevamente.</div>';
        
        document.getElementById('tabla-todos').innerHTML = 
            '<tr><td colspan="5" class="text-danger text-center py-4">Ocurrió un problema al procesar la solicitud. Intenta nuevamente.</td></tr>';
    } finally {
        document.getElementById('overlay-loading').style.setProperty('display', 'none', 'important');
    }
}

function badgeEstado(estado) {
    const map = {
        'activa':     'badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2',
        'pendiente':  'badge rounded-pill bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 px-3 py-2',
        'en_revision':'badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2',
        'suspendida': 'badge rounded-pill bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3 py-2',
    };
    const labels = {
        'activa':'● Activa','pendiente':'● Pendiente',
        'en_revision':'● En Revisión','suspendida':'● Suspendida',
    };
    return `<span class="${map[estado] || 'badge bg-light text-dark'}">${labels[estado] || estado}</span>`;
}

function renderTablaRevision(cafeterias) {
    const el = document.getElementById('tabla-revision');
    if (!cafeterias.length) {
        el.innerHTML = `<div class="text-center text-muted py-4">
            <i class="bi bi-check-circle fs-2 text-success d-block mb-2"></i>
            No hay cafeterías pendientes de revisión.
        </div>`;
        return;
    }
    el.innerHTML = `
    <div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr class="small text-muted text-uppercase">
                <th>Negocio</th><th>Gerente</th><th>Plan</th><th>Comprobante</th><th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            ${cafeterias.map(c => {
                const gerente = c.gerente ? `${c.gerente.name}<br><small class="text-muted">${c.gerente.email}</small>` : '—';
                const plan    = c.suscripcion_actual?.plan?.nombre_plan || '—';
                const comp    = c.comprobante_url
                    ? `<button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="verComprobante(${c.id})">
                        <i class="bi bi-receipt me-1"></i>Ver
                       </button>`
                    : '<span class="text-muted small">No subido</span>';
                return `<tr>
                    <td class="fw-bold">${c.nombre}</td>
                    <td>${gerente}</td>
                    <td>${plan}</td>
                    <td>${comp}</td>
                    <td class="text-end">
                        <button type="button" class="btn btn-sm btn-success rounded-pill px-3 me-1" onclick="accionSolicitud(${c.id}, 'aprobar')">
                            <i class="bi bi-check2 me-1"></i>Aprobar
                        </button>
                        <button type="button" class="btn btn-sm btn-danger rounded-pill px-3" onclick="accionSolicitud(${c.id}, 'rechazar')">
                            <i class="bi bi-x me-1"></i>Rechazar
                        </button>
                    </td>
                </tr>`;
            }).join('')}
        </tbody>
    </table>
    </div>`;
}

function renderTablaTodos(cafeterias) {
    const tbody = document.getElementById('tabla-todos');
    if (!cafeterias.length) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">No hay cafeterías registradas.</td></tr>';
        return;
    }
    tbody.innerHTML = cafeterias.map(c => {
        const gerente = c.gerente ? c.gerente.name : '—';
        const plan    = c.suscripcion_actual?.plan?.nombre_plan || '—';
        return `<tr>
            <td class="fw-bold">${c.nombre}</td>
            <td>${gerente}</td>
            <td>${plan}</td>
            <td>${badgeEstado(c.estado)}</td>
            <td class="text-end">
                ${c.estado === 'en_revision'
                    ? `<button type="button" class="btn btn-sm btn-success rounded-pill px-3 me-1" onclick="accionSolicitud(${c.id},'aprobar')">
                           <i class="bi bi-check2 me-1"></i>Aprobar
                       </button>
                       <button type="button" class="btn btn-sm btn-danger rounded-pill px-3" onclick="accionSolicitud(${c.id},'rechazar')">
                           <i class="bi bi-x me-1"></i>Rechazar
                       </button>`
                    : `<button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3"
                              onclick="accionSolicitud(${c.id},'${c.estado === 'activa' ? 'suspender' : 'aprobar'}')">
                           ${c.estado === 'activa' ? 'Suspender' : 'Activar'}
                       </button>`
                }
            </td>
        </tr>`;
    }).join('');
}

// ────────────────────────────────────────────
// Acciones Solicitudes (Aprobar / Rechazar)
// ────────────────────────────────────────────
// ────────────────────────────────────────────
// Acciones Solicitudes (Aprobar / Rechazar)
// ────────────────────────────────────────────
function accionSolicitud(cafeteriaId, accion) {
    const isActivar = accion === 'aprobar';
    const isSuspender = accion === 'suspender';
    
    let finalTexto = 'Rechazar';
    if (isActivar) finalTexto = 'Aprobar';
    if (isSuspender) finalTexto = 'Suspender';

    const colorBtn = isActivar ? '#198754' : '#dc3545'; // success or danger
    const endpointAccion = isSuspender ? 'rechazar' : accion; // backend rechazar suspends

    Swal.fire({
        title: `¿Deseas ${finalTexto.toLowerCase()} este negocio?`,
        text: 'Esta acción notificará al usuario seleccionado.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: colorBtn,
        cancelButtonColor: '#6c757d',
        confirmButtonText: `Sí, ${finalTexto.toLowerCase()}`,
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            document.getElementById('overlay-loading').style.setProperty('display', 'flex', 'important');
            try {
                const res = await fetch(`${API}/superadmin/solicitudes/${cafeteriaId}/${endpointAccion}`, {
                    method: 'PATCH',
                    headers: authHeaders()
                });
                
                if (!res.ok) { 
                    if(res.status >= 500) {
                        throw new Error('Ocurrió un problema al procesar la solicitud. Intenta nuevamente.');
                    }
                    throw new Error('Algo salió mal. Intenta de nuevo.');
                }
                
                await cargarDashboard();
                Swal.fire('¡Listo!', `Cafetería ${finalTexto === 'Aprobar' ? 'aprobada' : (finalTexto === 'Suspender' ? 'suspendida' : 'rechazada')} correctamente.`, 'success');
                
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



// ────────────────────────────────────────────
// Ver comprobante
// ────────────────────────────────────────────
async function verComprobante(cafeteriaId) {
    const modal = new bootstrap.Modal(document.getElementById('modalComprobante'));
    document.getElementById('modal-comprobante-body').innerHTML =
        '<div class="spinner-border text-primary" role="status"></div>';
    modal.show();

    try {
        const url = `${API}/superadmin/cafeterias/${cafeteriaId}/comprobante`;
        
        // Since the backend now handles the authorized view and returns the file,
        // we can fetch with auth headers to check if it exists, then use the URL with a blob or just an iframe/image
        // However, for simplicity and since we are using Bearer tokens, we might need a blob approach
        // or just rely on the backend returning the secure Cloudinary URL in a JSON if we update it.
        // BUT the requirement says: "consumir endpoint de backend para ver comprobante."
        
        const response = await fetch(url, { headers: authHeaders() });
        if (!response.ok) {
            throw new Error('Error al cargar el comprobante');
        }
        
        const blob = await response.blob();
        const blobUrl = URL.createObjectURL(blob);
        const contentType = response.headers.get('content-type');
        
        if (contentType && contentType.includes('pdf')) {
            document.getElementById('modal-comprobante-body').innerHTML = `
                <a href="${blobUrl}" target="_blank" class="btn btn-metra-main px-4" style="padding: 10px 20px;">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Abrir PDF
                </a>
                <p class="mt-3 small text-muted text-center">El navegador abrirá el PDF en una pestaña nueva.</p>
            `;
        } else {
            document.getElementById('modal-comprobante-body').innerHTML = `
                <img src="${blobUrl}" class="comprobante-img" alt="Comprobante" style="max-width: 100%; max-height: 500px;">
                <div class="mt-3">
                    <a href="${blobUrl}" download="comprobante" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        <i class="bi bi-download me-1"></i>Descargar
                    </a>
                </div>
            `;
        }
    } catch (e) {
        document.getElementById('modal-comprobante-body').innerHTML = '<p class="text-danger">No pudimos cargar el comprobante. Intenta de nuevo.</p>';
    }
}

// ────────────────────────────────────────────
// Crear negocio manual (superadmin)
// ────────────────────────────────────────────
async function crearNegocioManual() {
    const nombre = document.getElementById('m-nombre').value.trim();
    const name   = document.getElementById('m-gerente-name').value.trim();
    const email  = document.getElementById('m-gerente-email').value.trim();
    const plan_id = document.getElementById('m-plan').value;

    if (!nombre || !name || !email || !plan_id) {
        Swal.fire({ title: 'Atención', text: 'Todos los campos son requeridos, incluyendo el plan.', icon: 'warning', confirmButtonColor: '#382C26' });
        return;
    }
    
    document.getElementById('overlay-loading').style.setProperty('display', 'flex', 'important');

    try {
        const res  = await fetch(`${API}/superadmin/cafeterias`, {
            method: 'POST',
            headers: authHeaders(),
            body: JSON.stringify({ nombre, gerente: { name, email } }),
        });
        
        if (!res.ok) {
            if(res.status >= 500) throw new Error('Ocurrió un problema al procesar la solicitud. Intenta nuevamente.');
            throw new Error('Algo salió mal. Intenta de nuevo.');
        }

        const json = await res.json();
        const cafeId = json.data.cafeteria.id;
        const resPlan = await fetch(`${API}/superadmin/suscripciones`, {
            method: 'POST',
            headers: authHeaders(),
            body: JSON.stringify({ cafe_id: cafeId, plan_id: plan_id })
        });

        bootstrap.Modal.getInstance(document.getElementById('nuevoNegocio')).hide();
        document.getElementById('m-nombre').value = '';
        document.getElementById('m-gerente-name').value = '';
        document.getElementById('m-gerente-email').value = '';
        await cargarDashboard();
        Swal.fire({ title: '¡Éxito!', text: 'El negocio ha sido registrado.', icon: 'success', confirmButtonColor: '#382C26' });
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

async function cargarPlanesModal() {
    try {
        const res = await fetch(`${API}/superadmin/planes`, { headers: authHeaders() });
        const json = await res.json();
        if (res.ok) {
            const select = document.getElementById('m-plan');
            const planesActivos = json.data.filter(p => p.estado === true || p.estado === 1);
            select.innerHTML = '<option value="">Selecciona un plan...</option>' + 
                planesActivos.map(p => `<option value="${p.id}">${p.nombre_plan} ($${p.precio})</option>`).join('');
        }
    } catch (e) {
        console.error('Error cargando planes modal', e);
    }
}

// Init
cargarDashboard();
cargarPlanesModal();
</script>

@endsection