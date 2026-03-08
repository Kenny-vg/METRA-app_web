@extends('admin.menu')
@section('title', 'Eventos y Promos')

@section('content')
<header class="mb-5 border-bottom pb-4" style="border-color: var(--border-light) !important;">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Eventos y Promos</h2>
            <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Gestiona las promociones y los motivos de celebración para tus clientes.</p>
        </div>
    </div>
</header>

<ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
    <li class="nav-item">
        <button class="nav-link active rounded-pill px-4" id="promociones-tab" data-bs-toggle="pill" data-bs-target="#promociones" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
            <i class="bi bi-megaphone me-2"></i>Promociones Activas
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link rounded-pill px-4" id="ocasiones-tab" data-bs-toggle="pill" data-bs-target="#ocasiones" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
            <i class="bi bi-balloon me-2"></i>Ocasiones Especiales
        </button>
    </li>
</ul>

<div class="tab-content">
    <!-- PROMOCIONES -->
    <div class="tab-pane fade show active" id="promociones">
        <div class="d-flex justify-content-end mb-4">
            <button class="btn-metra-main" onclick="abrirModalNuevaPromo()" style="padding: 12px 24px; font-size: 0.9rem;">
                <i class="bi bi-plus-lg me-2"></i>Nueva Promoción
            </button>
        </div>

<!-- Métricas rápidas -->
<div class="row g-4 mb-5">
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 p-4 h-100 premium-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="small fw-bold text-uppercase" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.7rem;">Activas</span>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: var(--off-white);">
                    <i class="bi bi-megaphone-fill" style="color: var(--accent-gold);"></i>
                </div>
            </div>
            <h3 class="fw-bold mb-0" style="color: var(--black-primary); font-size: 2.2rem; letter-spacing: -1px;" id="contador-activas">—</h3>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card border-0 p-4 h-100 premium-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="small fw-bold text-uppercase" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.7rem;">Total creadas</span>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: var(--off-white);">
                    <i class="bi bi-collection-fill" style="color: var(--black-primary);"></i>
                </div>
            </div>
            <h3 class="fw-bold mb-0" style="color: var(--black-primary); font-size: 2.2rem; letter-spacing: -1px;" id="contador-total">—</h3>
        </div>
    </div>
</div>

<!-- Listado de promociones -->
<div class="premium-card p-4 p-lg-5">
    <h5 class="fw-bold mb-4" style="color: var(--black-primary);">Tus promociones</h5>

    <div id="promos-loading" class="text-center py-5 text-muted">
        <div class="spinner-border spinner-border-sm me-2"></div> Cargando promociones...
    </div>

    <div id="promos-lista" class="row g-4" style="display:none;"></div>

    <div id="promos-empty" class="text-center py-5" style="display:none;">
        <i class="bi bi-megaphone display-4 d-block mb-3" style="color: var(--border-light);"></i>
        <p class="fw-bold mb-1" style="color: var(--black-primary);">Aún no tienes promociones</p>
        <p class="text-muted small">Crea tu primera promoción para atraer más clientes.</p>
        <button class="btn-metra-main mt-2" onclick="abrirModalNuevaPromo()" style="padding: 10px 22px; font-size: 0.85rem;">
            <i class="bi bi-plus me-2"></i>Crear primera promoción
        </button>
    </div>
</div>
</div>

    <!-- OCASIONES ESPECIALES -->
    <div class="tab-pane fade" id="ocasiones">
        <div class="card border-0 p-4 p-md-5 premium-card">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Ocasiones Especiales</h5>
                <button class="btn-admin-primary" onclick="openModalOcasion()">
                    <i class="bi bi-plus-lg me-2"></i>Nueva Ocasión
                </button>
            </div>
            <div class="table-responsive">
                <table class="table-metra mt-2">
                    <thead>
                        <tr>
                            <th>Motivo / Celebración</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-ocasiones-body">
                        <!-- Ocasiones cargadas por JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal nueva/editar promoción -->
<div class="modal fade" id="modalPromo" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg" style="overflow: hidden;">
            <div class="modal-header border-0 px-5 pt-5 pb-3" style="background: var(--off-white);">
                <h5 class="modal-title fw-bold" style="color: var(--black-primary);" id="modalPromoTitulo">Nueva Promoción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-5 py-4">
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px; color: var(--text-muted);">Título de la promoción</label>
                        <input type="text" id="promoTitulo" class="form-control form-control-lg" style="border-radius: 10px; border-color: var(--border-light);" placeholder="Ej: Cumpleaños Especial">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px; color: var(--text-muted);">Descripción</label>
                        <textarea id="promoDescripcion" class="form-control" rows="3" style="border-radius: 10px; border-color: var(--border-light);" placeholder="Describe brevemente la promoción o evento especial..."></textarea>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px; color: var(--text-muted);">Fecha inicio</label>
                        <input type="date" id="promoFechaInicio" class="form-control" style="border-radius: 10px; border-color: var(--border-light);">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px; color: var(--text-muted);">Fecha fin</label>
                        <input type="date" id="promoFechaFin" class="form-control" style="border-radius: 10px; border-color: var(--border-light);">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px; color: var(--text-muted);">Tipo de evento</label>
                        <select id="promoTipo" class="form-select" style="border-radius: 10px; border-color: var(--border-light);">
                            <option value="">Selecciona un tipo</option>
                            <option value="cumpleanos">🎂 Cumpleaños</option>
                            <option value="aniversario">💍 Aniversario</option>
                            <option value="temporada">🌟 Temporada especial</option>
                            <option value="descuento">💰 Descuento</option>
                            <option value="evento">🎉 Evento</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 px-5 pb-5 pt-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn-metra-main" onclick="guardarPromo()" style="padding: 12px 28px;">
                    <i class="bi bi-check2 me-2"></i>Guardar Promoción
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL OCASION -->
<div class="modal fade" id="modalOcasion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold m-0" id="modalOcasionTitle" style="color: var(--black-primary); letter-spacing: -0.5px;">Nueva Ocasión Especial</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <form id="formOcasion">
                    <input type="hidden" id="ocasion-id">
                    <p class="small text-muted mb-4">Brinde a sus clientes motivos especiales para celebrar y reservar con ustedes.</p>
                    <div class="mb-3">
                        <label class="form-label small fw-bold" style="color: var(--text-main); letter-spacing: 0.5px;">NOMBRE DE LA OCASIÓN</label>
                        <input type="text" id="ocasion-nombre" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" placeholder="Ej. Cumpleaños" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold" style="color: var(--text-main); letter-spacing: 0.5px;">DESCRIPCIÓN (Opcional)</label>
                        <textarea id="ocasion-descripcion" class="form-control border-0 shadow-sm rounded-3" rows="3" style="background: var(--off-white);" placeholder="Detalles o cortesías que incluyen..."></textarea>
                    </div>
                    <button type="submit" class="btn-admin-primary w-100 py-3 mt-3">Guardar Ocasión</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const token = localStorage.getItem('token');
let promoEditandoId = null;

// Promociones demo (frontend-only por ahora)
let promosDemo = [
    {
        id: 1,
        titulo: 'Cumpleaños Especial',
        descripcion: 'Celebra tu día con nosotros. Mesa decorada y postre de cortesía para el festejado.',
        tipo: 'cumpleanos',
        fechaInicio: '2026-01-01',
        fechaFin: '2026-12-31',
        activa: true
    },
    {
        id: 2,
        titulo: 'Tarde de Aniversario',
        descripcion: 'Mesa reservada con ambiente especial para celebrar su aniversario. Previa reservación.',
        tipo: 'aniversario',
        fechaInicio: '2026-01-01',
        fechaFin: '2026-12-31',
        activa: true
    }
];

const tipoIconos = {
    cumpleanos: '🎂',
    aniversario: '💍',
    temporada: '🌟',
    descuento: '💰',
    evento: '🎉'
};

function renderPromos() {
    const lista = document.getElementById('promos-lista');
    const empty = document.getElementById('promos-empty');
    const loading = document.getElementById('promos-loading');

    loading.style.display = 'none';
    document.getElementById('contador-activas').textContent = promosDemo.filter(p=>p.activa).length;
    document.getElementById('contador-total').textContent = promosDemo.length;

    if (!promosDemo.length) {
        lista.style.display = 'none';
        empty.style.display = 'block';
        return;
    }

    lista.style.display = 'flex';
    empty.style.display = 'none';

    lista.innerHTML = promosDemo.map(p => `
        <div class="col-12 col-md-6">
            <div class="bg-white rounded-4 border p-4 h-100" style="border-color: var(--border-light) !important;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="fs-4">${tipoIconos[p.tipo] || '📌'}</span>
                        <span class="badge rounded-pill ms-2 ${p.activa ? '' : 'bg-secondary'}" style="${p.activa ? 'background: rgba(25,135,84,0.1); color: #198754; border: 1px solid rgba(25,135,84,0.2);' : ''} font-size: 0.7rem;">${p.activa ? 'Activa' : 'Inactiva'}</span>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-secondary rounded-pill" onclick="editarPromo(${p.id})" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger rounded-pill" onclick="eliminarPromo(${p.id})" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                <h6 class="fw-bold mb-2" style="color: var(--black-primary);">${p.titulo}</h6>
                <p class="text-muted small mb-3">${p.descripcion}</p>
                <p class="small mb-0" style="color: var(--text-muted);"><i class="bi bi-calendar3 me-1" style="color: var(--accent-gold);"></i>${p.fechaInicio} → ${p.fechaFin}</p>
            </div>
        </div>
    `).join('');
}

function abrirModalNuevaPromo() {
    promoEditandoId = null;
    document.getElementById('modalPromoTitulo').textContent = 'Nueva Promoción';
    document.getElementById('promoTitulo').value = '';
    document.getElementById('promoDescripcion').value = '';
    document.getElementById('promoFechaInicio').value = '';
    document.getElementById('promoFechaFin').value = '';
    document.getElementById('promoTipo').value = '';
    new bootstrap.Modal(document.getElementById('modalPromo')).show();
}

function editarPromo(id) {
    const p = promosDemo.find(x => x.id === id);
    if (!p) return;
    promoEditandoId = id;
    document.getElementById('modalPromoTitulo').textContent = 'Editar Promoción';
    document.getElementById('promoTitulo').value = p.titulo;
    document.getElementById('promoDescripcion').value = p.descripcion;
    document.getElementById('promoFechaInicio').value = p.fechaInicio;
    document.getElementById('promoFechaFin').value = p.fechaFin;
    document.getElementById('promoTipo').value = p.tipo;
    new bootstrap.Modal(document.getElementById('modalPromo')).show();
}

function guardarPromo() {
    const titulo = document.getElementById('promoTitulo').value.trim();
    if (!titulo) { Swal.fire('Error', 'El título es requerido.', 'error'); return; }

    const data = {
        id: promoEditandoId || Date.now(),
        titulo,
        descripcion: document.getElementById('promoDescripcion').value.trim(),
        fechaInicio: document.getElementById('promoFechaInicio').value,
        fechaFin: document.getElementById('promoFechaFin').value,
        tipo: document.getElementById('promoTipo').value,
        activa: true
    };

    if (promoEditandoId) {
        const idx = promosDemo.findIndex(x => x.id === promoEditandoId);
        promosDemo[idx] = data;
    } else {
        promosDemo.push(data);
    }

    bootstrap.Modal.getInstance(document.getElementById('modalPromo')).hide();
    renderPromos();
    Swal.fire({ icon: 'success', title: 'Guardado', text: 'Promoción guardada correctamente.', timer: 2000, showConfirmButton: false });
}

function eliminarPromo(id) {
    Swal.fire({ title: '¿Eliminar promoción?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Sí, eliminar', cancelButtonText: 'Cancelar', confirmButtonColor: '#dc3545' }).then(r => {
        if (r.isConfirmed) {
            promosDemo = promosDemo.filter(p => p.id !== id);
            renderPromos();
        }
    });
}

// --- OCASIONES ESPECIALES ---
const API_URL = '/api/gerente';
const headers = () => ({
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': `Bearer ${token}`
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

let modalOcasionInst;

async function loadOcasiones() {
    try {
        const res = await fetch(`${API_URL}/ocasiones`, { headers: headers() });
        if (!res.ok) throw new Error('Error al cargar ocasiones especiales');
        
        const response = await res.json();
        const ocasiones = Array.isArray(response) ? response : (response.data || []);
        
        const tbody = document.getElementById('tabla-ocasiones-body');
        tbody.innerHTML = '';
        
        ocasiones.forEach(o => {
            const opacityClass = o.activo ? '' : 'opacity-50';
            const bgClass = o.activo ? '' : 'table-secondary';
            const badge = !o.activo ? `<span class="badge bg-secondary ms-2 text-xs">Inactivo</span>` : '';
            const actions = o.activo 
                ? `<button class="btn btn-sm btn-outline-dark rounded-circle me-1" onclick="editOcasion(${o.id}, '${o.nombre}', '${o.descripcion || ''}')" title="Editar"><i class="bi bi-pencil"></i></button>
                   <button class="btn btn-sm btn-outline-danger rounded-circle" onclick="deleteOcasion(${o.id})" title="Desactivar"><i class="bi bi-trash"></i></button>`
                : `<button class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" onclick="reactivateOcasion(${o.id})" title="Reactivar"><i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar</button>`;

            tbody.innerHTML += `
                <tr class="${bgClass} ${opacityClass}">
                    <td>
                        <div class="fw-bold" style="color: var(--black-primary);">${o.nombre} ${badge}</div>
                        <div class="small text-muted text-truncate" style="max-width: 300px;">${o.descripcion || 'Sin descripción'}</div>
                    </td>
                    <td class="text-end align-middle">
                        ${actions}
                    </td>
                </tr>
            `;
        });
    } catch (error) {
        console.error(error);
        showToast('error', 'No se pudieron cargar las ocasiones especiales');
    }
}

function openModalOcasion() {
    document.getElementById('formOcasion').reset();
    document.getElementById('ocasion-id').value = '';
    document.getElementById('modalOcasionTitle').innerText = 'Nueva Ocasión Especial';
    modalOcasionInst.show();
}

function editOcasion(id, nombre, descripcion) {
    document.getElementById('ocasion-id').value = id;
    document.getElementById('ocasion-nombre').value = nombre;
    document.getElementById('ocasion-descripcion').value = descripcion;
    document.getElementById('modalOcasionTitle').innerText = 'Editar Ocasión Especial';
    modalOcasionInst.show();
}

document.getElementById('formOcasion').addEventListener('submit', async (e) => {
    e.preventDefault();
    const id = document.getElementById('ocasion-id').value;
    const nombre = document.getElementById('ocasion-nombre').value;
    const descripcion = document.getElementById('ocasion-descripcion').value;
    
    const method = id ? 'PUT' : 'POST';
    const url = id ? `${API_URL}/ocasiones/${id}` : `${API_URL}/ocasiones`;

    try {
        const res = await fetch(url, {
            method,
            headers: headers(),
            body: JSON.stringify({ nombre, descripcion })
        });

        if (res.ok) {
            showToast('success', id ? 'Ocasión actualizada' : 'Ocasión creada');
            modalOcasionInst.hide();
            loadOcasiones();
        } else {
            const errorData = await res.json();
            Swal.fire('Error', errorData.message || 'Error al guardar ocasión especial', 'error');
        }
    } catch (error) {
        Swal.fire('Error', 'Error de conexión', 'error');
    }
});

async function deleteOcasion(id) {
    Swal.fire({
        title: '¿Desactivar Ocasión?',
        text: 'Esta ocasión ya no aparecerá como opción al reservar.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, desactivar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await fetch(`${API_URL}/ocasiones/${id}`, { method: 'DELETE', headers: headers() });
                if (res.ok) {
                    showToast('success', 'Ocasión desactivada');
                    loadOcasiones();
                } else {
                    const err = await res.json();
                    Swal.fire('Error', err.message || 'Error al desactivar ocasión', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Error de conexión', 'error');
            }
        }
    });
}

async function reactivateOcasion(id) {
    Swal.fire({
        title: '¿Reactivar Ocasión?',
        text: 'Esta ocasión volverá a estar disponible para reservaciones.',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, reactivar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await fetch(`${API_URL}/ocasiones/${id}/activar`, { method: 'PATCH', headers: headers() });
                if (res.ok) {
                    showToast('success', 'Ocasión reactivada');
                    loadOcasiones();
                } else {
                    const err = await res.json();
                    Swal.fire('Error', err.message || 'Error al reactivar ocasión', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Error de conexión', 'error');
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    setTimeout(renderPromos, 400);
    modalOcasionInst = new bootstrap.Modal(document.getElementById('modalOcasion'));
    loadOcasiones();
});
</script>
@endsection
