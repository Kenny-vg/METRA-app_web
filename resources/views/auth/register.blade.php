<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Registro de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal">

    <main class="login-container">
        <div class="login-card text-center" style="border-top: 5px solid var(--accent-gold);">
            
            <span class="login-logo">METRA</span>
            <h5 class="fw-bold mb-4" style="color: #6D4C41;">Crea tu cuenta</h5>
            
            <p class="text-muted small mb-4">Regístrate para comenzar a reservar en tus lugares favoritos</p>

            <form id="registerForm">
                <div class="text-start mb-3">
                    <label class="form-label small fw-bold" style="color: var(--black-primary);">Nombre Completo</label>
                    <input type="text" name="name" class="form-control input-metra" placeholder="Ej. Cristina Juárez" required>
                </div>

                <div class="text-start mb-3">
                    <label class="form-label small fw-bold" style="color: var(--black-primary);">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control input-metra" placeholder="tu@correo.com" required>
                </div>

                <div class="text-start mb-3">
                    <label class="form-label small fw-bold" style="color: var(--black-primary);">Contraseña</label>
                    <input type="password" name="password" class="form-control input-metra" placeholder="••••••••" required>
                </div>

                <div class="text-start mb-4">
                    <label class="form-label small fw-bold" style="color: var(--black-primary);">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control input-metra" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-metra-main w-100 rounded-3">
                    Crear mi cuenta
                </button>
                
                <div class="my-4 d-flex align-items-center">
                    <hr class="flex-grow-1 opacity-25">
                    <span class="mx-3 small text-muted">o regístrate con</span>
                    <hr class="flex-grow-1 opacity-25">
                </div>

                <button type="button" id="customGoogleBtn" class="btn btn-outline-dark w-100 rounded-pill py-2 shadow-sm">
                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="20" class="me-2">
                     Google
                </button>
            </form>

            <div class="mt-5">
                <a href="{{ route('login') }}" class="text-muted small text-decoration-none">
                    ¿Ya tienes cuenta? <span class="fw-bold text-dark">Inicia Sesión</span>
                </a>
            </div>
        </div>
    </main>

    @include('partials.footer')

<script src="https://accounts.google.com/gsi/client" async></script>
<script>
let tokenClient;

document.addEventListener('DOMContentLoaded', function() {
    tokenClient = google.accounts.oauth2.initTokenClient({
        client_id: "{{ env('GOOGLE_CLIENT_ID') }}",
        scope: 'email profile',
        callback: async (tokenResponse) => {
            if (tokenResponse && tokenResponse.access_token) {
                try {
                    const userInfoRes = await fetch('https://www.googleapis.com/oauth2/v3/userinfo', {
                        headers: { 'Authorization': 'Bearer ' + tokenResponse.access_token }
                    });
                    const userInfo = await userInfoRes.json();
                    
                    const res = await fetch('/api/auth/google', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            email: userInfo.email,
                            name: userInfo.name,
                            google_id: userInfo.sub,
                            avatar: userInfo.picture
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
                        alert('Fallo al iniciar sesión con Google.');
                    }
                } catch (error) {
                    console.error('API Error', error);
                    alert('Error comunicando con Google o el servidor.');
                }
            }
        }
    });

    const customGoogleBtn = document.getElementById('customGoogleBtn');
    if (customGoogleBtn) {
        customGoogleBtn.addEventListener('click', () => {
            tokenClient.requestAccessToken();
        });
    }

    const registerForm = document.getElementById('registerForm');

    if (registerForm) {
        registerForm.addEventListener('submit', async function(e) {
            e.preventDefault(); 
            
            const btnSubmit = registerForm.querySelector('button[type="submit"]');
            btnSubmit.disabled = true;

            const name = registerForm.querySelector('input[name="name"]').value;
            const email = registerForm.querySelector('input[name="email"]').value;
            const password = registerForm.querySelector('input[name="password"]').value;
            const password_confirmation = registerForm.querySelector('input[name="password_confirmation"]').value;

            if (password !== password_confirmation) {
                alert('Las contraseñas no coinciden.');
                btnSubmit.disabled = false;
                return;
            }

            try {
                const response = await fetch('/api/register-cliente', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ name, email, password })
                });

                if (response.ok) {
                    alert('Cuenta creada exitosamente. Ahora puedes iniciar sesión.');
                    window.location.href = '/login';
                } else {
                    const errorData = await response.json();
                    let errorMsg = errorData.message || 'Datos inválidos.';
                    if (errorData.errors) {
                        const firstError = Object.values(errorData.errors)[0][0];
                        if (firstError) errorMsg = firstError;
                    }
                    alert('Error en registro: ' + errorMsg);
                    btnSubmit.disabled = false;
                }
            } catch (error) {
                console.error('Fallo la API', error);
                alert('Fallo de conexión al servidor.');
                btnSubmit.disabled = false;
            }
        });
    }
});
</script>
</body>
</html>