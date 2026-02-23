<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal">

    <main class="login-container">
        <div class="login-card text-center" style="border-top: 5px solid var(--ambar);">
            
            <span class="login-logo">METRA</span>
            <h5 class="fw-bold mb-4" style="color: #6D4C41;">Bienvenido de nuevo</h5>
            
            <p class="text-muted small mb-5">Ingresa </p>
@if ($errors->any())
    <div class="alert alert-danger small p-2">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <form id="loginForm" action="{{ route('login') }}" method="POST">
    @csrf <div class="text-start mb-4">
        <label class="form-label small fw-bold" style="color: #4E342E;">Correo Electrónico</label>
        <input type="email" name="email" class="form-control input-metra" placeholder="tu@correo.com" required>
    </div>

    <div class="text-start mb-4">
        <label class="form-label small fw-bold" style="color: #4E342E;">Contraseña</label>
        <input type="password" name="password" class="form-control input-metra" placeholder="••••••••" required>
    </div>

    <button type="submit" class="btn-metra-main w-100 rounded-3">
        Iniciar Sesión
    </button>
    
    <div class="my-4 d-flex align-items-center">
        <hr class="flex-grow-1 opacity-25">
        <span class="mx-3 small text-muted">o continúa con</span>
        <hr class="flex-grow-1 opacity-25">
    </div>

    <a href="#" class="btn btn-outline-dark w-100 rounded-pill py-2 shadow-sm">
        <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" width="20" class="me-2">
         Google
    </a>
</form>

            <div class="mt-5">
                 <a href="{{ route('register') }}" class="text-muted small text-decoration-none">
                     ¿No tienes cuenta? <span class="fw-bold text-dark">Regístrate</span>
                 </a>
            </div>
        </div>
    </main>
 @include('partials.footer')


    <script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');

    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            // Detenemos el envío para intentar hablar con la API primero
            e.preventDefault(); 

            // 1. Limpieza segura: si el navegador lo bloquea, no pasa nada, seguimos
            try {
                localStorage.clear();
            } catch (err) {
                console.warn("Storage bloqueado por el navegador");
            }

            const email = loginForm.querySelector('input[name="email"]').value;
            const password = loginForm.querySelector('input[name="password"]').value;

            try {
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email, password })
                });

                if (response.ok) {
                    const result = await response.json();
                    try {
                        localStorage.setItem('token', result.token);
                    } catch (storageErr) {
                        // Si no nos deja guardar el token, no importa, mandamos el form para la sesión
                    }
                    // IMPORTANTE: Enviamos el formulario "de verdad" para que Laravel cree la sesión
                    loginForm.submit(); 
                } else {
                    const errorData = await response.json();
                    alert('Error: ' + (errorData.message || 'Credenciales incorrectas'));
                }
            } catch (error) {
                console.error('Error de API, intentando login tradicional...', error);
                // Si la API falla o el navegador bloquea el fetch, enviamos el form normal
                loginForm.submit();
            }
        });
    }
});
</script>

</body>
</html>
