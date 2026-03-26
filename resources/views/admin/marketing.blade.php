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
        <button class="nav-link active rounded-pill px-4" id="ocasiones-tab" data-bs-toggle="pill" data-bs-target="#ocasiones" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
            <i class="bi bi-balloon me-2"></i>Ocasiones Especiales
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link rounded-pill px-4" id="promociones-tab" data-bs-toggle="pill" data-bs-target="#promociones" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
            <i class="bi bi-megaphone me-2"></i>Promociones Activas
        </button>
    </li>
</ul>

<div class="tab-content">
    <!-- OCASIONES ESPECIALES -->
    <div class="tab-pane fade show active" id="ocasiones">
        <div class="card border-0 p-4 p-md-5 premium-card">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
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

    <!-- PROMOCIONES -->
    <div class="tab-pane fade" id="promociones">
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
</div>

<!-- Plantillas para Renderizado Estructural (Seguridad XSS y Rendimiento) -->
<template id="promo-template">
    <tr class="js-row">
        <td>
            <div class="js-badge-container" style="display: none;">
                <span class="badge bg-secondary mb-1" style="font-size:0.65rem;">Inactiva</span><br>
            </div>
            <span class="fw-bold js-nombre" style="color: var(--black-primary); font-size: 1.05rem;"></span>
        </td>
        <td><span class="text-muted small js-desc" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; max-width: 300px;"></span></td>
        <td>
            <span class="badge fs-6 rounded-pill js-precio" style="background: rgba(212,175,55,0.1); color: var(--accent-gold); border: 1px solid rgba(212,175,55,0.2);"></span>
        </td>
        <td class="text-end align-middle js-actions"></td>
    </tr>
</template>

<template id="ocasion-template">
    <tr class="js-row">
        <td>
            <div class="fw-bold js-nombre-container" style="color: var(--black-primary);">
                <span class="js-nombre"></span>
                <span class="badge bg-secondary ms-2 text-xs js-badge" style="display: none;">Inactivo</span>
            </div>
            <div class="small text-muted text-truncate js-desc" style="max-width: 300px;"></div>
        </td>
        <td class="text-end align-middle js-actions"></td>
    </tr>
</template>

<!-- Modal nueva/editar promoción -->
<div class="modal fade" id="modalPromo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold m-0" id="modalPromoTitulo" style="color: var(--black-primary); letter-spacing: -0.5px;">Nueva Promoción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-4">
                <p class="small text-muted mb-4">Configure los beneficios y promociones que sus clientes podrán elegir al reservar.</p>
                
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">TÍTULO DE LA PROMO</label>
                        <input type="text" id="promoTitulo" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" placeholder="Ej: Cumpleaños Especial" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">DESCRIPCIÓN</label>
                        <textarea id="promoDescripcion" class="form-control border-0 shadow-sm rounded-3" rows="2" style="background: var(--off-white);" placeholder="Describe brevemente el beneficio..."></textarea>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-muted">PRECIO ($)</label>
                        <input type="number" id="promoPrecio" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" placeholder="0.00" step="0.01" min="0" required>
                        <div class="form-text mt-1 x-small text-muted">Si es 0, se mostrará como "Cortesía".</div>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label small fw-bold text-muted">APLICA A (OCASIONES)</label>
                        <select id="promoTipo" name="ocasiones[]" multiple class="form-select border-0 shadow-sm rounded-3">
                        </select>
                        <div class="form-text mt-1 x-small text-muted">Opcional: Si no selecciona ninguna, será una "Promo General".</div>
                    </div>

                    <div class="col-12 mt-4 pt-3 border-top">
                        <h6 class="fw-bold mb-3 small" style="color: var(--black-primary); letter-spacing: 0.5px;">RESTRICCIONES DE TIEMPO (OPCIONAL)</h6>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label x-small fw-bold text-muted">FECHA INICIO</label>
                                <input type="date" id="promoFechaInicio" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);">
                            </div>
                            <div class="col-6">
                                <label class="form-label x-small fw-bold text-muted">FECHA FIN</label>
                                <input type="date" id="promoFechaFin" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);">
                            </div>
                            <div class="col-6">
                                <label class="form-label x-small fw-bold text-muted">HORA APERTURA</label>
                                <input type="time" id="promoHoraInicio" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);">
                            </div>
                            <div class="col-6">
                                <label class="form-label x-small fw-bold text-muted">HORA CIERRE</label>
                                <input type="time" id="promoHoraFin" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);">
                            </div>
                            <div class="col-12">
                                <label class="form-label x-small fw-bold text-muted d-block mb-2">DÍAS DISPONIBLES</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input js-dia-semana" type="checkbox" value="Lunes" id="dia-Lunes">
                                        <label class="form-check-label x-small" for="dia-Lunes">Lun</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input js-dia-semana" type="checkbox" value="Martes" id="dia-Martes">
                                        <label class="form-check-label x-small" for="dia-Martes">Mar</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input js-dia-semana" type="checkbox" value="Miercoles" id="dia-Miercoles">
                                        <label class="form-check-label x-small" for="dia-Miercoles">Mié</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input js-dia-semana" type="checkbox" value="Jueves" id="dia-Jueves">
                                        <label class="form-check-label x-small" for="dia-Jueves">Jue</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input js-dia-semana" type="checkbox" value="Viernes" id="dia-Viernes">
                                        <label class="form-check-label x-small" for="dia-Viernes">Vie</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input js-dia-semana" type="checkbox" value="Sabado" id="dia-Sabado">
                                        <label class="form-check-label x-small" for="dia-Sabado">Sáb</label>
                                    </div>
                                    <div class="form-check form-check-inline m-0">
                                        <input class="form-check-input js-dia-semana" type="checkbox" value="Domingo" id="dia-Domingo">
                                        <label class="form-check-label x-small" for="dia-Domingo">Dom</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 mb-2">
                    <button type="button" class="btn-admin-primary w-100 py-3" onclick="guardarPromo()">
                        <i class="bi bi-check2 me-2"></i>Guardar Promoción
                    </button>
                    <button type="button" class="btn btn-link w-100 text-muted small mt-2 text-decoration-none" data-bs-dismiss="modal">Cancelar</button>
                </div>
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
    if (parseFloat(price) === 0) return 'Cortesía / Sujeto a consumo';
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

        const fragment = document.createDocumentFragment();
        const template = document.getElementById('promo-template');

        promos.forEach(p => {
            const clone = template.content.cloneNode(true);
            const row = clone.querySelector('.js-row');

            if (!p.activo) {
                row.classList.add('table-secondary', 'opacity-50');
                clone.querySelector('.js-badge-container').style.display = 'block';
            }

            clone.querySelector('.js-nombre').textContent = p.nombre_promocion;
            clone.querySelector('.js-desc').textContent = p.descripcion || '-';
            clone.querySelector('.js-precio').textContent = formatPrice(p.precio);

            const actionsCol = clone.querySelector('.js-actions');
            if (p.activo) {
                const btnEdit = document.createElement('button');
                btnEdit.className = 'btn btn-sm btn-outline-dark rounded-circle me-1';
                btnEdit.title = 'Editar';
                btnEdit.innerHTML = '<i class="bi bi-pencil"></i>';
                btnEdit.addEventListener('click', () => editPromocion(p));

                const btnDelete = document.createElement('button');
                btnDelete.className = 'btn btn-sm btn-outline-primary rounded-circle';
                btnDelete.title = 'Desactivar';
                btnDelete.innerHTML = '<i class="bi bi-x-circle"></i>';
                btnDelete.addEventListener('click', () => deletePromocion(p.id));

                actionsCol.appendChild(btnEdit);
                actionsCol.appendChild(btnDelete);
            } else {
                const btnReactivate = document.createElement('button');
                btnReactivate.className = 'btn btn-sm btn-success rounded-pill px-3 shadow-sm';
                btnReactivate.title = 'Reactivar';
                btnReactivate.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar';
                btnReactivate.addEventListener('click', () => reactivatePromocion(p.id));

                actionsCol.appendChild(btnReactivate);
            }

            fragment.appendChild(clone);
        });
        
        tbody.appendChild(fragment);
    } catch (error) {
        console.error(error);
        document.getElementById('tabla-promos-body').innerHTML = '<tr><td colspan="4" class="text-center text-danger py-4">Error de conexión al cargar promociones.</td></tr>';
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

async function abrirModalNuevaPromo() {
    // Si no hay ocasiones cargadas o no se ha inicializado el selector, intentar cargar
    if (ocasionesCargadas.length === 0 || !promoTipoChoices) {
        const select = document.getElementById('promoTipo');
        if (promoTipoChoices) {
            promoTipoChoices.destroy();
            promoTipoChoices = null;
        }
        select.innerHTML = '<option value="">Cargando ocasiones...</option>';
        await loadOcasionesForSelect();
    }

    // Not blocking for General Promos

    promoEditandoId = null;
    document.getElementById('modalPromoTitulo').innerText = 'Añadir Promoción';
    document.getElementById('promoTitulo').value = '';
    document.getElementById('promoDescripcion').value = '';
    document.getElementById('promoPrecio').value = '';
    document.getElementById('promoFechaInicio').value = '';
    document.getElementById('promoFechaFin').value = '';
    document.getElementById('promoHoraInicio').value = '';
    document.getElementById('promoHoraFin').value = '';
    document.querySelectorAll('.js-dia-semana').forEach(cb => cb.checked = false);

    // Aseguramos que el select esté lleno y listo antes de mostrar modal
    if (promoTipoChoices) {
        promoTipoChoices.removeActiveItems();
    }

    modalPromoInst.show();
}

function editPromocion(p) {


    promoEditandoId = p.id;
    document.getElementById('modalPromoTitulo').innerText = 'Editar Promoción';
    document.getElementById('promoTitulo').value = p.nombre_promocion;
    document.getElementById('promoDescripcion').value = p.descripcion || '';
    document.getElementById('promoPrecio').value = p.precio;
    document.getElementById('promoFechaInicio').value = p.fecha_inicio || '';
    document.getElementById('promoFechaFin').value = p.fecha_fin || '';
    document.getElementById('promoHoraInicio').value = p.hora_inicio ? p.hora_inicio.substring(0,5) : '';
    document.getElementById('promoHoraFin').value = p.hora_fin ? p.hora_fin.substring(0,5) : '';
    
    const dias = p.dias_semana || [];
    document.querySelectorAll('.js-dia-semana').forEach(cb => {
        cb.checked = dias.includes(cb.value);
    });
    
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



    const data = {
        nombre_promocion: document.getElementById('promoTitulo').value,
        descripcion: document.getElementById('promoDescripcion').value,
        precio: document.getElementById('promoPrecio').value,
        fecha_inicio: document.getElementById('promoFechaInicio').value || null,
        fecha_fin: document.getElementById('promoFechaFin').value || null,
        hora_inicio: document.getElementById('promoHoraInicio').value || null,
        hora_fin: document.getElementById('promoHoraFin').value || null,
        dias_semana: Array.from(document.querySelectorAll('.js-dia-semana:checked')).map(cb => cb.value),
        activo: true,
        ocasiones: ocasionesMarcadas
    };
    
    if (data.dias_semana.length === 0) data.dias_semana = null;
    
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
        
        const template = document.getElementById('ocasion-template');
        const fragment = document.createDocumentFragment();

        ocasiones.forEach(o => {
            const clone = template.content.cloneNode(true);
            const row = clone.querySelector('.js-row');

            if (!o.activo) {
                row.classList.add('table-secondary', 'opacity-50');
                clone.querySelector('.js-badge').style.display = 'inline-block';
            }

            clone.querySelector('.js-nombre').textContent = o.nombre;
            clone.querySelector('.js-desc').textContent = o.descripcion || 'Sin descripción';

            const actionsCol = clone.querySelector('.js-actions');
            if (o.activo) {
                const btnEdit = document.createElement('button');
                btnEdit.className = 'btn btn-sm btn-outline-dark rounded-circle me-1';
                btnEdit.title = 'Editar';
                btnEdit.innerHTML = '<i class="bi bi-pencil"></i>';
                btnEdit.addEventListener('click', () => editOcasion(o));

                const btnDelete = document.createElement('button');
                btnDelete.className = 'btn btn-sm btn-outline-primary rounded-circle';
                btnDelete.title = 'Desactivar';
                btnDelete.innerHTML = '<i class="bi bi-x-circle"></i>';
                btnDelete.addEventListener('click', () => deleteOcasion(o.id));

                actionsCol.appendChild(btnEdit);
                actionsCol.appendChild(btnDelete);
            } else {
                const btnReactivate = document.createElement('button');
                btnReactivate.className = 'btn btn-sm btn-success rounded-pill px-3 shadow-sm';
                btnReactivate.title = 'Reactivar';
                btnReactivate.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar';
                btnReactivate.addEventListener('click', () => reactivateOcasion(o.id));

                actionsCol.appendChild(btnReactivate);
            }

            fragment.appendChild(clone);
        });

        tbody.appendChild(fragment);
    } catch (error) {
        console.error(error);
        document.getElementById('tabla-ocasiones-body').innerHTML = '<tr><td colspan="2" class="text-center text-danger py-4">Error de conexión al cargar ocasiones.</td></tr>';
        showToast('error', 'No se pudieron cargar las ocasiones especiales');
    }
}

function openModalOcasion() {
    document.getElementById('formOcasion').reset();
    document.getElementById('ocasion-id').value = '';
    document.getElementById('modalOcasionTitle').innerText = 'Nueva Ocasión Especial';
    modalOcasionInst.show();
}

function editOcasion(o) {
    document.getElementById('ocasion-id').value = o.id;
    document.getElementById('ocasion-nombre').value = o.nombre;
    document.getElementById('ocasion-descripcion').value = o.descripcion || '';
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
            await loadOcasiones();
            await loadOcasionesForSelect();
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
                    await loadOcasiones();
                    await loadOcasionesForSelect();
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
                    await loadOcasiones();
                    await loadOcasionesForSelect();
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
