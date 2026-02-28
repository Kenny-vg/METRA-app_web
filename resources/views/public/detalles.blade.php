<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Información y Reservaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal">

    <nav class="navbar navbar-expand-lg py-3 py-lg-4" style="background: rgba(248,249,250,0.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border-light); position: sticky; top: 0; z-index: 1000;">
        <div class="container">
            <a href="/" class="navbar-brand fw-bold fs-3 text-decoration-none" style="color: var(--black-primary); letter-spacing: -0.5px;">
                <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold); font-size: 1.2rem;"></i>METRA
            </a>
            <div class="ms-auto d-flex align-items-center gap-3">
                <a href="{{ url('/') }}" class="nav-link nav-link-custom d-flex align-items-center gap-1" style="color: var(--text-muted); font-size: 0.9rem;">
                    <i class="bi bi-arrow-left-short fs-5"></i> Volver
                </a>
                <a href="/reservar" class="btn-metra-main px-4 py-2" style="font-size: 0.9rem; border-radius: 6px;">
                    Reservar mesa
                </a>
            </div>
        </div>
    </nav>

    @php
        $cafe = \App\Models\Cafeteria::first();
        $heroImg = $cafe?->foto_url
            ? asset('storage/' . $cafe->foto_url) . '?v=' . ($cafe->updated_at?->timestamp ?? time())
            : 'https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&q=80&w=1600';
    @endphp

    <!-- HERO -->
    <section style="position: relative; height: 480px; overflow: hidden;">
        <img src="{{ $heroImg }}"
             alt="{{ $cafe?->nombre ?? 'Cafetería' }}"
             style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.65) 100%);"></div>
        <div class="container position-absolute bottom-0 start-50 translate-middle-x w-100 pb-5">
            <div class="text-white">
                <span style="display:inline-block; background: rgba(212,175,55,0.2); color: var(--accent-gold); font-size: 0.72rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 5px 14px; border-radius: 50px; margin-bottom: 14px; border: 1px solid rgba(212,175,55,0.4);">
                    <i class="bi bi-cup-hot-fill me-1"></i>Con METRA activo
                </span>
                <h1 class="fw-bold mb-2" style="font-size: clamp(2rem, 5vw, 3.5rem); letter-spacing: -0.5px; line-height: 1.15;">
                    {{ $cafe?->nombre ?? 'Cafetería Central' }}
                </h1>
                <p style="color: rgba(255,255,255,0.75); font-size: 1.1rem; max-width: 560px; margin: 0;">
                    {{ $cafe?->descripcion ?? 'Un espacio diseñado para que disfrutes cada momento.' }}
                </p>
            </div>
        </div>
    </section>

    <!-- CONTENIDO PRINCIPAL -->

    <main class="container py-5">
        <div class="row g-5">

            <!-- Columna izquierda -->
            <div class="col-12 col-lg-7">

                @if($cafe && $cafe->calle)
                <div class="d-flex align-items-center gap-2 mb-5" style="color: var(--text-muted);">
                    <i class="bi bi-geo-alt-fill" style="color: var(--accent-gold);"></i>
                    <span>{{ $cafe->calle }}{{ $cafe->num_exterior ? ' '.$cafe->num_exterior : '' }}{{ $cafe->colonia ? ', '.$cafe->colonia : '' }}</span>
                </div>
                @endif

                <!-- PROMOCIONES -->
                <section class="mb-5" id="sectionPromociones">
                    <div class="d-flex align-items-baseline justify-content-between mb-4">
                        <h4 class="fw-bold mb-0" style="color: var(--black-primary); letter-spacing: -0.3px;">Promociones y Eventos</h4>
                        <span class="small text-muted">Oportunidades especiales</span>
                    </div>
                    <div class="row g-3" id="promos-publicas">
                        {{-- Datos demo hasta integración con backend --}}
                        <div class="col-12 col-sm-6">
                            <div class="p-4 rounded-4 bg-white border h-100" style="border-color: var(--border-light) !important;">
                                <div class="mb-3">
                                    <span class="fs-3">🎂</span>
                                    <span class="badge rounded-pill ms-2" style="background: rgba(212,175,55,0.12); color: var(--accent-gold); border: 1px solid rgba(212,175,55,0.3); font-size: 0.7rem;">Disponible</span>
                                </div>
                                <h6 class="fw-bold mb-2">Cumpleaños Especial</h6>
                                <p class="text-muted small mb-0">Celebra tu día con nosotros. Mesa decorada y postre de cortesía para el festejado. Previa reservación.</p>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="p-4 rounded-4 bg-white border h-100" style="border-color: var(--border-light) !important;">
                                <div class="mb-3">
                                    <span class="fs-3">💍</span>
                                    <span class="badge rounded-pill ms-2" style="background: rgba(212,175,55,0.12); color: var(--accent-gold); border: 1px solid rgba(212,175,55,0.3); font-size: 0.7rem;">Disponible</span>
                                </div>
                                <h6 class="fw-bold mb-2">Tarde de Aniversario</h6>
                                <p class="text-muted small mb-0">Mesa reservada con ambiente especial para celebrar su aniversario. Previa reservación.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- MENÚ DESTACADO -->
                <section class="mb-5">
                    <div class="d-flex align-items-baseline justify-content-between mb-4">
                        <h4 class="fw-bold mb-0" style="color: var(--black-primary); letter-spacing: -0.3px;">Menú Destacado</h4>
                        <span class="small text-muted">Lo más pedido</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-6 col-md-3 text-center">
                            <img src="https://images.unsplash.com/photo-1541167760496-1628856ab772?w=300&q=80"
                                 class="img-fluid shadow-sm rounded-3 mb-3 w-100" style="height: 120px; object-fit: cover;" alt="Café">
                            <p class="small fw-bold mb-0">Flat White</p>
                            <p class="text-muted" style="font-size: 0.75rem;">Café de especialidad</p>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <img src="https://images.unsplash.com/photo-1550461716-bf5ce596f280?w=300&q=80"
                                 class="img-fluid shadow-sm rounded-3 mb-3 w-100" style="height: 120px; object-fit: cover;" alt="Brunch">
                            <p class="small fw-bold mb-0">Brunch del Día</p>
                            <p class="text-muted" style="font-size: 0.75rem;">Desayuno completo</p>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=300&q=80"
                                 class="img-fluid shadow-sm rounded-3 mb-3 w-100" style="height: 120px; object-fit: cover;" alt="Bowl">
                            <p class="small fw-bold mb-0">Bowl Orgánico</p>
                            <p class="text-muted" style="font-size: 0.75rem;">Opción saludable</p>
                        </div>
                        <div class="col-6 col-md-3 text-center">
                            <img src="https://images.unsplash.com/photo-1544145945-f90425340c7e?w=300&q=80"
                                 class="img-fluid shadow-sm rounded-3 mb-3 w-100" style="height: 120px; object-fit: cover;" alt="Matcha">
                            <p class="small fw-bold mb-0">Matcha Latte</p>
                            <p class="text-muted" style="font-size: 0.75rem;">Frío o caliente</p>
                        </div>
                    </div>
                </section>

                <!-- IMAGEN PRINCIPAL DEL NEGOCIO -->
                <section class="mb-5">
                    <div class="d-flex align-items-baseline justify-content-between mb-4">
                        <h4 class="fw-bold mb-0" style="color: var(--black-primary); letter-spacing: -0.3px;">El espacio</h4>
                    </div>
                    @if($cafe?->foto_url)
                        <img src="{{ asset('storage/' . $cafe->foto_url) }}?v={{ $cafe->updated_at?->timestamp }}"
                             alt="{{ $cafe->nombre }}"
                             class="img-fluid rounded-4 shadow-sm w-100" style="height: 280px; object-fit: cover;">
                    @else
                        <div class="rounded-4 d-flex align-items-center justify-content-center" style="height: 280px; background: var(--off-white); border: 1px dashed var(--border-light);">
                            <div class="text-center text-muted">
                                <i class="bi bi-image display-4 d-block mb-2" style="opacity: 0.3;"></i>
                                <small>El gerente aún no ha subido imagen del negocio.</small>
                            </div>
                        </div>
                    @endif
                </section>

            </div>

            <!-- Sidebar reserva -->
            <div class="col-12 col-lg-5">
                <div class="sticky-top" style="top: 100px;">
                    <div class="bg-white rounded-4 shadow p-4 p-lg-5 border" style="border-color: var(--border-light) !important;">

                        <div class="text-center mb-4">
                            <span style="display:inline-block; background: rgba(212,175,55,0.1); color: var(--accent-gold); font-size: 0.72rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; padding: 5px 14px; border-radius: 50px; border: 1px solid rgba(212,175,55,0.3);">
                                Sistema de Reservas METRA
                            </span>
                            <h4 class="fw-bold mt-3 mb-1" style="color: var(--black-primary);">Hacer una reservación</h4>
                            <p class="text-muted small mb-0">Elige tu horario y asegura tu lugar.</p>
                        </div>

                        <a href="/reservar" class="btn-metra-main w-100 d-flex align-items-center justify-content-center py-3 mb-4" style="border-radius: 12px; font-size: 1rem;">
                            <i class="bi bi-calendar3 me-2"></i>Continuar con la reserva
                        </a>

                        <hr style="opacity: 0.08;">

                        <!-- Info rápida -->
                        <div class="d-flex flex-column gap-3 my-3">
                            @if($cafe && $cafe->calle)
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 36px; height: 36px; background: var(--off-white); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="bi bi-geo-alt-fill" style="color: var(--accent-gold);"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold small">Ubicación</p>
                                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">{{ $cafe->calle }}{{ $cafe->num_exterior ? ' '.$cafe->num_exterior : '' }}{{ $cafe->colonia ? ', '.$cafe->colonia : '' }}</p>
                                </div>
                            </div>
                            @endif
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 36px; height: 36px; background: var(--off-white); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="bi bi-clock-fill" style="color: var(--accent-gold);"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold small">Tolerancia de llegada</p>
                                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">15 minutos después del horario reservado.</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 36px; height: 36px; background: var(--off-white); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="bi bi-envelope-fill" style="color: var(--accent-gold);"></i>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold small">Confirmación</p>
                                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">Recibirás la confirmación al correo registrado.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Disponibilidad de horarios -->
                        <hr style="opacity: 0.08;">
                        <p class="small fw-bold text-uppercase mb-3" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.72rem;">Horarios disponibles hoy</p>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge rounded-pill px-3 py-2" style="background: var(--off-white); color: var(--black-primary); border: 1px solid var(--border-light); font-weight: 600; font-size: 0.8rem;">08:30 AM</span>
                            <span class="badge rounded-pill px-3 py-2" style="background: var(--off-white); color: var(--black-primary); border: 1px solid var(--border-light); font-weight: 600; font-size: 0.8rem;">09:00 AM</span>
                            <span class="badge rounded-pill px-3 py-2" style="background: var(--off-white); color: var(--black-primary); border: 1px solid var(--border-light); font-weight: 600; font-size: 0.8rem;">11:30 AM</span>
                            <span class="badge rounded-pill px-3 py-2" style="background: var(--off-white); color: var(--black-primary); border: 1px solid var(--border-light); font-weight: 600; font-size: 0.8rem;">01:00 PM</span>
                            <span class="badge rounded-pill px-3 py-2" style="background: var(--off-white); color: var(--black-primary); border: 1px solid var(--border-light); font-weight: 600; font-size: 0.8rem;">04:30 PM</span>
                            <span class="badge rounded-pill px-3 py-2" style="background: var(--off-white); color: var(--black-primary); border: 1px solid var(--border-light); font-weight: 600; font-size: 0.8rem;">07:00 PM</span>
                        </div>
                        <small class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-info-circle me-1"></i>Disponibilidad sujeta a cambios. Confirma al reservar.</small>

                        <div class="mt-4 p-3 rounded-3" style="background: var(--off-white); border: 1px solid var(--border-light);">
                            <p class="small mb-0" style="color: var(--text-muted);">
                                <i class="bi bi-shield-check-fill me-2" style="color: var(--accent-gold);"></i>
                                Las reservaciones son gestionadas por el staff del negocio vía METRA.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>