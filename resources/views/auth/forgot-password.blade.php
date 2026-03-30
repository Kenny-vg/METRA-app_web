<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Olvidé mi contraseña</title>
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
                <h4 class="fw-bold mb-2" style="color: var(--black-primary); font-family: 'Inter', sans-serif;">Recuperar acceso</h4>
                <p style="color: var(--text-muted);">Ingrese su correo electrónico y le enviaremos un enlace para restablecer su contraseña.</p>
            </div>

            <div class="bg-white p-5 rounded-4 shadow-sm border" style="border-radius: 20px;">
                <form id="forgotPasswordForm">
                    <div class="mb-4">
                        <label class="form-label small fw-bold" style="color: var(--black-primary);">Correo Electrónico</label>
                        <input type="email" id="email" class="form-control input-metra" placeholder="nombre@correo.com" required autofocus>
                    </div>

                    <button type="submit" id="btnSubmit" class="btn-metra-main w-100 py-3 mb-3" style="border-radius: 8px; font-size: 1.05rem;">
                        Enviar enlace de recuperación
                    </button>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="small text-muted text-decoration-none fw-bold">
                            <i class="bi bi-arrow-left me-1"></i> Volver al inicio de sesión
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('forgotPasswordForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value.trim();
            const btnSubmit = document.getElementById('btnSubmit');
            const originalText = btnSubmit.innerHTML;

            // UI Feedback
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';

            try {
                const result = await MetraAPI.post('/forgot-password', { email });

                Swal.fire({
                    icon: 'success',
                    title: 'Enviado',
                    text: result.message || 'Si el correo existe, se enviará un enlace de recuperación.',
                    confirmButtonColor: '#382C26',
                    confirmButtonText: 'Entendido'
                }).then(() => {
                    window.location.href = "{{ route('login') }}";
                });
            } catch (error) {
                const errData = error.data || error;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errData.message || 'Ocurrió un problema al procesar su solicitud.',
                    confirmButtonColor: '#382C26'
                });
            } finally {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = originalText;
            }
        });
    </script>
</body>
</html>
