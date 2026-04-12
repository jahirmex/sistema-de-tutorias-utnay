<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>UT Nayarit · Sistema de Tutorías PRO</title>

    <!-- Bootstrap 5 + Icons + SweetAlert -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Google Fonts: Inter + Outrun (ligera) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: radial-gradient(circle at 10% 20%, #e8f5e9 0%, #c8e6d9 50%, #a5d6a7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Efecto de ruido sutil */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzMDAiIGhlaWdodD0iMzAwIj48ZmlsdGVyIGlkPSJmIj48ZmVUdXJidWxlbmNlIHR5cGU9ImZyYWN0YWxOb2lzZSIgYmFzZUZyZXF1ZW5jeT0iLjciIG51bU9jdGF2ZXM9IjMiLz48L2ZpbHRlcj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWx0ZXI9InVybCgjZikiIG9wYWNpdHk9IjAuMDMiLz48L3N2Zz4=');
            background-repeat: repeat;
            opacity: 0.15;
            pointer-events: none;
            z-index: 0;
        }

        /* Orbes flotantes en tonos verdes claros */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            z-index: 0;
            pointer-events: none;
        }
        .orb-1 {
            width: 40vw;
            height: 40vw;
            background: radial-gradient(circle, #86efac80, #bbf7d000);
            top: -15vh;
            right: -10vw;
            animation: floatOrb 18s infinite alternate ease-in-out;
        }
        .orb-2 {
            width: 35vw;
            height: 35vw;
            background: radial-gradient(circle, #a7f3d080, #dcfce700);
            bottom: -20vh;
            left: -5vw;
            animation: floatOrb 22s infinite alternate-reverse;
        }
        .orb-3 {
            width: 25vw;
            height: 25vw;
            background: radial-gradient(circle, #6ee7b780, #ecfdf500);
            bottom: 30vh;
            right: 20vw;
            animation: floatOrb 14s infinite alternate;
        }

        @keyframes floatOrb {
            0% { transform: translate(0, 0) scale(1); opacity: 0.3; }
            100% { transform: translate(5%, 5%) scale(1.2); opacity: 0.55; }
        }

        /* Contenedor principal */
        .login-wrapper {
            width: 100%;
            max-width: 1400px;
            margin: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 3rem;
            flex-wrap: wrap;
            position: relative;
            z-index: 10;
        }

        /* COLUMNA IZQUIERDA: branding con glassmorphism claro */
        .hero-section {
            flex: 1.2;
            min-width: 300px;
            padding: 2rem;
            background: rgba(240, 253, 244, 0.35);
            backdrop-filter: blur(12px);
            border-radius: 48px;
            border: 1px solid rgba(34, 197, 94, 0.3);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08), inset 0 1px 1px rgba(255,255,255,0.6);
            transition: transform 0.3s ease;
            animation: fadeInLeft 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .hero-section:hover {
            transform: translateY(-5px);
            background: rgba(240, 253, 244, 0.5);
            border-color: rgba(34, 197, 94, 0.5);
        }

        .logo-ut {
            margin-bottom: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-ut img {
            max-width: 180px;
            filter: drop-shadow(0 8px 20px rgba(0,0,0,0.1));
            transition: all 0.2s;
        }

        .mobile-logo {
            display: none;
            margin-bottom: 1.5rem;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(125deg, #0f3b2c 20%, #166534 60%, #22c55e 100%);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .hero-section p {
            font-size: 1rem;
            color: #2d5a3b;
            line-height: 1.6;
            max-width: 460px;
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(255,255,255,0.3);
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        .hero-badge {
            margin-top: 2.5rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-badge span {
            background: rgba(34, 197, 94, 0.2);
            backdrop-filter: blur(4px);
            padding: 0.5rem 1.2rem;
            border-radius: 60px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #166534;
            border: 1px solid rgba(34,197,94,0.4);
            letter-spacing: 0.3px;
        }

        /* COLUMNA DERECHA: Tarjeta GLASS premium clara */
        .login-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(18px);
            border-radius: 56px;
            border: 1px solid rgba(34, 197, 94, 0.4);
            box-shadow: 0 30px 50px -20px rgba(0, 0, 0, 0.15), inset 0 1px 0 rgba(255,255,255,0.8);
            padding: 2.6rem;
            width: 100%;
            max-width: 500px;
            transition: all 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            animation: fadeInRight 0.7s ease-out;
        }

        .login-card:hover {
            transform: translateY(-6px);
            border-color: rgba(34, 197, 94, 0.7);
            box-shadow: 0 35px 60px -15px rgba(34, 197, 94, 0.25);
            background: rgba(255, 255, 255, 0.92);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h3 {
            font-size: 1.9rem;
            font-weight: 700;
            background: linear-gradient(135deg, #0f3b2c, #166534);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            font-size: 0.85rem;
            color: #4a7c5c;
        }

        /* Formulario refinado */
        .form-group {
            margin-bottom: 1.6rem;
        }

        .form-group label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #166534;
            margin-bottom: 0.5rem;
            display: block;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #6fbf7a;
            font-size: 1.1rem;
            transition: all 0.2s;
            z-index: 2;
        }

        .form-control-custom {
            width: 100%;
            padding: 14px 18px 14px 48px;
            border-radius: 34px;
            border: 1px solid rgba(34, 197, 94, 0.5);
            background: rgba(255, 255, 255, 0.9);
            color: #1f3b2c;
            font-size: 0.9rem;
            transition: all 0.25s;
            font-weight: 500;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: #22c55e;
            background: white;
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.15);
        }

        .form-control-custom:focus + i {
            color: #22c55e;
        }

        .form-control-custom::placeholder {
            color: #9bc0a5;
            font-weight: 400;
        }

        /* Botón principal efecto shiny verde claro */
        .btn-login {
            width: 100%;
            padding: 14px;
            border-radius: 44px;
            border: none;
            background: linear-gradient(95deg, #22c55e 0%, #4ade80 100%);
            color: white;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.25s;
            cursor: pointer;
            margin-bottom: 1.2rem;
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);
            letter-spacing: 0.3px;
            position: relative;
            overflow: hidden;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0) 80%);
            opacity: 0;
            transition: opacity 0.5s;
        }

        .btn-login:hover::after {
            opacity: 0.3;
        }

        .btn-login:hover {
            background: linear-gradient(95deg, #16a34a 0%, #3bcf6b 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(34, 197, 94, 0.5);
        }

        .forgot-link {
            text-align: center;
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: #16a34a;
            text-decoration: none;
            transition: 0.2s;
        }

        .forgot-link:hover {
            color: #0f5c2e;
            text-decoration: underline;
        }

        /* Checkbox premium */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin: 1.2rem 0 1.2rem;
        }

        .checkbox-group input {
            width: 18px;
            height: 18px;
            accent-color: #22c55e;
            filter: drop-shadow(0 0 2px #86efac);
        }

        .checkbox-group label {
            font-size: 0.8rem;
            color: #2d6a4f;
            font-weight: 600;
        }

        /* Alertas glass claras */
        .alert-custom, .alert-success-custom {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border-radius: 28px;
            padding: 12px 20px;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
            font-size: 0.8rem;
            color: #1f3b2c;
        }
        .alert-custom {
            border-left-color: #f97316;
        }
        .alert-success-custom {
            border-left-color: #22c55e;
        }

        .login-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.65rem;
            color: #5b8c6f;
            border-top: 1px solid rgba(34, 197, 94, 0.25);
            padding-top: 1.2rem;
            font-weight: 500;
        }

        /* Animaciones */
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Responsive perfecto */
        @media (max-width: 1000px) {
            .login-wrapper {
                flex-direction: column-reverse;
                justify-content: center;
                margin: 1rem;
            }
            .hero-section {
                text-align: center;
                backdrop-filter: blur(8px);
                width: 100%;
            }
            .hero-section h1 {
                font-size: 2.4rem;
            }
            .hero-section p {
                margin-left: auto;
                margin-right: auto;
            }
            .hero-badge {
                justify-content: center;
            }
            .login-card {
                max-width: 100%;
                padding: 1.8rem;
            }
            .hero-badge {
                display: none;
            }
            .hero-section p {
                display: none;
            }
            .hero-section {
                padding: 1.2rem;
            }

            .hero-section {
                display: none;
            }

            .mobile-logo {
                display: flex;
                justify-content: center;
            }
        }

        @media (max-width: 520px) {
            .login-card {
                padding: 1.5rem;
            }
            .hero-section h1 {
                font-size: 2rem;
            }
            .btn-login {
                padding: 12px;
            }
        }
    </style>
</head>
<body>

    <!-- Orbes de fondo en tonos verdes claros -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="login-wrapper">
        <!-- COLUMNA IZQUIERDA: mensaje institucional -->
        <div class="hero-section">
            <div class="logo-ut">
                <img src="{{ asset('images/utn.png') }}" alt="Universidad Tecnológica de Nayarit">
            </div>
            <h1>Tutorías<br>de Alto Rendimiento</h1>
            <p>Panel integral para seguimiento académico, sesiones personalizadas y métricas en tiempo real.</p>
            <div class="hero-badge">
                <span><i class="bi bi-calendar-check me-1"></i> Seguimiento</span>
                <span><i class="bi bi-graph-up me-1"></i> Análisis</span>
                <span><i class="bi bi-chat-dots me-1"></i> Tutorías 360°</span>
            </div>
        </div>

        <!-- COLUMNA DERECHA: login ultramoderno -->
        <div class="login-card">
            <div class="logo-ut mobile-logo">
                <img src="{{ asset('images/utn.png') }}" alt="UT Nayarit">
            </div>
            <div class="login-header">
                <h3>Acceso seguro</h3>
                <p>Ingresa tus credenciales institucionales</p>
            </div>

            @if(session('status'))
                <div class="alert-success-custom">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-custom">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <div class="form-group">
                    <label>Correo institucional</label>
                    <div class="input-icon">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" name="email" class="form-control-custom"
                               placeholder="tucuenta@utnayarit.edu.mx" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <div class="input-icon">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password" id="password" class="form-control-custom"
                               placeholder="••••••••" required>
                        <button type="button" class="toggle-password" onclick="togglePassword()"
                                style="position: absolute; right: 18px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #6fbf7a; cursor: pointer; z-index: 5;">
                            <i class="bi bi-eye-slash" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Mantener sesión activa</label>
                </div>

                <button type="submit" class="btn-login" id="btnLogin">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Ingresar al sistema
                </button>

                <a href="#" class="forgot-link">¿Restablecer contraseña?</a>
            </form>

            <div class="login-footer">
                <i class="bi bi-shield-lock-fill me-1"></i> Plataforma certificada · UT Nayarit
            </div>
        </div>
    </div>

    <script>
        // Mostrar/ocultar contraseña
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }

        // Prevenir doble envío
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('btnLogin');
        if (form) {
            form.addEventListener('submit', () => {
                btn.disabled = true;
                btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Autenticando...';
            });
        }

        // Console development
        console.log('%c🌿 UT Nayarit · Tutorías PRO | Verde Fresh Edition', 'color: #22c55e; font-size: 14px; font-weight: bold;');
        console.log('%c🔐 Demo: coordinador@example.com | tutor@example.com | alumno@example.com', 'color: #166534;');
        console.log('%c🔑 Pass: 12345678', 'color: #4ade80;');
    </script>
</body>
</html>