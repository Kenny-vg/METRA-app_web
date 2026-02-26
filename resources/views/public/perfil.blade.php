@extends('public.layout_cliente') 
@section('title', 'Portal del Cliente')

@section('content')
<div class="container-fluid px-0 px-lg-4">
    <div class="row g-4 g-lg-5">
        <!-- Columna de Perfil Lateral -->
        <div class="col-12 col-md-4 col-xl-3">
            <div class="card border-0 rounded-4 p-4 text-center h-100" style="background: var(--white-pure); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                <div class="mb-4">
                    <img src="https://ui-avatars.com/api/?name=Maria+Juanita&background=0A0A0A&color=FFFFFF" class="rounded-circle" width="100" style="border: 4px solid var(--off-white); box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                </div>
                <h4 class="fw-bold mb-1" style="color: var(--black-primary); letter-spacing: -0.5px;">Maria Juanita</h4>
                <p class="small mb-4" style="color: var(--text-muted); font-weight: 500;">lllllll@gmail.com</p>
                
                <hr style="border-color: var(--border-light); opacity: 1;" class="w-75 mx-auto mb-4">

                <div class="d-grid gap-3 mt-2">
                    <a href="/reservar" class="btn-metra-main rounded-pill fw-bold py-3" style="font-size: 0.95rem;">
                        <i class="bi bi-calendar-plus me-2"></i>Nueva Reservación
                    </a>
                    
                    <a href="/logout" id="btnCerrarSesionCliente" class="btn rounded-pill fw-bold py-3" style="background: var(--off-white); border: 1px solid var(--border-light); color: var(--text-main); font-size: 0.9rem; transition: background 0.3s;">
                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>

        <!-- Columna de Actividad / Reservas -->
        <div class="col-12 col-md-8 col-xl-9">
            <div class="card border-0 rounded-4 p-4 p-lg-5" style="background: var(--white-pure); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                
                <div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                    <h4 class="fw-bold m-0" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -0.5px;">Agenda de Experiencias</h4>
                    <span class="badge rounded-pill px-3 py-2" style="background: var(--off-white); border: 1px solid var(--border-light); color: var(--text-main); font-weight: 600;">1 Próxima</span>
                </div>
                
                <!-- Ticket SaaS -->
                <div class="p-4 rounded-4 mb-4" style="background: var(--white-pure); border: 1px solid var(--border-light); box-shadow: 0 4px 15px rgba(0,0,0,0.02); transition: all 0.3s ease;">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-8 mb-3 mb-lg-0">
                            <div class="d-flex align-items-start">
                                <div class="me-4 d-none d-sm-block">
                                    <div class="text-center rounded-3 p-2" style="background: var(--off-white); min-width: 60px; border: 1px solid var(--border-light);">
                                        <span class="d-block fw-bold fs-5" style="color: var(--black-primary); line-height: 1;">15</span>
                                        <span class="d-block small text-uppercase" style="color: var(--text-muted); font-weight: 700; font-size: 0.7rem;">Feb</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge rounded-pill me-2" style="background: #E8F5E9; color: #2E7D32; border: 1px solid #C8E6C9; padding: 6px 12px; font-weight: 700; font-size: 0.7rem; letter-spacing: 0.5px;">Confirmada</span>
                                        <span class="small fw-bold" style="color: var(--text-muted); letter-spacing: 1px;">#MET-2026</span>
                                    </div>
                                    <h5 class="fw-bold mb-1" style="color: var(--black-primary); letter-spacing: -0.5px;">Café Central Tehuacán</h5>
                                    <p class="m-0 small" style="color: var(--text-muted);">
                                        <i class="bi bi-clock me-1"></i> Domingo, 08:30 PM &nbsp;•&nbsp; <i class="bi bi-people me-1"></i> 2 Invitados
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 text-lg-end border-lg-start" style="border-color: var(--border-light) !important;">
                            <div class="ps-lg-3">
                                <button class="btn btn-sm w-100 mb-2 py-2 fw-bold" style="background: var(--black-primary); color: var(--white-pure); border-radius: 6px; font-size: 0.85rem;">Ver Detalles</button>
                                <button class="btn btn-sm w-100 py-2 fw-bold" style="background: var(--white-pure); border: 1px solid var(--border-light); color: #D32F2F; border-radius: 6px; font-size: 0.85rem;">Cancelar Reserva</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Ticket SaaS -->

            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('btnCerrarSesionCliente')?.addEventListener('click', function(e) {
    e.preventDefault();
    localStorage.removeItem('token');
    localStorage.clear();
    window.location.href = '/logout';
});
</script>
@endsection