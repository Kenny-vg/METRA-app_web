<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>METRA - Reportes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <style>
        .chart-box {
            width: 100%;
            height: 350px;
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #adb5bd;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body class="bg-light">

    <aside class="sidebar">
        <h4 class="fw-bold mb-5">METRA</h4>
        <nav>
            <a href="/admin/dashboard" class="nav-link-admin">Dashboard</a>
            <a href="/admin/mesas" class="nav-link-admin">Gestion del negocio</a>
            <a href="/admin/reservaciones" class="nav-link-admin">Reservaciones</a>
            <a href="#" class="nav-link-admin active">Reportes</a>
            <a href="/admin/perfil" class="nav-link-admin">Perfil</a>
        </nav>
    </aside>

    <main style="margin-left: 250px;" class="p-5">
        <header class="mb-5">
            <h2 class="fw-bold">Reportes y analisis</h2>
            <p class="text-muted">Visualiza tendencias y metricas de tu negocio</p>
        </header>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="metric-card shadow-sm">
                    <small class="text-muted">Reservaciones de hoy</small>
                    <div class="metric-value">10</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card shadow-sm">
                    <small class="text-muted">Mesas ocupadas</small>
                    <div class="metric-value">08</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card shadow-sm">
                    <small class="text-muted">Mesas disponibles</small>
                    <div class="metric-value">13</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card shadow-sm">
                    <small class="text-muted">Proxima reserva</small>
                    <div class="metric-value" style="font-size: 1.8rem;">18:00 pm</div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <button class="btn btn-dark btn-sm rounded-pill px-3 me-2">Semanal</button>
            <button class="btn btn-light btn-sm rounded-pill px-3 border me-2">Mensual</button>
            <button class="btn btn-light btn-sm rounded-pill px-3 border">Por horario</button>
        </div>

        <div class="row g-4">
            <div class="col-md-7">
                <div class="bg-white p-4 rounded-4 border shadow-sm">
                    <h6 class="fw-bold mb-4">Reservas y cancelaciones</h6>
                    <div class="chart-box">
                        <p>Espacio para grafica de barras (Tendencias semanales)</p>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="bg-white p-4 rounded-4 border shadow-sm">
                    <h6 class="fw-bold mb-4">Distribucion por numero de personas</h6>
                    <div class="chart-box">
                        <p>Espacio para grafica de pastel (Segmentacion de clientes)</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>