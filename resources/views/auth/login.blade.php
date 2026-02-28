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
        <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center" style="background-color: var(--white-pure);">
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
                    <div class="alert small p-3 mb-4 rounded-3" style="background: #FFF0F0; border: 1px solid #FFD6D6; color: #D32F2F;">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="loginForm" action="{{ route('login') }}" method="POST">
                    @csrf 
                    <div class="text-start mb-3">
                        <label class="form-label small fw-bold" style="color: var(--black-primary);">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control input-metra" placeholder="nombre@correo.com" maxlength="255" required 
                            value="{{ old('email') }}" autofocus>
                        @error('email')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-start mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold mb-0" style="color: var(--black-primary);">Contraseña</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="small text-muted text-decoration-none">¿Olvidó su contraseña?</a>
                            @endif
                        </div>
                        <input type="password" name="password" class="form-control input-metra" placeholder="••••••••" minlength="8" required 
                            autocomplete="current-password">
                        @error('password')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn-metra-main w-100 py-3 mt-2" style="border-radius: 8px; font-size: 1.05rem; letter-spacing: 0.5px;">
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
    try {
        const res = await fetch('/api/auth/google', {
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
                const role = result.data.usuario.role;
                if(role === 'superadmin') window.location.href = '/superadmin/dashboard';
                else if(role === 'gerente') window.location.href = '/admin/dashboard';
                else window.location.href = '/public/perfil';
            } catch(e) {}
        } else {
            console.error('Error Google Login backend');
            Swal.fire({
                icon: 'error',
                title: 'Error de Autenticación',
                text: 'Fallo al iniciar sesión con Google.',
                confirmButtonColor: 'var(--black-primary)',
                confirmButtonText: 'Aceptar'
            });
        }
    } catch (error) {
        console.error('API Error', error);
    }
}

document.addEventListener('DOMContentLoaded', function() {
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

            try { localStorage.clear(); } catch (err) {}

            const email = loginForm.querySelector('input[name="email"]').value;
            const password = loginForm.querySelector('input[name="password"]').value;

            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });

                if (response.ok) {
                    const result = await response.json();
                    try {
                        localStorage.setItem('token', result.data.token);
                        const role = result.data.usuario.role;
                        if(role === 'superadmin') window.location.href = '/superadmin/dashboard';
                        else if(role === 'gerente') window.location.href = '/admin/dashboard';
                        else window.location.href = '/public/perfil';
                    } catch (err) {}
                } else {
                    const errorData = await response.json();
                    Swal.fire({
                        icon: 'error',
                        title: 'Acceso Denegado',
                        text: errorData.message || 'Credenciales inválidas.',
                        confirmButtonColor: 'var(--black-primary)',
                        confirmButtonText: 'Aceptar'
                    });
                }
            } catch (error) {
                console.error('Fallo la API', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Conexión',
                    text: 'Fallo de conexión al servidor.',
                    confirmButtonColor: 'var(--black-primary)',
                    confirmButtonText: 'Entendido'
                });
            }
        });
    }
});
</script>

</body>
</html>
