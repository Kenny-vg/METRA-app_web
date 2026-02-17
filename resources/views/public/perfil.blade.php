@extends('public.layout_cliente') @section('title', 'Mi Perfil')

@section('content')
    <div class="container">
    <div class="row g-4">
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100">
                <div class="mb-3">
                    <img src="https://ui-avatars.com/api/?name=Martia&background=FFAB40&color=4E342E" class="rounded-circle shadow-sm" width="80">
                </div>
                <h4 class="fw-bold mb-1">Maria Juanita</h4>
                <p class="text-muted small mb-3">lllllllk@gmail.com</p>
                
                <div class="d-grid gap-2 mt-2">
                    <a href="/reservar" class="btn btn-primary rounded-pill fw-bold py-2">
                        <i class="bi bi-calendar-plus me-2"></i>Nueva Reservación
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4"><i class="bi bi-clock-history me-2 text-warning"></i>Mis Reservaciones</h5>
                
                <div class="p-3 border rounded-4 mb-3 bg-light d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-success-subtle text-success rounded-pill mb-2">Confirmada</span>
                        <h6 class="fw-bold m-0">Café Central</h6>
                        <small class="text-muted">Domingo, 15 de Febrero - 08:30 PM</small>
                    </div>
                    <div class="text-end">
                        <div class="small fw-bold text-dark">Folio: #MET-2026</div>
                        <button class="btn btn-sm btn-outline-danger border-0 mt-2">Cancelar</button>
                    </div>
                </div>

                </div>
        </div>
    </div>
</div>
@endsection