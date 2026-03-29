@extends('admin.menu')
@section('title', 'Moderación de Reseñas')

@section('content')
    <header class="mb-4 border-bottom pb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3" style="border-color: var(--border-light) !important;">
        <div>
            <h2 class="fw-bold" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Reseñas de Clientes</h2>
            <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Modera y publica las reseñas recibidas de tus clientes.</p>
        </div>
    </header>

    <!-- Stats -->
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="p-4 rounded-4 shadow-sm" style="background: var(--white-pure); border: 1px solid var(--border-light);">
                <div class="d-flex align-items-center mb-2">
                    <div style="width: 40px; height: 40px; background: rgba(212,175,55,0.1); border-radius: 50%; color: #d4af37;" class="d-flex align-items-center justify-content-center me-3">
                        <i class="bi bi-clock-history fs-5"></i>
                    </div>
                    <span class="text-muted fw-bold" style="letter-spacing: 0.5px; font-size: 0.85rem; text-transform: uppercase;">Pendientes</span>
                </div>
                <h3 class="fw-bold m-0" style="color: var(--black-primary); font-size: 2rem;" id="statPendientes">...</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 rounded-4 shadow-sm" style="background: var(--white-pure); border: 1px solid var(--border-light);">
                <div class="d-flex align-items-center mb-2">
                    <div style="width: 40px; height: 40px; background: rgba(46,125,50,0.1); border-radius: 50%; color: #2e7d32;" class="d-flex align-items-center justify-content-center me-3">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                    </div>
                    <span class="text-muted fw-bold" style="letter-spacing: 0.5px; font-size: 0.85rem; text-transform: uppercase;">Publicadas</span>
                </div>
                <h3 class="fw-bold m-0" style="color: var(--black-primary); font-size: 2rem;" id="statPublicadas">...</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 rounded-4 shadow-sm" style="background: var(--white-pure); border: 1px solid var(--border-light);">
                <div class="d-flex align-items-center mb-2">
                    <div style="width: 40px; height: 40px; background: rgba(212,175,55,0.1); border-radius: 50%; color: #d4af37;" class="d-flex align-items-center justify-content-center me-3">
                        <i class="bi bi-star-fill fs-5"></i>
                    </div>
                    <span class="text-muted fw-bold" style="letter-spacing: 0.5px; font-size: 0.85rem; text-transform: uppercase;">Promedio</span>
                </div>
                <h3 class="fw-bold m-0" style="color: var(--black-primary); font-size: 2rem;" id="statPromedio">...</h3>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="d-flex gap-2 mb-4 px-2">
        <button class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm btn-filtro-resena active" data-filtro="todas">Todas</button>
        <button class="btn btn-outline-dark rounded-pill px-4 fw-bold shadow-sm btn-filtro-resena" data-filtro="pendiente">Pendientes</button>
        <button class="btn btn-outline-dark rounded-pill px-4 fw-bold shadow-sm btn-filtro-resena" data-filtro="publicada">Publicadas</button>
        <button class="btn btn-outline-dark rounded-pill px-4 fw-bold shadow-sm btn-filtro-resena" data-filtro="oculta">Ocultas</button>
    </div>

    <!-- Grid -->
    <div id="resenas-grid" class="row g-4 mb-5">
        <div class="col-12 text-center py-5">
            <div class="spinner-border text-muted" role="status"></div>
            <p class="mt-2 text-muted fw-bold small">CARGANDO RESEÑAS...</p>
        </div>
    </div>

    @include('partials.footer_admin')

    <script>
        const API = '/api';
        let todasResenas = [];
        let filtroActual = 'todas';

        function renderStars(count) {
            let html = '';
            for (let i = 1; i <= 5; i++) {
                html += i <= count
                    ? '<i class="bi bi-star-fill text-warning me-1"></i>'
                    : '<i class="bi bi-star text-muted me-1" style="opacity:0.3;"></i>';
            }
            return html;
        }

        function getEstadoBadge(estado) {
            switch (estado) {
                case 'publicada':
                    return '<span class="badge rounded-pill" style="background: #e8f5e9; color: #2e7d32; font-size: 0.75rem;">Publicada</span>';
                case 'oculta':
                    return '<span class="badge rounded-pill" style="background: #f5f5f5; color: #9e9e9e; font-size: 0.75rem;">Oculta</span>';
                case 'pendiente':
                default:
                    return '<span class="badge rounded-pill" style="background: #fdf3d8; color: #b58500; font-size: 0.75rem;">Pendiente</span>';
            }
        }

        function renderResenas(lista) {
            const grid = document.getElementById('resenas-grid');

            if (lista.length === 0) {
                grid.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-chat-square-text display-3 d-block mb-3" style="color: var(--border-light);"></i>
                        <h5 class="fw-bold" style="color: var(--black-primary);">Sin reseñas en esta categoría</h5>
                        <p class="text-muted small">Las reseñas aparecerán aquí cuando los clientes las envíen.</p>
                    </div>`;
                return;
            }

            let html = '';
            lista.forEach(r => {
                const fecha = r.created_at ? new Date(r.created_at).toLocaleDateString('es-ES', { day: 'numeric', month: 'short', year: 'numeric' }) : '';

                const btnPublicar = r.estado !== 'publicada'
                    ? `<button class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold" onclick="cambiarEstado(${r.id}, 'aprobar')"><i class="bi bi-check-lg me-1"></i>Publicar</button>`
                    : '';
                const btnOcultar = r.estado !== 'oculta'
                    ? `<button class="btn btn-sm btn-outline-secondary rounded-pill px-3 fw-bold" onclick="cambiarEstado(${r.id}, 'ocultar')"><i class="bi bi-eye-slash me-1"></i>Ocultar</button>`
                    : '';

                html += `
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4" style="background: var(--white-pure); border: 1px solid var(--border-light) !important;">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>${renderStars(r.calificacion)}</div>
                                    ${getEstadoBadge(r.estado)}
                                </div>
                                <p class="text-muted flex-grow-1" style="line-height: 1.6; font-size: 0.95rem;">"${r.comentario ? escapeHTML(r.comentario) : '<em>Sin comentario</em>'}"</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3" style="border-top: 1px solid var(--border-light);">
                                    <small class="text-muted fw-bold"><i class="bi bi-calendar3 me-1"></i>${fecha}</small>
                                    <div class="d-flex gap-2">
                                        ${btnPublicar}
                                        ${btnOcultar}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
            });

            grid.innerHTML = html;
        }

        function aplicarFiltro() {
            const filtradas = filtroActual === 'todas'
                ? todasResenas
                : todasResenas.filter(r => r.estado === filtroActual);
            renderResenas(filtradas);
        }

        function actualizarStats() {
            const pendientes = todasResenas.filter(r => r.estado === 'pendiente').length;
            const publicadas = todasResenas.filter(r => r.estado === 'publicada').length;
            document.getElementById('statPendientes').textContent = pendientes;
            document.getElementById('statPublicadas').textContent = publicadas;

            const conCalificacion = todasResenas.filter(r => r.calificacion);
            if (conCalificacion.length > 0) {
                const promedio = conCalificacion.reduce((s, r) => s + r.calificacion, 0) / conCalificacion.length;
                document.getElementById('statPromedio').textContent = promedio.toFixed(1) + ' ★';
            } else {
                document.getElementById('statPromedio').textContent = '--';
            }
        }

        async function cargarResenas() {
            const grid = document.getElementById('resenas-grid');
            grid.innerHTML = '<div class="col-12 text-center py-5"><div class="spinner-border text-muted"></div><p class="mt-2 text-muted fw-bold small">CARGANDO RESEÑAS...</p></div>';

            try {
                const token = localStorage.getItem('token');
                const res = await fetch(`${API}/gerente/resenas`, {
                    headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                });

                if (!res.ok) {
                    if (res.status === 401 || res.status === 403) { window.location.href = '/login'; return; }
                    throw new Error('Error de red');
                }

                const json = await res.json();
                todasResenas = json.data || [];
                actualizarStats();
                aplicarFiltro();
            } catch (e) {
                console.error(e);
                grid.innerHTML = '<div class="col-12 text-center py-5 text-danger"><i class="bi bi-shield-exclamation fs-1"></i><p class="fw-bold mt-2">Error al cargar las reseñas.</p></div>';
            }
        }

        async function cambiarEstado(id, accion) {
            try {
                const token = localStorage.getItem('token');
                const res = await fetch(`${API}/gerente/resenas/${id}/${accion}`, {
                    method: 'PATCH',
                    headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                });

                if (!res.ok) throw new Error('Error al actualizar');

                const json = await res.json();
                if (json.success) {
                    // Actualizar en memoria
                    const idx = todasResenas.findIndex(r => r.id === id);
                    if (idx !== -1) {
                        todasResenas[idx].estado = json.data.estado;
                    }
                    actualizarStats();
                    aplicarFiltro();

                    Swal.fire({
                        icon: 'success',
                        title: json.message || 'Actualizado',
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
            } catch (e) {
                console.error(e);
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo actualizar la reseña.' });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            cargarResenas();

            document.querySelectorAll('.btn-filtro-resena').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.btn-filtro-resena').forEach(b => {
                        b.classList.remove('btn-dark', 'active');
                        b.classList.add('btn-outline-dark');
                    });
                    btn.classList.remove('btn-outline-dark');
                    btn.classList.add('btn-dark', 'active');
                    filtroActual = btn.dataset.filtro;
                    aplicarFiltro();
                });
            });
        });
    </script>
@endsection
