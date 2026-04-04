<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Tutorías - Iniciar Sesión</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Inter', system-ui, sans-serif;
            background: url('/images/login-bg.jpg') no-repeat center center/cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            position: relative;
        }

        /* Partículas */
        #particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }

        /* Overlay oscuro sobre la imagen */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            z-index: 0;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
            margin-left: 10%;
            z-index: 2;
            position: relative;
        }

        /* Responsive: en pantallas pequeñas centramos el formulario */
        @media (max-width: 992px) {
            .login-container {
                margin-left: 0;
                margin-right: 0;
                display: flex;
                justify-content: center;
            }
            body {
                justify-content: center;
            }
        }

        .login-card {
            background: rgba(15, 15, 20, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 28px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(34, 197, 94, 0.1);
            overflow: hidden;
            animation: fadeIn 0.6s ease;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(34, 197, 94, 0.2);
        }

        .login-header {
            background: linear-gradient(135deg, #0a0f0a 0%, #1a2a1a 100%);
            padding: 45px 35px 35px;
            text-align: center;
            border-bottom: 1px solid rgba(34, 197, 94, 0.15);
        }

        .login-icon {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            box-shadow: 0 0 20px rgba(34, 197, 94, 0.3);
        }

        .login-icon i {
            font-size: 2.2rem;
            color: white;
        }

        .login-header h3 {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, #fff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #94a3b8;
            font-size: 0.85rem;
            margin-bottom: 0;
        }

        .login-body {
            padding: 35px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 22px;
        }

        .input-group-custom i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 1.1rem;
            z-index: 1;
            transition: color 0.2s;
        }

        .form-control-custom {
            width: 100%;
            padding: 13px 16px 13px 45px;
            border-radius: 14px;
            border: 1.5px solid #2d2d3d;
            background: #1a1a2a;
            color: #e5e5e5;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: #22c55e;
            background: #222235;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.15);
        }

        .form-control-custom:focus + i {
            color: #22c55e;
        }

        .form-control-custom::placeholder {
            color: #4b5563;
        }

        .form-check {
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        .form-check-input {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            cursor: pointer;
            accent-color: #22c55e;
            background-color: #1a1a2a;
            border-color: #2d2d3d;
        }

        .form-check-label {
            color: #9ca3af;
            font-size: 0.85rem;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            border-radius: 14px;
            border: none;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login i {
            margin-right: 8px;
        }

        .alert-custom {
            background: rgba(239, 68, 68, 0.1);
            border-left: 3px solid #ef4444;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .alert-custom i {
            margin-right: 8px;
            color: #ef4444;
        }

        .alert-custom span {
            font-size: 0.85rem;
            color: #fca5a5;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 0.7rem;
            color: #4b5563;
        }

        .footer-text i {
            margin-right: 4px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Toggle password button */
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #22c55e;
        }
    </style>
</head>

<body>
    <canvas id="particles"></canvas>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h3>Sistema de Tutorías</h3>
                <p>Accede con tu cuenta institucional</p>
            </div>

            <div class="login-body">
                @if(session('status'))
                    <div class="alert alert-success" style="background: rgba(34, 197, 94, 0.1); border: none; border-left: 3px solid #22c55e; color: #86efac;">
                        <i class="bi bi-check-circle-fill"></i> {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-custom">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span>
                            @foreach($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <div class="input-group-custom">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" name="email" autocomplete="off" class="form-control-custom"
                            placeholder="Correo institucional" value="{{ old('email') }}" required>
                    </div>

                    <div class="input-group-custom">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="password" id="password" autocomplete="current-password" 
                            class="form-control-custom" placeholder="Contraseña" required>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="bi bi-eye-slash" id="toggleIcon"></i>
                        </button>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Recordar sesión
                        </label>
                    </div>

                    <button type="submit" class="btn-login" id="btnLogin">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                    </button>
                </form>

                <div class="footer-text">
                    <i class="bi bi-shield-check"></i> Sistema seguro · Tutorías Académicas
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            }
        }

        // Loading state
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('btnLogin');

        if (form) {
            form.addEventListener('submit', function() {
                btn.disabled = true;
                btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Iniciando sesión...';
            });
        }

        // Partículas animadas
        const canvas = document.getElementById('particles');
        const ctx = canvas.getContext('2d');
        
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);
        
        let particles = [];
        const particleCount = 80;
        
        for (let i = 0; i < particleCount; i++) {
            particles.push({
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                radius: Math.random() * 2.5,
                speedY: Math.random() * 0.5 + 0.2,
                alpha: Math.random() * 0.4 + 0.1
            });
        }
        
        function drawParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            for (let i = 0; i < particles.length; i++) {
                let p = particles[i];
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(34, 197, 94, ${p.alpha})`;
                ctx.fill();
                
                // Movimiento ascendente
                p.y -= p.speedY;
                
                // Reset cuando sale de la pantalla
                if (p.y < 0) {
                    p.y = canvas.height;
                    p.x = Math.random() * canvas.width;
                }
            }
            
            requestAnimationFrame(drawParticles);
        }
        
        drawParticles();

        // Console credentials (development only)
        console.log('%c🔐 Sistema de Tutorías', 'color: #22c55e; font-size: 14px; font-weight: bold;');
        console.log('%cCredenciales de prueba:', 'color: #9ca3af; font-size: 12px;');
        console.log('%c📧 Coordinador: coordinador@example.com', 'color: #3b82f6;');
        console.log('%c📧 Tutor: tutor@example.com', 'color: #f59e0b;');
        console.log('%c📧 Alumno: alumno@example.com', 'color: #ef4444;');
        console.log('%c🔑 Contraseña: 12345678', 'color: #22c55e;');
    </script>
</body>
</html>