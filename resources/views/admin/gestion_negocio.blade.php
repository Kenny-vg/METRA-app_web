@extends('admin.menu')
@section('title', 'Gestión del Negocio')

@section('content')
    <header class="mb-5 border-bottom pb-4" style="border-color: var(--border-light) !important;">
        <h2 class="fw-bold" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Gestión del Negocio</h2>
        <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Administración de estructura y configuración operativa.</p>
    </header>

    <ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
    <li class="nav-item">
        <button class="nav-link active rounded-pill px-4" id="zonas-tab" data-bs-toggle="pill" data-bs-target="#zonas" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
            <i class="bi bi-geo-alt me-2"></i>Zonas
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link rounded-pill px-4" id="mesas-tab" data-bs-toggle="pill" data-bs-target="#mesas" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
            <i class="bi bi-layout-three-columns me-2"></i>Mesas
        </button>
    </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-4" id="meseros-tab" data-bs-toggle="pill" data-bs-target="#meseros" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
                <i class="bi bi-people me-2"></i>Personal
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-4" id="reviews-tab" data-bs-toggle="pill" data-bs-target="#reviews" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
                <i class="bi bi-star me-2"></i>Reseñas
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-4" id="horarios-tab" data-bs-toggle="pill" data-bs-target="#horarios" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
                <i class="bi bi-clock me-2"></i>Horarios
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- ZONAS -->
        <div class="tab-pane fade show active" id="zonas">
            <div class="card border-0 p-4 p-md-5 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Distribución de Áreas</h5>
                    <button class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#modalZona">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Zona
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table-metra mt-2">
                        <thead>
                            <tr>
                                <th>Nombre de la Zona</th>
                                <th>Capacidad / Mesas</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold" style="color: var(--black-primary);">Terraza Principal</td>
                                <td><span class="badge" style="background: var(--off-white); color: var(--text-muted); border: 1px dashed var(--border-light); padding: 6px 12px;">5 Mesas</span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-dark rounded-circle me-1" title="Editar"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle" title="Eliminar"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MESAS -->
        <div class="tab-pane fade" id="mesas">
             <div class="card border-0 p-4 p-md-5 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Inventario de Mesas</h5>
                    <button class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#modalMesa">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Mesa
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table-metra mt-2">
                        <thead>
                            <tr>
                                <th>ID / # Mesa</th>
                                <th>Ubicación</th>
                                <th>Capacidad</th>
                                <th>Estado Operativo</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold" style="color: var(--black-primary);">
                                    <div class="d-inline-flex align-items-center justify-content-center text-white rounded-circle me-2 shadow-sm" style="background: var(--black-primary); width: 25px; height: 25px; font-size: 0.75rem;">01</div>
                                    Mesa Principal
                                </td>
                                <td><span class="badge" style="background: var(--off-white); border: 1px solid var(--border-light); color: var(--text-main);">Interior</span></td>
                                <td class="text-muted">4 Inv.</td>
                                <td><span class="badge badge-status badge-status-active">En Línea</span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-dark rounded-circle me-1" title="Editar"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle" title="Eliminar"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- PERSONAL -->
        <div class="tab-pane fade" id="meseros">
             <div class="card border-0 p-4 p-md-5 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Estructura de Personal</h5>
                    <button class="btn-admin-primary" data-bs-toggle="modal" data-bs-target="#modalMesero">
                        <i class="bi bi-person-plus me-2"></i>Añadir Colaborador
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table-metra mt-2">
                        <thead>
                            <tr>
                                <th>Identidad</th>
                                <th>Contacto Interno</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name=Juan+Perez&background=0A0A0A&color=fff" class="rounded-circle me-3" width="40" style="border: 2px solid var(--off-white);">
                                    <div>
                                        <span class="fw-bold d-block" style="color: var(--black-primary);">Juan Pérez</span>
                                        <span class="small" style="color: var(--text-muted); font-size: 0.75rem;">Staff Service</span>
                                    </div>
                                </td>
                                <td class="fw-medium text-muted">238 123 4455</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-dark rounded-circle me-1" title="Editar"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle" title="Eliminar"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- REVIEWS -->
        <div class="tab-pane fade" id="reviews">
             <div class="card border-0 p-4 p-md-5 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Reseñas Recibidas</h5>
                    <span class="badge rounded-pill px-3 py-2" style="background: rgba(0,0,0,0.05); border: 1px solid rgba(0,0,0,0.1); color: var(--black-primary);">3 Sin revisar</span>
                </div>
                <div class="table-responsive">
                    <table class="table-metra mt-2">
                        <thead>
                            <tr>
                                <th>Recepción</th>
                                <th style="min-width: 300px;">Testimonio</th>
                                <th>Score</th>
                                <th class="text-end">Control</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="small fw-medium" style="color: var(--text-muted);">30 Ene, 2026</td>
                                <td style="max-width: 300px;">
                                    <i class="bi bi-quote d-block mb-1" style="color: var(--border-light); font-size: 1.2rem;"></i>
                                    <span class="d-block" style="color: var(--text-main); font-style: italic;">"Experiencia inigualable, el ambiente minimalista fascina."</span>
                                </td>
                                <td><span style="color: var(--black-primary); font-size: 1.1rem; letter-spacing: 2px;">★★★★<span style="color: var(--border-light);">★</span></span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-dark rounded-pill px-3 me-2 fw-bold shadow-sm">Visualizar</button>
                                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3">Ignorar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- HORARIOS -->
        <div class="tab-pane fade" id="horarios">
            <div class="card border-0 p-4 p-md-5 premium-card">
                <div class="mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0 mb-1" style="color: var(--black-primary); letter-spacing: -0.5px;">Horarios de Atención</h5>
                    <p class="m-0" style="color: var(--text-muted); font-size: 0.9rem;">Configura las ventanas de reserva disponibles para tus clientes.</p>
                </div>
                <div class="row g-3">
                    @php $slots = ['08:30 AM', '09:00 AM', '11:30 AM', '01:00 PM', '04:30 PM', '07:00 PM']; @endphp
                    @foreach($slots as $hora)
                    <div class="col-md-4 col-lg-3 col-6">
                        <div class="p-3 rounded-4 d-flex justify-content-between align-items-center" style="background: var(--off-white); border: 1px solid var(--border-light); transition: all 0.2s;">
                            <span class="fw-bold" style="color: var(--black-primary); font-size: 0.9rem;">{{ $hora }}</span>
                            <div class="form-check form-switch m-0 pb-1">
                                <input class="form-check-input" type="checkbox" checked style="cursor: pointer;">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-5 pt-4 border-top d-flex flex-wrap flex-md-nowrap gap-3 justify-content-between" style="border-color: var(--border-light) !important;">
                    <button class="btn-admin-secondary px-4 py-2 w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#modalHorario">
                        <i class="bi bi-plus-lg me-2"></i>Añadir Slot
                    </button>
                    <button class="btn-admin-primary px-4 py-2 w-100 w-md-auto">Restablecer Configuración</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals Reestilizados -->
    <div class="modal fade" id="modalZona" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Nueva Zona de Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-3">
                    <p class="small text-muted mb-4">La zonificación ayuda a distribuir mejor a sus clientes.</p>
                    <div class="mb-4">
                        <label class="form-label small fw-bold" style="color: var(--text-main); letter-spacing: 0.5px;">DENOMINACIÓN</label>
                        <input type="text" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" placeholder="Ej. Balcón Este">
                    </div>
                    <button class="btn-admin-primary w-100 py-3 mt-3">Agregar Zona</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMesa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0"><h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Adicionar Mesa</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body pt-4">
                    <div class="row g-3 mb-4">
                        <div class="col-6"><input type="text" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" placeholder="ID/Num"></div>
                        <div class="col-6"><select class="form-select border-0 shadow-sm rounded-3" style="background: var(--off-white);"><option>Asignación...</option><option>Terraza Principal</option></select></div>
                        <div class="col-12"><input type="number" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" placeholder="Aforo máximo (Pax)"></div>
                    </div>
                    <button class="btn-admin-primary w-100 py-3 mt-3">Salvar Elemento</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMesero" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0"><h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Integrar Colaborador</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body pt-4">
                    <input type="text" class="form-control border-0 shadow-sm rounded-3 mb-3" style="background: var(--off-white);" placeholder="Nombre completo del colaborador">
                    <input type="tel" class="form-control border-0 shadow-sm rounded-3 mb-4" style="background: var(--off-white);" placeholder="Teléfono de contacto">
                    <button class="btn-admin-primary w-100 py-3 mt-3">Agregar al equipo</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHorario" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0"><h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Agregar horario</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body pt-4">
                    <input type="time" class="form-control border-0 shadow-sm rounded-3 mb-4" style="background: var(--off-white);">
                    <button class="btn-admin-primary w-100 py-3 mt-3">Agregar horario</button>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer_admin')
@endsection