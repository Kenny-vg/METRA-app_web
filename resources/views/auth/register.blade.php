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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <input type="text" name="name" class="form-control input-metra" placeholder="Ej. Cristina Juárez" maxlength="50" required oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                </div>

                <div class="text-start mb-3">
                    <label class="form-label small fw-bold" style="color: var(--black-primary);">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control input-metra" placeholder="tu@correo.com" maxlength="100" required oninput="this.value = this.value.trim()">
                </div>

                <div class="text-start mb-3">
                    <label class="form-label small fw-bold" style="color: var(--black-primary);">Contraseña</label>
                    <div class="position-relative">
                        <input type="password" name="password" class="form-control input-metra pe-5" placeholder="••••••••" minlength="8" maxlength="32" required oninput="this.value = this.value.trim()">
                        <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3 text-muted toggle-password" style="cursor: pointer; z-index: 10;"></i>
                    </div>
                </div>

                <div class="text-start mb-4">
                    <label class="form-label small fw-bold" style="color: var(--black-primary);">Confirmar Contraseña</label>
                    <div class="position-relative">
                        <input type="password" name="password_confirmation" class="form-control input-metra pe-5" placeholder="••••••••" minlength="8" maxlength="32" required oninput="this.value = this.value.trim()">
                        <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3 text-muted toggle-password" style="cursor: pointer; z-index: 10;"></i>
                    </div>
                </div>

                <button type="submit" class="btn-metra-main w-100 rounded-3">
                    Crear mi cuenta
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

<script>
document.addEventListener('DOMContentLoaded', function() {
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
                Swal.fire('Atención', 'Las contraseñas no coinciden.', 'warning');
                btnSubmit.disabled = false;
                return;
            }

            try {
                const API_URL = "{{ url('/api') }}";
                const response = await fetch(`${API_URL}/register-cliente`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ name, email, password })
                });

                if (response.ok) {
                    Swal.fire({
                        title: '¡Cuenta creada!',
                        text: 'Ahora puedes iniciar sesión para continuar.',
                        icon: 'success',
                        confirmButtonText: 'Ir al Login',
                        confirmButtonColor: 'var(--black-primary)'
                    }).then(() => {
                        registerForm.reset();
                        window.location.href = '/login';
                    });
                } else {
                    const errorData = await response.json();
                    let errorMsg = errorData.message || 'Datos inválidos.';
                    if (errorData.errors) {
                        const firstError = Object.values(errorData.errors)[0][0];
                        if (firstError) errorMsg = firstError;
                    }
                    Swal.fire('Error en el registro', errorMsg, 'error');
                    btnSubmit.disabled = false;
                }
            } catch (error) {
                console.error('Fallo la API', error);
                Swal.fire('Error', 'Fallo de conexión al servidor.', 'error');
                btnSubmit.disabled = false;
            }
        });
    }
});
</script>
</body>
</html>