@extends('layouts.coordinador')

@section('content')
<div class="container-fluid px-4 py-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-semibold mb-1 text-dark">
                <i class="bi bi-calendar-week me-2 text-primary"></i>Gestión de Horarios
            </h2>
            <p class="text-muted small mb-0">Administre los horarios académicos por grupo, día y hora</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-3 btn-sm">
                <i class="bi bi-printer me-1"></i> Imprimir
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Panel de estadísticas -->
        <div class="col-12">
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small text-uppercase fw-semibold">Total registros</span>
                                    <h3 class="fw-bold mb-0 mt-1">{{ $horarios->count() }}</h3>
                                </div>
                                <div class="bg-primary bg-opacity-10 rounded p-2">
                                    <i class="bi bi-table text-primary fs-4"></i>
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
                                    <span class="text-muted small text-uppercase fw-semibold">Grupos</span>
                                    <h3 class="fw-bold mb-0 mt-1">{{ $horarios->pluck('grupo')->unique()->count() }}</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 rounded p-2">
                                    <i class="bi bi-people-fill text-success fs-4"></i>
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
                                    <span class="text-muted small text-uppercase fw-semibold">Materias</span>
                                    <h3 class="fw-bold mb-0 mt-1">{{ $horarios->pluck('materia')->unique()->count() }}</h3>
                                </div>
                                <div class="bg-info bg-opacity-10 rounded p-2">
                                    <i class="bi bi-book text-info fs-4"></i>
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
                                    <span class="text-muted small text-uppercase fw-semibold">Docentes</span>
                                    <h3 class="fw-bold mb-0 mt-1">{{ $horarios->pluck('docente')->unique()->count() }}</h3>
                                </div>
                                <div class="bg-warning bg-opacity-10 rounded p-2">
                                    <i class="bi bi-person-badge text-warning fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario de creación -->
        <div class="col-md-5">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom px-4 py-3" style="border-radius: 12px 12px 0 0;">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-plus-circle me-2 text-primary"></i>Nuevo Horario
                    </h5>
                    <p class="text-muted small mb-0 mt-1">Complete los campos para agregar una nueva clase</p>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('horarios.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Grupo</label>
                                <input name="grupo" placeholder="Ej. IDGS81" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Día</label>
                                <select name="dia" class="form-select form-select-sm" required>
                                    <option value="">Seleccionar</option>
                                    <option value="lunes">Lunes</option>
                                    <option value="martes">Martes</option>
                                    <option value="miercoles">Miércoles</option>
                                    <option value="jueves">Jueves</option>
                                    <option value="viernes">Viernes</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Hora</label>
                                <input name="hora" placeholder="Ej. 08:00 - 09:00" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Materia</label>
                                <input name="materia" placeholder="Nombre de la materia" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Docente</label>
                                <input name="docente" placeholder="Nombre del docente" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-muted">Aula</label>
                                <input name="aula" placeholder="Ej. A-101" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-12 mt-3">
                                <button class="btn btn-primary w-100 rounded-pill py-2">
                                    <i class="bi bi-save me-2"></i>Guardar Horario
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabla de horarios -->
        <div class="col-md-7">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="border-radius: 12px 12px 0 0;">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-table me-2 text-primary"></i>Lista de Horarios
                    </h5>
                    <div class="d-flex gap-2">
                        <div class="input-group" style="width: 200px;">
                            <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                                <i class="bi bi-search text-muted small"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control form-control-sm border-start-0 rounded-end-pill" placeholder="Buscar...">
                        </div>
                        <select id="filterGroup" class="form-select form-select-sm rounded-pill" style="width: 120px;">
                            <option value="">Todos</option>
                            @foreach($horarios->pluck('grupo')->unique() as $grupo)
                                <option value="{{ $grupo }}">{{ $grupo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0" id="horariosTable" style="font-size: 0.85rem;">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="px-3 py-2"><i class="bi bi-people me-1"></i> Grupo</th>
                                    <th class="px-3 py-2"><i class="bi bi-calendar me-1"></i> Día</th>
                                    <th class="px-3 py-2"><i class="bi bi-clock me-1"></i> Hora</th>
                                    <th class="px-3 py-2"><i class="bi bi-book me-1"></i> Materia</th>
                                    <th class="px-3 py-2"><i class="bi bi-person me-1"></i> Docente</th>
                                    <th class="px-3 py-2"><i class="bi bi-door-closed me-1"></i> Aula</th>
                                    <th class="px-3 py-2 text-center"><i class="bi bi-three-dots me-1"></i> Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($horarios as $h)
                                <tr class="horario-row" data-grupo="{{ $h->grupo }}" data-search="{{ strtolower($h->grupo . ' ' . $h->materia . ' ' . $h->docente . ' ' . $h->aula) }}">
                                    <td class="px-3 py-2">
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1">
                                            {{ $h->grupo }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2">
                                        @php
                                            $dias = ['lunes'=>'Lunes','martes'=>'Martes','miercoles'=>'Miércoles','jueves'=>'Jueves','viernes'=>'Viernes'];
                                        @endphp
                                        {{ $dias[$h->dia] ?? ucfirst($h->dia) }}
                                    </td>
                                    <td class="px-3 py-2">
                                        <code class="small">{{ $h->hora }}</code>
                                    </td>
                                    <td class="px-3 py-2 fw-semibold">{{ $h->materia }}</td>
                                    <td class="px-3 py-2">{{ $h->docente }}</td>
                                    <td class="px-3 py-2">
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-1">
                                            <i class="bi bi-building me-1"></i>{{ $h->aula }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <button onclick='openEditModal(@json($h))' class="btn btn-sm btn-outline-warning rounded-pill px-2" data-bs-toggle="tooltip" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form method="POST" action="{{ route('horarios.destroy', $h->id) }}" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 btn-delete" data-bs-toggle="tooltip" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-top py-2 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Total: {{ $horarios->count() }} registros
                        </small>
                        <small class="text-muted">
                            <i class="bi bi-clock me-1"></i>
                            Última actualización: {{ now()->format('d/m/Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Vista tipo calendario por grupo -->
    <div class="row mt-4">
        <div class="col-12">
            @php
                $horariosPorGrupo = $horarios->groupBy('grupo');
            @endphp

            @foreach($horariosPorGrupo as $grupo => $items)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-calendar3 me-2 text-primary"></i>
                            Horario {{ $grupo }}
                        </h5>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Hora</th>
                                        <th>Lunes</th>
                                        <th>Martes</th>
                                        <th>Miércoles</th>
                                        <th>Jueves</th>
                                        <th>Viernes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $horas = $items->pluck('hora')->unique()->sort();
                                    @endphp

                                    @foreach($horas as $hora)
                                        <tr>
                                            <td class="fw-semibold">{{ $hora }}</td>

                                            @foreach(['lunes','martes','miercoles','jueves','viernes'] as $dia)
                                                @php
                                                    $clase = $items->where('hora', $hora)->where('dia', $dia)->first();
                                                @endphp

                                                <td>
                                                    @if($clase)
                                                        <div class="fw-semibold text-primary">{{ $clase->materia }}</div>
                                                        <small class="text-muted">{{ $clase->docente }}</small><br>
                                                        <small class="text-secondary">{{ $clase->aula }}</small>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

<!-- Modal Editar -->
<div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content rounded-3">
                <div class="modal-header bg-light border-0">
                    <h5 class="modal-title fw-semibold">
                        <i class="bi bi-pencil-square me-2 text-primary"></i>Editar Horario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="editId" name="id">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Grupo</label>
                        <input id="editGrupo" name="grupo" class="form-control form-control-sm" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Día</label>
                        <select id="editDia" name="dia" class="form-select form-select-sm" required>
                            <option value="lunes">Lunes</option>
                            <option value="martes">Martes</option>
                            <option value="miercoles">Miércoles</option>
                            <option value="jueves">Jueves</option>
                            <option value="viernes">Viernes</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Hora</label>
                        <input id="editHora" name="hora" class="form-control form-control-sm" placeholder="Ej. 08:00 - 09:00" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Materia</label>
                        <input id="editMateria" name="materia" class="form-control form-control-sm" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Docente</label>
                        <input id="editDocente" name="docente" class="form-control form-control-sm" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Aula</label>
                        <input id="editAula" name="aula" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-save me-1"></i>Guardar cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
/* Estilos formales */
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

.card {
    transition: box-shadow 0.2s ease;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05) !important;
}

.sticky-top {
    position: sticky;
    top: 0;
    z-index: 10;
}

/* Scrollbar personalizada */
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

.dark-mode .bg-light {
    background-color: #1e293b !important;
}

.dark-mode .form-control,
.dark-mode .form-select,
.dark-mode .input-group-text {
    background-color: #334155;
    border-color: #475569;
    color: #e2e8f0;
}

.dark-mode .form-control::placeholder {
    color: #94a3b8;
}

.dark-mode .modal-content {
    background-color: #1e293b;
    border-color: #334155;
}

.dark-mode .modal-header {
    border-bottom-color: #334155;
}

.dark-mode .btn-close {
    filter: invert(1);
}

/* Responsive */
@media (max-width: 768px) {
    .table {
        font-size: 0.7rem;
    }
    
    .table td, 
    .table th {
        padding: 6px 4px;
    }
    
    .badge {
        font-size: 0.6rem;
    }
}

/* Animación para nuevos registros */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.horario-row {
    animation: fadeIn 0.3s ease-out;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

// Función para abrir modal de edición
function openEditModal(h) {
    document.getElementById('editId').value = h.id;
    document.getElementById('editGrupo').value = h.grupo || '';
    document.getElementById('editDia').value = h.dia || 'lunes';
    document.getElementById('editHora').value = h.hora || '';
    document.getElementById('editMateria').value = h.materia || '';
    document.getElementById('editDocente').value = h.docente || '';
    document.getElementById('editAula').value = h.aula || '';

    document.getElementById('editForm').action = '/coordinador/horarios/' + h.id;

    let modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
}

// Filtros de búsqueda
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterGroup = document.getElementById('filterGroup');
    const rows = document.querySelectorAll('.horario-row');
    
    function filterTable() {
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const groupFilter = filterGroup ? filterGroup.value : '';
        
        rows.forEach(row => {
            const searchText = row.getAttribute('data-search') || '';
            const rowGroup = row.getAttribute('data-grupo') || '';
            
            const matchesSearch = searchTerm === '' || searchText.includes(searchTerm);
            const matchesGroup = groupFilter === '' || rowGroup === groupFilter;
            
            row.style.display = matchesSearch && matchesGroup ? '' : 'none';
        });
    }
    
    if (searchInput) {
        searchInput.addEventListener('keyup', filterTable);
    }
    
    if (filterGroup) {
        filterGroup.addEventListener('change', filterTable);
    }
    
    // Confirmación de eliminación
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: '¿Eliminar horario?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: '<i class="bi bi-trash me-1"></i>Sí, eliminar',
                cancelButtonText: '<i class="bi bi-x me-1"></i>Cancelar',
                customClass: {
                    popup: 'rounded-3'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
    
    // Tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Mostrar mensaje de éxito si hay sesión
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    @endif
});
</script>
@endsection