<div class="upsell-overlay d-flex flex-column align-items-center justify-content-center text-center p-4 rounded-4" 
     style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.05); backdrop-filter: blur(6px); z-index: 10; transition: all 0.3s ease;">
    
    <div class="premium-lock-icon mb-3 shadow-lg d-flex align-items-center justify-content-center" 
         style="width: 60px; height: 60px; background: var(--black-primary); border-radius: 50%; border: 2px solid var(--accent-gold);">
        <i class="bi bi-patch-check-fill fs-2" style="color: var(--accent-gold);"></i>
    </div>
    
    <h5 class="fw-bold mb-2" style="color: var(--black-primary); letter-spacing: -0.5px;">{{ $title ?? 'Función Premium' }}</h5>
    <p class="small text-muted mb-4 px-3" style="max-width: 300px; line-height: 1.4;">
        {{ $message ?? 'Desbloquea analíticas avanzadas y herramientas de marketing con el Plan Pro.' }}
    </p>
    
    <button class="btn-admin-primary px-4 py-2 shadow-sm" onclick="window.location.href='/admin/dashboard?upgrade=1'">
        <i class="bi bi-stars me-2"></i>Actualizar Plan
    </button>
</div>
