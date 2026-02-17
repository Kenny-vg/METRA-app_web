<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Finalizar Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal">

    <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1200" class="header-image">

    <main class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                
                <div class="reserva-card">
                    <div class="text-center mb-5">
                        <h1 class="fw-bold">¡Casi terminas tu reserva!</h1>
                        <div class="mb-4">
                            <a href="javascript:history.back()" class="btn-volver-chic">
                                <i class="bi bi-chevron-left"></i> Regresar a detalles
                            </a>
                        </div>
                    </div>

                    <form action="/confirmacion">
                        <div class="row mb-5">
                            <div class="col-12"><h5 class="section-title mb-4">1. Detalles de la mesa</h5></div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="fw-bold mb-2"><i class="bi bi-calendar3 me-2"></i> Fecha</label>
                                <input type="date" class="form-control input-metra" value="2026-01-30">
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="fw-bold mb-2"><i class="bi bi-clock me-2"></i> Hora</label>
                                <select class="form-select input-metra">
                                    <option>08:30 PM</option>
                                    <option>09:00 PM</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="fw-bold mb-2"><i class="bi bi-people me-2"></i> Personas</label>
                                <input type="number" class="form-control input-metra" value="2">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-12"><h5 class="section-title mb-4">2. Información del contacto</h5></div>
                            <div class="col-12 col-md-4 mb-3">
                                <input type="text" class="form-control input-metra" placeholder="Nombre(s)">
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <input type="text" class="form-control input-metra" placeholder="Apellido Paterno">
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <input type="text" class="form-control input-metra" placeholder="Apellido Materno">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <input type="email" class="form-control input-metra" placeholder="tu@correo.com">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <input type="tel" class="form-control input-metra" placeholder="Teléfono de contacto">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-12"><h5 class="section-title mb-4">3. Preferencias y Ocasión</h5></div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="small fw-bold mb-2">¿Alguna ocasión especial?</label>
                                <select class="form-select input-metra">
                                    <option>Ninguna</option>
                                    <option>Aniversario</option>
                                    <option>Cumpleaños</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="small fw-bold mb-2">Zona preferida</label>
                                <select class="form-select input-metra">
                                    <option>Interior (No fumadores)</option>
                                    <option>Terraza / Balcón</option>
                                    <option>Zona Fumadores</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control input-metra" rows="3" placeholder="Comentarios adicionales (alergias, notas...)"></textarea>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn-metra-main px-5 py-3 border-0" style="background-color: #FFAB40; border-radius: 50px; font-weight: bold; color: #4E342E;">
                                Confirmar Reservación →
                            </button>
                        </div>
                    </form>
                    <div class="mt-5 p-3" style="background-color: #fcfaf8; border-radius: 12px; border: 1px dashed #e0d7d0;">
                        <div class="row text-center">
                            <div class="col-4">
                                <i class="bi bi-shield-check d-block mb-2" style="font-size: 1.5rem; color: var(--ambar);"></i>
                                <span style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Reserva Segura</span>
                            </div>
                            <div class="col-4">
                                <i class="bi bi-lightning-charge d-block mb-2" style="font-size: 1.5rem; color: var(--ambar);"></i>
                                <span style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Confirmación Inmediata</span>
                            </div>
                            <div class="col-4">
                                <i class="bi bi-bell d-block mb-2" style="font-size: 1.5rem; color: var(--ambar);"></i>
                                <span style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Recordatorio vía Email</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('partials.footer')

</body>
</html>