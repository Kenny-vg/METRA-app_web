@extends('admin.menu')
@section('title', 'Menú Digital')

@section('content')
    <header class="mb-5 border-bottom pb-4" style="border-color: var(--border-light) !important;">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h2 class="fw-bold m-0" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Menú Digital</h2>
                <p class="m-0 mt-2" style="color: var(--text-muted); font-size: 0.95rem;">Gestiona los productos que ofreces a tus clientes.</p>
            </div>
            <button class="btn-admin-primary px-4 py-2" onclick="openModalProducto()">
                <i class="bi bi-plus-lg me-2"></i>Añadir Producto
            </button>
        </div>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </header>

    <div class="row g-4" id="productos-container">
        <!-- Productos cargados por JS -->
    </div>

    <!-- Template HTML para Producto (previene XSS vía clonación en JS) -->
    <template id="producto-template">
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 js-card" style="background: var(--white-pure);">
                <div class="js-img" style="height: 180px; width: 100%; background-size: cover; background-position: center; border-bottom: 1px solid var(--border-light);"></div>
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold mb-0 text-truncate pe-2 js-nombre" style="color: var(--black-primary); font-size: 1.1rem;"></h5>
                        <span class="badge rounded-pill js-badge" style="font-size: 0.7rem;"></span>
                    </div>
                    <p class="small text-muted mb-4 flex-grow-1 js-desc" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"></p>
                    
                    <div class="d-flex justify-content-end mt-auto align-items-center border-top pt-3 js-actions" style="border-color: var(--border-light) !important;">
                        <!-- Botones insertados por JS -->
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Modal Producto -->
    <div class="modal fade" id="modalProducto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-2" style="box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold m-0" id="modalProductoTitle" style="color: var(--black-primary); letter-spacing: -0.5px;">Añadir Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-4">
                    <form id="formProducto" onsubmit="saveProducto(event)">
                        <input type="hidden" id="producto-id">
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">NOMBRE DEL PRODUCTO</label>
                            <input type="text" id="producto-nombre" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">DESCRIPCIÓN (Opcional)</label>
                            <textarea id="producto-descripcion" class="form-control border-0 shadow-sm rounded-3" rows="3" style="background: var(--off-white);"></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">IMAGEN (Opcional)</label>
                            <input type="file" id="producto-imagen" accept="image/png, image/jpeg, image/webp" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);">
                            <div class="form-text mt-2 small text-muted">Archivos permitidos: JPG, PNG, WEBP. Máx: 5MB.</div>
                        </div>

                        <button type="submit" id="btnSaveProducto" class="btn-admin-primary w-100 py-3 mt-2">
                            Guardar Producto
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let modalProductoInst;
        const API_URL = '/api/gerente';

        document.addEventListener('DOMContentLoaded', () => {
            modalProductoInst = new bootstrap.Modal(document.getElementById('modalProducto'));
            loadProductos();
        });

        const getToken = () => sessionStorage.getItem('token') || localStorage.getItem('token');

        const authHeaders = () => ({
            'Authorization': `Bearer ${getToken()}`,
            'Accept': 'application/json'
        });

        const showToast = (icon, title) => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 3000
            });
        };

        async function loadProductos() {
            try {
                const res = await fetch(`${API_URL}/menu`, { headers: authHeaders() });
                if (!res.ok) throw new Error('Error al cargar menú');
                
                const response = await res.json();
                const productos = Array.isArray(response) ? response : (response.data || []);
                
                const container = document.getElementById('productos-container');
                container.innerHTML = '';

                if (productos.length === 0) {
                    container.innerHTML = `
                        <div class="col-12 text-center text-muted py-5">
                            <i class="bi bi-basket text-muted mb-3 d-block" style="font-size: 3rem; opacity: 0.5;"></i>
                            <p>No tienes productos en tu menú todavía.</p>
                        </div>
                    `;
                    return;
                }

                const template = document.getElementById('producto-template');
                const fragment = document.createDocumentFragment();

                productos.forEach(p => {
                    const clone = template.content.cloneNode(true);
                    
                    const card = clone.querySelector('.js-card');
                    if (!p.activo) card.classList.add('opacity-50');

                    const img = clone.querySelector('.js-img');
                    const imgUrl = p.imagen_url ? (p.imagen_url.startsWith('http') ? p.imagen_url : `{{ url('storage') }}/${p.imagen_url}`) : 'https://placehold.co/400x300?text=Sin+Imagen';
                    img.style.backgroundImage = `url('${imgUrl}')`;

                    clone.querySelector('.js-nombre').textContent = p.nombre_producto;
                    
                    const badge = clone.querySelector('.js-badge');
                    badge.classList.add(p.activo ? 'bg-success' : 'bg-secondary');
                    badge.textContent = p.activo ? 'Activo' : 'Inactivo';

                    clone.querySelector('.js-desc').textContent = p.descripcion || 'Sin descripción';

                    const actionsDiv = clone.querySelector('.js-actions');
                    if (p.activo) {
                        const btnEdit = document.createElement('button');
                        btnEdit.className = 'btn btn-sm btn-outline-dark me-2';
                        btnEdit.title = 'Editar';
                        btnEdit.innerHTML = '<i class="bi bi-pencil"></i>';
                        btnEdit.addEventListener('click', () => editProducto(p));
                        
                        const btnDeactivate = document.createElement('button');
                        btnDeactivate.className = 'btn btn-sm btn-outline-primary';
                        btnDeactivate.title = 'Desactivar';
                        btnDeactivate.innerHTML = '<i class="bi bi-x-circle"></i>';
                        btnDeactivate.addEventListener('click', () => deleteProducto(p.id));

                        actionsDiv.appendChild(btnEdit);
                        actionsDiv.appendChild(btnDeactivate);
                    } else {
                        const btnReactivate = document.createElement('button');
                        btnReactivate.className = 'btn btn-sm btn-success w-100 mt-2';
                        btnReactivate.innerHTML = '<i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar';
                        btnReactivate.addEventListener('click', () => reactivateProducto(p.id));

                        actionsDiv.appendChild(btnReactivate);
                    }

                    fragment.appendChild(clone);
                });
                
                container.appendChild(fragment);
            } catch (error) {
                console.error(error);
                showToast('error', 'Error al cargar los productos');
                document.getElementById('productos-container').innerHTML = `
                    <div class="col-12 text-center text-danger py-5">
                        <i class="bi bi-exclamation-triangle-fill mb-3 d-block" style="font-size: 3rem; opacity: 0.5;"></i>
                        <p>No se pudieron cargar los productos debido a un problema de conexión.</p>
                    </div>
                `;
            }
        }

        function openModalProducto() {
            document.getElementById('formProducto').reset();
            document.getElementById('producto-id').value = '';
            document.getElementById('modalProductoTitle').innerText = 'Añadir Producto';
            modalProductoInst.show();
        }

        function editProducto(p) {
            document.getElementById('producto-id').value = p.id;
            document.getElementById('producto-nombre').value = p.nombre_producto;
            document.getElementById('producto-descripcion').value = p.descripcion || '';
            document.getElementById('producto-imagen').value = ''; // Limpiar el file input, solo se llena si quieren cambiarla
            document.getElementById('modalProductoTitle').innerText = 'Editar Producto';
            modalProductoInst.show();
        }

        async function saveProducto(e) {
            e.preventDefault();
            
            const btn = document.getElementById('btnSaveProducto');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Guardando...';

            const id = document.getElementById('producto-id').value;
            const url = id ? `${API_URL}/menu/${id}` : `${API_URL}/menu`;
            
            // Usamos FormData en lugar de JSON porque subiremos imágenes
            const formData = new FormData();
            formData.append('nombre_producto', document.getElementById('producto-nombre').value);
            formData.append('descripcion', document.getElementById('producto-descripcion').value);
            
            const fileInput = document.getElementById('producto-imagen');
            if (fileInput.files.length > 0) {
                formData.append('imagen_url', fileInput.files[0]);
            }

            // Spoofing the method if it's an update, so Laravel processes the multipart/form-data gracefully
            if (id) {
                formData.append('_method', 'PUT');
            }

            try {
                const res = await fetch(url, {
                    method: 'POST', // Siempre POST con FormData. Laravel intercepta '_method'.
                    headers: authHeaders(),
                    body: formData
                });

                if (res.ok) {
                    showToast('success', id ? 'Producto actualizado' : 'Producto añadido al menú');
                    modalProductoInst.hide();
                    loadProductos();
                } else {
                    const errorData = await res.json();
                    Swal.fire('Error', errorData.message || 'Error al guardar el producto', 'error');
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Error', 'Problema de conexión', 'error');
            } finally {
                btn.disabled = false;
                btn.innerText = 'Guardar Producto';
            }
        }

        async function deleteProducto(id) {
            Swal.fire({
                title: '¿Desactivar Producto?',
                text: 'El producto dejará de estar visible en el menú.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, desactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/menu/${id}`, { 
                            method: 'DELETE', 
                            headers: authHeaders() 
                        });
                        
                        if (res.ok) {
                            showToast('success', 'Producto desactivado');
                            loadProductos();
                        } else {
                            const err = await res.json();
                            Swal.fire('Error', err.message || 'Error al desactivar', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }

        async function reactivateProducto(id) {
            Swal.fire({
                title: '¿Reactivar Producto?',
                text: 'Volverá a aparecer en tu menú digital.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, reactivar',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const res = await fetch(`${API_URL}/menu/${id}/activar`, { 
                            method: 'PATCH', 
                            headers: authHeaders() 
                        });
                        
                        if (res.ok) {
                            showToast('success', 'Producto reactivado');
                            loadProductos();
                        } else {
                            const err = await res.json();
                            Swal.fire('Error', err.message || 'Error al reactivar', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Error de conexión', 'error');
                    }
                }
            });
        }
    </script>
@endsection
