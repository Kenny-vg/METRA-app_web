@extends('admin.menu')
@section('title', 'Menú Digital')

@section('content')
    <header class="mb-5 border-bottom pb-4" style="border-color: var(--border-light) !important;">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
            <div>
                <h2 class="fw-bold m-0" style="color: var(--black-primary); font-family: 'Inter', sans-serif; letter-spacing: -1px;">Menú Digital</h2>
                <p class="m-0 mt-2" style="color: var(--text-muted); font-size: 0.95rem;">Gestiona los productos que ofreces a tus clientes.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-dark px-4 py-2" onclick="openModalGestionCategorias()" style="border-radius: 8px;">
                    <i class="bi bi-tags me-2"></i>Categorías
                </button>
                <button class="btn-admin-primary px-4 py-2" onclick="openModalProducto()">
                    <i class="bi bi-plus-lg me-2"></i>Añadir Producto
                </button>
            </div>
        </div>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </header>

    <div id="carta-container">
        <!-- Contenedor general para categorías y productos -->
    </div>

    <!-- Template for Category Group -->
    <template id="categoria-group-template">
        <div class="mb-5 js-categoria-section">
            <div class="d-flex align-items-center gap-3 mb-4">
                <h4 class="fw-bold mb-0 js-categoria-nombre" style="color: var(--black-primary); font-family: 'Inter', sans-serif;"></h4>
                <hr class="flex-grow-1" style="opacity: 0.1;">
            </div>
            <div class="row g-4 js-productos-row">
                <!-- Productos de esta categoría -->
            </div>
        </div>
    </template>

    <!-- Template HTML para Producto -->
    <template id="producto-template">
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 js-card" style="background: var(--white-pure);">
                <div class="js-img" style="height: 180px; width: 100%; background-size: cover; background-position: center; border-bottom: 1px solid var(--border-light);"></div>
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold mb-0 text-truncate pe-2 js-nombre" style="color: var(--black-primary); font-size: 1.1rem;"></h5>
                        <div class="d-flex flex-column align-items-end">
                            <span class="badge rounded-pill mb-1 js-badge" style="font-size: 0.7rem;"></span>
                            <span class="fw-bold text-admin-primary js-precio" style="font-size: 0.9rem;"></span>
                        </div>
                    </div>
                    <p class="small text-muted mb-4 flex-grow-1 js-desc" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"></p>
                    
                    <div class="d-flex justify-content-end mt-auto align-items-center border-top pt-3 js-actions" style="border-color: var(--border-light) !important;">
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
                            <label class="form-label small fw-bold text-muted">CATEGORÍA</label>
                            <select id="producto-categoria" class="form-select border-0 shadow-sm rounded-3" style="background: var(--off-white);" required>
                                <option value="" disabled selected>Selecciona una categoría</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">NOMBRE DEL PRODUCTO</label>
                            <input type="text" id="producto-nombre" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">DESCRIPCIÓN (Opcional)</label>
                            <textarea id="producto-descripcion" class="form-control border-0 shadow-sm rounded-3" rows="2" style="background: var(--off-white);"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">PRECIO ($)</label>
                            <input type="number" id="producto-precio" step="0.01" min="0" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);" required placeholder="0.00">
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">IMAGEN (Opcional)</label>
                            <input type="file" id="producto-imagen" accept="image/png, image/jpeg, image/webp" class="form-control border-0 shadow-sm rounded-3" style="background: var(--off-white);">
                            <div class="form-text mt-2 small text-muted">JPG, PNG, WEBP. Máx: 5MB.</div>
                        </div>

                        <button type="submit" id="btnSaveProducto" class="btn-admin-primary w-100 py-3 mt-2">
                            Guardar Producto
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Gestión Categorías -->
    <div class="modal fade" id="modalGestionCategorias" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 p-2">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold m-0" style="color: var(--black-primary); letter-spacing: -0.5px;">Gestionar Categorías</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-4">
                    <!-- Formulario Nueva Categoría -->
                    <form id="formCategoria" onsubmit="saveCategoria(event)" class="mb-4 p-3 rounded-3" style="background: var(--off-white);">
                        <input type="hidden" id="categoria-id">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label small fw-bold text-muted">NOMBRE</label>
                                <input type="text" id="categoria-nombre" class="form-control border-0 shadow-sm rounded-3" required placeholder="Ej: Bebidas">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-bold text-muted">ORDEN</label>
                                <input type="number" id="categoria-orden" class="form-control border-0 shadow-sm rounded-3" placeholder="0">
                            </div>
                            <div class="col-md-5 d-flex gap-2">
                                <button type="submit" id="btnSaveCategoria" class="btn-admin-primary flex-grow-1">Guardar</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="resetFormCategoria()">Limpiar</button>
                            </div>
                        </div>
                    </form>

                    <!-- Lista de Categorías -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-top">
                            <thead>
                                <tr class="text-muted small">
                                    <th>NOMBRE</th>
                                    <th>ORDEN</th>
                                    <th>ESTADO</th>
                                    <th class="text-end">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="categorias-lista-body">
                                <!-- Cargado por JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let modalProductoInst, modalCategoriasInst;
        const API_URL = '/api/gerente';
        let categoriasLocales = [];

        document.addEventListener('DOMContentLoaded', () => {
            modalProductoInst = new bootstrap.Modal(document.getElementById('modalProducto'));
            modalCategoriasInst = new bootstrap.Modal(document.getElementById('modalGestionCategorias'));
            loadTodo();
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

        async function loadTodo() {
            await loadCategorias(); // Cargar categorías para selects y lista
            await loadProductos();   // Cargar menú agrupado
        }

        async function loadCategorias() {
            try {
                const res = await fetch(`${API_URL}/menu-categorias`, { headers: authHeaders() });
                if (!res.ok) throw new Error();
                const json = await res.json();
                categoriasLocales = json.data || [];
                
                // 1. Poblar select del producto
                const select = document.getElementById('producto-categoria');
                select.innerHTML = '<option value="" disabled selected>Selecciona una categoría</option>';
                categoriasLocales.forEach(c => {
                    select.innerHTML += `<option value="${c.id}">${escapeHTML(c.nombre)}</option>`;
                });

                // 2. Poblar lista en modal de gestión
                const lista = document.getElementById('categorias-lista-body');
                lista.innerHTML = '';
                categoriasLocales.forEach(c => {
                    lista.innerHTML += `
                        <tr>
                            <td class="fw-bold">${escapeHTML(c.nombre)}</td>
                            <td><span class="badge bg-light text-dark border">${c.orden}</span></td>
                            <td><span class="badge ${c.activo ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'} border">${c.activo ? 'Activa' : 'Inactiva'}</span></td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-dark me-1" onclick="editCategoria(${JSON.stringify(c).replace(/"/g, '&quot;')})"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm ${c.activo ? 'btn-outline-danger' : 'btn-outline-success'}" onclick="toggleEstadoCategoria(${c.id}, ${c.activo})">
                                    <i class="bi ${c.activo ? 'bi-eye-slash' : 'bi-eye'}"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            } catch (e) { console.error('Error loadCategorias', e); }
        }

        async function loadProductos() {
            try {
                const res = await fetch(`${API_URL}/menu`, { headers: authHeaders() });
                if (!res.ok) throw new Error('Error al cargar menú');
                
                const response = await res.json();
                const categoriasConProductos = response.data || [];
                
                const container = document.getElementById('carta-container');
                container.innerHTML = '';

                if (categoriasConProductos.length === 0) {
                    container.innerHTML = `
                        <div class="col-12 text-center text-muted py-5">
                            <i class="bi bi-basket text-muted mb-3 d-block" style="font-size: 3rem; opacity: 0.5;"></i>
                            <p>No tienes categorías ni productos en tu menú todavía.</p>
                        </div>
                    `;
                    return;
                }

                const catTemplate = document.getElementById('categoria-group-template');
                const prodTemplate = document.getElementById('producto-template');

                categoriasConProductos.forEach(cat => {
                    const catClone = catTemplate.content.cloneNode(true);
                    catClone.querySelector('.js-categoria-nombre').textContent = cat.nombre;
                    
                    const productsRow = catClone.querySelector('.js-productos-row');
                    
                    if (cat.menus && cat.menus.length > 0) {
                        cat.menus.forEach(p => {
                            const pClone = prodTemplate.content.cloneNode(true);
                            
                            const card = pClone.querySelector('.js-card');
                            if (!p.activo) card.classList.add('opacity-50');

                            const img = pClone.querySelector('.js-img');
                            const imgUrl = p.imagen_url ? (p.imagen_url.startsWith('http') ? p.imagen_url : `/storage/${p.imagen_url}`) : 'https://placehold.co/400x300?text=Sin+Imagen';
                            img.style.backgroundImage = `url('${imgUrl}')`;

                            pClone.querySelector('.js-nombre').textContent = p.nombre_producto;
                            pClone.querySelector('.js-precio').textContent = new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(p.precio || 0);
                            
                            const badge = pClone.querySelector('.js-badge');
                            badge.classList.add(p.activo ? 'bg-success' : 'bg-secondary');
                            badge.textContent = p.activo ? 'Activo' : 'Inactivo';

                            pClone.querySelector('.js-desc').textContent = p.descripcion || 'Sin descripción';

                            const actionsDiv = pClone.querySelector('.js-actions');
                            if (p.activo) {
                                actionsDiv.innerHTML = `
                                    <button class="btn btn-sm btn-outline-dark me-2" onclick='editProducto(${JSON.stringify(p).replace(/"/g, '&quot;')})'><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-outline-primary" onclick="deleteProducto(${p.id})"><i class="bi bi-x-circle"></i></button>
                                `;
                            } else {
                                actionsDiv.innerHTML = `<button class="btn btn-sm btn-success w-100 mt-2" onclick="reactivateProducto(${p.id})"><i class="bi bi-arrow-counterclockwise me-1"></i>Reactivar</button>`;
                            }

                            productsRow.appendChild(pClone);
                        });
                    } else {
                        productsRow.innerHTML = '<div class="col-12 text-muted small ps-3">Sin productos en esta categoría.</div>';
                    }

                    container.appendChild(catClone);
                });
            } catch (error) {
                console.error(error);
                showToast('error', 'Error al cargar los productos');
            }
        }

        // --- Gestión de Categorías ---
        function openModalGestionCategorias() {
            resetFormCategoria();
            modalCategoriasInst.show();
        }

        function resetFormCategoria() {
            document.getElementById('formCategoria').reset();
            document.getElementById('categoria-id').value = '';
            document.getElementById('btnSaveCategoria').innerText = 'Guardar';
        }

        function editCategoria(c) {
            document.getElementById('categoria-id').value = c.id;
            document.getElementById('categoria-nombre').value = c.nombre;
            document.getElementById('categoria-orden').value = c.orden;
            document.getElementById('btnSaveCategoria').innerText = 'Actualizar';
        }

        async function saveCategoria(e) {
            e.preventDefault();
            const id = document.getElementById('categoria-id').value;
            const url = id ? `${API_URL}/menu-categorias/${id}` : `${API_URL}/menu-categorias`;
            
            const payload = {
                nombre: document.getElementById('categoria-nombre').value,
                orden: document.getElementById('categoria-orden').value || 0
            };

            try {
                const res = await fetch(url, {
                    method: id ? 'PUT' : 'POST',
                    headers: { ...authHeaders(), 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                if (res.ok) {
                    showToast('success', 'Categoría guardada');
                    resetFormCategoria();
                    loadTodo();
                } else {
                    const err = await res.json();
                    Swal.fire('Error', err.message || 'Error al guardar', 'error');
                }
            } catch (e) {
                Swal.fire('Error', 'Problema de conexión', 'error');
            }
        }

        async function toggleEstadoCategoria(id, activoActual) {
            try {
                const res = await fetch(`${API_URL}/menu-categorias/${id}`, {
                    method: 'PUT',
                    headers: { ...authHeaders(), 'Content-Type': 'application/json' },
                    body: JSON.stringify({ activo: !activoActual })
                });
                if (res.ok) {
                    showToast('success', 'Estado de categoría actualizado');
                    loadTodo();
                } else {
                    const err = await res.json();
                    Swal.fire('Error', err.message || 'Error al actualizar categoría', 'error');
                }
            } catch (e) { console.error(e); }
        }

        // --- Gestión de Productos ---
        function openModalProducto() {
            if (categoriasLocales.length === 0) {
                Swal.fire({
                    title: '¡Espera!',
                    text: 'Primero debes crear al menos una categoría (ej: Bebidas, Comidas, etc.) para poder añadir productos.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Crear categoría ahora',
                    cancelButtonText: 'Entendido',
                    confirmButtonColor: 'var(--accent-gold)'
                }).then((result) => {
                    if (result.isConfirmed) {
                        openModalGestionCategorias();
                    }
                });
                return;
            }
            document.getElementById('formProducto').reset();
            document.getElementById('producto-id').value = '';
            document.getElementById('modalProductoTitle').innerText = 'Añadir Producto';
            modalProductoInst.show();
        }

        function editProducto(p) {
            document.getElementById('producto-id').value = p.id;
            document.getElementById('producto-nombre').value = p.nombre_producto;
            document.getElementById('producto-descripcion').value = p.descripcion || '';
            document.getElementById('producto-categoria').value = p.categoria_id;
            document.getElementById('producto-precio').value = p.precio || 0;
            document.getElementById('producto-imagen').value = '';
            document.getElementById('modalProductoTitle').innerText = 'Editar Producto';
            modalProductoInst.show();
        }

        async function saveProducto(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSaveProducto');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>';

            const id = document.getElementById('producto-id').value;
            const url = id ? `${API_URL}/menu/${id}` : `${API_URL}/menu`;
            const formData = new FormData();
            formData.append('nombre_producto', document.getElementById('producto-nombre').value);
            formData.append('descripcion', document.getElementById('producto-descripcion').value);
            formData.append('categoria_id', document.getElementById('producto-categoria').value);
            formData.append('precio', document.getElementById('producto-precio').value);
            
            if (id) formData.append('_method', 'PUT');

            const fileInput = document.getElementById('producto-imagen');
            if (fileInput.files.length > 0) formData.append('imagen_url', fileInput.files[0]);

            try {
                const res = await fetch(url, { method: 'POST', headers: authHeaders(), body: formData });
                if (res.ok) {
                    showToast('success', 'Producto guardado');
                    modalProductoInst.hide();
                    loadProductos();
                } else {
                    const err = await res.json();
                    Swal.fire('Error', err.message || 'Error', 'error');
                }
            } catch (error) { Swal.fire('Error', 'Error de conexión', 'error'); } 
            finally {
                btn.disabled = false;
                btn.innerText = 'Guardar Producto';
            }
        }

        async function deleteProducto(id) {
            if (await confirmAction('¿Desactivar producto?', 'warning')) {
                try {
                    const res = await fetch(`${API_URL}/menu/${id}`, { method: 'DELETE', headers: authHeaders() });
                    if (res.ok) { showToast('success', 'Desactivado'); loadProductos(); }
                } catch (e) { console.error(e); }
            }
        }

        async function reactivateProducto(id) {
            try {
                const res = await fetch(`${API_URL}/menu/${id}/activar`, { 
                    method: 'PATCH', 
                    headers: authHeaders()
                });
                if (res.ok) { showToast('success', 'Reactivado'); loadProductos(); }
                else {
                    const err = await res.json();
                    Swal.fire('Error', err.message || 'Error al reactivar', 'error');
                }
            } catch (e) { console.error(e); }
        }

        async function confirmAction(title, icon) {
            const res = await Swal.fire({
                title, icon, showCancelButton: true, confirmButtonText: 'Sí', cancelButtonText: 'No'
            });
            return res.isConfirmed;
        }
    </script>
@endsection
