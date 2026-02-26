@extends('superadmin.menu')

@section('title', 'Suscripciones')

@section('content')
    <header class="mb-5">
        <h2 class="fw-bold">Gestión de Suscripciones</h2>
        <p class="text-muted">Control de ingresos y estados de cuenta de los negocios en METRA.</p>
    </header>

    <div class="premium-card p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <h5 class="fw-bold m-0" style="color: var(--black-primary);"><i class="bi bi-credit-card-2-front me-2" style="color: var(--accent-gold);"></i>Control de Pagos y Planes</h5>
            <div class="input-group" style="max-width: 300px;">
                <span class="input-group-text bg-light border-0" style="background: var(--off-white) !important; border-radius: 8px 0 0 8px;"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar negocio..." style="border-radius: 0 8px 8px 0; background: var(--off-white) !important;">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="small text-muted text-uppercase">
                        <th>Negocio</th>
                        <th>Plan Actual</th>
                        <th>Monto Mensual</th>
                        <th>Próximo Pago</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold" style="color: var(--black-primary);">Café Central</td>
                        <td><span class="badge rounded-pill px-3" style="background: #FFF8E1; color: #FFA000; border: 1px solid #FFE082;">Plan Pro</span></td>
                        <td class="fw-bold" style="color: var(--black-primary);">$499.00</td>
                        <td style="color: var(--text-muted);">15 Feb, 2026</td>
                        <td><span class="badge rounded-pill px-3" style="background: #E8F5E9; color: #2E7D32; border: 1px solid #A5D6A7;">● Al corriente</span></td>
                        <td class="text-end">
                            <button class="btn-admin-secondary rounded-pill px-3">Suspender</button>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="fw-bold" style="color: var(--black-primary);">Cafetería Susy</td>
                        <td><span class="badge rounded-pill px-3" style="background: var(--off-white); color: var(--text-muted); border: 1px solid var(--border-light);">Plan Básico</span></td>
                        <td class="fw-bold" style="color: var(--black-primary);">$299.00</td>
                        <td class="fw-bold text-danger">01 Feb, 2026</td>
                        <td><span class="badge rounded-pill px-3" style="background: #FFF3E0; color: #E65100; border: 1px solid #FFCC80;">● Pendiente</span></td>
                        <td class="text-end">
                            <button class="btn-admin-secondary rounded-pill px-3">Suspender</button>
                        </td>
                    </tr>

                    <tr class="opacity-75">
                        <td class="fw-bold" style="color: var(--black-primary);">Cafe 123</td>
                        <td><span class="badge rounded-pill px-3" style="background: var(--off-white); color: var(--text-muted); border: 1px solid var(--border-light);">Plan Basico</span></td>
                        <td class="fw-bold" style="color: var(--text-muted);">$299.00</td>
                        <td class="text-muted">---</td>
                        <td><span class="badge rounded-pill px-3" style="background: #FFEBEE; color: #C62828; border: 1px solid #EF9A9A;">● Suspendido</span></td>
                        <td class="text-end">
                            <button class="btn-admin-secondary rounded-pill px-3">Reactivar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection