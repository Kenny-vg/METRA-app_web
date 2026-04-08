@extends('layouts.mobile')

@section('title', 'Registro Walk-in')

@section('content')
<div class="staff-header mb-4 text-center">
    <h2 class="staff-title mb-1 text-uppercase">Registro</h2>
    <p class="text-muted small">Clientes sin reservación</p>
</div>

<div class="registration-container p-0">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid var(--app-border) !important;">
        <div class="card-body p-4">
            <form id="form-walkin">
                <!-- Nombre -->
                <div class="mb-3">
                    <input type="text" id="w-nombre" class="form-control rounded-3 py-3 border" placeholder="Nombre del cliente" required>
                </div>

                <!-- Personas -->
                <div class="mb-3">
                    <select id="w-personas" class="form-select rounded-3 py-3 border" required>
                        <option value="" selected disabled>Número de personas</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $i }} personas</option>
                        @endfor
                        <option value="15">15+ personas</option>
                    </select>
                </div>

                <!-- Zona -->
                <div class="mb-3">
                    <select id="w-zona" class="form-select rounded-3 py-3 border" required>
                        <option value="" selected disabled>Zona</option>
                        <!-- Zonas will be loaded here -->
                    </select>
                </div>

                <!-- Mesas Selection -->
                <div class="mb-4">
                    <label class="small fw-bold mb-2 text-gold d-block">Asignar Mesa(s)</label>
                    <div id="mesas-checkboxes" class="d-flex flex-wrap gap-2">
                        <p class="text-muted small w-100 italic">Selecciona primero una zona...</p>
                    </div>
                    <div id="capacity-warning" class="mt-2 d-none">
                        <span class="badge bg-success small w-100 py-2">Capacidad Cubierta <i class="bi bi-check-circle-fill"></i></span>
                    </div>
                </div>

                <!-- Comentarios -->
                <div class="mb-4">
                    <textarea id="w-comentarios" class="form-control rounded-3 py-3 border" placeholder="Comentarios (Opcional)" rows="3"></textarea>
                </div>

                <div class="d-grid">
                    <button type="submit" id="btn-registrar" class="btn btn-dark rounded-pill py-3 fw-bold" style="background: var(--app-coffee);">
                        CONFIRMAR REGISTRO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .mesa-checkbox-item {
        flex: 1 0 45%;
        border: 1px solid var(--app-border);
        border-radius: 10px;
        padding: 10px;
        position: relative;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }
    .mesa-checkbox-item input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    .mesa-checkbox-item label {
        display: block;
        margin: 0;
        cursor: pointer;
        font-weight: 700;
        font-size: 0.85rem;
    }
    .mesa-checkbox-item .cap {
        display: block;
        font-size: 0.65rem;
        color: var(--app-text-muted);
    }
    .mesa-checkbox-item.selected {
        background: var(--app-coffee);
        color: white;
        border-color: var(--app-coffee);
    }
    .mesa-checkbox-item.selected .cap {
        color: rgba(255,255,255,0.7);
    }
    .mesa-checkbox-item.disabled {
        opacity: 0.5;
        pointer-events: none;
        background: #f5f5f5;
    }
</style>
@endsection

@push('scripts')
<script>
    let allMesas = [];
    let selectedMesas = [];

    async function fetchFormConfig() {
        try {
            // Cargar Zonas
            const resZ = await MetraAPI.get('/staff/zonas');
            if (resZ.success) {
                const select = document.getElementById('w-zona');
                resZ.data.forEach(zona => {
                    const opt = document.createElement('option');
                    opt.value = zona.nombre_zona;
                    opt.textContent = zona.nombre_zona;
                    select.appendChild(opt);
                });
            }

            // Cargar Mesas
            const resM = await MetraAPI.get('/staff/mesas-estado');
            if (resM.success) {
                allMesas = resM.data.filter(m => m.estado === 'disponible');
            }
        } catch (e) {
            console.error(e);
        }
    }

    function updateMesasUI() {
        const zona = document.getElementById('w-zona').value;
        const container = document.getElementById('mesas-checkboxes');
        
        if (!zona) return;

        const filtered = allMesas.filter(m => m.zona_nombre === zona);
        
        if (filtered.length === 0) {
            container.innerHTML = '<p class="text-danger small italic py-2">No hay mesas disponibles en esta zona.</p>';
            return;
        }

        container.innerHTML = filtered.map(m => `
            <div class="mesa-checkbox-item ${selectedMesas.includes(m.id) ? 'selected' : ''}" data-id="${m.id}" data-cap="${m.capacidad}">
                <label>${m.nombre}</label>
                <span class="cap">Cap. ${m.capacidad}</span>
            </div>
        `).join('');

        // Re-attach listeners
        document.querySelectorAll('.mesa-checkbox-item').forEach(item => {
            item.addEventListener('click', function() {
                const id = parseInt(this.dataset.id);
                if (selectedMesas.includes(id)) {
                    selectedMesas = selectedMesas.filter(x => x !== id);
                } else {
                    selectedMesas.push(id);
                }
                updateSelectionState();
            });
        });
        
        updateSelectionState();
    }

    function updateSelectionState() {
        const numPersonas = parseInt(document.getElementById('w-personas').value) || 0;
        let totalCap = 0;
        
        document.querySelectorAll('.mesa-checkbox-item').forEach(item => {
            const id = parseInt(item.dataset.id);
            if (selectedMesas.includes(id)) {
                item.classList.add('selected');
                totalCap += parseInt(item.dataset.cap);
            } else {
                item.classList.remove('selected');
            }
        });

        const warningBox = document.getElementById('capacity-warning');
        if (selectedMesas.length > 0) {
            warningBox.classList.remove('d-none');
            if (totalCap >= numPersonas) {
                warningBox.innerHTML = `<span class="badge bg-success small w-100 py-2">CAPACIDAD CUBIERTA (${numPersonas}/${totalCap}) <i class="bi bi-check-circle-fill"></i></span>`;
            } else {
                warningBox.innerHTML = `<span class="badge bg-warning text-dark small w-100 py-2">CAPACIDAD INSUFICIENTE (${numPersonas}/${totalCap}) <i class="bi bi-exclamation-triangle-fill"></i></span>`;
            }
        } else {
            warningBox.classList.add('d-none');
        }
    }

    document.getElementById('w-zona').addEventListener('change', () => {
        selectedMesas = [];
        updateMesasUI();
    });
    
    document.getElementById('w-personas').addEventListener('change', updateSelectionState);

    document.getElementById('form-walkin').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const numPersonas = parseInt(document.getElementById('w-personas').value);

        if (selectedMesas.length === 0) {
            Swal.fire('Atención', 'Debes seleccionar al menos una mesa.', 'warning');
            return;
        }

        const firstMesaId = selectedMesas[0];
        const selectedMesaObj = allMesas.find(m => m.id === firstMesaId);

        const data = {
            nombre_cliente: document.getElementById('w-nombre').value,
            numero_personas: numPersonas,
            zona_id: selectedMesaObj ? selectedMesaObj.zona_id : null,
            mesa_ids: selectedMesas,
            comentarios: document.getElementById('w-comentarios').value
        };

        try {
            const btn = document.getElementById('btn-registrar');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Registrando...';

            await MetraAPI.post('/staff/ocupaciones', data);
            
            await Swal.fire({
                icon: 'success',
                title: '¡Registro Exitoso!',
                text: 'La mesa ha sido asignada correctamente.',
                confirmButtonColor: '#2D1F1A'
            });
            window.location.href = '/staff/inicio';
        } catch (e) {
            Swal.fire('Error', e.message || 'No se pudo completar el registro.', 'error');
        } finally {
            const btn = document.getElementById('btn-registrar');
            btn.disabled = false;
            btn.innerHTML = 'CONFIRMAR REGISTRO';
        }
    });

    document.addEventListener('DOMContentLoaded', fetchFormConfig);
</script>
@endpush
