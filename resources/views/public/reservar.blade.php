<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Reservación Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Flatpickr for Date Selection -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #fdfcfb 0%, #e2d1c3 100%); /* METRA Cream/Gold Gradient */
            color: #111; /* METRA Black */
            min-height: 100vh;
        }
        .text-gold { color: #d4af37; }
        .bg-gold { background-color: #d4af37; }
        
        .reserva-card { 
            background: #ffffff; 
            border-radius: 16px; 
            padding: 3.5rem 3rem; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.08); 
            border: 1px solid rgba(212,175,55,0.1); /* Subtle Gold border */
        }
        
        .page-title {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            color: #111;
            font-size: 2.5rem;
        }

        .section-title { 
            font-weight: 600; 
            font-size: 1.15rem; 
            color: #111; 
            letter-spacing: -0.2px; 
            border-bottom: 2px solid #f0ecdf; /* Creamy divider */
            padding-bottom: 0.75rem; 
            margin-bottom: 2rem; 
        }

        .input-metra { 
            border-radius: 10px; 
            border: 1px solid #e0ddd5; 
            padding: 0.85rem 1.1rem; 
            color: #111; 
            background-color: #faf9f7;
            transition: all 0.2s ease-in-out; 
            font-size: 0.95rem;
        }
        
        .input-group-text.bg-metra-light {
            background-color: #faf9f7;
            border-color: #e0ddd5;
            color: #7b7871;
        }

        .input-metra:focus, .input-group:focus-within .input-metra, .input-group:focus-within .input-group-text { 
            border-color: #d4af37; 
            background-color: #fff;
            outline: 0; 
        }
        
        .input-metra:focus {
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1); 
        }

        .input-metra.is-invalid { 
            border-color: #ef4444; 
            background-color: #fffafb;
        }
        .input-metra.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1); 
        }

        .btn-metra-main { 
            background: linear-gradient(135deg, #2a2a2a 0%, #111 100%);
            color: #d4af37; 
            border-radius: 10px; 
            font-weight: 600; 
            padding: 1.1rem; 
            border: 1px solid #111; 
            transition: all 0.3s ease; 
            letter-spacing: 0.5px; 
            text-transform: uppercase;
            font-size: 0.95rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
        
        .btn-metra-main:hover:not(:disabled) { 
            background: #111; 
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.2);
            border-color: #000;
        }
        
        .btn-metra-main:disabled { 
            background: #e2e8f0; 
            color: #94a3b8;
            border-color: #e2e8f0;
            box-shadow: none;
            cursor: not-allowed; 
        }

        .invalid-feedback-custom { 
            display: none; 
            width: 100%; 
            margin-top: 0.4rem; 
            font-size: 0.8rem; 
            color: #ef4444; 
            font-weight: 500;
        }
        
        .input-metra.is-invalid ~ .invalid-feedback-custom,
        .input-group:has(.is-invalid) ~ .invalid-feedback-custom { 
            display: block; 
        }

        .promo-label { 
            border: 1px solid #e0ddd5; 
            border-radius: 12px; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            background: #fff; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.01);
        }
        
        .promo-label:hover {
            border-color: #d4af37;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(212,175,55,0.05);
        }

        .btn-check:checked + .promo-label { 
            border-color: #d4af37; 
            background-color: #fffbfa; 
            box-shadow: 0 0 0 1px #d4af37, 0 8px 15px rgba(212,175,55,0.08); 
        }
        
        .flatpickr-calendar { 
            font-family: 'Inter', sans-serif; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.1); 
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 10px;
        }
        .flatpickr-day.selected {
            background: #d4af37 !important;
            border-color: #d4af37 !important;
            color: #fff !important;
            font-weight: 600;
        }
        .flatpickr-day.disabled {
            color: #cbd5e1 !important;
        }
        
        .form-label {
            color: #555;
            margin-bottom: 0.4rem;
        }
    </style>
</head>
<body>
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-11 col-lg-9 col-xl-8">
                
                <div class="text-center mb-5 mt-3">
                    <span class="badge text-gold mb-2" style="background: #111; padding: 0.5rem 1rem; font-weight: 600; font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase;">
                        Experiencia Exclusiva METRA
                    </span>
                    <h2 class="page-title mb-2">Reservación de Mesa</h2>
                    <p class="text-muted" style="font-size: 1.1rem; color: #444 !important;">Asegure su lugar completando los siguientes detalles.</p>
                </div>

                <div class="reserva-card">
                    <form id="reserva-form" novalidate>
                        <input type="hidden" id="cafe_slug" value="{{ $slug }}">
                        <input type="hidden" id="cafe_id" value="">

                        <div id="general-error" class="alert alert-danger d-none mb-4" style="border-radius: 10px; font-weight: 500;"></div>

                        <!-- 1. Detalles Experiencia -->
                        <div class="mb-5">
                            <h5 class="section-title">1. Detalles de la Experiencia</h5>
                            <div class="row g-4">
                                <div class="col-12 col-md-4">
                                    <label class="form-label small fw-bold">Invitados *</label>
                                    <select id="invitados-select" class="form-select input-metra" required>
                                        <option value="">Cargando plazas...</option>
                                    </select>
                                    <div class="invalid-feedback-custom">Seleccione el número de invitados.</div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label class="form-label small fw-bold">Fecha *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-metra-light border-end-0"><i class="bi bi-calendar-event"></i></span>
                                        <input type="text" id="fecha-select" class="form-control input-metra border-start-0 ps-0" placeholder="Seleccione invitados primero" required readonly disabled>
                                    </div>
                                    <div class="invalid-feedback-custom">Por favor seleccione una fecha válida.</div>
                                </div>
                                <div class="col-12 col-md-4 position-relative">
                                    <label class="form-label small fw-bold">Hora *</label>
                                    <div class="position-relative">
                                        <select id="hora-select" class="form-select input-metra" required disabled>
                                            <option value="">Seleccione fecha e invitados primero</option>
                                        </select>
                                        <div id="hora-spinner" class="spinner-border text-gold spinner-border-sm position-absolute d-none" style="right: 35px; top: 13px;" role="status"></div>
                                    </div>
                                    <div class="invalid-feedback-custom">Seleccione la hora de reservación.</div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Información del Titular -->
                        <div class="mb-5">
                            <h5 class="section-title">2. Información del Titular</h5>
                            <div class="row g-4">
                                <div class="col-12 col-md-12">
                                    <label class="form-label small fw-bold">Nombre(s) *</label>
                                    <input type="text" id="nombre_cliente" class="form-control input-metra" placeholder="Su nombre" required>
                                    <div class="invalid-feedback-custom">El nombre es obligatorio.</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-bold">Apellido Paterno *</label>
                                    <input type="text" id="apellido_p" class="form-control input-metra" placeholder="Su apellido paterno" required>
                                    <div class="invalid-feedback-custom">El apellido paterno es obligatorio.</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-bold">Apellido Materno</label>
                                    <input type="text" id="apellido_m" class="form-control input-metra" placeholder="(Opcional)">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-bold">Correo electrónico *</label>
                                    <input type="email" id="email" class="form-control input-metra" placeholder="ejemplo@correo.com" required>
                                    <div class="invalid-feedback-custom email-err">Ingrese un correo válido.</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-bold">Teléfono móvil *</label>
                                    <input type="text" id="telefono" class="form-control input-metra" placeholder="10 dígitos numéricos" maxlength="10" required>
                                    <div class="invalid-feedback-custom">El teléfono debe contener exactamente 10 números.</div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Preferencias -->
                        <div class="mb-5">
                            <h5 class="section-title">3. Preferencias Opcionales</h5>
                            <div class="row g-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-bold">¿Celebra una Ocasión Especial?</label>
                                    <select id="ocasion-select" name="ocasion_id" class="form-select input-metra">
                                        <option value="">Ninguna Ocasión</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-bold">Área preferida de la mesa</label>
                                    <select id="zona-select" name="zona_id" class="form-select input-metra">
                                        <option value="">Indiferente (Donde haya cupo)</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Notas al Chef / Gerencia</label>
                                    <textarea id="comentarios" class="form-control input-metra" rows="2" placeholder="Describa alergias, requerimientos dietéticos o solicitudes de arreglo de mesa..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Complementos -->
                        <div class="mb-5">
                            <h5 class="section-title">4. Complementos y Cortesías</h5>
                            <div class="col-12" id="promos-container">
                                <div class="text-center py-5 small" style="background: #faf9f7; border-radius: 12px; border: 1px dashed #e0ddd5; color: #7b7871;">
                                    <i class="bi bi-stars fs-3 d-block mb-3 text-gold"></i>
                                    Seleccione previamente una <strong>ocasión especial</strong> para descubrir atenciones exclusivas preparadas en esta sucursal.
                                </div>
                                <input type="hidden" id="promocion_id" value="">
                            </div>
                        </div>

                        <div class="mt-5 pt-2">
                            <button type="submit" id="btn-submit" class="btn btn-metra-main w-100 py-3 d-flex justify-content-center align-items-center">
                                Confirmar y Reservar
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        function getToken() {
            return localStorage.getItem('token');
        }

        document.addEventListener('DOMContentLoaded', async () => {
            const cafeSlug = document.getElementById('cafe_slug').value;
            const fechaInput = document.getElementById('fecha-select');
            const horaSelect = document.getElementById('hora-select');
            const horaSpinner = document.getElementById('hora-spinner');
            const paxSelect = document.getElementById('invitados-select');
            const form = document.getElementById('reserva-form');
            const ocasionSelect = document.getElementById('ocasion-select');
            const zonaSelect = document.getElementById('zona-select');
            const btnSubmit = document.getElementById('btn-submit');
            const errorContainer = document.getElementById('general-error');
            
            // Inputs Titular
            const iNom = document.getElementById('nombre_cliente');
            const iApP = document.getElementById('apellido_p');
            const iApM = document.getElementById('apellido_m');
            const iEmail = document.getElementById('email');
            const iTel = document.getElementById('telefono');

            const diasMap = {0:'Domingo',1:'Lunes',2:'Martes',3:'Miércoles',4:'Jueves',5:'Viernes',6:'Sábado'};
            let flatpickrInstance = null;
            let disabledDaysNumerico = [];

            // Helper to clean accents "Miércoles" -> "miercoles"
            const normalizarStr = (str) => {
                if(!str) return '';
                return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase().trim();
            };

            const getApiUrl = (endpoint) => `/api/cafeterias/${cafeSlug}/${endpoint}?t=${new Date().getTime()}`;

            // --- VALIDACIONES EN TIEMPO REAL ---
            const requiredInputs = [fechaInput, horaSelect, paxSelect, iNom, iApP, iEmail, iTel];
            
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            function checkFormValidity() {
                // El botón submit se mantiene siempre habilitado 
                // para que el usuario reciba retroalimentación visual al enviar vacíos.
            }

            // Eliminar bordes rojos ON INPUT (cuando se tipea)
            requiredInputs.forEach(input => {
                input.addEventListener('input', () => {
                    // Restricción visual en tiempo real para el teléfono
                    if (input.id === 'telefono') {
                        input.value = input.value.replace(/\D/g, '').substring(0, 10);
                    }
                    input.classList.remove('is-invalid'); // Instant feedback removal
                    checkFormValidity();
                });
                // También al cambiar el select
                input.addEventListener('change', () => {
                    input.classList.remove('is-invalid');
                    checkFormValidity();
                });

                // Si pierde el foco y está vacío o es inválido, pintar rojo
                input.addEventListener('focusout', () => {
                    if(input.value.trim() === '') {
                        input.classList.add('is-invalid');
                    } else if(input.id === 'email' && !validateEmail(input.value.trim())) {
                        input.classList.add('is-invalid');
                    } else if(input.id === 'telefono' && !/^\d{10}$/.test(input.value.replace(/\s/g,''))) {
                        input.classList.add('is-invalid');
                    }
                    checkFormValidity();
                });
            });


            // --- LLAMADAS INICIALES A LA API PARA CONFIGURAR DOM ---
            try {
                // Fetch the actual ID from slug 
                const resC = await fetch(`/api/cafeterias-publicas/${cafeSlug}`);
                if(resC.ok){
                    const jsonC = await resC.json();
                    document.getElementById('cafe_id').value = jsonC.data.id;
                }

                // 1. Horarios Iniciales
                const resH = await fetch(getApiUrl('horarios'));
                if(resH.ok){
                    const jsonH = await resH.json();
                    let operacionHorariosInicial = jsonH.data || [];
                    
                    const activeDaysNames = operacionHorariosInicial.map(h => normalizarStr(h.dia_semana));
                    disabledDaysNumerico = [];
                    Object.keys(diasMap).forEach(num => {
                        const strDay = normalizarStr(diasMap[num]);
                        if(!activeDaysNames.includes(strDay)) {
                            disabledDaysNumerico.push(parseInt(num));
                        }
                    });

                    flatpickrInstance = flatpickr(fechaInput, {
                        locale: "es",
                        minDate: "today",
                        disable: [
                            function(date) {
                                return disabledDaysNumerico.includes(date.getDay());
                            }
                        ],
                        onChange: function(selectedDates, dateStr, instance) {
                            fechaInput.classList.remove('is-invalid'); // Trigger visual cleanup
                            cargarHorasDisponibles();     // USE BACKEND ENDPOINT
                            checkFormValidity();
                        }
                    });
                }

                // 2. Capacidad Máxima (REAL TIME Sin Cache)
                const resM = await fetch(getApiUrl('mesas-capacidad'));
                if(resM.ok){
                    const jsonM = await resM.json();
                    const max = jsonM.data.max_capacidad || 1;
                    paxSelect.innerHTML = '<option value="">Opciones de capacidad...</option>';
                    for(let i=1; i<=max; i++) {
                        paxSelect.innerHTML += `<option value="${i}">${i} Persona${i>1?'s':''}</option>`;
                    }
                    // Si ya hay algo seleccionado o si el usuario elige una opcion, buscaremos el horario
                }

                // 3. Zonas y Ocasiones (Datos estáticos de catálogo)
                const resO = await fetch(getApiUrl('ocasiones'));
                if(resO.ok){
                    const jsonO = await resO.json();
                    jsonO.data.forEach(o => { ocasionSelect.innerHTML += `<option value="${o.id}">${o.nombre}</option>`});
                }

                const resZ = await fetch(getApiUrl('zonas'));
                if(resZ.ok){
                    const jsonZ = await resZ.json();
                    jsonZ.data.forEach(z => { zonaSelect.innerHTML += `<option value="${z.id}">${z.nombre_zona}</option>`});
                }

                // 4. Limpieza: Se ha eliminado el pre-llenado asumiendo perfiles de usuario/gerente,
                // asegurando que los datos de cliente siempre deban ingresarse limpios a petición.
                
            } catch(e) { console.error('Error init', e); }

            // --- SINCRONIZACION DE HORAS DISPONIBLES USANDO API ---
            async function cargarHorasDisponibles() {
                const fecha = fechaInput.value;
                const pax = paxSelect.value;
                
                if (!fecha || !pax) {
                    horaSelect.innerHTML = '<option value="">Seleccione fecha e invitados primero</option>';
                    horaSelect.disabled = true;
                    return;
                }

                horaSelect.innerHTML = '<option value="">Consultando disponibilidad...</option>';
                horaSelect.disabled = true;
                horaSpinner.classList.remove('d-none');

                try {
                    const url = `/api/cafeterias/${cafeSlug}/horarios-disponibles?fecha=${fecha}&numero_personas=${pax}`;
                    const resH = await fetch(url);
                    
                    if (!resH.ok) throw new Error('Error al consultar horarios');
                    const jsonH = await resH.json();
                    
                    const horarios = jsonH.data || [];
                    
                    if (horarios.length === 0) {
                        horaSelect.innerHTML = '<option value="">No hay horarios disponibles</option>';
                        horaSelect.disabled = true;
                        horaSelect.classList.remove('is-invalid');
                    } else {
                        horaSelect.innerHTML = '<option value="">Seleccione un horario</option>';
                        horarios.forEach(hora => {
                            horaSelect.innerHTML += `<option value="${hora}">${hora} hrs</option>`;
                        });
                        horaSelect.disabled = false;
                    }
                    horaSelect.value = '';
                    checkFormValidity();
                } catch(e) {
                    console.error('Error cargando horas', e);
                    horaSelect.innerHTML = '<option value="">Error de conexión</option>';
                } finally {
                    horaSpinner.classList.add('d-none');
                }
            }

            paxSelect.addEventListener('change', () => {
                if(paxSelect.value) {
                    fechaInput.disabled = false;
                    fechaInput.placeholder = "Seleccione día";
                    if(fechaInput.value) {
                        cargarHorasDisponibles();
                    }
                } else {
                    fechaInput.disabled = true;
                    fechaInput.value = '';
                    fechaInput.placeholder = "Seleccione invitados primero";
                    horaSelect.innerHTML = '<option value="">Seleccione fecha e invitados primero</option>';
                    horaSelect.disabled = true;
                }
            });

            // --- PROMOCIONES DINAMICAS DINAMICAS ---
            ocasionSelect.addEventListener('change', async (e) => {
                const oId = e.target.value;
                const pCont = document.getElementById('promos-container');
                if(!oId){ 
                    pCont.innerHTML = '<div class="text-center py-5 small" style="background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1; color: #64748b;"><i class="bi bi-stars fs-3 d-block mb-3 text-gold"></i>Seleccione una <strong>ocasión especial</strong> arriba para descubrir regalos o atenciones.</div><input type="hidden" id="promocion_id" value="">';
                    return; 
                }

                pCont.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-secondary spinner-border-sm"></div><div class="mt-2 text-muted x-small">Cargando beneficios...</div></div>';
                try {
                    // Fetch en tiempo real para no atrapar promociones caducas
                    const resP = await fetch(`/api/cafeterias/${cafeSlug}/ocasiones/${oId}/promociones?t=${new Date().getTime()}`);
                    const jsonP = await resP.json();
                    const promos = jsonP.data || [];

                    if(promos.length === 0){
                        pCont.innerHTML = '<div class="text-center py-5 small" style="background: #f8fafc; border-radius: 12px; border: 1px dashed #cbd5e1; color: #64748b;">No hay complementos disponibles para esta ocasión en este momento.</div><input type="hidden" id="promocion_id" value="">';
                        return;
                    }

                    let ht = '<div class="row g-3"><div class="col-12 col-md-6"><input type="radio" name="promo" id="promo-0" value="" class="btn-check" checked onchange="document.getElementById(\'promocion_id\').value=\'\';"><label class="card h-100 p-4 w-100 promo-label" for="promo-0"><div class="text-center py-2 h-100 d-flex flex-column justify-content-center"><h6 class="fw-bold mb-1" style="color:#334155;">Sin Complemento Adicional</h6></div></label></div>';

                    promos.forEach(p => {
                        const isFree = parseFloat(p.precio) === 0;
                        const dP = isFree ? 'Cortesía' : `$${p.precio}`;
                        ht += `<div class="col-12 col-md-6"><input type="radio" name="promo" id="promo-${p.id}" value="${p.id}" class="btn-check" onchange="document.getElementById('promocion_id').value='${p.id}';"><label class="card h-100 p-4 w-100 promo-label" for="promo-${p.id}"><div class="d-flex justify-content-between mb-3"><span class="badge" style="background: rgba(212,175,55,0.1); color: #d4af37; border: 1px solid rgba(212,175,55,0.2); font-size: 0.8rem; letter-spacing: 0.5px;">${dP}</span></div><h6 class="fw-bold mb-2" style="font-size:1.05rem; color:#1e293b;">${p.nombre_promocion}</h6><p class="small text-muted mb-0" style="font-size: 0.85rem; line-height: 1.4;">${p.descripcion||''}</p></label></div>`;
                    });
                    
                    ht += '</div><input type="hidden" id="promocion_id" value="">';
                    pCont.innerHTML = ht;
                } catch(e) { console.error('Error promos', e); }
            });

            // --- SUBMIT FINAL ---
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                // Forzar validación sucia
                let focusTriggered = false;
                requiredInputs.forEach(input => {
                    if(!input.value.trim()){
                        input.classList.add('is-invalid');
                        if(!focusTriggered) { input.focus(); focusTriggered = true; }
                    } else if(input.id === 'email' && !validateEmail(input.value.trim())) {
                        input.classList.add('is-invalid');
                        if(!focusTriggered) { input.focus(); focusTriggered = true; }
                    } else if(input.id === 'telefono' && !/^\d{10}$/.test(input.value.replace(/\s/g,''))) {
                        input.classList.add('is-invalid');
                        if(!focusTriggered) { input.focus(); focusTriggered = true; }
                    }
                });

                if(focusTriggered) return; // Detener flujo fallido

                errorContainer.classList.add('d-none');
                btnSubmit.disabled = true;
                const originalText = btnSubmit.innerHTML;
                btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Confirmando Reservación...';

                // Concatenar el Nombre Completo para la BD
                const nombreCompleto = `${iNom.value.trim()} ${iApP.value.trim()} ${iApM.value.trim()}`.trim();
                // Limpiar teléfono de espacios
                const telefonoLimpio = iTel.value.replace(/\D/g, '');

                const payload = {
                    fecha: fechaInput.value,
                    hora_inicio: horaSelect.value.length === 5 ? horaSelect.value + ':00' : horaSelect.value,
                    numero_personas: parseInt(paxSelect.value),
                    nombre_cliente: nombreCompleto,
                    email: iEmail.value.trim(),
                    telefono: telefonoLimpio,
                    ocasion_especial_id: ocasionSelect.value ? parseInt(ocasionSelect.value) : null,
                    promocion_id: document.getElementById('promocion_id')?.value ? parseInt(document.getElementById('promocion_id').value) : null,
                    zona_id: zonaSelect.value ? parseInt(zonaSelect.value) : null,
                    comentarios: document.getElementById('comentarios').value.trim(),
                };

                try {
                    // Endpoint correcto
                    const token = getToken();
                    const headers = {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    };
                    if (token) {
                        headers['Authorization'] = `Bearer ${token}`;
                    }

                    const res = await fetch(`/api/cafeterias/${cafeSlug}/reservaciones`, {
                        method: 'POST',
                        headers: headers,
                        body: JSON.stringify(payload)
                    });
                    
                    const json = await res.json();
                    
                    if(res.ok && json.success) {
                        // Mostrar pantalla de confirmación tal como se pidió
                        const rsv = json.data;
                        const cafeNombre = rsv.cafeteria ? rsv.cafeteria.nombre : 'La Cafetería';
                        const zonaP = rsv.zona ? rsv.zona.nombre_zona : 'Área General';
                        const ocasionP = rsv.ocasion_especial ? rsv.ocasion_especial.nombre : 'Sin Ocasión Especial';
                        
                        document.querySelector('.reserva-card').innerHTML = `
                            <div class="text-center py-5 px-3">
                                <div class="mb-4">
                                    <i class="bi bi-check-circle-fill text-gold" style="font-size: 5rem; text-shadow: 0 10px 20px rgba(212,175,55,0.2);"></i>
                                </div>
                                <h3 class="page-title mb-3" style="font-size: 2.2rem;">¡Reserva Confirmada!</h3>
                                <p class="text-muted fs-5 mb-5" style="max-width: 500px; margin: 0 auto;">Tu mesa en <strong>${cafeNombre}</strong> ha sido asegurada. Revisa tu correo electrónico para los detalles formales de acceso.</p>
                                
                                <div class="bg-metra-light rounded-4 p-4 text-start d-inline-block shadow-sm w-100" style="max-width: 480px; border: 1px solid #e0ddd5;">
                                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3" style="border-bottom: 1px dashed #d1c8b3;">
                                        <div>
                                            <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Folio de Acceso</small>
                                            <span class="fw-bold fs-4 text-gold">${rsv.folio || 'N/A'}</span>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">Destino</small>
                                            <span class="fw-bold fs-6 text-dark">${cafeNombre}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="row g-4 mb-2">
                                        <div class="col-6">
                                            <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Fecha</small>
                                            <span class="fw-bold fs-6 cl-dark"><i class="bi bi-calendar-check me-2 text-gold"></i>${payload.fecha}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Horario</small>
                                            <span class="fw-bold fs-6 cl-dark"><i class="bi bi-clock me-2 text-gold"></i>${payload.hora_inicio}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Invitados</small>
                                            <span class="fw-bold fs-6 cl-dark"><i class="bi bi-people me-2 text-gold"></i>${payload.numero_personas} Personas</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Ubicación Preferente</small>
                                            <span class="fw-bold fs-6 cl-dark"><i class="bi bi-geo-alt me-2 text-gold"></i>${zonaP}</span>
                                        </div>
                                        <div class="col-12 mt-4 pt-2" style="border-top: 1px dashed #d1c8b3;">
                                            <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Ocasión Declarada</small>
                                            <span class="badge bg-dark fw-normal px-3 py-2 text-gold" style="font-size: 0.85rem;">${ocasionP}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-5">
                                    <a href="/" class="btn btn-metra-main px-5 py-3 rounded-pill shadow-sm">
                                        Volver al inicio <i class="bi bi-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        `;
                    } else {
                        btnSubmit.disabled = false;
                        btnSubmit.innerHTML = originalText;
                        errorContainer.innerHTML = '<strong>Error en tu solicitud:</strong> ' + (json.message || 'Ocurrió un error en la validación.');
                        if(json.data) {
                            errorContainer.innerHTML += '<ul class="mb-0 mt-2">' + Object.values(json.data).map(err => `<li>${err[0]}</li>`).join('') + '</ul>';
                        }
                        errorContainer.classList.remove('d-none');
                        errorContainer.scrollIntoView({behavior: 'smooth', block: 'center'});
                    }
                } catch(error) {
                    btnSubmit.disabled = false;
                    btnSubmit.innerHTML = originalText;
                    errorContainer.innerHTML = 'Error de conexión con el servidor. Se ha perdido la comunicación con METRA.';
                    errorContainer.classList.remove('d-none');
                }
            });

        });
    </script>
</body>
</html>