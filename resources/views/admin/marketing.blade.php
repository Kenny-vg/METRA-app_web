@extends('admin.menu')
@section('title', 'Promociones')

@section('content')
<header class="mb-5 border-bottom pb-4" style="border-color: var(--border-light) !important;">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Promociones</h2>
            <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Gestiona las promociones que se muestran a tus clientes en la página del negocio.</p>
        </div>
        <button class="btn-metra-main" onclick="abrirModalNuevaPromo()" style="padding: 12px 24px; font-size: 0.9rem;">
            <i class="bi bi-plus-lg me-2"></i>Nueva Promoción
        </button>
    </div>
</header>

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

document.addEventListener('DOMContentLoaded', () => setTimeout(renderPromos, 400));
</script>
@endsection
