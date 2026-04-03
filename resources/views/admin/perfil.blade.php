@extends('admin.menu')
@section('title', 'Configuración de Ecosistema')

@section('content')
    <header class="mb-5 border-bottom pb-4" style="border-color: var(--border-light) !important;">
        <h2 class="fw-bold" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">
            Configuración de mi Negocio</h2>
        <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Gestiona la identidad pública y los datos de
            contacto de tu establecimiento.</p>
    </header>

    <style>
        /* Ajuste para evitar salto visual en validaciones */
        .invalid-feedback {
            position: absolute;
            bottom: -5px;
            left: 12px;
            margin-top: 0;
            z-index: 5;
            line-height: 1.1;
        }

        .col-md-6,
        .col-12,
        .col-md-8,
        .col-md-4,
        .col-md-3 {
            position: relative;
            padding-bottom: 26px !important;
            /* Espacio reservado para que no brinque form */
        }

        @keyframes customPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.4);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(212, 175, 55, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(212, 175, 55, 0);
            }
        }

        #btnGuardarPerfil:hover {
            transform: scale(1.03);
        }
    </style>
    <form id="formPerfil" style="max-width: 1100px;" novalidate>
        <!-- Alerta visual de cambios sin guardar -->
        <div id="dirtyAlert" class="alert alert-warning border-0 rounded-4 p-3 mb-4 d-none align-items-center shadow-sm"
            style="background: #fff8e1; color: #b78a00;">
            <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
            <div>
                <h6 class="fw-bold mb-0">Tienes cambios sin guardar</h6>
                <p class="small mb-0 opacity-75">No olvides presionar el botón "Guardar Cambios" al final de la página.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-xl-7">
                <!-- Información General -->
                <div class="card border-0 p-4 p-md-5 rounded-4 mb-4 premium-card">
                    <h5 class="fw-bold mb-4 text-dark" style="letter-spacing: -0.5px;"><i class="bi bi-shop me-2"
                            style="color: var(--accent-gold);"></i>Identidad Comercial</h5>

                    <div class="mb-4">
                        <label class="small fw-bold mb-2 text-uppercase text-muted"
                            style="letter-spacing: 1px; font-size: 0.7rem;">Nombre del establecimiento</label>
                        <input type="text" class="form-control border-0 shadow-sm rounded-3 p-3" name="nombre_franquicia"
                            value="" placeholder="Cargando..." maxlength="100"
                            style="background: var(--off-white); font-weight: 500; color: var(--black-primary);">
                    </div>

                    <div class="mb-3">
                        <label class="small fw-bold mb-2 text-uppercase text-muted"
                            style="letter-spacing: 1px; font-size: 0.7rem;">Descripción del establecimiento</label>
                        <textarea class="form-control border-0 shadow-sm rounded-3 p-3" name="descripcion" rows="4"
                            maxlength="255" placeholder="Escribe aquí la descripción de tu negocio..."
                            style="background: var(--off-white); font-weight: 400; color: var(--text-main); line-height: 1.6;"></textarea>
                    </div>
                </div>

                <!-- Ubicación -->
                <div class="card border-0 p-4 p-md-5 rounded-4 mb-4 premium-card">
                    <h5 class="fw-bold mb-4 text-dark" style="letter-spacing: -0.5px;"><i class="bi bi-geo-alt me-2"
                            style="color: var(--accent-gold);"></i>Geolocalización Física</h5>

                    <div class="mb-4 pb-4 border-bottom" style="border-color: var(--border-light) !important;">
                        <div class="row g-3 align-items-end mb-3">
                            <div class="col-md-6">
                                <label class="small fw-bold mb-2 text-uppercase text-muted"
                                    style="letter-spacing: 1px; font-size: 0.7rem;">Calle *</label>
                                <input type="text" name="calle" class="form-control border-0 shadow-sm rounded-3 p-3"
                                    placeholder="Ej. Av. Reforma" maxlength="100" style="background: var(--off-white);"
                                    required>
                                <div class="invalid-feedback" style="font-size: 0.75rem;">La calle es obligatoria.</div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="small fw-bold mb-2 text-uppercase text-muted"
                                    style="letter-spacing: 1px; font-size: 0.7rem;">Número Exterior *</label>
                                <input type="text" name="num_exterior" class="form-control border-0 shadow-sm rounded-3 p-3"
                                    maxlength="10" pattern="[a-zA-Z0-9\-\s]+" placeholder="Ej. 12-A"
                                    style="background: var(--off-white);" required>
                                <div class="invalid-feedback" style="font-size: 0.75rem;">Máx 10 letras/núm .</div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="small fw-bold mb-2 text-uppercase text-muted"
                                    style="letter-spacing: 1px; font-size: 0.7rem;">Número Interior (Opcional)</label>
                                <input type="text" name="num_interior" class="form-control border-0 shadow-sm rounded-3 p-3"
                                    maxlength="10" pattern="[a-zA-Z0-9\-\s]+" placeholder="Ej. B"
                                    style="background: var(--off-white);">
                                <div class="invalid-feedback" style="font-size: 0.75rem;">Máx 10 caracteres.</div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-8">
                                <label class="small fw-bold mb-2 text-uppercase text-muted"
                                    style="letter-spacing: 1px; font-size: 0.7rem;">Colonia *</label>
                                <input type="text" name="colonia" class="form-control border-0 shadow-sm rounded-3 p-3"
                                    maxlength="50" pattern="[a-zA-ZÀ-ÿ\s]+" placeholder="Ej. Centro Histórico"
                                    style="background: var(--off-white);" required>
                                <div class="invalid-feedback" style="font-size: 0.75rem;">La colonia es obligatoria.</div>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold mb-2 text-uppercase text-muted"
                                    style="letter-spacing: 1px; font-size: 0.7rem;">Código Postal *</label>
                                <input type="text" name="cp" class="form-control border-0 shadow-sm rounded-3 p-3"
                                    maxlength="5" pattern="\d{5}" placeholder="Ej. 44321"
                                    style="background: var(--off-white);" required>
                                <div class="invalid-feedback" style="font-size: 0.75rem;">Exactamente 5 números.</div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-bold mb-2 text-uppercase text-muted"
                                    style="letter-spacing: 1px; font-size: 0.7rem;">Estado *</label>
                                <select name="estado_republica" id="estado_republica"
                                    class="form-select border-0 shadow-sm rounded-3 p-3"
                                    style="background: var(--off-white);" required>
                                    <option value="">Cargando estados...</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold mb-2 text-uppercase text-muted"
                                    style="letter-spacing: 1px; font-size: 0.7rem;">Ciudad / Municipio *</label>
                                <select name="ciudad" id="ciudad" class="form-select border-0 shadow-sm rounded-3 p-3"
                                    style="background: var(--off-white);" required disabled>
                                    <option value="">Primero selecciona estado...</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold mb-2 text-uppercase text-muted"
                                style="letter-spacing: 1px; font-size: 0.7rem;">Teléfono *</label>
                            <input type="tel" name="telefono" id="inputTelefono"
                                class="form-control border-0 shadow-sm rounded-3 p-3" value=""
                                placeholder="Ej. (443) 123-4567" minlength="14" maxlength="14"
                                style="background: var(--off-white);" required>
                            <div class="invalid-feedback" style="font-size: 0.75rem;">Formato: (XXX) XXX-XXXX. Solo números.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-5">
                <!-- Portafolio Visual -->
                <div class="card border-0 p-4 p-md-5 rounded-4 mb-4 premium-card">
                    <h5 class="fw-bold mb-4 text-dark" style="letter-spacing: -0.5px;"><i class="bi bi-image me-2"
                            style="color: var(--accent-gold);"></i>Imagen Principal del Negocio</h5>
                    <div id="container-foto"
                        style="position: relative; border-radius: 12px; overflow: hidden; margin-bottom: 16px; background: #f0f0f0; min-height: 200px; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                        onclick="document.getElementById('inputFoto').click()">
                        <img id="previewFoto" src="" class="img-fluid w-100 d-none"
                            style="object-fit: cover; height: 200px; transition: opacity 0.2s;">

                        <div id="placeholder-foto" class="text-center p-4">
                            <i class="bi bi-cloud-arrow-up fs-1 text-muted"></i>
                            <p class="text-muted small fw-bold mt-2">Haz clic para subir una foto <br>de tu establecimiento
                            </p>
                        </div>

                        <div id="overlay-foto" class="d-none"
                            style="position: absolute; inset: 0; background: linear-gradient(0deg, rgba(0,0,0,0.35) 0%, transparent 60%); pointer-events: none;">
                        </div>
                        <div id="label-foto" class="d-none"
                            style="position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.55); color: #fff; font-size: 0.78rem; font-weight: 600; padding: 5px 14px; border-radius: 50px; white-space: nowrap; pointer-events: none;">
                            <i class="bi bi-pencil me-1"></i>Cambiar imagen
                        </div>
                    </div>
                    <input type="file" id="inputFoto" name="foto" accept="image/jpg,image/jpeg,image/png" class="d-none">
                    <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i>JPG o PNG · Máx. 2 MB. Esta
                        imagen aparece en la página pública de tu cafetería.</p>
                </div>



                <div class="alert alert-info border-0 rounded-4 p-4 shadow-sm"
                    style="background: rgba(212, 175, 55, 0.08);">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle-fill fs-4 me-3" style="color: var(--accent-gold);"></i>
                        <div>
                            <h6 class="fw-bold mb-1" style="color: var(--black-primary);">Recordatorio</h6>
                            <p class="small mb-0 text-muted">Si realizas cualquier cambio en tu información, debes presionar
                                el botón <strong>Guardar Cambios</strong> al final de la página para que se apliquen
                                correctamente.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="d-flex justify-content-start mt-4 mb-5">
            <button type="submit" id="btnGuardarPerfil" class="btn btn-dark fw-bold px-5 py-3 shadow-lg rounded-pill"
                style="font-size: 1.15rem; background-color: var(--accent-gold); color: var(--black-primary); border: none; transition: transform 0.2s; animation: customPulse 2s infinite;">
                Guardar Cambios <i class="bi bi-check-circle ms-2"></i>
            </button>
        </div>
    </form>

    @include('partials.footer_admin')

    <script>
        let cafeteriaId = null;
        let estadosMunicipiosData = {};
        let isDirty = false;
        let isInitializing = true;

        // Detectar cambios en el formulario
        document.getElementById('formPerfil').addEventListener('input', () => {
            if (isInitializing) return;
            if (!isDirty) {
                isDirty = true;
                const alert = document.getElementById('dirtyAlert');
                alert.classList.remove('d-none');
                alert.classList.add('d-flex');
            }
        });
        document.getElementById('formPerfil').addEventListener('change', () => {
            if (isInitializing) return;
            if (!isDirty) {
                isDirty = true;
                const alert = document.getElementById('dirtyAlert');
                alert.classList.remove('d-none');
                alert.classList.add('d-flex');
            }
        });

        // Alerta de cambios sin guardar
        // Phone Masking Logic (XXX) XXX-XXXX
        const inputTelefono = document.getElementById('inputTelefono');
        if (inputTelefono) {
            inputTelefono.addEventListener('input', function (e) {
                let x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            });
        }

        // Restriction formats for numbers only in CP
        document.querySelector('input[name="cp"]').addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Strict letters only for Colonia
        document.querySelector('input[name="colonia"]').addEventListener('input', function (e) {
            this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, '');
        });

        // Strict limits for num_exterior and num_interior to block infinite text manually
        document.querySelector('input[name="num_exterior"]').addEventListener('input', function (e) {
            this.value = this.value.replace(/[^a-zA-Z0-9\-\s]/g, '').substring(0, 10);
        });
        document.querySelector('input[name="num_interior"]').addEventListener('input', function (e) {
            this.value = this.value.replace(/[^a-zA-Z0-9\-\s]/g, '').substring(0, 10);
        });

        window.addEventListener('beforeunload', (e) => {
            if (isDirty) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        async function cargarEstadosMunicipios() {
            try {
                const res = await fetch('/data/estados-municipios.json');
                estadosMunicipiosData = await res.json();

                const estadoSelect = document.getElementById('estado_republica');
                const ciudadSelect = document.getElementById('ciudad');

                estadoSelect.innerHTML = '<option value="">Selecciona un estado...</option>';
                Object.keys(estadosMunicipiosData).sort().forEach(estado => {
                    const option = document.createElement('option');
                    option.value = estado;
                    // Truncar si es muy largo (ej. Veracruz de Ignacio de la Llave)
                    option.textContent = estado.length > 30 ? estado.substring(0, 28) + '...' : estado;
                    estadoSelect.appendChild(option);
                });

                estadoSelect.addEventListener('change', function () {
                    const estado = this.value;
                    ciudadSelect.innerHTML = '<option value="">Selecciona un municipio...</option>';

                    if (estado && estadosMunicipiosData[estado]) {
                        ciudadSelect.disabled = false;
                        estadosMunicipiosData[estado].sort().forEach(municipio => {
                            const option = document.createElement('option');
                            option.value = municipio;
                            option.textContent = municipio.length > 30 ? municipio.substring(0, 28) + '...' : municipio;
                            ciudadSelect.appendChild(option);
                        });
                    } else {
                        ciudadSelect.innerHTML = '<option value="">Primero selecciona estado...</option>';
                        ciudadSelect.disabled = true;
                    }
                });
            } catch (e) {
                console.error("Error cargando estados y municipios", e);
            }
        }



        const trySelectOption = (selectEl, targetValue) => {
            if (!targetValue) return;
            selectEl.value = targetValue;
            if (!selectEl.value) {
                const sanitizeStr = str => str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").trim().toLowerCase();
                const targetSanitized = sanitizeStr(targetValue);
                const match = Array.from(selectEl.options).find(opt => sanitizeStr(opt.value) === targetSanitized);
                if (match) selectEl.value = match.value;
            }
        };

        async function cargarPerfil() {
            try {
                blockDirty = true; // Prevenir alerta visual al cargar datos
                const res = await MetraAPI.get('/gerente/mi-cafeteria');
                const cafe = res.data || res;
                cafeteriaId = cafe.id;

                // Populate fields
                if (cafe.nombre) document.querySelector('input[name="nombre_franquicia"]').value = cafe.nombre;
                if (cafe.descripcion) document.querySelector('textarea[name="descripcion"]').value = cafe.descripcion;
                if (cafe.calle) document.querySelector('input[name="calle"]').value = cafe.calle;
                if (cafe.num_exterior) document.querySelector('input[name="num_exterior"]').value = cafe.num_exterior;
                if (cafe.num_interior) document.querySelector('input[name="num_interior"]').value = cafe.num_interior;
                if (cafe.colonia) document.querySelector('input[name="colonia"]').value = cafe.colonia;
                if (cafe.cp) document.querySelector('input[name="cp"]').value = cafe.cp;
                if (cafe.estado_republica) {
                    const estadoSelect = document.querySelector('select[name="estado_republica"]');
                    if (estadoSelect) {
                        trySelectOption(estadoSelect, cafe.estado_republica);
                        // Forzar el disparo del evento manual para que se carguen los municipios
                        estadoSelect.dispatchEvent(new Event('change'));

                        // Una vez pobladas las ciudades por el evento change, asignamos la ciudad
                        if (cafe.ciudad) {
                            const ciudadSelect = document.querySelector('select[name="ciudad"]');
                            if (ciudadSelect) {
                                trySelectOption(ciudadSelect, cafe.ciudad);
                            }
                        }
                    }
                } else if (cafe.ciudad) {
                    // Fallback si por alguna razón el estado no viene pero la ciudad sí
                    const ciudadSelect = document.querySelector('select[name="ciudad"]');
                    if (ciudadSelect) {
                        ciudadSelect.disabled = false;
                        const opt = document.createElement('option');
                        opt.value = cafe.ciudad;
                        opt.textContent = cafe.ciudad;
                        opt.selected = true;
                        ciudadSelect.appendChild(opt);
                        trySelectOption(ciudadSelect, cafe.ciudad);
                    }
                }

                if (cafe.telefono) {
                    let telRaw = cafe.telefono.toString().replace(/\D/g, '');
                    let x = telRaw.match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                    if (x) {
                        let formattedTel = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
                        document.querySelector('input[name="telefono"]').value = formattedTel;
                    }
                }

                if (cafe.foto_url) {
                    const fotoSrc = cafe.foto_url.startsWith('http') ? cafe.foto_url : `/storage/${cafe.foto_url}?v=` + new Date().getTime();
                    document.getElementById('previewFoto').src = fotoSrc;
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
            } finally {
                // Finalizamos la inicialización para permitir el dirty checker
                setTimeout(() => { isInitializing = false; }, 200);
            }
        }

        // Live preview al seleccionar foto
        document.getElementById('inputFoto').addEventListener('change', function () {
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

            const formObj = e.target;

            // Limpiamos espacios en blanco extremos antes de validar
            Array.from(formObj.querySelectorAll('input[type="text"], input[type="tel"], textarea')).forEach(el => {
                if (el.value) el.value = el.value.trim();
            });

            if (!formObj.checkValidity()) {
                formObj.classList.add('was-validated');
                Swal.fire('Atención', 'Verifica los campos marcados en rojo en el formulario.', 'warning');
                return;
            }

            const submitBtn = document.getElementById('btnGuardarPerfil');
            const originalContent = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';
            submitBtn.disabled = true;

            // Usamos FormData para soportar multipart (foto)
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('nombre', document.querySelector('input[name="nombre_franquicia"]').value);
            formData.append('descripcion', document.querySelector('textarea[name="descripcion"]').value);
            formData.append('calle', document.querySelector('input[name="calle"]').value);
            formData.append('num_exterior', document.querySelector('input[name="num_exterior"]').value);
            formData.append('num_interior', document.querySelector('input[name="num_interior"]').value);
            formData.append('colonia', document.querySelector('input[name="colonia"]').value);
            formData.append('cp', document.querySelector('input[name="cp"]').value);
            formData.append('ciudad', document.querySelector('select[name="ciudad"]').value);
            formData.append('estado_republica', document.querySelector('select[name="estado_republica"]').value);

            // Enviamos el teléfono completamente limpio al servidor (Puros números)
            const telRaw = document.querySelector('input[name="telefono"]').value;
            formData.append('telefono', telRaw.replace(/\D/g, ''));

            const fotoInput = document.getElementById('inputFoto');
            if (fotoInput.files.length > 0) {
                formData.append('foto', fotoInput.files[0]);
            }

            try {
                const res = await MetraAPI.post('/gerente/mi-cafeteria', formData);

                // Actualizar preview con la foto guardada (si la API devuelve foto_url)
                const cafe = res.data || res;
                if (cafe.foto_url) {
                    const fotoSrc = cafe.foto_url.startsWith('http') ? cafe.foto_url : `/storage/${cafe.foto_url}?v=` + new Date().getTime();
                    document.getElementById('previewFoto').src = fotoSrc;
                    fotoInput.value = ''; // resetear input
                }

                Swal.fire({
                    title: '¡Guardado!',
                    text: 'Perfil actualizado correctamente.',
                    icon: 'success',
                    timer: 2200,
                    showConfirmButton: false
                });

                isDirty = false; // Resetear bandera al guardar exitosamente
                const alert = document.getElementById('dirtyAlert');
                alert.classList.add('d-none');
                alert.classList.remove('d-flex');

            } catch (e) {
                let errorMsg = 'Error al actualizar';
                if (e.data?.errors) {
                    errorMsg = Object.values(e.data.errors).flat().join(' | ');
                } else if (e.data?.message) {
                    errorMsg = e.data.message;
                } else if (e.message) {
                    errorMsg = e.message;
                }
                Swal.fire({
                    title: 'Error',
                    text: errorMsg,
                    icon: 'error',
                    confirmButtonColor: '#212529'
                });
            } finally {
                submitBtn.innerHTML = originalContent;
                submitBtn.disabled = false;
            }
        });

        document.addEventListener('DOMContentLoaded', async () => {
            await cargarEstadosMunicipios();
            cargarPerfil();
        });

    </script>


@endsection