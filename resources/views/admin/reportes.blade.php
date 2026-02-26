@extends('admin.menu')
@section('title', 'Reportes y Analíticas')

@section('content')
    <header class="mb-5 border-bottom pb-4" style="border-color: var(--border-light) !important;">
        <h2 class="fw-bold" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Centro de Analíticas</h2>
        <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Visualiza métricas avanzadas y comportamiento de tu ecosistema.</p>
    </header>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <div class="btn-group bg-white p-1 rounded-pill" style="border: 1px solid var(--border-light); box-shadow: 0 2px 5px rgba(0,0,0,0.02);" role="group">
            <input type="radio" class="btn-check" name="filtroMetricas" id="rangoSemanal" checked>
            <label class="btn btn-admin-secondary border-0 rounded-pill px-4 btn-sm shadow-none m-0" for="rangoSemanal">Semana Actual</label>

            <input type="radio" class="btn-check" name="filtroMetricas" id="rangoMensual">
            <label class="btn btn-admin-secondary border-0 rounded-pill px-4 btn-sm shadow-none m-0" for="rangoMensual">Mes</label>

            <input type="radio" class="btn-check" name="filtroMetricas" id="rangoAnual">
            <label class="btn btn-admin-secondary border-0 rounded-pill px-4 btn-sm shadow-none m-0" for="rangoAnual">Año</label>
        </div>
        
        <button class="btn-admin-secondary px-4 py-2">
            <i class="bi bi-cloud-download me-2"></i>Exportar CSV
        </button>
    </div>

    <!-- KPI Cards de Reportes -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 p-4 h-100" style="background: var(--white-pure); border-radius: 12px; border: 1px solid rgba(0,0,0,0.03) !important;">
                <p class="small fw-bold text-uppercase mb-1" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.7rem;">Tráfico Total</p>
                <h3 class="fw-bold m-0" style="color: var(--black-primary); font-size: 2rem; letter-spacing: -1px;">1,432</h3>
                <span class="badge mt-2 align-self-start" style="background: #E8F5E9; color: #2E7D32; border: 1px solid #C8E6C9; padding: 4px 8px;">+12% <i class="bi bi-arrow-up"></i></span>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
             <div class="card border-0 p-4 h-100" style="background: var(--white-pure); border-radius: 12px; border: 1px solid rgba(0,0,0,0.03) !important;">
                <p class="small fw-bold text-uppercase mb-1" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.7rem;">Reservas Cumplidas</p>
                <h3 class="fw-bold m-0" style="color: var(--black-primary); font-size: 2rem; letter-spacing: -1px;">89%</h3>
                <span class="badge mt-2 align-self-start" style="background: var(--off-white); color: var(--text-main); border: 1px dashed var(--border-light); padding: 4px 8px;">Constante</span>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
             <div class="card border-0 p-4 h-100" style="background: var(--white-pure); border-radius: 12px; border: 1px solid rgba(0,0,0,0.03) !important;">
                <p class="small fw-bold text-uppercase mb-1" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.7rem;">No Presentados (No-Show)</p>
                <h3 class="fw-bold m-0" style="color: var(--black-primary); font-size: 2rem; letter-spacing: -1px;">11%</h3>
                <span class="badge mt-2 align-self-start" style="background: #FFEBEE; color: #C62828; border: 1px solid #FFCDD2; padding: 4px 8px;">-2% <i class="bi bi-arrow-down"></i></span>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
             <div class="card border-0 p-4 h-100" style="background: var(--black-primary); border-radius: 12px;">
                <p class="small fw-bold text-uppercase mb-1" style="color: rgba(255,255,255,0.6); letter-spacing: 1px; font-size: 0.7rem;">Ingreso Promedio / Reserva</p>
                <h3 class="fw-bold m-0" style="color: var(--accent-gold); font-size: 2rem; letter-spacing: -1px;">$840<span class="fs-5 fw-normal" style="color: rgba(255,255,255,0.6);"> MXN</span></h3>
                <span class="badge mt-2 align-self-start" style="background: rgba(255,255,255,0.1); color: var(--white-pure); padding: 4px 8px; font-weight: 500;">Proyectado</span>
            </div>
        </div>
    </div>

    <!-- Gráficas Placeholder -->
    <div class="row g-4">
        <div class="col-12 col-xl-8">
            <div class="card border-0 p-4 p-md-5 h-100 rounded-4" style="background: var(--white-pure); box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary);"><i class="bi bi-bar-chart-line me-2"></i>Fluctuación de Afluencia</h5>
                </div>
                <!-- Placeholder de gráfica SaaS -->
                <div class="w-100 d-flex align-items-center justify-content-center flex-column rounded-3" style="height: 350px; background: var(--off-white); border: 1px dashed var(--border-light); position: relative; overflow: hidden;">
                    <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 60%; background: linear-gradient(180deg, transparent 0%, rgba(10,10,10,0.03) 100%);"></div>
                    <i class="bi bi-graph-up text-muted mb-2" style="font-size: 2rem; opacity: 0.5;"></i>
                    <p class="small fw-bold text-muted m-0 text-uppercase" style="letter-spacing: 1px;">Área de Visualización de Datos (Líneas)</p>
                    <p class="small text-muted" style="font-size: 0.75rem;">Requiere integración de librería (ej. Chart.js)</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
             <div class="card border-0 p-4 p-md-5 h-100 rounded-4" style="background: var(--white-pure); box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
                <div class="mb-4">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary);"><i class="bi bi-pie-chart me-2"></i>Segmentación</h5>
                </div>
                 <!-- Placeholder de gráfica SaaS de pastel -->
                <div class="w-100 d-flex align-items-center justify-content-center flex-column rounded-3" style="height: 350px; background: transparent; border: 1px dashed var(--border-light);">
                    <div class="rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; border: 20px solid var(--off-white); border-top-color: var(--black-primary); border-right-color: var(--black-primary);">
                         <span class="fs-4 fw-bold" style="color: var(--black-primary);">50%</span>
                    </div>
                    <div class="w-100 mt-4 px-3">
                        <div class="d-flex justify-content-between mb-2 small"><span class="text-muted"><i class="bi bi-circle-fill me-2" style="color: var(--black-primary); font-size: 0.5rem;"></i>Parejas (2 pax)</span><span class="fw-bold">50%</span></div>
                        <div class="d-flex justify-content-between mb-2 small"><span class="text-muted"><i class="bi bi-circle-fill me-2" style="color: var(--off-white); font-size: 0.5rem; border: 1px solid var(--border-light); border-radius: 50%;"></i>Grupos (4+ pax)</span><span class="fw-bold">35%</span></div>
                        <div class="d-flex justify-content-between small"><span class="text-muted"><i class="bi bi-circle-fill me-2" style="color: var(--accent-gold); font-size: 0.5rem;"></i>Ejecutivo (1 pax)</span><span class="fw-bold">15%</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer_admin')
    
    <!-- Script para efecto visual de tabs reportes -->
    <script>
        document.querySelectorAll('input[name="filtroMetricas"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('label[for^="rango"]').forEach(label => {
                    label.classList.remove('bg-dark', 'text-white');
                    label.style.color = "var(--text-muted)";
                });
                
                if (this.checked) {
                    const activeLabel = document.querySelector('label[for="' + this.id + '"]');
                    activeLabel.classList.add('bg-dark', 'text-white');
                    activeLabel.style.color = "white";
                }
            });
        });
        
        const initialSelectedIdRep = document.querySelector('input[name="filtroMetricas"]:checked').id;
        const initialActiveLabelRep = document.querySelector('label[for="' + initialSelectedIdRep + '"]');
        if (initialActiveLabelRep) {
            initialActiveLabelRep.classList.add('bg-dark', 'text-white');
            initialActiveLabelRep.style.color = "white";
        }
    </script>
@endsection