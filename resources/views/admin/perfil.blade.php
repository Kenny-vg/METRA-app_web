@extends('admin.menu')
@section('title', 'Configuración de Ecosistema')

@section('content')
    <header class="mb-5 border-bottom pb-4" style="border-color: var(--border-light) !important;">
        <h2 class="fw-bold" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Configuración de mi Negocio</h2>
        <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Gestiona la identidad pública y los datos de contacto de tu establecimiento.</p>
    </header>

    <style>
        @keyframes customPulse {
            0% { box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(212, 175, 55, 0); }
            100% { box-shadow: 0 0 0 0 rgba(212, 175, 55, 0); }
        }
        #btnGuardarPerfil:hover {
            transform: scale(1.03);
        }
    </style>
    <form id="formPerfil" style="max-width: 1100px;">
        <div class="row g-4">
            <div class="col-12 col-xl-7">
                <!-- Información General -->
                <div class="card border-0 p-4 p-md-5 rounded-4 mb-4 premium-card">
                    <h5 class="fw-bold mb-4 text-dark" style="letter-spacing: -0.5px;"><i class="bi bi-shop me-2" style="color: var(--accent-gold);"></i>Identidad Comercial</h5>
                    
                    <div class="mb-4">
                        <label class="small fw-bold mb-2 text-uppercase text-muted" style="letter-spacing: 1px; font-size: 0.7rem;">Nombre del establecimiento</label>
                        <input type="text" class="form-control border-0 shadow-sm rounded-3 p-3" name="nombre_franquicia" value="" placeholder="Cargando..." maxlength="100" style="background: var(--off-white); font-weight: 500; color: var(--black-primary);">
                    </div>
                    
                    <div class="mb-3">
                        <label class="small fw-bold mb-2 text-uppercase text-muted" style="letter-spacing: 1px; font-size: 0.7rem;">Descripción del establecimiento</label>
                        <textarea class="form-control border-0 shadow-sm rounded-3 p-3" name="descripcion" rows="4" maxlength="255" placeholder="Escribe aquí la descripción de tu negocio..." style="background: var(--off-white); font-weight: 400; color: var(--text-main); line-height: 1.6;"></textarea>
                    </div>
                </div>

                <!-- Ubicación -->
                <div class="card border-0 p-4 p-md-5 rounded-4 mb-4 premium-card">
                    <h5 class="fw-bold mb-4 text-dark" style="letter-spacing: -0.5px;"><i class="bi bi-geo-alt me-2" style="color: var(--accent-gold);"></i>Geolocalización Física</h5>
                    
                    <div class="mb-4 pb-4 border-bottom" style="border-color: var(--border-light) !important;">
                        <div class="row g-3 align-items-end mb-3">
                            <div class="col-md-6">
                                <label class="small fw-bold mb-2 text-uppercase text-muted" style="letter-spacing: 1px; font-size: 0.7rem;">Calle</label>
                                <input type="text" name="calle" class="form-control border-0 shadow-sm rounded-3 p-3" placeholder="Ej. Av. Reforma" maxlength="100" style="background: var(--off-white);">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="small fw-bold mb-2 text-uppercase text-muted" style="letter-spacing: 1px; font-size: 0.7rem;">Número Exterior</label>
                                <input type="text" name="num_exterior" class="form-control border-0 shadow-sm rounded-3 p-3" maxlength="10" style="background: var(--off-white);">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="small fw-bold mb-2 text-uppercase text-muted" style="letter-spacing: 1px; font-size: 0.7rem;">Número Interior (Opcional)</label>
                                <input type="text" name="num_interior" class="form-control border-0 shadow-sm rounded-3 p-3" maxlength="10" style="background: var(--off-white);">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="small fw-bold mb-2 text-uppercase text-muted" style="letter-spacing: 1px; font-size: 0.7rem;">Colonia</label>
                                <input type="text" name="colonia" class="form-control border-0 shadow-sm rounded-3 p-3" maxlength="80" style="background: var(--off-white);">
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold mb-2 text-uppercase text-muted" style="letter-spacing: 1px; font-size: 0.7rem;">Código Postal</label>
                                <input type="text" name="cp" class="form-control border-0 shadow-sm rounded-3 p-3" maxlength="10" style="background: var(--off-white);">
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-bold mb-2 text-uppercase text-muted" style="letter-spacing: 1px; font-size: 0.7rem;">Ciudad</label>
                                <input type="text" name="ciudad" class="form-control border-0 shadow-sm rounded-3 p-3" maxlength="80" style="background: var(--off-white);">
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold mb-2 text-uppercase text-muted" style="letter-spacing: 1px; font-size: 0.7rem;">Estado</label>
                                <input type="text" name="estado_republica" class="form-control border-0 shadow-sm rounded-3 p-3" maxlength="80" style="background: var(--off-white);">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold mb-2 text-uppercase text-muted" style="letter-spacing: 1px; font-size: 0.7rem;">Teléfono</label>
                            <input type="tel" name="telefono" class="form-control border-0 shadow-sm rounded-3 p-3" value="" placeholder="Ej. 238 000 0000" maxlength="20" inputmode="numeric" pattern="[0-9\s\-\+]+" style="background: var(--off-white);">
                        </div>
                    </div>
                </div>
            </div> 
            
            <div class="col-12 col-xl-5">
                <!-- Portafolio Visual -->
                <div class="card border-0 p-4 p-md-5 rounded-4 mb-4 premium-card">
                    <h5 class="fw-bold mb-4 text-dark" style="letter-spacing: -0.5px;"><i class="bi bi-image me-2" style="color: var(--accent-gold);"></i>Imagen Principal del Negocio</h5>
                    <div id="container-foto" style="position: relative; border-radius: 12px; overflow: hidden; margin-bottom: 16px; background: #f0f0f0; min-height: 200px; cursor: pointer; display: flex; align-items: center; justify-content: center;" onclick="document.getElementById('inputFoto').click()">
                        <img id="previewFoto"
                             src=""
                             class="img-fluid w-100 d-none" style="object-fit: cover; height: 200px; transition: opacity 0.2s;">
                        
                        <div id="placeholder-foto" class="text-center p-4">
                            <i class="bi bi-cloud-arrow-up fs-1 text-muted"></i>
                            <p class="text-muted small fw-bold mt-2">Haz clic para subir una foto <br>de tu establecimiento</p>
                        </div>

                        <div id="overlay-foto" class="d-none" style="position: absolute; inset: 0; background: linear-gradient(0deg, rgba(0,0,0,0.35) 0%, transparent 60%); pointer-events: none;"></div>
                        <div id="label-foto" class="d-none" style="position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.55); color: #fff; font-size: 0.78rem; font-weight: 600; padding: 5px 14px; border-radius: 50px; white-space: nowrap; pointer-events: none;">
                            <i class="bi bi-pencil me-1"></i>Cambiar imagen
                        </div>
                    </div>
                    <input type="file" id="inputFoto" name="foto" accept="image/jpg,image/jpeg,image/png" class="d-none">
                    <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i>JPG o PNG · Máx. 2 MB. Esta imagen aparece en la página pública de tu cafetería.</p>
                </div>

                <!-- === TARJETA DE SUSCRIPCIÓN === -->
                <div id="susc-card" class="card border-0 p-4 rounded-4 mb-4 premium-card" style="display:none;">
                    <h5 class="fw-bold mb-4 text-dark" style="letter-spacing: -0.5px;">
                        <i class="bi bi-shield-check me-2" style="color: var(--accent-gold);"></i>Estado de Suscripción
                    </h5>

                    <!-- Estado OK -->
                    <div id="susc-ok" class="d-none">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width:44px;height:44px;background:rgba(40,167,69,0.1);flex-shrink:0;">
                                <i class="bi bi-check-circle-fill" style="color:#28a745;font-size:1.3rem;"></i>
                            </div>
                            <div>
                                <div class="fw-bold" style="color:var(--black-primary);">Activa</div>
                                <div class="small text-muted" id="susc-ok-msg"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Alerta vencimiento -->
                    <div id="susc-alert" class="d-none mb-3 p-3 rounded-3" 
                         style="background:rgba(255,193,7,0.1);border:1px solid rgba(255,193,7,0.35);">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-exclamation-triangle-fill mt-1" style="color:#FFC107;flex-shrink:0;"></i>
                            <div>
                                <div class="fw-bold small" style="color:var(--black-primary);">Suscripción por vencer</div>
                                <div class="small text-muted" id="susc-alert-msg"></div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn w-100 fw-bold" 
                            data-bs-toggle="modal" data-bs-target="#modalRenovarPerfil"
                            style="background:var(--black-primary);color:#fff;border-radius:8px;padding:11px;">
                        <i class="bi bi-arrow-repeat me-2"></i>Renovar Suscripción
                    </button>
                </div>

                <div class="alert alert-info border-0 rounded-4 p-4 shadow-sm" style="background: rgba(212, 175, 55, 0.08);">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle-fill fs-4 me-3" style="color: var(--accent-gold);"></i>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: var(--black-primary);">Recordatorio</h6>
                            <p class="small mb-0 text-muted">Si realizas cualquier cambio en tu información, debes presionar el botón <strong>Guardar Cambios</strong> al final de la página para que se apliquen correctamente.</p>
                        </div>
                    </div>
                </div>


            </div> 
        </div>

        <div class="d-flex justify-content-start mt-4 mb-5">
            <button type="submit" id="btnGuardarPerfil" class="btn btn-dark fw-bold px-5 py-3 shadow-lg rounded-pill" style="font-size: 1.15rem; background-color: var(--accent-gold); color: var(--black-primary); border: none; transition: transform 0.2s; animation: customPulse 2s infinite;">
                Guardar Cambios <i class="bi bi-check-circle ms-2"></i>
            </button>
        </div>
    </form>

    @include('partials.footer_admin')

    <script>
        const API = '/api';
        let authToken = localStorage.getItem('token');
        let cafeteriaId = null;

        function authHeaders() {
            return {
                'Authorization': `Bearer ${authToken}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            };
        }

        async function cargarPerfil() {
            if(!authToken) return;
            try {
                const res = await fetch(`${API}/gerente/mi-cafeteria`, { headers: authHeaders() });
                if (!res.ok) return;
                const json = await res.json();
                
                // Usually wrapped in `data` depending on the controller
                const cafe = json.data || json; 
                cafeteriaId = cafe.id;
                
                // Populate fields
                if (cafe.nombre) document.querySelector('input[name="nombre_franquicia"]').value = cafe.nombre;
                if (cafe.descripcion) document.querySelector('textarea[name="descripcion"]').value = cafe.descripcion;
                if (cafe.calle) document.querySelector('input[name="calle"]').value = cafe.calle;
                if (cafe.num_exterior) document.querySelector('input[name="num_exterior"]').value = cafe.num_exterior;
                if (cafe.num_interior) document.querySelector('input[name="num_interior"]').value = cafe.num_interior;
                if (cafe.colonia) document.querySelector('input[name="colonia"]').value = cafe.colonia;
                if (cafe.cp) document.querySelector('input[name="cp"]').value = cafe.cp;
                if (cafe.ciudad) document.querySelector('input[name="ciudad"]').value = cafe.ciudad;
                if (cafe.estado_republica) document.querySelector('input[name="estado_republica"]').value = cafe.estado_republica;
                if (cafe.telefono) document.querySelector('input[name="telefono"]').value = cafe.telefono;
                if (cafe.foto_url) {
                    document.getElementById('previewFoto').src = `{{ asset('storage') }}/${cafe.foto_url}?v=` + new Date().getTime();
                    document.getElementById('previewFoto').classList.remove('d-none');
                    document.getElementById('placeholder-foto').classList.add('d-none');
                    document.getElementById('overlay-foto').classList.remove('d-none');
                    document.getElementById('label-foto').classList.remove('d-none');
                } else {
                    document.getElementById('previewFoto').classList.add('d-none');
                    document.getElementById('placeholder-foto').classList.remove('d-none');
                    document.getElementById('overlay-foto').classList.add('d-none');
                    document.getElementById('label-foto').classList.add('d-none');
                }
                
            } catch (e) {
                console.error('Error cargando perfil:', e);
            }
        }

        // Live preview al seleccionar foto
        document.getElementById('inputFoto').addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire('Archivo muy grande', 'La imagen no debe superar 2 MB.', 'warning');
                this.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = e => { 
                const preview = document.getElementById('previewFoto');
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                document.getElementById('placeholder-foto').classList.add('d-none');
                document.getElementById('overlay-foto').classList.remove('d-none');
                document.getElementById('label-foto').classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        });

        document.getElementById('formPerfil').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const submitBtn = document.getElementById('btnGuardarPerfil');
            const originalContent = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';
            submitBtn.disabled = true;

            // Usamos FormData para soportar multipart (foto)
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('nombre',          document.querySelector('input[name="nombre_franquicia"]').value);
            formData.append('descripcion',     document.querySelector('textarea[name="descripcion"]').value);
            formData.append('calle',           document.querySelector('input[name="calle"]').value);
            formData.append('num_exterior',    document.querySelector('input[name="num_exterior"]').value);
            formData.append('num_interior',    document.querySelector('input[name="num_interior"]').value);
            formData.append('colonia',         document.querySelector('input[name="colonia"]').value);
            formData.append('cp',              document.querySelector('input[name="cp"]').value);
            formData.append('ciudad',          document.querySelector('input[name="ciudad"]').value);
            formData.append('estado_republica',document.querySelector('input[name="estado_republica"]').value);
            formData.append('telefono',        document.querySelector('input[name="telefono"]').value);

            const fotoInput = document.getElementById('inputFoto');
            if (fotoInput.files.length > 0) {
                formData.append('foto', fotoInput.files[0]);
            }

            // *** Authorization header only — NO Content-Type (el browser lo pone automático con boundary) ***
            try {
                const res = await fetch(`${API}/gerente/mi-cafeteria`, {
                    method: 'POST',   // Laravel necesita POST + _method=PUT para FormData
                    headers: { 'Authorization': `Bearer ${authToken}`, 'Accept': 'application/json' },
                    body: formData
                });
                
                const json = await res.json();
                
                if(!res.ok) {
                    throw new Error(json.message || 'Error al actualizar');
                }

                // Actualizar preview con la foto guardada (si la API devuelve foto_url)
                const cafe = json.data || json;
                if (cafe.foto_url) {
                    document.getElementById('previewFoto').src = `{{ asset('storage') }}/${cafe.foto_url}?v=` + new Date().getTime();
                    fotoInput.value = ''; // resetear input
                }

                Swal.fire({
                    title: '¡Guardado!',
                    text: 'Perfil actualizado correctamente.',
                    icon: 'success',
                    timer: 2200,
                    showConfirmButton: false
                });
                
            } catch (e) {
                Swal.fire({
                    title: 'Error',
                    text: e.message,
                    icon: 'error',
                    confirmButtonColor: '#212529'
                });
            } finally {
                submitBtn.innerHTML = originalContent;
                submitBtn.disabled = false;
            }
        });
        
        // === SUSCRIPCIÓN: mostrar estado ===
        function iniciarSuscripcion() {
            const diasRaw = localStorage.getItem('dias_restantes');
            const card = document.getElementById('susc-card');
            if (!card || diasRaw === null) return;
            const dias = parseInt(diasRaw, 10);
            card.style.display = 'block';
            if (!isNaN(dias) && dias <= 7) {
                document.getElementById('susc-alert').classList.remove('d-none');
                const msgEl = document.getElementById('susc-alert-msg');
                if (dias <= 0)       msgEl.textContent = 'Tu suscripción ya venció. Renueva para continuar usando el sistema.';
                else if (dias === 1) msgEl.textContent = 'Vence mañana — renueva lo antes posible.';
                else                 msgEl.textContent = `Quedan ${dias} días — renueva pronto para no perder el acceso.`;
            } else if (!isNaN(dias) && dias > 7) {
                document.getElementById('susc-ok').classList.remove('d-none');
                document.getElementById('susc-ok-msg').textContent = `${dias} días restantes de tu suscripción.`;
            }
        }

        // === RENOVACIÓN MODAL ===
        let prPlanId = null;
        const PR_API = '/api';

        document.getElementById('modalRenovarPerfil')?.addEventListener('show.bs.modal', () => {
            prPlanId = null;
            document.getElementById('pr-preview').innerHTML = '';
            document.getElementById('pr-file-input').value = '';
            document.getElementById('pr-plan-err').classList.add('d-none');
            document.getElementById('pr-file-err').classList.add('d-none');
            document.getElementById('pr-upload').style.display = 'block';
            prCargarPlanes();
        });

        async function prCargarPlanes() {
            document.getElementById('pr-loading').style.display = 'block';
            document.getElementById('pr-planes').style.display = 'none';
            try {
                const res = await fetch(`${PR_API}/planes-publicos`);
                const json = await res.json();
                const planes = json.data || [];
                const fmt = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' });
                document.getElementById('pr-planes').innerHTML = planes.map(p => `
                    <div class="col-12 col-md-4">
                        <div id="prp-${p.id}" onclick="prSelectPlan(${p.id})"
                             class="card h-100 shadow-sm p-3 text-center"
                             style="cursor:pointer;border:2px solid rgba(0,0,0,0.08);border-radius:12px;transition:all 0.2s;">
                            <h6 class="fw-bold mt-1" style="color:var(--black-primary);font-size:0.85rem;text-transform:uppercase;">${p.nombre_plan}</h6>
                            <div class="fw-bold mb-2" style="color:var(--accent-gold);font-size:1.3rem;">${fmt.format(p.precio)}</div>
                            <ul class="list-unstyled small text-muted mb-0">
                                <li><i class="bi bi-check2 me-1" style="color:var(--accent-gold);"></i>${p.max_reservas_mes} reservas/mes</li>
                                <li><i class="bi bi-check2 me-1" style="color:var(--accent-gold);"></i>Hasta ${p.max_usuarios_admin} usuarios</li>
                                <li><i class="bi bi-check2 me-1" style="color:var(--accent-gold);"></i>${p.duracion_dias} días de vigencia</li>
                            </ul>
                        </div>
                    </div>`).join('');
                document.getElementById('pr-loading').style.display = 'none';
                document.getElementById('pr-planes').style.display = 'flex';
            } catch(e) {
                document.getElementById('pr-loading').innerHTML = '<p class="text-danger small">No se pudieron cargar los planes.</p>';
            }
        }

        function prSelectPlan(id) {
            prPlanId = id;
            document.querySelectorAll('[id^="prp-"]').forEach(el => {
                el.style.borderColor = 'rgba(0,0,0,0.08)';
                el.style.background  = '#fff';
                el.style.boxShadow   = '';
            });
            const sel = document.getElementById(`prp-${id}`);
            if (sel) {
                sel.style.borderColor = 'var(--accent-gold)';
                sel.style.background  = 'rgba(181,146,126,0.06)';
                sel.style.boxShadow   = '0 0 0 3px rgba(181,146,126,0.2)';
            }
            document.getElementById('pr-plan-err').classList.add('d-none');
        }

        function prPreviewFile(input) {
            const preview = document.getElementById('pr-preview');
            if (!input.files.length) { preview.innerHTML = ''; return; }
            const f = input.files[0];
            document.getElementById('pr-upload').style.display = 'none';
            if (f.type.startsWith('image/')) {
                const rd = new FileReader();
                rd.onload = e => {
                    preview.innerHTML = `<div class="text-center">
                        <img src="${e.target.result}" style="max-width:100%;max-height:160px;border-radius:8px;">
                        <div class="small text-muted mt-2">${f.name}</div>
                        <button class="btn btn-sm btn-outline-danger mt-2" onclick="prClearFile()"><i class="bi bi-trash"></i> Quitar</button>
                    </div>`;
                };
                rd.readAsDataURL(f);
            } else {
                preview.innerHTML = `<div class="d-flex align-items-center gap-2 p-3 bg-white rounded-3 border">
                    <i class="bi bi-file-pdf text-danger fs-3"></i>
                    <div class="flex-grow-1 small fw-semibold">${f.name}</div>
                    <button class="btn btn-sm btn-outline-danger" onclick="prClearFile()"><i class="bi bi-trash"></i></button>
                </div>`;
            }
            document.getElementById('pr-file-err').classList.add('d-none');
        }

        function prClearFile() {
            document.getElementById('pr-file-input').value = '';
            document.getElementById('pr-preview').innerHTML = '';
            document.getElementById('pr-upload').style.display = 'block';
        }

        async function prEnviar() {
            if (!prPlanId) { document.getElementById('pr-plan-err').classList.remove('d-none'); return; }
            const fi = document.getElementById('pr-file-input');
            if (!fi.files.length) { document.getElementById('pr-file-err').classList.remove('d-none'); return; }
            const file = fi.files[0];
            if (file.size > 5 * 1024 * 1024) {
                Swal.fire('Archivo muy grande', 'El comprobante no debe superar 5 MB.', 'warning'); return;
            }
            const cafeId = localStorage.getItem('cafe_id') || cafeteriaId;
            if (!cafeId) {
                Swal.fire('Error', 'No se encontró tu cafetería. Cierra sesión e inicia de nuevo.', 'error'); return;
            }
            const btnTxt = document.getElementById('pr-btn-txt');
            const btnLd  = document.getElementById('pr-btn-ld');
            const btnS   = document.getElementById('pr-submit');
            btnTxt.classList.add('d-none'); btnLd.classList.remove('d-none'); btnS.disabled = true;

            const fd = new FormData();
            fd.append('comprobante', file);
            fd.append('plan_id', prPlanId);

            try {
                const res = await fetch(`${PR_API}/registro-negocio/${cafeId}/comprobante`, {
                    method: 'POST', headers: { 'Accept': 'application/json' }, body: fd
                });
                const json = await res.json();
                if (res.ok || res.status === 409) {
                    bootstrap.Modal.getInstance(document.getElementById('modalRenovarPerfil'))?.hide();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Solicitud enviada!',
                        text: 'Tu comprobante fue recibido. El equipo de METRA lo revisará y activará tu suscripción pronto.',
                        confirmButtonColor: '#382C26',
                        confirmButtonText: 'Entendido'
                    });
                } else {
                    Swal.fire('Error al enviar', json.message || 'Intenta de nuevo.', 'error');
                }
            } catch(e) {
                Swal.fire('Error de conexión', e.message, 'error');
            } finally {
                btnTxt.classList.remove('d-none'); btnLd.classList.add('d-none'); btnS.disabled = false;
            }
        }

        cargarPerfil();
        iniciarSuscripcion();

    </script>

    <!-- MODAL RENOVAR SUSCRIPCIÓN -->
    <div class="modal fade" id="modalRenovarPerfil" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0" style="border-radius:16px;overflow:hidden;">
                <div class="modal-header" style="background:var(--black-primary);border:none;padding:24px 28px;">
                    <div>
                        <h5 class="modal-title fw-bold text-white m-0">
                            <i class="bi bi-arrow-repeat me-2" style="color:var(--accent-gold);"></i>Renovar Suscripción
                        </h5>
                        <p class="text-white-50 small mb-0 mt-1">Elige tu plan y sube tu comprobante — el equipo METRA lo revisará.</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" style="background:#fafaf8;">
                    <div class="alert border-0 mb-4 p-3" style="background:rgba(181,146,126,0.1);border-radius:12px;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-info-circle-fill mt-1" style="color:var(--accent-gold);"></i>
                            <div class="small"><strong>Proceso:</strong> Transfiere el monto del plan elegido a la cuenta de METRA, sube tu comprobante y espera la aprobación del equipo.</div>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3" style="color:var(--black-primary);">1. Selecciona tu plan</h6>
                    <div id="pr-loading" class="text-center py-3">
                        <div class="spinner-border spinner-border-sm" style="color:var(--accent-gold);" role="status"></div>
                        <span class="text-muted small ms-2">Cargando planes...</span>
                    </div>
                    <div id="pr-planes" class="row g-3 mb-4" style="display:none;"></div>
                    <div id="pr-plan-err" class="text-danger small d-none mb-3">Debes seleccionar un plan.</div>

                    <h6 class="fw-bold mb-3 mt-2" style="color:var(--black-primary);">2. Comprobante de pago</h6>
                    <div id="pr-upload" class="text-center p-4 rounded-3 mb-3"
                         style="border:2px dashed rgba(56,44,38,0.2);cursor:pointer;background:#fff;"
                         onclick="document.getElementById('pr-file-input').click()">
                        <i class="bi bi-cloud-arrow-up fs-3 d-block mb-2" style="color:var(--accent-gold);"></i>
                        <p class="mb-0 fw-semibold small" style="color:var(--black-primary);">Haz clic para seleccionar</p>
                        <p class="text-muted mb-0" style="font-size:0.78rem;">JPG, PNG o PDF — Máx. 5 MB</p>
                    </div>
                    <input type="file" id="pr-file-input" accept=".jpg,.jpeg,.png,.pdf" class="d-none" onchange="prPreviewFile(this)">
                    <div id="pr-preview" class="mb-3"></div>
                    <div id="pr-file-err" class="text-danger small d-none mb-2">Debes adjuntar tu comprobante.</div>
                </div>
                <div class="modal-footer" style="background:#fafaf8;border-top:1px solid rgba(0,0,0,0.08);padding:16px 28px;">
                    <button class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius:8px;padding:10px 24px;">Cancelar</button>
                    <button type="button" class="btn fw-bold" id="pr-submit" onclick="prEnviar()"
                            style="background:var(--black-primary);color:#fff;border-radius:8px;padding:10px 28px;">
                        <span id="pr-btn-txt"><i class="bi bi-check-circle me-2"></i>Enviar Renovación</span>
                        <span id="pr-btn-ld" class="d-none"><span class="spinner-border spinner-border-sm me-2"></span>Enviando...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection