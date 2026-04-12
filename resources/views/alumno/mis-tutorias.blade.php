@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-semibold mb-1 text-dark">
                <i class="bi bi-chat-dots-fill me-2 text-primary"></i>Mis Tutorías
            </h2>
            <p class="text-muted small mb-0">Historial y seguimiento de tus sesiones de tutoría académica</p>
        </div>
        <button onclick="toggleDarkMode()" id="darkModeBtn" class="btn btn-outline-secondary rounded-pill px-3 btn-sm">
            <i class="bi bi-moon-stars me-1"></i> Modo oscuro
        </button>
    </div>

    @php
        $alumno = \App\Models\Alumno::with('tutorias')
            ->where('user_id', auth()->id())
            ->first();

        $tutorias = $alumno->tutorias ?? collect();
    @endphp

    @if($tutorias->isEmpty())
        <div class="text-center py-5">
            <div class="empty-state">
                <div class="empty-state-icon mb-3">
                    <i class="bi bi-chat-dots fs-1 text-muted"></i>
                </div>
                <h5 class="fw-semibold text-muted">No tienes tutorías registradas</h5>
                <p class="text-muted small">Cuando agendes una tutoría, aparecerá aquí.</p>
            </div>
        </div>
    @else
        <!-- Estadísticas -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
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
            <div class="col-md-4">
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
            <div class="col-md-4">
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
        </div>

        <!-- Tabla de tutorías -->
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-radius: 12px 12px 0 0;">
                <h5 class="fw-semibold mb-0">
                    <i class="bi bi-table me-2 text-primary"></i>Historial de Tutorías
                </h5>
                <div class="d-flex gap-2">
                    <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-filter active" onclick="filtrarEstado('todos', this)">
                            <i class="bi bi-grid-3x3-gap-fill me-1"></i>Todas
                        </button>
                        <button class="btn btn-filter" onclick="filtrarEstado('pendiente', this)">
                            <i class="bi bi-clock-history me-1"></i>Pendientes
                        </button>
                        <button class="btn btn-filter" onclick="filtrarEstado('completada', this)">
                            <i class="bi bi-check-circle-fill me-1"></i>Completadas
                        </button>
                    </div>
                    <div class="input-group input-group-sm" style="width: 250px;">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="buscadorTutorias" class="form-control border-start-0 rounded-end-pill" placeholder="Buscar por tema...">
                    </div>
                </div>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 custom-table" id="tutoriasTable">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3" style="min-width: 120px;">
                                    <i class="bi bi-calendar me-1 text-primary"></i> Fecha
                                </th>
                                <th class="py-3" style="min-width: 250px;">
                                    <i class="bi bi-book me-1 text-primary"></i> Tema
                                </th>
                                <th class="py-3 text-center" style="min-width: 130px;">
                                    <i class="bi bi-check-circle me-1 text-primary"></i> Estado
                                </th>
                                <th class="px-4 py-3 text-center" style="min-width: 100px;">
                                    <i class="bi bi-eye me-1 text-primary"></i> Acción
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tutorias as $tutoria)
                            <tr data-estado="{{ $tutoria->estado }}" data-tema="{{ strtolower($tutoria->tema ?? '') }}" data-id="{{ $tutoria->id }}">
                                <td class="px-4 py-3">
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ \Carbon\Carbon::parse($tutoria->fecha)->translatedFormat('d M Y') }}</span>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($tutoria->fecha)->format('H:i') }} hrs</small>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="fw-semibold">{{ $tutoria->tema ?? 'Sin tema' }}</div>
                                    <small class="text-muted">ID: {{ $tutoria->id }}</small>
                                </td>
                                <td class="py-3 text-center">
                                    @if($tutoria->estado == 'completada')
                                        <span class="badge-estado completada">
                                            <i class="bi bi-check-circle-fill me-1"></i> Completada
                                        </span>
                                    @elseif($tutoria->estado == 'pendiente')
                                        <span class="badge-estado pendiente">
                                            <i class="bi bi-clock-fill me-1"></i> Pendiente
                                        </span>
                                    @else
                                        <span class="badge-estado otro">{{ ucfirst($tutoria->estado) }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button class="btn-ver-detalle" onclick="verDetalle({{ $tutoria->id }})">
                                        <i class="bi bi-eye me-1"></i> Ver
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
    @endif
</div>

<style>
/* Estilos modernos */
.btn-filter {
    background: #f8f9fa;
    border: 1px solid #e2e8f0;
    color: #475569;
    font-size: 0.75rem;
    padding: 5px 12px;
    transition: all 0.2s ease;
}

.btn-filter:first-child {
    border-radius: 20px 0 0 20px;
}

.btn-filter:last-child {
    border-radius: 0 20px 20px 0;
}

.btn-filter.active {
    background: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

.btn-filter:hover:not(.active) {
    background: #e9ecef;
    border-color: #cbd5e1;
}

.custom-table {
    border-collapse: separate;
    border-spacing: 0;
}

.custom-table thead th {
    background: #f8f9fa;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    border-bottom: 2px solid #dee2e6;
}

.custom-table tbody tr {
    transition: all 0.2s ease;
    cursor: pointer;
}

.custom-table tbody tr:hover {
    background-color: #f8fafc;
}

.custom-table td {
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

.badge-estado {
    display: inline-flex;
    align-items: center;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
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

.btn-ver-detalle {
    background: none;
    border: none;
    color: #0d6efd;
    font-size: 0.75rem;
    padding: 5px 12px;
    border-radius: 20px;
    transition: all 0.2s ease;
}

.btn-ver-detalle:hover {
    background: #e7f1ff;
    color: #0b5ed7;
}

.empty-state {
    padding: 60px 20px;
    text-align: center;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    background: #f8f9fa;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
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

.dark-mode .custom-table thead th {
    background-color: #0f3460;
    color: #e2e8f0;
    border-bottom-color: #334155;
}

.dark-mode .custom-table tbody tr:hover {
    background-color: #334155;
}

.dark-mode .custom-table td {
    border-bottom-color: #334155;
}

.dark-mode .btn-filter {
    background: #334155;
    border-color: #475569;
    color: #cbd5e1;
}

.dark-mode .btn-filter.active {
    background: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

.dark-mode .btn-filter:hover:not(.active) {
    background: #475569;
}

.dark-mode .input-group-text,
.dark-mode .form-control {
    background-color: #334155;
    border-color: #475569;
    color: #e2e8f0;
}

.dark-mode .form-control::placeholder {
    color: #94a3b8;
}

.dark-mode .badge-estado.completada {
    background: #064e3b;
    color: #6ee7b7;
}

.dark-mode .badge-estado.pendiente {
    background: #78350f;
    color: #fcd34d;
}

.dark-mode .btn-ver-detalle:hover {
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
    .btn-filter {
        font-size: 0.65rem;
        padding: 4px 8px;
    }
    
    .badge-estado {
        font-size: 0.6rem;
        padding: 3px 8px;
    }
    
    .btn-ver-detalle {
        font-size: 0.65rem;
        padding: 3px 8px;
    }
    
    .custom-table td,
    .custom-table th {
        padding: 10px 8px;
    }
}
</style>

<script>
function verDetalle(id) {
    window.location.href = `/alumno/tutoria/${id}`;
}

function filtrarEstado(estado, btn) {
    // Actualizar botones activos
    document.querySelectorAll('.btn-filter').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    
    // Filtrar filas
    const rows = document.querySelectorAll('#tutoriasTable tbody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const rowEstado = row.getAttribute('data-estado');
        if (estado === 'todos' || rowEstado === estado) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Mostrar mensaje si no hay resultados
    const tbody = document.querySelector('#tutoriasTable tbody');
    const existingMsg = document.querySelector('.no-results-msg');
    
    if (visibleCount === 0 && !existingMsg) {
        const colCount = document.querySelector('#tutoriasTable thead tr')?.children.length || 4;
        const msgRow = document.createElement('tr');
        msgRow.className = 'no-results-msg';
        msgRow.innerHTML = `<td colspan="${colCount}" class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
            No hay tutorías ${estado === 'pendiente' ? 'pendientes' : estado === 'completada' ? 'completadas' : 'registradas'}
        </td>`;
        tbody.appendChild(msgRow);
    } else if (visibleCount > 0 && existingMsg) {
        existingMsg.remove();
    }
}

function filtrarBusqueda() {
    const searchTerm = document.getElementById('buscadorTutorias').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#tutoriasTable tbody tr:not(.no-results-msg)');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const tema = row.getAttribute('data-tema') || '';
        const matches = searchTerm === '' || tema.includes(searchTerm);
        row.style.display = matches ? '' : 'none';
        if (matches) visibleCount++;
    });
    
    // Manejar mensaje de no resultados
    const tbody = document.querySelector('#tutoriasTable tbody');
    const existingMsg = document.querySelector('.no-results-search');
    
    if (visibleCount === 0 && searchTerm !== '' && !existingMsg) {
        const colCount = document.querySelector('#tutoriasTable thead tr')?.children.length || 4;
        const msgRow = document.createElement('tr');
        msgRow.className = 'no-results-search';
        msgRow.innerHTML = `<td colspan="${colCount}" class="text-center py-5 text-muted">
            <i class="bi bi-search fs-1 d-block mb-2"></i>
            No se encontraron tutorías con "<strong>${searchTerm}</strong>"
        </td>`;
        tbody.appendChild(msgRow);
    } else if (visibleCount > 0 && existingMsg) {
        existingMsg.remove();
    } else if (searchTerm === '' && existingMsg) {
        existingMsg.remove();
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const buscador = document.getElementById('buscadorTutorias');
    if (buscador) {
        buscador.addEventListener('input', filtrarBusqueda);
    }
    
    // Inicializar tooltips si existen
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
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

// Verificar dark mode al cargar
if (localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark-mode');
    const btn = document.getElementById('darkModeBtn');
    if (btn) {
        btn.innerHTML = '<i class="bi bi-sun me-1"></i> Modo claro';
    }
}
</script>
@endsection