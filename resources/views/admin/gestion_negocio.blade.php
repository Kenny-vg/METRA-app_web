@extends('admin.menu')
@section('title', 'Gestión del Negocio')

@section('content')
    <header class="mb-5 border-bottom pb-4" style="border-color: var(--border-light) !important;">
        <h2 class="fw-bold" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Gestión del Negocio</h2>
        <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Administración de estructura y configuración operativa.</p>
    </header>

    <ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
    <li class="nav-item">
        <button class="nav-link active rounded-pill px-4" id="zonas-tab" data-bs-toggle="pill" data-bs-target="#zonas" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
            <i class="bi bi-geo-alt me-2"></i>Zonas
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link rounded-pill px-4" id="mesas-tab" data-bs-toggle="pill" data-bs-target="#mesas" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
            <i class="bi bi-layout-three-columns me-2"></i>Mesas
        </button>
    </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-4" id="meseros-tab" data-bs-toggle="pill" data-bs-target="#meseros" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
                <i class="bi bi-people me-2"></i>Personal
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-4" id="reviews-tab" data-bs-toggle="pill" data-bs-target="#reviews" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
                <i class="bi bi-star me-2"></i>Reseñas
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-4" id="horarios-tab" data-bs-toggle="pill" data-bs-target="#horarios" style="border: 1px solid var(--border-light); font-weight: 600; font-size: 0.9rem;">
                <i class="bi bi-clock me-2"></i>Horarios
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- ZONAS -->
        <div class="tab-pane fade show active" id="zonas">
            <div class="card border-0 p-4 p-md-5 premium-card">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Distribución de Áreas</h5>
                    <button class="btn-admin-primary" onclick="openModalZona()">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Zona
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table-metra mt-2">
                        <thead>
                            <tr>
                                <th>Nombre de la Zona</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-zonas-body">
                            <!-- Zonas cargadas por JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MESAS -->
        <div class="tab-pane fade" id="mesas">
             <div class="card border-0 p-4 p-md-5 premium-card">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Inventario de Mesas</h5>
                    <button class="btn-admin-primary" onclick="openModalMesa()">
                        <i class="bi bi-plus-lg me-2"></i>Nueva Mesa
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table-metra mt-2">
                        <thead>
                            <tr>
                                <th># Mesa</th>
                                <th>Zona</th>
                                <th>Capacidad</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-mesas-body">
                            <!-- Mesas cargadas por JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- PERSONAL -->
        <div class="tab-pane fade" id="meseros">
             <div class="card border-0 p-4 p-md-5 premium-card">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Panel de Personal</h5>
                    <button class="btn-admin-primary" onclick="openModalStaff()">
                        <i class="bi bi-plus-lg me-2"></i>Nuevo Personal
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table-metra mt-2">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-staff-body">
                            <!-- Staff cargado por JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- REVIEWS -->
        <div class="tab-pane fade" id="reviews">
             <!-- ... contenido igual ... -->
        </div>

        <!-- HORARIOS -->
        <div class="tab-pane fade" id="horarios">
            <div class="card border-0 p-4 p-md-5 premium-card">
                <div class="mb-4 pb-3 border-bottom" style="border-color: var(--border-light) !important;">
                    <h5 class="fw-bold m-0 mb-1" style="color: var(--black-primary); letter-spacing: -0.5px;">Horarios de Atención</h5>
                    <p class="m-0" style="color: var(--text-muted); font-size: 0.9rem;">Configura los días y horas de operación de tu negocio.</p>
                </div>
                <div class="row g-3" id="horarios-container">
                    <!-- Horarios cargados por JS -->
                </div>
                <div class="mt-5 pt-4 border-top d-flex flex-wrap flex-md-nowrap gap-3 justify-content-between" style="border-color: var(--border-light) !important;">
                    <button class="btn-admin-secondary px-4 py-2 w-100 w-md-auto" onclick="openModalHorario()">
                        <i class="bi bi-plus-lg me-2"></i>Añadir Horario
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Plantillas para Renderizado Estructural -->
    <template id="zona-template">
        <tr class="js-row">
            <td class="fw-bold" style="color: var(--black-primary);">
                <span class="js-nombre"></span>
                <span class="badge bg-secondary ms-2 js-badge" style="display:none;">Inactivo</span>
            </td>
            <td class="text-end js-actions"></td>
        </tr>
    </template>

    <template id="mesa-template">
        <tr class="js-row">
            <td class="fw-bold" style="color: var(--black-primary);">
                <div class="d-inline-flex align-items-center justify-content-center text-white rounded-circle me-2 shadow-sm js-numero" style="background: var(--black-primary); width: 25px; height: 25px; font-size: 0.75rem;"></div>
                <span class="badge bg-secondary ms-2 js-badge" style="display:none;">Inactiva</span>
            </td>
            <td><span class="badge js-zona" style="background: var(--off-white); border: 1px solid var(--border-light); color: var(--text-main);"></span></td>
            <td class="text-muted"><span class="js-capacidad"></span> Personas</td>
            <td class="text-end js-actions"></td>
        </tr>
    </template>

    <template id="horario-template">
        <div class="col-md-6 col-lg-4">
            <div class="p-3 rounded-4 d-flex justify-content-between align-items-center h-100 js-card" style="background: var(--off-white); border: 1px solid var(--border-light);">
                <div>
                    <span class="fw-bold d-block mb-1" style="color: var(--black-primary); font-size: 1.05rem;">
                        <span class="js-dia"></span>
                        <span class="badge bg-secondary ms-2 js-badge" style="font-size:0.7rem; display:none;">Inactivo</span>
                    </span>
                    <span class="small d-block text-muted"><i class="bi bi-clock me-1"></i> <span class="js-horas"></span></span>
                </div>
                <div class="d-flex gap-2 js-actions"></div>
            </div>
        </div>
    </template>

    <template id="staff-template">
        <tr class="js-row">
            <td class="fw-bold" style="color: var(--black-primary);">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center me-3 js-inicial" style="width: 35px; height: 35px; font-size: 14px;"></div>
                    <span class="js-nombre"></span>
                </div>
            </td>
            <td class="text-muted align-middle js-email"></td>
            <td class="align-middle js-badge-container">
                <span class="badge bg-success js-badge-activo" style="font-size:0.75rem; display:none;">Activo</span>
                <span class="badge bg-secondary js-badge-inactivo" style="font-size:0.75rem; display:none;">Inactivo</span>
            </td>
            <td class="text-end align-middle js-actions"></td>
        </tr>
    </template>

    <!-- Modals -->
    <div class="modal fade" id="modalZona" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold m-0" id="modalZonaTitle" style="color: var(--black-primary); letter-spacing: -0.5px;">Nueva Zona de Servicio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-3">
                    <form id="formZona">
                        <input type="hidden" id="zona-id">
                        <p class="small text-muted mb-4">La zonificación ayuda a distribuir mejor a sus clientes.</p>
                        <div class="mb-4">
                            <label class="form-label small fw-bold" style="color: var(--text-main); letter-spacing: 0.5px;">DENOMINACIÓN</label>
                            <input type="text" id="zona-nombre" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" placeholder="Ej. Balcón Este" required>
                        </div>
                        <button type="submit" class="btn-admin-primary w-100 py-3 mt-3">Guardar Zona</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMesa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold m-0" id="modalMesaTitle" style="color: var(--black-primary); letter-spacing: -0.5px;">Añadir Mesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-4">
                    <form id="formMesa">
                        <input type="hidden" id="mesa-id">
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">NÚMERO</label>
                                <input type="number" min="1" max="127" id="mesa-numero" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" placeholder="Ej. 1" onkeydown="return event.keyCode !== 69 && event.keyCode !== 189" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">ZONA</label>
                                <select id="mesa-zona-id" class="form-select border-0 shadow-sm rounded-3" style="background: var(--off-white);" required>
                                    <option value="">Cargando zonas...</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">CAPACIDAD</label>
                                <input type="number" min="1" max="127" id="mesa-capacidad" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" placeholder="Personas" onkeydown="return event.keyCode !== 69 && event.keyCode !== 189" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3);" required>
                            </div>
                        </div>
                        <button type="submit" class="btn-admin-primary w-100 py-3 mt-3">Guardar Mesa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalHorario" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold m-0" id="modalHorarioTitle" style="color: var(--black-primary); letter-spacing: -0.5px;">Configurar Horario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-4">
                    <form id="formHorario">
                        <input type="hidden" id="horario-id">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">DÍA DE LA SEMANA</label>
                            <select id="horario-dia" class="form-select border-0 shadow-sm rounded-3" style="background: var(--off-white);" required>
                                <option value="">Seleccione día...</option>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miercoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                                <option value="Sabado">Sábado</option>
                                <option value="Domingo">Domingo</option>
                            </select>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">APERTURA</label>
                                <input type="time" id="horario-apertura"
                                       class="form-control border-0 shadow-sm rounded-3"
                                       style="background: var(--off-white);" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">CIERRE</label>
                                <input type="time" id="horario-cierre"
                                       class="form-control border-0 shadow-sm rounded-3"
                                       style="background: var(--off-white);" required>
                            </div>
                        </div>
                        <button type="submit" class="btn-admin-primary w-100 py-3 mt-3">Guardar Horario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMesero" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold m-0" id="modalStaffTitle" style="color: var(--black-primary); letter-spacing: -0.5px;">Integrar Colaborador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-4">
                    <form id="formStaff">
                        <input type="hidden" id="staff-id">
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">NOMBRE COMPLETO</label>
                            <input type="text" id="staff-nombre" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" placeholder="Ej. Juan Pérez" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">CORREO ELECTRÓNICO</label>
                            <input type="email" id="staff-email" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" placeholder="juan@empresa.com" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">CONTRASEÑA</label>
                            <div class="position-relative">
                                <input type="password" id="staff-password" class="form-control border-0 shadow-sm rounded-3 pe-5" style="background: var(--off-white);" placeholder="Mínimo 8 caracteres">
                                <i class="bi bi-eye-slash toggle-staff-pw position-absolute top-50 end-0 translate-middle-y me-3 text-muted" style="cursor: pointer; z-index: 10;"></i>
                            </div>
                            <small class="text-muted" id="staff-password-help" style="display: none;">Dejar en blanco para mantener la contraseña actual.</small>
                        </div>

                        <div class="mb-4" id="staff-password-confirm-group">
                            <label class="form-label small fw-bold text-muted">CONFIRMAR CONTRASEÑA</label>
                            <div class="position-relative">
                                <input type="password" id="staff-password-confirm" class="form-control border-0 shadow-sm rounded-3 pe-5" style="background: var(--off-white);" placeholder="Repite la contraseña">
                                <i class="bi bi-eye-slash toggle-staff-pw position-absolute top-50 end-0 translate-middle-y me-3 text-muted" style="cursor: pointer; z-index: 10;"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn-admin-primary w-100 py-3 mt-3">Guardar Personal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer_admin')

    <script>
        // Mask for HH:MM inputs
       // function formatTime(input) {
          //  let val = input.value.replace(/\D/g, '');
           // if (val.length >= 3) {
           //     input.value = val.substring(0, 2) + ':' + val.substring(2, 4);
          //  } else {
          //      input.value = val;
          //  }
     //   }

        let modalZonaInst;
        let modalMesaInst;
        let modalHorarioInst;
        let modalStaffInst;

        document.addEventListener('DOMContentLoaded', () => {
            modalZonaInst = new bootstrap.Modal(document.getElementById('modalZona'));
            modalMesaInst = new bootstrap.Modal(document.getElementById('modalMesa'));
            modalHorarioInst = new bootstrap.Modal(document.getElementById('modalHorario'));
            modalStaffInst = new bootstrap.Modal(document.getElementById('modalMesero'));
            
            loadZonas();
            loadMesas();
            loadHorarios();
            loadStaff();
        });

        const API_URL = '/api/gerente';
        const getToken = () => localStorage.getItem('token');

        const headers = () => ({
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'Authorization': `Bearer ${getToken()}`
        });

        // Redirige al login si el token expiró o fue revocado
        const handleAuthError = (res) => {
            if (res.status === 401 || res.status === 403) {
                window.location.href = '/login';
                return true;
            }
            return false;
        };

        const showToast = (icon, title) => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 3000
            });
        };

        // --- ZONAS ---
        async function loadZonas() {
            try {
                const res = await fetch(`${API_URL}/zonas`, { headers: headers() });
                if (handleAuthError(res)) return;
                if (!res.ok) throw new Error('Error al cargar zonas');
                
                const response = await res.json();
                // Extract array depending on how API is structuring it (often response.data)
                const zonas = Array.isArray(response) ? response : (response.data || []);
                
                const tbody = document.getElementById('tabla-zonas-body');
                tbody.innerHTML = '';
                
                // Also update Mesas select
                const selectZona = document.getElementById('mesa-zona-id');
                selectZona.innerHTML = '<option value="">Seleccione zona...</option>';

                const template = document.getElementById('zona-template');
                const fragment = document.createDocumentFragment();

                zonas.forEach(z => {
                    const clone = template.content.cloneNode(true);
                    const row = clone.querySelector('.js-row');

                    if (!z.activo) {
                        row.classList.add('table-secondary', 'opacity-50');
                        clone.querySelector('.js-badge').style.display = 'inline-block';
                    }

                    clone.querySelector('.js-nombre').textContent = z.nombre_zona;

                    const actionsCol = clone.querySelector('.js-actions');
                    if (z.activo) {
                        const btnEdit = document.createElement('button');
                        btnEdit.className = 'btn btn-sm btn-outline-dark rounded-circle me-1';
                        btnEdit.title = 'Editar';
                        btnEdit.innerHTML = '<i class="bi bi-pencil"></i>';
                        btnEdit.addEventListener('click', () => editZona(z.id, z.nombre_zona));

                        const btnDelete = document.createElement('button');
                        btnDelete.className = 'btn btn-sm btn-outline-primary rounded-circle';
                        btnDelete.title = 'Desactivar';
                        btnDelete.innerHTML = '<i class="bi bi-x-circle"></i>';
                        btnDelete.addEventListener('click', () => deleteZona(z.id));

                        actionsCol.appendChild(btnEdit);
                        actionsCol.appendChild(btnDelete);
                    } else {
                        const btnReactivate = document.createElement('button');
                        btnReactivate.className = 'btn btn-sm btn-success rounded-pill px-3 shadow-sm';
                        btnReactivate.title = 'Reactivar';
                        btnReactivate.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar';
                        btnReactivate.addEventListener('click', () => reactivateZona(z.id));

                        actionsCol.appendChild(btnReactivate);
                    }

                    if(z.activo) {
                        const opt = document.createElement('option');
                        opt.value = z.id;
                        opt.textContent = z.nombre_zona;
                        selectZona.appendChild(opt);
                    }

                    fragment.appendChild(clone);
                });
                
                tbody.appendChild(fragment);
            } catch (error) {
                console.error(error);
                document.getElementById('tabla-zonas-body').innerHTML = '<tr><td colspan="2" class="text-danger text-center py-4">Error de conexión al cargar zonas.</td></tr>';
                showToast('error', 'No se pudieron cargar las zonas');
            }
        }

        function openModalZona() {
            document.getElementById('formZona').reset();
            document.getElementById('zona-id').value = '';
            document.getElementById('modalZonaTitle').innerText = 'Nueva Zona de Servicio';
            modalZonaInst.show();
        }

        function editZona(id, nombre) {
            document.getElementById('zona-id').value = id;
            document.getElementById('zona-nombre').value = nombre;
            document.getElementById('modalZonaTitle').innerText = 'Editar Zona';
            modalZonaInst.show();
        }

        let isSubmittingZona = false;
        document.getElementById('formZona').addEventListener('submit', async (e) => {
            e.preventDefault();
            if (isSubmittingZona) return;
            isSubmittingZona = true;

            const btn = e.target.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';

            const id = document.getElementById('zona-id').value;
            const nombre_zona = document.getElementById('zona-nombre').value;
            
            const method = id ? 'PUT' : 'POST';
            const url = id ? `${API_URL}/zonas/${id}` : `${API_URL}/zonas`;

            try {
                const res = await fetch(url, {
                    method,
                    headers: headers(),
                    body: JSON.stringify({ nombre_zona })
                });

                if (handleAuthError(res)) return;
                if (res.ok) {
                    showToast('success', id ? 'Zona actualizada' : 'Zona creada');
                    modalZonaInst.hide();
                    loadZonas();
                    loadMesas(); // Mesas could depend on it
                } else {
                    const errorData = await res.json();
                    Swal.fire('Error', errorData.message || 'Error al guardar zona', 'error');
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Error de conexión', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
                isSubmittingZona = false;
            }
        });

        async function deleteZona(id) {
            Swal.fire({
                title: '¿Desactivar Zona?',
                text: 'Esta zona dejará de estar disponible.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, desactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/zonas/${id}`, { method: 'DELETE', headers: headers() });
                        if (handleAuthError(res)) return;
                        if (res.ok) {
                            showToast('success', 'Zona desactivada');
                            loadZonas();
                            loadMesas();
                        } else {
                            const err = await res.json();
                            Swal.fire('Error', err.message || 'Error al desactivar zona', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }

        async function reactivateZona(id) {
            Swal.fire({
                title: '¿Reactivar Zona?',
                text: 'Esta zona volverá a estar disponible.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, reactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/zonas/${id}/activar`, { method: 'PATCH', headers: headers() });
                        if (handleAuthError(res)) return;
                        if (res.ok) {
                            showToast('success', 'Zona reactivada');
                            loadZonas();
                            loadMesas();
                        } else {
                            const err = await res.json();
                            Swal.fire('Error', err.message || 'Error al reactivar zona', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }

        // --- MESAS ---
        async function loadMesas() {
            try {
                const res = await fetch(`${API_URL}/mesas`, { headers: headers() });
                if (handleAuthError(res)) return;
                if (!res.ok) throw new Error('Error al cargar mesas');
                
                const response = await res.json();
                const mesas = Array.isArray(response) ? response : (response.data || []);
                
                const tbody = document.getElementById('tabla-mesas-body');
                tbody.innerHTML = '';

                const template = document.getElementById('mesa-template');
                const fragment = document.createDocumentFragment();

                mesas.forEach(m => {
                    const clone = template.content.cloneNode(true);
                    const row = clone.querySelector('.js-row');

                    if (!m.activo) {
                        row.classList.add('table-secondary', 'opacity-50');
                        clone.querySelector('.js-badge').style.display = 'inline-block';
                    }

                    clone.querySelector('.js-numero').textContent = m.numero_mesa;
                    clone.querySelector('.js-zona').textContent = m.zona ? m.zona.nombre_zona : 'N/A';
                    clone.querySelector('.js-capacidad').textContent = m.capacidad;

                    const actionsCol = clone.querySelector('.js-actions');
                    if (m.activo) {
                        const btnEdit = document.createElement('button');
                        btnEdit.className = 'btn btn-sm btn-outline-dark rounded-circle me-1';
                        btnEdit.title = 'Editar';
                        btnEdit.innerHTML = '<i class="bi bi-pencil"></i>';
                        btnEdit.addEventListener('click', () => editMesa(m));

                        const btnDelete = document.createElement('button');
                        btnDelete.className = 'btn btn-sm btn-outline-primary rounded-circle';
                        btnDelete.title = 'Desactivar';
                        btnDelete.innerHTML = '<i class="bi bi-x-circle"></i>';
                        btnDelete.addEventListener('click', () => deleteMesa(m.id));

                        actionsCol.appendChild(btnEdit);
                        actionsCol.appendChild(btnDelete);
                    } else {
                        const btnReactivate = document.createElement('button');
                        btnReactivate.className = 'btn btn-sm btn-success rounded-pill px-3 shadow-sm';
                        btnReactivate.title = 'Reactivar';
                        btnReactivate.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar';
                        btnReactivate.addEventListener('click', () => reactivateMesa(m.id));

                        actionsCol.appendChild(btnReactivate);
                    }

                    fragment.appendChild(clone);
                });
                
                tbody.appendChild(fragment);
            } catch (error) {
                console.error(error);
                document.getElementById('tabla-mesas-body').innerHTML = '<tr><td colspan="4" class="text-danger text-center py-4">Error de conexión al cargar mesas.</td></tr>';
                showToast('error', 'No se pudieron cargar las mesas');
            }
        }

        function openModalMesa() {
            document.getElementById('formMesa').reset();
            document.getElementById('mesa-id').value = '';
            document.getElementById('modalMesaTitle').innerText = 'Añadir Mesa';
            modalMesaInst.show();
        }

        function editMesa(m) {
            document.getElementById('mesa-id').value = m.id;
            document.getElementById('mesa-numero').value = m.numero_mesa;
            document.getElementById('mesa-zona-id').value = m.zona_id;
            document.getElementById('mesa-capacidad').value = m.capacidad;
            document.getElementById('modalMesaTitle').innerText = 'Editar Mesa';
            modalMesaInst.show();
        }

        let isSubmittingMesa = false;
        document.getElementById('formMesa').addEventListener('submit', async (e) => {
            e.preventDefault();
            if (isSubmittingMesa) return;
            isSubmittingMesa = true;

            const btn = e.target.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';

            const id = document.getElementById('mesa-id').value;
            const data = {
                numero_mesa: document.getElementById('mesa-numero').value,
                zona_id: document.getElementById('mesa-zona-id').value,
                capacidad: document.getElementById('mesa-capacidad').value
            };
            
            const method = id ? 'PUT' : 'POST';
            const url = id ? `${API_URL}/mesas/${id}` : `${API_URL}/mesas`;

            try {
                const res = await fetch(url, {
                    method,
                    headers: headers(),
                    body: JSON.stringify(data)
                });

                if (handleAuthError(res)) return;
                if (res.ok) {
                    showToast('success', id ? 'Mesa actualizada' : 'Mesa creada');
                    modalMesaInst.hide();
                    loadMesas();
                } else {
                    const errorData = await res.json();
                    Swal.fire('Error', errorData.message || 'Error al guardar mesa', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Error de conexión', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
                isSubmittingMesa = false;
            }
        });

        async function deleteMesa(id) {
            Swal.fire({
                title: '¿Desactivar Mesa?',
                text: 'Esta mesa dejará de estar disponible.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, desactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/mesas/${id}`, { method: 'DELETE', headers: headers() });
                        if (handleAuthError(res)) return;
                        if (res.ok) {
                            showToast('success', 'Mesa desactivada');
                            loadMesas();
                        } else {
                            const err = await res.json();
                            Swal.fire('Error', err.message || 'Error al desactivar mesa', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }

        async function reactivateMesa(id) {
            Swal.fire({
                title: '¿Reactivar Mesa?',
                text: 'Esta mesa volverá a estar disponible.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, reactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/mesas/${id}/activar`, { method: 'PATCH', headers: headers() });
                        if (handleAuthError(res)) return;
                        if (res.ok) {
                            showToast('success', 'Mesa reactivada');
                            loadMesas();
                        } else {
                            const err = await res.json();
                            Swal.fire('Error', err.message || 'Error al reactivar mesa. Verifica la zona', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }

        // --- HORARIOS ---
        async function loadHorarios() {
            try {
                const res = await fetch(`${API_URL}/horarios`, { headers: headers() });
                if (handleAuthError(res)) return;
                if (!res.ok) throw new Error('Error al cargar horarios');
                
                const response = await res.json();
                const horarios = Array.isArray(response) ? response : (response.data || []);
                
                const container = document.getElementById('horarios-container');
                container.innerHTML = '';

                if (horarios.length === 0) {
                    container.innerHTML = '<div class="col-12 text-center text-muted py-4">No hay horarios configurados aún.</div>';
                    return;
                }

                // Opcional: ordenar por día
                const ordenDias = { "Lunes": 1, "Martes": 2, "Miercoles": 3, "Jueves": 4, "Viernes": 5, "Sabado": 6, "Domingo": 7 };
                horarios.sort((a, b) => (ordenDias[a.dia_semana] || 99) - (ordenDias[b.dia_semana] || 99));

                // Mostrar horas en formato 24h (HH:MM) directamente desde la BD
                const formatTime24h = (time) => time ? time.substring(0, 5) : '--:--';

                const template = document.getElementById('horario-template');
                const fragment = document.createDocumentFragment();

                horarios.forEach(h => {
                    const clone = template.content.cloneNode(true);
                    const card = clone.querySelector('.js-card');

                    if (!h.activo) {
                        card.classList.add('opacity-50');
                        clone.querySelector('.js-badge').style.display = 'inline-block';
                    }

                    clone.querySelector('.js-dia').textContent = h.dia_semana;
                    clone.querySelector('.js-horas').textContent = `${formatTime24h(h.hora_apertura)} - ${formatTime24h(h.hora_cierre)}`;

                    const actionsCol = clone.querySelector('.js-actions');
                    if (h.activo) {
                        const btnEdit = document.createElement('button');
                        btnEdit.className = 'btn btn-sm btn-outline-dark rounded-circle';
                        btnEdit.title = 'Editar';
                        btnEdit.innerHTML = '<i class="bi bi-pencil"></i>';
                        btnEdit.addEventListener('click', () => editHorario(h));

                        const btnDelete = document.createElement('button');
                        btnDelete.className = 'btn btn-sm btn-outline-primary rounded-circle';
                        btnDelete.title = 'Desactivar';
                        btnDelete.innerHTML = '<i class="bi bi-x-circle"></i>';
                        btnDelete.addEventListener('click', () => deleteHorario(h.id));

                        actionsCol.appendChild(btnEdit);
                        actionsCol.appendChild(btnDelete);
                    } else {
                        const btnReactivate = document.createElement('button');
                        btnReactivate.className = 'btn btn-sm btn-success rounded-pill px-3 shadow-sm';
                        btnReactivate.title = 'Reactivar';
                        btnReactivate.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar';
                        btnReactivate.addEventListener('click', () => reactivateHorario(h.id));

                        actionsCol.appendChild(btnReactivate);
                    }

                    fragment.appendChild(clone);
                });
                
                container.appendChild(fragment);
            } catch (error) {
                console.error(error);
                document.getElementById('horarios-container').innerHTML = '<div class="col-12 text-center text-danger py-4">Error de conexión al cargar horarios.</div>';
                showToast('error', 'No se pudieron cargar los horarios');
            }
        }

        function openModalHorario() {
            document.getElementById('formHorario').reset();
            document.getElementById('horario-id').value = '';
            document.getElementById('horario-dia').disabled = false; // Permitir seleccionar día en nuevo
            document.getElementById('modalHorarioTitle').innerText = 'Añadir Horario';
            modalHorarioInst.show();
        }

        function editHorario(h) {
            document.getElementById('horario-id').value = h.id;
            document.getElementById('horario-dia').value = h.dia_semana;
            document.getElementById('horario-dia').disabled = true; // Deshabilitar cambio de día en edición
            
            // Format HH:MM from HH:MM:SS
            document.getElementById('horario-apertura').value = h.hora_apertura.substring(0, 5);
            document.getElementById('horario-cierre').value = h.hora_cierre.substring(0, 5);
            
            document.getElementById('modalHorarioTitle').innerText = 'Editar Horario';
            modalHorarioInst.show();
        }

        let isSubmittingHorario = false;
        document.getElementById('formHorario').addEventListener('submit', async (e) => {
            e.preventDefault();
            if (isSubmittingHorario) return;
            isSubmittingHorario = true;

            const btn = e.target.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';

            const id = document.getElementById('horario-id').value;
            const data = {
                dia_semana: document.getElementById('horario-dia').value, // Aunque disabled, leer el value funciona, pero disabled inputs don't submit in normal forms. we read it manually anyway.
                hora_apertura: document.getElementById('horario-apertura').value,
                hora_cierre: document.getElementById('horario-cierre').value
            };
            
            const method = id ? 'PUT' : 'POST';
            const url = id ? `${API_URL}/horarios/${id}` : `${API_URL}/horarios`;

            try {
                const res = await fetch(url, {
                    method,
                    headers: headers(),
                    body: JSON.stringify(data)
                });

                if (handleAuthError(res)) return;
                if (res.ok) {
                    showToast('success', id ? 'Horario actualizado' : 'Horario creado');
                    modalHorarioInst.hide();
                    loadHorarios();
                } else {
                    const errorData = await res.json();
                    Swal.fire('Error', errorData.message || 'Error al guardar horario (quizá ya existe)', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Error de conexión', 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
                isSubmittingHorario = false;
            }
        });

        async function deleteHorario(id) {
            Swal.fire({
                title: '¿Desactivar Horario?',
                text: 'Este horario dejará de estar disponible.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, desactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/horarios/${id}`, { method: 'DELETE', headers: headers() });
                        if (handleAuthError(res)) return;
                        if (res.ok) {
                            showToast('success', 'Horario desactivado');
                            loadHorarios();
                        } else {
                            const err = await res.json();
                            Swal.fire('Error', err.message || 'Error al desactivar horario', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }

        async function reactivateHorario(id) {
            Swal.fire({
                title: '¿Reactivar Horario?',
                text: 'Este horario volverá a estar disponible.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, reactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/horarios/${id}/activar`, { method: 'PATCH', headers: headers() });
                        if (handleAuthError(res)) return;
                        if (res.ok) {
                            showToast('success', 'Horario reactivado');
                            loadHorarios();
                        } else {
                            const err = await res.json();
                            Swal.fire('Error', err.message || 'Error al reactivar horario', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }

        // --- STAFF (PERSONAL) ---
        async function loadStaff() {
            try {
                const res = await fetch(`${API_URL}/staff`, { headers: headers() });
                if (handleAuthError(res)) return;
                if (!res.ok) throw new Error('Error al cargar personal');
                
                const response = await res.json();
                const staff = Array.isArray(response) ? response : (response.data || []);
                
                const tbody = document.getElementById('tabla-staff-body');
                tbody.innerHTML = '';

                if (staff.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">No hay personal registrado.</td></tr>';
                    return;
                }

                const template = document.getElementById('staff-template');
                const fragment = document.createDocumentFragment();

                staff.forEach(s => {
                    const isActivo = s.estado === true || s.estado === 1 || s.estado === '1' || s.estado === 'true';
                    
                    const clone = template.content.cloneNode(true);
                    const row = clone.querySelector('.js-row');

                    if (!isActivo) {
                        row.classList.add('table-secondary', 'opacity-50');
                        clone.querySelector('.js-badge-inactivo').style.display = 'inline-block';
                    } else {
                        clone.querySelector('.js-badge-activo').style.display = 'inline-block';
                    }

                    clone.querySelector('.js-inicial').textContent = s.name.charAt(0).toUpperCase();
                    clone.querySelector('.js-nombre').textContent = s.name;
                    clone.querySelector('.js-email').textContent = s.email;

                    const actionsCol = clone.querySelector('.js-actions');
                    if (isActivo) {
                        const btnEdit = document.createElement('button');
                        btnEdit.className = 'btn btn-sm btn-outline-dark rounded-circle me-1';
                        btnEdit.title = 'Editar';
                        btnEdit.innerHTML = '<i class="bi bi-pencil"></i>';
                        btnEdit.addEventListener('click', () => editStaff(s));

                        const btnDelete = document.createElement('button');
                        btnDelete.className = 'btn btn-sm btn-outline-primary rounded-circle';
                        btnDelete.title = 'Desactivar';
                        btnDelete.innerHTML = '<i class="bi bi-x-circle"></i>';
                        btnDelete.addEventListener('click', () => deleteStaff(s.id));

                        actionsCol.appendChild(btnEdit);
                        actionsCol.appendChild(btnDelete);
                    } else {
                        const btnReactivate = document.createElement('button');
                        btnReactivate.className = 'btn btn-sm btn-success rounded-pill px-3 shadow-sm';
                        btnReactivate.title = 'Reactivar';
                        btnReactivate.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar';
                        btnReactivate.addEventListener('click', () => reactivateStaff(s.id));

                        actionsCol.appendChild(btnReactivate);
                    }

                    fragment.appendChild(clone);
                });
                
                tbody.appendChild(fragment);
            } catch (error) {
                console.error(error);
                document.getElementById('tabla-staff-body').innerHTML = '<tr><td colspan="4" class="text-danger text-center py-4">Error de conexión al cargar el personal.</td></tr>';
                showToast('error', 'No se pudo cargar el personal');
            }
        }

        function openModalStaff() {
            document.getElementById('formStaff').reset();
            document.getElementById('staff-id').value = '';
            document.getElementById('modalStaffTitle').innerText = 'Añadir Personal';
            
            // Habilitar campos en modo creacion
            document.getElementById('staff-email').disabled = false;
            document.getElementById('staff-password').required = true;
            document.getElementById('staff-password-confirm').required = true;
            document.getElementById('staff-password-help').style.display = 'none';
            document.getElementById('staff-password-confirm-group').style.display = 'block';

            modalStaffInst.show();
        }

        function editStaff(s) {
            document.getElementById('formStaff').reset();
            document.getElementById('staff-id').value = s.id;
            document.getElementById('staff-nombre').value = s.name;
            document.getElementById('staff-email').value = s.email;
            
            // Hacer contraseña opcional
            document.getElementById('staff-password').required = false;
            document.getElementById('staff-password-confirm').required = false;
            document.getElementById('staff-password-help').style.display = 'block';
            document.getElementById('staff-password-confirm-group').style.display = 'block';

            document.getElementById('modalStaffTitle').innerText = 'Editar Personal';
            modalStaffInst.show();
        }

        document.getElementById('formStaff').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('staff-id').value;
            const password = document.getElementById('staff-password').value;
            const passwordConfirm = document.getElementById('staff-password-confirm').value;
            
            if (password && password !== passwordConfirm) {
                Swal.fire('Error', 'Las contraseñas no coinciden', 'error');
                return;
            }

            const data = {
                name: document.getElementById('staff-nombre').value,
                email: document.getElementById('staff-email').value
            };
            
            if (password) {
                data.password = password;
                data.password_confirmation = passwordConfirm;
            }
            
            const method = id ? 'PUT' : 'POST';
            const url = id ? `${API_URL}/staff/${id}` : `${API_URL}/staff`;

            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Guardando...';
            submitBtn.disabled = true;

            try {
                const res = await fetch(url, {
                    method,
                    headers: headers(),
                    body: JSON.stringify(data)
                });

                if (handleAuthError(res)) return;
                const result = await res.json();

                if (res.ok && result.success) {
                    showToast('success', result.message || (id ? 'Personal actualizado' : 'Personal creado'));
                    modalStaffInst.hide();
                    loadStaff();
                } else {
                    Swal.fire('Error', result.message || 'Error al guardar personal', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Error de conexión', 'error');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });

        async function deleteStaff(id) {
            Swal.fire({
                title: '¿Desactivar Personal?',
                text: 'Este usuario no podrá acceder al sistema.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, desactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/staff/${id}`, { method: 'DELETE', headers: headers() });
                        if (handleAuthError(res)) return;
                        const data = await res.json();
                        
                        if (res.ok && data.success !== false) {
                            showToast('success', data.message || 'Personal desactivado');
                            loadStaff();
                        } else {
                            Swal.fire('Error', data.message || 'Error al desactivar personal', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }

        async function reactivateStaff(id) {
            Swal.fire({
                title: '¿Reactivar Personal?',
                text: 'Este usuario volverá a tener acceso al sistema.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, reactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/staff/${id}/activar`, { method: 'PATCH', headers: headers() });
                        if (handleAuthError(res)) return;
                        const data = await res.json();
                        
                        if (res.ok && data.success !== false) {
                            showToast('success', data.message || 'Personal reactivado');
                            loadStaff();
                        } else {
                            Swal.fire('Error', data.message || 'Error al reactivar personal', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }

        // Toggle password visibility
        document.querySelectorAll('.toggle-staff-pw').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('bi-eye-slash');
                    this.classList.add('bi-eye');
                } else {
                    input.type = 'password';
                    this.classList.remove('bi-eye');
                    this.classList.add('bi-eye-slash');
                }
            });
        });
    </script>
@endsection