<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Tutorías - Tutor</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f5f7fa;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        /* Sidebar minimalista con colores claros */
        .sidebar {
            height: 100vh;
            background: #ffffff;
            color: #1e293b;
            padding: 28px 20px;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #e9ecef;
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.02);
        }

        .sidebar-header {
            padding-bottom: 24px;
            border-bottom: 1px solid #eef2f6;
            margin-bottom: 24px;
        }

        .sidebar-header h5 {
            font-size: 1.25rem;
            font-weight: 700;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 4px;
        }

        .sidebar-header small {
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .sidebar-nav {
            flex: 1;
        }

        .sidebar a {
            color: #475569;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            text-decoration: none;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-bottom: 4px;
        }

        .sidebar a i {
            font-size: 1.25rem;
            width: 24px;
        }

        .sidebar a:hover {
            background-color: #f1f5f9;
            color: #3b82f6;
            transform: translateX(4px);
        }

        .sidebar a.active {
            background: linear-gradient(135deg, #eff6ff 0%, #f5f3ff 100%);
            color: #3b82f6;
            font-weight: 600;
        }

        .sidebar a.active i {
            color: #3b82f6;
        }

        .sidebar-footer {
            padding-top: 20px;
            border-top: 1px solid #eef2f6;
            margin-top: auto;
        }

        .sidebar-footer .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px;
            border-radius: 12px;
            transition: all 0.2s;
        }

        .sidebar-footer .user-info:hover {
            background-color: #f8fafc;
        }

        .sidebar-footer .avatar-small {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .sidebar-footer .user-details {
            flex: 1;
        }

        .sidebar-footer .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 2px;
        }

        .sidebar-footer .user-role {
            font-size: 0.7rem;
            color: #94a3b8;
        }

        .sidebar-footer .logout-btn {
            color: #ef4444;
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 500;
            transition: all 0.2s;
            width: 100%;
            text-align: left;
        }

        .sidebar-footer .logout-btn:hover {
            background-color: #fef2f2;
            color: #dc2626;
        }

        .main-content {
            margin-left: 280px;
            width: calc(100% - 280px);
        }

        /* Navbar minimalista */
        .navbar-custom {
            background-color: #ffffff;
            border-bottom: 1px solid #f0f2f5;
            box-shadow: none;
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 12px 0;
        }

        .navbar-custom .dropdown-toggle {
            background: transparent;
            border: none;
            padding: 8px 12px;
            transition: all 0.2s;
        }

        .navbar-custom .dropdown-toggle:hover {
            background-color: #f8fafc;
        }

        .navbar-custom .avatar-circle {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        /* Tarjetas mejoradas */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            background: white;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .content {
            padding: 30px;
        }

        /* Scrollbar personalizada */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Animaciones */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card {
            animation: fadeIn 0.4s ease-out;
        }

        /* Badges y estados */
        .badge-estado {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background: #fafcff;
            border-radius: 16px;
            color: #6c757d;
        }
    </style>
</head>

<body>

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- SIDEBAR MINIMALISTA CLARA -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h5 class="fw-bold mb-1">Sistema Tutorías</h5>
                <small>Panel de tutor</small>
            </div>

            <div class="sidebar-nav">
                <a href="{{ route('tutor.dashboard') }}" class="{{ request()->routeIs('tutor.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <a href="{{ route('tutor.mis-alumnos') }}" class="{{ request()->routeIs('tutor.mis-alumnos') ? 'active' : '' }}">
                    <i class="bi bi-mortarboard"></i> Mis Alumnos
                </a>

                <a href="{{ route('tutor.tutorias') }}" class="{{ request()->routeIs('tutor.tutorias') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> Tutorías
                </a>

                <a href="{{ route('tutor.horario') }}" class="{{ request()->routeIs('tutor.horario') ? 'active' : '' }}">
                    <i class="bi bi-clock"></i> Mi Horario
                </a>
            </div>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="avatar-small">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ Auth::user()->name }}</div>
                        <div class="user-role">Tutor Académico</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button class="btn logout-btn" type="submit">
                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                    </button>
                </form>
            </div>
        </div>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="main-content">

            <!-- NAVBAR MINIMALISTA -->
            <nav class="navbar navbar-custom px-4">
                <div class="ms-auto d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar-circle d-inline-flex me-2">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <span class="fw-semibold">{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                            <li><a class="dropdown-item py-2" href="{{ route('tutor.perfil') }}">
                                <i class="bi bi-person me-2"></i>Mi perfil
                            </a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('tutor.configuracion') }}">
                                <i class="bi bi-gear me-2"></i>Configuración
                            </a></li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger py-2" type="submit">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- CONTENIDO DINÁMICO -->
            <div class="content">
                @yield('content')
            </div>

        </div>

    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@yield('scripts')

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: '{{ session('success') }}',
        confirmButtonColor: '#3b82f6',
        timer: 3000,
        customClass: {
            popup: 'rounded-4'
        }
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        confirmButtonColor: '#3b82f6'
    });
</script>
@endif

</body>
</html>