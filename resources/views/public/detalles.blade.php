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
            <a href="{{ url('/') }}" class="navbar-brand fw-bold fs-3 text-decoration-none" style="color: var(--black-primary); letter-spacing: -0.5px;">
                <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold); font-size: 1.2rem;"></i>METRA
            </a>
            <div class="ms-auto d-flex align-items-center gap-3">
                <a href="{{ url('/') }}" class="nav-link nav-link-custom d-flex align-items-center gap-1" style="color: var(--text-muted); font-size: 0.9rem;">
                    <i class="bi bi-arrow-left-short fs-5"></i> Volver
                </a>
                <a href="{{ url('/login') }}" class="btn btn-outline-dark px-4 py-2" style="font-size: 0.9rem; border-radius: 6px;">
                    Iniciar Sesión
                </a>
                <a href="#" id="btn-reservar-navbar" class="btn-metra-main px-4 py-2" style="font-size: 0.9rem; border-radius: 6px;">
                    Reservar mesa
                </a>
            </div>
        </div>
    </nav>

    <!-- PANTALLA DE CARGA -->
    <div id="loader-screen" class="d-flex align-items-center justify-content-center" style="height: 80vh;">
        <div class="text-center text-muted">
            <div class="spinner-border text-dark mb-3" style="width: 3rem; height: 3rem;" role="status"></div>
            <h5>Cargando Perfil del Negocio...</h5>
        </div>
    </div>

    <!-- CONTENIDO (se muestra al cargar) -->
    <div id="cafe-content" class="d-none">
        <!-- HERO -->
        <section style="position: relative; height: 480px; overflow: hidden;">
            <img id="cafe-hero-img"
                 src="https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&q=80&w=1600"
                 alt="Cargando..."
                 style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
            <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.65) 100%);"></div>
            <div class="container position-absolute bottom-0 start-50 translate-middle-x w-100 pb-5">
                <div class="text-white">
                    <span style="display:inline-block; background: rgba(212,175,55,0.2); color: var(--accent-gold); font-size: 0.72rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; padding: 5px 14px; border-radius: 50px; margin-bottom: 14px; border: 1px solid rgba(212,175,55,0.4);">
                        <i class="bi bi-cup-hot-fill me-1"></i>Con METRA activo
                    </span>
                    <h1 class="fw-bold mb-2" id="cafe-nombre" style="font-size: clamp(2rem, 5vw, 3.5rem); letter-spacing: -0.5px; line-height: 1.15;">
                        Cargando...
                    </h1>
                    <p id="cafe-desc" style="color: rgba(255,255,255,0.75); font-size: 1.1rem; max-width: 560px; margin: 0;">
                        Por favor espera.
                    </p>
                </div>
            </div>
        </section>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="container py-5">
            <div class="row g-5">

                <!-- Columna izquierda -->
                <div class="col-12 col-lg-7">

                    <div id="direccion-container" class="d-none align-items-center gap-2 mb-5" style="color: var(--text-muted);">
                        <i class="bi bi-geo-alt-fill" style="color: var(--accent-gold);"></i>
                        <span id="cafe-direccion"></span>
                    </div>

                    <!-- PROMOCIONES -->
                    <section class="mb-5" id="sectionPromociones">
                        <div class="d-flex align-items-baseline justify-content-between mb-4">
                            <h4 class="fw-bold mb-0" style="color: var(--black-primary); letter-spacing: -0.3px;">Promociones y Eventos</h4>
                            <span class="small text-muted">Oportunidades especiales</span>
                        </div>

                        <!-- Filtros Ocasiones -->
                        <div class="d-flex flex-wrap gap-2 mb-4 d-none" id="ocasiones-filtros-container">
                            <button class="btn btn-sm px-3 rounded-pill btn-admin-primary btn-filtro-ocasion fw-medium" id="btn-todas-promos" onclick="filtrarPromos('todas')">Todas</button>
                            <!-- Ocasiones cargadas por JS -->
                        </div>

                        <div class="row g-3" id="promos-publicas">
                            <div class="col-12 text-center text-muted py-3">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div> Cargando promociones...
                            </div>
                        </div>
                    </section>

                    <!-- MENÚ DESTACADO -->
                    <section class="mb-5">
                        <div class="d-flex align-items-baseline justify-content-between mb-4">
                            <h4 class="fw-bold mb-0" style="color: var(--black-primary); letter-spacing: -0.3px;">Menú Destacado</h4>
                            <span class="small text-muted">Lo más pedido</span>
                        </div>
                        <div class="row g-3" id="menu-publico-container">
                            <div class="col-12 text-center text-muted py-3">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div> Cargando menú...
                            </div>
                        </div>
                    </section>

                    <!-- IMAGEN PRINCIPAL DEL NEGOCIO -->
                    <section class="mb-5">
                        <div class="d-flex align-items-baseline justify-content-between mb-4">
                            <h4 class="fw-bold mb-0" style="color: var(--black-primary); letter-spacing: -0.3px;">El espacio</h4>
                        </div>
                        <div id="foto-secundaria-container">
                            <div class="rounded-4 d-flex align-items-center justify-content-center" style="height: 280px; background: var(--off-white); border: 1px dashed var(--border-light);">
                                <div class="text-center text-muted">
                                    <i class="bi bi-image display-4 d-block mb-2" style="opacity: 0.3;"></i>
                                    <small>El gerente aún no ha subido imagen del negocio.</small>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                    <!-- RESEÑAS -->
                    <section class="mb-5" id="sectionResenas">
                        <div class="d-flex align-items-baseline justify-content-between mb-4">
                            <h4 class="fw-bold mb-0" style="color: var(--black-primary); letter-spacing: -0.3px;">Lo que dicen nuestros clientes</h4>
                        </div>
                        <div class="row g-3" id="resenas-container">
                            <div class="col-12 text-center text-muted py-3">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div> Cargando reseñas...
                            </div>
                        </div>
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

                            <a href="{{ url('/reservar') }}" id="btn-reservar-lateral" class="btn-metra-main w-100 d-flex align-items-center justify-content-center py-3 mb-4" style="border-radius: 12px; font-size: 1rem;">
                                <i class="bi bi-calendar3 me-2"></i>Continuar con la reserva
                            </a>

                            <hr style="opacity: 0.08;">

                            <!-- Info rápida -->
                            <div class="d-flex flex-column gap-3 my-3">
                                
                                <div id="sidebar-direccion" class="d-none align-items-center gap-3">
                                    <div style="width: 36px; height: 36px; background: var(--off-white); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i class="bi bi-geo-alt-fill" style="color: var(--accent-gold);"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bold small">Ubicación</p>
                                        <p class="mb-0 text-muted" id="sidebar-direccion-texto" style="font-size: 0.8rem;"></p>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width: 36px; height: 36px; background: var(--off-white); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i class="bi bi-clock-fill" style="color: var(--accent-gold);"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bold small">Tolerancia de llegada</p>
                                        <p class="mb-0 text-muted" style="font-size: 0.8rem;">15 minutos después del horario reservado.</p>
                                    </div>
                                </div>

                                {{-- Horario de hoy: se muestra si la cafetería tiene horario activo para este día --}}
                                <div id="sidebar-horario-hoy-container" class="d-none align-items-center gap-3">
                                    <div style="width: 36px; height: 36px; background: var(--off-white); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i class="bi bi-door-open-fill" style="color: var(--accent-gold);"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bold small">Horario de hoy</p>
                                        <p class="mb-0 text-muted" id="sidebar-horario-hoy-texto" style="font-size: 0.8rem;"></p>
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
                            <p class="small fw-bold text-uppercase mb-3" style="color: var(--text-muted); letter-spacing: 1px; font-size: 0.72rem;">Horarios de atención</p>
                            <div id="horarios-slots-container" class="d-flex flex-wrap gap-2 mb-4">
                                {{-- Slots cargados dinámicamente por JS desde la API --}}
                                <span class="badge rounded-pill px-3 py-2" style="background: var(--off-white); color: var(--text-muted); border: 1px solid var(--border-light); font-size: 0.8rem;">
                                    <span class="spinner-border spinner-border-sm me-1" style="width:.75rem;height:.75rem;"></span>Cargando...
                                </span>
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
    </div>

    @include('partials.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/metra-utils.js"></script>
    <script>
        window.escapeHTML = function(str) {
            if (str === null || str === undefined) return '';
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        };

        document.addEventListener('DOMContentLoaded', async () => {
            const cafeSlug = getSlugFromUrl();
            const API_URL = "{{ url('/api') }}";
            const STORAGE_URL = "{{ asset('storage') }}";
            const BASE_URL = "{{ url('/') }}";
            const FALLBACK_IMG = "https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&q=80&w=1600";

            try {
                const res = await fetch(`${API_URL}/cafeterias-publicas/${cafeSlug}`);
                if (!res.ok) {
                    throw new Error('No encontrado');
                }
                const json = await res.json();
                const cafe = json.data;

                // Bind text elements
                document.getElementById('cafe-nombre').textContent = cafe.nombre || 'Cafetería';
                document.getElementById('cafe-desc').textContent = cafe.descripcion || 'Un espacio diseñado para que disfrutes cada momento.';
                
                // Bind Address
                if (cafe.calle) {
                    const addrHtml = `${cafe.calle}${cafe.num_exterior ? ' ' + cafe.num_exterior : ''}${cafe.colonia ? ', ' + cafe.colonia : ''}`;
                    document.getElementById('cafe-direccion').textContent = addrHtml;
                    document.getElementById('direccion-container').classList.remove('d-none');
                    document.getElementById('direccion-container').classList.add('d-flex');
                    
                    document.getElementById('sidebar-direccion-texto').textContent = addrHtml;
                    document.getElementById('sidebar-direccion').classList.remove('d-none');
                    document.getElementById('sidebar-direccion').classList.add('d-flex');
                }

                // Bind image with cache busting if exists
                let finalImgUrl = FALLBACK_IMG;
                let timestamp = new Date().getTime(); // simple cache buster
                
                if (cafe.foto_url) {
                    finalImgUrl = `/storage/${cafe.foto_url}?v=${timestamp}`;
                    document.getElementById('foto-secundaria-container').innerHTML = `
                        <img src="${finalImgUrl}" alt="El espacio" class="img-fluid rounded-4 shadow-sm w-100" style="height: 280px; object-fit: cover;">
                    `;
                }

                document.getElementById('cafe-hero-img').src = finalImgUrl;

                // Update reservation specific button
                document.getElementById('btn-reservar-lateral').href = `${BASE_URL}/reservar/${cafe.slug}`;
                document.getElementById('btn-reservar-navbar').href = `${BASE_URL}/reservar/${cafe.slug}`;

                // Reveal UI
                document.getElementById('loader-screen').classList.add('d-none');
                document.getElementById('cafe-content').classList.remove('d-none');

                // --- Load Menu ---
                try {
                    const resMenu = await fetch(`${API_URL}/cafeterias/${cafe.slug}/menu`);
                    if(resMenu.ok) {
                        const jsonMenu = await resMenu.json();
                        const menuItems = jsonMenu.data || [];
                        const menuContainer = document.getElementById('menu-publico-container');
                        menuContainer.innerHTML = '';
                        
                        if(menuItems.length === 0) {
                            menuContainer.innerHTML = '<div class="col-12"><p class="text-muted small">El menú aún no está disponible.</p></div>';
                        } else {
                            menuItems.forEach(item => {
                                const imgUrlWithCacheBuster = item.imagen_url.startsWith('http') ? item.imagen_url : `{{ url('storage') }}/${item.imagen_url}?v=${timestamp}`;
                                const img = item.imagen_url ? imgUrlWithCacheBuster : 'https://placehold.co/300x200/faf6f0/c5a059?text=METRA';
                                menuContainer.innerHTML += `
                                    <div class="col-6 col-md-4 text-center mb-3">
                                        <div style="width: 100%; height: 120px; border-radius: 12px; background-image: url('${img}'); background-size: cover; background-position: center; border: 1px solid var(--border-light);" class="mb-2 shadow-sm"></div>
                                        <p class="small fw-bold mb-0 text-truncate" style="color: var(--black-primary);" title="${escapeHTML(item.nombre_producto)}">${escapeHTML(item.nombre_producto)}</p>
                                        <p class="text-muted small text-truncate" style="font-size: 0.75rem;" title="${escapeHTML(item.descripcion || '')}">${escapeHTML(item.descripcion ? item.descripcion : ' ')}</p>
                                    </div>
                                `;
                            });
                        }
                    }
                } catch (e) {
                    console.error("Error loading menu", e);
                }

                // --- Load Promociones y Ocasiones ---
                window.filtrarPromos = function(ocasionId) {
                    // Update active pill styling
                    document.querySelectorAll('.btn-filtro-ocasion').forEach(btn => {
                        btn.classList.remove('btn-admin-primary');
                        btn.classList.add('btn-outline-secondary');
                    });
                    
                    const activeBtn = ocasionId === 'todas' 
                        ? document.getElementById('btn-todas-promos') 
                        : document.getElementById(`btn-ocasion-${ocasionId}`);
                        
                    if (activeBtn) {
                        activeBtn.classList.remove('btn-outline-secondary');
                        activeBtn.classList.add('btn-admin-primary');
                    }
                    
                    cargarPromociones(ocasionId === 'todas' ? null : ocasionId);
                };

                async function cargarOcasionesFiltros() {
                    try {
                        const res = await fetch(`${API_URL}/cafeterias/${cafe.slug}/ocasiones`);
                        if (res.ok) {
                            const data = await res.json();
                            const ocasiones = data.data || [];
                            if (ocasiones.length > 0) {
                                document.getElementById('ocasiones-filtros-container').classList.remove('d-none');
                                const container = document.getElementById('ocasiones-filtros-container');
                                ocasiones.forEach(o => {
                                    container.innerHTML += `<button id="btn-ocasion-${o.id}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill btn-filtro-ocasion fw-medium" onclick="filtrarPromos(${o.id})">${escapeHTML(o.nombre)}</button>`;
                                });
                            }
                        }
                    } catch (e) {
                         console.error("Error loading ocasiones", e);
                    }
                }

                async function cargarPromociones(ocasionId = null) {
                    const promosContainer = document.getElementById('promos-publicas');
                    try {
                        promosContainer.innerHTML = '<div class="col-12 text-center text-muted py-3"><div class="spinner-border spinner-border-sm me-2"></div> Cargando...</div>';
                        
                        const url = ocasionId 
                            ? `${API_URL}/cafeterias/${cafe.slug}/ocasiones/${ocasionId}/promociones`
                            : `${API_URL}/cafeterias/${cafe.slug}/promociones`;
                            
                        const resPromos = await fetch(url);
                        if(resPromos.ok) {
                            const jsonPromos = await resPromos.json();
                            const promosData = jsonPromos.data || [];
                            promosContainer.innerHTML = '';
                            
                            if(promosData.length === 0 && !ocasionId) {
                                document.getElementById('sectionPromociones').classList.add('d-none');
                            } else if (promosData.length === 0) {
                                promosContainer.innerHTML = '<div class="col-12 text-center text-muted py-4"><i class="bi bi-tag d-block fs-3 mb-2 opacity-50"></i>No hay promociones publicadas para esta ocasión.</div>';
                            } else {
                                document.getElementById('sectionPromociones').classList.remove('d-none');
                                promosData.forEach(p => {
                                    const formattedPrice = parseFloat(p.precio) === 0 ? 'Incluido sin costo' : new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(p.precio);
                                    promosContainer.innerHTML += `
                                        <div class="col-12 col-sm-6">
                                            <div class="p-4 rounded-4 h-100 d-flex flex-column shadow-sm" style="background: var(--off-white); border: 1px solid rgba(212,175,55,0.3); position: relative; overflow: hidden;">
                                                <div style="position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: var(--accent-gold);"></div>
                                                <div class="d-flex justify-content-between align-items-start mb-3 ms-2">
                                                    <h5 class="fw-bold mb-0" style="color: var(--black-primary); letter-spacing: -0.5px;">${escapeHTML(p.nombre_promocion)}</h5>
                                                    <span class="badge rounded-pill" style="background: rgba(212,175,55,0.12); color: var(--accent-gold); border: 1px solid rgba(212,175,55,0.3); font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;">
                                                        <i class="bi bi-star-fill me-1"></i>Disponible
                                                    </span>
                                                </div>
                                                <p class="text-muted small mb-4 ms-2 flex-grow-1" style="line-height: 1.5;">${escapeHTML(p.descripcion || 'Pregunta a tu mesero por los detalles.')}</p>
                                                <div class="mt-auto ms-2 pt-3 border-top" style="border-color: rgba(0,0,0,0.05) !important;">
                                                    <span class="fs-4 fw-bold" style="color: var(--accent-gold);">${formattedPrice}</span>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                });
                            }
                        }
                    } catch (e) {
                         console.error("Error loading promotions", e);
                         promosContainer.innerHTML = '<div class="col-12 text-danger text-center"><small>No se pudieron cargar las promociones.</small></div>';
                    }
                }

                cargarOcasionesFiltros();
                cargarPromociones();
                
                // --- Load Reseñas ---
                try {
                    const resResenas = await fetch(`${API_URL}/cafeterias/${cafe.slug}/resenas`);
                    if(resResenas.ok) {
                        const jsonResenas = await resResenas.json();
                        const resenasList = jsonResenas.data || [];
                        const resenasContainer = document.getElementById('resenas-container');
                        const sectionResenas = document.getElementById('sectionResenas');
                        
                        resenasContainer.innerHTML = '';
                        if(resenasList.length > 0) {
                            resenasList.forEach(r => {
                                let starsHtml = '';
                                for(let i=1; i<=5; i++){
                                    if(i <= r.calificacion){
                                        starsHtml += `<i class="bi bi-star-fill text-warning me-1"></i>`;
                                    } else {
                                        starsHtml += `<i class="bi bi-star text-muted me-1" style="opacity:0.3;"></i>`;
                                    }
                                }
                                
                                resenasContainer.innerHTML += `
                                    <div class="col-12 col-md-6 mb-3">
                                        <div class="p-4 rounded-4 shadow-sm h-100" style="background: var(--off-white); border: 1px solid var(--border-light);">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="small fw-bold text-muted">${r.fecha}</div>
                                                <div>${starsHtml}</div>
                                            </div>
                                            <p class="mb-0 text-muted" style="line-height: 1.5; font-size: 0.95rem;">"${escapeHTML(r.comentario || 'Excelente servicio.')}"</p>
                                        </div>
                                    </div>
                                `;
                            });
                        } else {
                            resenasContainer.innerHTML = `
                                <div class="col-12 text-center py-4">
                                    <i class="bi bi-chat-square-text display-5 d-block mb-3" style="color: var(--border-light);"></i>
                                    <p class="text-muted mb-0">Este negocio aún no tiene reseñas. ¡Sé el primero en compartir tu experiencia!</p>
                                </div>
                            `;
                        }
                    }
                } catch (e) {
                    console.error("Error loading resenas", e);
                }

                // --- Horarios de Atención (informativo, no reservaciones) ---
                try {
                    const resHorarios = await fetch(`${API_URL}/cafeterias/${cafe.slug}/horarios`);
                    if (resHorarios.ok) {
                        const jsonHorarios = await resHorarios.json();
                        const horariosList = (jsonHorarios.data || []).filter(h => h.activo !== false && h.activo !== 0);

                        if (horariosList.length > 0) {
                            const fmt24 = t => t ? t.substring(0, 5) : '--:--';

                            // 1. Horario de hoy en el sidebar
                            const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
                            const hoyNombre = diasSemana[new Date().getDay()];
                            const horarioHoy = horariosList.find(h => h.dia_semana === hoyNombre);

                            if (horarioHoy) {
                                document.getElementById('sidebar-horario-hoy-texto').textContent =
                                    `${fmt24(horarioHoy.hora_apertura)} \u2013 ${fmt24(horarioHoy.hora_cierre)}`;
                                const cont = document.getElementById('sidebar-horario-hoy-container');
                                cont.classList.remove('d-none');
                                cont.classList.add('d-flex');
                            }

                            // 2. Todos los horarios como badges (Lun–Dom)
                            const ordenDias = { Lunes:1, Martes:2, Miercoles:3, Jueves:4, Viernes:5, Sabado:6, Domingo:7 };
                            horariosList.sort((a, b) => (ordenDias[a.dia_semana] || 99) - (ordenDias[b.dia_semana] || 99));

                            const slotsContainer = document.getElementById('horarios-slots-container');
                            slotsContainer.innerHTML = horariosList.map(h => `
                                <span class="badge rounded-pill px-3 py-2"
                                      style="background: var(--off-white); color: var(--black-primary); border: 1px solid var(--border-light); font-weight: 600; font-size: 0.8rem;">
                                    ${h.dia_semana.substring(0,3)}: ${fmt24(h.hora_apertura)}–${fmt24(h.hora_cierre)}
                                </span>
                            `).join('');
                        } else {
                            // Sin horarios configurados: ocultar la sección
                            document.getElementById('horarios-slots-container').closest('hr')?.nextElementSibling
                                    && (document.getElementById('horarios-slots-container').parentElement.style.display = 'none');
                        }
                    }
                } catch (e) {
                    console.error('Error loading horarios públicos', e);
                }

            } catch(e) {
                console.error(e);
                document.getElementById('loader-screen').innerHTML = `
                    <div class="text-center text-danger w-100 p-5 mt-5">
                        <i class="bi bi-exclamation-triangle-fill display-1 mb-3"></i>
                        <h2>Negocio no encontrado</h2>
                        <a href="{{ url('/') }}" class="btn btn-dark mt-3 px-4 rounded-pill">Volver al inicio</a>
                    </div>
                `;
            }
        });
    </script>
</body>
</html>