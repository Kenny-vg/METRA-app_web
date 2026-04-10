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
    <li class="nav-item">
        <button class="nav-link rounded-pill px-4" id="recordatorios-tab" data-bs-toggle="pill" data-bs-target="#recordatorios" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
            <i class="bi bi-clock-history me-2"></i>Recordatorios
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

    <!-- RECORDATORIOS -->
    <div class="tab-pane fade" id="recordatorios">
        <div class="card border-0 p-4 p-md-5 premium-card locked-container" id="recordatorios-lock-wrapper">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Recordatorios Automáticos</h5>
            </div>
            
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <div class="p-4 rounded-4" style="background: var(--off-white); border: 1px solid var(--border-light);">
                        <h6 class="fw-bold mb-3"><i class="bi bi-envelope-paper me-2 text-primary"></i>Secuencia de Notificaciones</h6>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                            <li class="d-flex align-items-center">
                                <span class="badge rounded-circle me-3 p-2" style="background: var(--black-primary); color: white; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">1</span>
                                <div>
                                    <p class="mb-0 fw-bold small">Confirmación Inmediata</p>
                                    <p class="mb-0 x-small text-muted">Se envía al momento de crear la reserva.</p>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="badge rounded-circle me-3 p-2" style="background: var(--black-primary); color: white; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">2</span>
                                <div>
                                    <p class="mb-0 fw-bold small">Recordatorio Diario</p>
                                    <p class="mb-0 x-small text-muted">Aviso general por la mañana (9:00 AM).</p>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="badge rounded-circle me-3 p-2" style="background: var(--accent-gold); color: white; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">3</span>
                                <div>
                                    <p class="mb-0 fw-bold small">Alerta Crítica (2 horas)</p>
                                    <p class="mb-0 x-small text-muted">Último recordatorio antes de la cita.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="p-4 rounded-4 h-100 d-flex flex-column justify-content-center" style="background: rgba(212, 175, 55, 0.05); border: 1px dashed var(--accent-gold);">
                        <h6 class="fw-bold mb-3 text-dark">Impacto en tu Negocio</h6>
                        <p class="small text-muted mb-3">Los recordatorios automatizados reducen el <strong>No-Show</strong> hasta en un <strong>40%</strong>, asegurando que tus mesas no se queden vacías por olvidos.</p>
                        <hr class="my-3 opacity-10">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 p-2 me-3" style="background: white; border: 1px solid var(--border-light);">
                                <i class="bi bi-check2-all text-success fs-4"></i>
                            </div>
                            <span class="small fw-bold">Estado: <span class="text-success" id="status-reminders-text">Inactivo</span></span>
                        </div>
                    </div>
                </div>
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
            <div class="js-ocasiones-container mt-1"></div>
        </td>
        <td>
            <div class="js-desc text-muted mb-2" style="font-size: 0.85rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; max-width: 300px;"></div>
            <div class="js-schedule-info small text-gold fw-medium" style="font-size: 0.75rem;"></div>
        </td>
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

                    <!-- NUEVO: Selector de Ocasiones condicional -->
                    <div class="col-12 mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="toggleOccasions">
                            <label class="form-check-label small fw-bold text-dark" for="toggleOccasions">Limitar por Ocasión Especial</label>
                            <div class="form-text x-small text-muted">Aplica cuando el cliente selecciona un motivo de reserva (cumpleaños, etc).</div>
                        </div>
                    </div>

                    <div class="col-12" id="sectionOccasions" style="display: none;">
                        <label class="form-label small fw-bold text-muted">SELECCIONA LAS OCASIONES</label>
                        <select id="promoTipo" name="ocasiones[]" multiple class="form-select border-0 shadow-sm rounded-3">
                        </select>
                    </div>

                    <!-- NUEVO: Restricciones de Tiempo condicionales -->
                    <div class="col-12 mt-4 pt-3 border-top">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="toggleSchedule">
                            <label class="form-check-label small fw-bold text-dark" for="toggleSchedule">Programar fechas o horarios</label>
                            <div class="form-text x-small text-muted">Define cuándo estará disponible esta promoción.</div>
                        </div>
                    </div>

                    <div id="sectionSchedule" class="col-12" style="display: none;">
                        <div class="row g-3 mt-1">
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

let promoEditandoId = null;

let modalPromoInst;
let promoTipoChoices = null;

const formatPrice = (price) => {
    if (parseFloat(price) === 0) return 'Cortesía / Sujeto a consumo';
    return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(price);
};

async function loadPromociones() {
    try {
        const response = await MetraAPI.get('/gerente/promociones');
        // El API retorna {success: true, data: [...]}
        // Pero el controlador usa get() ahora, por lo que data es un array directo.
        let promos = [];
        if (Array.isArray(response)) {
            promos = response;
        } else if (response && response.data) {
            // Si es un objeto paginador, los items están en response.data.data
            // Si es un ApiResponse wrapper, los items están en response.data
            promos = Array.isArray(response.data) ? response.data : (response.data.data || []);
        }
        
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

            // Mostrar Ocasiones
            const occasionsContainer = clone.querySelector('.js-ocasiones-container');
            if (p.ocasiones && p.ocasiones.length > 0) {
                p.ocasiones.forEach(o => {
                    const span = document.createElement('span');
                    span.className = 'badge rounded-pill me-1 text-xs';
                    span.style = 'background: rgba(0,0,0,0.05); color: #666; font-size: 0.65rem; border: 1px solid #ddd;';
                    span.textContent = o.nombre || o.nombre_ocasion;
                    occasionsContainer.appendChild(span);
                });
            }

            // Mostrar Horarios/Días
            const scheduleInfo = clone.querySelector('.js-schedule-info');
            let scheduleText = '';
            if (p.fecha_inicio || p.fecha_fin) {
                scheduleText += `<i class="bi bi-calendar-range me-1"></i> ${p.fecha_inicio || '...'} al ${p.fecha_fin || '...'}<br>`;
            }
            if (p.hora_inicio || p.hora_fin) {
                scheduleText += `<i class="bi bi-clock me-1"></i> ${p.hora_inicio ? p.hora_inicio.substring(0,5) : '...'} - ${p.hora_fin ? p.hora_fin.substring(0,5) : '...'}<br>`;
            }
            if (p.dias_semana && p.dias_semana.length > 0) {
                scheduleText += `<i class="bi bi-calendar-check me-1"></i> ${p.dias_semana.join(', ')}`;
            }
            scheduleInfo.innerHTML = scheduleText;

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
        const response = await MetraAPI.get('/gerente/ocasiones');
        const ocasiones = Array.isArray(response) ? response : (response.data || []);
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
        } catch (e) {
            console.error('Error cargando ocasiones para el modal', e);
        }
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

    // Reset toggles y visibilidad
    document.getElementById('toggleOccasions').checked = false;
    document.getElementById('toggleSchedule').checked = false;
    document.getElementById('sectionOccasions').style.display = 'none';
    document.getElementById('sectionSchedule').style.display = 'none';

    promoEditandoId = null;
    document.getElementById('modalPromoTitulo').innerText = 'Añadir Promoción';
    document.getElementById('promoTitulo').value = '';
    document.getElementById('promoDescripcion').value = '';
    document.getElementById('promoPrecio').value = '';
    // Set min date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('promoFechaInicio').min = today;
    document.getElementById('promoFechaFin').min = today;

    // Reset validation states
    document.getElementById('promoTitulo').classList.remove('is-invalid');
    document.getElementById('promoPrecio').classList.remove('is-invalid');

    modalPromoInst.show();
}

function editPromocion(p) {


    promoEditandoId = p.id;
    document.getElementById('modalPromoTitulo').innerText = 'Editar Promoción';
    document.getElementById('promoTitulo').value = p.nombre_promocion;
    document.getElementById('promoDescripcion').value = p.descripcion || '';
    document.getElementById('promoPrecio').value = p.precio;

    // Set min date and reset validation
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('promoFechaInicio').min = today;
    document.getElementById('promoFechaFin').min = today;
    document.getElementById('promoTitulo').classList.remove('is-invalid');
    document.getElementById('promoPrecio').classList.remove('is-invalid');
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
    
    // Configurar visibilidad basada en los datos
    const hasOccasions = p.ocasiones && p.ocasiones.length > 0;
    const hasSchedule = p.fecha_inicio || p.fecha_fin || p.hora_inicio || p.hora_fin || (p.dias_semana && p.dias_semana.length > 0);

    document.getElementById('toggleOccasions').checked = hasOccasions;
    document.getElementById('sectionOccasions').style.display = hasOccasions ? 'block' : 'none';

    document.getElementById('toggleSchedule').checked = hasSchedule;
    document.getElementById('sectionSchedule').style.display = hasSchedule ? 'block' : 'none';

    modalPromoInst.show();
}

async function guardarPromo() {
    let ocasionesMarcadas = [];
    if (document.getElementById('toggleOccasions').checked && promoTipoChoices) {
        ocasionesMarcadas = promoTipoChoices.getValue(true).map(v => parseInt(v));
    }

    const useSchedule = document.getElementById('toggleSchedule').checked;

    const data = {
        nombre_promocion: document.getElementById('promoTitulo').value.trim(),
        descripcion: document.getElementById('promoDescripcion').value.trim(),
        precio: document.getElementById('promoPrecio').value,
        fecha_inicio: useSchedule ? (document.getElementById('promoFechaInicio').value || null) : null,
        fecha_fin: useSchedule ? (document.getElementById('promoFechaFin').value || null) : null,
        hora_inicio: useSchedule ? (document.getElementById('promoHoraInicio').value || null) : null,
        hora_fin: useSchedule ? (document.getElementById('promoHoraFin').value || null) : null,
        dias_semana: useSchedule ? Array.from(document.querySelectorAll('.js-dia-semana:checked')).map(cb => cb.value) : null,
        activo: true,
        ocasiones: ocasionesMarcadas
    };

    // Frontend validation
    let isValid = true;
    if (!data.nombre_promocion) {
        document.getElementById('promoTitulo').classList.add('is-invalid');
        isValid = false;
    } else {
        document.getElementById('promoTitulo').classList.remove('is-invalid');
    }

    if (data.precio === '') {
        document.getElementById('promoPrecio').classList.add('is-invalid');
        isValid = false;
    } else {
        document.getElementById('promoPrecio').classList.remove('is-invalid');
    }

    if (useSchedule && data.hora_inicio && data.hora_fin && data.hora_inicio >= data.hora_fin) {
        showToast('error', 'La hora de fin debe ser posterior a la hora de inicio');
        return;
    }

    if (!isValid) {
        showToast('error', 'Por favor completa los campos obligatorios');
        return;
    }
    
    if (data.dias_semana && data.dias_semana.length === 0) data.dias_semana = null;
    
    const method = promoEditandoId ? 'PUT' : 'POST';
    const url = promoEditandoId ? `${API_URL}/promociones/${promoEditandoId}` : `${API_URL}/promociones`;

    try {
        await MetraAPI[promoEditandoId ? 'put' : 'post'](
            promoEditandoId ? `/gerente/promociones/${promoEditandoId}` : '/gerente/promociones',
            data
        );

        Swal.fire({
            icon: 'success',
            title: promoEditandoId ? 'Promoción actualizada' : 'Promoción creada',
            text: promoEditandoId ? 'Los datos han sido guardados.' : 'La promoción fue registrada correctamente.',
            confirmButtonColor: '#28a745'
        });
        modalPromoInst.hide();
        loadPromociones();
    } catch (error) {
        let errorMsg = 'Error al guardar promoción. Verifica los datos.';
        if (error.data?.errors) {
            errorMsg = Object.values(error.data.errors).flat().join('\n');
        } else if (error.data?.message) {
            errorMsg = error.data.message;
        } else {
             errorMsg = error.message || 'Error desconocido';
        }
        console.error('Error al guardar:', error);
        Swal.fire('Error', errorMsg, 'error');
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
                await MetraAPI.delete(`/gerente/promociones/${id}`);
                showToast('success', 'Promoción desactivada');
                loadPromociones();
            } catch (error) {
                Swal.fire('Error', error.data?.message || 'Error al desactivar promoción', 'error');
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
                await MetraAPI.post(`/gerente/promociones/${id}/activar`, {}, { 'X-HTTP-Method-Override': 'PATCH' });
                Swal.fire('Reactivada', 'Promoción reactivada', 'success');
                loadPromociones();
            } catch (error) {
                Swal.fire('Error', error.data?.message || 'Error al reactivar promoción', 'error');
            }
        }
    });
}

// --- OCASIONES ESPECIALES ---

let modalOcasionInst;

async function loadOcasiones() {
    try {
        const response = await MetraAPI.get('/gerente/ocasiones');
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
    const descripcion = document.getElementById('ocasion-descripcion').value.trim();
    
    if(!nombre) {
        document.getElementById('ocasion-nombre').classList.add('is-invalid');
        showToast('error', 'El nombre es obligatorio');
        return;
    }
    document.getElementById('ocasion-nombre').classList.remove('is-invalid');

    const method = id ? 'PUT' : 'POST';
    const url = id ? `${API_URL}/ocasiones/${id}` : `${API_URL}/ocasiones`;

    try {
        await MetraAPI[id ? 'put' : 'post'](
            id ? `/gerente/ocasiones/${id}` : '/gerente/ocasiones',
            { nombre, descripcion }
        );
        showToast('success', id ? 'Ocasión actualizada' : 'Ocasión creada');
        modalOcasionInst.hide();
        await loadOcasiones();
        await loadOcasionesForSelect();
    } catch (error) {
        const errorData = error.data || error;
        Swal.fire('Error', errorData.message || 'Error al guardar ocasión especial', 'error');
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
                await MetraAPI.delete(`/gerente/ocasiones/${id}`);
                showToast('success', 'Ocasión desactivada');
                await loadOcasiones();
                await loadOcasionesForSelect();
            } catch (error) {
                Swal.fire('Error', error.data?.message || 'Error al desactivar ocasión', 'error');
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
                await MetraAPI.post(`/gerente/ocasiones/${id}/activar`, {}, { 'X-HTTP-Method-Override': 'PATCH' });
                showToast('success', 'Ocasión reactivada');
                await loadOcasiones();
                await loadOcasionesForSelect();
            } catch (error) {
                Swal.fire('Error', error.data?.message || 'Error al reactivar ocasión', 'error');
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    modalOcasionInst = new bootstrap.Modal(document.getElementById('modalOcasion'));
    modalPromoInst = new bootstrap.Modal(document.getElementById('modalPromo'));

    // Event listeners para los toggles del modal de promociones
    document.getElementById('toggleOccasions').addEventListener('change', (e) => {
        document.getElementById('sectionOccasions').style.display = e.target.checked ? 'block' : 'none';
        if (!e.target.checked && promoTipoChoices) {
            promoTipoChoices.removeActiveItems();
        }
    });

    document.getElementById('toggleSchedule').addEventListener('change', (e) => {
        document.getElementById('sectionSchedule').style.display = e.target.checked ? 'block' : 'none';
    });

    loadOcasiones();
    loadOcasionesForSelect();
    loadPromociones();
    verificarPlanMarketing();
});

async function verificarPlanMarketing() {
    try {
        const res = await MetraAPI.get('/gerente/mi-cafeteria');
        const plan = res.data.suscripcion_actual?.plan;
        
        if (plan) {
            if (!plan.tiene_recordatorios) {
                const wrapper = document.getElementById('recordatorios-lock-wrapper');
                renderUpsellOverlay(wrapper, 'Recordatorios Inteligentes');
                document.getElementById('status-reminders-text').textContent = 'Bloqueado (Plan Básico/Estándar)';
                document.getElementById('status-reminders-text').className = 'text-danger';
            } else {
                document.getElementById('status-reminders-text').textContent = 'Activo (Plan Pro)';
                document.getElementById('status-reminders-text').className = 'text-success';
            }
        }
    } catch (e) {
        console.error("Error verificando plan en marketing:", e);
    }
}

function renderUpsellOverlay(container, title) {
    if (container.querySelector('.upsell-overlay')) return;
    
    const overlay = document.createElement('div');
    overlay.className = 'upsell-overlay d-flex flex-column align-items-center justify-content-center text-center p-4 rounded-4';
    overlay.style.position = 'absolute';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.background = 'rgba(255,255,255,0.05)';
    overlay.style.backdropFilter = 'blur(10px)';
    overlay.style.webkitBackdropFilter = 'blur(10px)';
    overlay.style.zIndex = '10';

    overlay.innerHTML = `
        <div class="premium-lock-icon mb-4 shadow-lg d-flex align-items-center justify-content-center" 
             style="width: 80px; height: 80px; background: rgba(255,255,255,0.1); backdrop-filter: blur(5px); border-radius: 50%; border: 3px solid var(--accent-gold);">
            <i class="bi bi-patch-check-fill fs-1" style="color: var(--accent-gold);"></i>
        </div>
        <h4 class="fw-bold mb-2" style="color: white; letter-spacing: -1px; text-shadow: 0 4px 8px rgba(0,0,0,0.5);">${title}</h4>
        <p class="text-white mb-4 px-3" style="max-width: 400px; line-height: 1.5; opacity: 0.9;">
            Envía recordatorios automáticos por correo a tus clientes (1 día y 2 horas antes de su cita). <br>
            <strong>Exclusivo del Plan Pro.</strong>
        </p>
        <div class="d-flex gap-3">
            <button class="btn btn-dark px-4 py-2 fw-bold shadow" onclick="window.location.href='/admin/dashboard?upgrade=1'">
                <i class="bi bi-stars me-2 text-warning"></i>Mejorar a Pro
            </button>
        </div>
    `;
    
    container.style.position = 'relative';
    container.appendChild(overlay);
}
</script>
@endsection
