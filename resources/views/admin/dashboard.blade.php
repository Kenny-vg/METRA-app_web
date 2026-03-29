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


    <div class="row g-4 mb-5">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 p-4 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small fw-bold text-uppercase" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.7rem;">Reservas de Hoy</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--off-white); color: var(--black-primary);">
                        <i class="bi bi-people-fill fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" id="dash_reservas_hoy" style="color: var(--black-primary); font-size: 2.2rem; letter-spacing: -1px;">...</h3>
                <div class="d-flex align-items-center mt-2">
                    <span class="small" style="color: var(--text-muted); font-size: 0.75rem;">Reservaciones activas de hoy</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 p-4 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small fw-bold text-uppercase" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.7rem;">Completadas</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--off-white); color: #2E7D32;">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" id="dash_completadas" style="color: var(--black-primary); font-size: 2.2rem; letter-spacing: -1px;">...</h3>
                <div id="badge_ocupacion_container" class="d-flex align-items-center mt-2">
                    <span class="small" style="color: var(--text-muted); font-size: 0.75rem;">Calculando insight...</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 p-4 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small fw-bold text-uppercase" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.7rem;">Bajas / No Show</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--off-white); color: #c62828;">
                        <i class="bi bi-x-circle-fill fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" id="dash_bajas" style="color: var(--black-primary); font-size: 2.2rem; letter-spacing: -1px;">...</h3>
                <div id="badge_cancelacion_container" class="d-flex align-items-center mt-2">
                    <span class="small" style="color: var(--text-muted); font-size: 0.75rem;">Calculando riesgo...</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 p-4 h-100 position-relative overflow-hidden" style="background: var(--black-primary); border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                <!-- Decoración -->
                <div style="position: absolute; right: -20px; top: -20px; width: 100px; height: 100px; background: var(--accent-gold); border-radius: 50%; opacity: 0.1; filter: blur(20px);"></div>
                
                <div class="d-flex justify-content-between align-items-center mb-3 position-relative z-1">
                    <span class="small fw-bold text-uppercase" style="color: rgba(255,255,255,0.6); letter-spacing: 1px; font-size: 0.7rem;">Próxima Llegada</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); color: var(--accent-gold);">
                        <i class="bi bi-clock-history fs-5"></i>
                    </div>
                </div>
                <h3 id="dash_proxima_hora" class="fw-bold mb-1 position-relative z-1" style="color: var(--white-pure); font-size: 2.2rem; letter-spacing: -1px;">--:--</h3>
                <div class="d-flex align-items-center mt-2 position-relative z-1">
                    <span id="dash_proxima_nombre" class="small" style="color: var(--accent-gold); font-size: 0.75rem; font-weight: 600;">-</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Gráficos y Tablas -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-xl-7">
            <div class="card border-0 p-4 p-lg-5 h-100 premium-card">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center border-bottom pb-4 mb-4 gap-3" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Tendencia Operativa al Cierre</h5>
                </div>
                <div class="text-center py-3" style="position: relative; height:300px; width:100%; display:flex; justify-content:center; align-items:center;">
                    <canvas id="chartReservas" style="max-height: 100%;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5">
             <div class="card border-0 p-4 p-lg-5 h-100 premium-card">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center border-bottom pb-4 mb-4 gap-3" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Panel de Llegadas</h5>
                    <a href="/admin/reservaciones" class="small fw-bold text-decoration-none" style="color: var(--text-muted);">Ver todo →</a>
                </div>

                <div id="dash_panel_llegadas" class="d-flex flex-column gap-3 overflow-auto pe-2" style="max-height: 400px;">
                    <p class="text-muted text-center mt-3">Cargando llegadas...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tendencia Mensual (MV) -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="card border-0 p-4 p-lg-5 premium-card shadow-sm">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;"><i class="bi bi-clock-history me-2 text-warning"></i>Tendencia Operativa Mensual</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead style="background: var(--off-white);">
                            <tr>
                                <th class="text-secondary small fw-bold text-uppercase border-0 py-3 rounded-start">Periodo</th>
                                <th class="text-secondary small fw-bold text-uppercase border-0 py-3 text-center">Reservas Totales</th>
                                <th class="text-secondary small fw-bold text-uppercase border-0 py-3 text-center">Cancelaciones</th>
                                <th class="text-secondary small fw-bold text-uppercase border-0 py-3 text-center">Efectividad</th>
                                <th class="text-secondary small fw-bold text-uppercase border-0 py-3 rounded-end text-end">Tendencia</th>
                            </tr>
                        </thead>
                        <tbody id="tabla_historico">
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Cargando registro histórico del servidor...</td>
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
        const token = localStorage.getItem('token');
        const API = '/api';
        let chartRef = null;

        if (!token) {
            window.location.href = '/login';
        }

        function authHeaders() {
            return {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            };
        }

        async function cargarDashboard() {
            try {
                const res = await fetch('/api/gerente/mi-cafeteria', { headers: authHeaders() });

                if (!res.ok) return;
                const json = await res.json();
                const cafe = json.data;
                cafeteriaId = cafe.id;

                // Rellenar el campo email del modal de renovar sin depender de Blade/sesión PHP
                const emailField = document.getElementById('r-email');
                if (emailField && cafe.gerente?.email) emailField.value = cafe.gerente.email;

                renderWidgetSuscripcion(cafe);
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
                    const res = await fetch('/api/planes-publicos', { headers: authHeaders() });
                    const json = await res.json();
                    if (res.ok) {
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
                // Usar el endpoint dedicado de renovación (requiere auth)
                const res = await fetch('/api/gerente/renovar-suscripcion', {
                    method: 'POST',
                    headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' },
                    body: formData
                });

                const json = await res.json();

                if (!res.ok) {
                    throw new Error(json.message || 'Error al enviar la solicitud.');
                }

                bootstrap.Modal.getInstance(document.getElementById('modalRenovar')).hide();

                Swal.fire({
                    title: '¡Solicitud Enviada!',
                    text: json.message || 'Tu comprobante está en revisión por el administrador.',
                    icon: 'success',
                    confirmButtonColor: '#212529'
                }).then(() => cargarDashboard());

            } catch(err) {
                Swal.fire({ title: 'Error', text: err.message, icon: 'error', confirmButtonColor: '#382C26' });
            } finally {
                submitBtn.innerHTML = document.getElementById('btn-submit-renovar').dataset.label || 'Enviar Renovación';
                submitBtn.disabled = false;
            }
        });


        async function cargarLlegadas() {
            try {
                const off = new Date().getTimezoneOffset();
                const hoyIso = new Date(Date.now() - off * 60000).toISOString().split('T')[0];

                const resR = await fetch(`/api/gerente/reservaciones?modo=todo&desde=${hoyIso}`, { headers: authHeaders() });
                if(resR.ok) {
                    const reservas = (await resR.json()).data || [];
                    const reservasHoy = reservas.filter(r => r.fecha === hoyIso);

                    const now = new Date();
                    const pendientes = reservas.filter(r => {
                        const rsrvTime = new Date(`${r.fecha}T${r.hora_inicio}`);
                        // Consideramos pendientes a las que estan en estado=pendiente (que van a llegar)
                        return r.estado === 'pendiente' && rsrvTime >= now;
                    }).sort((a,b) => new Date(`${a.fecha}T${a.hora_inicio}`) - new Date(`${b.fecha}T${b.hora_inicio}`));

                    if (pendientes.length > 0) {
                        const pr = pendientes[0];
                        document.getElementById('dash_proxima_hora').innerHTML = `${pr.hora_inicio.substring(0,5)}<span class="fs-5 fw-normal" style="color: rgba(255,255,255,0.6);">Hrs</span>`;
                        document.getElementById('dash_proxima_nombre').textContent = `${pr.nombre_cliente} | ${pr.numero_personas} Personas`;
                    } else {
                        document.getElementById('dash_proxima_hora').innerHTML = `--:--`;
                        document.getElementById('dash_proxima_nombre').textContent = `Sin próximas llegadas`;
                    }

                    const llegadasPanel = document.getElementById('dash_panel_llegadas');
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

        async function cargarVistasAnaliticas() {
            try {
                const url = `/api/gerente/metricas/diarias?t=${Date.now()}`;
                const res = await fetch(url, { headers: authHeaders() });
                if(res.ok) {
                    const json = await res.json();
                    if(json.success && json.data) {
                        const completadas = parseInt(json.data.reservas_completadas) || 0;
                        const canceladas = (parseInt(json.data.reservas_canceladas) || 0) + (parseInt(json.data.no_shows) || 0);
                        const totales = parseInt(json.data.total_reservas) || 0;
                        const pendientes = totales - (completadas + canceladas);

                        // BINDING UX SIN LOGICA MATEMÁTICA EN JS (Puro API)
                        const totalHtml = totales > 0 ? totales : '<span class="fs-5 text-muted fw-normal" style="letter-spacing:0;">Aún sin llegadas</span>';
                        const completadasHtml = completadas > 0 ? completadas : '<span class="fs-5 text-muted fw-normal" style="letter-spacing:0;">Sin actividad</span>';
                        const bajasHtml = canceladas > 0 ? canceladas : '<span class="fs-5 text-muted fw-normal" style="letter-spacing:0;">0 bajas registradas</span>';

                        // Si hay 0 reservas, desactivamos los insights para no mostrar Badges engañosos
                        if (totales === 0) {
                            document.getElementById('badge_ocupacion_container').innerHTML = `<span class="small text-muted"><i class="bi bi-clock me-1"></i>Esperando primeras reservas</span>`;
                            document.getElementById('badge_cancelacion_container').innerHTML = `<span class="small text-muted"><i class="bi bi-clock me-1"></i>Aún sin tendencias</span>`;
                        } else {
                            // Badge UX original restaurado (Píldora verde para ocupación, y roja-suave para bajas si hay riesgo)
                            document.getElementById('badge_ocupacion_container').innerHTML = `
                                <span class="badge rounded-pill" style="background: rgba(46, 125, 50, 0.1); color: #2E7D32; border: 1px solid rgba(46, 125, 50, 0.2); font-weight: 700;">${json.data.porcentaje_ocupacion}%</span>
                                <span class="small ms-2" style="color: var(--text-muted); font-size: 0.75rem;">${json.data.insight_ocupacion}</span>
                            `;
                            
                            const colorCancel = json.data.porcentaje_cancelacion > 20 ? 'c62828' : '6c757d';
                            const bgCancel = json.data.porcentaje_cancelacion > 20 ? 'rgba(198,40,40,0.1)' : 'rgba(108,117,125,0.1)';
                            
                            document.getElementById('badge_cancelacion_container').innerHTML = `
                                <span class="badge rounded-pill" style="background: ${bgCancel}; color: #${colorCancel}; border: 1px solid rgba(0,0,0,0.05); font-weight: 700;">${json.data.porcentaje_cancelacion}%</span>
                                <span class="small ms-2" style="color: var(--text-muted); font-size: 0.75rem;">${json.data.insight_cancelacion}</span>
                            `;
                        }

                        renderChart(completadas, pendientes > 0 ? pendientes : 0, canceladas);
                    }
                }
            } catch(e) { console.error('Error fetching Vistas DB', e); }
        }

        async function cargarMetricasMensuales() {
            try {
                const res = await fetch('/api/gerente/metricas/mensuales', { headers: authHeaders() });
                if(res.ok) {
                    const json = await res.json();
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
                }
            } catch(e) { console.error('Error fetching Histórico', e); }
        }

        // Init
        if(token) {
            cargarDashboard();
            cargarLlegadas();
            cargarVistasAnaliticas();
            cargarMetricasMensuales();
            setInterval(() => {
                cargarLlegadas();
                cargarVistasAnaliticas();
            }, 60000); // 1 minuto
        }
    </script>
@endsection