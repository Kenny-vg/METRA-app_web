<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>METRA - Gestión de Reservaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css?v=' . time()) }}">
</head>
<body style="background-color: #F5EFE6;">

    <aside class="sidebar">
        <h2 class="fw-bold mb-5 text-center" style="color: #FFAB40;">METRA</h2>
        <nav>
            <a href="/admin/dashboard" class="nav-link-admin"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            <a href="/admin/gestion_negocio" class="nav-link-admin"><i class="bi bi-shop me-2"></i> Gestión</a>
            <a href="/admin/reservaciones" class="nav-link-admin active"><i class="bi bi-calendar3 me-2"></i> Reservaciones</a>
            <a href="/admin/perfil" class="nav-link-admin"><i class="bi bi-person-circle me-2"></i> Perfil</a>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <a href="/" class="nav-link-admin text-danger"><i class="bi bi-door-open me-2"></i> Salir</a>
        </nav>
    </aside>

    <main style="margin-left: 260px;" class="p-5">
        <header class="mb-5">
            <h2 class="fw-bold">Gestión de Reservaciones</h2>
            <p class="text-muted">Revisa y administra las próximas visitas a Café Central</p>
        </header>

        <div class="row g-3 mb-5">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-0 shadow-sm"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control border-0 shadow-sm py-2" placeholder="Buscar por cliente o folio...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select border-0 shadow-sm py-2">
                    <option>Hoy - 30 Enero</option>
                    <option>Mañana</option>
                    <option>Esta semana</option>
                </select>
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-2">
                    <button class="btn btn-dark rounded-pill px-4 w-100">Filtrar</button>
                    <button class="btn btn-outline-dark rounded-pill px-4 w-100">Limpiar</button>
                </div>
            </div>
        </div>

        <div class="reserva-list">
            
            <div class="reserva-item-card d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-4">
                    <div class="hora-box">
                        <span class="d-block fs-4">20:30</span>
                        <small class="text-uppercase" style="font-size: 0.6rem;">PM</small>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <h5 class="fw-bold mb-0">Cristina Ramírez</h5>
                            <span class="badge-status" style="background: #E8F5E9; color: #2E7D32;">✓ Confirmada</span>
                        </div>
                        <div class="text-muted small">
                            <i class="bi bi-people me-1"></i> 4 Personas • 
                            <i class="bi bi-geo-alt me-1"></i> Balcón • 
                            <i class="bi bi-telephone me-1"></i> 238 123 4567
                        </div>
                        <div class="mt-2">
                            <span class="badge bg-light text-dark border fw-normal" style="font-size: 0.7rem;">
                                <i class="bi bi-gift me-1"></i> Aniversario
                            </span>
                            <span class="badge bg-light text-danger border fw-normal ms-2" style="font-size: 0.7rem;">
                                <i class="bi bi-exclamation-triangle me-1"></i> Alergia a nueces
                            </span>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-dark btn-sm rounded-pill px-3">Editar</button>
                    <button class="btn btn-danger btn-sm rounded-pill px-3">Cancelar</button>
                </div>
            </div>

            <div class="reserva-item-card d-flex align-items-center justify-content-between opacity-75">
                <div class="d-flex align-items-center gap-4">
                    <div class="hora-box" style="background: #eee;">
                        <span class="d-block fs-4">21:00</span>
                        <small class="text-uppercase" style="font-size: 0.6rem;">PM</small>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <h5 class="fw-bold mb-0">Juan Pablo Montes</h5>
                            <span class="badge-status" style="background: #FFF3E0; color: #EF6C00;">🕒 Pendiente</span>
                        </div>
                        <div class="text-muted small">
                            <i class="bi bi-people me-1"></i> 2 Personas • 
                            <i class="bi bi-geo-alt me-1"></i> Interior • 
                            <i class="bi bi-envelope me-1"></i> juan.p@correo.com
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-sm rounded-pill px-3">Confirmar</button>
                    <button class="btn btn-outline-danger btn-sm rounded-pill px-3">Rechazar</button>
                </div>
            </div>

        </div>
    </main>
</body>
</html>