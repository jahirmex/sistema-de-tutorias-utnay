@extends('layouts.coordinador')

@section('content')
<div class="container-fluid px-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-mortarboard me-2 text-primary"></i>Gestión de alumnos
            </h2>
            <p class="text-muted">Administra los alumnos, sus grupos y estadísticas académicas</p>
        </div>
        <button onclick="toggleDarkMode()" id="darkModeBtn" class="btn btn-light rounded-pill px-3">
            <i class="bi bi-moon-stars"></i> Modo oscuro
        </button>
    </div>

    <!-- Gráfica de alumnos por grupo -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-bar-chart me-2 text-primary"></i>Alumnos por grupo
            </h5>
        </div>
        <div class="card-body p-4">
            <canvas id="graficaGrupos" height="100"></canvas>
        </div>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
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
                            <i class="bi bi-mortarboard me-1"></i> Alumnos registrados
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm hover-shadow transition" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Total grupos</div>
                            <h2 class="fw-bold display-6 mb-0">{{ $totalGrupos }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-diagram-3 text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-grid me-1"></i> Grupos académicos
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm hover-shadow transition" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Promedio general</div>
                            <h2 class="fw-bold display-6 mb-0">{{ number_format($promedioGeneral, 2) }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-star-fill text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-graph-up me-1"></i> Calificación promedio
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm hover-shadow transition" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Grupos activos</div>
                            <h2 class="fw-bold display-6 mb-0">{{ count($alumnosPorGrupo) }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-check-circle-fill text-info fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-calendar-check me-1"></i> Con alumnos asignados
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- FORMULARIO DE AGREGAR ALUMNO -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-person-plus me-2 text-primary"></i>Agregar Alumno
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('alumnos.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Nombre completo</label>
                            <input type="text" name="nombre" class="form-control rounded-pill px-3" placeholder="Ej. Juan Pérez López" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Correo electrónico</label>
                            <input type="email" name="correo" class="form-control rounded-pill px-3" placeholder="ejemplo@utnay.edu.mx" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Matrícula</label>
                            <input type="text" name="matricula" class="form-control rounded-pill px-3" placeholder="A12345678">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Carrera</label>
                            <input type="text" name="carrera" class="form-control rounded-pill px-3" placeholder="IDGS">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Cuatrimestre</label>
                            <input type="number" name="cuatrimestre" class="form-control rounded-pill px-3" placeholder="1-11" min="1" max="12">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted">Grupo</label>
                            <select name="grupo_id" class="form-select rounded-pill px-3" required>
                                <option value="">Selecciona un grupo</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn w-100 rounded-pill py-2 text-white" style="background: linear-gradient(135deg, #1f7a5c 0%, #0f5e46 100%);">
                            <i class="bi bi-save me-2"></i>Guardar alumno
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- TABLA DE ALUMNOS -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-table me-2 text-primary"></i>Lista de Alumnos
                        </h5>
                        <div class="d-flex gap-2">
                            <div class="input-group" style="width: 250px;">
                                <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" id="buscador" class="form-control border-start-0 rounded-end-pill" placeholder="Buscar por nombre, matrícula...">
                            </div>
                            <select id="filterGroupTable" class="form-select rounded-pill" style="width: 150px;">
                                <option value="">Todos los grupos</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->nombre }}">{{ $grupo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0" id="alumnosTable" style="min-width: 1200px;">
                            <thead class="bg-light sticky-top">
                                <tr class="border-0">
                                    <th class="px-4 py-3 border-0" style="min-width: 200px;"><i class="bi bi-person me-1"></i> Nombre</th>
                                    <th class="py-3 border-0" style="min-width: 120px;"><i class="bi bi-qr-code me-1"></i> Matrícula</th>
                                    <th class="py-3 border-0" style="min-width: 100px;"><i class="bi bi-book me-1"></i> Carrera</th>
                                    <th class="py-3 border-0 text-center" style="min-width: 150px;"><i class="bi bi-calendar me-1"></i> Cuatrimestre</th>
                                    <th class="py-3 border-0 text-center" style="min-width: 110px;"><i class="bi bi-people me-1"></i> Grupo</th>
                                    <th class="py-3 border-0" style="min-width: 200px;"><i class="bi bi-envelope me-1"></i> Correo</th>
                                    <th class="py-3 border-0" style="min-width: 150px;"><i class="bi bi-person-badge me-1"></i> Tutor</th>
                                    <th class="px-4 py-3 border-0 text-center" style="min-width: 100px;">Acciones</th>
                                  </tr>
                            </thead>
                            <tbody>
                                @foreach($alumnos as $alumno)
                                <tr class="border-bottom" 
                                    data-nombre="{{ strtolower($alumno->user->name ?? '') }}"
                                    data-matricula="{{ $alumno->matricula ?? '' }}"
                                    data-grupo="{{ $alumno->grupo->nombre ?? '' }}">
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-circle bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                                                <i class="bi bi-person-circle text-primary"></i>
                                            </div>
                                            <div class="fw-semibold text-nowrap">{{ $alumno->user->name ?? 'Sin usuario' }}</div>
                                        </div>
                                      </td>
                                    <td class="py-3"><code class="text-nowrap">{{ $alumno->matricula }}</code></td>
                                    <td class="py-3">{{ $alumno->carrera }}</td>
                                    <td class="py-3 text-center">
                                        <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                            {{ $alumno->cuatrimestre }}°
                                        </span>
                                      </td>
                                    <td class="py-3 text-center">
                                        @if($alumno->grupo)
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 text-nowrap">
                                                <i class="bi bi-people-fill me-1"></i>{{ $alumno->grupo->nombre }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">
                                                Sin grupo
                                            </span>
                                        @endif
                                      </td>
                                    <td class="py-3">
                                        <a href="mailto:{{ $alumno->user->email }}" class="text-decoration-none text-dark hover-primary">
                                            <i class="bi bi-envelope me-1 text-muted"></i>
                                            <span class="text-nowrap">{{ $alumno->user->email ?? 'Sin correo' }}</span>
                                        </a>
                                      </td>
                                    <td class="py-3">
                                        @if($alumno->grupo && $alumno->grupo->tutor)
                                            <span class="small text-nowrap">{{ $alumno->grupo->tutor->user->name ?? 'Sin tutor' }}</span>
                                        @else
                                            <span class="text-muted small">Sin asignar</span>
                                        @endif
                                      </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('alumnos.edit', $alumno->id) }}" 
                                               class="btn btn-sm btn-outline-warning rounded-pill px-3"
                                               data-bs-toggle="tooltip" 
                                               title="Editar alumno">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('alumnos.destroy', $alumno->id) }}" method="POST" style="display:inline;" class="form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger rounded-pill px-3 btn-delete"
                                                        data-alumno="{{ $alumno->user->name ?? 'este alumno' }}"
                                                        data-bs-toggle="tooltip" 
                                                        title="Eliminar alumno">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                      </td>
                                  </tr>
                                @endforeach
                            </tbody>
                          </table>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-4 border-top">
                        <div class="text-muted small">
                            {{ $alumnos->firstItem() ?? 0 }}–{{ $alumnos->lastItem() ?? 0 }} de {{ $alumnos->total() }}
                        </div>
                        <div>
                            {{ $alumnos->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-white border-0 pb-4 px-4">
                    <a href="{{ route('alumnos.exportar') }}" class="btn w-100 rounded-pill py-2 text-white" style="background: linear-gradient(135deg, #1f7a5c 0%, #0f5e46 100%);">
                        <i class="bi bi-file-earmark-excel me-2"></i>Exportar a Excel
                    </a>
                </div>
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
    
    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    /* Evitar que el texto se rompa */
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
    
    // Gráfica de grupos
    const ctx = document.getElementById('graficaGrupos').getContext('2d');
    
    const data = {
        labels: [
            @foreach($grupos as $grupo)
                "{{ $grupo->nombre }}",
            @endforeach
        ],
        datasets: [{
            label: 'Alumnos',
            data: [
                @foreach($grupos as $grupo)
                    {{ $alumnosPorGrupo[$grupo->id] ?? 0 }},
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
    
    // Filtro de búsqueda y grupo
    const buscador = document.getElementById('buscador');
    const filterGroupTable = document.getElementById('filterGroupTable');
    const table = document.getElementById('alumnosTable');
    
    function filterTable() {
        if (!table) return;
        
        const searchTerm = buscador ? buscador.value.toLowerCase().trim() : '';
        const groupFilter = filterGroupTable ? filterGroupTable.value : '';
        
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
        
        const rows = tbody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const nombre = row.getAttribute('data-nombre') || '';
            const matricula = row.getAttribute('data-matricula') || '';
            const grupo = row.getAttribute('data-grupo') || '';
            
            const matchesSearch = searchTerm === '' || nombre.includes(searchTerm) || matricula.includes(searchTerm);
            const matchesGroup = groupFilter === '' || grupo === groupFilter;
            
            row.style.display = matchesSearch && matchesGroup ? '' : 'none';
        });
    }
    
    if (buscador) {
        buscador.addEventListener('keyup', filterTable);
    }
    
    if (filterGroupTable) {
        filterGroupTable.addEventListener('change', filterTable);
    }
    
    // Confirmación de eliminación
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.form-delete');
            const alumnoNombre = this.getAttribute('data-alumno');
            
            Swal.fire({
                title: '¿Eliminar alumno?',
                html: `Estás a punto de eliminar a <strong>${alumnoNombre}</strong>.<br>Esta acción no se puede deshacer.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: '<i class="bi bi-trash me-1"></i>Sí, eliminar',
                cancelButtonText: '<i class="bi bi-x-lg me-1"></i>Cancelar',
                customClass: {
                    popup: 'rounded-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
    
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
    
    // Click en la gráfica para filtrar
    if (chart) {
        chart.canvas.onclick = (evt) => {
            const activePoints = chart.getElementsAtEvent(evt);
            if (activePoints.length > 0) {
                const index = activePoints[0].index;
                const grupoSeleccionado = data.labels[index];
                
                if (filterGroupTable) {
                    filterGroupTable.value = grupoSeleccionado;
                    filterTable();
                    mostrarToast(`Filtrado por grupo: ${grupoSeleccionado}`);
                }
            }
        };
    }
});

// Dark mode toggle
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    const isDark = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDark);
    
    const btn = document.getElementById('darkModeBtn');
    if (btn) {
        btn.innerHTML = isDark ? '<i class="bi bi-sun"></i> Modo claro' : '<i class="bi bi-moon-stars"></i> Modo oscuro';
    }
}

// Verificar dark mode al cargar
if (localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark-mode');
    const btn = document.getElementById('darkModeBtn');
    if (btn) {
        btn.innerHTML = '<i class="bi bi-sun"></i> Modo claro';
    }
}
</script>

<!-- Toast notification -->
<div id="toast" style="position: fixed; bottom: 20px; right: 20px; background: #1e293b; color: #fff; padding: 12px 20px; border-radius: 12px; opacity: 0; transition: all 0.3s; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
    <i class="bi bi-info-circle me-2"></i> Acción realizada
</div>

@endsection