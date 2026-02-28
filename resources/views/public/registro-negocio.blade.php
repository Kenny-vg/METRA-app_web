<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suma tu Cafetería | METRA</title>
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
<nav class="navbar navbar-expand-lg navbar-light-custom sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="/" style="color: var(--black-primary);">
            <i class="bi bi-cup-hot-fill me-2" style="color: var(--accent-gold);"></i>METRA
        </a>
        <div class="ms-auto text-end">
            <a href="/login" class="btn fw-semibold" style="color: var(--texto-s);">Iniciar Sesión</a>
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
                    <a href="#planes" class="btn btn-outline-dark rounded-pill px-4" style="padding: 16px; font-weight: 600; border-width: 2px; color: var(--black-primary); border-color: var(--black-primary);">
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
        <!-- Alert -->
        <div class="alert alert-danger rounded-3" style="display:none; background: #FFF5F5; border-color: #FFDEDC; color: #B3261E;" id="alert-box" role="alert"></div>

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
                    <label class="form-label fw-semibold">Calle</label>
                    <input type="text" class="form-metra w-100" id="calle" placeholder="Av. Principal" maxlength="100">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Núm. Ext.</label>
                    <input type="text" class="form-metra w-100" id="num_exterior" placeholder="123" maxlength="10">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Núm. Int. (Opc)</label>
                    <input type="text" class="form-metra w-100" id="num_interior" placeholder="Int 4" maxlength="10">
                </div>
            </div>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Colonia</label>
                    <input type="text" class="form-metra w-100" id="colonia" placeholder="Centro" maxlength="80">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Ciudad</label>
                    <input type="text" class="form-metra w-100" id="ciudad" placeholder="Tehuacán" maxlength="80">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Teléfono</label>
                    <input type="tel" class="form-metra w-100" id="telefono" placeholder="238 100 0000" maxlength="20" inputmode="numeric" pattern="[0-9\s\-\+]+">
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
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Correo corporativo *</label>
                    <input type="email" class="form-metra w-100" id="gerente_email" placeholder="admin@cafe.com" maxlength="255" required>
                </div>
            </div>
            
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contraseña *</label>
                    <input type="password" class="form-metra w-100" id="gerente_password" placeholder="Mínimo 8 caracteres" minlength="8" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Confirmar contraseña *</label>
                    <input type="password" class="form-metra w-100" id="gerente_password_confirmation" placeholder="Repite tu contraseña" minlength="8" required>
                </div>
            </div>
            
            <label class="form-label fw-semibold mb-2">Selección de plan *</label>
            <div id="plan-selector"></div>
            
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
            <p class="text-muted mb-4">
                Transfiere tu cuota inicial a <strong id="dynamic-clabe" style="color: var(--accent-gold);">CLABE: 0123 4567 8901 2345 67</strong> y adjunta el soporte visual.
            </p>
            
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
                    <a href="/" class="btn-prev text-decoration-none">Volver al inicio</a>
                    <a href="/login" class="btn-metra-main" style="padding: 14px 35px;">Portal Administrativo</a>
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

<script>
    const API_BASE = '/api';
    let selectedPlanId = null;
    let registeredCafeteriaId = null;

    async function cargarPlanes() {
        try {
            const res = await fetch(`${API_BASE}/planes-publicos`);
            const json = await res.json();
            const planesData = json.data || [];
            renderPlanes(planesData);
            renderPlanSelector(planesData);
        } catch (e) {
            document.getElementById('planes-container').innerHTML =
                '<div class="col-12 text-center text-danger">Error de conectividad al cargar catálogo de planes.</div>';
        }
    }

    function renderPlanes(planes) {
        const container = document.getElementById('planes-container');
        if (!planes.length) return;
        const midIndex = Math.floor(planes.length / 2);
        container.innerHTML = planes.map((plan, i) => {
            const featured = i === midIndex;
            return `
            <div class="col-md-6 col-lg-4">
                <div class="plan-card ${featured ? 'featured' : ''}">
                    ${featured ? '<div class="plan-badge-featured"><i class="bi bi-star-fill me-1"></i> Recomendado</div>' : ''}
                    <h4 class="fw-bold" style="color: var(--black-primary); text-transform: uppercase; font-size:1.1rem; letter-spacing:1px">${plan.nombre_plan}</h4>
                    <div class="plan-price mt-3 mb-2">
                        <span>$</span>${parseFloat(plan.precio).toLocaleString('es-MX')}<sub class="text-muted">/mes</sub>
                    </div>
                    ${plan.descripcion ? `<p class="text-muted small mt-3 mb-0">${plan.descripcion}</p>` : ''}
                    <hr style="border-color: rgba(56,44,38,0.1); margin: 25px 0;">
                    <div class="d-flex flex-column gap-2 mb-4">
                        <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> ${plan.max_reservas_mes} reservas mensuales</div>
                        <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> ${plan.max_usuarios_admin} acceso(s) administrador</div>
                        <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Vigencia ${plan.duracion_dias} días</div>
                        <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Soporte Especializado</div>
                    </div>
                    <button class="${featured ? 'btn-metra-main' : 'btn-plan-outline'} w-100 mt-auto" style="border-radius: 50px;" onclick="selectPlanAndScroll(${plan.id})">
                        Seleccionar
                    </button>
                </div>
            </div>`;
        }).join('');
    }

    function renderPlanSelector(planes) {
        document.getElementById('plan-selector').innerHTML = planes.map(plan => `
            <div class="plan-option d-flex justify-content-between align-items-center" id="po-${plan.id}" onclick="selectPlan(${plan.id})">
                <div>
                    <div class="fw-bold" style="color: var(--black-primary);">${plan.nombre_plan}</div>
                    <div class="text-muted small">${plan.max_reservas_mes} reservas · ${plan.max_usuarios_admin} admin</div>
                </div>
                <div class="fw-bold fs-5" style="color: var(--accent-gold);">$${parseFloat(plan.precio).toLocaleString('es-MX')}</div>
            </div>
        `).join('');
    }

    function selectPlan(id) {
        selectedPlanId = id;
        document.querySelectorAll('.plan-option').forEach(el => el.classList.remove('selected'));
        document.getElementById(`po-${id}`)?.classList.add('selected');
    }

    function selectPlanAndScroll(id) {
        selectPlan(id);
        document.getElementById('registro').scrollIntoView({ behavior: 'smooth' });
        setTimeout(() => goToStep(2), 500);
    }

    /* WIZARD LOGIC */
    function goToStep(step) {
        if (step === 2 && !document.getElementById('nombre').value.trim()) {
            showAlert('Por favor, indica el nombre de la cafetería.'); return;
        }
        hideAlert();
        document.querySelectorAll('.wizard-step').forEach(s => s.classList.remove('active'));
        document.getElementById(`step-${step}`).classList.add('active');
        
        for (let i = 1; i <= 3; i++) {
            const dot = document.getElementById(`dot-${i}`);
            dot.classList.remove('active', 'done');
            if (i < step) dot.classList.add('done');
            else if (i === step) dot.classList.add('active');
        }
    }

    /* SUBMIT */
    async function registrarNegocio() {
        const name  = document.getElementById('gerente_name').value.trim();
        const email = document.getElementById('gerente_email').value.trim();
        const password = document.getElementById('gerente_password').value;
        const password_confirmation = document.getElementById('gerente_password_confirmation').value;

        if (!name || !email) { showAlert('Completa tu nombre y correo corporativo.'); return; }
        if (password.length < 8) { showAlert('La contraseña debe tener al menos 8 caracteres.'); return; }
        if (password !== password_confirmation) { showAlert('Las contraseñas no coinciden.'); return; }
        if (!selectedPlanId) { showAlert('Selecciona una propuesta de suscripción.'); return; }

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
            telefono: document.getElementById('telefono').value.trim() || null,
            gerente: { name, email, password, password_confirmation },
            plan_id: selectedPlanId,
        };

        try {
            const res = await fetch(`${API_BASE}/registro-negocio`, {
                method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify(payload)
            });
            const json = await res.json();
            if (!res.ok) throw new Error(json.errors ? Object.values(json.errors).flat().join(' | ') : (json.message || 'Error'));
            
            registeredCafeteriaId = json.data.cafeteria_id;
            hideAlert();
            goToStep(3); // Visual trick covered by normal goto
        } catch (e) { showAlert(e.message); } 
        finally { btnTxt.classList.remove('d-none'); btnLd.classList.add('d-none'); }
    }

    /* COMPROBANTE */
    function previewFile(input) {
        const p = document.getElementById('file-preview');
        if (!input.files.length) return p.innerHTML = '';
        const f = input.files[0];
        if (f.type.startsWith('image/')) {
            const rd = new FileReader();
            rd.onload = e => p.innerHTML = `<img src="${e.target.result}" style="max-width: 100%; max-height: 250px; object-fit: contain; border-radius: 8px; margin-top: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"><div class="small text-muted mt-2 fw-semibold">${f.name}</div>`;
            rd.readAsDataURL(f);
        } else {
            p.innerHTML = `<div class="p-3 bg-light rounded-3 text-start border"><i class="bi bi-file-pdf text-danger fs-3 me-2"></i><b>${f.name}</b> adjunto listo.</div>`;
        }
    }

    async function subirComprobante() {
        const input = document.getElementById('comprobante-input');
        if (!input.files.length) { showAlert('Por favor selecciona el soporte de pago visual.'); return; }
        
        const file = input.files[0];
        // 5 MB en Bytes
        if (file.size > 5 * 1024 * 1024) { 
            showAlert('El archivo excede el límite de 5MB. Por favor selecciona uno más ligero.'); 
            input.value = ''; // Limpiar el input
            document.getElementById('file-preview').innerHTML = '';
            return; 
        }

        const btnTxt = document.getElementById('btn-subir-text');
        const btnLd = document.getElementById('btn-subir-loading');
        btnTxt.classList.add('d-none'); btnLd.classList.remove('d-none');

        const fd = new FormData(); 
        fd.append('comprobante', file);
        if (selectedPlanId) {
            fd.append('plan_id', selectedPlanId); // <- Se envía siempre junto como solicitaste
        }

        try {
            const res = await fetch(`${API_BASE}/registro-negocio/${registeredCafeteriaId}/comprobante`, {
                method: 'POST', headers: { 'Accept': 'application/json' }, body: fd
            });
            if (!res.ok) {
                const json = await res.json();
                throw new Error(json.message || 'Ocurrió un error en la transferencia del archivo.');
            }
            
            // Go to success
            document.querySelectorAll('.wizard-step').forEach(s => s.classList.remove('active'));
            document.getElementById('step-success').classList.add('active');
            document.querySelectorAll('.step-dot').forEach(d => { d.classList.remove('active'); d.classList.add('done'); });
            hideAlert();
        } catch(e) { showAlert(e.message); }
        finally { btnTxt.classList.remove('d-none'); btnLd.classList.add('d-none'); }
    }

    function showAlert(msg) { const b = document.getElementById('alert-box'); b.textContent = msg; b.style.display = 'block'; }
    function hideAlert() { document.getElementById('alert-box').style.display = 'none'; }

    // Drag N Drop
    const ua = document.getElementById('upload-area');
    ua.addEventListener('dragover', e => { e.preventDefault(); ua.classList.add('dragover'); });
    ua.addEventListener('dragleave', () => ua.classList.remove('dragover'));
    ua.addEventListener('drop', e => { e.preventDefault(); ua.classList.remove('dragover'); document.getElementById('comprobante-input').files = e.dataTransfer.files; previewFile(document.getElementById('comprobante-input')); });

    // Preparado para consumo de endpoint futuro de cuenta CLABE
    async function cargarConfiguracionPago() {
        // const res = await fetch(`${API_BASE}/configuracion-pago`);
        // const json = await res.json();
        // document.getElementById('dynamic-clabe').textContent = `CLABE: ${json.data.clabe}`;
    }

    cargarPlanes();
    // cargarConfiguracionPago();
</script>
</body>
</html>
