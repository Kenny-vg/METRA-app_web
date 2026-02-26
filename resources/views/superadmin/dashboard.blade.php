@extends('superadmin.menu')

@section('title', 'Panel Maestro')

@section('content')

<style>
    /* Superadmin specific overrides if any, otherwise rely on estilos.css */
    .stat-card { border-radius: 16px; padding: 24px; border: 1px solid rgba(0,0,0,0.06); }
    .stat-card h2 { font-size: 2.2rem; font-weight: 800; margin: 0; letter-spacing: -1px; }
    .comprobante-img { max-width: 100%; border-radius: 12px; max-height: 300px; object-fit: contain; }
    #overlay-loading { display:none; position:fixed; top:0;left:0;width:100%;height:100%;
        background:rgba(10,10,10,0.5); z-index:9999; align-items:center; justify-content:center; }
</style>

<!-- Loading overlay -->
<div id="overlay-loading" class="d-flex">
    <div class="text-center text-white">
        <div class="spinner-border text-light mb-3" style="width:3rem;height:3rem;"></div>
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
        <div class="stat-card bg-white shadow-sm">
            <p class="text-muted small mb-1">Total cafeterías</p>
            <h2 id="stat-total">—</h2>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card shadow-sm" style="background:#d1fae5;">
            <p class="text-muted small mb-1" style="color:#065f46!important;">Activas</p>
            <h2 id="stat-activas" style="color:#065f46;">—</h2>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card shadow-sm" style="background:#fef3c7;">
            <p class="small mb-1 fw-semibold" style="color:#92400e;">Pendientes</p>
            <h2 id="stat-pendientes" style="color:#92400e;">—</h2>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card shadow-sm" style="background:#fef3c7;">
            <p class="small mb-1 fw-semibold" style="color:#92400e;">Pendientes</p>
            <h2 id="stat-pendientes" style="color:#92400e;">—</h2>
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
                <div class="alert alert-danger d-none rounded-3" id="modal-alert"></div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nombre del Negocio</label>
                    <input type="text" class="form-control bg-light border-0 py-2" id="m-nombre" placeholder="Ej. Café Central">
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label small fw-bold">Nombre del Gerente</label>
                        <input type="text" class="form-control bg-light border-0 py-2" id="m-gerente-name" placeholder="Nombre completo">
                    </div>
                    <div class="col">
                        <label class="form-label small fw-bold">Correo del Gerente</label>
                        <input type="email" class="form-control bg-light border-0 py-2" id="m-gerente-email" placeholder="gerente@cafe.com">
                    </div>
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
const API = '/METRA-app_web/api';
let authToken = localStorage.getItem('metra_token') || sessionStorage.getItem('metra_token') || '';

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
        const res  = await fetch(`${API}/superadmin/cafeterias`, { headers: authHeaders() });
        const json = await res.json();
        const todos = json.data || [];

        // Stats
        const activas    = todos.filter(c => c.estado === 'activa').length;
        const revision   = todos.filter(c => c.estado === 'en_revision').length;
        const pendientes = todos.filter(c => c.estado === 'pendiente').length;

        document.getElementById('stat-total').textContent    = todos.length;
        document.getElementById('stat-activas').textContent  = activas;
        document.getElementById('stat-revision').textContent = revision;
        document.getElementById('stat-pendientes').textContent = pendientes;

        if (revision > 0) {
            document.getElementById('badge-revision-count').textContent = `${revision} nuevas`;
        }

        // Tabla revisión
        const enRevision = todos.filter(c => c.estado === 'en_revision');
        renderTablaRevision(enRevision);

        // Tabla todos
        renderTablaTodos(todos);

    } catch (e) {
        document.getElementById('tabla-revision').innerHTML =
            '<div class="text-danger text-center py-3">Error al cargar datos. Verifica tu sesión.</div>';
    }
}

function badgeEstado(estado) {
    const map = {
        'activa':     'badge-activa',
        'pendiente':  'badge-pendiente',
        'en_revision':'badge-revision',
        'suspendida': 'badge-suspendida',
    };
    const labels = {
        'activa':'Activa','pendiente':'Pendiente',
        'en_revision':'En Revisión','suspendida':'Suspendida',
    };
    return `<span class="badge-estado ${map[estado] || ''}">${labels[estado] || estado}</span>`;
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
                        <button class="btn btn-sm btn-success rounded-pill px-3 me-1" onclick="cambiarEstado(${c.id}, 'activa')">
                            <i class="bi bi-check2 me-1"></i>Aprobar
                        </button>
                        <button class="btn btn-sm btn-danger rounded-pill px-3" onclick="cambiarEstado(${c.id}, 'suspendida')">
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
                    ? `<button class="btn btn-sm btn-success rounded-pill px-3 me-1" onclick="cambiarEstado(${c.id},'activa')">Aprobar</button>
                       <button class="btn btn-sm btn-danger rounded-pill px-3" onclick="cambiarEstado(${c.id},'suspendida')">Rechazar</button>`
                    : `<button class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="cambiarEstado(${c.id},'${c.estado === 'activa' ? 'suspendida' : 'activa'}')">
                        ${c.estado === 'activa' ? 'Suspender' : 'Activar'}
                       </button>`
                }
            </td>
        </tr>`;
    }).join('');
}

// ────────────────────────────────────────────
// Cambiar estado
// ────────────────────────────────────────────
async function cambiarEstado(cafeteriaId, nuevoEstado) {
    const accion = nuevoEstado === 'activa' ? 'APROBAR' : 'RECHAZAR';
    if (!confirm(`¿Deseas ${accion} esta cafetería?`)) return;

    document.getElementById('overlay-loading').style.display = 'flex';
    try {
        const res  = await fetch(`${API}/superadmin/cafeterias/${cafeteriaId}/estado`, {
            method: 'PATCH',
            headers: authHeaders(),
            body: JSON.stringify({ estado: nuevoEstado }),
        });
        const json = await res.json();
        if (!res.ok) { alert(json.message || 'Error al cambiar estado.'); return; }
        await cargarDashboard();
    } catch (e) {
        alert('Error de conexión.');
    } finally {
        document.getElementById('overlay-loading').style.display = 'none';
    }
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
        const res  = await fetch(`${API}/superadmin/cafeterias/${cafeteriaId}/comprobante`, { headers: authHeaders() });
        const json = await res.json();
        if (!res.ok || !json.data?.comprobante_url) {
            document.getElementById('modal-comprobante-body').innerHTML =
                '<p class="text-danger">No se pudo cargar el comprobante.</p>';
            return;
        }
        const url = json.data.comprobante_url;
        const isPdf = url.toLowerCase().includes('.pdf');
        document.getElementById('modal-comprobante-body').innerHTML = isPdf
            ? `<a href="${url}" target="_blank" class="btn btn-metra-main px-4" style="padding: 10px 20px;">
                <i class="bi bi-file-earmark-pdf me-2"></i>Abrir PDF
               </a>`
            : `<img src="${url}" class="comprobante-img" alt="Comprobante">`;
    } catch (e) {
        document.getElementById('modal-comprobante-body').innerHTML = '<p class="text-danger">Error de conexión.</p>';
    }
}

// ────────────────────────────────────────────
// Crear negocio manual (superadmin)
// ────────────────────────────────────────────
async function crearNegocioManual() {
    const nombre = document.getElementById('m-nombre').value.trim();
    const name   = document.getElementById('m-gerente-name').value.trim();
    const email  = document.getElementById('m-gerente-email').value.trim();
    const alert  = document.getElementById('modal-alert');

    if (!nombre || !name || !email) {
        alert.textContent = 'Todos los campos son requeridos.';
        alert.classList.remove('d-none');
        return;
    }
    alert.classList.add('d-none');

    try {
        const res  = await fetch(`${API}/superadmin/cafeterias`, {
            method: 'POST',
            headers: authHeaders(),
            body: JSON.stringify({ nombre, gerente: { name, email } }),
        });
        const json = await res.json();
        if (!res.ok) {
            const msgs = json.errors ? Object.values(json.errors).flat().join(' | ') : json.message;
            alert.textContent = msgs;
            alert.classList.remove('d-none');
            return;
        }
        bootstrap.Modal.getInstance(document.getElementById('nuevoNegocio')).hide();
        document.getElementById('m-nombre').value = '';
        document.getElementById('m-gerente-name').value = '';
        document.getElementById('m-gerente-email').value = '';
        await cargarDashboard();
    } catch (e) {
        alert.textContent = 'Error de conexión.';
        alert.classList.remove('d-none');
    }
}

// Init
cargarDashboard();
</script>

@endsection