@extends('admin.menu')
@section('title', 'Gestión de Reservaciones')

@section('content')
    <header class="mb-5">
        <h2 class="fw-bold">Gestión de Reservaciones</h2>
        <p class="text-muted">Revisa y administra las próximas visitas a Café Central</p>
    </header>

    <div class="bg-white p-4 rounded-4 shadow-sm border mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2">
            <h5 class="fw-bold m-0 text-dark"><i class="bi bi-grid-3x3-gap me-2"></i>Monitor de Ocupación</h5>
            <div class="d-flex gap-3">
                <small><i class="bi bi-circle-fill text-warning me-1"></i> Por Confirmar</small>
                <small><i class="bi bi-circle-fill me-1" style="color: #4E342E !important;"></i> Confirmadas</small>
            </div>
        </div>

        <div class="row g-3">
            @php 
                $horarios_maestro = ['08:30', '09:00', '11:30', '13:00', '16:30'];
                $reservas_activas = [
                    ['hora' => '08:30', 'cliente' => 'Fam. Martínez', 'pax' => 4, 'status' => 'confirmada', 'mesa' => 'Balcón'],
                    ['hora' => '08:30', 'cliente' => 'Ana López', 'pax' => 2, 'status' => 'confirmada', 'mesa' => 'Dentro'],
                    ['hora' => '11:30', 'cliente' => 'J. Montes', 'pax' => 2, 'status' => 'nueva', 'mesa' => 'Terraza'],
                ];
            @endphp

            @foreach($horarios_maestro as $h)
                <div class="col-6 col-md-4 col-lg-2"> <div class="card border-0 bg-light rounded-4 h-100 shadow-sm">
                        <div class="card-header bg-transparent border-0 pt-3 text-center">
                            <span class="badge bg-dark rounded-pill px-3">{{ $h }}</span>
                        </div>
                        <div class="card-body p-2">
                            @php $hay_reserva = false; @endphp
                            @foreach($reservas_activas as $res)
                                @if($res['hora'] == $h)
                                    @php $hay_reserva = true; @endphp
                                    <div class="reserva-mini-card {{ $res['status'] == 'nueva' ? 'nueva' : 'confirmada' }} mb-2 p-2 rounded-3 shadow-sm" 
                                         style="background-color: {{ $res['status'] == 'nueva' ? '#FFAB40' : '#4E342E' }}; 
                                                color: {{ $res['status'] == 'nueva' ? '#4E342E' : '#F5EFE6' }};">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <strong class="small d-block text-truncate" style="max-width: 70px;">{{ $res['cliente'] }}</strong>
                                            <span class="badge rounded-pill bg-white text-dark border" style="font-size: 0.5rem;">{{ $res['mesa'] }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1">
                                            <span style="font-size: 0.7rem;"><i class="bi bi-people"></i> {{ $res['pax'] }}</span>
                                            <i class="bi bi-pencil-square opacity-75" style="font-size: 0.8rem; cursor: pointer;"></i>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            @if(!$hay_reserva)
                                <div class="text-center py-3 opacity-25">
                                    <small class="text-muted">Libre</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="reserva-list">
        </div>

    @include('partials.footer_admin')
@endsection