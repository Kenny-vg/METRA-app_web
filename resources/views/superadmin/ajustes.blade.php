@extends('superadmin.menu')

@section('title', 'Ajustes del Sistema')

@section('content')
    <style>
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            border-color: #86b7fe;
        }
    </style>
    <header class="mb-5">
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: 'success', title: '¡Éxito!', text: '{{ session("success") }}', confirmButtonColor: '#382C26' });
                    }
                });
            </script>
        @endif
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h2 class="fw-bold text-dark">Configuración Global SaaS</h2>
                <p class="text-muted mb-0">Administra parámetros críticos de la plataforma METRA.</p>
            </div>
        </div>
    </header>

    <!-- Loading overlay -->
    <div id="overlay-loading" class="d-flex" style="display:none !important; position:fixed; top:0;left:0;width:100%;height:100%; z-index:9999; align-items:center; justify-content:center;">
        <div class="text-center">
            <div class="spinner-border mb-3" style="width:3rem;height:3rem;"></div>
            <p class="fw-bold">Procesando...</p>
        </div>
    </div>

        <div class="row g-4 mb-5">
            <!-- Sección Superior: System/Status -->
            <div class="col-12 mb-4 mb-md-0">
                <div class="row g-3 g-md-4">
                    <!-- Estado del Sistema -->
                    <div class="col-12 col-md-6">
                        <div class="card bg-white border-0 shadow-sm rounded-4 p-3 p-md-4">
                            <h5 class="fw-bold mb-3 text-danger"><i class="bi bi-shield-exclamation me-2"></i>Modo Mantenimiento</h5>
                            <div class="form-check form-switch p-0 m-0 d-flex justify-content-between align-items-center mb-3">
                                <label class="form-check-label fw-bold small text-uppercase" for="maintenanceMode" style="letter-spacing: 0.5px;">Acceso Restringido</label>
                                <input class="form-check-input ms-0" type="checkbox" role="switch" id="maintenanceMode" style="width: 3em; height: 1.5em;">
                            </div>
                            <p class="small text-muted mb-0">
                                Solo Superadmins podrán acceder. Clientes verán página de "Mantenimiento".
                            </p>
                        </div>
                    </div>

                    <!-- Información Técnica -->
                    <div class="col-12 col-md-6">
                        <div class="card bg-white border-0 shadow-sm rounded-4 p-3 p-md-4">
                            <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-server me-2"></i>Build Info</h5>
                            <ul class="list-group list-group-flush small">
                                <li class="list-group-item d-flex justify-content-between px-0 border-0 bg-transparent text-muted py-1">
                                    <span>Versión</span>
                                    <span class="fw-bold text-dark">11.x</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0 border-0 bg-transparent text-muted py-1">
                                    <span>Entorno</span>
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2 py-1" style="font-size: 0.65rem;">Producción</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between px-0 border-0 bg-transparent text-muted py-1">
                                    <span>Build</span>
                                    <span class="fw-bold text-dark">09.Feb.26</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuración Sistema: Pagos y Soporte -->
            <div class="col-12 mt-4 mt-md-2">
                <div class="d-flex align-items-center mb-4">
                    <h4 class="fw-bold text-dark m-0"><i class="bi bi-wallet2 me-2 text-primary"></i>Pagos y Soporte</h4>
                </div>
                <div class="card bg-white border-0 shadow-sm rounded-4 p-3 p-md-4">
                    <form id="form-configuracion" onsubmit="event.preventDefault(); guardarConfiguracion();">
                        <div class="row g-4">
                            <!-- Datos de Pago -->
                            <div class="col-12 col-md-6">
                                <h5 class="fw-bold mb-3 text-secondary border-bottom pb-2">Datos Bancarios</h5>
                                <div class="mb-3">
                                    <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Banco</label>
                                    <input type="text" class="form-control bg-light border-0" id="conf_banco" placeholder="Ej. BBVA">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">CLABE</label>
                                    <input type="text" class="form-control bg-light border-0" id="conf_clabe" placeholder="18 dígitos" maxlength="18" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Beneficiario</label>
                                    <input type="text" class="form-control bg-light border-0" id="conf_beneficiario" placeholder="Nombre completo">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Instrucciones</label>
                                    <textarea class="form-control bg-light border-0" id="conf_instrucciones" rows="3" placeholder="Instrucciones adicionales..."></textarea>
                                </div>
                            </div>
                            <!-- Datos de Soporte -->
                            <div class="col-12 col-md-6">
                                <h5 class="fw-bold mb-3 text-secondary border-bottom pb-2">Contacto</h5>
                                <div class="mb-3">
                                    <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Email</label>
                                    <input type="email" class="form-control bg-light border-0" id="conf_email" placeholder="soporte@metra.com">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Teléfono</label>
                                    <input type="text" class="form-control bg-light border-0" id="conf_telefono" placeholder="+52 238 000 0000" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 43" oninput="this.value = this.value.replace(/[^0-9+]/g, '');">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">WhatsApp</label>
                                    <input type="text" class="form-control bg-light border-0" id="conf_whatsapp" placeholder="+52 238 000 0000" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 43" oninput="this.value = this.value.replace(/[^0-9+]/g, '');">
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 text-center text-md-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow-sm w-100 w-md-auto">
                                <i class="bi bi-save2-fill me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>


        </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
if (!localStorage.getItem('token')) {
    window.location.href = '/login';
}



async function cargarConfiguracion() {
    try {
        const res = await MetraAPI.get(`/configuracion-pago`);
        if (res.data) {
            const config = res.data;
            document.getElementById('conf_banco').value = config.banco || '';
            document.getElementById('conf_clabe').value = config.clabe || '';
            document.getElementById('conf_beneficiario').value = config.beneficiario || '';
            document.getElementById('conf_instrucciones').value = config.instrucciones_pago || '';
            document.getElementById('conf_email').value = config.email_soporte || '';
            document.getElementById('conf_telefono').value = config.telefono_soporte || '';
            document.getElementById('conf_whatsapp').value = config.whatsapp_soporte || '';
        }
    } catch (e) {
        console.error('Error loading config:', e);
    }
}

async function guardarConfiguracion() {
    const overlay = document.getElementById('overlay-loading');
    overlay.style.setProperty('display', 'flex', 'important');
    
    const data = {
        banco: document.getElementById('conf_banco').value,
        clabe: document.getElementById('conf_clabe').value,
        beneficiario: document.getElementById('conf_beneficiario').value,
        instrucciones_pago: document.getElementById('conf_instrucciones').value,
        email_soporte: document.getElementById('conf_email').value,
        telefono_soporte: document.getElementById('conf_telefono').value,
        whatsapp_soporte: document.getElementById('conf_whatsapp').value
    };

    try {
        await MetraAPI.put(`/superadmin/configuracion-pago`, data);
        overlay.style.setProperty('display', 'none', 'important');
        Swal.fire({ icon: 'success', title: 'Guardado', text: 'Configuración actualizada.', confirmButtonColor: '#28a745', timer: 2000, showConfirmButton: false });
    } catch (e) {
        overlay.style.setProperty('display', 'none', 'important');
        const fallbackMsg = e.data?.message || Object.values(e.data?.errors || {}).join(' | ') || e.message || 'Problema de conexión.';
        Swal.fire({ icon: 'error', title: 'Error', text: fallbackMsg, confirmButtonColor: '#0d6efd' });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    cargarConfiguracion();
});
</script>
@endsection