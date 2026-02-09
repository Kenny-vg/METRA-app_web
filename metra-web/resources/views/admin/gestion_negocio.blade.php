
@extends('admin.menu')
@section('title', 'Gestión del Negocio')

@section('content')
    <header class="mb-5">
        <h2 class="fw-bold">Gestión del Negocio</h2>
        <p class="text-muted">Administra tu negocio</p>
    </header>
        <ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active rounded-pill px-4" id="mesas-tab" data-bs-toggle="pill" data-bs-target="#mesas">
                    <i class="bi bi-layout-three-columns me-2"></i>Mesas
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4 border" id="meseros-tab" data-bs-toggle="pill" data-bs-target="#meseros">
                    <i class="bi bi-people me-2"></i>Meseros
                </button>
            </li>
            <li class="nav-item">
    <button class="nav-link rounded-pill px-4 border" id="reviews-tab" data-bs-toggle="pill" data-bs-target="#reviews">
        <i class="bi bi-star me-2"></i>Aprobar Reseñas
    </button>
</li>
<li class="nav-item">
    <button class="nav-link rounded-pill px-4 border" id="horarios-tab" data-bs-toggle="pill" data-bs-target="#horarios">
        <i class="bi bi-clock me-2"></i>Horarios
    </button>
</li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="mesas">
                <div class="bg-white p-4 rounded-4 shadow-sm border">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0 text-dark">Inventario de Mesas</h5>
                        <button class="btn btn-dark rounded-pill px-4"><i class="bi bi-plus-lg me-2"></i>Nueva Mesa</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr class="small text-muted text-uppercase">
                                    <th># Mesa</th>
                                    <th>Zona</th>
                                    <th>Capacidad</th>
                                    <th>Estado</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">01</td>
                                    <td><span class="badge bg-light text-dark">Interior</span></td>
                                    <td>4 personas</td>
                                    <td><span class="status-available">● Activa</span></td>
                                    <td class="text-end">
                                        <button class="btn btn-outline-secondary btn-sm rounded-circle"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-outline-danger btn-sm rounded-circle ms-2"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">02</td>
                                    <td><span class="badge bg-light text-dark">Terraza</span></td>
                                    <td>2 personas</td>
                                    <td><span class="status-available">● Activa</span></td>
                                    <td class="text-end">
                                        <button class="btn btn-outline-secondary btn-sm rounded-circle"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-outline-danger btn-sm rounded-circle ms-2"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="meseros">
                <div class="bg-white p-4 rounded-4 shadow-sm border">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0 text-dark">Equipo de Servicio</h5>
                        <button class="btn btn-dark rounded-pill px-4"><i class="bi bi-person-plus me-2"></i>Añadir Mesero</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr class="small text-muted text-uppercase">
                                    <th>Nombre del Mesero</th>
                                    <th>Teléfono</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Juan+Perez&background=6D4C41&color=fff" class="rounded-circle me-3" width="35">
                                        <span class="fw-bold">Juan Pérez</span>
                                    </td>
                                    <td>238 123 4455</td>
                                    <td class="text-end">
                                        <button class="btn btn-outline-secondary btn-sm rounded-circle"><i class="bi bi-pencil"></i></button>
                                        <button class="btn btn-outline-danger btn-sm rounded-circle ms-2"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="horarios">
    <div class="bg-white p-4 rounded-4 shadow-sm border">
        <div class="mb-4">
            <h5 class="fw-bold text-dark">Configuración de Citas</h5>
            <p class="text-muted small">Selecciona los horarios que estarán disponibles para reservación en tu página pública.</p>
        </div>

        <div class="row g-3">
            @php 
                $slots = ['08:30 AM', '09:00 AM', '11:30 AM', '01:00 PM', '04:30 PM', '07:00 PM', '08:30 PM'];
            @endphp
            
            @foreach($slots as $hora)
            <div class="col-md-3 col-6">
                <div class="p-3 border rounded-4 d-flex justify-content-between align-items-center bg-light">
                    <span class="fw-bold small">{{ $hora }}</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4 pt-4 border-top text-end">
            <button class="btn btn-warning rounded-pill px-5 fw-bold shadow-sm">
                Actualizar Disponibilidad
            </button>
        </div>
    </div>
</div>

        </div>
        <div class="tab-pane fade" id="reviews">
    <div class="bg-white p-4 rounded-4 shadow-sm border">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold m-0 text-dark">Moderación de Comentarios</h5>
            <span class="badge bg-warning text-dark rounded-pill">3 Pendientes</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="small text-muted text-uppercase">
                        <th>Fecha</th>
                        <th>Comentario</th>
                        <th>Calificación</th>
                        <th class="text-end">Estado / Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="small">30 Ene, 2026</td>
                        <td style="max-width: 300px;">
                            <span class="d-block text-truncate">"El café está increíble, pero tardaron un poco..."</span>
                        </td>
                        <td><span class="text-warning">★★★★☆</span></td>
                        <td class="text-end">
                            <button class="btn btn-success btn-sm rounded-pill px-3">Aprobar</button>
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-3 ms-2">Rechazar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
 @include('partials.footer_admin')
 @endsection