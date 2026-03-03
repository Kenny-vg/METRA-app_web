<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Subir Comprobante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <p class="text-center mb-4" style="color: var(--text-muted); font-size: 0.95rem;">Su registro requiere un comprobante de pago para ser procesado.</p>

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
    const API_BASE = "{{ url('/api') }}";
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
        
        if (f.type.startsWith('image/')) {
            const rd = new FileReader();
            rd.onload = e => {
                p.innerHTML = `
                    <div class="position-relative d-inline-block">
                        <img src="${e.target.result}" style="max-width: 100%; max-height: 200px; object-fit: contain; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    </div>
                    <div class="small text-muted mt-3 fw-semibold">${f.name}</div>
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
                        <i class="bi bi-file-pdf text-danger fs-3 me-2"></i><b>${f.name}</b> adjunto.
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

        const formData = new FormData();
        formData.append('comprobante', input.files[0]);

        try {
            const response = await fetch(`${API_BASE}/registro-negocio/${cafeteriaId}/comprobante`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Comprobante enviado',
                    text: 'Tu solicitud será revisada por el superadmin.',
                    confirmButtonColor: '#382C26'
                }).then(() => {
                    window.location.href = '/login';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message || 'Error al subir el comprobante. Inténtalo más tarde.',
                    confirmButtonColor: '#382C26'
                });
            }
        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'Fallo al comunicarse con el servidor.',
                confirmButtonColor: '#382C26'
            });
        } finally {
            btnTxt.classList.remove('d-none'); 
            btnLd.classList.add('d-none');
            btnEnviar.disabled = false;
        }
    };
</script>
</body>
</html>
