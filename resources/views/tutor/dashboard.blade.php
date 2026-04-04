@extends('layouts.tutor')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0">👨‍🏫 Panel del Tutor</h2>
        <span class="badge bg-dark-subtle text-dark px-3 py-2">Resumen general</span>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control rounded-3" placeholder="🔍 Buscar alumno por nombre...">
            </div>
            <div class="col-md-4">
                <select id="grupoFilter" class="form-select rounded-3">
                    <option value="">Todos los grupos</option>
                    @foreach($alumnos->pluck('grupo.nombre')->unique() as $grupo)
                        <option value="{{ $grupo }}">{{ $grupo }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row g-3">

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 hover-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Mis alumnos</div>
                        <h2 class="fw-bold mb-0">{{ $totalAlumnos }}</h2>
                    </div>
                    <div class="icon-box bg-primary-subtle text-primary">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 hover-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Mis grupos</div>
                        <h2 class="fw-bold mb-0">{{ $totalGrupos }}</h2>
                    </div>
                    <div class="icon-box bg-success-subtle text-success">
                        <i class="bi bi-collection"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-semibold mb-0">⚡ Actividad reciente</h6>
                </div>

                @php
                    $ultimasTutorias = $alumnos->flatMap->tutorias
                        ->filter(fn($t) => !is_null($t->alumno_id) && !is_null($t->alumno))
                        ->sortByDesc('fecha')
                        ->take(3);
                @endphp

                @if($ultimasTutorias->isNotEmpty())
                    @foreach($ultimasTutorias as $tutoria)
                        <a href="{{ $tutoria->alumno ? route('tutor.alumnos.show', $tutoria->alumno->id) : '#' }}" 
                           class="d-flex align-items-center gap-3 mb-3 text-decoration-none text-dark hover-card">
                            <div class="icon-box bg-primary-subtle text-primary">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">
                                    {{ $tutoria->tema }}
                                </div>
                                <div class="text-muted small">
                                    {{ optional($tutoria->alumno)->user->name ?? 'Alumno' }}
                                </div>
                                <div class="text-muted small">
                                    {{ \Carbon\Carbon::parse($tutoria->fecha)->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="text-muted">
                        No hay actividad reciente
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-4 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-semibold mb-0">📋 Lista de alumnos</h6>
            <span class="text-muted small">{{ $alumnos->count() }} registros</span>
        </div>

        <div class="table-responsive">
        <table class="table align-middle table-hover">
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Matrícula</th>
                    <th>Grupo</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumnos as $alumno)
                    <tr class="alumno-row" data-nombre="{{ strtolower($alumno->user->name ?? '') }}" data-grupo="{{ $alumno->grupo->nombre ?? '' }}">

                        <td style="white-space: nowrap;">
                            <div class="d-flex align-items-center gap-2">

                                <div class="avatar-circle">
                                    {{ strtoupper(substr($alumno->user->name ?? 'U', 0, 1)) }}
                                </div>

                                <div>
                                    <div class="fw-semibold">
                                        {{ $alumno->user->name ?? 'Sin usuario' }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $alumno->user->email ?? 'Sin correo' }}
                                    </div>
                                </div>

                            </div>
                        </td>

                        <td style="white-space: nowrap;">
                            {{ $alumno->matricula }}
                        </td>

                        <td>
                            <span class="badge bg-primary-subtle text-primary border rounded-pill px-3 py-2">
                                {{ $alumno->grupo->nombre ?? 'Sin grupo' }}
                            </span>
                        </td>

                        <td class="text-end" style="white-space: nowrap;">

                            <a href="{{ route('tutor.alumnos.show', $alumno->id) }}" 
                               class="btn btn-outline-primary btn-sm rounded-3 me-1"
                               title="Ver alumno">
                                <i class="bi bi-eye"></i>
                            </a>

                            <button class="btn btn-outline-success btn-sm rounded-3"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalTutoria"
                                    data-alumno="{{ $alumno->id }}">
                                <i class="bi bi-journal-plus"></i>
                            </button>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            No hay alumnos asignados
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>

    </div>

    <!-- Modal Tutoría -->
    <div class="modal fade" id="modalTutoria" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
          <form method="POST" action="{{ route('tutor.tutorias.store') }}">
            @csrf

            <div class="modal-header border-0">
              <h5 class="modal-title fw-semibold">Registrar Tutoría</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" name="alumno_id" id="alumno_id">

                <div class="mb-3">
                    <label class="form-label">Tema</label>
                    <input type="text" name="tema" class="form-control rounded-3" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control rounded-3" rows="3" required></textarea>
                </div>
            </div>

            <div class="modal-footer border-0">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

</div>

<style>
.avatar-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #2563eb;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
}

.icon-box {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.hover-card {
    transition: all 0.2s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-4px);
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,0.03);
}

.dark-mode .avatar-circle {
    background: #3b82f6;
}
</style>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    document.querySelectorAll('.alumno-row').forEach(row => {
        let nombre = row.dataset.nombre;
        row.style.display = nombre.includes(value) ? '' : 'none';
    });
});

document.getElementById('grupoFilter').addEventListener('change', function() {
    let grupo = this.value;
    document.querySelectorAll('.alumno-row').forEach(row => {
        let rowGrupo = row.dataset.grupo;
        row.style.display = (grupo === '' || rowGrupo === grupo) ? '' : 'none';
    });
});

document.getElementById('modalTutoria').addEventListener('show.bs.modal', function (event) {
    let button = event.relatedTarget;
    let alumnoId = button.getAttribute('data-alumno');
    document.getElementById('alumno_id').value = alumnoId;
});
</script>

@endsection