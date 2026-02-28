@extends('admin.menu')
@section('title', 'Gestión de Reservaciones')

@section('content')
    <header class="mb-5 border-bottom pb-4" style="border-color: var(--border-light) !important;">
        <h2 class="fw-bold" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Gestión de Reservaciones</h2>
        <p class="m-0" style="color: var(--text-muted); font-size: 0.95rem;">Monitor de ocupación en tiempo real para la sala principal y terraza.</p>
    </header>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <div class="btn-group bg-white p-1 rounded-pill" style="border: 1px solid var(--border-light); box-shadow: 0 2px 5px rgba(0,0,0,0.02);" role="group">
            <input type="radio" class="btn-check" name="vistas" id="vistaDia" checked>
            <label class="btn btn-admin-secondary border-0 rounded-pill px-4 btn-sm shadow-none m-0" for="vistaDia">Día</label>

            <input type="radio" class="btn-check" name="vistas" id="vistaSemana">
            <label class="btn btn-admin-secondary border-0 rounded-pill px-4 btn-sm shadow-none m-0" for="vistaSemana">Semana</label>
        </div>

        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: var(--white-pure); border: 1px solid var(--border-light);"><i class="bi bi-chevron-left"></i></button>
            <div class="bg-white px-4 py-2 rounded-pill" style="border: 1px solid var(--border-light); box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                <span class="fw-bold small" style="color: var(--black-primary);"><i class="bi bi-calendar-event me-2 text-muted"></i>Hoy, 22 de Febrero</span>
            </div>
            <button class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: var(--white-pure); border: 1px solid var(--border-light);"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>

    <!-- Panel de Monitor Principal -->
    <div class="card border-0 p-4 p-md-5 mb-5 premium-card">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2 border-bottom pb-4" style="border-color: var(--border-light) !important;">
            <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;"><i class="bi bi-grid-3x3-gap me-2 pb-1" style="color: var(--accent-gold);"></i>Monitor Táctico</h5>
            <div class="d-flex gap-3 mt-2 mt-md-0 pt-1" style="font-size: 0.8rem; font-weight: 500;">
                <span style="color: var(--text-muted);"><i class="bi bi-circle-fill me-1" style="color: #F8F9FA; border: 1px solid var(--border-light); border-radius: 50%;"></i> No presentados</span>
                <span style="color: var(--text-main);"><i class="bi bi-circle-fill me-1" style="color: var(--off-white); border: 1px solid var(--black-primary); border-radius: 50%;"></i> Confirmadas</span>
                <span style="color: var(--white-pure); padding: 2px 8px; background: var(--black-primary); border-radius: 4px;"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> En curso</span>
            </div>
        </div>

        <div class="row g-3">
            @php 
                $horarios_maestro = ['08:30', '09:00', '11:30', '13:00', '16:30'];
                /* Datos ficticios adaptados al nuevo diseño */
                $reservas_activas = [
                    ['hora' => '08:30', 'cliente' => 'Fam. Martínez', 'pax' => 4, 'status' => 'curso', 'mesa' => 'Balcón'],
                    ['hora' => '08:30', 'cliente' => 'Ana López', 'pax' => 2, 'status' => 'confirmada', 'mesa' => 'Mesa 3'],
                    ['hora' => '11:30', 'cliente' => 'J. Montes', 'pax' => 2, 'status' => 'confirmada', 'mesa' => 'Terraza'],
                ];
            @endphp

            @foreach($horarios_maestro as $h)
                <div class="col-12 col-sm-6 col-md-4 col-lg-2"> 
                    <div class="card h-100" style="background: var(--off-white); border: 1px dashed var(--border-light); border-radius: 12px;">
                        <div class="card-header bg-transparent border-0 pt-3 pb-2 text-center">
                            <span class="badge" style="background: var(--white-pure); color: var(--black-primary); border: 1px solid var(--border-light); font-size: 0.85rem; padding: 6px 12px; font-weight: 600;">{{ $h }}</span>
                        </div>
                        <div class="card-body p-2 d-flex flex-column gap-2">
                            @php $hay_reserva = false; @endphp
                            @foreach($reservas_activas as $res)
                                @if($res['hora'] == $h)
                                    @php $hay_reserva = true; @endphp
                                    
                                    <div class="p-2 rounded-3 shadow-sm position-relative" 
                                         style="background-color: {{ $res['status'] == 'curso' ? 'var(--black-primary)' : 'var(--white-pure)' }}; 
                                                color: {{ $res['status'] == 'curso' ? 'var(--white-pure)' : 'var(--black-primary)' }};
                                                border: 1px solid {{ $res['status'] == 'curso' ? 'transparent' : 'var(--border-light)' }};
                                                transition: all 0.2s ease; cursor: pointer;">
                                        
                                        <!-- Decorative dot for status -->
                                        @if($res['status'] == 'curso')
                                            <div style="position: absolute; top: 8px; right: 8px; width: 6px; height: 6px; background-color: var(--accent-gold); border-radius: 50%;"></div>
                                        @endif
                                        
                                        <div class="d-flex justify-content-between align-items-start mt-1">
                                            <strong class="d-block text-truncate" style="font-size: 0.8rem; max-width: 80px;">{{ $res['cliente'] }}</strong>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span style="font-size: 0.7rem; opacity: 0.8;"><i class="bi bi-people-fill me-1"></i>{{ $res['pax'] }}</span>
                                            <span class="badge badge-status badge-status-{{ $res['status'] == 'curso' ? 'active' : 'pending' }}" 
                                                  style="font-size: 0.6rem;">
                                                {{ $res['mesa'] }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            @if(!$hay_reserva)
                                <div class="text-center py-4 my-2" style="background: transparent; border: 1px dashed rgba(0,0,0,0.05); border-radius: 8px;">
                                    <small style="color: var(--text-muted) !important; font-size: 0.75rem; font-weight: 500;">Disponible</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Área reservada para la lista detallada -->
    <div class="reserva-list">
        <!-- Content will be populated here -->
    </div>

    @include('partials.footer_admin')
    
    <!-- Script adicional para efectos de los tabs -->
    <script>
        document.querySelectorAll('input[name="vistas"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('label[for^="vista"]').forEach(label => {
                    label.classList.remove('bg-dark', 'text-white');
                    label.style.color = "var(--text-muted)";
                });
                
                if (this.checked) {
                    const activeLabel = document.querySelector('label[for="' + this.id + '"]');
                    activeLabel.classList.add('bg-dark', 'text-white');
                    activeLabel.style.color = "white";
                }
            });
        });
        
        // Trigger inicial
        const initialSelectedId = document.querySelector('input[name="vistas"]:checked').id;
        const initialActiveLabel = document.querySelector('label[for="' + initialSelectedId + '"]');
        if (initialActiveLabel) {
            initialActiveLabel.classList.add('bg-dark', 'text-white');
            initialActiveLabel.style.color = "white";
        }
    </script>
@endsection