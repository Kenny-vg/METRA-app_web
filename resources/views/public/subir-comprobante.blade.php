<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Subir Comprobante</title>
    <link rel='icon' href='{{ asset('favicon.png') }}?v=6' type='image/png'>
    <link rel='icon' href='{{ asset('favicon.svg') }}?v=6' type='image/svg+xml'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.API_URL = "{{ url('/api') }}";
        window.FILE_URL = "{{ url('/') }}";
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .upload-area {
            border: 2px dashed var(--border-light);
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            background: var(--off-white);
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .upload-area:hover, .upload-area.dragover {
            border-color: var(--accent-gold);
            background: rgba(181, 146, 126, 0.05); /* Ligeramente tintado */
        }
        .upload-area i {
            font-size: 2.5rem;
            color: var(--accent-gold);
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="zona-comensal" style="background-color: var(--off-white);">

    <div class="container d-flex flex-column justify-content-center align-items-center vh-100">
        
        <div class="text-center mb-4">
            <a href="/" class="text-decoration-none d-inline-block mb-3">
                <span class="fw-bold fs-2" style="color: var(--black-primary); letter-spacing: -1px;">
                    <i class="bi bi-hexagon-fill me-2" style="color: var(--accent-gold); font-size: 1.5rem;"></i>METRA
                </span>
            </a>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 16px; max-width: 500px; width: 100%;">
            <div class="card-body p-4 p-md-5">
                <h4 class="fw-bold mb-2 text-center" style="color: var(--black-primary); font-family: 'Inter', sans-serif;">Subir Comprobante</h4>
                <p id="negocio-nombre" class="text-center fw-bold mb-1" style="color: var(--accent-gold); font-size: 1.1rem; display: none;"></p>
                <p class="text-center mb-4" style="color: var(--text-muted); font-size: 0.95rem;">Su registro requiere un comprobante de pago para ser procesado.</p>

                <!-- Sección de Datos Bancarios Refinada -->
                <div id="datos-pago-container" class="mb-4 p-4 rounded-4 border-0" style="display: none; background: #fdfaf8; border: 1px solid rgba(181, 146, 126, 0.2) !important;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-metra-gold text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; background-color: var(--accent-gold);">
                            <i class="bi bi-bank" style="font-size: 0.9rem;"></i>
                        </div>
                        <h6 class="fw-bold mb-0" style="color: var(--black-primary); font-size: 0.95rem; letter-spacing: 0.3px;">Instrucciones de Pago</h6>
                    </div>
                    
                    <div id="loading-pago" class="text-center py-3">
                        <div class="spinner-border spinner-border-sm text-gold" style="color: var(--accent-gold);"></div>
                    </div>

                    <div id="datos-pago-content" style="display: none;">
                        <p class="small text-muted mb-3">Realiza tu transferencia con los siguientes datos:</p>
                        
                        <div class="payment-detail-row mb-2">
                            <span class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 600;">Banco</span>
                            <span class="fw-bold text-dark" id="pago-banco" style="font-size: 1rem;">---</span>
                        </div>
                        
                        <div class="payment-detail-row mb-2">
                            <span class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 600;">CLABE Interbancaria</span>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold text-metra-gold" id="pago-clabe" style="font-size: 1.1rem; color: var(--accent-gold); letter-spacing: 1px;">---</span>
                                <button class="btn btn-sm p-0 text-muted" onclick="copyClabeUpload()" title="Copiar CLABE">
                                    <i class="bi bi-copy" id="clabe-copy-icon-up"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="payment-detail-row mb-3">
                            <span class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; font-weight: 600;">Beneficiario / Destinatario</span>
                            <span class="fw-bold text-dark" id="pago-beneficiario" style="font-size: 1rem;">---</span>
                        </div>

                        <div id="pago-instrucciones-container" class="mt-3 pt-3 border-top" style="display: none; border-top-style: dashed !important;">
                            <p class="small mb-0" style="color: var(--text-muted); line-height: 1.4;">
                                <i class="bi bi-info-circle me-1"></i> <span id="pago-instrucciones"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="upload-area" id="upload-area" onclick="document.getElementById('comprobante-input').click()">
                    <i class="bi bi-cloud-arrow-up"></i>
                    <p class="mb-1 fw-semibold" style="color: var(--black-primary); font-size: 1.1rem;">Selecciona tu comprobante</p>
                    <p class="text-muted small mb-0">Arrastra el documento aquí o haz clic (JPG, PNG, PDF)</p>
                </div>
                <input type="file" id="comprobante-input" accept=".jpg,.jpeg,.png,.pdf" class="d-none" onchange="previewFile(this)">
                
                <div id="file-preview" class="text-center mt-3 mb-4"></div>

                <button class="btn-metra-main w-100 py-3 mt-2" id="btn-enviar" style="border-radius: 8px; font-size: 1.05rem; letter-spacing: 0.5px;" onclick="subirComprobante()">
                    <span id="btn-text">Enviar Comprobante</span>
                    <span id="btn-loading" class="d-none"><span class="spinner-border spinner-border-sm me-2"></span>Enviando...</span>
                </button>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="small text-muted text-decoration-none fw-bold"><i class="bi bi-arrow-left me-1"></i> Volver al Login</a>
                </div>
            </div>
        </div>
        
    </div>

<script>
    const cafeteriaId = "{{ $id }}";

    function previewFile(input) {
        const p = document.getElementById('file-preview');
        const uploadArea = document.getElementById('upload-area');
        if (!input.files.length) {
            p.innerHTML = '';
            uploadArea.style.display = 'block';
            return;
        }
        
        uploadArea.style.display = 'none';
        const f = input.files[0];
        
        const parseHTML = (str) => {
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        };
        
        if (f.type.startsWith('image/')) {
            const rd = new FileReader();
            rd.onload = e => {
                p.innerHTML = `
                    <div class="position-relative d-inline-block">
                        <img src="${e.target.result}" style="max-width: 100%; max-height: 200px; object-fit: contain; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    </div>
                    <div class="small text-muted mt-3 fw-semibold">${parseHTML(f.name)}</div>
                    <div class="mt-3">
                        <button class="btn btn-sm btn-outline-danger me-2 shadow-sm rounded-pill px-3" onclick="rmFile()"><i class="bi bi-trash"></i> Eliminar</button>
                        <button class="btn btn-sm btn-outline-primary shadow-sm rounded-pill px-3" onclick="document.getElementById('comprobante-input').click()"><i class="bi bi-arrow-repeat"></i> Reemplazar</button>
                    </div>
                `;
            };
            rd.readAsDataURL(f);
        } else {
            p.innerHTML = `
                <div class="p-3 bg-light rounded-3 text-start border d-flex justify-content-between align-items-center">
                    <div class="text-truncate me-3">
                        <i class="bi bi-file-pdf text-danger fs-3 me-2"></i><b>${parseHTML(f.name)}</b> adjunto.
                    </div>
                    <div class="text-nowrap">
                        <button class="btn btn-sm btn-outline-danger me-1" onclick="rmFile()"><i class="bi bi-trash"></i></button>
                        <button class="btn btn-sm btn-outline-primary" onclick="document.getElementById('comprobante-input').click()"><i class="bi bi-arrow-repeat"></i></button>
                    </div>
                </div>
            `;
        }
    }

    window.rmFile = function() {
        const input = document.getElementById('comprobante-input');
        input.value = '';
        document.getElementById('file-preview').innerHTML = '';
        document.getElementById('upload-area').style.display = 'block';
    }

    const ua = document.getElementById('upload-area');
    ua.addEventListener('dragover', e => { e.preventDefault(); ua.classList.add('dragover'); });
    ua.addEventListener('dragleave', () => ua.classList.remove('dragover'));
    ua.addEventListener('drop', e => { 
        e.preventDefault(); 
        ua.classList.remove('dragover'); 
        document.getElementById('comprobante-input').files = e.dataTransfer.files; 
        previewFile(document.getElementById('comprobante-input')); 
    });

    window.subirComprobante = async function() {
        const input = document.getElementById('comprobante-input');
        
        if (!input || !input.files.length) {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Por favor selecciona tu comprobante visual.',
                confirmButtonColor: '#382C26'
            });
            return;
        }

        const btnTxt = document.getElementById('btn-text');
        const btnLd = document.getElementById('btn-loading');
        const btnEnviar = document.getElementById('btn-enviar');
        
        btnTxt.classList.add('d-none'); 
        btnLd.classList.remove('d-none');
        btnEnviar.disabled = true;

        try {
            const formData = new FormData();
            formData.append('comprobante', input.files[0]);
            
            const result = await MetraAPI.post(`/registro-negocio/${cafeteriaId}/comprobante`, formData);

            Swal.fire({
                icon: 'success',
                title: 'Comprobante enviado',
                text: 'Tu solicitud será revisada por el superadmin.',
                confirmButtonColor: '#382C26'
            }).then(() => {
                window.location.href = '/login';
            });
        } catch (error) {
            console.error(error);
            const dt = error.data || {};
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: dt.message || 'Error al subir el comprobante. Inténtalo más tarde.',
                confirmButtonColor: '#382C26'
            });
        } finally {
            btnTxt.classList.remove('d-none'); 
            btnLd.classList.add('d-none');
            btnEnviar.disabled = false;
        }
    };

    // Cargar datos de pago al iniciar
    async function cargarDatosPago() {
        const container = document.getElementById('datos-pago-container');
        const loading = document.getElementById('loading-pago');
        const content = document.getElementById('datos-pago-content');
        
        container.style.display = 'block';

        try {
            const result = await MetraAPI.get('/configuracion-pago');

            if (result.data) {
                const d = result.data;
                document.getElementById('pago-banco').textContent = d.banco || 'No especificado';
                document.getElementById('pago-clabe').textContent = d.clabe || 'No especificado';
                document.getElementById('pago-beneficiario').textContent = d.beneficiario || 'No especificado';
                
                if (d.instrucciones_pago) {
                    document.getElementById('pago-instrucciones').textContent = d.instrucciones_pago;
                    document.getElementById('pago-instrucciones-container').style.display = 'block';
                } else {
                    document.getElementById('pago-instrucciones-container').style.display = 'none';
                }
                
                if (loading) loading.style.display = 'none';
                if (content) content.style.display = 'block';
            } else {
                if (loading) loading.innerHTML = '<span class="text-muted small">Pendiente de configurar por el administrador.</span>';
            }
        } catch (error) {
            console.error('Error cargando datos de pago:', error);
            if (loading) loading.innerHTML = '<span class="text-danger small">Error de conexión.</span>';
        }
    }

    window.copyClabeUpload = function() {
        const clabe = document.getElementById('pago-clabe').textContent;
        if (!clabe || clabe === '---') return;
        
        navigator.clipboard.writeText(clabe).then(() => {
            const icon = document.getElementById('clabe-copy-icon-up');
            icon.classList.remove('bi-copy');
            icon.classList.add('bi-check-lg', 'text-success');
            setTimeout(() => {
                icon.classList.remove('bi-check-lg', 'text-success');
                icon.classList.add('bi-copy');
            }, 2000);
        });
    }

    async function cargarInfoCafeteria() {
        try {
            const result = await MetraAPI.get(`/cafeterias-publicas-id/${cafeteriaId}`);
            if (result.data) {
                const el = document.getElementById('negocio-nombre');
                el.textContent = result.data.nombre;
                el.style.display = 'block';
            }
        } catch (e) { console.error(e); }
    }

    document.addEventListener('DOMContentLoaded', () => {
        cargarDatosPago();
        cargarInfoCafeteria();
    });
</script>
</body>
</html>
