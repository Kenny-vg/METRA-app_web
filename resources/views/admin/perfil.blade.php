@extends('admin.menu')
@section('title', 'Perfil del negocio')

@section('content')
    <header class="mb-5">
        <h2 class="fw-bold">Perfil del negocio</h2>
        <p class="text-muted">Revisa y administra la información de Café Central Tehuacán</p>
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
                    
                    <div class="mb-4">
                        <label class="small fw-bold mb-3 d-block text-muted border-bottom pb-2">Dirección Física</label>
                        
                        <div class="row g-3 align-items-end mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold mb-1">Calle</label>
                                <input type="text" name="calle" class="form-control input-metra" placeholder="Ej. Av. Reforma">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label small fw-bold mb-1 text-nowrap">Num. Ext.</label>
                                <input type="text" name="num_exterior" class="form-control input-metra">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label small fw-bold mb-1 text-nowrap">Num. Int.</label>
                                <input type="text" name="num_interior" class="form-control input-metra">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="form-label small fw-bold mb-1">Colonia</label>
                                <input type="text" name="colonia" class="form-control input-metra">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold mb-1">C.P.</label>
                                <input type="text" name="cp" class="form-control input-metra">
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold mb-1">Ciudad</label>
                                <input type="text" name="ciudad" class="form-control input-metra">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold mb-1">Estado</label>
                                <input type="text" name="estado_republica" class="form-control input-metra">
                            </div>
                        </div>
                    </div>

                    <label class="small fw-bold mb-3 d-block text-muted border-bottom pb-2">Contacto y Costos</label>
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
            </div> <div class="col-md-5">
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
                <div class="bg-white p-4 rounded-4 shadow-sm mb-4 border">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0 text-dark"><i class="bi bi-stars me-2 text-warning"></i>Combos y Promociones</h5>
                        <span class="badge bg-primary-subtle text-primary" style="font-size: 0.6rem;">PÚBLICO</span>
                    </div>

                    <div class="p-3 border rounded-3 bg-light mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <p class="mb-0 fw-bold small">Desayuno Central</p>
                            <span class="fw-bold text-success small">$149.00</span>
                        </div>
                        <p class="text-muted mb-2" style="font-size: 0.75rem;">Chilaquiles + Café + Pan artesanal</p>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-light border py-0 px-2" style="font-size: 0.7rem;"><i class="bi bi-pencil me-1"></i>Editar</button>
                            <button type="button" class="btn btn-sm btn-light border py-0 px-2 text-danger" style="font-size: 0.7rem;"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>

                    <div class="p-3 border rounded-3 bg-light mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <p class="mb-0 fw-bold small">Combo Estudiante</p>
                            <span class="fw-bold text-success small">$95.00</span>
                        </div>
                        <p class="text-muted mb-2" style="font-size: 0.75rem;">Expreso Doble + Galleta de Avena</p>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-light border py-0 px-2" style="font-size: 0.7rem;"><i class="bi bi-pencil me-1"></i>Editar</button>
                            <button type="button" class="btn btn-sm btn-light border py-0 px-2 text-danger" style="font-size: 0.7rem;"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-warning btn-sm w-100 mt-2 fw-bold" style="color: #4E342E; border-color: #FFAB40;">
                        <i class="bi bi-plus-circle me-2"></i>Crear Nueva Promoción
                    </button>
                </div>

                <div class="bg-white p-4 rounded-4 shadow-sm border">
                    <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-image me-2"></i>Imagen Principal</h5>
                    <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=400" class="img-fluid rounded-3 mb-3 shadow-sm">
                    <button type="button" class="btn btn-dark btn-sm w-100">Cambiar Imagen</button>
                </div>
            </div> </div>

        <div class="mt-4 mb-5">
            <button type="submit" class="btn btn-dark border-0 py-3 px-5 rounded-pill shadow">
                <i class="bi bi-save me-2"></i>Guardar todos los cambios
            </button>
        </div>
    </form>

    @include('partials.footer_admin')
@endsection