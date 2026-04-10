<footer class="mt-5 py-4 border-top">
    <div class="d-flex flex-wrap justify-content-between align-items-center small text-muted gap-2">
        <div>
            <strong>METRA Admin</strong> | <span class="badge bg-light text-dark border">v1.2.0</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="javascript:void(0)" onclick="abrirModalSoporte()" class="text-decoration-none text-primary fw-bold d-flex align-items-center transition-transform hover-scale">
                <i class="bi bi-headset me-1"></i>Soporte Técnico
            </a>
            <span class="opacity-50">|</span>
            <span>© 2026 V-TECH Software</span>
        </div>
    </div>
</footer>

<!-- Modal de Soporte Premium -->
<div class="modal fade" id="modalSoporteGeneral" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
            <div class="modal-header border-0 pb-0 pt-4 px-4 justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4 pt-0">
                <div class="mb-4 mx-auto d-flex align-items-center justify-content-center shadow-lg" 
                     style="width: 80px; height: 80px; background: var(--black-primary); border-radius: 50%; border: 4px solid var(--accent-gold);">
                    <i class="bi bi-headset fs-1" style="color: var(--accent-gold);"></i>
                </div>
                
                <h3 class="fw-bold mb-2" style="color: var(--black-primary); letter-spacing: -1px;">Soporte METRA</h3>
                <p class="text-muted mb-4 px-3" style="font-size: 0.95rem;">Estamos aquí para ayudarte a optimizar tu negocio. Comunícate con nosotros por cualquiera de estos medios:</p>

                <div id="support-content-boxes" class="d-grid gap-3 px-3 pb-3 text-start">
                    <!-- WhatsApp -->
                    <div id="support-box-whatsapp" class="p-3 rounded-4" style="background: rgba(40, 167, 69, 0.05); border: 1px solid rgba(40, 167, 69, 0.2); display: none;">
                        <p class="small text-muted mb-1 fw-bold text-uppercase" style="letter-spacing: 1px;">WhatsApp</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <span id="support-text-whatsapp" class="fw-bold fs-5" style="color: var(--black-primary);"></span>
                            <a id="support-link-whatsapp" href="#" target="_blank" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm transition-transform hover-scale">
                                <i class="bi bi-whatsapp me-1"></i>Mensaje
                            </a>
                        </div>
                    </div>
                    
                    <!-- Llamada -->
                    <div id="support-box-phone" class="p-3 rounded-4" style="background: rgba(0,0,0,0.02); border: 1px solid var(--border-light); display: none;">
                        <p class="small text-muted mb-1 fw-bold text-uppercase" style="letter-spacing: 1px;">Teléfono Fijo</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <span id="support-text-phone" class="fw-bold fs-5" style="color: var(--black-primary);"></span>
                            <a id="support-link-phone" href="#" class="btn btn-sm btn-dark rounded-pill px-3 shadow-sm transition-transform hover-scale">
                                <i class="bi bi-telephone-fill me-1"></i>Llamar
                            </a>
                        </div>
                    </div>
                    
                    <!-- Correo -->
                    <div id="support-box-email" class="p-3 rounded-4" style="background: rgba(0,0,0,0.02); border: 1px dashed var(--border-light); display: none;">
                        <p class="small text-muted mb-1 fw-bold text-uppercase" style="letter-spacing: 1px;">Correo electrónico</p>
                        <a id="support-text-email" href="#" class="text-decoration-none fw-bold fs-6" style="color: var(--black-primary);"></a>
                    </div>
                </div>

                <!-- Estado Vacío -->
                <div id="support-box-empty" class="px-4 pb-4" style="display: none;">
                    <div class="p-4 rounded-4" style="background: rgba(255,0,0,0.05); border: 1px dashed rgba(255,0,0,0.2);">
                        <i class="bi bi-info-circle text-danger fs-3 mb-2 d-block"></i>
                        <p class="text-muted fw-bold mb-0">La plataforma no ha dado de alta su información de contacto.</p>
                        <p class="small text-muted mb-0">Por favor intente más tarde.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-scale:hover { transform: scale(1.02); }
    .transition-transform { transition: transform 0.2s ease; }
</style>

<script>
    async function abrirModalSoporte() {
        try {
            const res = await MetraAPI.get('/configuracion-pago');
            const config = res.data;
            
            if (config) {
                const modal = new bootstrap.Modal(document.getElementById('modalSoporteGeneral'));
                
                // Extraer datos
                const w = config.whatsapp_soporte || '';
                const t = config.telefono_soporte || '';
                const e = config.email_soporte || '';

                const bW = document.getElementById('support-box-whatsapp');
                const bT = document.getElementById('support-box-phone');
                const bE = document.getElementById('support-box-email');
                const bEmpty = document.getElementById('support-box-empty');
                const contentBoxes = document.getElementById('support-content-boxes');
                const descriptionText = document.getElementById('support-description-text');

                const formatNum = (num) => num.length === 10 ? `${num.substring(0,3)} ${num.substring(3,6)} ${num.substring(6)}` : num;

                // Restablecer
                bW.style.display = 'none';
                bT.style.display = 'none';
                bE.style.display = 'none';
                bEmpty.style.display = 'none';
                
                if(!w && !t && !e) {
                    // Estado vacío
                    bEmpty.style.display = 'block';
                    contentBoxes.style.display = 'none';
                } else {
                    contentBoxes.style.display = 'grid'; // restoring d-grid gap-3
                    
                    if(w) {
                        bW.style.display = 'block';
                        document.getElementById('support-text-whatsapp').innerText = formatNum(w);
                        document.getElementById('support-link-whatsapp').href = `https://wa.me/${w.replace(/[^0-9]/g, '')}`;
                    }
                    if(t) {
                        bT.style.display = 'block';
                        document.getElementById('support-text-phone').innerText = formatNum(t);
                        document.getElementById('support-link-phone').href = `tel:${t}`;
                    }
                    if(e) {
                        bE.style.display = 'block';
                        document.getElementById('support-text-email').innerText = e;
                        document.getElementById('support-text-email').href = `mailto:${e}`;
                    }
                }

                modal.show();
            } else {
                Swal.fire('Atención', 'La configuración de soporte no está disponible en este momento.', 'info');
            }
        } catch (error) {
            console.error('Error al cargar datos de soporte:', error);
            Swal.fire('Error', 'No pudimos contactar con el servidor de soporte.', 'error');
        }
    }
</script>