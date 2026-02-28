<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Sistema de Reservas para tu Negocio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="zona-comensal">

    <nav class="navbar navbar-expand-lg py-3 py-lg-4" style="background: rgba(248, 249, 250, 0.95); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border-light); position: sticky; top: 0; z-index: 1000;">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="/" style="color: var(--black-primary); letter-spacing: -0.5px;">
                <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold); font-size: 1.2rem;"></i>METRA
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navBienvenida">
                <i class="bi bi-list fs-2" style="color: var(--black-primary);"></i>
            </button>
            <div class="collapse navbar-collapse" id="navBienvenida">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-2 gap-lg-4 mt-3 mt-lg-0">
                    <li class="nav-item"><a href="#como-funciona" class="nav-link nav-link-custom">Cómo funciona</a></li>
                    <li class="nav-item"><a href="#para-clientes" class="nav-link nav-link-custom">Para clientes</a></li>
                    <li class="nav-item"><a href="#app-staff" class="nav-link nav-link-custom">App Staff</a></li>
                    <li class="nav-item"><a href="/login" class="nav-link nav-link-custom fw-bold">Acceso Gerentes</a></li>
                    <li class="nav-item">
                        <a href="#para-negocios" class="btn-metra-main px-4 py-2" style="font-size: 0.9rem; border-radius: 6px;">Contratar METRA</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO — orientado a gerentes/dueños -->
    <main class="hero-container" style="background: linear-gradient(180deg, var(--off-white) 0%, #FFFFFF 100%);">
        <div class="container py-5">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6 text-center text-lg-start pe-lg-5">
                    <span style="display:inline-block; background: rgba(0,0,0,0.04); color: var(--text-muted); font-size: 0.8rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 6px 16px; border-radius: 50px; margin-bottom: 24px; border: 1px solid var(--border-light);">
                        Sistema SaaS de reservas para cafeterías y restaurantes
                    </span>
                    <h1 class="hero-title" style="font-family: 'Inter', sans-serif;">
                        Digitaliza las reservas<br>
                        <span style="color: var(--accent-gold);">de tu negocio.</span>
                    </h1>
                    <p class="fs-5 mb-5" style="color: var(--text-muted); max-width: 520px; font-weight: 400; line-height: 1.6;">
                        METRA es el sistema de gestión de reservas que tu cafetería o restaurante necesita. Sin listas físicas, sin llamadas, sin caos.
                    </p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                        <a href="#para-negocios" class="btn-metra-main" style="padding: 16px 36px; font-size: 1.05rem;">
                            Contratar el servicio <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="#como-funciona" class="btn btn-outline-dark rounded-pill" style="padding: 16px 36px; font-size: 1.05rem; font-weight: 600;">
                            Cómo funciona <i class="bi bi-play-circle ms-2"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="image-wrapper text-center position-relative">
                        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                             class="img-restaurante img-fluid shadow-lg" alt="Interior de cafetería con METRA"
                             style="max-width: 100%; height: auto; border-radius: 12px; object-fit: cover; aspect-ratio: 4/3; position: relative; z-index: 2;">
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- CÓMO FUNCIONA EL ECOSISTEMA -->
    <section id="como-funciona" style="background: #f8f9fa; padding: 70px 0; border-top: 1px solid var(--border-light); border-bottom: 1px solid var(--border-light);">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: var(--black-primary); font-size: clamp(1.5rem, 3vw, 2.2rem);">El ecosistema METRA</h2>
                <p class="text-muted mx-auto" style="max-width: 560px;">
                    Un negocio contrata el servicio. Sus clientes reservan dentro de su sistema. El staff opera con la app. Así de directo.
                </p>
            </div>

            <!-- Flujo visual -->
            <div class="row g-0 align-items-center justify-content-center mb-5 text-center d-none d-md-flex">
                <div class="col-auto">
                    <div class="rounded-4 p-3 bg-white shadow-sm border" style="min-width: 160px;">
                        <i class="bi bi-building" style="font-size: 2rem; color: var(--black-primary);"></i>
                        <p class="fw-bold mb-0 small mt-2">Dueño / Gerente</p>
                        <p class="text-muted mb-0" style="font-size: 0.72rem;">Contrata METRA</p>
                    </div>
                </div>
                <div class="col-auto px-2"><i class="bi bi-arrow-right text-muted fs-4"></i></div>
                <div class="col-auto">
                    <div class="rounded-4 p-3 bg-white shadow-sm border" style="min-width: 160px;">
                        <i class="bi bi-gear-fill" style="font-size: 2rem; color: var(--accent-gold);"></i>
                        <p class="fw-bold mb-0 small mt-2">Activación</p>
                        <p class="text-muted mb-0" style="font-size: 0.72rem;">El equipo METRA valida</p>
                    </div>
                </div>
                <div class="col-auto px-2"><i class="bi bi-arrow-right text-muted fs-4"></i></div>
                <div class="col-auto">
                    <div class="rounded-4 p-3 bg-white shadow-sm border" style="min-width: 160px;">
                        <i class="bi bi-person-check-fill" style="font-size: 2rem; color: #198754;"></i>
                        <p class="fw-bold mb-0 small mt-2">Clientes reservan</p>
                        <p class="text-muted mb-0" style="font-size: 0.72rem;">En el sistema del negocio</p>
                    </div>
                </div>
                <div class="col-auto px-2"><i class="bi bi-arrow-right text-muted fs-4"></i></div>
                <div class="col-auto">
                    <div class="rounded-4 p-3 bg-white shadow-sm border" style="min-width: 160px;">
                        <i class="bi bi-phone-fill" style="font-size: 2rem; color: #6c757d;"></i>
                        <p class="fw-bold mb-0 small mt-2">Staff opera</p>
                        <p class="text-muted mb-0" style="font-size: 0.72rem;">Con la app Android</p>
                    </div>
                </div>
            </div>

            <!-- Cards de beneficios -->
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100" style="border-left: 4px solid var(--accent-gold) !important;">
                        <i class="bi bi-calendar2-check-fill mb-3" style="font-size: 2rem; color: var(--accent-gold);"></i>
                        <h6 class="fw-bold mb-2">Reservas digitales para tu negocio</h6>
                        <p class="text-muted small mb-0">Tus clientes reservan desde el sistema de tu cafetería. Sin llamadas, sin listas físicas, sin errores de doble reserva.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100" style="border-left: 4px solid var(--black-primary) !important;">
                        <i class="bi bi-speedometer2 mb-3" style="font-size: 2rem; color: var(--black-primary);"></i>
                        <h6 class="fw-bold mb-2">Panel de control completo</h6>
                        <p class="text-muted small mb-0">El gerente gestiona horarios, mesas, clientes y suscripción desde un panel web claro y profesional.</p>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100" style="border-left: 4px solid #6c757d !important;">
                        <i class="bi bi-phone-fill mb-3" style="font-size: 2rem; color: #6c757d;"></i>
                        <h6 class="fw-bold mb-2">App móvil para el staff</h6>
                        <p class="text-muted small mb-0">El personal interno opera el día a día desde la app Android de METRA: reservas activas, ocupaciones y flujo diario.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CÓMO FUNCIONA PARA CLIENTES (informativo, no acción pública) -->
    <section id="para-clientes" style="background: #FFFFFF; padding: 90px 0;">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?auto=format&fit=crop&q=80&w=900"
                         alt="Clientes disfrutando en la cafetería"
                         style="width: 100%; border-radius: 16px; object-fit: cover; aspect-ratio: 4/3; box-shadow: 0 20px 60px rgba(0,0,0,0.1);">
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <span style="display:inline-block; background: rgba(212,175,55,0.1); color: var(--accent-gold); font-size: 0.75rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 6px 18px; border-radius: 50px; margin-bottom: 20px; border: 1px solid rgba(212,175,55,0.3);">
                        Experiencia del cliente final
                    </span>
                    <h2 class="fw-bold mb-4" style="color: var(--black-primary); font-size: clamp(1.8rem, 3vw, 2.6rem); line-height: 1.2;">
                        Tus clientes reservan <span style="color: var(--accent-gold);">sin complicaciones</span>
                    </h2>
                    <p style="color: var(--text-muted); font-size: 1.1rem; line-height: 1.7; margin-bottom: 32px;">
                        Una vez que tu cafetería usa METRA, tus clientes acceden al sistema <strong>de tu negocio</strong> para reservar su mesa de forma digital. Sin llamadas, sin papelería.
                    </p>
                    <div class="d-flex flex-column gap-3 mb-5">
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-calendar2-plus-fill" style="color: var(--accent-gold); font-size: 1.3rem; margin-top: 2px;"></i>
                            <div><strong>Eligen fecha y hora disponible</strong><br><small class="text-muted">El sistema muestra disponibilidad real del negocio.</small></div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-check2-circle" style="color: var(--accent-gold); font-size: 1.3rem; margin-top: 2px;"></i>
                            <div><strong>Confirman su reserva</strong><br><small class="text-muted">Reciben confirmación inmediata dentro del sistema.</small></div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <i class="bi bi-door-open-fill" style="color: var(--accent-gold); font-size: 1.3rem; margin-top: 2px;"></i>
                            <div><strong>Llegan y el staff los espera</strong><br><small class="text-muted">Sin esperas en puerta. El equipo ya conoce su reservación.</small></div>
                        </div>
                    </div>
                    <a href="#para-negocios" class="btn btn-outline-dark rounded-pill px-5 py-3 fw-bold">
                        <i class="bi bi-shop me-2"></i>Contratar METRA para mi negocio
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- B2B — CONTRATACIÓN -->
    <section id="para-negocios" style="background: linear-gradient(135deg, var(--black-primary), var(--gray-dark)); padding: 90px 0; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -100px; right: -50px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(212,175,55,0.08) 0%, transparent 60%); border-radius: 50%;"></div>
        <div class="container position-relative" style="z-index: 1;">
            <div class="text-center mb-5">
                <span style="display:inline-block; background: rgba(212,175,55,0.15); color: var(--accent-gold); font-size: 0.75rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 6px 18px; border-radius: 50px; margin-bottom: 16px; border: 1px solid rgba(212,175,55,0.3);">
                    Contratación del Servicio
                </span>
                <h2 style="color: #fff; font-size: clamp(1.8rem, 3.5vw, 3rem); font-weight: 800; line-height: 1.2; margin-bottom: 16px;">
                    Lleva las reservas de tu negocio <span style="color: var(--accent-gold);">al siguiente nivel</span>
                </h2>
                <p style="color: rgba(255,255,255,0.65); font-size: 1.05rem; max-width: 580px; margin: 0 auto;">
                    El proceso es simple: regístrate, elige tu plan y nuestro equipo activa tu cuenta en cuanto valide tu solicitud.
                </p>
            </div>
            <div class="row g-4 mb-5">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="d-flex align-items-start gap-3 p-4 rounded-4" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                        <i class="bi bi-1-circle-fill" style="color: var(--accent-gold); font-size: 1.8rem; flex-shrink: 0;"></i>
                        <div>
                            <p class="fw-bold text-white mb-1">Registra tu negocio</p>
                            <p class="small mb-0" style="color: rgba(255,255,255,0.5);">Llena los datos de tu cafetería en el formulario.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="d-flex align-items-start gap-3 p-4 rounded-4" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                        <i class="bi bi-2-circle-fill" style="color: var(--accent-gold); font-size: 1.8rem; flex-shrink: 0;"></i>
                        <div>
                            <p class="fw-bold text-white mb-1">Elige tu plan</p>
                            <p class="small mb-0" style="color: rgba(255,255,255,0.5);">Selecciona el plan que mejor se ajuste a tu operación.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="d-flex align-items-start gap-3 p-4 rounded-4" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                        <i class="bi bi-3-circle-fill" style="color: var(--accent-gold); font-size: 1.8rem; flex-shrink: 0;"></i>
                        <div>
                            <p class="fw-bold text-white mb-1">Envía tu comprobante</p>
                            <p class="small mb-0" style="color: rgba(255,255,255,0.5);">Sube el comprobante de pago para iniciar la revisión.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="d-flex align-items-start gap-3 p-4 rounded-4" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                        <i class="bi bi-4-circle-fill" style="color: var(--accent-gold); font-size: 1.8rem; flex-shrink: 0;"></i>
                        <div>
                            <p class="fw-bold text-white mb-1">Validación y acceso</p>
                            <p class="small mb-0" style="color: rgba(255,255,255,0.5);">Nuestro equipo revisa tu solicitud y activa tu cuenta manualmente.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="/registro-negocio" class="btn-metra-main" style="padding: 18px 50px; font-size: 1.1rem; border-radius: 50px; box-shadow: 0 10px 30px rgba(212,175,55,0.3);">
                    <i class="bi bi-rocket-takeoff me-2"></i>Registrar mi Negocio
                </a>
                <p style="color: rgba(255,255,255,0.35); font-size: 0.85rem; margin-top: 14px; margin-bottom: 0;">
                    La activación es manual y toma entre 24 y 48 horas hábiles.
                </p>
            </div>
        </div>
    </section>

    <!-- APP STAFF -->
    <section id="app-staff" style="background: #f8f9fa; padding: 90px 0; border-top: 1px solid var(--border-light);">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6 pe-lg-5">
                    <span style="display:inline-block; background: rgba(108,117,125,0.1); color: #6c757d; font-size: 0.75rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 6px 18px; border-radius: 50px; margin-bottom: 20px; border: 1px solid rgba(108,117,125,0.2);">
                        App Android &middot; Herramienta Interna del Staff
                    </span>
                    <h2 class="fw-bold mb-4" style="color: var(--black-primary); font-size: clamp(1.8rem, 3vw, 2.6rem); line-height: 1.2;">
                        El staff opera desde su celular
                    </h2>
                    <p style="color: var(--text-muted); font-size: 1.05rem; line-height: 1.7; margin-bottom: 32px;">
                        La app móvil de METRA es una herramienta de uso interno exclusiva para el personal del negocio. Permite al equipo gestionar el flujo diario de reservas y ocupaciones desde su Android.
                    </p>
                    <div class="row g-3 mb-5">
                        <div class="col-12 col-sm-6">
                            <div class="d-flex align-items-start gap-3 p-3 bg-white rounded-3 shadow-sm border">
                                <i class="bi bi-list-check text-primary" style="font-size: 1.4rem; flex-shrink: 0;"></i>
                                <div>
                                    <p class="fw-bold mb-0 small">Ver reservaciones activas</p>
                                    <p class="text-muted mb-0" style="font-size: 0.78rem;">Consulta las reservas del día en tiempo real.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="d-flex align-items-start gap-3 p-3 bg-white rounded-3 shadow-sm border">
                                <i class="bi bi-layout-three-columns text-success" style="font-size: 1.4rem; flex-shrink: 0;"></i>
                                <div>
                                    <p class="fw-bold mb-0 small">Gestionar ocupaciones</p>
                                    <p class="text-muted mb-0" style="font-size: 0.78rem;">Registra y actualiza el estado de mesas y espacios.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="d-flex align-items-start gap-3 p-3 bg-white rounded-3 shadow-sm border">
                                <i class="bi bi-person-workspace text-warning" style="font-size: 1.4rem; flex-shrink: 0;"></i>
                                <div>
                                    <p class="fw-bold mb-0 small">Apoyo operativo al equipo</p>
                                    <p class="text-muted mb-0" style="font-size: 0.78rem;">El personal coordina mejor con información en mano.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="d-flex align-items-start gap-3 p-3 bg-white rounded-3 shadow-sm border">
                                <i class="bi bi-calendar-week text-danger" style="font-size: 1.4rem; flex-shrink: 0;"></i>
                                <div>
                                    <p class="fw-bold mb-0 small">Control del flujo diario</p>
                                    <p class="text-muted mb-0" style="font-size: 0.78rem;">Vista organizada de todo lo que pasa en el negocio.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-dark rounded-pill d-inline-flex align-items-center gap-3 px-5 py-3 shadow" style="font-size: 1rem; font-weight: 600;">
                        <i class="bi bi-android2" style="font-size: 1.3rem; color: #a4c639;"></i>
                        <div class="text-start">
                            <div style="font-size: 0.7rem; font-weight: 400; opacity: 0.6; line-height: 1;">Uso interno del staff</div>
                            <div>Descargar App Android</div>
                        </div>
                    </a>
                    <p class="text-muted small mt-3"><i class="bi bi-lock-fill me-1 text-secondary"></i>Acceso exclusivo para el personal autorizado del negocio.</p>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex justify-content-center align-items-center" style="background: linear-gradient(145deg, var(--black-primary), #2d3748); border-radius: 24px; padding: 50px 30px; min-height: 420px; position: relative; overflow: hidden; box-shadow: 0 30px 80px rgba(0,0,0,0.15);">
                        <div style="position: absolute; top: -40px; right: -40px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(212,175,55,0.15) 0%, transparent 70%); border-radius: 50%;"></div>
                        <div class="text-center" style="z-index: 1; position: relative;">
                            <i class="bi bi-phone-fill mb-4 d-block" style="font-size: 5rem; color: var(--accent-gold);"></i>
                            <h4 class="text-white fw-bold mb-1">METRA Staff</h4>
                            <p style="color: rgba(255,255,255,0.4); font-size: 0.8rem; margin-bottom: 8px;">Versión Android &middot; Uso interno</p>
                            <div class="mb-4">
                                <span class="badge rounded-pill px-3 py-2" style="background: rgba(164,198,57,0.15); color: #a4c639; border: 1px solid rgba(164,198,57,0.3); font-size: 0.75rem;">
                                    <i class="bi bi-android2 me-1"></i>Android
                                </span>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex align-items-center gap-2 justify-content-center" style="color: rgba(255,255,255,0.75); font-size: 0.85rem;"><i class="bi bi-check-circle-fill" style="color: var(--accent-gold);"></i> Reservas activas del día</div>
                                <div class="d-flex align-items-center gap-2 justify-content-center" style="color: rgba(255,255,255,0.75); font-size: 0.85rem;"><i class="bi bi-check-circle-fill" style="color: var(--accent-gold);"></i> Gestión de ocupaciones</div>
                                <div class="d-flex align-items-center gap-2 justify-content-center" style="color: rgba(255,255,255,0.75); font-size: 0.85rem;"><i class="bi bi-check-circle-fill" style="color: var(--accent-gold);"></i> Control del flujo diario</div>
                                <div class="d-flex align-items-center gap-2 justify-content-center" style="color: rgba(255,255,255,0.75); font-size: 0.85rem;"><i class="bi bi-check-circle-fill" style="color: var(--accent-gold);"></i> Sin papel ni formatos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CAFETERIAS ACTIVAS -->
    <section id="cafeterias" style="background: #fff; padding: 80px 0; border-top: 1px solid var(--border-light);">
        <div class="container">
            <div class="text-center mb-5">
                <span style="display:inline-block; background: rgba(212,175,55,0.1); color: var(--accent-gold); font-size: 0.75rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 6px 18px; border-radius: 50px; margin-bottom: 16px; border: 1px solid rgba(212,175,55,0.3);">
                    Negocios que ya confían en METRA
                </span>
                <h2 class="fw-bold" style="color: var(--black-primary); font-size: clamp(1.5rem, 3vw, 2.2rem);">Cafeterías con METRA activo</h2>
                <p class="text-muted mx-auto" style="max-width: 520px;">Estos negocios ya digitalizan sus reservas con METRA. Sus clientes reservan directamente en el sistema del negocio.</p>
            </div>
            <div class="row g-4" id="cafeterias-container">
                <div class="col-12 text-center text-muted py-4">
                    <div class="spinner-border spinner-border-sm me-2"></div> Cargando cafeterías...
                </div>
            </div>
        </div>
    </section>

    <script>
    async function cargarCafeterias() {
        try {
            const res = await fetch('/api/cafeterias-publicas');
            const json = await res.json();
            const cafeterias = Array.isArray(json) ? json : (json.data || []);
            const container = document.getElementById('cafeterias-container');

            if (!cafeterias.length) {
                container.innerHTML = '<div class="col-12 text-center text-muted py-4"><i class="bi bi-shop fs-1 d-block mb-2 opacity-25"></i>Próximamente habrá cafeterías disponibles.</div>';
                return;
            }

            container.innerHTML = cafeterias.map(cafe => `
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="/detalles" class="text-decoration-none d-block h-100">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden" style="transition: transform 0.2s ease, box-shadow 0.2s ease;"
                             onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 16px 40px rgba(0,0,0,0.12)'"
                             onmouseout="this.style.transform='';this.style.boxShadow=''">
                            ${cafe.foto_url
                                ? `<img src="/storage/${cafe.foto_url}?v=${Date.now()}" alt="${cafe.nombre}" style="width:100%; height:180px; object-fit:cover;">`
                                : `<div style="height: 180px; background: linear-gradient(135deg, var(--black-primary), #2d3748); display: flex; align-items: center; justify-content: center;"><i class="bi bi-cup-hot-fill" style="font-size: 3.5rem; color: var(--accent-gold); opacity: 0.8;"></i></div>`
                            }
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="fw-bold mb-0 text-dark">${cafe.nombre}</h5>
                                    <span class="badge rounded-pill ms-2" style="background: rgba(25,135,84,0.1); color: #198754; border: 1px solid rgba(25,135,84,0.2); font-size: 0.7rem; flex-shrink: 0;">Activa</span>
                                </div>
                                <p class="text-muted small mb-3">${cafe.descripcion || 'Sistema de reservas METRA activo.'}</p>
                                ${cafe.calle ? `<p class="small mb-0" style="color: var(--text-muted);"><i class="bi bi-geo-alt-fill me-1" style="color: var(--accent-gold);"></i>${cafe.calle}${cafe.num_exterior ? ' ' + cafe.num_exterior : ''}${cafe.colonia ? ', ' + cafe.colonia : ''}</p>` : ''}
                            </div>
                            <div class="card-footer bg-white border-0 px-4 pb-4">
                                <span class="btn btn-sm fw-bold w-100 rounded-pill" style="background: var(--black-primary); color: #fff;">
                                    Ver detalles y reservar <i class="bi bi-arrow-right ms-1"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            `).join('');
        } catch (e) {
            document.getElementById('cafeterias-container').innerHTML = '<div class="col-12 text-center text-muted">No se pudo cargar la información.</div>';
        }
    }
    document.addEventListener('DOMContentLoaded', cargarCafeterias);
    </script>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>