@extends('admin.menu')
@section('title', 'Gestión del Negocio')

@section('content')
    <header class="mb-5">
        <h2 class="fw-bold">Gestión del Negocio</h2>
        <p class="text-muted">Administra tu negocio</p>
    </header>

    <ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
    <li class="nav-item">
        <button class="nav-link active rounded-pill px-4 border" id="zonas-tab" data-bs-toggle="pill" data-bs-target="#zonas">
            <i class="bi bi-geo-alt me-2"></i>Zonas
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link rounded-pill px-4 border" id="mesas-tab" data-bs-toggle="pill" data-bs-target="#mesas">
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
        <div class="tab-pane fade show active" id="zonas">
            <div class="bg-white p-4 rounded-4 shadow-sm border">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0 text-dark">Distribución de Áreas</h5>
                    <button class="btn btn-dark rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalZona">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Zona
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr class="small text-muted text-uppercase">
                                <th>Nombre de la Zona</th>
                                <th>Mesas Asignadas</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold text-primary">Terraza</td>
                                <td>5 mesas</td>
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

        <div class="tab-pane fade" id="mesas">
            <div class="bg-white p-4 rounded-4 shadow-sm border">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0 text-dark">Inventario de Mesas</h5>
                    <button class="btn btn-dark rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalMesa">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Mesa
                    </button>
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
                                <td><span class="text-success small">● Activa</span></td>
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
                    <button class="btn btn-dark rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalMesero">
                        <i class="bi bi-person-plus me-2"></i>Añadir Mesero
                    </button>
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
                                <th class="text-end">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="small">30 Ene, 2026</td>
                                <td style="max-width: 300px;"><span class="d-block text-truncate">"El café está increíble..."</span></td>
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

        <div class="tab-pane fade" id="horarios">
            <div class="bg-white p-4 rounded-4 shadow-sm border">
                <div class="mb-4">
                    <h5 class="fw-bold text-dark">Configuración de Citas</h5>
                    <p class="text-muted small">Selecciona los horarios disponibles.</p>
                </div>
                <div class="row g-3">
                    @php $slots = ['08:30 AM', '09:00 AM', '11:30 AM', '01:00 PM', '04:30 PM', '07:00 PM']; @endphp
                    @foreach($slots as $hora)
                    <div class="col-md-3 col-6">
                        <div class="p-3 border rounded-4 d-flex justify-content-between align-items-center bg-light">
                            <span class="fw-bold small">{{ $hora }}</span>
                            <div class="form-check form-switch"><input class="form-check-input" type="checkbox" checked></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-top d-flex justify-content-between">
                    <button class="btn btn-outline-dark rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalHorario">
                        <i class="bi bi-plus-lg me-2"></i>Añadir horario
                    </button>
                    <button class="btn btn-warning rounded-pill px-5 fw-bold shadow-sm">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalZona" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold m-0">Dar de alta nueva Zona</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 pt-3">
                <p class="text-muted small">Crea un área (ej. Terraza, Planta Alta) para después asignarle sus mesas.</p>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nombre de la Zona</label>
                    <input type="text" class="form-control bg-light border-0 py-2" placeholder="Ej. Jardín">
                </div>
                <button class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">
                    Guardar Zona
                </button>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="modalMesa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 p-4 pb-0"><h5 class="fw-bold m-0">Nueva Mesa</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body p-4 pt-3">
                    <div class="row g-3 mb-3">
                        <div class="col-6"><input type="text" class="form-control bg-light border-0" placeholder="# Mesa"></div>
                        <div class="col-6"><select class="form-select bg-light border-0"><option>Zona</option><option>Terraza</option></select></div>
                        <div class="col-12"><input type="number" class="form-control bg-light border-0" placeholder="Capacidad"></div>
                    </div>
                    <button class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Guardar Mesa</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMesero" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 p-4 pb-0"><h5 class="fw-bold m-0">Añadir Mesero</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body p-4 pt-3">
                    <input type="text" class="form-control bg-light border-0 mb-3" placeholder="Nombre completo">
                    <input type="tel" class="form-control bg-light border-0 mb-3" placeholder="Teléfono">
                    <button class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHorario" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 p-4 pb-0"><h5 class="fw-bold m-0">Añadir Horario</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body p-4 pt-3">
                    <input type="time" class="form-control bg-light border-0 mb-3">
                    <button class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Añadir</button>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer_admin')
@endsection