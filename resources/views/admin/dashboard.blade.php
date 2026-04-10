@extends('admin.menu')
@section('title', 'Métricas General')

@section('content')
    <header class="mb-5 border-bottom pb-4" style="border-color: var(--border-light) !important;">
        <h2 class="fw-bold" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Resumen Operativo</h2>
        <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Métricas clave de Café Central en tiempo real.</p>
    </header>

    <div id="alerta-vencimiento-container"></div>

    <div class="row g-4 mb-5">
        <div class="col-12" id="suscripcion-widget-container">
            <!-- Cargando suscripción -->
        </div>
    </div>


    <div class="row g-3 mb-5 text-center row-cols-1 row-cols-md-3 row-cols-xl-5">
        <!-- 1. Servicios Totales (Unificado) -->
        <div class="col">
            <div class="card border-0 p-3 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small fw-bold text-uppercase" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.65rem;">Servicios Totales</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: var(--off-white); color: var(--black-primary);">
                        <i class="bi bi-people-fill fs-6"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" id="dash_visitas_totales" style="color: var(--black-primary); font-size: 1.8rem; letter-spacing: -1px;">...</h3>
                <div class="d-flex align-items-center mt-2 justify-content-center">
                    <span id="dash_desglose_fuentes" class="small fw-bold" style="color: var(--text-muted); font-size: 0.65rem;">Cargando...</span>
                </div>
            </div>
        </div>

        <!-- 2. Ocupación Real (%) -->
        <div class="col">
             <div class="card border-0 p-3 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small fw-bold text-uppercase" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.65rem;">Ocupación Real</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: rgba(56, 44, 38, 0.05); color: var(--black-primary);">
                        <i class="bi bi-house-door-fill fs-6"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" id="dash_ocupacion_real" style="color: var(--black-primary); font-size: 1.8rem; letter-spacing: -1px;">0%</h3>
                <div class="mt-2 text-center">
                    <span id="dash_insight_ocupacion" class="badge rounded-pill" style="background: rgba(46, 125, 50, 0.1); color: #2E7D32; border: 1px solid rgba(46, 125, 50, 0.2); font-size: 0.6rem; font-weight: 700;">Calculando...</span>
                </div>
            </div>
        </div>

        <!-- 3. Tiempo Promedio de Estancia -->
        <div class="col">
             <div class="card border-0 p-3 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small fw-bold text-uppercase" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.65rem;">Tiempo de Estancia</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: rgba(13, 110, 253, 0.05); color: #0d6efd;">
                        <i class="bi bi-clock-fill fs-6"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" id="dash_tiempo_estancia" style="color: var(--black-primary); font-size: 1.8rem; letter-spacing: -1px;">0m</h3>
                <div class="mt-2 text-center">
                    <span id="dash_insight_fuente" class="badge rounded-pill" style="background: rgba(13, 110, 253, 0.1); color: #0d6efd; font-size: 0.6rem; font-weight: 700;">Promedio Hoy</span>
                </div>
            </div>
        </div>

        <!-- 4. Tasa No-Show -->
        <div class="col">
             <div class="card border-0 p-3 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small fw-bold text-uppercase" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.65rem;">Tasa No-Show</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: var(--off-white); color: #c62828;">
                        <i class="bi bi-person-x-fill fs-6"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" id="dash_noshow_rate" style="color: var(--black-primary); font-size: 1.8rem; letter-spacing: -1px;">0%</h3>
                <div class="mt-2 text-center">
                    <span id="dash_insight_noshow" class="badge rounded-pill" style="background: rgba(108, 117, 125, 0.1); color: #6c757d; font-size: 0.6rem; font-weight: 700;">Solo Reservas</span>
                </div>
            </div>
        </div>


        <!-- 5. Fidelidad -->
        <div class="col">
             <div class="card border-0 p-4 h-100 premium-card locked-container" id="card-fidelidad-premium" style="background: var(--black-primary); border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small fw-bold text-uppercase" style="color: rgba(255,255,255,0.6); letter-spacing: 1px; font-size: 0.7rem;">Fidelidad</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); color: var(--accent-gold);">
                        <i class="bi bi-award-fill fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" id="dash_fidelidad_rate" style="color: var(--white-pure); font-size: 2.2rem; letter-spacing: -1px;">0%</h3>
                <div class="mt-2 text-center">
                    <span id="dash_insight_fidelidad" class="small fw-bold" style="color: var(--accent-gold); font-size: 0.7rem;">Clientes Recurrentes</span>
                </div>
            </div>
        </div>
    </div>


    <!-- Sección de Gráficos de Inteligencia -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-xl-8">
            <div class="card border-0 p-4 p-lg-5 h-100 premium-card locked-container" id="card-tendencia-premium">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center border-bottom pb-4 mb-4 gap-3">
                    <h5 class="fw-bold m-0"><i class="bi bi-graph-up me-2 text-primary"></i>Tendencia Semanal de Gestión</h5>
                    <span class="small text-muted">Últimos 7 días activos</span>
                </div>
                <div style="height: 320px;">
                    <canvas id="chartTendenciaSemanal"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
             <div class="card border-0 p-4 p-lg-5 h-100 premium-card locked-container" id="card-horaspico-premium">
                <div class="d-flex flex-column border-bottom pb-4 mb-4">
                    <h5 class="fw-bold m-0"><i class="bi bi-clock-history me-2 text-warning"></i>Horas Pico de Demanda</h5>
                    <span class="small text-muted mt-1">Afluencia por bloque horario</span>
                </div>
                <div style="height: 320px;">
                    <canvas id="chartHorasPico"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel de Control Diario -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-xl-5">
             <div class="card border-0 p-4 p-lg-5 h-100 premium-card">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center border-bottom pb-4 mb-4 gap-3" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Panel de Llegadas</h5>
                    <a href="/admin/reservaciones" class="small fw-bold text-decoration-none" style="color: var(--text-muted);">Ver todo →</a>
                </div>

                <div id="dash_panel_llegadas" class="d-flex flex-column gap-3 overflow-auto pe-2" style="max-height: 480px;">
                    <p class="text-muted text-center mt-3">Cargando llegadas...</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-7">
             <div class="card border-0 p-4 p-lg-5 premium-card shadow-sm h-100 locked-container" id="card-historico-premium">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0"><i class="bi bi-list-stars me-2 text-info"></i>Historial Operativo Mensual</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead style="background: var(--off-white);">
                            <tr>
                                <th class="text-secondary small fw-bold text-uppercase border-0 py-3 rounded-start">Periodo</th>
                                <th class="text-secondary small fw-bold text-uppercase border-0 py-3 text-center">Reservas</th>
                                <th class="text-secondary small fw-bold text-uppercase border-0 py-3 text-center">Cancelaciones</th>
                                <th class="text-secondary small fw-bold text-uppercase border-0 py-3 text-center">Efectividad</th>
                                <th class="text-secondary small fw-bold text-uppercase border-0 py-3 rounded-end text-end">Tendencia</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_historico">
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Cargando registros...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    @include('partials.footer_admin')

    <!-- Modal Renovar Suscripción -->
    <div class="modal fade" id="modalRenovar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 p-4">
                    <h5 class="fw-bold m-0" id="titulo-modal-renovar"><i class="bi bi-arrow-repeat me-2"></i>Renovar Suscripción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    <div id="modal-mensaje-revisar" class="d-none text-center p-4">
                        <h5 class="fw-bold fs-4 text-warning mb-3"><i class="bi bi-clock-history"></i></h5>
                        <h5 class="fw-bold">¡Pago en proceso!</h5>
                        <p class="text-muted">Tu comprobante ha sido recibido y está pendiente de validación por el administrador. Por favor, espera a que tu acceso sea reactivado.</p>
                    </div>

                    <form id="formRenovar" class="d-none">
                        <input type="hidden" id="r-email" name="email" value="">
                        <div class="mb-3" id="caja-r-plan">
                            <label class="form-label small fw-bold">Selecciona tu nuevo plan</label>
                            <select id="r-plan" class="form-select border-0 shadow-sm rounded-3" style="background: var(--off-white);" required>
                                <option value="">Cargando planes...</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Comprobante de Pago (PDF, JPG, PNG)</label>
                            <input type="file" id="r-comprobante" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" accept=".pdf,.jpg,.jpeg,.png" required>
                        </div>
                        <button type="submit" id="btn-submit-renovar" class="btn-admin-primary w-100 py-2">Enviar Renovación</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let chartRef = null;

        if (!localStorage.getItem('token')) {
            window.location.href = '/login';
        }

        async function cargarDashboard() {
            try {
                const json = await MetraAPI.get('/gerente/mi-cafeteria');
                const cafe = json.data;
                cafeteriaId = cafe.id;

                // Rellenar el campo email del modal de renovar sin depender de Blade/sesión PHP
                const emailField = document.getElementById('r-email');
                if (emailField && cafe.gerente?.email) emailField.value = cafe.gerente.email;

                renderWidgetSuscripcion(cafe);
                verificarRestriccionesPlan(cafe);
            } catch (e) {
                console.error('Error cargando perfil:', e);
                document.getElementById('suscripcion-widget-container').innerHTML = `
                    <div class="card border-0 p-4 text-center text-danger shadow-sm">
                        <i class="bi bi-wifi-off fs-1 mb-3"></i>
                        <h5 class="fw-bold">Error de conexión</h5>
                        <p class="text-muted m-0">No se pudo cargar la información de tu cafetería. Intenta recargar la página.</p>
                    </div>`;
            }
        }

        function renderWidgetSuscripcion(cafe) {
            const container = document.getElementById('suscripcion-widget-container');
            const alertContainer = document.getElementById('alerta-vencimiento-container');
            
            if (!cafe || !cafe.suscripcion_actual) {
                if (cafe && cafe.estado === 'pendiente') {
                    container.innerHTML = `
                        <div class="card border-0 p-4 premium-card text-center shadow-sm">
                            <h5 class="fw-bold mb-3 text-warning"><i class="bi bi-hourglass-split me-2"></i>Pago en validación</h5>
                            <p class="text-muted m-0">Tu suscripción venció, pero estamos validando tu pago. En breve tendrás acceso total.</p>
                        </div>`;
                } else {
                    container.innerHTML = `
                        <div class="card border-0 p-4 premium-card text-center shadow-sm">
                            <h5 class="fw-bold mb-3 text-danger"><i class="bi bi-exclamation-circle me-2"></i>Suscripción Vencida</h5>
                            <p class="text-muted m-0">No tienes una suscripción activa.</p>
                            <button class="btn-admin-primary mt-3 px-4" onclick="abrirModalRenovar('${cafe ? cafe.estado : ''}')"><i class="bi bi-arrow-repeat me-2"></i>Renovar ahora</button>
                        </div>`;
                    abrirModalRenovar(cafe ? cafe.estado : '');
                }
                return;
            }

            const sub = cafe.suscripcion_actual;
            const plan = sub.plan;
            const fechaFin = new Date(sub.fecha_fin);
            const hoy = new Date();
            // Calcular días restantes usando únicamente la fecha (sin considerar hora)
            // para evitar que fracciones de día influyan en el conteo.
            const inicioDia = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate());
            const finDia = new Date(fechaFin.getFullYear(), fechaFin.getMonth(), fechaFin.getDate());
            const diasRestantes = Math.max(0, Math.round((finDia - inicioDia) / (1000 * 60 * 60 * 24)));

            let htmlAlertas = '';
            
            // Alerta de plan desactivado
            if (plan && (plan.estado === false || plan.estado === 0)) {
                htmlAlertas += `
                    <div class="alert alert-warning border-0 rounded-3 mb-3 d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                        <div><strong>Atención:</strong> Este plan ya no está disponible. Tu próxima renovación deberá usar otro plan.</div>
                    </div>`;
            }

            // Alerta de revisión (prioritaria si ya subió comprobante)
            if (cafe.estado === 'pendiente' || cafe.estado === 'en_revision') {
                alertContainer.innerHTML = `
                    <div class="alert alert-info border-0 rounded-3 mb-4 d-flex align-items-center fw-bold shadow-sm" style="background-color: #e3f2fd; color: #0d47a1;">
                        <i class="bi bi-info-circle-fill me-3 fs-3"></i>
                        <div>Tu suscripción actual vence en ${diasRestantes} días. Tu nueva renovación está en proceso.</div>
                    </div>`;
            }
            // Alerta de vencimiento (solo si NO está en revisión)
            else if (diasRestantes <= 7 && diasRestantes >= 0) {
                alertContainer.innerHTML = `
                    <div class="alert alert-danger border-0 rounded-3 mb-4 d-flex align-items-center fw-bold shadow-sm" style="background-color: #ffebee; color: #c62828;">
                        <i class="bi bi-clock-history me-3 fs-3"></i>
                        <div>Tu suscripción vence en ${diasRestantes} días. Por favor, renueva para evitar la suspensión del servicio.</div>
                        <button class="btn btn-sm btn-danger ms-auto px-3" onclick="abrirModalRenovar('${cafe.estado}')">Renovar ahora</button>
                    </div>`;
            } else {
                alertContainer.innerHTML = '';
            }

            container.innerHTML = `
                ${htmlAlertas}
                <div class="card border-0 p-4 premium-card shadow-sm" style="background: var(--black-primary); color: white;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <span class="small fw-bold text-uppercase" style="color: var(--accent-gold); letter-spacing: 1px; font-size: 0.75rem;">Suscripción Actual</span>
                            <h3 class="fw-bold mb-1 mt-1 text-white">${escapeHTML(plan ? plan.nombre_plan : 'Plan Desconocido')}</h3>
                            <div class="small" style="color: rgba(255,255,255,0.7);">
                                <div>Válida hasta: <strong>${fechaFin.toLocaleDateString('es-ES')}</strong></div>
                                ${diasRestantes > 0 ? `<div>Tiempo restante: <strong>${diasRestantes} días</strong></div>` : `<div class="text-danger fw-bold">Suscripción Expirada</div>`}
                            </div>
                        </div>
                        <div class="text-end">
                            ${cafe.estado === 'pendiente' || cafe.estado === 'en_revision' 
                                ? `<div class="mt-2"><span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="bi bi-hourglass-split me-1"></i>Gracias, hemos recibido tu comprobante. El administrador lo está validando.</span></div>`
                                : `<button class="btn-admin-secondary px-4 py-2" onclick="abrirModalRenovar('${cafe.estado}')">
                                      <i class="bi bi-arrow-repeat me-2"></i>Renovar Suscripción
                                   </button>`
                            }
                        </div>
                    </div>
                </div>
            `;
        }


        async function abrirModalRenovar(estado = '') {
            const modal = new bootstrap.Modal(document.getElementById('modalRenovar'));
            const isPendiente = estado === 'pendiente' || estado === 'en_revision';
            
            document.getElementById('titulo-modal-renovar').innerHTML = isPendiente 
                ? '<i class="bi bi-receipt me-2"></i>Actualizar Comprobante' 
                : '<i class="bi bi-arrow-repeat me-2"></i>Renovar Suscripción';
                
            const divRevisar = document.getElementById('modal-mensaje-revisar');
            const formRenovar = document.getElementById('formRenovar');
            const selectPlan = document.getElementById('r-plan');

            if (isPendiente) {
                if(divRevisar) divRevisar.classList.remove('d-none');
                if(formRenovar) formRenovar.classList.add('d-none');
            } else {
                if(divRevisar) divRevisar.classList.add('d-none');
                if(formRenovar) formRenovar.classList.remove('d-none');

                try {
                    const json = await MetraAPI.get('/planes-publicos');
                    if (json.data) {
                        selectPlan.innerHTML = '<option value="">Selecciona un plan...</option>' + 
                            json.data.map(p => `<option value="${p.id}">${p.nombre_plan} ($${p.precio})</option>`).join('');
                    }
                } catch (e) {
                    console.error('Error cargando planes modal', e);
                    Swal.fire({ title: 'Error', text: 'No se pudieron cargar los planes de renovación. Revisa tu conexión.', icon: 'error', confirmButtonColor: '#382C26' });
                }
            }

            modal.show();
        }

        document.getElementById('formRenovar').addEventListener('submit', async (e) => {
            e.preventDefault();

            const planVal   = document.getElementById('r-plan').value;
            const fileInput = document.getElementById('r-comprobante').files[0];
            const selectReq = document.getElementById('r-plan').hasAttribute('required');

            if ((selectReq && !planVal) || !fileInput) {
                Swal.fire({ title: 'Atención', text: 'Completa todos los campos requeridos.', icon: 'warning', confirmButtonColor: '#382C26' });
                return;
            }
            if (fileInput.size > 5 * 1024 * 1024) {
                Swal.fire({ title: 'Atención', text: 'El comprobante no debe superar los 5 MB.', icon: 'warning', confirmButtonColor: '#382C26' });
                return;
            }

            const submitBtn = e.target.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';
            submitBtn.disabled = true;

            const formData = new FormData();
            formData.append('comprobante', fileInput);
            if (planVal) formData.append('plan_id', planVal);
            // Incluir email del gerente como respaldo para el controlador
            const emailInput = document.getElementById('r-email');
            if (emailInput && emailInput.value) formData.append('email', emailInput.value);

            try {
                const json = await MetraAPI.post('/gerente/renovar-suscripcion', formData);

                bootstrap.Modal.getInstance(document.getElementById('modalRenovar')).hide();

                Swal.fire({
                    title: '¡Solicitud Enviada!',
                    text: json.message || 'Tu comprobante está en revisión por el administrador.',
                    icon: 'success',
                    confirmButtonColor: '#212529'
                }).then(() => cargarDashboard());

            } catch(err) {
                Swal.fire({ title: 'Error', text: err.data?.message || err.message, icon: 'error', confirmButtonColor: '#382C26' });
            } finally {
                submitBtn.innerHTML = document.getElementById('btn-submit-renovar').dataset.label || 'Enviar Renovación';
                submitBtn.disabled = false;
            }
        });

        function verificarRestriccionesPlan(cafe) {
            const plan = cafe.suscripcion_actual?.plan;
            if (!plan) return;

            if (!plan.tiene_metricas_avanzadas) {
                const targets = [
                    { id: 'card-fidelidad-premium', title: 'Analítica de Fidelidad' },
                    { id: 'card-tendencia-premium', title: 'Tendencia de Gestión' },
                    { id: 'card-horaspico-premium', title: 'Análisis de Horas Pico' },
                    { id: 'card-historico-premium', title: 'Historial Operativo' }
                ];

                targets.forEach(t => {
                    const el = document.getElementById(t.id);
                    if (el) renderUpsellOverlay(el, t.title);
                });
            }
        }

        function renderUpsellOverlay(container, title) {
            if (container.querySelector('.upsell-overlay')) return;
            
            const overlay = document.createElement('div');
            overlay.className = 'upsell-overlay d-flex flex-column align-items-center justify-content-center text-center p-4 rounded-4';
            overlay.style.position = 'absolute';
            overlay.style.top = '0';
            overlay.style.left = '0';
            overlay.style.width = '100%';
            overlay.style.height = '100%';
            overlay.style.background = 'rgba(255,255,255,0.05)';
            overlay.style.backdropFilter = 'blur(10px)';
            overlay.style.webkitBackdropFilter = 'blur(10px)';
            overlay.style.zIndex = '10';

            overlay.innerHTML = `
                <div class="premium-lock-icon mb-3 shadow-lg d-flex align-items-center justify-content-center" 
                     style="width: 50px; height: 50px; background: rgba(255,255,255,0.1); backdrop-filter: blur(5px); border-radius: 50%; border: 2px solid var(--accent-gold);">
                    <i class="bi bi-patch-check-fill fs-4" style="color: var(--accent-gold);"></i>
                </div>
                <h6 class="fw-bold mb-1" style="color: white; letter-spacing: -0.5px; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">${title}</h6>
                <p class="small text-white-50 mb-3 px-3" style="font-size: 0.7rem; line-height: 1.2;">
                    Exclusivo del Plan Pro. Analítica inteligente para tu negocio.
                </p>
                <button class="btn btn-sm btn-dark px-3 py-1 fw-bold shadow" style="font-size: 0.7rem; border: 1px solid rgba(255,255,255,0.1);" onclick="abrirModalRenovar()">
                    <i class="bi bi-stars me-1 text-warning"></i>Mejorar Plan
                </button>
            `;
            
            container.style.position = 'relative';
            container.appendChild(overlay);
        }

        async function cargarLlegadas() {
            try {
                const off = new Date().getTimezoneOffset();
                const hoyIso = new Date(Date.now() - off * 60000).toISOString().split('T')[0];

                const resR = await MetraAPI.get(`/gerente/reservaciones?modo=todo&desde=${hoyIso}`);
                const reservas = resR.data || [];
                const reservasHoy = reservas.filter(r => r.fecha === hoyIso);

                    const now = new Date();
                    const pendientes = reservas.filter(r => {
                        const rsrvTime = new Date(`${r.fecha}T${r.hora_inicio}`);
                        // Consideramos pendientes a las que estan en estado=pendiente (que van a llegar)
                        return r.estado === 'pendiente' && rsrvTime >= now;
                    }).sort((a,b) => new Date(`${a.fecha}T${a.hora_inicio}`) - new Date(`${b.fecha}T${b.hora_inicio}`));

                    if (pendientes.length > 0) {
                        const pr = pendientes[0];
                        
                        // Determinar el día relativo o fecha
                        const prFechaStr = pr.fecha;
                        let diaTexto = '';
                        
                        if (prFechaStr === hoyIso) {
                            diaTexto = 'Hoy';
                        } else {
                            const mañanaReq = new Date(Date.now() - (off * 60000) + 86400000);
                            const mañanaIso = mañanaReq.toISOString().split('T')[0];
                            
                            if (prFechaStr === mañanaIso) {
                                diaTexto = 'Mañana';
                            } else {
                                const d = new Date(`${prFechaStr}T00:00:00`);
                                diaTexto = d.toLocaleDateString('es-ES', { weekday: 'short', day: 'numeric', month: 'short' });
                                diaTexto = diaTexto.charAt(0).toUpperCase() + diaTexto.slice(1);
                            }
                        }

                        // Actualizar solo si los elementos existen (opcional en el nuevo diseño)
                        const elHora = document.getElementById('dash_proxima_hora');
                        const elNombre = document.getElementById('dash_proxima_nombre');
                        if (elHora) elHora.innerHTML = `${pr.hora_inicio.substring(0,5)}<span class="fs-5 fw-normal" style="color: rgba(255,255,255,0.6);">Hrs</span>`;
                        if (elNombre) elNombre.innerHTML = `
                            <span class="d-block mb-1" style="color: var(--white-pure); opacity: 0.8; font-size: 0.8rem; font-weight: 500;">
                                <i class="bi bi-calendar-event me-1 text-warning"></i>${diaTexto}
                            </span>
                            ${escapeHTML(pr.nombre_cliente)} | ${pr.numero_personas} Pers.
                        `;
                    } else {
                        const elHora = document.getElementById('dash_proxima_hora');
                        const elNombre = document.getElementById('dash_proxima_nombre');
                        if (elHora) elHora.innerHTML = `--:--`;
                        if (elNombre) elNombre.textContent = `Sin próximas llegadas`;
                    }

                    const llegadasPanel = document.getElementById('dash_panel_llegadas');
                    if (!llegadasPanel) return;

                    const proximasMostrar = reservasHoy
                        .filter(r => ['pendiente', 'en_curso'].includes(r.estado))
                        .sort((a,b) => new Date(`${a.fecha}T${a.hora_inicio}`) - new Date(`${b.fecha}T${b.hora_inicio}`))
                        .slice(0, 4);
                    
                    if (proximasMostrar.length > 0) {
                        llegadasPanel.innerHTML = proximasMostrar.map(r => {
                            const badge = r.estado === 'en_curso' 
                                ? `<span class="badge" style="background: rgba(46,125,50,0.2); color: #2e7d32; border: 1px solid rgba(46,125,50,0.4);">En Curso</span>`
                                : `<span class="badge" style="background: rgba(212,175,55,0.2); color: #B38600; border: 1px solid rgba(212,175,55,0.4);">Pendiente</span>`;
                            
                            return `
                            <div class="d-flex justify-content-between align-items-center p-3 rounded-3 mb-2" style="border: 1px solid var(--border-light); background: var(--off-white); transition: all 0.2s;">
                                <div>
                                    <span class="fw-bold d-block" style="color: var(--black-primary);">${escapeHTML(r.nombre_cliente)}</span>
                                    <small style="color: var(--text-muted); font-size: 0.8rem;"><i class="bi bi-clock me-1"></i>${r.hora_inicio.substring(0,5)} &nbsp;•&nbsp; ${r.numero_personas} personas</small>
                                </div>
                                ${badge}
                            </div>
                        `}).join('');
                    } else {
                        llegadasPanel.innerHTML = '<p class="text-muted text-center mt-3 fw-bold">No hay llegadas pendientes hoy.</p>';
                    }
            } catch(e) { console.error('Error al cargar llegadas:', e); }
        }

        function renderChart(completadas, pendientes, canceladas) {
            const ctx = document.getElementById('chartReservas').getContext('2d');
            
            const sinActividad = (completadas === 0 && pendientes === 0 && canceladas === 0);
            
            const labelsGrafica = sinActividad 
                ? ['Esperando reservas'] 
                : ['Completadas', 'Esperadas (Pendientes)', 'Bajas'];
                
            const dataGrafica = sinActividad 
                ? [1] 
                : [completadas, pendientes, canceladas];
                
            const coloresGrafica = sinActividad 
                ? ['#f0f0f0'] 
                : ['#2E7D32', '#D4AF37', '#c62828'];

            if (chartRef) {
                chartRef.data.labels = labelsGrafica;
                chartRef.data.datasets[0].data = dataGrafica;
                chartRef.data.datasets[0].backgroundColor = coloresGrafica;
                chartRef.update();
                return;
            }

            chartRef = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labelsGrafica,
                    datasets: [{
                        data: dataGrafica,
                        backgroundColor: coloresGrafica,
                        borderWidth: 0,
                        hoverOffset: sinActividad ? 0 : 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { family: 'Inter', size: 13, weight: 'bold' } } },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    if(sinActividad) return 'Aún no hay actividad hoy';
                                    let label = context.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed !== null) { label += context.parsed + ' Personas'; }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

        async function cargarAnaliticaAvanzada() {
            try {
                // 1. Cargar Estadísticas Generales (Tarjetas)
                const resStats = await MetraAPI.get('/gerente/analytics/stats');
                if (resStats.success && resStats.data) {
                    const d = resStats.data;
                    
                    // Actualizar Tarjetas
                    document.getElementById('dash_visitas_totales').innerText = d.visitas_totales || 0;
                    document.getElementById('dash_desglose_fuentes').innerText = `${d.desglose.reservaciones} Res. | ${d.desglose.walkins} Walk-ins`;
                    
                    document.getElementById('dash_ocupacion_real').innerText = `${d.ocupacion_real_porcentaje}%`;
                    document.getElementById('dash_insight_ocupacion').innerText = d.insights.ocupacion;

                    document.getElementById('dash_tiempo_estancia').innerText = `${d.tiempo_promedio_estancia_min}m`;
                    document.getElementById('dash_insight_fuente').innerText = d.insights.fuente_principal;
                    
                    document.getElementById('dash_noshow_rate').innerText = `${d.no_show_rate}%`;
                    
                    const fidelidadRate = d.fidelidad.clientes_unicos > 0 
                        ? Math.round((d.fidelidad.clientes_recurrentes / d.fidelidad.clientes_unicos) * 100) 
                        : 0;
                    document.getElementById('dash_fidelidad_rate').innerText = `${fidelidadRate}%`;
                    document.getElementById('dash_insight_fidelidad').innerText = `${d.fidelidad.clientes_recurrentes} Recurrentes | ${d.fidelidad.clientes_unicos - d.fidelidad.clientes_recurrentes} Nuevos`;
                }

                // 2. Gráfico: Horas Pico
                const resHours = await MetraAPI.get('/gerente/analytics/demand-hourly');
                if (resHours.success) renderChartHoras(resHours.data);

                // 3. Gráfico: Tendencia Semanal
                const resTrends = await MetraAPI.get('/gerente/analytics/trends-weekly');
                if (resTrends.success) renderChartTendencia(resTrends.data);

            } catch (e) { console.error('Error Analítica:', e); }
        }

        function renderChartHoras(data) {
            const ctx = document.getElementById('chartHorasPico').getContext('2d');
            const labels = data.map(d => `${d.hora}:00`);
            const values = data.map(d => d.total_servicios); // Cambio a total_servicios

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Afluencia (Total)',
                        data: values,
                        backgroundColor: 'rgba(212, 175, 55, 0.6)',
                        borderColor: 'rgba(212, 175, 55, 1)',
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, grid: { display: false } } }
                }
            });
        }

        function renderChartTendencia(data) {
            const ctx = document.getElementById('chartTendenciaSemanal').getContext('2d');
            const labels = data.map(d => {
                const date = new Date(d.fecha + 'T00:00:00');
                return date.toLocaleDateString('es-ES', { weekday: 'short', day: 'numeric' });
            });
            const values = data.map(d => d.total);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Visitas Totales',
                        data: values,
                        fill: true,
                        backgroundColor: 'rgba(56, 44, 38, 0.05)',
                        borderColor: '#382C26',
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#D4AF37'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, grid: { color: '#f0f0f0' } } }
                }
            });
        }

        async function cargarMetricasMensuales() {
            try {
                const json = await MetraAPI.get('/gerente/metricas/mensuales');
                const tbody = document.getElementById('tabla_historico');
                if(json.data && json.data.length > 0) {
                        const meses = ['-', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                        
                        tbody.innerHTML = json.data.map((m, i) => {
                            let tendenciaStr = '<span class="text-muted">-</span>';
                            if (i < json.data.length - 1) { // hay mes anterior para comparar
                                const mesAnterior = json.data[i+1];
                                if (m.total_reservaciones > mesAnterior.total_reservaciones) {
                                    tendenciaStr = '<span class="text-success fw-bold"><i class="bi bi-arrow-up-right me-1"></i>En Alta</span>';
                                } else if (m.total_reservaciones < mesAnterior.total_reservaciones) {
                                  tendenciaStr = '<span class="text-danger fw-bold"><i class="bi bi-arrow-down-right me-1"></i>A la baja</span>';
                                } else {
                                  tendenciaStr = '<span class="text-secondary fw-bold"><i class="bi bi-arrow-right me-1"></i>Estable</span>';
                                }
                            }

                            return `
                                <tr>
                                    <td class="fw-bold">${meses[m.mes]} ${m.anio}</td>
                                    <td class="text-center">${m.total_reservaciones}</td>
                                    <td class="text-center">${m.cancelaciones}</td>
                                    <td class="text-center">
                                        <div class="progress" style="height: 6px; width: 60px; margin: 0 auto;">
                                            <div class="progress-bar ${m.porcentaje_efectividad > 70 ? 'bg-success' : 'bg-warning'}" style="width: ${m.porcentaje_efectividad}%"></div>
                                        </div>
                                        <small class="text-muted d-block mt-1">${m.porcentaje_efectividad}%</small>
                                    </td>
                                    <td class="text-end">${tendenciaStr}</td>
                                </tr>
                            `;
                        }).join('');
                    } else {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted mb-2"><i class="bi bi-folder2-open fs-1 text-black-50 opacity-50"></i></div>
                                    <h6 class="fw-bold text-dark mt-3">Aún no hay historial disponible</h6>
                                    <p class="text-muted small">Comienza a recibir reservas para analizar tendencias de crecimiento mes a mes.</p>
                                </td>
                            </tr>
                        `;
                    }
            } catch(e) { console.error('Error fetching Histórico', e); }
        }

        // Init
        document.addEventListener('DOMContentLoaded', () => {
            if(localStorage.getItem('token')) {
                cargarDashboard();
                cargarLlegadas();
                cargarAnaliticaAvanzada();
                cargarMetricasMensuales();
                setInterval(() => {
                    cargarLlegadas();
                    cargarAnaliticaAvanzada();
                }, 60000); // 1 minuto
            }
        });
    </script>
@endsection