<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Limpiar estado de wizard de registro si se accede al login (ej. tras logout)
    localStorage.removeItem('wizard_form_data');
    localStorage.removeItem('registro_cafeteria_id');
});
</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal">

    <div class="row g-0 vh-100">
        <!-- Lado Izquierdo: Imagen Conceptual High-End -->
        <div class="col-lg-6 d-none d-lg-block">
            <div class="h-100 w-100" style="background-image: url('https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?auto=format&fit=crop&q=80&w=1400'); background-size: cover; background-position: center; position: relative;">
                <!-- Overlay opcional sutil -->
                <div style="position: absolute; inset: 0; background: linear-gradient(to right, rgba(0,0,0,0.2), transparent);"></div>
                <div style="position: absolute; bottom: 40px; left: 40px; color: white; z-index: 2;">
                    <h2 class="fw-bold fs-1" style="font-family: 'Inter', sans-serif; letter-spacing: -1px; text-shadow: 0 4px 20px rgba(0,0,0,0.3);">Exclusividad y<br>Servicio Impecable.</h2>
                    <p class="fs-5" style="opacity: 0.9;">Gestione su perfil en METRA.</p>
                </div>
            </div>
        </div>

        <!-- Lado Derecho: Formulario Limpio -->
        <div class="col-12 col-lg-6 position-relative d-flex align-items-center justify-content-center" style="background-color: var(--white-pure);">
            <!-- Botón Volver -->
            <a href="/" class="btn btn-sm btn-outline-secondary position-absolute top-0 end-0 m-4 fw-bold" style="border-radius: 50px; padding: 8px 20px;">
                <i class="bi bi-arrow-left me-2"></i>Volver al Inicio
            </a>
            
            <div class="w-100 px-4 px-md-5" style="max-width: 480px;">
                
                <div class="text-center mb-5">
                    <a href="/" class="text-decoration-none d-inline-block mb-4">
                        <span class="fw-bold fs-2" style="color: var(--black-primary); letter-spacing: -1px;">
                            <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold); font-size: 1.5rem;"></i>METRA
                        </span>
                    </a>
                    <h4 class="fw-bold mb-2" style="color: var(--black-primary); font-family: 'Inter', sans-serif;">Acceso al Portal</h4>
                    <p style="color: var(--text-muted);">Ingrese sus credenciales para continuar.</p>
                </div>

                @if ($errors->any())
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Atención',
                                    html: '<ul class="text-start mb-0" style="color: #D32F2F;">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                                    confirmButtonColor: '#382C26'
                                });
                            }
                        });
                    </script>
                @endif

                <form id="loginForm" action="{{ route('login') }}" method="POST">
                    @csrf 
                    <div class="text-start mb-3">
                        <label class="form-label small fw-bold" style="color: var(--black-primary);">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control input-metra" placeholder="nombre@correo.com" maxlength="100" required 
                            value="{{ old('email') }}" autofocus oninput="this.value = this.value.trim()" tabindex="1">
                        @error('email')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-start mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold mb-0" style="color: var(--black-primary);">Contraseña</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="small text-muted text-decoration-none" tabindex="4">¿Olvidó su contraseña?</a>
                            @endif
                        </div>
                        <div class="position-relative">
                            <input type="password" name="password" class="form-control input-metra pe-5" placeholder="••••••••" minlength="8" maxlength="32" required 
                                autocomplete="current-password" oninput="this.value = this.value.trim()" tabindex="2">
                            <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3 text-muted toggle-password" style="cursor: pointer; z-index: 10;"></i>
                        </div>
                        @error('password')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn-metra-main w-100 py-3 mt-2" style="border-radius: 8px; font-size: 1.05rem; letter-spacing: 0.5px;" tabindex="3">
                        Iniciar Sesión
                    </button>
                    
                    <div class="my-4 d-flex align-items-center">
                        <hr class="flex-grow-1" style="border-color: var(--border-light); opacity: 1;">
                        <span class="mx-3 small text-uppercase fw-bold" style="color: var(--text-muted); font-size: 0.7rem; letter-spacing: 1px;">Confirmar Identidad</span>
                        <hr class="flex-grow-1" style="border-color: var(--border-light); opacity: 1;">
                    </div>

                    <div class="position-relative w-100" style="height: 52px; overflow: hidden; border-radius: 8px;">
                        <!-- Botón Personalizado Visible -->
                        <button type="button" id="customGoogleBtn" class="btn w-100 h-100 d-flex align-items-center justify-content-center" 
                           style="border: 1px solid var(--border-light); background: var(--white-pure); color: var(--text-main); font-weight: 600; font-size: 0.95rem; pointer-events: none;">
                            <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="20" class="me-3">
                             Continuar con Google
                        </button>
                        
                        <!-- Botón Oficial Invisible Encima -->
                        <div id="btnGoogleContainer" class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0.001; z-index: 10;"></div>
                    </div>
                </form>

                <div class="mt-5 text-center">
                    <p class="text-muted small">
                        ¿Requiere una nueva cuenta? <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: var(--black-primary); border-bottom: 1px solid var(--black-primary);">Regístrese aquí</a>
                    </p>
                </div>

            </div>
        </div>
    </div>


<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
function decodeJwtResponse(token) {
    let base64Url = token.split('.')[1];
    let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    let jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
    return JSON.parse(jsonPayload);
}

window.handleCredentialResponse = async function(response) {
    const data = decodeJwtResponse(response.credential);
    const API_URL = "{{ url('/api') }}";
    try {
        const res = await fetch(`${API_URL}/auth/google`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email: data.email,
                name: data.name,
                google_id: data.sub,
                avatar: data.picture
            })
        });

        if (res.ok) {
            const result = await res.json();
            try {
                localStorage.setItem('token', result.data.token);
                sessionStorage.setItem('token', result.data.token);
                if (result.data.usuario?.nombre_cafeteria) {
                    localStorage.setItem('nombre_cafeteria', result.data.usuario.nombre_cafeteria);
                }
                if (result.data.usuario?.name) {
                    localStorage.setItem('user_name', result.data.usuario.name);
                }
                if (result.data.usuario?.dias_restantes !== undefined && result.data.usuario?.dias_restantes !== null) {
                    localStorage.setItem('dias_restantes', result.data.usuario.dias_restantes);
                }
                if (result.data.usuario?.cafe_id) {
                    localStorage.setItem('cafe_id', result.data.usuario.cafe_id);
                }
                const role = result.data.usuario.role;
                if(role === 'superadmin') window.location.href = '/superadmin/dashboard';
                else if(role === 'gerente') window.location.href = '/admin/dashboard';
                else if(role === 'personal') window.location.href = '/staff-app';
                else window.location.href = '/public/perfil';
            } catch(e) {}
        } else {
            console.error('Error Google Login backend');
            if (res.status === 422) {
                const json = await res.json();
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: json.message || 'Primero debes crear tu cuenta usando el formulario de registro.',
                    confirmButtonColor: '#382C26',
                    confirmButtonText: 'Entendido'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Autenticación',
                    text: 'Fallo al iniciar sesión con Google.',
                    confirmButtonColor: '#382C26',
                    confirmButtonText: 'Aceptar'
                });
            }
        }
    } catch (error) {
        console.error('API Error', error);
        Swal.fire('Error de conexión', 'Fallo al comunicarse con el servidor.', 'error');
    }
}

document.addEventListener('DOMContentLoaded', function() {

    window.continuarSubida = async function(email) {
        if (!email) return;

        try {
            const API_URL = "{{ url('/api') }}";
            const res = await fetch(`${API_URL}/registro-pendiente`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email })
            });
            
            const result = await res.json();
            
            if (res.ok && result.data && result.data.cafeteria_id) {
                window.location.href = '/subir-comprobante/' + result.data.cafeteria_id;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se encontró registro pendiente.',
                    confirmButtonColor: '#382C26'
                });
            }
        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'Fallo de conexión al servidor.',
                confirmButtonColor: '#382C26'
            });
        }
    }
    
    const togglePasswords = document.querySelectorAll('.toggle-password');
    togglePasswords.forEach(icon => {
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

    const initGoogle = setInterval(() => {
        if (typeof google !== 'undefined' && google.accounts) {
            clearInterval(initGoogle);
            google.accounts.id.initialize({
                client_id: "{{ env('GOOGLE_CLIENT_ID') }}",
                callback: handleCredentialResponse
            });
            // Hacemos render del boton oficial pero transparente sobre el nuestro
            google.accounts.id.renderButton(
                document.getElementById("btnGoogleContainer"),
                { theme: "outline", size: "large", type: "standard", shape: "rectangular", text: "signin_with", logo_alignment: "left", width: document.getElementById('customGoogleBtn').offsetWidth }
            );
        }
    }, 100);

    const loginForm = document.getElementById('loginForm');

    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault(); 

            try { 
                localStorage.clear(); 
                sessionStorage.clear(); 
                // Clear the cookie as well
                document.cookie = 'metra_role=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
            } catch (err) {}

            const email = loginForm.querySelector('input[name="email"]').value;
            const password = loginForm.querySelector('input[name="password"]').value;

            try {
                const API_URL = "{{ url('/api') }}";
                const response = await fetch(`${API_URL}/login`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });

                console.log('STATUS:', response.status);
                const raw = await response.clone().json();
                console.log('BODY:', raw);

                if (response.ok) {
                    const result = await response.json();
                    try {
                        localStorage.setItem('token', result.data.token);
                        sessionStorage.setItem('token', result.data.token);
                        
                        // Set cookie for web routes protection
                        const role = result.data.usuario.role;
                        document.cookie = `metra_role=${role}; path=/; max-age=86400`;

                        if (result.data.usuario?.nombre_cafeteria) {
                            localStorage.setItem('nombre_cafeteria', result.data.usuario.nombre_cafeteria);
                        }
                        if (result.data.usuario?.name) {
                            localStorage.setItem('user_name', result.data.usuario.name);
                        }
                        if (result.data.usuario?.dias_restantes !== undefined && result.data.usuario?.dias_restantes !== null) {
                            localStorage.setItem('dias_restantes', result.data.usuario.dias_restantes);
                        }
                        if (result.data.usuario?.cafe_id) {
                            localStorage.setItem('cafe_id', result.data.usuario.cafe_id);
                        }
                        if(role === 'superadmin') window.location.href = '/superadmin/dashboard';
                        else if(role === 'gerente') window.location.href = '/admin/dashboard';
                        else if(role === 'personal') window.location.href = '/staff-app';
                        else window.location.href = '/public/perfil';
                    } catch (err) {}
                } else {
                    const errorData = await response.json();
                    const errorMsg = errorData.message || '';
                    const msgLower = errorMsg.toLowerCase();

                    // Caso 1: Rechazado o Inactivo (Status 403 o mensaje con palabras clave)
                    if (response.status === 403 || msgLower.includes('rechazado') || msgLower.includes('soporte') || msgLower.includes('inactivo')) {
                        if (msgLower.includes('inactivo')) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Cuenta en revisión',
                                text: 'Tu cuenta está pendiente de aprobación.',
                                confirmButtonColor: '#382C26',
                                confirmButtonText: 'Entendido'
                            });
                            return;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Registro Rechazado',
                            text: errorMsg || 'Tu registro ha sido rechazado. Por favor contacta a soporte.',
                            confirmButtonColor: '#D32F2F',
                            confirmButtonText: 'Entendido'
                        });
                        return;
                    }

                    // Caso 2: Pendiente / Revisión (Status 423)
                    if (response.status === 423) {
                        // 1. Mostrar pantalla de subir comprobante
                        if (errorMsg === 'Debes subir tu comprobante para continuar.' || msgLower.includes('subir tu comprobante')) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Comprobante requerido',
                                text: errorMsg,
                                showCancelButton: true,
                                confirmButtonText: 'Subir comprobante',
                                cancelButtonText: 'Cancelar',
                                confirmButtonColor: '#382C26'
                            }).then((result) => {
                                if(result.isConfirmed) {
                                    continuarSubida(email);
                                }
                            });
                        } 
                        // 2. Mostrar pantalla de "Solicitud en revisión"
                        else if (errorMsg === 'Tu comprobante fue enviado. Espera la validación del superadmin.' || msgLower.includes('espera la validación')) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Solicitud en revisión',
                                text: errorMsg,
                                confirmButtonColor: '#382C26',
                                confirmButtonText: 'Entendido'
                            });
                        } 
                        // 3. Mostrar pantalla de estado pendiente
                        else if (errorMsg === 'Tu cuenta está en revisión.' || msgLower.includes('cuenta está en revisión')) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Cuenta en revisión',
                                text: errorMsg,
                                confirmButtonColor: '#382C26',
                                confirmButtonText: 'Entendido'
                            });
                        } 
                    // 4. Suscripción Vencida
                        else if (errorMsg === 'Tu cafetería no tiene una suscripción activa.' || msgLower.includes('no tiene una suscripción activa')) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Atención',
                                text: errorMsg,
                                showCancelButton: true,
                                confirmButtonText: 'Renovar Suscripción',
                                cancelButtonText: 'Entendido',
                                confirmButtonColor: '#c62828',
                                cancelButtonColor: '#382C26'
                            }).then((result) => {
                                if(result.isConfirmed) {
                                    abrirModalRenovar();
                                    // Save email for potential backend use when user doesn't have token
                                    window.tempLoginEmail = email;
                                }
                            });
                        }
                        // Fallback para otros 423
                        else {
                            Swal.fire({
                                icon: 'info',
                                title: 'Atención',
                                text: errorMsg || 'Acción requerida.',
                                confirmButtonColor: '#382C26',
                                confirmButtonText: 'Entendido'
                            });
                        }
                        return; // Detiene la ejecución normal
                    }


                    // Si no es ninguno de los anteriores, mostrar error genérico o de validación
                    let displayMsg = errorData.message || 'Credenciales inválidas.';
                    
                    if (errorData.errors) {
                        displayMsg = `<ul class="text-start mb-0" style="color: #D32F2F;">`;
                        Object.values(errorData.errors).forEach(errArray => {
                            errArray.forEach(err => {
                                displayMsg += `<li>${err}</li>`;
                            });
                        });
                        displayMsg += `</ul>`;
                        Swal.fire({
                            icon: 'error',
                            title: 'Acceso Denegado',
                            html: displayMsg,
                            confirmButtonColor: '#382C26',
                            confirmButtonText: 'Aceptar'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Acceso Denegado',
                            text: displayMsg,
                            confirmButtonColor: '#382C26',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                }
            } catch (error) {
                console.error('Fallo la API', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Conexión',
                    text: 'Fallo de conexión al servidor.',
                    confirmButtonColor: '#382C26',
                    confirmButtonText: 'Entendido'
                });
            }
        });
    }
});

window.abrirModalRenovar = async function(estado = '') {
    const modalElement = document.getElementById('modalRenovar');
    if (!modalElement) {
        console.error('Modal Renovar no encontrado en el DOM');
        return;
    }
    const modal = new bootstrap.Modal(modalElement);
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
            const API_URL = "{{ url('/api') }}";
            const res = await fetch(`${API_URL}/planes-publicos`, { headers: { 'Accept': 'application/json' } });
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
}

document.addEventListener('DOMContentLoaded', function() {
    const formRenovar = document.getElementById('formRenovar');
    if (formRenovar) {
        formRenovar.addEventListener('submit', async (e) => {
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

            // Dado que el usuario no ha iniciado sesión, adjuntamos el email temporal que intentó usar
            if (window.tempLoginEmail) formData.append('email', window.tempLoginEmail);

            try {
                const API_URL = "{{ url('/api') }}";
                let authToken = localStorage.getItem('token') || '';
                
                // Usar el endpoint de renovación
                const res = await fetch(`${API_URL}/gerente/renovar-suscripcion`, {
                    method: 'POST',
                    headers: { 'Authorization': `Bearer ${authToken}`, 'Accept': 'application/json' },
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
                });

            } catch(err) {
                Swal.fire({ title: 'Error', text: err.message, icon: 'error', confirmButtonColor: '#382C26' });
            } finally {
                submitBtn.innerHTML = 'Enviar Renovación';
                submitBtn.disabled = false;
            }
        });
    }
});
</script>

    <!-- Modal Renovar Suscripción (Copy from Dashboard) -->
    <div class="modal fade" id="modalRenovar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 p-4">
                    <h5 class="fw-bold m-0" id="titulo-modal-renovar"><i class="bi bi-arrow-repeat me-2"></i>Renovar Suscripción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    @php
                        $cafeteria = auth()->check() && auth()->user() ? auth()->user()->cafeteria : null;
                        $isPendiente = $cafeteria ? $cafeteria->suscripciones()->where('estado_pago', 'pendiente')->exists() : false;
                    @endphp
                    @if($isPendiente)
                        <div class="text-center p-4">
                            <h5 class="fw-bold fs-4 text-warning mb-3"><i class="bi bi-clock-history"></i></h5>
                            <h5 class="fw-bold">¡Pago en proceso!</h5>
                            <p class="text-muted">Tu comprobante ha sido recibido y está pendiente de validación por el administrador. Por favor, espera a que tu acceso sea reactivado.</p>
                        </div>
                    @else
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
                            <button type="submit" id="btn-submit-renovar" class="btn-metra-main w-100 py-3 mt-2" style="border-radius: 8px; font-size: 1.05rem; letter-spacing: 0.5px;">Enviar Renovación</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
