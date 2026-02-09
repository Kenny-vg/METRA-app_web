@extends('superadmin.menu')

@section('title', 'Ajustes del Sistema')

@section('content')
    <header class="mb-5">
        <h2 class="fw-bold">Configuración Global</h2>
        <p class="text-muted">Administra los costos de los planes y parámetros generales de la plataforma.</p>
    </header>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                <h5 class="fw-bold mb-4"><i class="bi bi-tags me-2"></i>Precios de Planes Mensuales</h5>
                
                <form action="/superadmin/guardar-ajustes" method="POST">
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Plan Básico ($)</label>
                            <input type="number" class="form-control bg-light border-0 py-2" value="299" placeholder="299">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Plan Pro ($)</label>
                            <input type="number" class="form-control bg-light border-0 py-2" value="499" placeholder="499">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Plan Premium ($)</label>
                            <input type="number" class="form-control bg-light border-0 py-2" value="899" placeholder="899">
                        </div>
                    </div>

                    <h5 class="fw-bold mb-3 small text-uppercase text-muted">Límites por Negocio</h5>
                    <div class="row g-3 mb-4">
                    

                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                        <i class="bi bi-cloud-upload me-2"></i>Actualizar Parámetros
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-4">
            <div class="bg-white p-4 rounded-4 shadow-sm border h-100">
                <h5 class="fw-bold mb-4"><i class="bi bi-headset me-2"></i>Soporte Técnico</h5>
                <div class="mb-3">
                    <small class="text-muted d-block">Desarrollado por:</small>
                    <p class="fw-bold m-0">V-TECH Software</p>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Versión actual:</small>
                    <span class="badge bg-light text-dark border">v1.0.2</span>
                </div>
                <hr>
                <div class="p-3 bg-primary-subtle rounded-3 text-primary small">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Recuerda que los cambios en los precios solo afectarán a los **nuevos clientes** registrados.
                </div>
            </div>
        </div>
    </div>
@endsection