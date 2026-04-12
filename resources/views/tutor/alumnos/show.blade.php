@extends('layouts.tutor')

@section('content')
<div class="container-fluid px-4 py-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-semibold mb-1 text-dark">
                <i class="bi bi-person-circle me-2 text-primary"></i>Detalle del Alumno
            </h2>
            <p class="text-muted small mb-0">Información académica y seguimiento de tutorías</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-3 btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Regresar
            </a>
            <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-3 btn-sm">
                <i class="bi bi-printer me-1"></i> Imprimir
            </button>
            <button onclick="toggleDarkMode()" id="darkModeBtn" class="btn btn-outline-secondary rounded-pill px-3 btn-sm">
                <i class="bi bi-moon-stars me-1"></i> Modo oscuro
            </button>
        </div>
    </div>

    <!-- Perfil del alumno -->
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-4 flex-wrap">
                        <div class="avatar-large">
                            {{ strtoupper(substr($alumno->user->name ?? 'A', 0, 2)) }}
                        </div>
                        <div>
                            <h3 class="fw-bold mb-1">{{ $alumno->user->name ?? 'Sin nombre' }}</h3>
                            <div class="d-flex gap-2 flex-wrap mb-2">
                                <span class="badge-grupo">
                                    <i class="bi bi-people-fill me-1"></i>
                                    {{ $alumno->grupo->nombre ?? 'Sin grupo' }}
                                </span>
                                <span class="badge-matricula">
                                    <i class="bi bi-qr-code me-1"></i>
                                    Matrícula: {{ $alumno->matricula ?? 'N/A' }}
                                </span>
                                <span class="badge-carrera">
                                    <i class="bi bi-book me-1"></i>
                                    {{ $alumno->carrera ?? 'Carrera no especificada' }}
                                </span>
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-envelope me-1"></i>
                                {{ $alumno->user->email ?? 'Sin correo' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="row g-3 h-100">
                <div class="col-12">
                    <div class="card border-0 shadow-sm h-100 text-center stat-card" style="border-radius: 16px;">
                        <div class="card-body p-3">
                            <div class="stat-icon-sm bg-primary bg-opacity-10 mx-auto mb-2">
                                <i class="bi bi-chat-dots text-primary fs-4"></i>
                            </div>
                            <h3 class="fw-bold mb-0">{{ $alumno->tutorias->count() }}</h3>
                            <small class="text-muted">Total Tutorías</small>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card border-0 shadow-sm h-100 text-center stat-card" style="border-radius: 16px;">
                        <div class="card-body p-4">
                            <div class="stat-icon-sm bg-success bg-opacity-10 mx-auto mb-2">
                                <i class="bi bi-calendar-check text-success fs-4"></i>
                            </div>
                            <h3 class="fw-bold mb-0 text-nowrap fs-5">
                                @php
                                    $ultimaTutoria = $alumno->tutorias->sortByDesc('fecha')->first();
                                @endphp
                                {{ $ultimaTutoria ? \Carbon\Carbon::parse($ultimaTutoria->fecha)->format('d/m/Y') : 'N/A' }}
                            </h3>
                            <small class="text-muted">Última tutoría</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Gráfica de tutorías -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom px-4 py-3" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-graph-up me-2 text-primary"></i>Evolución de Tutorías
                    </h5>
                    <p class="text-muted small mb-0 mt-1">Distribución mensual y acumulado</p>
                </div>
                <div class="card-body p-4">
                    <canvas id="tutoriasChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Resumen rápido -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom px-4 py-3" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-pie-chart me-2 text-primary"></i>Resumen
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="info-list">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-calendar-range me-2 text-primary"></i>Primera tutoría
                            </div>
                            <div class="info-value">
                                @php
                                    $primeraTutoria = $alumno->tutorias->sortBy('fecha')->first();
                                @endphp
                                {{ $primeraTutoria ? \Carbon\Carbon::parse($primeraTutoria->fecha)->format('d M Y') : 'Sin registros' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-clock-history me-2 text-primary"></i>Última tutoría
                            </div>
                            <div class="info-value">
                                {{ $ultimaTutoria ? \Carbon\Carbon::parse($ultimaTutoria->fecha)->format('d M Y') : 'Sin registros' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-calendar-week me-2 text-primary"></i>Frecuencia promedio
                            </div>
                            <div class="info-value">
                                @php
                                    $count = $alumno->tutorias->count();
                                    $frecuencia = $count > 0 ? round($count / max(1, \Carbon\Carbon::parse($primeraTutoria->fecha ?? now())->diffInMonths(now())), 1) : 0;
                                @endphp
                                {{ $frecuencia }} por mes
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-person-badge me-2 text-primary"></i>Tutor asignado
                            </div>
                            <div class="info-value">
                                {{ $alumno->grupo->tutor->user->name ?? 'No asignado' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de tutorías -->
    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-radius: 16px 16px 0 0;">
            <h5 class="fw-semibold mb-0">
                <i class="bi bi-journal-bookmark-fill me-2 text-primary"></i>Historial de Tutorías
            </h5>
            <div class="d-flex gap-2">
                <div class="input-group" style="width: 200px;">
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="searchTutoria" class="form-control border-start-0 rounded-end-pill" placeholder="Buscar tema...">
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($alumno->tutorias->isEmpty())
                <div class="text-center py-5">
                    <div class="empty-state">
                        <div class="empty-state-icon mx-auto mb-3">
                            <i class="bi bi-journal-x fs-1 text-muted"></i>
                        </div>
                        <h5 class="fw-semibold text-muted">No hay tutorías registradas</h5>
                        <p class="text-muted small">Este alumno aún no tiene tutorías en el sistema.</p>
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="tutoriasTable">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3" style="min-width: 120px;">
                                    <i class="bi bi-calendar me-1 text-primary"></i> Fecha
                                </th>
                                <th class="py-3" style="min-width: 200px;">
                                    <i class="bi bi-book me-1 text-primary"></i> Tema
                                </th>
                                <th class="py-3" style="min-width: 250px;">
                                    <i class="bi bi-file-text me-1 text-primary"></i> Descripción
                                </th>
                                <th class="py-3" style="min-width: 180px;">
                                    <i class="bi bi-person-badge me-1 text-primary"></i> Tutor
                                </th>
                                <th class="px-4 py-3 text-center" style="min-width: 100px;">
                                    <i class="bi bi-eye me-1 text-primary"></i> Acción
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumno->tutorias->sortByDesc('fecha') as $tutoria)
                            <tr class="tutoria-row" data-tema="{{ strtolower($tutoria->tema ?? '') }}">
                                <td class="px-4 py-3">
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ \Carbon\Carbon::parse($tutoria->fecha)->translatedFormat('d M Y') }}</span>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($tutoria->fecha)->format('h:i A') }}</small>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="fw-semibold">{{ $tutoria->tema }}</span>
                                </td>
                                <td class="py-3">
                                    <p class="mb-0 small text-muted" style="max-width: 250px;">
                                        {{ Str::limit($tutoria->descripcion, 80) }}
                                    </p>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-tutor">
                                            {{ strtoupper(substr($tutoria->tutor->user->name ?? 'T', 0, 1)) }}
                                        </div>
                                        <span>{{ $tutoria->tutor->user->name ?? 'Sin tutor' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('tutorias.show', $tutoria->id) }}" class="btn-view" data-bs-toggle="tooltip" title="Ver detalle">
                                        <i class="bi bi-eye me-1"></i> Ver
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        
        <div class="card-footer bg-white border-top py-3 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex gap-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Total: {{ $alumno->tutorias->count() }} tutorías
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-calendar me-1"></i>
                        Desde {{ $primeraTutoria ? \Carbon\Carbon::parse($primeraTutoria->fecha)->format('M Y') : 'N/A' }}
                    </small>
                </div>
                <small class="text-muted">
                    <i class="bi bi-clock me-1"></i>
                    Actualizado: {{ now()->format('d/m/Y H:i') }}
                </small>
            </div>
        </div>
    </div>
</div>

<style>
/* Avatar grande */
.avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 28px;
    text-transform: uppercase;
}

/* Badges */
.badge-grupo {
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    color: #3730a3;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-matricula {
    background: #f1f5f9;
    color: #475569;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-carrera {
    background: #fef3c7;
    color: #92400e;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

/* Estadísticas */
.stat-card {
    transition: all 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
}

.stat-icon-sm {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Información */
.info-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 12px;
    border-bottom: 1px solid #e9ecef;
}

.info-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-label {
    font-size: 0.8rem;
    color: #6c757d;
}

.info-value {
    font-weight: 600;
    font-size: 0.9rem;
    color: #212529;
}

/* Avatar tutor */
.avatar-tutor {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    background: #e9ecef;
    color: #495057;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
}

/* Botón ver */
.btn-view {
    background: none;
    border: none;
    color: #0d6efd;
    font-size: 0.75rem;
    padding: 5px 12px;
    border-radius: 20px;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.btn-view:hover {
    background: #e7f1ff;
    color: #0b5ed7;
}

/* Empty state */
.empty-state-icon {
    width: 70px;
    height: 70px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Tabla */
.table th {
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
    border-color: #e9ecef;
}

.table-hover tbody tr:hover {
    background-color: #f8fafc;
}

/* Dark mode */
.dark-mode {
    background-color: #0f172a !important;
    color: #e2e8f0 !important;
}

.dark-mode .card,
.dark-mode .card-header,
.dark-mode .card-footer {
    background-color: #1e293b !important;
    border-color: #334155 !important;
}

.dark-mode .table {
    color: #e2e8f0;
}

.dark-mode .table td,
.dark-mode .table th {
    border-color: #334155;
}

.dark-mode .table-light th {
    background-color: #0f3460;
    color: #e2e8f0;
}

.dark-mode .table-hover tbody tr:hover {
    background-color: #334155;
}

.dark-mode .badge-matricula {
    background: #334155;
    color: #cbd5e1;
}

.dark-mode .badge-carrera {
    background: #451a03;
    color: #fcd34d;
}

.dark-mode .badge-grupo {
    background: #1e1b4b;
    color: #a5b4fc;
}

.dark-mode .info-item {
    border-bottom-color: #334155;
}

.dark-mode .info-label {
    color: #94a3b8;
}

.dark-mode .info-value {
    color: #e2e8f0;
}

.dark-mode .avatar-tutor {
    background: #475569;
    color: #cbd5e1;
}

.dark-mode .btn-view:hover {
    background: #1e40af;
    color: #e2e8f0;
}

.dark-mode .empty-state-icon {
    background: #1e293b;
}

.dark-mode .text-muted {
    color: #94a3b8 !important;
}

/* Responsive */
@media (max-width: 768px) {
    .avatar-large {
        width: 60px;
        height: 60px;
        font-size: 22px;
    }
    
    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .table {
        font-size: 0.75rem;
    }
    
    .btn-view {
        font-size: 0.65rem;
        padding: 3px 8px;
    }
}

/* Animación */
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
    animation: fadeIn 0.3s ease-out;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const tutorias = @json($alumno->tutorias);

    // Agrupar por mes
    const conteo = {};

    tutorias.forEach(t => {
        const fecha = new Date(t.fecha);
        const mes = fecha.toLocaleString('es-MX', { month: 'short', year: 'numeric' });

        conteo[mes] = (conteo[mes] || 0) + 1;
    });

    const sorted = Object.entries(conteo).sort((a, b) => {
        const fechaA = new Date(a[0]);
        const fechaB = new Date(b[0]);
        return fechaA - fechaB;
    });

    const labels = sorted.map(e => e[0]);
    const data = sorted.map(e => e[1]);

    // acumulado
    let acumulado = [];
    let total = 0;
    data.forEach(v => {
        total += v;
        acumulado.push(total);
    });

    const ctx = document.getElementById('tutoriasChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Tutorías por mes',
                    data: data,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Acumulado',
                    data: acumulado,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.05)',
                    tension: 0.4,
                    fill: false,
                    borderDash: [5, 5],
                    pointBackgroundColor: 'rgba(255, 99, 132, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 3,
                    pointHoverRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: { size: 11 },
                        usePointStyle: true,
                        boxWidth: 8
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    },
                    grid: {
                        color: '#e2e8f0'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 1000
            }
        }
    });

    // Búsqueda en tabla
    document.getElementById('searchTutoria')?.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase().trim();
        const rows = document.querySelectorAll('.tutoria-row');
        
        rows.forEach(row => {
            const tema = row.getAttribute('data-tema') || '';
            row.style.display = searchTerm === '' || tema.includes(searchTerm) ? '' : 'none';
        });
    });

    // Dark mode toggle
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        const isDark = document.body.classList.contains('dark-mode');
        localStorage.setItem('darkMode', isDark);
        
        const btn = document.getElementById('darkModeBtn');
        if (btn) {
            btn.innerHTML = isDark ? '<i class="bi bi-sun me-1"></i> Modo claro' : '<i class="bi bi-moon-stars me-1"></i> Modo oscuro';
        }
    }

    // Verificar dark mode
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
        const btn = document.getElementById('darkModeBtn');
        if (btn) {
            btn.innerHTML = '<i class="bi bi-sun me-1"></i> Modo claro';
        }
    }

    // Tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection