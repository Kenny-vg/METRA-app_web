<footer style="background-color: var(--black-primary); color: var(--off-white);" class="mt-5 pt-5 pb-4">
    <div class="container">
        <div class="row g-4 justify-content-between">
            
            <!-- Marca y Slogan -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h3 class="fw-bold mb-3" style="color: var(--accent-gold); font-family: 'Instrument Sans', sans-serif;">METRA</h3>
                <p class="small opacity-75" style="line-height: 1.6;">
                    Elevando la experiencia gastronómica con tecnología de vanguardia. Un sistema integral para la gestión inteligente de restaurantes.
                </p>
                <div class="mt-4">
                    <span class="badge rounded-pill px-3 py-2 fw-bold" style="background: var(--off-white); color: var(--black-primary);">
                        <i class="bi bi-star-fill me-1" style="color: var(--accent-gold);"></i> Powered by V-TECH
                    </span>
                </div>
            </div>

            <!-- Enlaces Rápidos -->
            <div class="col-md-3 mb-4 mb-md-0">
                <h5 class="fw-bold mb-3" style="color: var(--accent-gold);">Explorar</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/') }}" class="text-decoration-none opacity-75 hover-white" style="color: inherit; transition: 0.3s;">Inicio</a></li>
                    <li class="mb-2"><a href="{{ url('/#como-funciona') }}" class="text-decoration-none opacity-75 hover-white" style="color: inherit; transition: 0.3s;">Conócenos</a></li>
                    <li class="mb-2"><a href="{{ url('/reservar') }}" class="text-decoration-none opacity-75 hover-white" style="color: inherit; transition: 0.3s;">Reservar Mesa</a></li>
                    <li class="mb-2"><a href="{{ url('/login') }}" class="text-decoration-none opacity-75 hover-white" style="color: inherit; transition: 0.3s;">Acceso Clientes</a></li>
                    <li class="mb-2"><a href="{{ url('/login') }}" class="text-decoration-none opacity-75 hover-white" style="color: inherit; transition: 0.3s;">Acceso Restaurantes</a></li>
                </ul>
            </div>

            <!-- Contacto -->
            <div class="col-md-4">
                <h5 class="fw-bold mb-3" style="color: var(--accent-gold);">Contacto</h5>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-geo-alt-fill me-2 mt-1" style="color: var(--accent-gold);"></i>
                        <span class="opacity-75">Calle Independencia 123, Centro<br>Tehuacán, Puebla</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-telephone-fill me-2" style="color: var(--accent-gold);"></i>
                        <span class="opacity-75">+52 238 100 0000</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-whatsapp me-2" style="color: var(--success);"></i>
                        <span class="opacity-75">+52 238 100 0000</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center">
                        <i class="bi bi-envelope-fill me-2" style="color: var(--accent-gold);"></i>
                        <span class="opacity-75">soporte@metra-app.com</span>
                    </li>
                </ul>
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="btn btn-outline-light rounded-circle btn-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="btn btn-outline-light rounded-circle btn-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="btn btn-outline-light rounded-circle btn-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>
        </div>

        <hr class="my-5" style="opacity: 0.1; background-color: var(--off-white);">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="small mb-0 opacity-50">
                    &copy; 2026 V-TECH Software. Todos los derechos reservados.
                </p>
                <div class="mt-2">
                    <a href="{{ url('/login') }}" class="small text-decoration-none fw-bold" style="color: var(--black-primary); background: var(--accent-gold); padding: 2px 8px; border-radius: 4px; font-size: 0.65rem;">
                        <i class="bi bi-lock-fill me-1"></i>SaaS Admin
                    </a>
                </div>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="small text-decoration-none opacity-50 me-3" style="color: inherit;">Privacidad</a>
                <a href="#" class="small text-decoration-none opacity-50" style="color: inherit;">Términos</a>
            </div>
        </div>
    </div>
</footer>

<style>
    .hover-white:hover {
        opacity: 1 !important;
        color: var(--accent-gold) !important;
        transform: translateX(5px);
    }
</style>