@extends('superadmin.menu')

@section('title', 'Suscripciones')

@section('content')
    <header class="mb-5">
        <h2 class="fw-bold">Gestión de Suscripciones</h2>
        <p class="text-muted">Control de ingresos y estados de cuenta de los negocios en METRA.</p>
    </header>

    <div class="bg-white p-4 rounded-4 shadow-sm border">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold m-0 text-dark"><i class="bi bi-credit-card-2-front me-2"></i>Control de Pagos y Planes</h5>
            <div class="input-group w-25">
                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar negocio...">
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
                        <td class="fw-bold">Café Central</td>
                        <td><span class="badge bg-primary-subtle text-primary rounded-pill px-3">Plan Pro</span></td>
                        <td class="fw-bold">$499.00</td>
                        <td>15 Feb, 2026</td>
                        <td><span class="badge bg-success rounded-pill px-3">● Al corriente</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-success rounded-pill px-3">Ssupender</button>
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="fw-bold">Cafetería Susy</td>
                        <td><span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">Plan Básico</span></td>
                        <td class="fw-bold">$299.00</td>
                        <td class="text-danger fw-bold">01 Feb, 2026</td>
                        <td><span class="badge bg-warning text-dark rounded-pill px-3">● Pendiente</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-success rounded-pill px-3">Suspender</button>
                        </td>
                    </tr>

                    <tr class="opacity-75">
                        <td class="fw-bold">Cafe 123</td>
                        <td><span class="badge bg-dark-subtle text-dark rounded-pill px-3">Plan Basico</span></td>
                        <td class="fw-bold">$299.00</td>
                        <td class="text-muted">---</td>
                        <td><span class="badge bg-danger rounded-pill px-3">● Suspendido</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-success rounded-pill px-3">Reactivar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection