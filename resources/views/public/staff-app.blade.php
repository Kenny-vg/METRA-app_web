<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Acceso Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <script>
        window.APP_API_URL = window.location.origin;
    </script>
</head>
<body style="background: var(--off-white); min-height: 100vh; display: flex; align-items: center; justify-content: center;">

<div class="container text-center px-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="bg-white p-5 rounded-4 shadow-sm text-center" style="border: 1px solid var(--border-light);">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 80px; height: 80px; background: rgba(212, 175, 55, 0.1); color: var(--accent-gold);">
                        <i class="bi bi-phone" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
                
                <h3 class="fw-bold mb-3" style="color: var(--black-primary); letter-spacing: -0.5px;">Acceso Restringido</h3>
                
                <p class="text-muted mb-4 fs-5" style="line-height: 1.6;">
                    El personal opera exclusivamente desde la <strong>App móvil METRA</strong>. Por favor, descarga la aplicación para acceder a tu panel de trabajo.
                </p>

                <div class="d-grid gap-3 mt-4">
                    <a href="#" class="btn btn-dark fw-bold rounded-pill p-3 d-flex align-items-center justify-content-center" style="background: var(--black-primary); font-size: 1.05rem;">
                        <i class="bi bi-google-play fs-4 me-2"></i> Descargar para Android
                    </a>
                </div>

                <!-- TEST ENPOINTS PANEL -->
                <div class="mt-5 border-top pt-4 text-start">
                    <h5 class="fw-bold"><i class="bi bi-bug me-2"></i>Testing API Staff</h5>
                    <p class="small text-muted mb-3">Verifica que los endpoints exclusivos de staff respondan correctamente con el token actual.</p>
                    
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <button class="btn btn-sm btn-outline-primary fw-bold" onclick="testEndpoint('/mesas')">GET /mesas</button>
                        <button class="btn btn-sm btn-outline-success fw-bold" onclick="testEndpoint('/zonas')">GET /zonas</button>
                        <button class="btn btn-sm btn-outline-danger fw-bold" onclick="testEndpoint('/promociones')">GET /promociones</button>
                        <button class="btn btn-sm btn-outline-warning fw-bold text-dark" onclick="testEndpoint('/horarios')">GET /horarios</button>
                    </div>

                    <pre id="api-result" class="bg-light p-3 rounded border text-start" style="font-size:0.75rem; max-height:200px; overflow-y:auto; color:#d63384;">Esperando acción...</pre>
                </div>

                <div class="mt-5 border-top pt-4">
                    <a href="#" onclick="logout()" class="text-decoration-none fw-semibold" style="color: var(--text-muted);">
                        <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const API_URL = '/api/staff';
    const token = localStorage.getItem('token');

    if(!token) {
        document.getElementById('api-result').textContent = 'Error: No hay token Sanctum en localStorage.';
    }

    async function testEndpoint(endpoint) {
        const resEl = document.getElementById('api-result');
        resEl.textContent = `Petición a ${API_URL}${endpoint}...`;
        try {
            const res = await fetch(`${API_URL}${endpoint}`, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const data = await res.json();
            resEl.textContent = `Status: ${res.status}\n\n` + JSON.stringify(data, null, 2);
        } catch (error) {
            resEl.textContent = `Error de red: ${error.message}`;
        }
    }

    function logout() {
        localStorage.clear();
        sessionStorage.clear();
        window.location.href = '/logout';
    }
</script>
</body>
</html>
