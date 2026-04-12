@extends('layouts.coordinador')

@section('content')
<div class="container-fluid px-4 py-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-semibold mb-1 text-dark">
                <i class="bi bi-chat-dots-fill me-2 text-primary"></i>Tutorías
            </h2>
            <p class="text-muted small mb-0">Gestión y seguimiento de tutorías académicas</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-3 btn-sm">
                <i class="bi bi-printer me-1"></i> Imprimir
            </button>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold">Total tutorías</span>
                            <h3 class="fw-bold mb-0 mt-1">{{ $tutorias->count() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded p-2">
                            <i class="bi bi-calendar-check text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold">Completadas</span>
                            <h3 class="fw-bold mb-0 mt-1 text-success">{{ $tutorias->where('estado', 'completada')->count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded p-2">
                            <i class="bi bi-check-circle-fill text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold">Pendientes</span>
                            <h3 class="fw-bold mb-0 mt-1 text-warning">{{ $tutorias->where('estado', 'pendiente')->count() }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded p-2">
                            <i class="bi bi-clock-history text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold">Alumnos atendidos</span>
                            <h3 class="fw-bold mb-0 mt-1">{{ $tutorias->pluck('alumno_id')->unique()->count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded p-2">
                            <i class="bi bi-people-fill text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de tutorías -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-radius: 12px 12px 0 0;">
            <h5 class="fw-semibold mb-0">
                <i class="bi bi-table me-2 text-primary"></i>Listado de Tutorías
            </h5>
            <div class="d-flex gap-2">
                <div class="input-group" style="width: 250px;">
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                        <i class="bi bi-search text-muted small"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control form-control-sm border-start-0 rounded-end-pill" placeholder="Buscar alumno o tutor...">
                </div>
                <select id="filterEstado" class="form-select form-select-sm rounded-pill" style="width: 130px;">
                    <option value="">Todos</option>
                    <option value="completada">Completadas</option>
                    <option value="pendiente">Pendientes</option>
                </select>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 550px; overflow-y: auto;">
                <table class="table table-hover align-middle mb-0" id="tutoriasTable" style="font-size: 0.85rem;">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th class="px-4 py-3" style="min-width: 200px;">
                                <i class="bi bi-person me-1 text-primary"></i> Alumno
                            </th>
                            <th class="py-3" style="min-width: 140px;">
                                <i class="bi bi-collection me-1 text-primary"></i> Grupo
                            </th>
                            <th class="py-3" style="min-width: 180px;">
                                <i class="bi bi-person-badge me-1 text-primary"></i> Tutor
                            </th>
                            <th class="py-3 text-center" style="min-width: 120px;">
                                <i class="bi bi-check-circle me-1 text-primary"></i> Estado
                            </th>
                            <th class="py-3" style="min-width: 160px;">
                                <i class="bi bi-calendar me-1 text-primary"></i> Fecha
                            </th>
                            <th class="px-4 py-3 text-center" style="min-width: 100px;">
                                <i class="bi bi-eye me-1 text-primary"></i> Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tutorias as $t)
                        <tr class="tutoria-row" 
                            data-search="{{ strtolower(($t->alumno->user->name ?? '') . ' ' . ($t->tutor->user->name ?? '') . ' ' . ($t->alumno->grupo->nombre ?? '')) }}"
                            data-estado="{{ $t->estado }}">
                            <!-- Alumno -->
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-modern">
                                        {{ strtoupper(substr($t->alumno->user->name ?? 'NA', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $t->alumno->user->name ?? 'N/A' }}</div>
                                        <small class="text-muted">Matrícula: {{ $t->alumno->matricula ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <!-- Grupo -->
                            <td class="py-3">
                                @if($t->alumno && $t->alumno->grupo)
                                    <div class="d-flex flex-column">
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary-subtle fw-semibold" style="width: fit-content;">
                                            {{ $t->alumno->grupo->nombre }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-muted">Sin grupo</span>
                                @endif
                            </td>
                            
                            <!-- Tutor -->
                            <td class="py-3">
                                @if($t->tutor)
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-tutor">
                                            {{ strtoupper(substr($t->tutor->user->name ?? 'T', 0, 1)) }}
                                        </div>
                                        <span>{{ $t->tutor->user->name ?? 'Sin asignar' }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">Sin asignar</span>
                                @endif
                            </td>
                            
                            <!-- Estado -->
                            <td class="py-3 text-center">
                                @if($t->estado == 'completada')
                                    <span class="badge-estado completada">
                                        <i class="bi bi-check-circle-fill me-1"></i> Completada
                                    </span>
                                @elseif($t->estado == 'pendiente')
                                    <span class="badge-estado pendiente">
                                        <i class="bi bi-clock-fill me-1"></i> Pendiente
                                    </span>
                                @else
                                    <span class="badge-estado otro">{{ ucfirst($t->estado) }}</span>
                                @endif
                            </td>
                            
                            <!-- Fecha -->
                            <td class="py-3">
                                <div class="d-flex flex-column">
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($t->created_at)->format('d M Y') }}</span>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($t->created_at)->format('H:i') }} hrs</small>
                                </div>
                            </td>
                            
                            <!-- Acciones -->
                            <td class="px-4 py-3 text-center">
                                <button class="btn-ver" 
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalTutoria"
                                    data-id="{{ $t->id }}"
                                    data-alumno="{{ $t->alumno->user->name ?? 'N/A' }}"
                                    data-matricula="{{ $t->alumno->matricula ?? 'N/A' }}"
                                    data-tutor="{{ $t->tutor->user->name ?? 'Sin asignar' }}"
                                    data-tema="{{ $t->tema ?? 'No especificado' }}"
                                    data-descripcion="{{ $t->descripcion ?? 'Sin descripción' }}"
                                    data-estado="{{ $t->estado }}"
                                    data-fecha="{{ \Carbon\Carbon::parse($t->created_at)->format('d/m/Y H:i') }}">
                                    <i class="bi bi-eye me-1"></i> Ver detalle
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top py-3 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex gap-3">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Total: {{ $tutorias->count() }} registros
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-check-circle me-1 text-success"></i>
                        Completadas: {{ $tutorias->where('estado', 'completada')->count() }}
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-clock me-1 text-warning"></i>
                        Pendientes: {{ $tutorias->where('estado', 'pendiente')->count() }}
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

<!-- Modal Detalle Tutoría - Rediseñado -->
<div class="modal fade" id="modalTutoria" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 border-0 shadow-lg">
            <div class="modal-header border-0 pt-4 px-4" style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);">
                <h5 class="modal-title text-white">
                    <i class="bi bi-chat-dots-fill me-2"></i>Detalle de Tutoría
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-label">
                                <i class="bi bi-person-circle me-1 text-primary"></i> Alumno
                            </div>
                            <div class="info-value fw-semibold" id="m_alumno">---</div>
                            <div class="info-subtext text-muted small" id="m_matricula"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-label">
                                <i class="bi bi-person-badge me-1 text-primary"></i> Tutor
                            </div>
                            <div class="info-value fw-semibold" id="m_tutor">---</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-label">
                                <i class="bi bi-tag me-1 text-primary"></i> Estado
                            </div>
                            <div id="m_estado"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="info-label">
                                <i class="bi bi-calendar me-1 text-primary"></i> Fecha
                            </div>
                            <div class="info-value" id="m_fecha">---</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-card">
                            <div class="info-label">
                                <i class="bi bi-book me-1 text-primary"></i> Tema
                            </div>
                            <div class="info-value fw-semibold" id="m_tema">---</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-card">
                            <div class="info-label">
                                <i class="bi bi-file-text me-1 text-primary"></i> Descripción
                            </div>
                            <div class="info-value" id="m_descripcion">---</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>Cerrar
                </button>
                <button type="button" class="btn btn-primary rounded-pill px-4" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i>Imprimir
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos modernos y formales */
.avatar-modern {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
}

.avatar-tutor {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    background: #e9ecef;
    color: #495057;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-estado {
    display: inline-flex;
    align-items: center;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-estado.completada {
    background: #d1fae5;
    color: #065f46;
}

.badge-estado.pendiente {
    background: #fed7aa;
    color: #92400e;
}

.badge-estado.otro {
    background: #e2e8f0;
    color: #475569;
}

.btn-ver {
    background: none;
    border: none;
    color: #0d6efd;
    font-size: 0.8rem;
    padding: 5px 12px;
    border-radius: 20px;
    transition: all 0.2s ease;
}

.btn-ver:hover {
    background: #e7f1ff;
    color: #0b5ed7;
}

.info-card {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 12px 16px;
    transition: all 0.2s ease;
}

.info-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
    margin-bottom: 6px;
}

.info-value {
    font-size: 0.95rem;
    color: #212529;
}

.info-subtext {
    font-size: 0.7rem;
    margin-top: 4px;
}

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
    background-color: #f8f9fa;
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

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
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

.dark-mode .modal-content {
    background-color: #1e293b;
}

.dark-mode .modal-header {
    background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%) !important;
}

.dark-mode .info-card {
    background-color: #334155;
}

.dark-mode .info-label {
    color: #94a3b8;
}

.dark-mode .info-value {
    color: #e2e8f0;
}

.dark-mode .btn-light {
    background-color: #475569;
    border-color: #475569;
    color: #e2e8f0;
}

.dark-mode .badge-estado.completada {
    background: #064e3b;
    color: #6ee7b7;
}

.dark-mode .badge-estado.pendiente {
    background: #78350f;
    color: #fcd34d;
}

.dark-mode .btn-ver:hover {
    background: #1e40af;
    color: #e2e8f0;
}

.dark-mode .avatar-tutor {
    background: #475569;
    color: #cbd5e1;
}

/* Responsive */
@media (max-width: 768px) {
    .table {
        font-size: 0.7rem;
    }
    
    .avatar-modern {
        width: 32px;
        height: 32px;
        font-size: 11px;
    }
    
    .badge-estado {
        font-size: 0.65rem;
        padding: 3px 8px;
    }
    
    .btn-ver {
        font-size: 0.7rem;
        padding: 3px 8px;
    }
}
</style>

<script>
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

// Modal data
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalTutoria');
    if (!modal) return;

    modal.addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        document.getElementById('m_alumno').textContent = btn.getAttribute('data-alumno') || '---';
        document.getElementById('m_matricula').textContent = btn.getAttribute('data-matricula') || '';
        document.getElementById('m_tutor').textContent = btn.getAttribute('data-tutor') || '---';
        document.getElementById('m_tema').textContent = btn.getAttribute('data-tema') || '---';
        document.getElementById('m_descripcion').textContent = btn.getAttribute('data-descripcion') || '---';
        document.getElementById('m_fecha').textContent = btn.getAttribute('data-fecha') || '---';
        
        const estado = btn.getAttribute('data-estado') || 'pendiente';
        const estadoHtml = estado === 'completada' 
            ? '<span class="badge-estado completada"><i class="bi bi-check-circle-fill me-1"></i> Completada</span>'
            : '<span class="badge-estado pendiente"><i class="bi bi-clock-fill me-1"></i> Pendiente</span>';
        document.getElementById('m_estado').innerHTML = estadoHtml;
    });
    
    // Filtros
    const searchInput = document.getElementById('searchInput');
    const filterEstado = document.getElementById('filterEstado');
    const rows = document.querySelectorAll('.tutoria-row');
    
    function filterTable() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const estadoFilter = filterEstado ? filterEstado.value : '';
        
        rows.forEach(row => {
            const searchText = row.getAttribute('data-search') || '';
            const rowEstado = row.getAttribute('data-estado') || '';
            
            const matchesSearch = searchTerm === '' || searchText.includes(searchTerm);
            const matchesEstado = estadoFilter === '' || rowEstado === estadoFilter;
            
            row.style.display = matchesSearch && matchesEstado ? '' : 'none';
        });
    }
    
    if (searchInput) searchInput.addEventListener('keyup', filterTable);
    if (filterEstado) filterEstado.addEventListener('change', filterTable);
});
</script>
@endsection