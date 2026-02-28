@extends('admin.menu')
@section('title', 'Configuración de Ecosistema')

@section('content')
    <header class="mb-5 border-bottom pb-4" style="border-color: var(--border-light) !important;">
        <h2 class="fw-bold" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Configuración de Ecosistema</h2>
        <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Gestiona la identidad pública y oferta de Café Central.</p>
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
                        <input type="text" class="form-control border-0 shadow-sm rounded-3 p-3" name="nombre_franquicia" value="Café Central Tehuacán" maxlength="100" style="background: var(--off-white); font-weight: 500; color: var(--black-primary);">
                    </div>
                    
                    <div class="mb-3">
                        <label class="small fw-bold mb-2 text-uppercase text-muted" style="letter-spacing: 1px; font-size: 0.7rem;">Descripción del establecimiento</label>
                        <textarea class="form-control border-0 shadow-sm rounded-3 p-3" name="descripcion" rows="4" maxlength="255" style="background: var(--off-white); font-weight: 400; color: var(--text-main); line-height: 1.6;">Fusionamos granos locales con panadería artesanal. Un ambiente perfecto para trabajar o reunirse con amigos en el corazón de la ciudad.</textarea>
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
                            <input type="tel" name="telefono" class="form-control border-0 shadow-sm rounded-3 p-3" value="238 123 4567" maxlength="20" inputmode="numeric" pattern="[0-9\s\-\+]+" style="background: var(--off-white);">
                        </div>
                    </div>
                </div>
            </div> 
            
            <div class="col-12 col-xl-5">
                <!-- Portafolio Visual -->
                <div class="card border-0 p-4 p-md-5 rounded-4 mb-4 premium-card">
                    <h5 class="fw-bold mb-4 text-dark" style="letter-spacing: -0.5px;"><i class="bi bi-image me-2" style="color: var(--accent-gold);"></i>Imagen Principal del Negocio</h5>
                    <div style="position: relative; border-radius: 12px; overflow: hidden; margin-bottom: 16px; background: var(--off-white); min-height: 200px; cursor: pointer;" onclick="document.getElementById('inputFoto').click()">
                        <img id="previewFoto"
                             src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=800"
                             class="img-fluid w-100" style="object-fit: cover; height: 200px; transition: opacity 0.2s;">
                        <div style="position: absolute; inset: 0; background: linear-gradient(0deg, rgba(0,0,0,0.35) 0%, transparent 60%); pointer-events: none;"></div>
                        <div style="position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.55); color: #fff; font-size: 0.78rem; font-weight: 600; padding: 5px 14px; border-radius: 50px; white-space: nowrap; pointer-events: none;">
                            <i class="bi bi-pencil me-1"></i>Cambiar imagen
                        </div>
                    </div>
                    <input type="file" id="inputFoto" name="foto" accept="image/jpg,image/jpeg,image/png" class="d-none">
                    <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i>JPG o PNG · Máx. 2 MB. Esta imagen aparece en la página pública de tu cafetería.</p>
                </div>

                <!-- Highlights Menú -->
                <div class="card border-0 p-4 p-md-5 rounded-4 mb-4 premium-card">
                    <h5 class="fw-bold mb-4 text-dark" style="letter-spacing: -0.5px;"><i class="bi bi-star me-2" style="color: var(--accent-gold);"></i>Destacados Menú</h5>
                    
                    <div class="d-flex align-items-center mb-3 p-2 rounded-3" style="border: 1px solid var(--border-light); background: var(--off-white);">
                        <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=100" class="rounded-2 me-3" width="50" style="height: 50px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-bold small text-dark">Expreso Doble Origen</p>
                            <span class="badge" style="background: var(--white-pure); color: var(--text-muted); border: 1px solid var(--border-light); font-size: 0.6rem;">Item Frecuente</span>
                        </div>
                        <button class="btn btn-link text-danger p-0 ms-2"><i class="bi bi-x-circle"></i></button>
                    </div>
                    
                    <div class="d-flex align-items-center mb-4 p-2 rounded-3" style="border: 1px solid var(--border-light); background: transparent;">
                        <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?w=100" class="rounded-2 me-3" width="50" style="height: 50px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <p class="mb-0 fw-bold small text-dark">Chilaquiles Suizos VIP</p>
                            <span class="badge" style="background: var(--white-pure); color: var(--text-muted); border: 1px solid var(--border-light); font-size: 0.6rem;">Item Frecuente</span>
                        </div>
                         <button class="btn btn-link text-danger p-0 ms-2"><i class="bi bi-x-circle"></i></button>
                    </div>
                    
                    <button type="button" class="btn-admin-secondary w-100 py-2">
                        <i class="bi bi-plus me-1"></i>Incorporar Platillo
                    </button>
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
                    document.getElementById('previewFoto').src = '/storage/' + cafe.foto_url;
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
            reader.onload = e => { document.getElementById('previewFoto').src = e.target.result; };
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
                    document.getElementById('previewFoto').src = '/storage/' + cafe.foto_url;
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
        
        cargarPerfil();
    </script>
@endsection