@extends('public.layout_cliente') 
@section('title', 'Portal del Cliente')

@section('content')
<div class="container-fluid px-0 px-lg-4">
    <div class="row g-4 g-lg-5">
        <!-- Columna de Perfil Lateral -->
        <div class="col-12 col-md-4 col-xl-3">
            <div class="card border-0 rounded-4 p-4 text-center h-100" style="background: var(--white-pure); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                <div class="mb-4">
                    <img id="profileAvatar" src="https://ui-avatars.com/api/?name=User&background=0A0A0A&color=FFFFFF" class="rounded-circle" width="100" style="border: 4px solid var(--off-white); box-shadow: 0 4px 15px rgba(0,0,0,0.08);" referrerpolicy="no-referrer">
                </div>
                <h4 id="profileName" class="fw-bold mb-1" style="color: var(--black-primary); letter-spacing: -0.5px;">Cargando...</h4>
                <p id="profileEmail" class="small mb-4" style="color: var(--text-muted); font-weight: 500;">Cargando...</p>
                
                <hr style="border-color: var(--border-light); opacity: 1;" class="w-75 mx-auto mb-4">

                <div class="d-grid gap-3 mt-2">
                    <a href="{{ url('/#cafeterias') }}" class="btn-metra-main rounded-pill fw-bold py-3" style="font-size: 0.95rem;">
                        <i class="bi bi-calendar-plus me-2"></i>Nueva Reservación
                    </a>
                    
                    <a href="{{ url('/logout') }}" id="btnCerrarSesionCliente" class="btn rounded-pill fw-bold py-3" style="background: var(--off-white); border: 1px solid var(--border-light); color: var(--text-main); font-size: 0.9rem; transition: background 0.3s;">
                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>

        <!-- Columna de Actividad / Reservas -->
        <div class="col-12 col-md-8 col-xl-9">
            <div class="card border-0 rounded-4 p-4 p-lg-5" style="background: var(--white-pure); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                
                <div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                    <h4 class="fw-bold m-0" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -0.5px;">Mis Reservaciones</h4>
                    <span class="badge rounded-pill px-3 py-2" id="badge-count" style="background: var(--off-white); border: 1px solid var(--border-light); color: var(--text-main); font-weight: 600;">...</span>
                </div>

                <!-- Estado: cargando -->
                <div id="reservas-loading" class="text-center py-5">
                    <div class="spinner-border spinner-border-sm" style="color: var(--accent-gold);" role="status"></div>
                    <p class="mt-2 small text-muted fw-bold">Cargando reservaciones...</p>
                </div>

                <!-- Estado: vacío -->
                <div id="reservas-empty" style="display: none;" class="text-center py-5">
                    <i class="bi bi-calendar-x fs-1" style="color: var(--border-light);"></i>
                    <p class="mt-3 fw-bold" style="color: var(--text-muted);">Todavía no tienes reservaciones.</p>
                    <a href="{{ url('/') }}" class="btn-metra-main rounded-pill fw-bold px-4 py-2 mt-2" style="font-size: 0.9rem;">
                        <i class="bi bi-calendar-plus me-2"></i>Hacer una reservación
                    </a>
                </div>

                <!-- Estado: lista -->
                <div id="reservas-list" style="display: none;"></div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const BASE_URL = "{{ url('/') }}";
const MESES    = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];

function getToken() {
    return localStorage.getItem('token');
}

function formatFechaCorta(isoDate) {
    const [y, m, d] = isoDate.split('-');
    return { dia: parseInt(d), mes: MESES[parseInt(m)-1] };
}

function getEstadoBadge(r) {
    const inicio = new Date(`${r.fecha}T${r.hora_inicio}`);
    if (r.estado === 'cancelada')  return { bg:'#fce8e8', color:'#c62828', border:'#f5c6cb', label:'Cancelada' };
    if (r.estado === 'completada') return { bg:'#e8f5e9', color:'#2e7d32', border:'#c8e6c9', label:'Completada' };
    if (inicio < new Date())       return { bg:'#f0f0f0', color:'#757575', border:'#e0e0e0', label:'Pasada' };
    return                                { bg:'#e8f5e9', color:'#2e7d32', border:'#c8e6c9', label:'Confirmada' };
}

function esCancelable(r) {
    if (r.estado === 'cancelada' || r.estado === 'completada') return false;
    return new Date(`${r.fecha}T${r.hora_inicio}`) > new Date();
}

function renderReservaciones(reservas) {
    const listEl    = document.getElementById('reservas-list');
    const loadingEl = document.getElementById('reservas-loading');
    const emptyEl   = document.getElementById('reservas-empty');
    const badgeEl   = document.getElementById('badge-count');

    loadingEl.style.display = 'none';

    if (!reservas.length) {
        emptyEl.style.display = 'block';
        badgeEl.textContent   = '0 reservas';
        return;
    }

    const proximas = reservas.filter(r => r.estado !== 'cancelada' && new Date(`${r.fecha}T${r.hora_inicio}`) >= new Date());
    badgeEl.textContent = proximas.length > 0 ? `${proximas.length} próxima${proximas.length > 1 ? 's' : ''}` : 'Sin próximas';

    let html = '';

    // Renderizar todas las reservas ordenadas
    reservas.forEach(r => {
        const { dia, mes } = formatFechaCorta(r.fecha);
        const badge = getEstadoBadge(r);
        const cancelable = esCancelable(r);
        const opacidad = (r.estado === 'cancelada' || (r.estado !== 'completada' && new Date(`${r.fecha}T${r.hora_inicio}`) < new Date())) ? 'opacity: 0.65;' : '';

        html += `
        <div class="p-4 rounded-4 mb-3" style="background: var(--white-pure); border: 1px solid var(--border-light); transition: all 0.2s ease; ${opacidad}">
            <div class="row align-items-center">
                <div class="col-12 col-lg-8 mb-3 mb-lg-0">
                    <div class="d-flex align-items-start">
                        <div class="me-4 d-none d-sm-block text-center rounded-3 p-2" style="background: var(--off-white); min-width: 60px; border: 1px solid var(--border-light);">
                            <span class="d-block fw-bold fs-5" style="color: var(--black-primary); line-height: 1;">${dia}</span>
                            <span class="d-block small text-uppercase" style="color: var(--text-muted); font-weight: 700; font-size: 0.7rem;">${mes}</span>
                        </div>
                        <div>
                            <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                <span class="badge rounded-pill" style="background: ${badge.bg}; color: ${badge.color}; border: 1px solid ${badge.border}; padding: 5px 12px; font-weight: 700; font-size: 0.7rem; letter-spacing: 0.5px;">${badge.label}</span>
                                <span class="small fw-bold" style="color: var(--text-muted); letter-spacing: 1px; font-family: monospace;">${r.folio}</span>
                            </div>
                            <h6 class="fw-bold mb-1" style="color: var(--black-primary);">${escapeHTML(r.cafeteria ? r.cafeteria.nombre : '—')}</h6>
                            <p class="m-0 small" style="color: var(--text-muted);">
                                <i class="bi bi-clock me-1"></i>${r.hora_inicio.substring(0,5)} hrs
                                &nbsp;•&nbsp;
                                <i class="bi bi-people me-1"></i>${r.numero_personas} ${r.numero_personas > 1 ? 'personas' : 'persona'}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 text-lg-end">
                    <div class="ps-lg-3 d-flex flex-column gap-2">
                        <a href="${BASE_URL}/confirmacion/${r.folio}" class="btn btn-sm py-2 fw-bold w-100" style="background: var(--black-primary); color: var(--white-pure); border-radius: 6px; font-size: 0.82rem;">
                            <i class="bi bi-eye me-1"></i>Ver Detalles
                        </a>
                        ${cancelable ? `
                        <button onclick="cancelarReservacion(${r.id}, '${r.folio}', '${r.fecha}', '${r.hora_inicio}')"
                            class="btn btn-sm py-2 fw-bold w-100"
                            style="background: var(--white-pure); border: 1px solid var(--border-light); color: #D32F2F; border-radius: 6px; font-size: 0.82rem;">
                            <i class="bi bi-x-circle me-1"></i>Cancelar
                        </button>` : ''}
                    </div>
                </div>
            </div>
        </div>`;
    });

    listEl.innerHTML  = html;
    listEl.style.display = 'block';
}

async function cargarReservaciones() {
    const token = getToken();
    if (!token) return;
    try {
        const json = await MetraAPI.get('/reservaciones');
        // Ordenar: primero próximas (asc), luego pasadas (desc)
        const data = (json.data || []).sort((a, b) => {
            const da = new Date(`${a.fecha}T${a.hora_inicio}`);
            const db = new Date(`${b.fecha}T${b.hora_inicio}`);
            const now = new Date();
            const aFut = da >= now, bFut = db >= now;
            if (aFut && !bFut) return -1;
            if (!aFut && bFut) return 1;
            return aFut ? da - db : db - da;
        });

        // Necesitamos el nombre de la cafeteria — lo añadimos si viene como relación
        renderReservaciones(data);
    } catch(e) {
        document.getElementById('reservas-loading').innerHTML =
            '<p class="text-danger small fw-bold">Error al cargar reservaciones.</p>';
    }
}

window.cancelarReservacion = async function(id, folio, fecha, hora) {
    const confirm = await Swal.fire({
        title: '¿Cancelar reservación?',
        html: `Folio <strong>${folio}</strong><br>Fecha: <strong>${fecha}</strong> a las <strong>${hora.substring(0,5)} hrs</strong>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#c62828',
        cancelButtonColor: '#111',
        confirmButtonText: 'Sí, cancelar',
        cancelButtonText: 'No, mantener'
    });
    if (!confirm.isConfirmed) return;

    const token = getToken();
    try {
        const json = await MetraAPI.delete(`/reservaciones/${id}`);
        await Swal.fire({ icon: 'success', title: 'Cancelada', text: 'Tu reservación fue cancelada.', confirmButtonColor: '#111' });
        cargarReservaciones(); // Recargar lista
    } catch(error) {
        const data = error.data || {};
        Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Intenta de nuevo.', confirmButtonColor: '#111' });
    }
};

document.addEventListener('DOMContentLoaded', async function() {
    const token = getToken();
    if (!token) {
        window.location.href = `${BASE_URL}/login`;
        return;
    }

    // Cargar perfil
    try {
        const data = await MetraAPI.get('/mi-perfil');
        const user = data.data.usuario;
        document.getElementById('profileName').textContent  = user.name;
        document.getElementById('profileEmail').textContent = user.email;
        document.getElementById('profileAvatar').src = user.avatar
            ? user.avatar
            : `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=0A0A0A&color=FFFFFF`;
    } catch (error) {
        console.error('Error cargando perfil:', error);
    }

    // Cargar reservaciones
    cargarReservaciones();
});

document.getElementById('btnCerrarSesionCliente')?.addEventListener('click', async function(e) {
    e.preventDefault();
    const token = getToken();
    if (token) {
        try {
            await MetraAPI.post('/logout', {});
        } catch (e) { console.error('Error API Logout', e); }
    }
    localStorage.clear();
    window.location.href = `${BASE_URL}/login`;
});
</script>

@endsection