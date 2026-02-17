@extends('superadmin.menu')

@section('title', 'Panel Maestro')

@section('content')
    <header class="mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="fw-bold">Panel de Control Maestro</h2>
                <p class="text-muted mb-0">Bienvenido, V-TECH. Gestiona los restaurantes inscritos.</p>
            </div>
            <button class="btn btn-primary rounded-pill px-4 shadow-sm w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#nuevoNegocio">
                <i class="bi bi-plus-lg me-2"></i>Registrar Nuevo Café
            </button>
        </div>
    </header>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-stat border-0 shadow-sm p-4 rounded-4 bg-white">
                <h6 class="text-muted mb-2">Restaurantes Totales</h6>
                <h2 class="fw-bold m-0">12</h2>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-4 shadow-sm border mt-5">
        <h5 class="fw-bold mb-4">Negocios Activos</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="small text-muted text-uppercase">
                        <th>Negocio</th>
                        <th>Responsable</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                        <th class="text-end">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold">Café Central</td>
                        <td>Iván Martínez</td> 
                        <td>Tehuacán, Pue.</td>
                        <td><span class="badge bg-success-subtle text-success rounded-pill px-3">Plan Pro</span></td>
                        <td class="text-end">
                            <a href="/superadmin/suscripciones" class="btn btn-sm btn-outline-primary rounded-pill px-3">Gestionar</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="nuevoNegocio" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 p-4">
                    <h5 class="fw-bold m-0">Dar de alta nuevo Restaurante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nombre del Negocio</label>
                            <input type="text" class="form-control bg-light border-0 py-2" placeholder="Ej. Café Central">
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label small fw-bold">Responsable</label>
                                <input type="text" class="form-control bg-light border-0 py-2" placeholder="Nombre completo">
                            </div>
                            <div class="col">
                                <label class="form-label small fw-bold">Plan</label>
                                <select class="form-select bg-light border-0 py-2">
                                    <option>Plan Básico</option>
                                    <option selected>Plan Pro</option>
                                    <option>Plan Premium</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Correo de Acceso</label>
                            <input type="email" class="form-control bg-light border-0 py-2" placeholder="admin@ejemplo.com">
                        </div>
                        <button type="button" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Crear Cuenta de Negocio</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection