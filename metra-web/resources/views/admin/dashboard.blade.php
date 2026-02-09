@extends('admin.menu')
@section('title', 'Dashboard Administrador')

@section('content')
    <header class="mb-5">
        <h2 class="fw-bold">Resumen de Operaciones</h2>
        <p class="text-muted">Estado actual de Café Central</p>
    </header>
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="metric-card">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted fw-bold">RESERVAS HOY</small>
                        <i class="bi bi-people text-muted"></i>
                    </div>
                    <div class="metric-value">24</div>
                    <small class="text-success fw-bold">+15% vs ayer</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted fw-bold">Horas Pico</small>
                        <i class="bi bi-currency-dollar text-muted"></i>
                    </div>
                    <div class="metric-value">6:00 PM</div>
                    <small class="text-muted">A 8:00PM</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted fw-bold">MESAS OCUPADAS</small>
                        <i class="bi bi-check-circle text-muted"></i>
                    </div>
                    <div class="metric-value">18</div>
                    <small class="text-muted">De 25 totales</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card" style="background-color: #4E342E; color: white;">
                    <div class="d-flex justify-content-between">
                        <small class="text-white-50 fw-bold">Próxima reserva:</small>
                        <i class="bi bi-clock text-white-50"></i>
                    </div>
                    <div class="metric-value text-white">8:00PM</div>
                    <small class="text-white-50">Por mesa</small>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-7">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                    <h6 class="fw-bold mb-4">Análisis de Ocupación Semanal</h6>
                    <img src="https://support.content.office.net/es-es/media/9d77e47a-6f77-4977-90c2-511a2f605f6b.png" 
                         class="chart-box-image" alt="Gráfica de minería de datos">
                    <div class="mt-3 small text-muted text-center">
                        <i class="bi bi-info-circle me-1"></i> Gráfica generada mediante datos históricos de reservaciones
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                    <h6 class="fw-bold mb-4">Últimas Reservaciones</h6>
                    <div class="overflow-auto" style="max-height: 400px;">
                        
                        <div class="reservation-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold d-block">Mariana Sánchez</span>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i>20:30 PM • 4 pers.</small>
                            </div>
                            <span class="badge rounded-pill" style="background-color: #689F38;">Confirmada</span>
                        </div>

                        <div class="reservation-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold d-block">Juan Pablo Montes</span>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i>21:00 PM • 2 pers.</small>
                            </div>
                            <span class="badge rounded-pill" style="background-color: #FFA000;">Pendiente</span>
                        </div>

                        <div class="reservation-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold d-block">Roberto Gómez</span>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i>21:15 PM • 6 pers.</small>
                            </div>
                            <span class="badge rounded-pill" style="background-color: #689F38;">Confirmada</span>
                        </div>

                        <div class="reservation-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold d-block">Elena Torres</span>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i>22:00 PM • 2 pers.</small>
                            </div>
                            <span class="badge rounded-pill bg-danger">Cancelada</span>
                        </div>

                        <div class="reservation-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold d-block">Carlos Slim</span>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i>22:30 PM • 10 pers.</small>
                            </div>
                            <span class="badge rounded-pill" style="background-color: #FFA000;">Pendiente</span>
                        </div>

                    </div>
                    <button class="btn btn-link btn-sm w-100 mt-3 text-decoration-none" style="color: #6D4C41;">
                        Ver todas las reservas del día
                    </button>
                </div>
            </div>
        </div>
         @include('partials.footer_admin')
@endsection