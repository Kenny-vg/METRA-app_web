@extends('admin.menu')
@section('title', 'Métricas General')

@section('content')
    <header class="mb-5 border-bottom pb-4" style="border-color: var(--border-light) !important;">
        <h2 class="fw-bold" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Resumen Operativo</h2>
        <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Métricas clave de Café Central en tiempo real.</p>
    </header>

    <div class="row g-4 mb-5">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 p-4 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small fw-bold text-uppercase" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.7rem;">Reservas de Hoy</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--off-white); color: var(--black-primary);">
                        <i class="bi bi-people-fill fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" style="color: var(--black-primary); font-size: 2.2rem; letter-spacing: -1px;">24</h3>
                <div class="d-flex align-items-center mt-2">
                    <span class="badge rounded-pill" style="background: rgba(46, 125, 50, 0.1); color: #2E7D32; border: 1px solid rgba(46, 125, 50, 0.2); font-weight: 700;">+15%</span>
                    <span class="small ms-2" style="color: var(--text-muted); font-size: 0.75rem;">vs ayer</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 p-4 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small fw-bold text-uppercase" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.7rem;">Horas Pico</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--off-white); color: var(--black-primary);">
                        <i class="bi bi-bar-chart-fill fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" style="color: var(--black-primary); font-size: 2.2rem; letter-spacing: -1px;">06:00<span class="fs-5 text-muted fw-normal">PM</span></h3>
                <div class="d-flex align-items-center mt-2">
                    <span class="small" style="color: var(--text-muted); font-size: 0.75rem;">Tendencia estable</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 p-4 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small fw-bold text-uppercase" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.7rem;">Ocupación</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--off-white); color: var(--black-primary);">
                        <i class="bi bi-grid-fill fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" style="color: var(--black-primary); font-size: 2.2rem; letter-spacing: -1px;">18<span class="fs-5 text-muted fw-normal">/25</span></h3>
                <div class="progress mt-3" style="height: 6px; background: var(--off-white);">
                    <div class="progress-bar" role="progressbar" style="width: 72%; background: var(--black-primary);" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 p-4 h-100 position-relative overflow-hidden" style="background: var(--black-primary); border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                <!-- Decoración -->
                <div style="position: absolute; right: -20px; top: -20px; width: 100px; height: 100px; background: var(--accent-gold); border-radius: 50%; opacity: 0.1; filter: blur(20px);"></div>
                
                <div class="d-flex justify-content-between align-items-center mb-3 position-relative z-1">
                    <span class="small fw-bold text-uppercase" style="color: rgba(255,255,255,0.6); letter-spacing: 1px; font-size: 0.7rem;">Próxima Llegada</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); color: var(--accent-gold);">
                        <i class="bi bi-clock-history fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1 position-relative z-1" style="color: var(--white-pure); font-size: 2.2rem; letter-spacing: -1px;">08:00<span class="fs-5 fw-normal" style="color: rgba(255,255,255,0.6);">PM</span></h3>
                <div class="d-flex align-items-center mt-2 position-relative z-1">
                    <span class="small" style="color: var(--accent-gold); font-size: 0.75rem; font-weight: 600;">Mesa VIP Preparada</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Gráficos y Tablas -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-xl-7">
            <div class="card border-0 p-4 p-lg-5 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Flujo Analítico (Demostración)</h5>
                    <button class="btn-admin-secondary"><i class="bi bi-download me-2"></i>Exportar</button>
                </div>
                <div class="text-center py-3">
                    <img src="https://support.content.office.net/es-es/media/9d77e47a-6f77-4977-90c2-511a2f605f6b.png" 
                         class="img-fluid rounded-3" alt="Gráfica de minería de datos" style="opacity: 0.85; mix-blend-mode: multiply; filter: grayscale(100%) contrast(1.2);">
                    <p class="mt-4 small" style="color: var(--text-muted);"><i class="bi bi-lightning-charge me-1"></i> Análisis proyectado de afluencia semanal.</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5">
             <div class="card border-0 p-4 p-lg-5 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Panel de Llegadas</h5>
                    <a href="/admin/reservaciones" class="small fw-bold text-decoration-none" style="color: var(--text-muted);">Ver todo →</a>
                </div>

                <div class="d-flex flex-column gap-3 overflow-auto pe-2" style="max-height: 400px;">
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="border: 1px solid var(--border-light); background: var(--off-white);">
                        <div>
                            <span class="fw-bold d-block" style="color: var(--black-primary);">Mariana Sánchez</span>
                            <small style="color: var(--text-muted); font-size: 0.8rem;"><i class="bi bi-clock me-1"></i>20:30 PM &nbsp;•&nbsp; 4 pax</small>
                        </div>
                        <span class="badge" style="background: rgba(0,0,0,0.05); color: var(--black-primary); border: 1px solid rgba(0,0,0,0.1);">Confirmada</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="border: 1px solid var(--border-light); background: transparent;">
                        <div>
                            <span class="fw-bold d-block" style="color: var(--black-primary);">Juan Pablo Montes</span>
                            <small style="color: var(--text-muted); font-size: 0.8rem;"><i class="bi bi-clock me-1"></i>21:00 PM &nbsp;•&nbsp; 2 pax</small>
                        </div>
                        <span class="badge" style="background: var(--white-pure); color: var(--text-muted); border: 1px dashed var(--border-light);">Pendiente</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="border: 1px solid var(--border-light); background: var(--off-white);">
                        <div>
                            <span class="fw-bold d-block" style="color: var(--black-primary);">Roberto Gómez</span>
                            <small style="color: var(--text-muted); font-size: 0.8rem;"><i class="bi bi-clock me-1"></i>21:15 PM &nbsp;•&nbsp; 6 pax</small>
                        </div>
                        <span class="badge" style="background: rgba(0,0,0,0.05); color: var(--black-primary); border: 1px solid rgba(0,0,0,0.1);">Confirmada</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    @include('partials.footer_admin')
@endsection