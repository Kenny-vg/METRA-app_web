@extends('superadmin.menu')

@section('title', 'Planes')

@section('content')
    <div class="row g-4 mb-5">
        <div class="col-12">
            <div class="d-flex align-items-center mb-4 mt-2">
                <h4 class="fw-bold text-dark m-0"><i class="bi bi-stack me-2 text-primary"></i>Gestión de Planes</h4>
            </div>
            
            <div class="row g-4" id="planes-container">
                <div class="col-12 text-center text-muted py-5">
                    <div class="spinner-border text-primary mb-2"></div>
                    <p>Cargando planes del sistema...</p>
                </div>
            </div>
        </div>
    </div>

<div id="overlay-loading" class="d-flex" style="display:none !important; position:fixed; top:0;left:0;width:100%;height:100%; z-index:9999; align-items:center; justify-content:center;">
    <div class="text-center">
        <div class="spinner-border text-primary mb-3" style="width:3rem;height:3rem;"></div>
        <p class="fw-bold text-dark bg-white py-1 px-3 rounded-pill shadow-sm">Procesando...</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const API = '/api';
let authToken = localStorage.getItem('token') || '';

if (!authToken) {
    window.location.href = '/login';
}

function authHeaders() {
    return {
        'Authorization': `Bearer ${authToken}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    };
}

let planesData = [];

async function cargarPlanes() {
    const overlay = document.getElementById('overlay-loading');
    overlay.style.setProperty('display', 'flex', 'important');
    try {
        const res = await fetch(`${API}/superadmin/planes`, { headers: authHeaders() });
        const json = await res.json();
        if (res.ok) {
            planesData = json.data || [];
            renderPlanes();
        } else {
            console.error('Error al cargar planes:', json.message);
        }
    } catch (e) {
        console.error('Error loading planes:', e);
    } finally {
        document.getElementById('overlay-loading').style.display = 'none';
        document.getElementById('overlay-loading').style.setProperty('display', 'none', 'important');
    }
}

function renderPlanes() {
    const container = document.getElementById('planes-container');
    container.innerHTML = '';

    planesData.forEach(plan => {
        container.innerHTML += `
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card bg-white border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4">
                    <h5 class="fw-bold text-primary mb-0 d-flex justify-content-between align-items-center">
                        Plan ${plan.nombre_plan}
                        <i class="bi bi-card-checklist text-muted" style="font-size: 1.2rem; opacity: 0.5;"></i>
                    </h5>
                </div>
                <div class="card-body p-4 pt-2">
                    <form id="form-plan-${plan.id}" onsubmit="event.preventDefault(); guardarPlan(${plan.id});">
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Nombre del Plan</label>
                            <input type="text" class="form-control bg-light border-0" id="nombre-${plan.id}" value="${plan.nombre_plan}" maxlength="100" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Precio (MXN)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted">$</span>
                                <input type="number" step="0.01" min="0" class="form-control bg-light border-0 fw-bold" id="precio-${plan.id}" value="${plan.precio}" required>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Máx. Reservas</label>
                                <input type="number" min="0" class="form-control bg-light border-0 text-center" id="reservas-${plan.id}" value="${plan.max_reservas_mes}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Máx. Admins</label>
                                <input type="number" min="1" class="form-control bg-light border-0 text-center" id="usuarios-${plan.id}" value="${plan.max_usuarios_admin}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Duración (Días)</label>
                            <input type="number" min="1" class="form-control bg-light border-0" id="duracion-${plan.id}" value="${plan.duracion_dias}" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Descripción</label>
                            <textarea class="form-control bg-light border-0" id="desc-${plan.id}" rows="2" maxlength="255">${plan.descripcion || ''}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm d-flex align-items-center justify-content-center">
                            <i class="bi bi-save2-fill me-2"></i>Guardar Cambios
                        </button>
                    </form>
                </div>
            </div>
        </div>
        `;
    });

    // Añadir Card de Creación (Nuevo Plan)
    container.innerHTML += `
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card bg-light border border-dashed shadow-sm rounded-4 h-100" style="border-style: dashed; border-color: #adb5bd;">
                <div class="card-header bg-transparent border-bottom-0 pt-4 pb-2 px-4">
                    <h5 class="fw-bold text-secondary mb-0 d-flex justify-content-between align-items-center">
                        Crear Nuevo Plan
                        <i class="bi bi-plus-circle-dotted text-muted" style="font-size: 1.2rem;"></i>
                    </h5>
                </div>
                <div class="card-body p-4 pt-2">
                    <form id="form-plan-nuevo" onsubmit="event.preventDefault(); crearPlan();">
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Nombre del Plan</label>
                            <input type="text" class="form-control" id="nombre-nuevo" placeholder="Ej. Premium" maxlength="100" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Precio (MXN)</label>
                            <div class="input-group">
                                <span class="input-group-text text-muted">$</span>
                                <input type="number" step="0.01" min="0" class="form-control fw-bold" id="precio-nuevo" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Máx. Reservas</label>
                                <input type="number" min="0" class="form-control text-center" id="reservas-nuevo" value="0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Máx. Admins</label>
                                <input type="number" min="1" class="form-control text-center" id="usuarios-nuevo" value="1" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Duración (Días)</label>
                            <input type="number" min="1" class="form-control" id="duracion-nuevo" value="30" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small text-muted fw-bold text-uppercase" style="letter-spacing: 0.5px;">Descripción</label>
                            <textarea class="form-control" id="desc-nuevo" rows="2" maxlength="255" placeholder="Detalles del plan..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-outline-secondary w-100 rounded-pill py-2 fw-bold d-flex align-items-center justify-content-center">
                            <i class="bi bi-plus-lg me-2"></i>Agregar Plan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    `;
}

async function guardarPlan(id) {
    const overlay = document.getElementById('overlay-loading');
    overlay.style.setProperty('display', 'flex', 'important');
    
    const nombre_plan = document.getElementById(`nombre-${id}`).value;
    const precio = document.getElementById(`precio-${id}`).value;
    const max_reservas_mes = document.getElementById(`reservas-${id}`).value;
    const max_usuarios_admin = document.getElementById(`usuarios-${id}`).value;
    const duracion_dias = document.getElementById(`duracion-${id}`).value;
    const descripcion = document.getElementById(`desc-${id}`).value;

    const data = {
        nombre_plan,
        precio: parseFloat(precio),
        max_reservas_mes: parseInt(max_reservas_mes),
        max_usuarios_admin: parseInt(max_usuarios_admin),
        duracion_dias: parseInt(duracion_dias),
        descripcion
    };

    try {
        const res = await fetch(`${API}/superadmin/planes/${id}`, {
            method: 'PUT',
            headers: authHeaders(),
            body: JSON.stringify(data)
        });
        const json = await res.json();
        overlay.style.setProperty('display', 'none', 'important');

        if (!res.ok) {
            const fallbackMsg = json.message || Object.values(json.errors || {}).join(' | ');
            Swal.fire({ icon: 'error', title: 'Error al Guardar', text: fallbackMsg, confirmButtonColor: '#0d6efd' });
        } else {
            Swal.fire({ icon: 'success', title: 'Plan Actualizado', text: `El plan "${nombre_plan}" se actualizó exitosamente.`, confirmButtonColor: '#28a745', timer: 2000, showConfirmButton: false });
            cargarPlanes(); // Refresh
        }
    } catch (e) {
        overlay.style.setProperty('display', 'none', 'important');
        Swal.fire({ icon: 'error', title: 'Error de Red', text: 'Ocurrió un problema de conexión.', confirmButtonColor: '#0d6efd' });
    }
}

async function crearPlan() {
    const overlay = document.getElementById('overlay-loading');
    overlay.style.setProperty('display', 'flex', 'important');
    
    const nombre_plan = document.getElementById(`nombre-nuevo`).value;
    const precio = document.getElementById(`precio-nuevo`).value;
    const max_reservas_mes = document.getElementById(`reservas-nuevo`).value;
    const max_usuarios_admin = document.getElementById(`usuarios-nuevo`).value;
    const duracion_dias = document.getElementById(`duracion-nuevo`).value;
    const descripcion = document.getElementById(`desc-nuevo`).value;

    const data = {
        nombre_plan,
        precio: parseFloat(precio || 0),
        max_reservas_mes: parseInt(max_reservas_mes || 0),
        max_usuarios_admin: parseInt(max_usuarios_admin || 1),
        duracion_dias: parseInt(duracion_dias || 30),
        descripcion
    };

    try {
        const res = await fetch(`${API}/superadmin/planes`, {
            method: 'POST',
            headers: authHeaders(),
            body: JSON.stringify(data)
        });
        const json = await res.json();
        overlay.style.setProperty('display', 'none', 'important');

        if (!res.ok) {
            const fallbackMsg = json.message || Object.values(json.errors || {}).join(' | ');
            Swal.fire({ icon: 'error', title: 'Error al Crear', text: fallbackMsg, confirmButtonColor: '#0d6efd' });
        } else {
            Swal.fire({ icon: 'success', title: 'Plan Creado', text: `El nuevo plan "${nombre_plan}" se creó correctamente.`, confirmButtonColor: '#28a745', timer: 2000, showConfirmButton: false });
            cargarPlanes();
        }
    } catch (e) {
        overlay.style.setProperty('display', 'none', 'important');
        Swal.fire({ icon: 'error', title: 'Error de Red', text: 'Ocurrió un problema de conexión.', confirmButtonColor: '#0d6efd' });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    cargarPlanes();
});
</script>
@endsection
