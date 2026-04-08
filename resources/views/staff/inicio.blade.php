@extends('layouts.mobile')

@section('title', 'Inicio')

@section('content')
<div class="staff-inicio-header text-center mb-4">
    <h2 class="staff-title mb-1 text-uppercase">Inicio</h2>
    <p class="text-muted small mb-3">METRA LUXURY COFFEE</p>
    <div class="staff-date bg-white d-inline-block px-3 py-1 rounded-pill border small fw-bold">
        {{ date('d/m/Y') }}
    </div>
</div>

<div class="welcome-section mb-4">
    <h4 class="fw-bold">¡Bienvenido, <span id="staff-name">Staff</span>!</h4>
</div>

<!-- Summary Section -->
<div class="row g-3 mb-4">
    <div class="col-12" onclick="window.location.href='/staff/reservas'">
        <div class="summary-box d-flex justify-content-between align-items-center active-click">
            <div>
                <h6 class="m-0 text-uppercase fw-bold">Reservas: <span id="count-reservas">--</span></h6>
                <p id="next-reserva" class="small opacity-75">Siguiente: --:--</p>
            </div>
            <div class="summary-icon-box" style="background: rgba(212, 175, 55, 0.1); padding: 12px; border-radius: 12px;">
                <i class="bi bi-calendar-event fs-3 text-gold"></i>
            </div>
        </div>
    </div>
    <div class="col-12" onclick="window.location.href='/staff/mesas'">
        <div class="summary-box d-flex justify-content-between align-items-center active-click">
            <div>
                <h6 class="m-0 text-uppercase fw-bold">Mesas totales: <span id="count-mesas-total">--</span></h6>
                <div class="d-flex gap-3 mt-1">
                    <span class="text-success small fw-bold">Disponibles: <span id="count-mesas-disp">--</span></span>
                    <span class="text-danger small fw-bold">Ocupadas: <span id="count-mesas-ocup">--</span></span>
                </div>
            </div>
            <div class="summary-icon-box" style="background: rgba(212, 175, 55, 0.1); padding: 12px; border-radius: 12px;">
                <i class="bi bi-ui-checks-grid fs-3 text-gold"></i>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Reservations List -->
<div class="next-reservas-section">
    <h6 class="fw-bold mb-3 border-bottom pb-2">Próximas reservas</h6>
    
    <div id="next-reservations-list" class="d-flex flex-column gap-2">
        <!-- Loader placeholder -->
        <div class="text-center py-4 text-muted">
            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
            Cargando reservaciones...
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function fetchDashboardData() {
        try {
            // 1. Obtener Reservaciones
            const off = new Date().getTimezoneOffset();
            const hoyIso = new Date(Date.now() - off * 60000).toISOString().split('T')[0];
            
            const resR = await MetraAPI.get('/staff/reservaciones');
            if (resR.success) {
                const todas = resR.data || [];
                const hoy = todas.filter(r => r.fecha === hoyIso);
                
                document.getElementById('count-reservas').textContent = hoy.length;
                
                const now = new Date();
                const proximas = hoy.filter(r => {
                    const rsrvTime = new Date(`${r.fecha}T${r.hora_inicio}`);
                    return r.estado === 'pendiente' && rsrvTime >= now;
                }).sort((a,b) => new Date(`${a.fecha}T${a.hora_inicio}`) - new Date(`${b.fecha}T${b.hora_inicio}`));

                if (proximas.length > 0) {
                    document.getElementById('next-reserva').textContent = `Siguiente: ${proximas[0].hora_inicio.substring(0,5)}`;
                } else {
                    document.getElementById('next-reserva').textContent = 'Sin pendientes hoy';
                }

                // Renderizar lista
                const list = document.getElementById('next-reservations-list');
                const mostrables = proximas.slice(0, 5);
                
                if (mostrables.length === 0) {
                    list.innerHTML = '<div class="text-center py-4 text-muted small">No hay más reservas pendientes para hoy</div>';
                } else {
                    list.innerHTML = mostrables.map(r => `
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="fw-bold small">${r.hora_inicio.substring(0,5)}</span>
                            <span class="flex-grow-1 mx-3 text-truncate small">${r.nombre_cliente}</span>
                            <span class="text-muted small">${r.numero_personas} pers.</span>
                        </div>
                    `).join('');
                }
            }

            // 2. Obtener Mesas
            const resM = await MetraAPI.get('/staff/mesas-estado');
            if (resM.success) {
                const mesas = resM.data || [];
                document.getElementById('count-mesas-total').textContent = mesas.length;
                document.getElementById('count-mesas-disp').textContent = mesas.filter(m => m.estado === 'disponible').length;
                document.getElementById('count-mesas-ocup').textContent = mesas.filter(m => m.estado === 'ocupada').length;
            }

        } catch (e) {
            console.error('Error loading dashboard:', e);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const userName = localStorage.getItem('user_name') || 'Staff';
        document.getElementById('staff-name').textContent = userName;

        fetchDashboardData();
        setInterval(fetchDashboardData, 30000); // Actualizar cada 30s
    });
</script>
@endpush
