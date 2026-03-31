<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suma tu Cafetería | METRA</title>
    <link rel='icon' href='{{ asset('favicon.png') }}?v=6' type='image/png'>
    <link rel='icon' href='{{ asset('favicon.svg') }}?v=6' type='image/svg+xml'>
    <meta name="description" content="Contrata METRA para gestionar reservas, mesas y clientes de tu cafetería con elegancia. Elige un plan hoy.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Usamos los estilos globales del sistema METRA -->
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg py-3 py-lg-4" style="background: rgba(248, 249, 250, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border-light); position: sticky; top: 0; z-index: 1000;">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="{{ url('/') }}" style="color: var(--black-primary); letter-spacing: -0.5px;">
            <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold); font-size: 1.2rem;"></i>METRA
        </a>
        <div class="d-flex align-items-center gap-3 order-lg-3 ms-auto ms-lg-0">
            <a href="{{ url('/login') }}" class="btn-metra-main px-4 py-2 rounded-pill" style="font-size: 0.9rem;">Iniciar Sesión</a>
            <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navRegistro">
                <i class="bi bi-list fs-2" style="color: var(--black-primary);"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse order-lg-2" id="navRegistro">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2 gap-lg-4 mt-3 mt-lg-0 me-lg-4">
                <li class="nav-item"><a href="{{ url('/') }}" class="nav-link nav-link-custom" style="color: #111111 !important;">Inicio</a></li>
                <li class="nav-item"><a href="{{ url('/#cafeterias') }}" class="nav-link nav-link-custom" style="color: #111111 !important;">Ver Cafeterías</a></li>
                <li class="nav-item"><a href="{{ url('/registro-negocio') }}" class="nav-link nav-link-custom" style="color: #111111 !important;">Sumar Cafetería</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero-premium text-center text-lg-start">
    <div class="container position-relative" style="z-index:1;">
        <div class="row align-items-center gy-5">
            <div class="col-lg-6">
                <div class="hero-badge"><i class="bi bi-star-fill me-2"></i> Software de Alta Gama</div>
                <h1>La gestión que tu café<br><span>realmente merece</span></h1>
                <p class="fs-5 mt-4" style="color: var(--text-muted); max-width: 500px; font-weight: 400;">
                    El estándar en gestión de reservas y mesas que los restaurantes modernos están utilizando. Elegante, rápido y sin complicaciones.
                </p>
                <div class="d-flex flex-wrap gap-3 mt-5 justify-content-center justify-content-lg-start">
                    <button onclick="document.getElementById('registro').scrollIntoView({ behavior: 'smooth' });" class="btn-metra-main">
                        <i class="bi bi-rocket-takeoff me-2"></i> Comenzar registro
                    </button>
                    <a href="#planes" class="btn rounded-pill px-4 fw-600" style="padding: 16px; font-weight: 600; border: 2px solid var(--accent-gold); color: var(--accent-gold); background: transparent;">
                        Ver Planes
                    </a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div style="background: var(--off-white); border: 1px solid var(--border-light); border-radius: 30px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                    <div class="row g-4 text-start">
                        <div class="col-6">
                            <h2 class="fw-bold mb-1" style="color: var(--black-primary);">+2,400</h2>
                            <div style="color: var(--text-muted); font-size: 0.9rem; font-weight: 600;">Reservas gestionadas</div>
                        </div>
                        <div class="col-6">
                            <h2 class="fw-bold mb-1" style="color: var(--black-primary);">150+</h2>
                            <div style="color: var(--text-muted); font-size: 0.9rem; font-weight: 600;">Cafeterías exclusivas</div>
                        </div>
                        <div class="col-6">
                            <h2 class="fw-bold mb-1" style="color: var(--black-primary);">98%</h2>
                            <div style="color: var(--text-muted); font-size: 0.9rem; font-weight: 600;">Satisfacción de dueños</div>
                        </div>
                        <div class="col-6">
                            <h2 class="fw-bold mb-1" style="color: var(--black-primary);">24/7</h2>
                            <div style="color: var(--text-muted); font-size: 0.9rem; font-weight: 600;">Soporte premium</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BENEFICIOS -->
<section class="py-5" style="margin-top: 40px;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: var(--black-primary); font-size: 2.2rem;">Diseñado para la excelencia</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="info-card text-center h-100">
                    <div class="benefit-icon-wrapper mx-auto"><i class="bi bi-calendar-check"></i></div>
                    <h5 class="fw-bold mt-3">Reservas Impecables</h5>
                    <p class="text-muted small mt-2 mb-0">Tus clientes reservan su mesa online con una interfaz elegante desde cualquier dispositivo.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="info-card text-center h-100">
                    <div class="benefit-icon-wrapper mx-auto"><i class="bi bi-grid"></i></div>
                    <h5 class="fw-bold mt-3">Control de Mesas</h5>
                    <p class="text-muted small mt-2 mb-0">Mapa visual en tiempo real para optimizar tu ocupación sin saturaciones.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="info-card text-center h-100">
                    <div class="benefit-icon-wrapper mx-auto"><i class="bi bi-people"></i></div>
                    <h5 class="fw-bold mt-3">Fidelización</h5>
                    <p class="text-muted small mt-2 mb-0">Base de datos automatizada para conocer las preferencias de tus mejores clientes.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="info-card text-center h-100">
                    <div class="benefit-icon-wrapper mx-auto"><i class="bi bi-bar-chart"></i></div>
                    <h5 class="fw-bold mt-3">Métricas Clave</h5>
                    <p class="text-muted small mt-2 mb-0">Estadísticas precisas de ocupación e ingresos presentadas en dashboards limpios.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PLANES -->
<section class="py-5 bg-white" id="planes">
    <div class="container py-4">
        <div class="text-center mb-5">
            <div class="hero-badge mb-2">Inversión</div>
            <h2 class="fw-bold" style="color: var(--black-primary); font-size: 2.2rem;">Elige tu plan maestro</h2>
            <p class="text-muted">Desarrolla el máximo potencial de tu negocio.</p>
        </div>
        <div class="row g-4 justify-content-center" id="planes-container">
            <!-- Dinámico -->
            <div class="col-12 text-center py-5">
                <div class="spinner-border" style="color: var(--accent-gold);" role="status"></div>
                <p class="mt-3 text-muted">Cargando propuestas...</p>
            </div>
        </div>
    </div>
</section>

<!-- WIZARD REGISTRO (Fondo oscuro para destacar la tarjeta clara encimada) -->
<section id="registro" style="background: var(--black-primary); padding: 120px 0 80px;">
    <div class="container">
        <div class="text-center mb-5 text-white">
            <h2 class="fw-bold" style="font-size: 2.2rem;">Únete a la red METRA</h2>
            <p style="color: rgba(255,255,255,0.7);">Completa la información en 3 simples pasos</p>
        </div>
    </div>
</section>

<div class="container mb-5" style="position: relative; z-index: 20;">
    <div class="wizard-card" id="wizard-form">
        <!-- Alert removed manually to use SweetAlert instead -->

        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step-dot active" id="dot-1">1</div>
            <div class="step-line"></div>
            <div class="step-dot" id="dot-2">2</div>
            <div class="step-line"></div>
            <div class="step-dot" id="dot-3">3</div>
        </div>

        <!-- PASO 1 -->
        <div class="wizard-step active" id="step-1">
            <h4 class="fw-bold mb-1" style="color: var(--black-primary);">Detalles del Negocio</h4>
            <p class="text-muted mb-4">Información principal de tu cafetería</p>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre del negocio *</label>
                <input type="text" class="form-metra w-100" id="nombre" placeholder="Ej. Café Central" maxlength="100" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Descripción</label>
                <textarea class="form-metra w-100" id="descripcion" rows="2" placeholder="Un concepto elegante, especialidad en origen..." maxlength="255"></textarea>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Calle *</label>
                    <input type="text" class="form-metra w-100" id="calle" placeholder="Av. Principal" maxlength="100" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Núm. Ext. *</label>
                    <input type="text" class="form-metra w-100" id="num_exterior" placeholder="123" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Núm. Int. (Opc)</label>
                    <input type="text" class="form-metra w-100" id="num_interior" placeholder="Int 4" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Estado *</label>
                    <select class="form-select form-metra w-100" id="estado_republica" required>
                        <option value="">Selecciona un estado...</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Ciudad/Municipio *</label>
                    <select class="form-select form-metra w-100" id="ciudad" required disabled>
                        <option value="">Primero selecciona estado...</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">C.P. *</label>
                    <input type="text" class="form-metra w-100" id="cp" placeholder="Ej. 75700" maxlength="5" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Colonia *</label>
                    <input type="text" class="form-metra w-100" id="colonia" placeholder="Centro" maxlength="80" required>
                </div>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Teléfono *</label>
                    <input type="tel" class="form-metra w-100" id="telefono" placeholder="238 100 0000" maxlength="10" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-2">
                <button class="btn-metra-main" style="padding: 12px 30px;" onclick="goToStep(2)">Continuar <i class="bi bi-arrow-right ms-2"></i></button>
            </div>
        </div>

        <!-- PASO 2 -->
        <div class="wizard-step" id="step-2">
            <h4 class="fw-bold mb-1" style="color: var(--black-primary);">Tu perfil & Plan</h4>
            <p class="text-muted mb-4">Credenciales administrativas</p>
            
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nombre completo *</label>
                    <input type="text" class="form-metra w-100" id="gerente_name" placeholder="Juan García" maxlength="100" required>
                    <div class="text-danger small mt-1 d-none validation-error" id="error-gerente_name"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Correo corporativo *</label>
                    <input type="email" class="form-metra w-100" id="gerente_email" placeholder="admin@cafe.com" maxlength="255" required>
                    <div class="text-danger small mt-1 d-none validation-error" id="error-gerente_email"></div>
                </div>
            </div>
            
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contraseña *</label>
                    <div class="position-relative">
                        <input type="password" class="form-metra w-100 pe-5" id="gerente_password" placeholder="Mínimo 8 caracteres" minlength="8" required>
                        <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3 text-muted toggle-password" style="cursor: pointer; z-index: 10;"></i>
                    </div>
                    <div class="text-danger small mt-1 d-none validation-error" id="error-gerente_password"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Confirmar contraseña *</label>
                    <div class="position-relative">
                        <input type="password" class="form-metra w-100 pe-5" id="gerente_password_confirmation" placeholder="Repite tu contraseña" minlength="8" required>
                        <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3 text-muted toggle-password" style="cursor: pointer; z-index: 10;"></i>
                    </div>
                    <div class="text-danger small mt-1 d-none validation-error" id="error-gerente_password_confirmation"></div>
                </div>
            </div>
            
            <label class="form-label fw-semibold mb-2">Selección de plan *</label>
            <div id="plan-selector"></div>
            <div class="text-danger small mt-1 d-none validation-error" id="error-plan_id"></div>
            
            <div class="d-flex justify-content-between mt-5">
                <button class="btn-prev" onclick="goToStep(1)"><i class="bi bi-arrow-left me-2"></i>Atrás</button>
                <button class="btn-metra-main" style="padding: 12px 30px;" id="btn-registrar" onclick="registrarNegocio()">
                    <span id="btn-text">Confirmar y Avanzar</span>
                    <span id="btn-loading" class="d-none"><span class="spinner-border spinner-border-sm me-2"></span>Procesando...</span>
                </button>
            </div>
        </div>

        <!-- PASO 3 -->
        <div class="wizard-step" id="step-3">
            <h4 class="fw-bold mb-1" style="color: var(--black-primary);">Validación de Pago</h4>
            <p class="text-muted mb-4 small">Por favor, realiza la transferencia y sube tu comprobante para activar tu cuenta.</p>

            <div class="mb-4 p-4 rounded-4 bg-light border-0 shadow-sm" id="resumen-pedido" style="border-left: 4px solid var(--accent-gold) !important;">
                <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Resumen de Solicitud</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Negocio:</span>
                    <span class="fw-bold small" id="res-negocio">---</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Plan Seleccionado:</span>
                    <span class="fw-bold small" id="res-plan">---</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted small">Monto a Transferir:</span>
                    <span class="fw-bold h5 mb-0" style="color: var(--accent-gold);" id="res-monto">---</span>
                </div>
            </div>
            
            <div class="mb-4 p-4 rounded-4 border-0 shadow-sm" id="pago-s-info" style="background: #fdfaf8; border: 1px solid rgba(181, 146, 126, 0.2) !important;">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-metra-gold text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; background-color: var(--accent-gold);">
                        <i class="bi bi-bank" style="font-size: 0.9rem;"></i>
                    </div>
                    <h6 class="fw-bold mb-0" style="color: var(--black-primary); font-size: 1rem;">Instrucciones de Pago</h6>
                </div>
                
                <p class="small text-muted mb-3">Transfiere el monto exacto a la siguiente cuenta:</p>

                <div id="loading-pago-wizard" class="py-3 text-center">
                    <div class="spinner-border spinner-border-sm text-gold" style="color: var(--accent-gold);" role="status"></div>
                </div>

                <div id="pago-details-wizard" style="display:none;">
                    <div class="row g-3 small text-muted mb-2">
                        <div class="col-12 payment-detail-row">
                            <span class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 600;">Banco</span>
                            <span class="fw-bold text-dark fs-6" id="dyn-banco">---</span>
                        </div>
                        <div class="col-12 payment-detail-row">
                            <span class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 600;">CLABE Interbancaria</span>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold fs-5" id="dyn-clabe" style="color: var(--accent-gold); letter-spacing:1px;">---</span>
                                <button class="btn btn-sm p-0 text-muted" onclick="copyClabeWizard()" title="Copiar CLABE">
                                    <i class="bi bi-copy" id="clabe-copy-icon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-12 payment-detail-row">
                            <span class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 600;">Beneficiario / Destinatario</span>
                            <span class="fw-bold text-dark fs-6" id="dyn-beneficiario">---</span>
                        </div>
                        <div class="col-12 mt-3 p-3 bg-white bg-opacity-50 rounded-3 border-top" id="dyn-inst-box" style="display:none; border-top-style: dashed !important;">
                            <i class="bi bi-info-circle me-1" style="color: var(--accent-gold);"></i> <span id="dyn-instrucciones" class="text-muted"></span>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top" style="border-top-style: solid !important;">
                        <h6 class="fw-bold text-dark mb-2" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Centro de Soporte</h6>
                        <div class="d-flex flex-wrap gap-3 small fw-semibold">
                            <span id="dyn-email-box" style="display:none;"><i class="bi bi-envelope-at text-danger me-1"></i> <span id="dyn-email" class="text-dark"></span></span>
                            <span id="dyn-tel-box" style="display:none;"><i class="bi bi-telephone text-primary me-1"></i> <span id="dyn-telefono" class="text-dark"></span></span>
                            <span id="dyn-wts-box" style="display:none;"><i class="bi bi-whatsapp text-success me-1"></i> <span id="dyn-whatsapp" class="text-dark"></span></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="upload-area" id="upload-area" onclick="document.getElementById('comprobante-input').click()">
                <i class="bi bi-cloud-arrow-up"></i>
                <p class="mb-1 fw-semibold" style="color: var(--black-primary); font-size: 1.1rem;">Selecciona tu comprobante de transferencia</p>
                <p class="text-muted small">Arrastra el documento aquí o haz clic (JPG, PNG, PDF)</p>
            </div>
            <input type="file" id="comprobante-input" accept=".jpg,.jpeg,.png,.pdf" class="d-none" onchange="previewFile(this)">
            <div id="file-preview" class="text-center mt-3"></div>
            
            <div class="d-flex justify-content-between mt-5">
                <button class="btn-prev" onclick="goToStep(2)">Atrás</button>
                <button class="btn-metra-main" style="padding: 12px 30px;" id="btn-subir" onclick="subirComprobante()">
                    <span id="btn-subir-text">Finalizar Solicitud <i class="bi bi-check2-circle ms-2"></i></span>
                    <span id="btn-subir-loading" class="d-none"><span class="spinner-border spinner-border-sm me-2"></span>Enviando...</span>
                </button>
            </div>
        </div>

        <!-- SUCCESS -->
        <div class="wizard-step" id="step-success">
            <div class="text-center py-4">
                <div class="success-icon"><i class="bi bi-check2"></i></div>
                <h2 class="fw-bold mb-3" style="color: var(--black-primary);">Excelencia en proceso</h2>
                <p class="text-muted mx-auto" style="max-width: 450px; line-height: 1.6;">
                    Hemos recibido la documentación de tu cafetería correctamente. Nuestro equipo administrativo validará el formato y en breve recibirás tus credenciales de acceso oficial.
                </p>
                <div class="d-flex gap-3 justify-content-center mt-5">
                    <a href="{{ url('/') }}" class="btn-prev text-decoration-none">Volver al inicio</a>
                    <a href="{{ url('/login') }}" class="btn-metra-main" style="padding: 14px 35px;">Portal Administrativo</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER REDUCIDO -->
<footer class="py-4 bg-white border-top text-center text-muted small">
    <div class="container">
        <p class="mb-0">© 2026 METRA · Diseñado para la alta gastronomía</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.API_URL = "{{ url('/api') }}";
    window.FILE_URL = "{{ url('/') }}";
</script>
<script>
    window.escapeHTML = function(str) {
        if (str === null || str === undefined) return '';
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
    };

    let selectedPlanId = null;
    let registeredCafeteriaId = null;

    let estadosMunicipiosData = {};

    async function cargarEstadosMunicipios() {
        try {
            const res = await fetch('/data/estados-municipios.json');
            estadosMunicipiosData = await res.json();
            
            const estadoSelect = document.getElementById('estado_republica');
            const ciudadSelect = document.getElementById('ciudad');
            
            Object.keys(estadosMunicipiosData).sort().forEach(estado => {
                const option = document.createElement('option');
                option.value = estado;
                option.textContent = estado;
                estadoSelect.appendChild(option);
            });
            
            estadoSelect.addEventListener('change', function() {
                const estado = this.value;
                ciudadSelect.innerHTML = '<option value="">Selecciona un municipio...</option>';
                
                if (estado && estadosMunicipiosData[estado]) {
                    ciudadSelect.disabled = false;
                    estadosMunicipiosData[estado].sort().forEach(municipio => {
                        const option = document.createElement('option');
                        option.value = municipio;
                        option.textContent = municipio;
                        ciudadSelect.appendChild(option);
                    });
                } else {
                    ciudadSelect.innerHTML = '<option value="">Primero selecciona estado...</option>';
                    ciudadSelect.disabled = true;
                }
            });

            // Restaurar selects si hay datos
            const savedDataStr = localStorage.getItem('wizard_form_data');
            if (savedDataStr) {
                try {
                    const data = JSON.parse(savedDataStr);
                    if (data.estado_republica) {
                        estadoSelect.value = data.estado_republica;
                        estadoSelect.dispatchEvent(new Event('change'));
                        if (data.ciudad) {
                           ciudadSelect.value = data.ciudad;
                        }
                    }
                } catch(e){}
            }
        } catch(e) {
            console.error("Error cargando estados y municipios", e);
        }
    }

    // Recuperar estado al cargar
    document.addEventListener("DOMContentLoaded", function() {
        cargarEstadosMunicipios();
        
        // Restaurar IDs
        const savedCafeId = localStorage.getItem('registro_cafeteria_id');
        if (savedCafeId) {
            registeredCafeteriaId = savedCafeId;
            goToStep(3);
        }

        // Restaurar datos guardados
        const savedData = localStorage.getItem('wizard_form_data');
        if (savedData) {
            try {
                const data = JSON.parse(savedData);
                Object.keys(data).forEach(key => {
                    const el = document.getElementById(key);
                    // Evitar sobreescribir selects dinámicos controlados arriba
                    if (el && key !== 'estado_republica' && key !== 'ciudad') {
                        el.value = data[key];
                    }
                });
                if (data.plan_id) {
                    selectedPlanId = data.plan_id;
                    // El selector visual se actualizará en renderPlanSelector
                }
            } catch (e) {
                console.error("Error al restaurar el estado del formulario", e);
            }
        }
    });

    // Guardar estado
    function saveFormState() {
        const inputs = ['nombre', 'descripcion', 'calle', 'num_exterior', 'num_interior', 'colonia', 'ciudad', 'estado_republica', 'cp', 'telefono', 'gerente_name', 'gerente_email'];
        const data = {};
        inputs.forEach(id => {
            const val = document.getElementById(id)?.value;
            if (val) data[id] = val;
        });
        if (selectedPlanId) data.plan_id = selectedPlanId;
        
        localStorage.setItem('wizard_form_data', JSON.stringify(data));
    }

    const formatterMXN = new Intl.NumberFormat('es-MX', {
        style: 'currency',
        currency: 'MXN',
        currencyDisplay: 'symbol'
    });

    window.cargarPlanes = async function() {
        try {
            const json = await MetraAPI.get('/planes-publicos');
            const planesData = json.data || [];
            renderPlanes(planesData);
            renderPlanSelector(planesData);
        } catch (e) {
            console.error('Error cargando planes:', e);
            document.getElementById('planes-container').innerHTML =
                '<div class="col-12 text-center text-danger py-4"><i class="bi bi-exclamation-triangle fs-2 mb-2 d-block"></i> Error de conectividad al cargar catálogo de planes.</div>';
        }
    };

    function renderPlanes(planes) {
        const container = document.getElementById('planes-container');
        if (!planes || planes.length === 0) {
            container.innerHTML = '<div class="col-12 text-center py-5 text-muted">No hay planes disponibles por el momento.</div>';
            return;
        }
        const midIndex = Math.floor(planes.length / 2);
        container.innerHTML = planes.map((plan, i) => {
            const featured = i === midIndex;
            return `
            <div class="col-md-6 col-lg-4">
                <div class="plan-card ${featured ? 'featured' : ''}">
                    ${featured ? '<div class="plan-badge-featured"><i class="bi bi-star-fill me-1"></i> Recomendado</div>' : ''}
                    <h4 class="fw-bold" style="color: var(--black-primary); text-transform: uppercase; font-size:1.1rem; letter-spacing:1px">${escapeHTML(plan.nombre_plan)}</h4>
                    <div class="plan-price mt-3 mb-2">
                        ${formatterMXN.format(plan.precio)} MXN<sub class="text-muted"> / mes</sub>
                    </div>
                    ${plan.descripcion ? `<p class="text-muted small mt-3 mb-0">${escapeHTML(plan.descripcion)}</p>` : ''}
                    <hr style="border-color: rgba(56,44,38,0.1); margin: 25px 0;">
                    <div class="d-flex flex-column gap-2 mb-4">
                        <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> ${plan.max_reservas_mes} reservas mensuales</div>
                        <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Hasta ${plan.max_usuarios_admin} usuarios del sistema</div>
                        <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Vigencia ${plan.duracion_dias} días</div>
                        <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Soporte Especializado</div>
                    </div>
                    <button class="${featured ? 'btn-metra-main' : 'btn-plan-outline'} w-100 mt-auto" style="border-radius: 50px;" onclick="window.selectPlanAndScroll(${plan.id})">
                        Seleccionar
                    </button>
                </div>
            </div>`;
        }).join('');
    }

    window.renderPlanSelector = function(planes) {
        document.getElementById('plan-selector').innerHTML = planes.map(plan => `
            <div class="plan-option d-flex justify-content-between align-items-center" id="po-${plan.id}" onclick="window.selectPlan(${plan.id})">
                <div>
                    <div class="fw-bold" style="color: var(--black-primary);">${escapeHTML(plan.nombre_plan)}</div>
                    <div class="text-muted small">${plan.max_reservas_mes} reservas · ${plan.max_usuarios_admin} usuarios</div>
                </div>
                <div class="fw-bold fs-5" style="color: var(--accent-gold);">${formatterMXN.format(plan.precio)} MXN</div>
            </div>
        `).join('');

        // Si ya hay un plan pre-seleccionado (desde la sección pública), aplica visual
        if (selectedPlanId) {
            document.getElementById(`po-${selectedPlanId}`)?.classList.add('selected');
        }
    };

    window.selectPlan = function(id) {
        selectedPlanId = id;
        document.querySelectorAll('.plan-option').forEach(el => el.classList.remove('selected'));
        document.getElementById(`po-${id}`)?.classList.add('selected');
        saveFormState();
    };

    window.selectPlanAndScroll = function(id) {
        window.selectPlan(id);
        const registroSection = document.getElementById('registro');
        if (registroSection) {
            registroSection.scrollIntoView({ behavior: 'smooth' });
            setTimeout(() => window.goToStep(2), 500);
        }
    };

    window.validarPaso1 = function() {
        const nombre = document.getElementById('nombre').value.trim();
        const calle = document.getElementById('calle').value.trim();
        const num_exterior = document.getElementById('num_exterior').value.trim();
        const num_interior = document.getElementById('num_interior').value.trim();
        const colonia = document.getElementById('colonia').value.trim();
        const ciudad = document.getElementById('ciudad').value.trim();
        const estado = document.getElementById('estado_republica').value.trim();
        const cp = document.getElementById('cp').value.trim();
        const telefono = document.getElementById('telefono').value.trim();

        if (!nombre) { showAlert('El nombre del negocio es obligatorio.'); return false; }
        if (nombre.length < 3) { showAlert('El nombre del negocio debe tener al menos 3 caracteres.'); return false; }
        if (!calle) { showAlert('La calle es obligatoria.'); return false; }
        if (!num_exterior) { showAlert('El número exterior es obligatorio.'); return false; }
        
        // Validar solo números en campos numéricos
        const regexNum = /^\d+$/;
        if (!regexNum.test(num_exterior)) { showAlert('El número exterior debe contener solo números.'); return false; }
        if (num_interior && !regexNum.test(num_interior)) { showAlert('El número interior debe contener solo números.'); return false; }
        
        if (!colonia) { showAlert('La colonia es obligatoria.'); return false; }
        if (!ciudad) { showAlert('La ciudad es obligatoria.'); return false; }
        if (!estado) { showAlert('El estado es obligatorio.'); return false; }
        
        if (!cp) { showAlert('El código postal es obligatorio.'); return false; }
        if (!/^\d{5}$/.test(cp)) {
            showAlert('El código postal debe ser de exactamente 5 dígitos numéricos.');
            return false;
        }
        
        if (!telefono) { showAlert('El teléfono es obligatorio.'); return false; }
        if (telefono.length !== 10 || !regexNum.test(telefono)) {
            showAlert('El teléfono debe ser de exactamente 10 dígitos numéricos.');
            return false;
        }
        
        saveFormState();
        return true;
    };

    window.goToStep = function(step) {
        if (step === 2 && !window.validarPaso1()) {
            return;
        }
        
        document.querySelectorAll('.wizard-step').forEach(s => s.classList.remove('active'));
        const nextStep = document.getElementById(`step-${step}`);
        if (nextStep) {
            nextStep.classList.add('active');
        }
        
        // Al llegar al paso 2: re-aplicar selección visual del plan
        if (step === 2 && selectedPlanId) {
            setTimeout(() => {
                document.querySelectorAll('.plan-option').forEach(el => el.classList.remove('selected'));
                document.getElementById(`po-${selectedPlanId}`)?.classList.add('selected');
            }, 50);
        }

        for (let i = 1; i <= 3; i++) {
            const dot = document.getElementById(`dot-${i}`);
            if (dot) {
                dot.classList.remove('active', 'done');
                if (i < step) dot.classList.add('done');
                else if (i === step) dot.classList.add('active');
            }
        }


        if (step === 3) {
            // Llenar resumen
            document.getElementById('res-negocio').textContent = document.getElementById('nombre').value;
            // Buscar plan nombre
            const planCard = document.getElementById(`po-${selectedPlanId}`);
            if (planCard) {
                document.getElementById('res-plan').textContent = planCard.querySelector('.fw-bold').textContent;
                document.getElementById('res-monto').textContent = planCard.querySelector('.fs-5').textContent;
            }
        }
    };

    function clearValidationErrors() {
        document.querySelectorAll('.validation-error').forEach(el => {
            el.textContent = '';
            el.classList.add('d-none');
        });
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    }

    function showValidationErrors(errors) {
        for (const [field, messages] of Object.entries(errors)) {
            const elementId = field.replace(/\./g, '_');
            const errorElement = document.getElementById(`error-${elementId}`);
            const inputElement = document.getElementById(elementId);
            
            if (errorElement) {
                errorElement.textContent = messages[0];
                errorElement.classList.remove('d-none');
            }
            if (inputElement) {
                inputElement.classList.add('is-invalid');
            }
        }
    }

    window.registrarNegocio = async function() {
        const name  = document.getElementById('gerente_name').value.trim();
        const email = document.getElementById('gerente_email').value.trim();
        const password = document.getElementById('gerente_password').value;
        const password_confirmation = document.getElementById('gerente_password_confirmation').value;

        const scrollToStep2 = () => document.getElementById('step-2').scrollIntoView({ behavior: 'smooth', block: 'start' });

        // Validaciones Paso 2
        if (!name) { showAlert('El nombre completo es obligatorio.'); scrollToStep2(); return; }
        if (!email) { showAlert('El correo corporativo es obligatorio.'); scrollToStep2(); return; }
        
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) { showAlert('El formato del correo institucional no es válido.'); scrollToStep2(); return; }
        
        if (!password) { showAlert('La contraseña es obligatoria.'); scrollToStep2(); return; }
        if (password.length < 8) { showAlert('La contraseña debe tener al menos 8 caracteres.'); scrollToStep2(); return; }
        if (password !== password_confirmation) { showAlert('Las contraseñas no coinciden. Por favor verifica.'); scrollToStep2(); return; }
        
        if (!selectedPlanId) { showAlert('Debes seleccionar un plan de suscripción para continuar.'); scrollToStep2(); return; }

        clearValidationErrors();

        const btnTxt = document.getElementById('btn-text');
        const btnLd = document.getElementById('btn-loading');
        btnTxt.classList.add('d-none'); btnLd.classList.remove('d-none');

        const payload = {
            nombre: document.getElementById('nombre').value.trim(),
            descripcion: document.getElementById('descripcion').value.trim() || null,
            calle: document.getElementById('calle').value.trim() || null,
            num_exterior: document.getElementById('num_exterior').value.trim() || null,
            num_interior: document.getElementById('num_interior').value.trim() || null,
            colonia: document.getElementById('colonia').value.trim() || null,
            ciudad: document.getElementById('ciudad').value.trim() || null,
            estado_republica: document.getElementById('estado_republica').value.trim() || null,
            cp: document.getElementById('cp').value.trim() || null,
            telefono: document.getElementById('telefono').value.trim() || null,
            gerente: { name, email, password, password_confirmation },
            plan_id: selectedPlanId,
        };

        try {
            const json = await MetraAPI.post('/registro-negocio', payload);
            console.log("registro response:", json);
            clearValidationErrors();
            
            if (json.data && json.data.cafeteria_id) {
                registeredCafeteriaId = json.data.cafeteria_id;
                localStorage.setItem('registro_cafeteria_id', registeredCafeteriaId);
                
                if (json.data.registro_existente) {
                    console.log("Registro existente detectado, avanzando a paso 3");
                }

                saveFormState();
                goToStep(3);
            } else {
                showAlert('No se pudo obtener el ID del negocio. Contacta a soporte.');
            }
        } catch(error) {
            clearValidationErrors();
            const status = error.status;
            const data = error.data || {};

            if (status === 422 && data.errors) {
                showValidationErrors(data.errors);
                showAlert('Revisa los campos marcados en rojo.');
            } else if (status === 403) {
                // Rechazado
                showAlert(data.message || 'Tu registro ha sido rechazado. Contacta a soporte.', 'error');
            } else if (status === 409) {
                // Ya tiene comprobante
                showAlert(data.message || 'Tu comprobante ya fue enviado y está en revisión.', 'info');
                
                // Limpiar local storage
                localStorage.removeItem('registro_cafeteria_id');
                localStorage.removeItem('wizard_form_data');

                // Destruir el wizard completamente mostrando la pantalla de bloque
                const wizardCard = document.getElementById('wizard-form');
                if (wizardCard) {
                    wizardCard.innerHTML = `
                        <div class="text-center py-5">
                            <i class="bi bi-shield-lock-fill mb-3" style="font-size: 5rem; color: var(--accent-gold);"></i>
                            <h2 class="fw-bold mb-3" style="color: var(--black-primary);">Comprobante en Revisión</h2>
                            <p class="text-muted mx-auto mb-4" style="max-width: 450px; line-height: 1.6;">
                                Hemos detectado que ya subiste el comprobante para esta cuenta. Por favor, espera a que nuestro equipo administrativo valide el formato oficial de tus credenciales de acceso.
                            </p>
                            <a href="${window.location.origin}" class="btn-metra-main px-4 py-2 mt-2">Volver al inicio</a>
                        </div>
                    `;
                }
            } else {
                let errorMsg = 'Algo salió mal al procesar tu solicitud. Intenta de nuevo más tarde.';
                if (status === 400 || data.message) {
                    errorMsg = data.message || errorMsg;
                }
                showAlert(errorMsg);
            }
        } 
        finally { btnTxt.classList.remove('d-none'); btnLd.classList.add('d-none'); }
    }

    /* COMPROBANTE */
    function previewFile(input) {
        const p = document.getElementById('file-preview');
        const uploadArea = document.getElementById('upload-area');
        if (!input.files.length) {
            p.innerHTML = '';
            uploadArea.style.display = 'block';
            return;
        }
        
        uploadArea.style.display = 'none'; // ocultar area original para mejorar UX
        const f = input.files[0];
        
        let htmlPreview = '';
        if (f.type.startsWith('image/')) {
            const rd = new FileReader();
            rd.onload = e => {
                p.innerHTML = `
                    <img src="${e.target.result}" style="max-width: 100%; max-height: 250px; object-fit: contain; border-radius: 8px; margin-top: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <div class="small text-muted mt-3 fw-semibold">${escapeHTML(f.name)}</div>
                    <div class="mt-3">
                        <button class="btn btn-sm btn-outline-danger me-2 shadow-sm rounded-pill px-3" onclick="rmFile()"><i class="bi bi-trash"></i> Eliminar</button>
                        <button class="btn btn-sm btn-outline-primary shadow-sm rounded-pill px-3" onclick="document.getElementById('comprobante-input').click()"><i class="bi bi-arrow-repeat"></i> Reemplazar</button>
                    </div>
                `;
            };
            rd.readAsDataURL(f);
        } else {
            p.innerHTML = `
                <div class="p-3 bg-light rounded-3 text-start border d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-file-pdf text-danger fs-3 me-2"></i><b>${escapeHTML(f.name)}</b> adjunto listo.
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-danger me-2" onclick="rmFile()"><i class="bi bi-trash"></i></button>
                        <button class="btn btn-sm btn-outline-primary" onclick="document.getElementById('comprobante-input').click()"><i class="bi bi-arrow-repeat"></i></button>
                    </div>
                </div>
            `;
        }
    }

    window.rmFile = function() {
        const input = document.getElementById('comprobante-input');
        input.value = '';
        document.getElementById('file-preview').innerHTML = '';
        document.getElementById('upload-area').style.display = 'block';
    }

    window.subirComprobante = async function() {
        const input = document.getElementById('comprobante-input');
        if (!input || !input.files.length) { showAlert('Por favor selecciona el soporte de pago visual.'); return; }
        
        const file = input.files[0];
        if (file.size > 5 * 1024 * 1024) { 
            showAlert('El archivo excede el límite de 5MB. Por favor selecciona uno más ligero.'); 
            rmFile(); // Limpia la vista en vez de solo remover valor
            return; 
        }

        const btnTxt = document.getElementById('btn-subir-text');
        const btnLd = document.getElementById('btn-subir-loading');
        
        // Bloquear UX
        btnTxt.classList.add('d-none'); 
        btnLd.classList.remove('d-none');
        document.getElementById('btn-subir').disabled = true;
        document.querySelector('#step-3 .btn-prev').disabled = true;

        const fd = new FormData(); 
        fd.append('comprobante', file);
        if (selectedPlanId) {
            fd.append('plan_id', selectedPlanId);
        }

        console.log("registeredCafeteriaId:", registeredCafeteriaId);
        console.log("URL comprobante:", `/api/registro-negocio/${registeredCafeteriaId}/comprobante`);

        try {
            const json = await MetraAPI.post(`/registro-negocio/${registeredCafeteriaId}/comprobante`, fd);
            
            // Éxito! Limpiar estado local y avanzar
            localStorage.removeItem('registro_cafeteria_id');
            localStorage.removeItem('wizard_form_data');
            
            document.querySelectorAll('.wizard-step').forEach(s => s.classList.remove('active'));
            document.getElementById('step-success').classList.add('active');
            document.querySelectorAll('.step-dot').forEach(d => { d.classList.remove('active'); d.classList.add('done'); });
            
        } catch(error) { 
            const status = error.status;
            const data = error.data || {};

            if (status === 409) {
                showAlert(data.message || 'Tu comprobante ya fue enviado y está en revisión', 'info');
                
                // Limpiar local storage
                localStorage.removeItem('registro_cafeteria_id');
                localStorage.removeItem('wizard_form_data');

                // Destruir el wizard completamente mostrando la pantalla de bloque
                const wizardCard = document.getElementById('wizard-form');
                if (wizardCard) {
                    wizardCard.innerHTML = `
                        <div class="text-center py-5">
                            <i class="bi bi-shield-lock-fill mb-3" style="font-size: 5rem; color: var(--accent-gold);"></i>
                            <h2 class="fw-bold mb-3" style="color: var(--black-primary);">Comprobante en Revisión</h2>
                            <p class="text-muted mx-auto mb-4" style="max-width: 450px; line-height: 1.6;">
                                Hemos detectado que ya subiste el comprobante para esta cuenta. Por favor, espera a que nuestro equipo administrativo valide el formato oficial de tus credenciales de acceso.
                            </p>
                            <a href="${window.location.origin}" class="btn-metra-main px-4 py-2 mt-2">Volver al inicio</a>
                        </div>
                    `;
                }
            } else if (status === 422 && data.errors && data.errors.comprobante) {
                showAlert(data.errors.comprobante[0]);
            } else {
                showAlert(data.message || 'Ocurrió un error general en el servidor o problema de conexión.');
            }
        } finally { 
            btnTxt.classList.remove('d-none'); 
            btnLd.classList.add('d-none'); 
            document.getElementById('btn-subir').disabled = false;
            document.querySelector('#step-3 .btn-prev').disabled = false;
        }
    };

    function showAlert(msg, icon = 'warning') { 
        Swal.fire({
            title: icon === 'info' ? 'Aviso' : 'Atención',
            text: msg,
            icon: icon,
            confirmButtonColor: '#382C26',
            confirmButtonText: 'Entendido'
        });
    }
    function hideAlert() { /* Left empty as UI alerts are no longer used */ }

    // Drag N Drop
    const ua = document.getElementById('upload-area');
    ua.addEventListener('dragover', e => { e.preventDefault(); ua.classList.add('dragover'); });
    ua.addEventListener('dragleave', () => ua.classList.remove('dragover'));
    ua.addEventListener('drop', e => { e.preventDefault(); ua.classList.remove('dragover'); document.getElementById('comprobante-input').files = e.dataTransfer.files; previewFile(document.getElementById('comprobante-input')); });

    // Contraseñas Toggle Ojo
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('toggle-password')) {
            const input = e.target.previousElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                e.target.classList.remove('bi-eye-slash');
                e.target.classList.add('bi-eye');
            } else {
                input.type = 'password';
                e.target.classList.remove('bi-eye');
                e.target.classList.add('bi-eye-slash');
            }
        }
    });

    // Consumo de endpoint de configuración
    async function cargarConfiguracionPago() {
        const loading = document.getElementById('loading-pago-wizard');
        const details = document.getElementById('pago-details-wizard');
        
        try {
            const json = await MetraAPI.get('/configuracion-pago');
            
            if(json.data) {
                const config = json.data;
                
                document.getElementById('dyn-banco').textContent = config.banco || 'No provisto';
                document.getElementById('dyn-beneficiario').textContent = config.beneficiario || 'No provisto';
                document.getElementById('dyn-clabe').textContent = config.clabe || 'No provista';
                
                if (config.instrucciones_pago) {
                    document.getElementById('dyn-inst-box').style.display = 'block';
                    document.getElementById('dyn-instrucciones').textContent = config.instrucciones_pago;
                } else {
                    document.getElementById('dyn-inst-box').style.display = 'none';
                }
                
                if (config.email_soporte) {
                    document.getElementById('dyn-email-box').style.display = 'inline-block';
                    document.getElementById('dyn-email').textContent = config.email_soporte;
                }
                if (config.telefono_soporte) {
                    document.getElementById('dyn-tel-box').style.display = 'inline-block';
                    document.getElementById('dyn-telefono').textContent = config.telefono_soporte;
                }
                if (config.whatsapp_soporte) {
                    document.getElementById('dyn-wts-box').style.display = 'inline-block';
                    document.getElementById('dyn-whatsapp').textContent = config.whatsapp_soporte;
                }

                if (loading) loading.style.display = 'none';
                if (details) details.style.display = 'block';
            } else {
                // Si no hay datos, ocultar sección o mostrar mensaje amable
                if (loading) loading.innerHTML = '<span class="text-muted small">Pendiente de configurar por el administrador.</span>';
            }
        } catch(e) {
            console.error('Error al cargar config pago', e);
            if (loading) loading.innerHTML = '<span class="text-danger small">Error al cargar datos. Verifica tu conexión.</span>';
        }
    }

    window.copyClabeWizard = function() {
        const clabe = document.getElementById('dyn-clabe').textContent;
        if (!clabe || clabe === '---') return;
        
        navigator.clipboard.writeText(clabe).then(() => {
            const icon = document.getElementById('clabe-copy-icon');
            icon.classList.remove('bi-copy');
            icon.classList.add('bi-check-lg', 'text-success');
            setTimeout(() => {
                icon.classList.remove('bi-check-lg', 'text-success');
                icon.classList.add('bi-copy');
            }, 2000);
        });
    }

    // Render inicial del plan seleccionado después de cargar planes
    const originalRenderPlanSelector = window.renderPlanSelector;
    window.renderPlanSelector = function(planes) {
        originalRenderPlanSelector(planes);
        if (selectedPlanId) selectPlan(selectedPlanId); // Reaplicar clase visual si había uno guardado en localStorage
    };

    document.addEventListener("DOMContentLoaded", function() {
        cargarPlanes();
        cargarConfiguracionPago();
    });
</script>
</body>
</html>
