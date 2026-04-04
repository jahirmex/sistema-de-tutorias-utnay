@extends('layouts.coordinador')

@section('content')
<div class="container-fluid px-4">
    
    <!-- Header con título y botón de agregar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-person-badge me-2 text-primary"></i>Tutores
            </h2>
            <p class="text-muted">Gestión de tutores académicos y sus grupos asignados</p>
        </div>
        <a href="/coordinador/tutores/create" class="btn btn-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i>Agregar tutor
        </a>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm hover-shadow transition" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Total de tutores</div>
                            <h2 class="fw-bold display-4 mb-0">{{ $tutores->count() }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-person-badge text-primary fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-people me-1"></i> Tutores registrados en el sistema
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
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Tutores con grupos</div>
                            <h2 class="fw-bold display-4 mb-0">{{ $tutores->filter(function($tutor) { return $tutor->grupos->count() > 0; })->count() }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-people-fill text-success fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-check-circle me-1"></i> Con al menos un grupo asignado
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
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Total de grupos</div>
                            <h2 class="fw-bold display-4 mb-0">{{ $tutores->sum(function($tutor) { return $tutor->grupos->count(); }) }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-diagram-3 text-info fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-bar-chart me-1"></i> Grupos asignados a tutores
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de tutores mejorada -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-table me-2 text-primary"></i>Lista de tutores
                </h5>
                <div class="d-flex gap-2">
                    <div class="input-group" style="width: 250px;">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0 rounded-end-pill" placeholder="Buscar tutor...">
                    </div>
                    <select id="filterArea" class="form-select rounded-pill" style="width: 150px;">
                        <option value="">Todas las áreas</option>
                        @php
                            $areas = $tutores->pluck('area')->unique();
                        @endphp
                        @foreach($areas as $area)
                            @if($area)
                                <option value="{{ $area }}">{{ $area }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($tutores->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="tutoresTable">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th class="px-4 py-3 border-0">
                                    <i class="bi bi-person me-1"></i> Nombre
                                </th>
                                <th class="py-3 border-0">
                                    <i class="bi bi-envelope me-1"></i> Correo
                                </th>
                                <th class="py-3 border-0">
                                    <i class="bi bi-tag me-1"></i> Área
                                </th>
                                <th class="py-3 border-0 text-center">
                                    <i class="bi bi-diagram-3 me-1"></i> Grupos
                                </th>
                                <th class="px-4 py-3 border-0 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tutores as $tutor)
                            <tr class="border-bottom" 
                                data-nombre="{{ strtolower($tutor->user->name ?? '') }}" 
                                data-area="{{ $tutor->area ?? '' }}">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle bg-info bg-opacity-10 rounded-circle p-2" style="width: 36px; height: 36px;">
                                            <i class="bi bi-person-circle text-info"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $tutor->user->name ?? 'Sin nombre' }}</div>
                                            <small class="text-muted">ID: {{ $tutor->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <a href="mailto:{{ $tutor->user->email }}" class="text-decoration-none text-dark hover-primary">
                                        <i class="bi bi-envelope me-1 text-muted"></i>
                                        {{ $tutor->user->email }}
                                    </a>
                                </td>
                                <td class="py-3">
                                    @if($tutor->area)
                                        <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                            <i class="bi bi-tag me-1"></i> {{ $tutor->area }}
                                        </span>
                                    @else
                                        <span class="text-muted">No especificada</span>
                                    @endif
                                </td>
                                <td class="py-3 text-center">
                                    @if($tutor->grupos->count() > 0)
                                        <div class="d-flex flex-wrap justify-content-center gap-1">
                                            @foreach($tutor->grupos as $grupo)
                                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1">
                                                    <i class="bi bi-people-fill me-1 small"></i>{{ $grupo->nombre }}
                                                </span>
                                            @endforeach
                                        </div>
                                        <small class="text-muted d-block mt-1">{{ $tutor->grupos->count() }} grupo(s)</small>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-2">
                                            <i class="bi bi-exclamation-circle me-1"></i> Sin grupos
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('tutores.dashboard', $tutor->id) }}" 
                                           class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                           data-bs-toggle="tooltip" 
                                           title="Ver dashboard del tutor">
                                            <i class="bi bi-bar-chart"></i>
                                        </a>
                                        <a href="/coordinador/tutores/{{ $tutor->id }}/edit" 
                                           class="btn btn-sm btn-outline-warning rounded-pill px-3"
                                           data-bs-toggle="tooltip" 
                                           title="Editar tutor">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="/coordinador/tutores/{{ $tutor->id }}" method="POST" style="display:inline;" class="form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger rounded-pill px-3 btn-delete"
                                                    data-tutor="{{ $tutor->user->name }}"
                                                    data-bs-toggle="tooltip" 
                                                    title="Eliminar tutor">
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
                
                <!-- Paginación -->
                @if(method_exists($tutores, 'links'))
                    <div class="d-flex justify-content-center p-4">
                        {{ $tutores->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state m-4">
                    <i class="bi bi-inbox display-1 text-muted mb-3 d-block"></i>
                    <h5 class="text-muted">No hay tutores registrados</h5>
                    <p class="text-muted mb-3">Comienza agregando un nuevo tutor al sistema.</p>
                    <a href="/coordinador/tutores/create" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-plus-circle me-2"></i>Agregar primer tutor
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
        width: 36px;
        height: 36px;
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Filtro de búsqueda
    const searchInput = document.getElementById('searchInput');
    const filterArea = document.getElementById('filterArea');
    const table = document.getElementById('tutoresTable');
    
    function filterTable() {
        if (!table) return;
        
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const areaFilter = filterArea ? filterArea.value : '';
        
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
        
        const rows = tbody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const nombre = row.getAttribute('data-nombre') || '';
            const area = row.getAttribute('data-area') || '';
            
            const matchesSearch = searchTerm === '' || nombre.includes(searchTerm);
            const matchesArea = areaFilter === '' || area === areaFilter;
            
            row.style.display = matchesSearch && matchesArea ? '' : 'none';
        });
    }
    
    if (searchInput) {
        searchInput.addEventListener('keyup', filterTable);
    }
    
    if (filterArea) {
        filterArea.addEventListener('change', filterTable);
    }
    
    // Confirmación de eliminación
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.form-delete');
            const tutorNombre = this.getAttribute('data-tutor');
            
            Swal.fire({
                title: '¿Eliminar tutor?',
                html: `Estás a punto de eliminar a <strong>${tutorNombre}</strong>.<br>Esta acción no se puede deshacer.`,
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
    
    // Ejecutar filtro inicial
    filterTable();
});
</script>

@endsection