@extends('layouts.tutor')

@section('content')
<div class="container-fluid px-4 py-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-semibold mb-1 text-dark">
                <i class="bi bi-person-badge me-2 text-primary"></i>Panel del Tutor
            </h2>
            <p class="text-muted small mb-0">Gestión de alumnos, seguimiento académico y registro de tutorías</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-3 btn-sm">
                <i class="bi bi-printer me-1"></i> Imprimir
            </button>
        </div>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 stat-card" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold">Total alumnos</span>
                            <h2 class="fw-bold mb-0 mt-2">{{ $totalAlumnos }}</h2>
                            <small class="text-muted mt-2 d-block">
                                <i class="bi bi-people me-1"></i> Asignados a tu tutoría
                            </small>
                        </div>
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-people-fill text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 stat-card" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold">Grupos activos</span>
                            <h2 class="fw-bold mb-0 mt-2">{{ $totalGrupos }}</h2>
                            <small class="text-muted mt-2 d-block">
                                <i class="bi bi-collection me-1"></i> Grupos a tu cargo
                            </small>
                        </div>
                        <div class="stat-icon bg-success">
                            <i class="bi bi-diagram-3-fill text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 stat-card" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold">Tutorías realizadas</span>
                            <h2 class="fw-bold mb-0 mt-2">{{ $alumnos->flatMap->tutorias->count() }}</h2>
                            <small class="text-muted mt-2 d-block">
                                <i class="bi bi-chat-dots me-1"></i> Sesiones registradas
                            </small>
                        </div>
                        <div class="stat-icon bg-info">
                            <i class="bi bi-chat-dots-fill text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 stat-card" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold">Tasa de atención</span>
                            <h2 class="fw-bold mb-0 mt-2">
                                @php
                                    $totalAlumnosCount = max($totalAlumnos, 1);
                                    $tutoriasCount = $alumnos->flatMap->tutorias->count();
                                    $tasa = round(($tutoriasCount / $totalAlumnosCount) * 100, 0);
                                @endphp
                                {{ $tasa }}%
                            </h2>
                            <small class="text-muted mt-2 d-block">
                                <i class="bi bi-graph-up me-1"></i> Promedio por alumno
                            </small>
                        </div>
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-graph-up text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Actividad reciente -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom px-4 py-3" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-clock-history me-2 text-primary"></i>Actividad Reciente
                    </h5>
                </div>
                <div class="card-body p-4">
                    @php
                        $ultimasTutorias = $alumnos->flatMap->tutorias
                            ->filter(fn($t) => !is_null($t->alumno_id) && !is_null($t->alumno))
                            ->sortByDesc('fecha')
                            ->take(5);
                    @endphp

                    @if($ultimasTutorias->isNotEmpty())
                        <div class="timeline">
                            @foreach($ultimasTutorias as $tutoria)
                                <div class="timeline-item">
                                    <div class="timeline-icon">
                                        <i class="bi bi-journal-check"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <a href="{{ $tutoria->alumno ? route('tutor.alumnos.show', $tutoria->alumno->id) : '#' }}" 
                                           class="text-decoration-none">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="fw-semibold mb-1">{{ $tutoria->tema }}</h6>
                                                    <p class="text-muted small mb-1">
                                                        <i class="bi bi-person me-1"></i>
                                                        {{ optional($tutoria->alumno)->user->name ?? 'Alumno no disponible' }}
                                                    </p>
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar me-1"></i>
                                                        {{ \Carbon\Carbon::parse($tutoria->fecha)->translatedFormat('d M Y H:i') }}
                                                    </small>
                                                </div>
                                                <span class="badge bg-primary text-white rounded-pill">
                                                    {{ \Carbon\Carbon::parse($tutoria->fecha)->diffForHumans() }}
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">No hay actividad reciente</p>
                            <small class="text-muted">Registra tu primera tutoría</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Próximas tutorías / Recomendaciones -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom px-4 py-3" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-calendar-check me-2 text-primary"></i>Resumen Rápido
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-card">
                            <div class="info-icon bg-primary">
                                <i class="bi bi-trophy text-white"></i>
                            </div>
                                <div>
                                    <small class="text-muted d-block">Alumnos sin tutoría</small>
                                    <h5 class="fw-bold mb-0">
                                        @php
                                            $alumnosSinTutoria = $alumnos->filter(function($alumno) {
                                                return $alumno->tutorias->count() == 0;
                                            })->count();
                                        @endphp
                                        {{ $alumnosSinTutoria }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="info-icon bg-success">
                                    <i class="bi bi-star text-white"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Mayor seguimiento</small>
                                    <h5 class="fw-bold mb-0">
                                        @php
                                            $maxTutorias = $alumnos->flatMap->tutorias->groupBy('alumno_id')->max()->count() ?? 0;
                                        @endphp
                                        {{ $maxTutorias }} sesiones
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="alert alert-primary border-0 rounded-3" style="background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-info-circle-fill fs-4 text-primary"></i>
                                    <div>
                                        <strong class="text-primary">Consejo del día</strong>
                                        <p class="mb-0 small text-primary">Realiza al menos una tutoría por alumno cada mes para un seguimiento efectivo.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de alumnos -->
    <div class="card border-0 shadow-sm mt-4" style="border-radius: 16px;">
        <div class="card-header bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-radius: 16px 16px 0 0;">
            <h5 class="fw-semibold mb-0">
                <i class="bi bi-people me-2 text-primary"></i>Lista de Alumnos
            </h5>
            <div class="d-flex gap-2">
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0 rounded-end-pill" placeholder="Buscar alumno...">
                </div>
                <select id="grupoFilter" class="form-select rounded-pill" style="width: 150px;">
                    <option value="">Todos los grupos</option>
                    @foreach($alumnos->pluck('grupo.nombre')->unique() as $grupo)
                        <option value="{{ $grupo }}">{{ $grupo }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0" id="alumnosTable">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th class="px-4 py-3" style="min-width: 250px;">
                                <i class="bi bi-person me-1 text-primary"></i> Alumno
                            </th>
                            <th class="py-3" style="min-width: 150px;">
                                <i class="bi bi-qr-code me-1 text-primary"></i> Matrícula
                            </th>
                            <th class="py-3" style="min-width: 130px;">
                                <i class="bi bi-people me-1 text-primary"></i> Grupo
                            </th>
                            <th class="py-3 text-center" style="min-width: 120px;">
                                <i class="bi bi-chat-dots me-1 text-primary"></i> Tutorías
                            </th>
                            <th class="px-4 py-3 text-center" style="min-width: 130px;">
                                <i class="bi bi-three-dots me-1 text-primary"></i> Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alumnos as $alumno)
                            <tr class="alumno-row" 
                                data-nombre="{{ strtolower($alumno->user->name ?? '') }}" 
                                data-grupo="{{ $alumno->grupo->nombre ?? '' }}">
                                
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-modern">
                                            {{ strtoupper(substr($alumno->user->name ?? 'U', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $alumno->user->name ?? 'Sin usuario' }}</div>
                                            <div class="text-muted small">{{ $alumno->user->email ?? 'Sin correo' }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="py-3">
                                    <code class="badge-matricula">{{ $alumno->matricula }}</code>
                                </td>
                                
                                <td class="py-3">
                                    <span class="badge-grupo">
                                        <i class="bi bi-collection me-1"></i>
                                        {{ $alumno->grupo->nombre ?? 'Sin grupo' }}
                                    </span>
                                </td>
                                
                                <td class="py-3 text-center">
                                    <span class="badge-tutorias">
                                        <i class="bi bi-journal-bookmark-fill me-1"></i>
                                        {{ $alumno->tutorias->count() }}
                                    </span>
                                </td>
                                
                                <td class="px-4 py-3 text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('tutor.alumnos.show', $alumno->id) }}" 
                                           class="btn-action btn-view"
                                           data-bs-toggle="tooltip" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button class="btn-action btn-add"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalTutoria"
                                                data-alumno="{{ $alumno->id }}"
                                                data-alumno-nombre="{{ $alumno->user->name ?? '' }}"
                                                data-bs-toggle="tooltip" 
                                                title="Registrar tutoría">
                                            <i class="bi bi-journal-plus"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No hay alumnos asignados a tu tutoría
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top py-3 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex gap-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Total: {{ $alumnos->count() }} alumnos
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-chat-dots me-1"></i>
                        Total tutorías: {{ $alumnos->flatMap->tutorias->count() }}
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

<!-- Modal Tutoría - Rediseñado -->
<div class="modal fade" id="modalTutoria" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow-lg">
            <form method="POST" action="{{ route('tutor.tutorias.store') }}">
                @csrf
                <div class="modal-header border-0 pt-4 px-4" style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-journal-plus me-2"></i>Registrar Tutoría
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body p-4">
                    <input type="hidden" name="alumno_id" id="alumno_id">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="bi bi-person me-1 text-primary"></i>Alumno
                        </label>
                        <div class="alert alert-light rounded-3 mb-0" id="alumnoNombreDisplay">
                            Selecciona un alumno
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="bi bi-book me-1 text-primary"></i>Tema
                        </label>
                        <input type="text" name="tema" class="form-control modern-input" placeholder="Ej. Repaso de matemáticas" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="bi bi-file-text me-1 text-primary"></i>Descripción
                        </label>
                        <textarea name="descripcion" class="form-control modern-input" rows="3" placeholder="Describe los temas tratados y acuerdos..." required></textarea>
                    </div>
                </div>
                
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-save me-1"></i>Guardar Tutoría
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Estadísticas */
.stat-card {
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.bg-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
}

.bg-success {
    background: linear-gradient(135deg, #198754 0%, #157347 100%);
}

.bg-info {
    background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%);
}

.bg-warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
}

/* Timeline */
.timeline {
    position: relative;
}

.timeline-item {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.timeline-icon {
    width: 35px;
    height: 35px;
    border-radius: 12px;
    background: #e7f1ff;
    color: #0d6efd;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.timeline-content {
    flex: 1;
    padding-bottom: 15px;
    border-bottom: 1px solid #e9ecef;
}

.timeline-item:last-child .timeline-content {
    border-bottom: none;
}

/* Info cards */
.info-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.2s ease;
}

.info-card:hover {
    background: #e9ecef;
}

.info-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

/* Avatar */
.avatar-modern {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    text-transform: uppercase;
}

/* Badges */
.badge-matricula {
    background: #f1f5f9;
    color: #475569;
    padding: 5px 10px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-family: monospace;
}

.badge-grupo {
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    color: #3730a3;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-tutorias {
    background: #fef3c7;
    color: #92400e;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

/* Botones de acción */
.btn-action {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    text-decoration: none;
    border: none;
    background: transparent;
}

.btn-view {
    color: #0d6efd;
    background: #e7f1ff;
}

.btn-view:hover {
    background: #0d6efd;
    color: white;
    transform: scale(1.05);
}

.btn-add {
    color: #198754;
    background: #d1fae5;
}

.btn-add:hover {
    background: #198754;
    color: white;
    transform: scale(1.05);
}

/* Input moderno */
.modern-input {
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    padding: 10px 14px;
    transition: all 0.2s ease;
}

.modern-input:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
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

.sticky-top {
    position: sticky;
    top: 0;
    z-index: 10;
}

/* Scrollbar */
.table-responsive::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
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

.dark-mode .form-control,
.dark-mode .form-select,
.dark-mode .input-group-text {
    background-color: #334155;
    border-color: #475569;
    color: #e2e8f0;
}

.dark-mode .badge-matricula {
    background: #334155;
    color: #cbd5e1;
}

.dark-mode .info-card {
    background: #334155;
}

.dark-mode .info-card:hover {
    background: #475569;
}

.dark-mode .timeline-icon {
    background: #1e40af;
    color: #60a5fa;
}

.dark-mode .timeline-content {
    border-bottom-color: #334155;
}

.dark-mode .alert-light {
    background-color: #334155;
    color: #e2e8f0;
}

.dark-mode .modal-content {
    background-color: #1e293b;
}

.dark-mode .modal-header {
    background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%) !important;
}

.dark-mode .btn-light {
    background-color: #475569;
    border-color: #475569;
    color: #e2e8f0;
}

/* Responsive */
@media (max-width: 768px) {
    .table {
        font-size: 0.75rem;
    }
    
    .avatar-modern {
        width: 36px;
        height: 36px;
        font-size: 11px;
    }
    
    .badge-grupo,
    .badge-tutorias {
        font-size: 0.65rem;
        padding: 3px 8px;
    }
    
    .btn-action {
        width: 28px;
        height: 28px;
        font-size: 0.75rem;
    }
}
</style>

<script>
// Filtros
document.getElementById('searchInput')?.addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    document.querySelectorAll('.alumno-row').forEach(row => {
        let nombre = row.dataset.nombre;
        row.style.display = nombre?.includes(value) ? '' : 'none';
    });
});

document.getElementById('grupoFilter')?.addEventListener('change', function() {
    let grupo = this.value;
    document.querySelectorAll('.alumno-row').forEach(row => {
        let rowGrupo = row.dataset.grupo;
        row.style.display = (grupo === '' || rowGrupo === grupo) ? '' : 'none';
    });
});

// Modal Tutoría
document.getElementById('modalTutoria')?.addEventListener('show.bs.modal', function(event) {
    let button = event.relatedTarget;
    let alumnoId = button.getAttribute('data-alumno');
    let alumnoNombre = button.getAttribute('data-alumno-nombre');
    
    document.getElementById('alumno_id').value = alumnoId;
    document.getElementById('alumnoNombreDisplay').innerHTML = `
        <div class="d-flex align-items-center gap-2">
            <div class="avatar-modern" style="width: 32px; height: 32px; font-size: 11px;">
                ${alumnoNombre ? alumnoNombre.substring(0, 2).toUpperCase() : 'AL'}
            </div>
            <div>
                <strong>${alumnoNombre || 'Alumno seleccionado'}</strong>
            </div>
        </div>
    `;
});

// Dark mode
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    const isDark = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDark);
    
    const btn = document.getElementById('darkModeBtn');
    if (btn) {
        btn.innerHTML = isDark ? '<i class="bi bi-sun me-1"></i> Modo claro' : '<i class="bi bi-moon-stars me-1"></i> Modo oscuro';
    }
}

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