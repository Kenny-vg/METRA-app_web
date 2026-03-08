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
<div class="row g-4 mb-4">
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

<!-- Bloque informativo principal -->
<div class="alert alert-info d-flex align-items-start rounded-3 mb-4" style="background: rgba(13, 110, 253, 0.05); border: 1px solid rgba(13, 110, 253, 0.2); color: #084298;">
    <i class="bi bi-info-circle-fill fs-4 me-3 mt-1"></i>
    <div>
        <p class="mb-0 small" style="line-height: 1.4;">Las promociones pueden aplicarse a una o varias ocasiones especiales.<br>
        <strong>Ejemplo:</strong> Cumpleaños, Aniversario, Graduación.<br>
        Primero registra las ocasiones en su pestaña respectiva y luego crea promociones asociadas a ellas.</p>
    </div>
</div>

<!-- Listado de promociones -->
<div class="card border-0 p-4 p-md-5 premium-card">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
        <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Gestión de Promociones</h5>
    </div>
    <div class="table-responsive">
        <table class="table-metra mt-2">
            <thead>
                <tr>
                    <th>Campaña</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla-promos-body">
                <!-- Promociones cargadas por JS -->
            </tbody>
        </table>
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
<div class="modal fade" id="modalPromo" tabindex="-1" style="font-family: inherit !important;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg" style="overflow: visible; font-family: inherit !important;">
            <div class="modal-header border-0 px-5 pt-5 pb-3" style="background: var(--off-white);">
                <h5 class="modal-title fw-bold" style="color: var(--black-primary);" id="modalPromoTitulo">Nueva Promoción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-5 py-4">
                <div class="alert alert-info d-flex align-items-start rounded-3 mb-4" style="background: rgba(13, 110, 253, 0.05); border: 1px solid rgba(13, 110, 253, 0.2); color: #084298;">
                    <i class="bi bi-info-circle-fill fs-4 me-3 mt-1"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Información</h6>
                        <p class="mb-0 small" style="line-height: 1.4;">Las promociones pueden aplicarse a una o varias ocasiones especiales.<br>
                        <strong>Ejemplo:</strong> Cumpleaños, Aniversario, Graduación.<br>
                        Antes de crear una promoción debes registrar al menos una ocasión especial.</p>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px; color: var(--text-muted);">Título de la promoción</label>
                        <input type="text" id="promoTitulo" class="form-control form-control-lg" style="border-radius: 10px; border-color: var(--border-light);" placeholder="Ej: Cumpleaños Especial" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px; color: var(--text-muted);">Descripción</label>
                        <textarea id="promoDescripcion" class="form-control" rows="3" style="border-radius: 10px; border-color: var(--border-light);" placeholder="Describe brevemente la promoción o evento especial..."></textarea>
                    </div>
                    <div class="col-12 col-md-4">
                        <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px; color: var(--text-muted);">Precio Especial</label>
                        <div class="input-group shadow-sm" style="border-radius: 10px; border: 1px solid var(--border-light); overflow: hidden;">
                            <span class="input-group-text border-0 bg-white" style="color: var(--black-primary); font-weight: 600;">$</span>
                            <input type="number" id="promoPrecio" class="form-control border-0" placeholder="85.00" step="0.01" min="0" required>
                        </div>
                        <div class="form-text text-muted" style="font-size: 0.75rem; margin-top: 6px;"><i class="bi bi-info-circle me-1"></i>Si el precio es 0 la promoción se mostrará como "Incluido sin costo".</div>
                    </div>
                    <div class="col-12 col-md-8">
                        <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px; color: var(--text-muted);">Tipo de evento (Ocasiones)</label>
                        <select id="promoTipo" name="ocasiones[]" multiple class="form-select shadow-sm" style="border-radius: 10px; border-color: var(--border-light);" required>
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

<!-- Choices.js para selectors modernos -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
const token = localStorage.getItem('token');
let promoEditandoId = null;

let modalPromoInst;
let promoTipoChoices = null;

const formatPrice = (price) => {
    if (parseFloat(price) === 0) return 'Incluido sin costo';
    return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(price);
};

async function loadPromociones() {
    try {
        const res = await fetch(`${API_URL}/promociones`, { headers: headers() });
        if (!res.ok) throw new Error('Error al cargar promociones');
        
        const response = await res.json();
        const promos = Array.isArray(response) ? response : (response.data || []);
        
        const tbody = document.getElementById('tabla-promos-body');
        tbody.innerHTML = '';

        document.getElementById('contador-activas').textContent = promos.filter(p=>p.activo).length;
        document.getElementById('contador-total').textContent = promos.length;

        if (promos.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted py-4">No hay promociones registradas.</td></tr>`;
            return;
        }

        promos.forEach(p => {
            const opacityClass = p.activo ? '' : 'opacity-50';
            const bgClass = p.activo ? '' : 'table-secondary';
            const badge = !p.activo ? `<span class="badge bg-secondary mb-1" style="font-size:0.65rem;">Inactiva</span><br>` : '';
            
            const actions = p.activo
                ? `<button class="btn btn-sm btn-outline-dark rounded-circle me-1" onclick='editPromocion(${JSON.stringify(p)})' title="Editar"><i class="bi bi-pencil"></i></button>
                   <button class="btn btn-sm btn-outline-danger rounded-circle" onclick="deletePromocion(${p.id})" title="Desactivar"><i class="bi bi-trash"></i></button>`
                : `<button class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" onclick="reactivatePromocion(${p.id})" title="Reactivar"><i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar</button>`;

            tbody.innerHTML += `
                <tr class="${bgClass} ${opacityClass}">
                    <td>
                        ${badge}
                        <span class="fw-bold" style="color: var(--black-primary); font-size: 1.05rem;">${p.nombre_promocion}</span>
                    </td>
                    <td><span class="text-muted small" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; max-width: 300px;">${p.descripcion || '-'}</span></td>
                    <td>
                        <span class="badge fs-6 rounded-pill" style="background: rgba(212,175,55,0.1); color: var(--accent-gold); border: 1px solid rgba(212,175,55,0.2);">
                            ${formatPrice(p.precio)}
                        </span>
                    </td>
                    <td class="text-end align-middle">
                        ${actions}
                    </td>
                </tr>
            `;
        });
    } catch (error) {
        console.error(error);
        showToast('error', 'No se pudieron cargar las promociones');
    }
}

let ocasionesCargadas = [];

async function loadOcasionesForSelect() {
    try {
        const res = await fetch(`${API_URL}/ocasiones`, { headers: headers() });
        if (res.ok) {
            const data = await res.json();
            const ocasiones = Array.isArray(data) ? data : (data.data || []);
            ocasionesCargadas = ocasiones.filter(o => o.activo);
            
            const select = document.getElementById('promoTipo');
            select.innerHTML = '';
            
            ocasionesCargadas.forEach(o => {
                const opt = document.createElement('option');
                opt.value = o.id;
                opt.textContent = o.nombre;
                select.appendChild(opt);
            });

            if(promoTipoChoices) {
                promoTipoChoices.destroy();
            }
            promoTipoChoices = new Choices(select, {
                removeItemButton: true,
                placeholderValue: 'Seleccionar ocasiones',
                searchPlaceholderValue: 'Buscar ocasión...',
                itemSelectText: '',
                noResultsText: 'No se encontraron resultados',
                noChoicesText: 'No hay opciones disponibles'
            });
        }
    } catch (e) { console.error('Error cargando ocasiones para el modal', e); }
}

function abrirModalNuevaPromo() {
    if (ocasionesCargadas.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Primero registra una ocasión especial',
            text: 'Las promociones deben estar asociadas a al menos una ocasión. Ve a la pestaña "Ocasiones especiales".',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Entendido'
        });
        return;
    }

    promoEditandoId = null;
    document.getElementById('modalPromoTitulo').innerText = 'Añadir Promoción';
    document.getElementById('promoTitulo').value = '';
    document.getElementById('promoDescripcion').value = '';
    document.getElementById('promoPrecio').value = '';
    
    if (promoTipoChoices) {
        promoTipoChoices.removeActiveItems();
    }

    modalPromoInst.show();
}

function editPromocion(p) {
    if (ocasionesCargadas.length === 0) {
        Swal.fire('Error', 'No hay ocasiones registradas.', 'error');
        return;
    }

    promoEditandoId = p.id;
    document.getElementById('modalPromoTitulo').innerText = 'Editar Promoción';
    document.getElementById('promoTitulo').value = p.nombre_promocion;
    document.getElementById('promoDescripcion').value = p.descripcion || '';
    document.getElementById('promoPrecio').value = p.precio;
    
    if (promoTipoChoices) {
        promoTipoChoices.removeActiveItems();
        if (p.ocasiones && Array.isArray(p.ocasiones)) {
            const ocIds = p.ocasiones.map(o => (o.id || o.ocasion_id || o).toString());
            promoTipoChoices.setChoiceByValue(ocIds);
        }
    }
    
    modalPromoInst.show();
}

async function guardarPromo() {
    let ocasionesMarcadas = [];
    if (promoTipoChoices) {
        ocasionesMarcadas = promoTipoChoices.getValue(true).map(v => parseInt(v));
    }

    if (ocasionesMarcadas.length === 0) {
        Swal.fire('Atención', 'Debes seleccionar al menos una ocasión especial.', 'warning');
        return;
    }

    const data = {
        nombre_promocion: document.getElementById('promoTitulo').value,
        descripcion: document.getElementById('promoDescripcion').value,
        precio: document.getElementById('promoPrecio').value,
        activo: true,
        ocasiones: ocasionesMarcadas
    };
    
    const method = promoEditandoId ? 'PUT' : 'POST';
    const url = promoEditandoId ? `${API_URL}/promociones/${promoEditandoId}` : `${API_URL}/promociones`;

    try {
        const res = await fetch(url, {
            method,
            headers: headers(),
            body: JSON.stringify(data)
        });

        if (res.ok) {
            Swal.fire({
                icon: 'success',
                title: promoEditandoId ? 'Promoción actualizada' : 'Promoción creada',
                text: promoEditandoId ? 'Los datos han sido guardados.' : 'La promoción fue registrada correctamente.',
                confirmButtonColor: '#28a745'
            });
            modalPromoInst.hide();
            loadPromociones();
        } else {
            const errorData = await res.json();
            let errorMsg = 'Error al guardar promoción. Verifica los datos.';
            if (errorData.errors) {
                errorMsg = Object.values(errorData.errors).flat().join('\n');
            } else if (errorData.message) {
                errorMsg = errorData.message;
            }
            Swal.fire('Error', errorMsg, 'error');
        }
    } catch (error) {
        Swal.fire('Error', 'Error de conexión', 'error');
    }
}

async function deletePromocion(id) {
    Swal.fire({
        title: '¿Deseas desactivar esta promoción?',
        text: 'Esta promoción no será visible para los clientes.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, desactivar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await fetch(`${API_URL}/promociones/${id}`, { method: 'DELETE', headers: headers() });
                if (res.ok) {
                    showToast('success', 'Promoción desactivada');
                    loadPromociones();
                } else {
                    const err = await res.json();
                    Swal.fire('Error', err.message || 'Error al desactivar promoción', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Error de conexión', 'error');
            }
        }
    });
}

async function reactivatePromocion(id) {
    Swal.fire({
        title: '¿Reactivar Promoción?',
        text: 'La promoción volverá a estar pública.',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, reactivar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const res = await fetch(`${API_URL}/promociones/${id}/activar`, { method: 'PATCH', headers: headers() });
                if (res.ok) {
                    Swal.fire('Reactivada', 'Promoción reactivada', 'success');
                    loadPromociones();
                } else {
                    const err = await res.json();
                    Swal.fire('Error', err.message || 'Error al reactivar promoción', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Error de conexión', 'error');
            }
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
    modalOcasionInst = new bootstrap.Modal(document.getElementById('modalOcasion'));
    modalPromoInst = new bootstrap.Modal(document.getElementById('modalPromo'));
    loadOcasiones();
    loadOcasionesForSelect();
    loadPromociones();
});
</script>
@endsection
