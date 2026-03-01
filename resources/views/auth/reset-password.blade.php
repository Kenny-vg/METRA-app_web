<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Restablecer contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal">

    <div class="row g-0 vh-100 align-items-center justify-content-center" style="background-color: var(--off-white);">
        <div class="col-12 px-4" style="max-width: 480px;">
            
            <div class="text-center mb-5">
                <a href="/" class="text-decoration-none d-inline-block mb-4">
                    <span class="fw-bold fs-2" style="color: var(--black-primary); letter-spacing: -1px;">
                        <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold); font-size: 1.5rem;"></i>METRA
                    </span>
                </a>
                <h4 class="fw-bold mb-2" style="color: var(--black-primary); font-family: 'Inter', sans-serif;">Cambiar contraseña</h4>
                <p style="color: var(--text-muted);">Defina una nueva contraseña segura para su cuenta.</p>
            </div>

            <div class="bg-white p-5 rounded-4 shadow-sm border" style="border-radius: 20px;">
                <form id="resetPasswordForm">
                    <div class="mb-3">
                        <label class="form-label small fw-bold" style="color: var(--black-primary);">Correo Electrónico</label>
                        <input type="email" id="email" class="form-control input-metra bg-light" readonly required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold" style="color: var(--black-primary);">Nueva Contraseña</label>
                        <div class="position-relative">
                            <input type="password" id="password" class="form-control input-metra pe-5" placeholder="••••••••" minlength="8" required>
                            <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3 text-muted toggle-password" style="cursor: pointer; z-index: 10;"></i>
                        </div>
                        <small class="text-muted" style="font-size: 0.75rem;">Mínimo 8 caracteres.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold" style="color: var(--black-primary);">Confirmar Nueva Contraseña</label>
                        <div class="position-relative">
                            <input type="password" id="password_confirmation" class="form-control input-metra pe-5" placeholder="••••••••" minlength="8" required>
                            <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3 text-muted toggle-password" style="cursor: pointer; z-index: 10;"></i>
                        </div>
                    </div>

                    <button type="submit" id="btnSubmit" class="btn-metra-main w-100 py-3 mb-3" style="border-radius: 8px; font-size: 1.05rem;">
                        Actualizar contraseña
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener parametros de la URL
            const urlParams = new URLSearchParams(window.location.search);
            const token = urlParams.get('token');
            const email = urlParams.get('email');

            if (!token || !email) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Enlace inválido',
                    text: 'El enlace de recuperación es incorrecto o le faltan parámetros.',
                    confirmButtonColor: '#382C26'
                }).then(() => {
                    window.location.href = "{{ route('login') }}";
                });
                return;
            }

            document.getElementById('email').value = email;

            // Lógica mostrar/ocultar contraseña
            document.querySelectorAll('.toggle-password').forEach(icon => {
                icon.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    if (input.type === 'password') {
                        input.type = 'text';
                        this.classList.replace('bi-eye-slash', 'bi-eye');
                    } else {
                        input.type = 'password';
                        this.classList.replace('bi-eye', 'bi-eye-slash');
                    }
                });
            });

            // Form submission
            document.getElementById('resetPasswordForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const password = document.getElementById('password').value;
                const password_confirmation = document.getElementById('password_confirmation').value;

                if (password.length < 8) {
                    Swal.fire({ icon: 'warning', title: 'Contraseña corta', text: 'La contraseña debe tener al menos 8 caracteres.', confirmButtonColor: '#382C26' });
                    return;
                }

                if (password !== password_confirmation) {
                    Swal.fire({ icon: 'warning', title: 'No coinciden', text: 'Las contraseñas no coinciden.', confirmButtonColor: '#382C26' });
                    return;
                }

                const btnSubmit = document.getElementById('btnSubmit');
                const originalText = btnSubmit.innerHTML;

                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';

                try {
                    const API_URL = "{{ url('/api') }}";
                    const response = await fetch(`${API_URL}/reset-password`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ 
                            email, 
                            token, 
                            password, 
                            password_confirmation 
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: result.message || 'Su contraseña ha sido actualizada correctamente.',
                            confirmButtonColor: '#382C26'
                        }).then(() => {
                            window.location.href = "{{ route('login') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: result.message || 'Hubo un problema al restablecer la contraseña. El enlace puede haber expirado.',
                            confirmButtonColor: '#382C26'
                        });
                    }
                } catch (error) {
                    console.error('API Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de red',
                        text: 'No se pudo conectar con el servidor.',
                        confirmButtonColor: '#382C26'
                    });
                } finally {
                    btnSubmit.disabled = false;
                    btnSubmit.innerHTML = originalText;
                }
            });
        });
    </script>
</body>
</html>
