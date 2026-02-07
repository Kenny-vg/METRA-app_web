<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>METRA - Finalizar Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilos.css?v=' . time()) }}">
<body>

    <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1200" class="header-image">

    <main class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <div class="reserva-card">
                    <div class="text-center mb-5">
                        <h1 class="fw-bold">¡Casi terminas tu reserva!</h1>
                    </div>

                    <form action="/confirmacion">
                        <div class="row mb-5">
                            <div class="col-12"><h5 class="section-title mb-4">1. Detalles de la mesa</h5></div>
                            <div class="col-md-4 mb-3">
                                <label class="small fw-bold mb-2">Fecha</label>
                                <input type="date" class="form-control input-metra" value="2026-01-30">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small fw-bold mb-2">Hora</label>
                                <select class="form-select input-metra">
                                    <option>08:30 PM</option>
                                    <option>09:00 PM</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small fw-bold mb-2">Personas</label>
                                <input type="number" class="form-control input-metra" value="2">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-12"><h5 class="section-title mb-4">2. Información del contacto</h5></div>
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control input-metra" placeholder="Nombre(s)">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control input-metra" placeholder="Apellido Paterno">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control input-metra" placeholder="Apellido Materno">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="email" class="form-control input-metra" placeholder="tu@correo.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="tel" class="form-control input-metra" placeholder="Teléfono de contacto">
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-12"><h5 class="section-title mb-4">3. Preferencias y Ocasión</h5></div>
                            <div class="col-md-6 mb-3">
                                <label class="small fw-bold mb-2">¿Alguna ocasión especial?</label>
                                <select class="form-select input-metra">
                                    <option>Ninguna</option>
                                    <option>Aniversario</option>
                                    <option>Cumpleaños</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
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
                </div>
            </div>
        </div>
    </main>

</body>
</html>