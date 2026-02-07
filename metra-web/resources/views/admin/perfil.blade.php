<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>METRA - Perfil del Negocio</title>
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
            <a href="/admin/reservaciones" class="nav-link-admin"><i class="bi bi-calendar3 me-2"></i> Reservaciones</a>
            <a href="/admin/perfil" class="nav-link-admin active"><i class="bi bi-person-circle me-2"></i> Perfil</a>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <a href="/" class="nav-link-admin text-danger fw-bold">
                <i class="bi bi-box-arrow-left me-2"></i> Cerrar Sesión
            </a>
        </nav>
    </aside>

    <main style="margin-left: 260px;" class="p-5">
        <header class="mb-5">
            <h2 class="fw-bold">Perfil del Negocio</h2>
            <p class="text-muted">Personaliza la información que tus clientes ven en METRA</p>
        </header>

        <form style="max-width: 900px;">
            <div class="row">
                <div class="col-md-7">
                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4 border">
                        <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-info-circle me-2"></i>Información General</h5>
                        <div class="mb-3">
                            <label class="small fw-bold mb-2">Nombre del Establecimiento</label>
                            <input type="text" class="form-control input-metra" value="Café Central Tehuacán">
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold mb-2">Descripción del lugar</label>
                            <textarea class="form-control input-metra" rows="4">Fusionamos granos locales con panadería artesanal. Un ambiente perfecto para trabajar o reunirse con amigos en el corazón de la ciudad.</textarea>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4 border">
                        <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-geo-alt me-2"></i>Ubicación y Contacto</h5>
                        <div class="mb-3">
                            <label class="small fw-bold mb-2">Dirección Completa</label>
                            <input type="text" class="form-control input-metra" value="Calle Principal 123, Colonia Centro">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="small fw-bold mb-2">Teléfono Público</label>
                                <input type="text" class="form-control input-metra" value="238 123 4567">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small fw-bold mb-2">Precio Promedio (MXN)</label>
                                <input type="text" class="form-control input-metra" value="$150 - $300">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4 border">
                        <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-egg-fried me-2"></i>Platillos Estrella</h5>
                        <div class="d-flex align-items-center mb-3 p-2 border rounded-3 bg-light">
                            <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=100" class="rounded-3 me-3" width="50">
                            <div>
                                <p class="mb-0 fw-bold small">Expreso Doble</p>
                                <span class="text-muted" style="font-size: 0.7rem;">Activo en el menú</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3 p-2 border rounded-3 bg-light">
                            <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?w=100" class="rounded-3 me-3" width="50">
                            <div>
                                <p class="mb-0 fw-bold small">Chilaquiles Verdes</p>
                                <span class="text-muted" style="font-size: 0.7rem;">Activo en el menú</span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-dark btn-sm w-100 mt-2">+ Agregar platillo</button>
                    </div>

                    <div class="bg-white p-4 rounded-4 shadow-sm border">
                        <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-image me-2"></i>Imagen Principal</h5>
                        <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=400" class="img-fluid rounded-3 mb-3 shadow-sm">
                        <button type="button" class="btn btn-dark btn-sm w-100">Cambiar Imagen</button>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn-metra-main border-0 py-3 px-5">
                    <i class="bi bi-save me-2"></i>Guardar todos los cambios
                </button>
            </div>
        </form>
    </main>

</body>
</html>