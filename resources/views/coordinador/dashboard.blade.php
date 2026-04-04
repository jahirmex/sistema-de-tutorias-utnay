@extends('layouts.coordinador')

@section('content')

<div class="container py-4">

    <h2 class="mb-4 fw-semibold fade-in">Dashboard</h2>

    <div class="row g-3">

        <!-- Usuarios -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 card-hover fade-in">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Usuarios</div>
                        <h3 class="fw-bold mb-0 counter" data-value="{{ $totalUsuarios }}">0</h3>
                    </div>
                    <div class="icon-circle bg-primary-subtle text-primary">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alumnos -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 card-hover fade-in">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Alumnos</div>
                        <h3 class="fw-bold mb-0 counter" data-value="{{ $totalAlumnos }}">0</h3>
                    </div>
                    <div class="icon-circle bg-success-subtle text-success">
                        <i class="bi bi-mortarboard fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tutores -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 card-hover fade-in">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total Tutores</div>
                        <h3 class="fw-bold mb-0 counter" data-value="{{ $totalTutores }}">0</h3>
                    </div>
                    <div class="icon-circle bg-warning-subtle text-warning">
                        <i class="bi bi-person-badge fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Métricas avanzadas -->
    <div class="row mt-4 g-3">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 fade-in">
                <div class="text-muted small">Alumnos por grupo</div>
                <h4 class="fw-bold mb-0">{{ $alumnosPorGrupo ?? '—' }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 fade-in">
                <div class="text-muted small">Promedio por tutor</div>
                <h4 class="fw-bold mb-0">{{ $promedioAlumnosPorTutor ?? '—' }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 fade-in">
                <div class="text-muted small">Grupos activos</div>
                <h4 class="fw-bold mb-0">{{ $totalGrupos ?? '—' }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 fade-in">
                <div class="text-muted small">Asignación completa</div>
                <h4 class="fw-bold mb-0">{{ $porcentajeAsignacion ?? '—' }}%</h4>
            </div>
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-3 fade-in">
                <div class="text-muted small mb-1">Estado del sistema</div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="fw-semibold" id="estadoSistemaTexto">Evaluando...</div>
                    <span class="badge rounded-pill px-3 py-2" id="estadoSistemaBadge">
                        --
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfica -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-3 fade-in">
                <h6 class="fw-semibold mb-3">Alumnos por Grupo</h6>
                <canvas id="graficaAlumnos"></canvas>
            </div>
        </div>
    </div>

    <!-- Sección adicional -->
    <div class="row mt-4 g-3">

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 fade-in">
                <h6 class="fw-semibold mb-3">Resumen rápido</h6>
                <p class="text-muted small mb-3">
                    Visualiza el estado general del sistema de tutorías. Puedes gestionar alumnos,
                    tutores y grupos desde el menú lateral.
                </p>

                <a href="{{ route('coordinador.reportes') }}" class="btn btn-primary">
                    📊 Ver reportes
                </a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-3 fade-in">
                <h6 class="fw-semibold mb-3">Actividad</h6>
                <ul class="list-unstyled small text-muted mb-0">
                    <li>• Últimos alumnos registrados</li>
                    <li>• Cambios en asignación de grupos</li>
                    <li>• Actualizaciones recientes</li>
                </ul>
            </div>
        </div>

    </div>

</div>

<style>
/* Hover suave */
.card-hover {
    transition: all 0.2s ease;
}
.card-hover:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

/* Iconos */
.icon-circle {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Animación */
.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Dark mode */
.dark-mode .card {
    background-color: #1e293b;
    color: #e2e8f0;
}
.dark-mode .text-muted {
    color: #94a3b8 !important;
}
canvas {
    max-height: 300px;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    // 🔢 Contadores animados
    document.querySelectorAll('.counter').forEach(el => {
        const target = parseInt(el.getAttribute('data-value')) || 0;
        let count = 0;
        const increment = Math.ceil(target / 30);

        const update = () => {
            count += increment;
            if (count >= target) {
                el.textContent = target;
            } else {
                el.textContent = count;
                requestAnimationFrame(update);
            }
        };

        update();
    });

    // 📊 Gráfica
    const ctx = document.getElementById('graficaAlumnos');

    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels ?? ['IDGS81','IDGS82','IDGS83','IDGS84']) !!},
                datasets: [{
                    label: 'Alumnos',
                    data: {!! json_encode($data ?? [10,12,8,9]) !!},
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // 🧠 Estado inteligente
    const porcentaje = {{ $porcentajeAsignacion ?? 0 }};
    const texto = document.getElementById('estadoSistemaTexto');
    const badge = document.getElementById('estadoSistemaBadge');

    if (porcentaje >= 90) {
        texto.textContent = 'Óptimo';
        badge.textContent = '🟢';
        badge.classList.add('bg-success-subtle', 'text-success');
    } else if (porcentaje >= 60) {
        texto.textContent = 'Regular';
        badge.textContent = '🟡';
        badge.classList.add('bg-warning-subtle', 'text-warning');
    } else {
        texto.textContent = 'Crítico';
        badge.textContent = '🔴';
        badge.classList.add('bg-danger-subtle', 'text-danger');
    }

});
</script>

@endsection