<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>METRA SaaS - Acceso Maestro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #1a1c23;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .login-card-super {
            background-color: #2d3748;
            border: 1px solid #4a5568;
            padding: 40px;
            border-radius: 16px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            text-align: center;
        }
        .form-control-super {
            background-color: #1a1c23;
            border: 1px solid #4a5568;
            color: #ffffff;
            margin-bottom: 20px;
            padding: 14px;
            border-radius: 10px;
            font-size: 1rem;
        }
        .form-control-super::placeholder {
            color: #a0aec0;
        }
        .form-control-super:focus {
            background-color: #1a1c23;
            color: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
            outline: none;
        }
        .btn-super {
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: none;
            transition: 0.3s;
            font-size: 1.05rem;
        }
        .btn-super:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        }
        .brand-super {
            color: #3b82f6;
            font-weight: 800;
            font-size: 2.2rem;
            margin-bottom: 5px;
            display: block;
        }

        @media (max-width: 768px) {
            .login-card-super {
                padding: 30px 25px;
            }
            .brand-super {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-card-super">
        <span class="brand-super">METRA</span>
        <p class="text-white-50 mb-4 small text-uppercase fw-bold ls-1">Acceso Administrativo SaaS</p>

        <form action="/superadmin/dashboard">
            <div class="text-start mb-3">
                <label class="form-label small fw-bold text-white-50">Usuario</label>
                <input type="text" class="form-control form-control-super" placeholder="admin@vtech.com" required>
            </div>
            <div class="text-start mb-4">
                <label class="form-label small fw-bold text-white-50">Contraseña</label>
                <input type="password" class="form-control form-control-super" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="btn-super">
                Iniciar Sesión
            </button>
        </form>
        
        <div class="mt-4">
            <a href="/" class="text-white-50 small text-decoration-none">← Volver al sitio público</a>
        </div>
    </div>

</body>
</html>
