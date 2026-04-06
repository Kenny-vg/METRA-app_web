<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Registro de Clientes</title>
    <link rel="icon" href="{{ asset('favicon.png') }}?v=6" type="image/png">
    <link rel="icon" href="{{ asset('favicon.svg') }}?v=6" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- URL global del backend API (configurable por entorno) -->
    <script>
        window.API_URL = "{{ url('/api') }}";
        window.FILE_URL = "{{ url('/') }}";
    </script>
    <style>
        .password-strength-container { margin-top: 10px; }
        .strength-meter { height: 6px; display: flex; gap: 4px; margin-bottom: 15px; }
        .strength-bar { flex: 1; height: 100%; border-radius: 10px; background: #e0e0e0; transition: background 0.3s ease; }
        .strength-bar.active[data-level="1"] { background: #ff4d4d; } /* Rojo - Débil */
        .strength-bar.active[data-level="2"] { background: #ffcc00; } /* Amarillo - Medio */
        .strength-bar.active[data-level="3"] { background: #2ecc71; } /* Verde - Fuerte */
        .password-hint-list { list-style: none; padding: 0; margin: 0; font-size: 0.75rem; text-align: left; }
        .password-hint-item { display: flex; align-items: center; gap: 8px; color: var(--text-muted); margin-bottom: 4px; transition: color 0.3s ease; }
        .password-hint-item i { font-size: 0.9rem; }
        .password-hint-item.valid { color: #2ecc71; }
        .password-hint-item.valid i::before { content: "\f272"; } /* bi-check-circle-fill */
    </style>
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
                    <input type="text" name="name" class="form-control input-metra"  required oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                </div>

                <div class="text-start mb-3">
                    <label class="form-label small fw-bold" style="color: var(--black-primary);">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control input-metra" maxlength="100" required oninput="this.value = this.value.trim()">
                </div>
                <div class="text-start mb-3">
                    <label class="form-label small fw-bold" style="color: var(--black-primary);">Contraseña</label>
                    <div class="position-relative">
                        <input type="password" id="register_password" name="password" class="form-control input-metra pe-5" placeholder="••••••••" minlength="8" maxlength="32" required oninput="this.value = this.value.trim()">
                        <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3 text-muted toggle-password" style="cursor: pointer; z-index: 10;"></i>
                    </div>
                    <!-- Medidor de Fortaleza -->
                    <div class="password-strength-container d-none" id="strength-container">
                        <div class="strength-meter">
                            <div class="strength-bar" data-index="0"></div>
                            <div class="strength-bar" data-index="1"></div>
                            <div class="strength-bar" data-index="2"></div>
                        </div>
                        <ul class="password-hint-list">
                            <li class="password-hint-item" id="hint-len"><i class="bi bi-circle"></i> Al menos 8 caracteres</li>
                            <li class="password-hint-item" id="hint-mix"><i class="bi bi-circle"></i> Letras y Números (Mínimo requerido)</li>
                            <li class="password-hint-item" id="hint-spec"><i class="bi bi-circle"></i> Símbolos o Mayúsculas (Recomendado)</li>
                        </ul>
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
        // Lógica del Medidor de Fortaleza
        const passInput = document.getElementById('register_password');
        const strengthContainer = document.getElementById('strength-container');
        const bars = document.querySelectorAll('.strength-bar');
        const hLen = document.getElementById('hint-len');
        const hMix = document.getElementById('hint-mix');
        const hSpec = document.getElementById('hint-spec');

        if (passInput) {
            passInput.addEventListener('input', () => {
                const val = passInput.value;
                if (val.length > 0) {
                    strengthContainer.classList.remove('d-none');
                } else {
                    strengthContainer.classList.add('d-none');
                }

                const hasLen = val.length >= 8;
                const hasLetters = /[a-zA-Z]/.test(val);
                const hasNumbers = /[0-9]/.test(val);
                const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(val) || /[A-Z]/.test(val) && /[a-z]/.test(val);

                updateHint(hLen, hasLen);
                updateHint(hMix, hasLetters && hasNumbers);
                updateHint(hSpec, hasSpecial);

                let level = 0;
                if (val.length > 0) {
                    level = 1;
                    if (hasLen && hasLetters && hasNumbers) {
                        level = 2;
                        if (hasSpecial) level = 3;
                    }
                }

                bars.forEach((bar, idx) => {
                    bar.classList.remove('active');
                    bar.removeAttribute('data-level');
                    if (idx < level) {
                        bar.classList.add('active');
                        bar.setAttribute('data-level', level);
                    }
                });
            });
        }

        function updateHint(el, valid) {
            if (valid) {
                el.classList.add('valid');
                el.querySelector('i').className = 'bi bi-check-circle-fill';
            } else {
                el.classList.remove('valid');
                el.querySelector('i').className = 'bi bi-circle';
            }
        }

        registerForm.addEventListener('submit', async function(e) {
            e.preventDefault(); 
            
            const btnSubmit = registerForm.querySelector('button[type="submit"]');
            
            const name = registerForm.querySelector('input[name="name"]').value;
            const email = registerForm.querySelector('input[name="email"]').value;
            const password = registerForm.querySelector('input[name="password"]').value;
            const password_confirmation = registerForm.querySelector('input[name="password_confirmation"]').value;

            // Validación de Fortaleza Nivel Medio
            const hasLen = password.length >= 8;
            const hasLetters = /[a-zA-Z]/.test(password);
            const hasNumbers = /[0-9]/.test(password);

            if (!hasLen || !hasLetters || !hasNumbers) {
                Swal.fire('Contraseña Insegura', 'Tu contraseña debe tener al menos 8 caracteres e incluir letras y números.', 'warning');
                return;
            }

            if (password !== password_confirmation) {
                Swal.fire('Atención', 'Las contraseñas no coinciden.', 'warning');
                return;
            }

            btnSubmit.disabled = true;

            try {
                const response = await MetraAPI.post('/register-cliente', { name, email, password });
                
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
            } catch (error) {
                const errorData = error.data || error;
                let errorMsg = errorData.message || 'Datos inválidos.';
                if (errorData.errors) {
                    errorMsg = `<ul class="text-start mb-0" style="color: #D32F2F;">`;
                    Object.values(errorData.errors).forEach(errArray => {
                        errArray.forEach(err => {
                            errorMsg += `<li>${err}</li>`;
                        });
                    });
                    errorMsg += `</ul>`;
                    Swal.fire({
                        title: 'Error en el registro',
                        html: errorMsg,
                        icon: 'error',
                        confirmButtonColor: '#382C26'
                    });
                } else {
                    Swal.fire('Error en el registro', errorMsg, 'error');
                }
                btnSubmit.disabled = false;
            }

        });
    }
});
</script>
</body>
</html>