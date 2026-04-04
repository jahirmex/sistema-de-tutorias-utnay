@extends('layouts.tutor')

@section('title', 'Mis Alumnos')

@section('content')
<div class="container-fluid px-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-people me-2 text-primary"></i>Mis Alumnos
            </h2>
            <p class="text-muted">Lista de alumnos asignados a tus grupos</p>
        </div>
        <a href="{{ route('tutor.dashboard') }}" class="btn btn-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Volver al dashboard
        </a>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
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
                            <i class="bi bi-mortarboard me-1"></i> Alumnos a tu cargo
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
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
                            <i class="bi bi-grid me-1"></i> Grupos a tu cargo
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm hover-shadow transition" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Tutorías realizadas</div>
                            <h2 class="fw-bold display-6 mb-0">{{ $totalTutorias }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-calendar-check-fill text-info fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-bar-chart me-1"></i> Sesiones registradas
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfica de alumnos por grupo -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-bar-chart me-2 text-primary"></i>Alumnos por grupo
            </h5>
        </div>
        <div class="card-body p-4">
            <canvas id="graficaAlumnosPorGrupo" height="100"></canvas>
        </div>
    </div>

    <!-- Tabla de alumnos -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-table me-2 text-primary"></i>Lista de alumnos
                </h5>
                <div class="d-flex gap-2">
                    <div class="input-group" style="width: 250px;">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0 rounded-end-pill" placeholder="Buscar por nombre o matrícula...">
                    </div>
                    <select id="filterGrupo" class="form-select rounded-pill" style="width: 150px;">
                        <option value="">Todos los grupos</option>
                        @foreach($tutor->grupos as $grupo)
                            <option value="{{ $grupo->nombre }}">{{ $grupo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($paginatedAlumnos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="alumnosTable" style="min-width: 800px;">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th class="px-4 py-3 border-0" style="min-width: 200px;"><i class="bi bi-person me-1"></i> Alumno</th>
                                <th class="py-3 border-0" style="min-width: 120px;"><i class="bi bi-qr-code me-1"></i> Matrícula</th>
                                <th class="py-3 border-0" style="min-width: 180px;"><i class="bi bi-book me-1"></i> Carrera</th>
                                <th class="py-3 border-0 text-center" style="min-width: 150px;"><i class="bi bi-calendar me-1"></i> Cuatrimestre</th>
                                <th class="py-3 border-0 text-center" style="min-width: 120px;"><i class="bi bi-people me-1"></i> Grupo</th>
                                <th class="py-3 border-0" style="min-width: 180px;"><i class="bi bi-envelope me-1"></i> Correo</th>
                                <th class="px-4 py-3 border-0 text-center" style="min-width: 100px;">Acciones</th>
                              </tr>
                        </thead>
                        <tbody>
                            @foreach($paginatedAlumnos as $alumno)
                            <tr class="border-bottom" 
                                data-nombre="{{ strtolower($alumno->user->name ?? '') }}"
                                data-matricula="{{ $alumno->matricula ?? '' }}"
                                data-grupo="{{ $alumno->nombre_grupo ?? '' }}">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                                            <i class="bi bi-person-circle text-primary"></i>
                                        </div>
                                        <div class="fw-semibold text-nowrap">{{ $alumno->user->name ?? 'Sin nombre' }}</div>
                                    </div>
                                  </td>
                                <td class="py-3"><code class="text-nowrap">{{ $alumno->matricula ?? 'N/A' }}</code></td>
                                <td class="py-3">{{ $alumno->carrera ?? 'N/A' }}</td>
                                <td class="py-3 text-center">
                                    <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                        {{ $alumno->cuatrimestre ?? 'N/A' }}°
                                    </span>
                                  </td>
                                <td class="py-3 text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 text-nowrap">
                                        <i class="bi bi-people-fill me-1"></i>{{ $alumno->nombre_grupo ?? 'Sin grupo' }}
                                    </span>
                                  </td>
                                <td class="py-3">
                                    <a href="mailto:{{ $alumno->user->email }}" class="text-decoration-none text-dark hover-primary">
                                        <i class="bi bi-envelope me-1 text-muted"></i>
                                        <span class="text-nowrap">{{ $alumno->user->email ?? 'Sin correo' }}</span>
                                    </a>
                                  </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('tutor.alumnos.show', $alumno->id) }}" 
                                           class="btn btn-sm btn-outline-info rounded-pill px-3"
                                           data-bs-toggle="tooltip" 
                                           title="Ver detalle del alumno">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('tutor.tutorias.create', $alumno->id) }}" 
                                           class="btn btn-sm btn-outline-success rounded-pill px-3"
                                           data-bs-toggle="tooltip" 
                                           title="Registrar tutoría">
                                            <i class="bi bi-calendar-plus"></i>
                                        </a>
                                    </div>
                                  </td>
                              </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                <div class="d-flex justify-content-between align-items-center p-4 border-top">
                    <div class="text-muted small">
                        {{ $paginatedAlumnos->firstItem() ?? 0 }}–{{ $paginatedAlumnos->lastItem() ?? 0 }} de {{ $paginatedAlumnos->total() }}
                    </div>
                    <div>
                        {{ $paginatedAlumnos->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="empty-state m-4">
                    <i class="bi bi-inbox display-1 text-muted mb-3 d-block"></i>
                    <h5 class="text-muted">No hay alumnos asignados</h5>
                    <p class="text-muted mb-3">Aún no tienes alumnos asignados a tus grupos.</p>
                    <a href="{{ route('tutor.dashboard') }}" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-2"></i>Volver al dashboard
                    </a>
                </div>
            @endif
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
    
    .dark-mode .badge.bg-light {
        background-color: #334155 !important;
        color: #e2e8f0 !important;
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
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Gráfica de alumnos por grupo
    const ctx = document.getElementById('graficaAlumnosPorGrupo').getContext('2d');
    
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
    
    new Chart(ctx, {
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
    
    // Filtros de búsqueda
    const searchInput = document.getElementById('searchInput');
    const filterGrupo = document.getElementById('filterGrupo');
    const table = document.getElementById('alumnosTable');
    
    function filterTable() {
        if (!table) return;
        
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const grupoFilter = filterGrupo ? filterGrupo.value : '';
        
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
        
        const rows = tbody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const nombre = row.getAttribute('data-nombre') || '';
            const matricula = row.getAttribute('data-matricula') || '';
            const grupo = row.getAttribute('data-grupo') || '';
            
            const matchesSearch = searchTerm === '' || nombre.includes(searchTerm) || matricula.includes(searchTerm);
            const matchesGroup = grupoFilter === '' || grupo === grupoFilter;
            
            row.style.display = matchesSearch && matchesGroup ? '' : 'none';
        });
    }
    
    if (searchInput) searchInput.addEventListener('keyup', filterTable);
    if (filterGrupo) filterGrupo.addEventListener('change', filterTable);
    
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('success') }}',
            confirmButtonColor: '#1f7a5c',
            timer: 3000
        });
    @endif
});
</script>

@endsection