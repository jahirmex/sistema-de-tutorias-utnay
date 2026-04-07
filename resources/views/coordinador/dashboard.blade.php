@extends('layouts.coordinador')

@section('content')

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Dashboard</h2>
        <div class="d-flex gap-2 align-items-center">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                Sistema activo
            </span>
            <a href="{{ route('coordinador.reportes') }}" class="btn btn-sm btn-primary rounded-pill">
                <i class="bi bi-bar-chart"></i> Reportes
            </a>
        </div>
    </div>

    <!-- KPIs -->
    <div class="row g-4">

        <div class="col-md-4">
            <div class="card kpi-card">
                <div>
                    <p class="kpi-title">Usuarios</p>
                    <h3 class="kpi-value counter" data-value="{{ $totalUsuarios }}">0</h3>
                </div>
                <i class="bi bi-people kpi-icon"></i>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card kpi-card success">
                <div>
                    <p class="kpi-title">Alumnos</p>
                    <h3 class="kpi-value counter" data-value="{{ $totalAlumnos }}">0</h3>
                </div>
                <i class="bi bi-mortarboard kpi-icon"></i>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card kpi-card warning">
                <div>
                    <p class="kpi-title">Tutores</p>
                    <h3 class="kpi-value counter" data-value="{{ $totalTutores }}">0</h3>
                </div>
                <i class="bi bi-person-badge kpi-icon"></i>
            </div>
        </div>

    </div>

    <!-- Layout principal -->
    <div class="row mt-4 g-4">

        <!-- Gráfica -->
        <div class="col-lg-8">
            <div class="card p-4 shadow-sm rounded-4">
                <h6 class="fw-semibold mb-3">Distribución de alumnos por grupo</h6>
                <canvas id="graficaAlumnos"></canvas>
            </div>
        </div>

        <!-- Estado sistema -->
        <div class="col-lg-4">
            <div class="card p-4 shadow-sm rounded-4 h-100">
                <h6 class="fw-semibold mb-3">Estado del sistema</h6>
                <div class="text-center mt-3">
                    <h3 id="estadoSistemaTexto">Evaluando...</h3>
                    <div id="estadoSistemaBadge" class="mt-2 fs-1">--</div>
                </div>
                <hr>
                <div class="small text-muted">
                    Este indicador muestra el nivel de asignación de tutores en el sistema.
                </div>
            </div>
        </div>

    </div>

    <!-- Métricas secundarias -->
    <div class="row mt-4 g-4">

        <div class="col-md-3">
            <div class="card metric-card">
                <p>Grupos activos</p>
                <h4>{{ $totalGrupos ?? 0 }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card metric-card">
                <p>Promedio general</p>
                <h4>{{ number_format($promedioGeneral ?? 0,1) }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card metric-card">
                <p>Asignación</p>
                <h4>{{ $porcentajeAsignacion ?? 0 }}%</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card metric-card">
                <p>Alumnos / Tutor</p>
                <h4>{{ $promedioAlumnosPorTutor ?? 0 }}</h4>
            </div>
        </div>

    </div>

</div>

<style>
.kpi-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-radius: 16px;
    background: #ffffff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.kpi-card.success { border-left: 5px solid #22c55e; }
.kpi-card.warning { border-left: 5px solid #f59e0b; }
.kpi-card { border-left: 5px solid #3b82f6; }

.kpi-title { font-size: 0.85rem; color: #64748b; margin-bottom: 5px; }
.kpi-value { font-weight: bold; }
.kpi-icon { font-size: 28px; color: #94a3b8; }

.metric-card {
    text-align: center;
    padding: 20px;
    border-radius: 16px;
    background: #f8fafc;
}

.metric-card h4 { font-weight: bold; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    // contador
    document.querySelectorAll('.counter').forEach(el => {
        const target = parseInt(el.dataset.value) || 0;
        let count = 0;
        const step = Math.ceil(target / 30);

        const update = () => {
            count += step;
            if (count >= target) {
                el.textContent = target;
            } else {
                el.textContent = count;
                requestAnimationFrame(update);
            }
        };

        update();
    });

    // gráfica
    const ctx = document.getElementById('graficaAlumnos');

    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels ?? []) !!},
                datasets: [{
                    label: 'Alumnos',
                    data: {!! json_encode($data ?? []) !!}
                }]
            }
        });
    }

    // estado
    const porcentaje = {{ $porcentajeAsignacion ?? 0 }};
    const texto = document.getElementById('estadoSistemaTexto');
    const badge = document.getElementById('estadoSistemaBadge');

    if (porcentaje >= 90) {
        texto.textContent = 'Óptimo';
        badge.textContent = '🟢';
    } else if (porcentaje >= 60) {
        texto.textContent = 'Regular';
        badge.textContent = '🟡';
    } else {
        texto.textContent = 'Crítico';
        badge.textContent = '🔴';
    }

});
</script>

@endsection