<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA - Compartir Experiencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <script>
        window.API_URL = "{{ url('/api') }}";
        window.FILE_URL = "{{ url('/') }}";
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #fdfcfb 0%, #e2d1c3 100%);
            color: #111;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }
        
        .resena-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 3.5rem;
            box-shadow: 0 20px 50px rgba(0,0,0,0.08);
            border: 1px solid rgba(212,175,55,0.1);
            position: relative;
            overflow: hidden;
        }

        .resena-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #d4af37, #f3e5ab, #d4af37);
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            color: #111;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .cafe-name {
            color: #d4af37;
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
            display: inline-block;
            padding: 0.5rem 1.2rem;
            background: rgba(212,175,55,0.05);
            border-radius: 50px;
            border: 1px solid rgba(212,175,55,0.2);
        }

        /* Star Rating System */
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 0.5rem;
            margin: 2rem 0;
        }

        .rating input {
            display: none;
        }

        .rating label {
            cursor: pointer;
            width: 45px;
            height: 45px;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23e0ddd5'%3e%3cpath d='M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            transition: all 0.2s ease;
        }

        /* Hover and Checked States */
        .rating label:hover,
        .rating label:hover ~ label,
        .rating input:checked ~ label {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23d4af37'%3e%3cpath d='M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z'/%3e%3c/svg%3e");
            transform: scale(1.1);
        }

        .input-metra {
            border-radius: 12px;
            border: 1px solid #e0ddd5;
            padding: 1rem;
            color: #111;
            background-color: #faf9f7;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            resize: none;
        }

        .input-metra:focus {
            border-color: #d4af37;
            background-color: #fff;
            outline: 0;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
        }

        .btn-metra-main {
            background: linear-gradient(135deg, #2a2a2a 0%, #111 100%);
            color: #d4af37;
            border-radius: 12px;
            font-weight: 600;
            padding: 1rem;
            border: 1px solid #111;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.95rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            width: 100%;
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
            transform: none;
        }

        #loading-state, #error-state, #success-state {
            display: none;
        }

        .spinner-gold {
            color: #d4af37;
        }

        .visit-date {
            color: #7b7871;
            font-size: 0.9rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px dashed #e0ddd5;
        }

        @media (max-width: 768px) {
            .resena-card { padding: 2.5rem 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                
                <!-- Logo -->
                <div class="text-center mb-4">
                    <a href="/" class="text-decoration-none" style="color: #111;">
                        <span class="fs-4 fw-bold" style="letter-spacing: -0.5px;">
                            <i class="bi bi-hexagon-fill me-2" style="color: #d4af37;"></i>METRA
                        </span>
                    </a>
                </div>

                <div class="resena-card">
                    
                    <!-- Loading State -->
                    <div id="loading-state" class="text-center py-5">
                        <div class="spinner-border spinner-gold mb-4" style="width: 3rem; height: 3rem;" role="status"></div>
                        <h4 class="fw-bold">Cargando detalles...</h4>
                        <p class="text-muted">Preparando tu experiencia</p>
                    </div>

                    <!-- Error State -->
                    <div id="error-state" class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-exclamation-circle text-danger" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Enlace no válido</h4>
                        <p class="text-muted mb-4" id="error-message">Este enlace puede haber expirado o la reseña ya fue enviada.</p>
                        <a href="/" class="btn btn-outline-dark rounded-pill px-4">Ir a Inicio</a>
                    </div>

                    <!-- Success State -->
                    <div id="success-state" class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-3">¡Gracias por tu reseña!</h3>
                        <p class="text-muted mb-4">Valoramos mucho tu opinión. Esto ayuda a mantener el alto nivel de servicio en nuestra plataforma.</p>
                        <a href="/" class="btn btn-outline-dark rounded-pill px-4">Explorar más lugares</a>
                    </div>

                    <!-- Form State -->
                    <div id="form-state">
                        <div class="text-center">
                            <h1 class="page-title">Tu Experiencia</h1>
                            <div id="cafe-name" class="cafe-name">Cargando...</div>
                            <div class="visit-date">
                                <i class="bi bi-calendar-check me-2"></i>Visita del <strong id="visit-date">...</strong>
                            </div>
                        </div>

                        <form id="resenaForm">
                            <div class="text-center mb-2">
                                <label class="fw-bold text-dark fs-5">¿Cómo calificarías tu visita?</label>
                            </div>
                            
                            <div class="rating">
                                <input type="radio" id="star5" name="calificacion" value="5" />
                                <label for="star5" title="5 estrellas"></label>
                                <input type="radio" id="star4" name="calificacion" value="4" />
                                <label for="star4" title="4 estrellas"></label>
                                <input type="radio" id="star3" name="calificacion" value="3" />
                                <label for="star3" title="3 estrellas"></label>
                                <input type="radio" id="star2" name="calificacion" value="2" />
                                <label for="star2" title="2 estrellas"></label>
                                <input type="radio" id="star1" name="calificacion" value="1" />
                                <label for="star1" title="1 estrella"></label>
                            </div>

                            <div class="mb-4">
                                <label for="comentario" class="form-label fw-bold small text-muted">Cuéntanos más sobre tu experiencia (Opcional)</label>
                                <textarea class="form-control input-metra" id="comentario" rows="4" placeholder="¿Qué fue lo que más te gustó? ¿Algo que mejorar?"></textarea>
                            </div>

                            <button type="submit" id="submitBtn" class="btn-metra-main mt-2" disabled>
                                Enviar Reseña
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const token = "{{ $token }}";
            const loadingState = document.getElementById('loading-state');
            const errorState = document.getElementById('error-state');
            const successState = document.getElementById('success-state');
            const formState = document.getElementById('form-state');
            
            const submitBtn = document.getElementById('submitBtn');
            const form = document.getElementById('resenaForm');
            const radioButtons = document.querySelectorAll('input[name="calificacion"]');

            // Show initial loading
            loadingState.style.display = 'block';
            formState.style.display = 'none';

            // Fetch visit details
            try {
                const data = await MetraAPI.get(`/resena/${token}`);

                if (!data.success) {
                    throw new Error(data.message || 'Error al cargar los datos');
                }

                // Populate data
                document.getElementById('cafe-name').textContent = data.data.cafeteria;
                
                // Format date manually to avoid external libraries for simple formats
                const dateObj = new Date(data.data.fecha_visita);
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                let dateStr = dateObj.toLocaleDateString('es-ES', options);
                document.getElementById('visit-date').textContent = dateStr.charAt(0).toUpperCase() + dateStr.slice(1);

                // Show form
                loadingState.style.display = 'none';
                formState.style.display = 'block';

            } catch (error) {
                loadingState.style.display = 'none';
                errorState.style.display = 'block';
                const errData = error.data || {};
                document.getElementById('error-message').textContent = errData.message || error.message;
            }

            // Enable submit button only when a rating is selected
            radioButtons.forEach(radio => {
                radio.addEventListener('change', () => {
                    submitBtn.disabled = false;
                });
            });

            // Handle submission
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const calificacion = document.querySelector('input[name="calificacion"]:checked')?.value;
                const comentario = document.getElementById('comentario').value.trim();

                if (!calificacion) return;

                // UI Update
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enviando...';

                try {
                    const data = await MetraAPI.post(`/resena/${token}`, {
                        calificacion: parseInt(calificacion),
                        comentario: comentario
                    });

                    if (data.success) {
                        formState.style.display = 'none';
                        successState.style.display = 'block';
                    } else {
                        throw new Error(data.message || 'Error al enviar la reseña');
                    }
                } catch (error) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                    const errData = error.data || {};
                    alert(errData.message || error.message);
                }
            });
        });
    </script>
</body>
</html>
