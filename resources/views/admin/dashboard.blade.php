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
                <h3 class="fw-bold mb-1" style="color: var(--black-primary); font-size: 2.2rem; letter-spacing: -1px;">24</h3>
                <div class="d-flex align-items-center mt-2">
                    <span class="badge rounded-pill" style="background: rgba(46, 125, 50, 0.1); color: #2E7D32; border: 1px solid rgba(46, 125, 50, 0.2); font-weight: 700;">+15%</span>
                    <span class="small ms-2" style="color: var(--text-muted); font-size: 0.75rem;">vs ayer</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 p-4 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small fw-bold text-uppercase" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.7rem;">Horas Pico</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--off-white); color: var(--black-primary);">
                        <i class="bi bi-bar-chart-fill fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" style="color: var(--black-primary); font-size: 2.2rem; letter-spacing: -1px;">06:00<span class="fs-5 text-muted fw-normal">PM</span></h3>
                <div class="d-flex align-items-center mt-2">
                    <span class="small" style="color: var(--text-muted); font-size: 0.75rem;">Tendencia estable</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 p-4 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small fw-bold text-uppercase" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.7rem;">Ocupación</span>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--off-white); color: var(--black-primary);">
                        <i class="bi bi-grid-fill fs-5"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" style="color: var(--black-primary); font-size: 2.2rem; letter-spacing: -1px;">18<span class="fs-5 text-muted fw-normal">/25</span></h3>
                <div class="progress mt-3" style="height: 6px; background: var(--off-white);">
                    <div class="progress-bar" role="progressbar" style="width: 72%; background: var(--black-primary);" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
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
                <h3 class="fw-bold mb-1 position-relative z-1" style="color: var(--white-pure); font-size: 2.2rem; letter-spacing: -1px;">08:00<span class="fs-5 fw-normal" style="color: rgba(255,255,255,0.6);">PM</span></h3>
                <div class="d-flex align-items-center mt-2 position-relative z-1">
                    <span class="small" style="color: var(--accent-gold); font-size: 0.75rem; font-weight: 600;">Mesa VIP Preparada</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Gráficos y Tablas -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-xl-7">
            <div class="card border-0 p-4 p-lg-5 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Flujo Analítico (Demostración)</h5>
                    <button class="btn-admin-secondary"><i class="bi bi-download me-2"></i>Exportar</button>
                </div>
                <div class="text-center py-3">
                    <img src="https://support.content.office.net/es-es/media/9d77e47a-6f77-4977-90c2-511a2f605f6b.png" 
                         class="img-fluid rounded-3" alt="Gráfica de minería de datos" style="opacity: 0.85; mix-blend-mode: multiply; filter: grayscale(100%) contrast(1.2);">
                    <p class="mt-4 small" style="color: var(--text-muted);"><i class="bi bi-lightning-charge me-1"></i> Análisis proyectado de afluencia semanal.</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5">
             <div class="card border-0 p-4 p-lg-5 h-100 premium-card">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Panel de Llegadas</h5>
                    <a href="/admin/reservaciones" class="small fw-bold text-decoration-none" style="color: var(--text-muted);">Ver todo →</a>
                </div>

                <div class="d-flex flex-column gap-3 overflow-auto pe-2" style="max-height: 400px;">
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="border: 1px solid var(--border-light); background: var(--off-white); transition: all 0.2s; cursor: pointer;" onmouseover="this.style.background='var(--white-pure)'" onmouseout="this.style.background='var(--off-white)'">
                        <div>
                            <span class="fw-bold d-block" style="color: var(--black-primary);">Mariana Sánchez</span>
                            <small style="color: var(--text-muted); font-size: 0.8rem;"><i class="bi bi-clock me-1"></i>20:30 PM &nbsp;•&nbsp; 4 pax</small>
                        </div>
                        <span class="badge badge-status badge-status-active">Confirmada</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="border: 1px solid var(--border-light); background: transparent; transition: all 0.2s; cursor: pointer;" onmouseover="this.style.background='var(--off-white)'" onmouseout="this.style.background='transparent'">
                        <div>
                            <span class="fw-bold d-block" style="color: var(--black-primary);">Juan Pablo Montes</span>
                            <small style="color: var(--text-muted); font-size: 0.8rem;"><i class="bi bi-clock me-1"></i>21:00 PM &nbsp;•&nbsp; 2 pax</small>
                        </div>
                        <span class="badge badge-status badge-status-pending">Pendiente</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="border: 1px solid var(--border-light); background: var(--off-white); transition: all 0.2s; cursor: pointer;" onmouseover="this.style.background='var(--white-pure)'" onmouseout="this.style.background='var(--off-white)'">
                        <div>
                            <span class="fw-bold d-block" style="color: var(--black-primary);">Roberto Gómez</span>
                            <small style="color: var(--text-muted); font-size: 0.8rem;"><i class="bi bi-clock me-1"></i>21:15 PM &nbsp;•&nbsp; 6 pax</small>
                        </div>
                        <span class="badge badge-status badge-status-active">Confirmada</span>
                    </div>

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
                    <form id="formRenovar">
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
                        <!-- Alert removed manually to use SweetAlert instead -->
                        <button type="submit" id="btn-submit-renovar" class="btn-admin-primary w-100 py-2">Enviar Renovación</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API = '/api';
        let authToken = localStorage.getItem('token');
        let cafeteriaId = null;

        function authHeaders() {
            return {
                'Authorization': `Bearer ${authToken}`,
                'Accept': 'application/json'
            };
        }

        async function cargarDashboard() {
            try {
                const res = await fetch(`${API}/gerente/cafeteria/perfil`, { headers: authHeaders() });
                if (!res.ok) return;
                const json = await res.json();
                const cafe = json.data;
                cafeteriaId = cafe.id;

                renderWidgetSuscripcion(cafe);
            } catch (e) {
                console.error('Error cargando perfil:', e);
            }
        }

        function renderWidgetSuscripcion(cafe) {
            const container = document.getElementById('suscripcion-widget-container');
            const alertContainer = document.getElementById('alerta-vencimiento-container');
            
            if (!cafe || !cafe.suscripcion_actual) {
                container.innerHTML = `
                    <div class="card border-0 p-4 premium-card text-center">
                        <p class="text-muted m-0">No tienes una suscripción activa.</p>
                        <button class="btn-admin-primary mt-3 px-4" onclick="abrirModalRenovar()"><i class="bi bi-arrow-repeat me-2"></i>Renovar Suscripción</button>
                    </div>`;
                return;
            }

            const sub = cafe.suscripcion_actual;
            const plan = sub.plan;
            const fechaFin = new Date(sub.fecha_fin);
            const hoy = new Date();
            const diasRestantes = Math.ceil((fechaFin - hoy) / (1000 * 60 * 60 * 24));

            let htmlAlertas = '';
            
            // Alerta de plan desactivado
            if (plan && (plan.estado === false || plan.estado === 0)) {
                htmlAlertas += `
                    <div class="alert alert-warning border-0 rounded-3 mb-3 d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                        <div><strong>Atención:</strong> Este plan ya no está disponible. Tu próxima renovación deberá usar otro plan.</div>
                    </div>`;
            }

            // Alerta de vencimiento
            if (diasRestantes <= 7 && diasRestantes >= 0) {
                alertContainer.innerHTML = `
                    <div class="alert alert-danger border-0 rounded-3 mb-4 d-flex align-items-center fw-bold shadow-sm" style="background-color: #ffebee; color: #c62828;">
                        <i class="bi bi-clock-history me-3 fs-3"></i>
                        Tu suscripción vence en ${diasRestantes} días. Por favor, renueva para evitar la suspensión del servicio.
                    </div>`;
            }

            container.innerHTML = `
                ${htmlAlertas}
                <div class="card border-0 p-4 premium-card shadow-sm" style="background: var(--black-primary); color: white;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <span class="small fw-bold text-uppercase" style="color: var(--accent-gold); letter-spacing: 1px; font-size: 0.75rem;">Suscripción Actual</span>
                            <h3 class="fw-bold mb-1 mt-1 text-white">${plan ? plan.nombre_plan : 'Plan Desconocido'}</h3>
                            <div class="small" style="color: rgba(255,255,255,0.7);">
                                <div>Válida hasta: <strong>${fechaFin.toLocaleDateString('es-ES')}</strong></div>
                                ${diasRestantes > 0 ? `<div>Tiempo restante: <strong>${diasRestantes} días</strong></div>` : `<div class="text-danger fw-bold">Suscripción Expirada</div>`}
                            </div>
                        </div>
                        <div class="text-end">
                            ${cafe.estado === 'en_revision' ? 
                                `<div class="mb-2"><span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="bi bi-hourglass-split me-1"></i>En revisión por administrador</span></div>` : ''
                            }
                            <button class="btn-admin-secondary px-4 py-2" onclick="abrirModalRenovar('${cafe.estado}')">
                                <i class="bi bi-arrow-repeat me-2"></i>${cafe.estado === 'en_revision' ? 'Actualizar Comprobante' : 'Renovar Suscripción'}
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        async function abrirModalRenovar(estado = '') {
            const modal = new bootstrap.Modal(document.getElementById('modalRenovar'));
            const isRevision = estado === 'en_revision';
            
            document.getElementById('titulo-modal-renovar').innerHTML = isRevision 
                ? '<i class="bi bi-receipt me-2"></i>Actualizar Comprobante' 
                : '<i class="bi bi-arrow-repeat me-2"></i>Renovar Suscripción';
                
            const selectPlan = document.getElementById('r-plan');
            const cajaPlan = document.getElementById('caja-r-plan');
            if (isRevision) {
                cajaPlan.classList.add('d-none');
                selectPlan.removeAttribute('required');
            } else {
                cajaPlan.classList.remove('d-none');
                selectPlan.setAttribute('required', 'true');
            }
            
            document.getElementById('btn-submit-renovar').innerHTML = isRevision ? 'Subir Nuevo Comprobante' : 'Enviar Renovación';

            modal.show();
            
            if (!isRevision) {
                try {
                    const res = await fetch(`${API}/planes-publicos`, { headers: authHeaders() });
                    const json = await res.json();
                    if (res.ok) {
                        selectPlan.innerHTML = '<option value="">Selecciona un plan...</option>' + 
                            json.data.map(p => `<option value="${p.id}">${p.nombre_plan} ($${p.precio})</option>`).join('');
                    }
                } catch (e) {
                    console.error('Error cargando planes modal', e);
                }
            }
        }

        document.getElementById('formRenovar').addEventListener('submit', async (e) => {
            e.preventDefault();
            if(!cafeteriaId) return;

            const planVal = document.getElementById('r-plan').value;
            const fileInput = document.getElementById('r-comprobante').files[0];
            const alertBox = document.getElementById('r-alert');

            // if requires plan text check dynamically
            const selectReq = document.getElementById('r-plan').hasAttribute('required');
            if ((selectReq && !planVal) || !fileInput) {
                Swal.fire({ title: 'Atención', text: 'Llena todos los campos', icon: 'warning', confirmButtonColor: '#382C26' });
                return;
            }
            if (fileInput.size > 5 * 1024 * 1024) {
                Swal.fire({ title: 'Atención', text: 'El comprobante no debe superar los 5MB.', icon: 'warning', confirmButtonColor: '#382C26' });
                return;
            }

            const submitBtn = e.target.querySelector('button');
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';
            submitBtn.disabled = true;

            const formData = new FormData();
            formData.append('comprobante', fileInput);
            formData.append('_method', 'POST'); // for Laravel API

            // Si idealmente hubiera un endpoint para renovaciones, lo usaríamos aquí.
            // Para satisfacer las reglas, usaremos subirComprobante, simulando la interfaz de revisión.
            try {
                const res = await fetch(`${API}/registro-negocio/${cafeteriaId}/comprobante`, {
                    method: 'POST',
                    headers: { 'Authorization': `Bearer ${authToken}` },
                    body: formData
                });
                
                const json = await res.json();
                
                if(!res.ok) {
                    throw new Error(json.message || 'Error al subir el comprobante.');
                }

                bootstrap.Modal.getInstance(document.getElementById('modalRenovar')).hide();
                
                // Simulación visual temporal de que la renovación está en proceso ("en_revision")
                // Ya que subirComprobante no cambia el estado general de un cafe activo a "en_revision",
                // se lo mostramos localmente o requerimos recarga si hicimos cambio via DB.
                Swal.fire({
                    title: '¡Recibo Enviado!',
                    text: 'Tu comprobante está en revisión por el administrador.',
                    icon: 'success',
                    confirmButtonColor: '#212529'
                }).then(() => {
                    cargarDashboard();
                });

            } catch(e) {
                Swal.fire({ title: 'Error', text: e.message, icon: 'error', confirmButtonColor: '#382C26' });
            } finally {
                submitBtn.innerHTML = document.getElementById('btn-submit-renovar').textContent === 'Subir Nuevo Comprobante' ? 'Subir Nuevo Comprobante' : 'Enviar Renovación';
                submitBtn.disabled = false;
            }

        });

        // Init
        if(authToken) {
            cargarDashboard();
        }
    </script>
@endsection