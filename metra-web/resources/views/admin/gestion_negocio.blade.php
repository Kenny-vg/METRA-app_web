<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>METRA - Gestión de Negocio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css?v=' . time()) }}">
</head>
<body class = "zona-admin" style="background-color: #F5EFE6;">

    <aside class="sidebar">
        <h2 class="fw-bold mb-5 text-center" style="color: #FFAB40;">METRA</h2>
        <nav>
            <a href="/admin/dashboard" class="nav-link-admin"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a href="/admin/gestion_negocio" class="nav-link-admin active"><i class="bi bi-shop me-2"></i> Gestión</a>
            <a href="/admin/reservaciones" class="nav-link-admin"><i class="bi bi-calendar3 me-2"></i> Reservaciones</a>
            <a href="/admin/perfil" class="nav-link-admin"><i class="bi bi-person-circle me-2"></i> Mi Perfil</a>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <a href="/" class="nav-link-admin text-danger"><i class="bi bi-door-open me-2"></i> Salir</a>
        </nav>
    </aside>

    <main style="margin-left: 260px;" class="p-5">
        <header class="mb-5">
            <h2 class="fw-bold">Gestión del Negocio</h2>
            <p class="text-muted">Administra tus recursos: Mesas y Personal</p>
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
                                    <th>Turno</th>
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
                                    <td>Matutino</td>
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
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>