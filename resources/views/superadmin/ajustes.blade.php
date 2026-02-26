@extends('superadmin.menu')

@section('title', 'Ajustes del Sistema')

@section('content')
    <header class="mb-5">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 position-absolute top-0 start-50 translate-middle-x mt-4" style="z-index: 1050;">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="fw-bold" style="color: var(--black-primary);">Configuración Global SaaS</h2>
                <p class="text-muted mb-0">Administra parámetros críticos de la plataforma METRA.</p>
            </div>
            <button type="submit" form="settingsForm" class="btn-metra-main w-100 w-md-auto" style="padding: 12px 28px;">
                <i class="bi bi-save2-fill me-2"></i>Guardar Cambios
            </button>
        </div>
    </header>

    <form id="settingsForm" action="/superadmin/guardar-ajustes" method="POST">
        <div class="row g-4">
            
            <!-- Columna Izquierda: Configuración de Negocio -->
            <div class="col-12 col-md-8">
                
                <!-- Sección Precios -->
                <div class="premium-card p-4 mb-4">
                    <h5 class="fw-bold mb-4 text-primary" style="color: var(--black-primary) !important;"><i class="bi bi-cash-coin me-2" style="color: var(--accent-gold);"></i>Precios de Suscripción (MXN)</h5>
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <label class="form-label small fw-bold text-muted">Plan Básico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0" style="background: var(--off-white) !important; border-radius: 8px 0 0 8px;">$</span>
                                <input type="number" class="form-control form-metra border-0" value="299" placeholder="0.00" style="border-radius: 0 8px 8px 0; background: var(--off-white) !important;">
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="form-label small fw-bold text-muted">Plan Pro</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0" style="background: var(--off-white) !important; border-radius: 8px 0 0 8px;">$</span>
                                <input type="number" class="form-control form-metra border-0" value="499" placeholder="0.00" style="border-radius: 0 8px 8px 0; background: var(--off-white) !important;">
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="form-label small fw-bold text-muted">Plan Premium</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0" style="background: var(--off-white) !important; border-radius: 8px 0 0 8px;">$</span>
                                <input type="number" class="form-control form-metra border-0" value="899" placeholder="0.00" style="border-radius: 0 8px 8px 0; background: var(--off-white) !important;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección Límites -->
                <div class="premium-card p-4 mb-4">
                    <h5 class="fw-bold mb-4" style="color: var(--black-primary);"><i class="bi bi-speedometer2 me-2" style="color: var(--accent-gold);"></i>Límites por Plan</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead class="text-muted small text-uppercase">
                                <tr>
                                    <th>Característica</th>
                                    <th>Básico</th>
                                    <th>Pro</th>
                                    <th>Premium</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-muted">Máx. Reservas / Mes</td>
                                    <td><input type="number" class="form-control form-metra form-control-sm border-0" value="100" style="background: var(--off-white) !important;"></td>
                                    <td><input type="number" class="form-control form-metra form-control-sm border-0" value="500" style="background: var(--off-white) !important;"></td>
                                    <td><input type="text" class="form-control form-metra form-control-sm border-0" value="Ilimitado" readonly style="background: var(--off-white) !important;"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Máx. Usuarios Admin</td>
                                    <td><input type="number" class="form-control form-metra form-control-sm border-0" value="1" style="background: var(--off-white) !important;"></td>
                                    <td><input type="number" class="form-control form-metra form-control-sm border-0" value="3" style="background: var(--off-white) !important;"></td>
                                    <td><input type="number" class="form-control form-metra form-control-sm border-0" value="10" style="background: var(--off-white) !important;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Sección Información de Contacto -->
                <div class="premium-card p-4">
                    <h5 class="fw-bold mb-4" style="color: var(--black-primary);"><i class="bi bi-info-circle me-2" style="color: var(--accent-gold);"></i>Información de Soporte</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Email de Soporte</label>
                            <input type="email" class="form-control form-metra" value="soporte@vtech.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Teléfono / WhatsApp</label>
                            <input type="text" class="form-control form-metra" value="+52 55 1234 5678">
                        </div>
                    </div>
                </div>

            </div>

            <!-- Columna Derecha: Sistema -->
            <div class="col-12 col-md-4">
                
                <!-- Estado del Sistema -->
                <div class="premium-card p-4 mb-4">
                    <h5 class="fw-bold mb-3 text-danger"><i class="bi bi-shield-exclamation me-2"></i>Estado del Sistema</h5>
                    
                    <div class="form-check form-switch p-0 m-0 d-flex justify-content-between align-items-center mb-3">
                        <label class="form-check-label fw-bold" for="maintenanceMode">Modo Mantenimiento</label>
                        <input class="form-check-input ms-0" type="checkbox" role="switch" id="maintenanceMode" style="width: 3em; height: 1.5em;">
                    </div>
                    <p class="small text-muted mb-0">
                        Si activas esto, solo los Superadmins podrán acceder. Los restaurantes y clientes verán una página de "En Mantenimiento".
                    </p>
                </div>

                <!-- Información Técnica -->
                <div class="premium-card p-4">
                    <h5 class="fw-bold mb-3" style="color: var(--black-primary);"><i class="bi bi-code-square me-2" style="color: var(--accent-gold);"></i>Build Info</h5>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Versión Laravel</span>
                            <span class="fw-bold">11.x</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Entorno</span>
                            <span class="badge bg-success-subtle text-success">Producción</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Último Despliegue</span>
                            <span class="fw-bold">09 Feb, 2026</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </form>
@endsection