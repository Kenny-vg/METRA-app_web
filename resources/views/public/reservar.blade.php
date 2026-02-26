<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Finalizar Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}?v={{ time() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal">

    <main class="container mb-5" style="margin-top: 50px;">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                
                <div class="reserva-card" style="box-shadow: 0 24px 60px rgba(0,0,0,0.08); border: none; border-radius: 20px;">
                    <div class="text-center mb-5">
                        <span class="badge mb-3" style="background: var(--off-white); color: var(--text-main); border: 1px solid var(--border-light); padding: 8px 20px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">
                            Paso Final
                        </span>
                        <h1 class="fw-bold mb-3" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px; font-size: 2.5rem;">Casi Listo</h1>
                        <div class="mb-4">
                            <a href="javascript:history.back()" class="text-decoration-none fw-bold" style="color: var(--text-muted); font-size: 0.9rem;">
                                <i class="bi bi-arrow-left me-1"></i> Volver a Opciones
                            </a>
                        </div>
                    </div>

                    <form action="/confirmacion">
                        <div class="row mb-5">
                            <div class="col-12"><h5 class="section-title mb-4" style="border-bottom: 1px solid var(--border-light); padding-bottom: 12px; color: var(--black-primary); font-weight: 700;">1. Detalles de Experiencia</h5></div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="fw-bold mb-2 small" style="color: var(--text-muted);"><i class="bi bi-calendar3 me-2"></i> Fecha</label>
                                <input type="date" class="form-control input-metra" value="2026-01-30">
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="fw-bold mb-2 small" style="color: var(--text-muted);"><i class="bi bi-clock me-2"></i> Hora</label>
                                <select class="form-select input-metra">
                                    <option>08:30 PM (Mesa Preferencial)</option>
                                    <option>09:00 PM</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="fw-bold mb-2 small" style="color: var(--text-muted);"><i class="bi bi-people me-2"></i> Invitados</label>
                                <select class="form-select input-metra">
                                    <option>2 Personas</option>
                                    <option>3 Personas</option>
                                    <option>4 Personas</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-12"><h5 class="section-title mb-4" style="border-bottom: 1px solid var(--border-light); padding-bottom: 12px; color: var(--black-primary); font-weight: 700;">2. Información del Titular</h5></div>
                            <div class="col-12 col-md-4 mb-3">
                                <input type="text" class="form-control input-metra" placeholder="Nombre(s)">
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <input type="text" class="form-control input-metra" placeholder="Apellido Paterno">
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <input type="text" class="form-control input-metra" placeholder="Apellido Materno">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <input type="email" class="form-control input-metra" placeholder="Correo electrónico institucional / personal">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <input type="tel" class="form-control input-metra" placeholder="Teléfono móvil">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-12"><h5 class="section-title mb-4" style="border-bottom: 1px solid var(--border-light); padding-bottom: 12px; color: var(--black-primary); font-weight: 700;">3. Personalización</h5></div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="small fw-bold mb-2" style="color: var(--text-muted);">¿Celebra alguna ocasión?</label>
                                <select class="form-select input-metra">
                                    <option>Seleccionar motivo</option>
                                    <option>Negocios</option>
                                    <option>Aniversario</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="small fw-bold mb-2" style="color: var(--text-muted);">Preferencia de área</label>
                                <select class="form-select input-metra">
                                    <option>Salón Principal (Clima Controlado)</option>
                                    <option>Terraza Privada</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control input-metra" rows="2" placeholder="Notas sobre alergias, requerimientos dietéticos o solicitudes especiales..."></textarea>
                            </div>
                        </div>
                        
                        <div class="row mb-5">
                            <div class="col-12">
                                <h5 class="section-title mb-4" style="border-bottom: 1px solid var(--border-light); padding-bottom: 12px; color: var(--black-primary); font-weight: 700;">4. Complementos (Opcional)</h5>
                            </div>
                            
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-12 col-md-6">
                                        <input type="radio" name="combo_seleccionado" id="combo1" value="ejecutivo" class="btn-check">
                                        <label class="card h-100 border-1 p-3 w-100" for="combo1" style="cursor: pointer; border-color: var(--border-light); transition: 0.2s;">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <span class="badge" style="background: var(--off-white); color: var(--black-primary);">Despensa Matutina</span>
                                                <span class="fw-bold" style="color: var(--black-primary);">$149</span>
                                            </div>
                                            <h6 class="fw-bold mb-1">Desayuno Ejecutivo</h6>
                                            <p class="x-small text-muted mb-0" style="font-size: 0.8rem;">Especialidad del chef + Bebida.</p>
                                        </label>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <input type="radio" name="combo_seleccionado" id="combo4" value="ninguno" class="btn-check" checked>
                                        <label class="card h-100 border-1 p-3 w-100" for="combo4" style="cursor: pointer; border-color: var(--border-light); transition: 0.2s;">
                                            <div class="text-center py-2">
                                                <h6 class="fw-bold mb-1" style="color: var(--black-primary);">Ningún Complemento</h6>
                                                <p class="x-small text-muted mb-0" style="font-size: 0.8rem;">Continuar solo con la mesa.</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" class="btn-metra-main px-5 py-4 w-100" style="font-size: 1.1rem; border-radius: 12px;">
                                Formalizar Reservación
                            </button>
                        </div>
                    </form>
                    
                    <!-- Trust Badges Limpios -->
                    <div class="mt-5 pt-4 border-top" style="border-color: var(--border-light) !important;">
                        <div class="row text-center flex-nowrap overflow-auto" style="color: var(--text-muted);">
                            <div class="col-4">
                                <i class="bi bi-shield-check d-block mb-2 fs-4" style="color: var(--black-primary);"></i>
                                <span style="font-size: 0.70rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">Datos Encriptados</span>
                            </div>
                            <div class="col-4 border-start border-end" style="border-color: var(--border-light) !important;">
                                <i class="bi bi-calendar-check d-block mb-2 fs-4" style="color: var(--black-primary);"></i>
                                <span style="font-size: 0.70rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">Aprobación Instantánea</span>
                            </div>
                            <div class="col-4">
                                <i class="bi bi-envelope-paper d-block mb-2 fs-4" style="color: var(--black-primary);"></i>
                                <span style="font-size: 0.70rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">Recepción Digital</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
    @include('partials.footer')

</body>
</html>