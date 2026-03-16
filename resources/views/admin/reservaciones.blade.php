@extends('admin.menu')
@section('title', 'Dashboard de Reservaciones')

@section('content')
    <header class="mb-4 border-bottom pb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3" style="border-color: var(--border-light) !important;">
        <div>
            <h2 class="fw-bold" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Monitor Táctico</h2>
            <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Dashboard de alto rendimiento en tiempo real.</p>
        </div>
    </header>

    <!-- Header Stats (Hoy de un vistazo) -->
    <div class="row mb-5 g-3">
        <div class="col-md-3">
            <div class="p-4 rounded-4 shadow-sm" style="background: var(--white-pure); border: 1px solid var(--border-light); height: 100%;">
                <div class="d-flex align-items-center mb-2">
                    <div style="width: 40px; height: 40px; background: rgba(212,175,55,0.1); border-radius: 50%; color: #d4af37;" class="d-flex align-items-center justify-content-center me-3">
                        <i class="bi bi-people-fill fs-5"></i>
                    </div>
                    <span class="text-muted fw-bold" style="letter-spacing: 0.5px; font-size: 0.85rem; text-transform: uppercase;">Aforo Esperado</span>
                </div>
                <h3 class="fw-bold m-0" style="color: var(--black-primary); font-size: 2rem;" id="statTotalPersonas">...</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 rounded-4 shadow-sm" style="background: var(--white-pure); border: 1px solid var(--border-light); height: 100%;">
                <div class="d-flex align-items-center mb-2">
                    <div style="width: 40px; height: 40px; background: rgba(0,0,0,0.05); border-radius: 50%; color: var(--black-primary);" class="d-flex align-items-center justify-content-center me-3">
                        <i class="bi bi-clock-history fs-5"></i>
                    </div>
                    <span class="text-muted fw-bold" style="letter-spacing: 0.5px; font-size: 0.85rem; text-transform: uppercase;">Próxima Reserva</span>
                </div>
                <h5 class="fw-bold m-0" style="color: var(--black-primary); font-size: 1.2rem;" id="statProxima">...</h5>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-4 rounded-4 shadow-sm" style="background: var(--white-pure); border: 1px solid var(--border-light); height: 100%;">
                <div class="d-flex align-items-center mb-2">
                    <div style="width: 40px; height: 40px; background: rgba(46,125,50,0.1); border-radius: 50%; color: #2e7d32;" class="d-flex align-items-center justify-content-center me-3">
                        <i class="bi bi-cup-hot-fill fs-5"></i>
                    </div>
                    <span class="text-muted fw-bold" style="letter-spacing: 0.5px; font-size: 0.85rem; text-transform: uppercase;">En curso</span>
                </div>
                <h3 class="fw-bold m-0" style="color: var(--black-primary); font-size: 2rem;" id="statEnCurso">...</h3>
            </div>
        </div>
        <div class="col-md-3" id="panel-selector-dia">
            <div class="p-4 rounded-4 shadow-sm d-flex flex-column justify-content-center" style="background: linear-gradient(135deg, #111, #2a2a2a); border: 1px solid #000; height: 100%;">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div>
                        <span class="text-white-50 fw-bold d-block mb-1" style="letter-spacing: 0.5px; font-size: 0.8rem; text-transform: uppercase;">Selector de Día</span>
                        <div class="d-flex align-items-center" style="cursor: pointer;" onclick="document.getElementById('inputDate').showPicker()">
                            <h5 class="fw-bold m-0 text-white" id="dateDisplay" style="font-family: 'Inter', sans-serif;">Cargando...</h5>
                            <i class="bi bi-calendar-event ms-2 text-warning"></i>
                        </div>
                        <input type="date" id="inputDate" style="position: absolute; opacity: 0; width: 0; height: 0; padding: 0; border: none;">
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <button class="btn btn-sm btn-outline-light rounded-circle btn-day-nav d-flex align-items-center justify-content-center" data-offset="-1" style="width: 32px; height: 32px;"><i class="bi bi-chevron-up"></i></button>
                        <button class="btn btn-sm btn-outline-light rounded-circle btn-day-nav d-flex align-items-center justify-content-center" data-offset="1" style="width: 32px; height: 32px;"><i class="bi bi-chevron-down"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leyenda de colores -->
    <div class="d-flex flex-wrap gap-3 mb-4 px-2" style="font-size: 0.85rem; font-weight: 600;">
        <span class="d-flex align-items-center text-muted"><i class="bi bi-circle-fill me-2 border border-secondary" style="color: #fff; border-radius: 50%;"></i> Programada (Futura)</span>
        <span class="d-flex align-items-center text-muted"><i class="bi bi-circle-fill me-2 p-1" style="background: #fdf3d8; color: #d4af37; border-radius: 50%;"></i> Llegando (< 30 min)</span>
        <span class="d-flex align-items-center text-muted"><i class="bi bi-circle-fill me-2 p-1" style="background: #e8f5e9; color: #2e7d32; border-radius: 50%;"></i> En curso (Activa)</span>
        <span class="d-flex align-items-center text-muted"><i class="bi bi-circle-fill me-2 p-1" style="background: #f5f5f5; color: #9e9e9e; border-radius: 50%;"></i> Finalizada (Pasada)</span>
    </div>

    <!-- Tabs Navegación -->
    <div class="d-flex gap-2 mb-4 px-2">
        <button class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm" id="btn-modo-dia" onclick="cambiarModo('dia')" style="font-family: 'Inter', sans-serif;">Vista por Día</button>
        <button class="btn btn-outline-dark rounded-pill px-4 fw-bold shadow-sm" id="btn-modo-futuras" onclick="cambiarModo('futuras')" style="font-family: 'Inter', sans-serif;">Próximas Reservas</button>
    </div>

    <!-- Grid Layout -->
    <div class="card p-0 border-0 bg-transparent mb-5">
        <div id="reservaciones-grid" class="row g-4">
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-muted" role="status"></div>
                <p class="mt-2 text-muted fw-bold small">SINCRONIZANDO AGENDA...</p>
            </div>
        </div>
    </div>

    <!-- Modal Detalles de Reserva -->
    <div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.15);">
          <div class="modal-header border-bottom flex-column align-items-start" style="background: linear-gradient(135deg, #fdfcfb, #e2d1c3); border-radius: 16px 16px 0 0; padding: 2rem;">
            <button type="button" class="btn-close ms-auto position-absolute" style="top: 15px; right: 15px;" data-bs-dismiss="modal" aria-label="Close"></button>
            <span class="badge bg-dark fw-bold px-3 py-2 mb-3 shadow-sm rounded-pill font-monospace" id="m_folio">#FOLIO</span>
            <h3 class="modal-title fw-bold" id="m_nombre" style="font-family: 'Inter', sans-serif; color: var(--black-primary);">Nombre del Cliente</h3>
            <p class="m-0 text-muted fw-bold" id="m_estado_texto"><i class="bi bi-circle-fill me-1"></i> Estado</p>
          </div>
          <div class="modal-body p-4 text-start">
             <div class="row g-3">
                 <div class="col-6">
                     <p class="text-muted small mb-1 fw-bold">HORARIO</p>
                     <p class="fw-bold fs-5 shadow-sm rounded-3 p-2 bg-light text-center" style="border: 1px solid var(--border-light);" id="m_hora">00:00</p>
                 </div>
                 <div class="col-6">
                     <p class="text-muted small mb-1 fw-bold">INVITADOS</p>
                     <p class="fw-bold fs-5 shadow-sm rounded-3 p-2 bg-light text-center" style="border: 1px solid var(--border-light);" id="m_pax">0</p>
                 </div>
                 <div class="col-12 mt-4">
                     <p class="text-muted small mb-1 fw-bold">CONTACTO</p>
                     <div class="d-flex align-items-center mb-2 px-3 py-2 rounded-3" style="background: rgba(0,0,0,0.02); border: 1px solid var(--border-light);">
                         <i class="bi bi-telephone-fill me-3" style="color: #d4af37;"></i>
                         <span class="fw-bold" id="m_telefono">...</span>
                     </div>
                     <div class="d-flex align-items-center px-3 py-2 rounded-3" style="background: rgba(0,0,0,0.02); border: 1px solid var(--border-light);">
                         <i class="bi bi-envelope-fill me-3" style="color: #d4af37;"></i>
                         <span class="fw-bold" id="m_email">...</span>
                     </div>
                 </div>
                 <div class="col-12 mt-3" id="m_comentarios_box">
                     <p class="text-muted small mb-1 fw-bold">NOTAS/OCASIÓN</p>
                     <p class="fst-italic p-3 rounded-3" style="background: #fff8e1; border-left: 4px solid #d4af37;" id="m_comentarios">...</p>
                 </div>
             </div>
          </div>
          <div class="modal-footer border-0 p-4 pt-0">
            <button type="button" class="btn text-white w-100 fw-bold py-2 rounded-3 shadow-sm" style="background: #111;" data-bs-dismiss="modal">CERRAR DETALLES</button>
          </div>
        </div>
      </div>
    </div>

    @include('partials.footer_admin')
    
    <script>
        let currentDate = new Date();
        // Variables globales para el modal
        let reservasGlobales = [];
        let modoVista = 'dia';

        function cambiarModo(modo) {
            modoVista = modo;
            if (modo === 'dia') {
                document.getElementById('btn-modo-dia').classList.replace('btn-outline-dark', 'btn-dark');
                document.getElementById('btn-modo-futuras').classList.replace('btn-dark', 'btn-outline-dark');
                document.getElementById('panel-selector-dia').style.display = 'flex';
                updateDateUI();
            } else {
                document.getElementById('btn-modo-futuras').classList.replace('btn-outline-dark', 'btn-dark');
                document.getElementById('btn-modo-dia').classList.replace('btn-dark', 'btn-outline-dark');
                document.getElementById('panel-selector-dia').style.display = 'none';
                fetchReservaciones('', 'futuras');
            }
        }

        function formatDisplayDate(dateObj) {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const todayStr = new Date().toDateString();
            const dateStr = dateObj.toDateString();
            let finalStr = dateObj.toLocaleDateString('es-ES', options);
            if(todayStr === dateStr) {
                return 'HOY';
            } else {
                return finalStr.toUpperCase();
            }
        }

        function parseTimeStringToDate(timeStr, dateObj) {
            // Convierte "14:30:00" y la fecha actual a un objeto Date real para comparar
            const [hours, minutes] = timeStr.split(':');
            let d = new Date(dateObj.getTime());
            d.setHours(parseInt(hours), parseInt(minutes), 0, 0);
            return d;
        }

        function calcularEstadoReserva(horaInicioStr, horaFinStr, dateObj) {
            const now = new Date(); // Hora real actual
            
            // Creamos un Date que junte la fecha de la reserva con su hora de inicio real
            const start = parseTimeStringToDate(horaInicioStr, dateObj);
            
            let end = null;
            if(horaFinStr) {
                end = parseTimeStringToDate(horaFinStr, dateObj);
            } else {
                end = new Date(start.getTime() + (2 * 60 * 60 * 1000));
            }

            const thirtyMinsBefore = new Date(start.getTime() - (30 * 60 * 1000));

            // Si el fin de la reserva es estrictamente anterior al mismísimo momento actual (time real), ya pasó.
            if (end < now) {
                return 'finalizada'; 
            }
            if (now >= start && now <= end) {
                return 'curso'; // Ya empezó
            } else if (now >= thirtyMinsBefore && now < start) {
                return 'llegando'; // Faltan menos de 30 mins
            } else if (now > end) {
                return 'finalizada'; // Ya pasó la hora de fin
            } else {
                return 'programada'; // Faltan más de 30 mins
            }
        }

        function getStatusStyling(estadoStr) {
            switch(estadoStr) {
                case 'curso':
                    return { bg: '#e8f5e9', border: '#81c784', text: '#2e7d32', shadow: '0 5px 15px rgba(46,125,50,0.1)', badgeBg: '#2e7d32', badgeText: '#fff', label: 'En Curso' };
                case 'llegando':
                    return { bg: '#fdf3d8', border: '#f3ca63', text: '#b58500', shadow: '0 5px 15px rgba(212,175,55,0.15)', badgeBg: '#d4af37', badgeText: '#fff', label: 'Por Llegar' };
                case 'finalizada':
                    return { bg: '#f9f9f9', border: '#e0e0e0', text: '#9e9e9e', shadow: 'none', badgeBg: '#e0e0e0', badgeText: '#757575', label: 'Finalizada' };
                default: 
                case 'programada':
                    return { bg: '#ffffff', border: '#e6e6e6', text: '#111', shadow: '0 4px 10px rgba(0,0,0,0.03)', badgeBg: '#f0f0f0', badgeText: '#555', label: 'Programada' };
            }
        }

        function abrirDetalles(idReserva) {
            const r = reservasGlobales.find(x => x.id === idReserva);
            if(!r) return;

            // Calcular el estado en tiempo real al abrir
            const rsrvDate = new Date(r.fecha + 'T00:00:00');
            const estadoActual = calcularEstadoReserva(r.hora_inicio, r.hora_fin, rsrvDate);
            const estilos = getStatusStyling(estadoActual);

            document.getElementById('m_folio').textContent = r.folio || '#N/A';
            document.getElementById('m_nombre').textContent = r.nombre_cliente;
            
            document.getElementById('m_estado_texto').innerHTML = `<i class="bi bi-circle-fill me-1" style="color: ${estilos.badgeBg};"></i> ${estilos.label}`;
            
            document.getElementById('m_hora').textContent = r.hora_inicio.substring(0,5) + ' hrs';
            document.getElementById('m_pax').textContent = r.numero_personas + ' Personas';
            document.getElementById('m_telefono').textContent = r.telefono;
            document.getElementById('m_email').textContent = r.email;
            
            let notas = [];
            if(r.zona && r.zona.nombre_zona) notas.push('Zona: ' + r.zona.nombre_zona);
            else if(r.zona_id) notas.push('Zona: Asignada');
            
            if(r.ocasion && r.ocasion.nombre) notas.push('Ocasión: ' + r.ocasion.nombre);
            
            if(r.comentarios) notas.push(r.comentarios);
            
            if(notas.length > 0) {
                document.getElementById('m_comentarios').textContent = notas.join(' | ');
                document.getElementById('m_comentarios_box').style.display = 'block';
            } else {
                document.getElementById('m_comentarios_box').style.display = 'none';
            }

            const modal = new bootstrap.Modal(document.getElementById('modalReserva'));
            modal.show();
        }

        function renderizarTarjetas(reservaciones) {
            const grid = document.getElementById('reservaciones-grid');
            reservasGlobales = reservaciones;

            if(reservaciones.length === 0) {
                grid.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <h4 class="fw-bold" style="color: var(--black-primary); font-family: 'Inter', sans-serif;">Todo tranquilo por ahora.</h4>
                        <p class="text-muted">¡Prepárate o descansa para el siguiente flujo de invitados!</p>
                    </div>
                `;
                return;
            }

            let html = '';
            
            // Renderizamos por tarjeta suelta en un layout grid masonry-ish
            reservaciones.forEach(r => {
                const rsrvDate = new Date(r.fecha + 'T00:00:00');
                const estado = calcularEstadoReserva(r.hora_inicio, r.hora_fin, rsrvDate);
                
                // DEBUG: Imprimir en consola para diagnosticar
                if (modoVista === 'futuras') {
                    const debugEnd = r.hora_fin ? parseTimeStringToDate(r.hora_fin, rsrvDate) : new Date(parseTimeStringToDate(r.hora_inicio, rsrvDate).getTime() + (2*60*60*1000));
                    console.log(`[DEBUG PRÓXIMAS] Reserva: ${r.nombre_cliente} | fecha: ${r.fecha} | hora: ${r.hora_inicio} | end: ${debugEnd.toString()} | now: ${new Date().toString()} | estado: ${estado}`);
                }

                // PRUEBA MAESTRA: Mostrar TODAS sin filtrar para confirmar que el JSON las trae
                // (Descomenta el bloque de abajo una vez confirmado el diagnóstico)
                // if (modoVista === 'futuras' && estado === 'finalizada') return;

                const estilos = getStatusStyling(estado);
                const opacidadBaja = estado === 'finalizada' ? 'opacity: 0.75;' : '';
                const datePrefix = modoVista === 'futuras' ? rsrvDate.toLocaleDateString('es-ES', {month:'short', day:'numeric'}).toUpperCase() + ' - ' : '';

                html += `
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="card h-100 position-relative" 
                             onclick="abrirDetalles(${r.id})"
                             style="cursor: pointer; background: ${estilos.bg}; border: 1px solid ${estilos.border}; border-radius: 14px; box-shadow: ${estilos.shadow}; transition: transform 0.2s ease, box-shadow 0.2s ease; ${opacidadBaja}">
                            
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold fs-4" style="color: ${estilos.text}; letter-spacing: -1px; font-family: 'Inter', sans-serif;">
                                            ${r.hora_inicio.substring(0,5)}
                                        </span>
                                        <span class="badge mt-1" style="background: ${estilos.badgeBg}; color: ${estilos.badgeText}; font-size: 0.7rem; align-self: flex-start; padding: 4px 8px; border-radius: 6px;">
                                            ${datePrefix}${estilos.label}
                                        </span>
                                    </div>
                                    <div class="text-end">
                                        <div style="background: rgba(255,255,255,0.8); border: 1px solid rgba(0,0,0,0.05); padding: 5px 12px; border-radius: 20px; color: ${estilos.text}; font-weight: bold; font-size: 0.9rem;">
                                            <i class="bi bi-people-fill me-1"></i> ${r.numero_personas}
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h5 class="fw-bold mb-1 text-truncate" style="color: ${estilos.text}; font-size: 1.1rem;" title="${r.nombre_cliente}">
                                        ${r.nombre_cliente}
                                    </h5>
                                    <p class="m-0 text-truncate" style="color: ${estilos.text}; opacity: 0.75; font-size: 0.85rem;">
                                        <i class="bi bi-hash me-1"></i> ${r.folio || 'N/A'} 
                                        ${r.zona && r.zona.nombre_zona ? ' | <i class="bi bi-geo-alt-fill mx-1"></i> ' + r.zona.nombre_zona : ''}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                `;
            });

            grid.innerHTML = html;
        }

        async function fetchReservaciones(isoDateString, modo = 'dia') {
            const grid = document.getElementById('reservaciones-grid');
            grid.innerHTML = '<div class="col-12 text-center py-5"><div class="spinner-border text-muted"></div><p class="mt-2 text-muted fw-bold small">SINCRONIZANDO AGENDA...</p></div>';
            
            // Limpiar Headers visualmente
            document.getElementById('statTotalPersonas').textContent = '...';
            document.getElementById('statProxima').textContent = '...';
            document.getElementById('statEnCurso').textContent = '...';

            try {
                let url = `/api/gerente/reservaciones?t=${new Date().getTime()}`;
                if(modo === 'futuras') {
                    url += '&modo=futuras';
                } else {
                    url += `&fecha=${isoDateString}`;
                }

                const token = localStorage.getItem('token');
                const res = await fetch(url, { // cache-busting
                    headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                });
                
                if(!res.ok) {
                    if(res.status === 401 || res.status === 403) {
                        window.location.href = '/login';
                        return;
                    }
                    throw new Error('Error de red');
                }

                const json = await res.json();
                let reservaciones = json.data || [];

                // Envolver en try-catch para evitar que un dato mal formado rompa todo el grid
                try {
                    // Si estamos en modo futuras, ordenar secuencialmente (fecha + hora_inicio) de menor a mayor
                    if (modoVista === 'futuras') {
                        reservaciones.sort((a, b) => {
                            // Obtenemos un pseudo timestamp uniendo fecha y hora: "2026-03-16T14:30:00"
                            const tA = new Date(`${a.fecha}T${a.hora_inicio}`).getTime();
                            const tB = new Date(`${b.fecha}T${b.hora_inicio}`).getTime();
                            return tA - tB;
                        });
                    }
                } catch (e) {
                    console.warn("Fallo al ordenar las reservaciones futuras:", e);
                }
                
                // Calcular Estadisticas
                const isToday = (isoDateString === new Date().toISOString().split('T')[0]);
                const totalPersonas = reservaciones.reduce((sum, r) => sum + r.numero_personas, 0);
                document.getElementById('statTotalPersonas').textContent = totalPersonas;

                // Calcular En Curso
                const now = new Date();
                const enCursoCount = reservaciones.filter(r => calcularEstadoReserva(r.hora_inicio, r.hora_fin, new Date(r.fecha + 'T00:00:00')) === 'curso').length;
                document.getElementById('statEnCurso').textContent = enCursoCount;

                if(reservaciones.length === 0) {
                    document.getElementById('statProxima').textContent = '--';
                } else {
                    if(isToday) {
                        // Buscar la mas cercana futura
                        const futuras = reservaciones.filter(r => {
                            const t = parseTimeStringToDate(r.hora_inicio, now);
                            return t > now; // o iguales
                        });
                        
                        if(futuras.length > 0) {
                            const nombre = futuras[0].nombre_cliente.split(' ')[0]; // Primer nombre
                            document.getElementById('statProxima').textContent = `Siguiente: ${nombre} a las ${futuras[0].hora_inicio.substring(0,5)}`;
                        } else {
                            document.getElementById('statProxima').textContent = 'Cierre de día';
                        }
                    } else {
                        const nombre = reservaciones[0].nombre_cliente.split(' ')[0];
                        document.getElementById('statProxima').textContent = `Siguiente: ${nombre} a las ${reservaciones[0].hora_inicio.substring(0,5)}`;
                    }
                }

                renderizarTarjetas(reservaciones);

            } catch(e) {
                console.error(e);
                grid.innerHTML = '<div class="col-12 text-center py-5 text-danger"><i class="bi bi-shield-exclamation fs-1"></i><p class="fw-bold mt-2">Error de conexión al obtener la agenda.</p></div>';
            }
        }

        function updateDateUI() {
            document.getElementById('dateDisplay').textContent = formatDisplayDate(currentDate);
            // Format YYYY-MM-DD local
            const offset = currentDate.getTimezoneOffset()
            let isoDateObj = new Date(currentDate.getTime() - (offset*60*1000))
            let isoString = isoDateObj.toISOString().split('T')[0];
            document.getElementById('inputDate').value = isoString;
            
            // Lanzar Fetch
            fetchReservaciones(isoString);
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateDateUI();

            document.querySelectorAll('.btn-day-nav').forEach(btn => {
                btn.addEventListener('click', () => {
                    const offset = parseInt(btn.getAttribute('data-offset'));
                    currentDate.setDate(currentDate.getDate() + offset);
                    updateDateUI();
                });
            });

            document.getElementById('inputDate').addEventListener('change', (e) => {
                if(e.target.value) {
                    currentDate = new Date(e.target.value + 'T00:00:00'); // Evita timezone bug
                    updateDateUI();
                }
            });

            // Refresco Automatico de los estados en vivo (Cada 30 seg)
            setInterval(() => {
                if(reservasGlobales.length > 0) {
                    renderizarTarjetas(reservasGlobales);
                }
            }, 30000);
        });
    </script>
@endsection