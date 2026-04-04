@extends('layouts.tutor')

@section('title', 'Mis Tutorías')

@section('content')
<div class="container-fluid px-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-calendar-check me-2 text-primary"></i>Mis Tutorías
            </h2>
            <p class="text-muted">Gestiona las tutorías realizadas y programadas con tus alumnos</p>
        </div>
        <a href="{{ route('tutor.dashboard') }}" class="btn btn-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Volver al dashboard
        </a>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm hover-shadow transition" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Total tutorías</div>
                            <h2 class="fw-bold display-6 mb-0">{{ $totalTutorias }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-calendar-check-fill text-primary fs-4"></i>
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

        <div class="col-md-3">
            <div class="card border-0 shadow-sm hover-shadow transition" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Pendientes</div>
                            <h2 class="fw-bold display-6 mb-0">{{ $tutoriasPendientes }}</h2>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-clock-history text-warning fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-hourglass-split me-1"></i> Por realizar
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
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Completadas</div>
                            <h2 class="fw-bold display-6 mb-0">{{ $tutoriasCompletadas }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-check-circle-fill text-success fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-trophy me-1"></i> Finalizadas
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
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Canceladas</div>
                            <h2 class="fw-bold display-6 mb-0">{{ $tutoriasCanceladas ?? 0 }}</h2>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-x-circle-fill text-danger fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-calendar-x me-1"></i> Canceladas
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de tutorías -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-table me-2 text-primary"></i>Lista de tutorías
                </h5>
                <div class="d-flex gap-2">
                    <div class="input-group" style="width: 250px;">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0 rounded-end-pill" placeholder="Buscar alumno o tema...">
                    </div>
                    <select id="filterEstado" class="form-select rounded-pill" style="width: 130px;">
                        <option value="">Todos</option>
                        <option value="pendiente">Pendientes</option>
                        <option value="completada">Completadas</option>
                        <option value="cancelada">Canceladas</option>
                    </select>
                    <select id="filterGrupo" class="form-select rounded-pill" style="width: 150px;">
                        <option value="">Todos los grupos</option>
                        @foreach($grupos as $grupo)
                            <option value="{{ $grupo->nombre }}">{{ $grupo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($tutorias->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="tutoriasTable" style="min-width: 1000px;">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th class="px-4 py-3 border-0" style="min-width: 100px;"><i class="bi bi-calendar3 me-1"></i> Fecha</th>
                                <th class="py-3 border-0" style="min-width: 180px;"><i class="bi bi-person me-1"></i> Alumno</th>
                                <th class="py-3 border-0" style="min-width: 120px;"><i class="bi bi-qr-code me-1"></i> Matrícula</th>
                                <th class="py-3 border-0" style="min-width: 150px;"><i class="bi bi-people me-1"></i> Grupo</th>
                                <th class="py-3 border-0" style="min-width: 180px;"><i class="bi bi-book me-1"></i> Tema</th>
                                <th class="py-3 border-0 text-center" style="min-width: 120px;"><i class="bi bi-hourglass-split me-1"></i> Duración</th>
                                <th class="py-3 border-0 text-center" style="min-width: 100px;"><i class="bi bi-info-circle me-1"></i> Estado</th>
                                <th class="px-4 py-3 border-0 text-center" style="min-width: 120px;">Acciones</th>
                              </tr>
                        </thead>
                        <tbody>
                            @foreach($tutorias as $tutoria)
                            <tr class="border-bottom" 
                                data-nombre="{{ strtolower($tutoria->alumno->user->name ?? '') }}"
                                data-tema="{{ strtolower($tutoria->tema ?? '') }}"
                                data-estado="{{ $tutoria->estado }}"
                                data-grupo="{{ $tutoria->alumno->grupo->nombre ?? '' }}">
                                <td class="px-4 py-3">
                                    <div class="fw-semibold">{{ \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($tutoria->fecha)->format('h:i A') }}</small>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                                            <i class="bi bi-person-circle text-primary"></i>
                                        </div>
                                        <div class="fw-semibold text-nowrap">{{ $tutoria->alumno->user->name ?? 'Sin nombre' }}</div>
                                    </div>
                                </td>
                                <td class="py-3"><code class="text-nowrap">{{ $tutoria->alumno->matricula ?? 'N/A' }}</code></td>
                                <td class="py-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 text-nowrap">
                                        <i class="bi bi-people-fill me-1"></i>{{ $tutoria->alumno->grupo->nombre ?? 'Sin grupo' }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div class="fw-semibold">{{ $tutoria->tema ?? 'Sin tema' }}</div>
                                    @if($tutoria->descripcion)
                                        <small class="text-muted d-block">{{ \Illuminate\Support\Str::limit($tutoria->descripcion, 50) }}</small>
                                    @endif
                                </td>
                                <td class="py-3 text-center">
                                    <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                        <i class="bi bi-clock me-1"></i> {{ $tutoria->duracion_minutos ?? 60 }} min
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    @if($tutoria->estado == 'completada')
                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            <i class="bi bi-check-circle-fill me-1"></i> Completada
                                        </span>
                                    @elseif($tutoria->estado == 'pendiente')
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                            <i class="bi bi-hourglass-split me-1"></i> Pendiente
                                        </span>
                                    @elseif($tutoria->estado == 'cancelada')
                                        <span class="badge bg-danger rounded-pill px-3 py-2">
                                            <i class="bi bi-x-circle-fill me-1"></i> Cancelada
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">
                                            {{ ucfirst($tutoria->estado) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('tutor.tutoria.detalle', $tutoria->id) }}" 
                                           class="btn btn-sm btn-outline-info rounded-pill px-3"
                                           data-bs-toggle="tooltip" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($tutoria->estado == 'pendiente')
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-success rounded-pill px-3 btn-completar"
                                                    data-id="{{ $tutoria->id }}"
                                                    data-alumno="{{ $tutoria->alumno->user->name ?? '' }}"
                                                    data-bs-toggle="tooltip" 
                                                    title="Marcar como completada">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        @endif
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
                        {{ $tutorias->firstItem() ?? 0 }}–{{ $tutorias->lastItem() ?? 0 }} de {{ $tutorias->total() }}
                    </div>
                    <div>
                        {{ $tutorias->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @else
                <div class="empty-state m-4">
                    <i class="bi bi-inbox display-1 text-muted mb-3 d-block"></i>
                    <h5 class="text-muted">No hay tutorías registradas</h5>
                    <p class="text-muted mb-3">Aún no has registrado ninguna tutoría con tus alumnos.</p>
                    <a href="{{ route('tutor.dashboard') }}" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-2"></i>Volver al dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para completar tutoría -->
<div class="modal fade" id="modalCompletarTutoria" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-success text-white border-0" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-check-circle-fill me-2"></i>Completar tutoría
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formCompletarTutoria" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alumno</label>
                        <input type="text" id="alumnoNombre" class="form-control rounded-pill" readonly disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Comentarios</label>
                        <textarea name="comentarios" class="form-control rounded-3" rows="3" placeholder="Agrega observaciones sobre la tutoría..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Calificación (1-5)</label>
                        <select name="calificacion" class="form-select rounded-pill">
                            <option value="">Sin calificar</option>
                            <option value="1">⭐ 1 - Muy deficiente</option>
                            <option value="2">⭐⭐ 2 - Deficiente</option>
                            <option value="3">⭐⭐⭐ 3 - Aceptable</option>
                            <option value="4">⭐⭐⭐⭐ 4 - Bueno</option>
                            <option value="5">⭐⭐⭐⭐⭐ 5 - Excelente</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="bi bi-check-lg me-2"></i>Confirmar
                    </button>
                </div>
            </form>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Filtros
    const searchInput = document.getElementById('searchInput');
    const filterEstado = document.getElementById('filterEstado');
    const filterGrupo = document.getElementById('filterGrupo');
    const table = document.getElementById('tutoriasTable');
    
    function filterTable() {
        if (!table) return;
        
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const estadoFilter = filterEstado ? filterEstado.value : '';
        const grupoFilter = filterGrupo ? filterGrupo.value : '';
        
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
        
        const rows = tbody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const nombre = row.getAttribute('data-nombre') || '';
            const tema = row.getAttribute('data-tema') || '';
            const estado = row.getAttribute('data-estado') || '';
            const grupo = row.getAttribute('data-grupo') || '';
            
            const matchesSearch = searchTerm === '' || nombre.includes(searchTerm) || tema.includes(searchTerm);
            const matchesEstado = estadoFilter === '' || estado === estadoFilter;
            const matchesGrupo = grupoFilter === '' || grupo === grupoFilter;
            
            row.style.display = matchesSearch && matchesEstado && matchesGrupo ? '' : 'none';
        });
    }
    
    if (searchInput) searchInput.addEventListener('keyup', filterTable);
    if (filterEstado) filterEstado.addEventListener('change', filterTable);
    if (filterGrupo) filterGrupo.addEventListener('change', filterTable);
    
    // Modal para completar tutoría
    const modal = new bootstrap.Modal(document.getElementById('modalCompletarTutoria'));
    const formCompletar = document.getElementById('formCompletarTutoria');
    const alumnoNombreInput = document.getElementById('alumnoNombre');
    
    document.querySelectorAll('.btn-completar').forEach(button => {
        button.addEventListener('click', function() {
            const tutoriaId = this.getAttribute('data-id');
            const alumnoNombre = this.getAttribute('data-alumno');
            
            alumnoNombreInput.value = alumnoNombre;
            formCompletar.action = `/tutor/tutoria/${tutoriaId}/completar`;
            modal.show();
        });
    });
    
    // SweetAlert para mensajes de éxito
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