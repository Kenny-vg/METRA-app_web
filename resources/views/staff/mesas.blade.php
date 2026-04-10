@extends('layouts.mobile')

@section('title', 'Mesas')

@section('content')
<div class="staff-header mb-4">
    <h2 class="staff-title mb-1 text-uppercase">Mesas</h2>
    <p class="text-muted small">Estado actual del salón</p>
</div>

<!-- Filters Section -->
<div class="filters-section mb-4">
    <div class="input-group mb-3 shadow-sm rounded-pill overflow-hidden border">
        <span class="input-group-text border-0 bg-white pe-0"><i class="bi bi-search text-muted"></i></span>
        <input type="text" id="search-mesa" class="form-control border-0 py-2 ps-2" placeholder="Buscar mesa..." style="font-size: 0.9rem;">
    </div>
    
    <select id="filter-zona" class="form-select rounded-pill border shadow-sm py-2" style="font-size: 0.9rem;">
        <option value="Todas">Todas las zonas</option>
        <!-- Zones will be loaded here -->
    </select>
</div>

<!-- Mesas List -->
<div id="mesas-list" class="row g-3">
    <!-- Loader placeholder -->
    <div class="col-12 text-center py-5 text-muted">
        <div class="spinner-border text-gold mb-3" role="status"></div>
        <p class="small fw-bold">Actualizando mesas...</p>
    </div>
</div>

@push('modals')
<!-- Modal confirmación liberación (Simple) -->
<div class="modal fade" id="modalConfirmarLiberar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered px-4">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-body text-center p-4">
                <i class="bi bi-exclamation-circle text-warning fs-1 mb-3"></i>
                <h5 class="fw-bold">¿Liberar Mesa?</h5>
                <p class="text-muted small">Se finalizará la ocupación actual de la <strong id="liberar-mesa-nombre">--</strong>.</p>
                <div class="d-grid gap-2 mt-4">
                    <button type="button" id="btn-confirmar-liberar" class="btn btn-dark rounded-pill py-2 fw-bold" style="background: var(--app-coffee);">Confirmar</button>
                    <button type="button" class="btn btn-link text-muted text-decoration-none fw-bold" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush
@endsection

@push('scripts')
<script>
    let allMesas = [];
    let currentOcupacionId = null;

    async function fetchMesas() {
        try {
            const res = await MetraAPI.get('/staff/mesas-estado');
            if (res.success) {
                allMesas = res.data;
                renderMesas();
            }
        } catch (e) {
            console.error('Error fetching mesas:', e);
        }
    }

    async function fetchZonas() {
        try {
            const res = await MetraAPI.get('/staff/zonas');
            if (res.success) {
                const select = document.getElementById('filter-zona');
                res.data.forEach(zona => {
                    const opt = document.createElement('option');
                    opt.value = zona.nombre_zona;
                    opt.textContent = zona.nombre_zona;
                    select.appendChild(opt);
                });
            }
        } catch (e) {
            console.error('Error fetching zonas:', e);
        }
    }

    function renderMesas() {
        const query = document.getElementById('search-mesa').value.toLowerCase();
        const zona = document.getElementById('filter-zona').value;
        const container = document.getElementById('mesas-list');
        
        let filtered = allMesas.filter(m => {
            const matchName = m.nombre.toLowerCase().includes(query);
            const matchZona = zona === 'Todas' || m.zona_nombre === zona;
            return matchName && matchZona;
        });

        if (filtered.length === 0) {
            container.innerHTML = '<div class="col-12 text-center py-5 text-muted">No se encontraron mesas</div>';
            return;
        }

        // Ordenar primero ocupadas para visibilidad de liberación
        filtered.sort((a, b) => (b.estado === 'ocupada' ? 1 : -1));

        container.innerHTML = filtered.map(m => `
            <div class="col-12">
                <div class="staff-card status-border active-click ${m.estado === 'ocupada' ? 'occupied' : 'available'}" 
                     onclick="${m.estado === 'ocupada' ? `prepararLiberar(${m.id}, '${m.nombre}', ${m.ocupacion_id})` : ''}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="staff-badge ${m.estado === 'ocupada' ? 'badge-occupied' : 'badge-available'} mb-2 d-inline-block">
                                ${m.estado.toUpperCase()}
                            </span>
                            <h5 class="m-0 fw-bold">${m.nombre}</h5>
                            <p class="text-muted small m-0">${m.zona_nombre}</p>
                        </div>
                        <div class="text-end">
                            <i class="bi bi-people-fill text-muted mb-1 d-block"></i>
                            <span class="small fw-bold">Hasta ${m.capacidad}</span>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function prepararLiberar(id, nombre, ocupacionId) {
        if (!ocupacionId) return;
        currentOcupacionId = ocupacionId;
        document.getElementById('liberar-mesa-nombre').textContent = nombre;
        new bootstrap.Modal(document.getElementById('modalConfirmarLiberar')).show();
    }

    document.getElementById('btn-confirmar-liberar').addEventListener('click', async () => {
        if (!currentOcupacionId) return;
        const btn = document.getElementById('btn-confirmar-liberar');
        const originalText = btn.innerHTML;
        
        try {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            
            await MetraAPI.patch(`/staff/ocupaciones/${currentOcupacionId}/finalizar`);
            
            bootstrap.Modal.getInstance(document.getElementById('modalConfirmarLiberar')).hide();
            Swal.fire({
                icon: 'success',
                title: 'Mesa liberada',
                showConfirmButton: false,
                timer: 1500,
                toast: true,
                position: 'top-end'
            });
            fetchMesas();
        } catch (e) {
            Swal.fire('Error', e.message || 'No se pudo liberar la mesa', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    });

    document.getElementById('search-mesa').addEventListener('input', renderMesas);
    document.getElementById('filter-zona').addEventListener('change', renderMesas);

    document.addEventListener('DOMContentLoaded', () => {
        fetchZonas();
        fetchMesas();
        // Polling cada 30 segundos
        setInterval(fetchMesas, 30000);
    });
</script>
@endpush
