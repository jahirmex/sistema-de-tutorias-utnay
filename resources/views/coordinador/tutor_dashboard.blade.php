@extends('layouts.coordinador')

@section('content')
<div class="container-fluid px-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-person-badge me-2 text-primary"></i>Dashboard - {{ $tutor->user->name }}
            </h2>
            <p class="text-muted">Resumen de alumnos asignados y grupos a cargo</p>
        </div>
        <a href="/coordinador/tutores" class="btn btn-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Volver a tutores
        </a>
    </div>

    <!-- Tarjetas de métricas -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm hover-shadow transition" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Total alumnos</div>
                            <h2 class="fw-bold display-6 mb-0">{{ $totalAlumnos }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-people-fill text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-mortarboard me-1"></i> Alumnos asignados al tutor
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm hover-shadow transition" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Grupos asignados</div>
                            <h2 class="fw-bold display-6 mb-0">{{ $totalGrupos }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-diagram-3 text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-grid me-1"></i> Grupos a cargo del tutor
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfica y filtros -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-bar-chart me-2 text-primary"></i>Alumnos por grupo
                </h5>
                <div class="d-flex gap-2">
                    <div class="input-group" style="width: 250px;">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="searchAlumno" class="form-control border-start-0 rounded-end-pill" placeholder="Buscar alumno...">
                    </div>
                    <select id="filterGrupo" class="form-select rounded-pill" style="width: 180px;">
                        <option value="">Todos los grupos</option>
                        @foreach($tutor->grupos as $grupo)
                            <option value="{{ $grupo->nombre }}">{{ $grupo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <canvas id="graficaTutor" height="100"></canvas>
        </div>
    </div>

    <!-- Tabla de alumnos -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-table me-2 text-primary"></i>Alumnos del tutor
            </h5>
        </div>
        
        <div class="card-body p-0">
            @php
                $totalAlumnosLista = 0;
                foreach($tutor->grupos as $grupo) {
                    $totalAlumnosLista += $grupo->alumnos->count();
                }
            @endphp
            
            @if($totalAlumnosLista > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="alumnosTable" style="min-width: 800px;">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th class="px-4 py-3 border-0" style="min-width: 200px;"><i class="bi bi-person me-1"></i> Nombre</th>
                                <th class="py-3 border-0" style="min-width: 200px;"><i class="bi bi-envelope me-1"></i> Correo</th>
                                <th class="py-3 border-0" style="min-width: 120px;"><i class="bi bi-qr-code me-1"></i> Matrícula</th>
                                <th class="py-3 border-0 text-center" style="min-width: 120px;"><i class="bi bi-people me-1"></i> Grupo</th>
                             </tr>
                        </thead>
                        <tbody>
                            @foreach($tutor->grupos as $grupo)
                                @foreach($grupo->alumnos as $alumno)
                                <tr class="border-bottom" 
                                    data-nombre="{{ strtolower($alumno->user->name ?? '') }}"
                                    data-correo="{{ strtolower($alumno->user->email ?? '') }}"
                                    data-grupo="{{ $grupo->nombre }}">
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-circle bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                                                <i class="bi bi-person-circle text-primary"></i>
                                            </div>
                                            <div class="fw-semibold text-nowrap">{{ $alumno->user->name ?? 'Sin nombre' }}</div>
                                        </div>
                                     </td>
                                    <td class="py-3">
                                        <a href="mailto:{{ $alumno->user->email }}" class="text-decoration-none text-dark hover-primary">
                                            <i class="bi bi-envelope me-1 text-muted"></i>
                                            <span class="text-nowrap">{{ $alumno->user->email ?? 'Sin correo' }}</span>
                                        </a>
                                     </td>
                                    <td class="py-3"><code class="text-nowrap">{{ $alumno->matricula }}</code></td>
                                    <td class="py-3 text-center">
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 text-nowrap">
                                            <i class="bi bi-people-fill me-1"></i>{{ $grupo->nombre }}
                                        </span>
                                     </td>
                                 </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                     </table>
                </div>
            @else
                <div class="empty-state m-4">
                    <i class="bi bi-inbox display-1 text-muted mb-3 d-block"></i>
                    <h5 class="text-muted">No hay alumnos asignados</h5>
                    <p class="text-muted mb-0">Este tutor aún no tiene alumnos a su cargo</p>
                </div>
            @endif
        </div>
        
        <div class="card-footer bg-white border-0 pb-4 px-4">
            <div class="d-flex justify-content-end">
                <small class="text-muted">
                    <i class="bi bi-people me-1"></i> Total de alumnos: {{ $totalAlumnos }}
                </small>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-primary:hover {
        color: #3b82f6 !important;
    }
    
    .table tbody tr {
        transition: background-color 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
    
    .avatar-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
    }
    
    .transition {
        transition: all 0.3s ease;
    }
    
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
    
    .badge {
        font-weight: 500;
    }
    
    .text-nowrap {
        white-space: nowrap;
    }
    
    /* Dark mode styles */
    .dark-mode {
        background-color: #0f172a !important;
        color: #e2e8f0 !important;
    }
    
    .dark-mode .card {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
    }
    
    .dark-mode .card-header {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    
    .dark-mode .table {
        color: #e2e8f0;
    }
    
    .dark-mode .table tbody tr:hover {
        background-color: #334155;
    }
    
    .dark-mode .badge.bg-primary-subtle {
        background-color: rgba(59, 130, 246, 0.2) !important;
        color: #93c5fd !important;
    }
    
    .dark-mode .form-control, 
    .dark-mode .form-select {
        background-color: #1e293b;
        color: #e2e8f0;
        border-color: #334155;
    }
    
    .dark-mode .form-control::placeholder {
        color: #94a3b8;
    }
    
    .dark-mode .input-group-text {
        background-color: #1e293b;
        border-color: #334155;
        color: #e2e8f0;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfica
    const ctx = document.getElementById('graficaTutor').getContext('2d');
    
    const data = {
        labels: [
            @foreach($alumnosPorGrupo as $item)
                "{{ $item['nombre'] }}",
            @endforeach
        ],
        datasets: [{
            label: 'Alumnos',
            data: [
                @foreach($alumnosPorGrupo as $item)
                    {{ $item['total'] }},
                @endforeach
            ],
            backgroundColor: 'rgba(59, 130, 246, 0.5)',
            borderColor: '#3b82f6',
            borderWidth: 2,
            borderRadius: 8,
            barPercentage: 0.7
        }]
    };
    
    const chart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Alumnos: ${context.raw}`;
                        }
                    }
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
            }
        }
    });
    
    // 🔍 Buscador + filtro
    const searchInput = document.getElementById('searchAlumno');
    const filterGrupo = document.getElementById('filterGrupo');
    const rows = document.querySelectorAll('tbody tr');
    
    function filtrarTabla() {
        const search = searchInput ? searchInput.value.toLowerCase() : '';
        const grupo = filterGrupo ? filterGrupo.value : '';
        
        rows.forEach(row => {
            const nombre = row.dataset.nombre || '';
            const correo = row.dataset.correo || '';
            const grupoRow = row.dataset.grupo || '';
            
            const coincideBusqueda = search === '' || nombre.includes(search) || correo.includes(search);
            const coincideGrupo = grupo === '' || grupoRow === grupo;
            
            if (coincideBusqueda && coincideGrupo) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', filtrarTabla);
    }
    
    if (filterGrupo) {
        filterGrupo.addEventListener('change', filtrarTabla);
    }
    
    // Click en la gráfica para filtrar
    if (chart) {
        chart.canvas.onclick = (evt) => {
            const activePoints = chart.getElementsAtEvent(evt);
            if (activePoints.length > 0) {
                const index = activePoints[0].index;
                const grupoSeleccionado = data.labels[index];
                
                if (filterGrupo) {
                    filterGrupo.value = grupoSeleccionado;
                    filtrarTabla();
                    
                    // Mostrar toast
                    mostrarToast(`Filtrado por grupo: ${grupoSeleccionado}`);
                }
            }
        };
    }
    
    // Función para mostrar toast
    function mostrarToast(mensaje) {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.innerText = mensaje;
            toast.style.opacity = 1;
            toast.style.transform = 'translateY(0)';
            
            setTimeout(() => {
                toast.style.opacity = 0;
                toast.style.transform = 'translateY(20px)';
            }, 2000);
        }
    }
});
</script>

<!-- Toast notification -->
<div id="toast" style="position: fixed; bottom: 20px; right: 20px; background: #1e293b; color: #fff; padding: 12px 20px; border-radius: 12px; opacity: 0; transition: all 0.3s; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
    <i class="bi bi-info-circle me-2"></i> Acción realizada
</div>

@endsection