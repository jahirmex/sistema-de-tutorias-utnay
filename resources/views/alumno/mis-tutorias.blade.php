@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="fw-bold mb-4">Mis Tutorías</h2>

    @php
        $alumno = \App\Models\Alumno::with('tutorias')
            ->where('user_id', auth()->id())
            ->first();

        $tutorias = $alumno->tutorias ?? collect();
    @endphp

    @if($tutorias->isEmpty())
        <div class="alert alert-info">No tienes tutorías registradas</div>
    @else
        <div class="card p-4 border-0 shadow-sm rounded-4">
            <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between mb-3">
                <div class="btn-group" role="group" aria-label="Filtros">
                    <button class="btn btn-sm btn-light active" onclick="filtrarEstado('todos', this)">Todas</button>
                    <button class="btn btn-sm btn-light" onclick="filtrarEstado('pendiente', this)">Pendientes</button>
                    <button class="btn btn-sm btn-light" onclick="filtrarEstado('completada', this)">Completadas</button>
                </div>

                <div class="input-group input-group-sm" style="max-width: 280px;">
                    <span class="input-group-text">🔎</span>
                    <input type="text" id="buscadorTutorias" class="form-control" placeholder="Buscar por tema..." oninput="filtrarBusqueda()">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0 custom-table">
                    <thead class="text-muted small">
                        <tr>
                            <th>Fecha</th>
                            <th>Tema</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tutorias as $tutoria)
                        <tr data-estado="{{ $tutoria->estado }}" data-tema="{{ strtolower($tutoria->tema ?? '') }}" onclick="verDetalle({{ $tutoria->id }})" style="cursor:pointer;">
                            <td class="fw-semibold">
                                {{ \Carbon\Carbon::parse($tutoria->fecha)->translatedFormat('j M Y') }}
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $tutoria->tema ?? 'Sin tema' }}</div>
                                <div class="text-muted small">ID: {{ $tutoria->id }}</div>
                            </td>
                            <td>
                                @if($tutoria->estado == 'completada')
                                    <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">✔ Completada</span>
                                @elseif($tutoria->estado == 'pendiente')
                                    <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2">⏳ Pendiente</span>
                                @else
                                    <span class="badge rounded-pill bg-secondary-subtle text-secondary px-3 py-2">
                                        {{ ucfirst($tutoria->estado) }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-primary" onclick="verDetalle({{ $tutoria->id }}); event.stopPropagation();">
                                    Ver →
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

<style>
.custom-table {
    border-collapse: separate;
    border-spacing: 0 10px;
}

.custom-table tbody tr {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: all 0.2s ease;
}

.custom-table tbody tr:hover {
    background: #f8fafc;
    transform: translateY(-2px);
}

.custom-table td {
    border: none !important;
    padding: 14px;
}

.custom-table tbody tr td:first-child {
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
}

.custom-table tbody tr td:last-child {
    border-top-right-radius: 12px;
    border-bottom-right-radius: 12px;
}

.btn-group .btn.active {
    background-color: #3b82f6;
    color: white;
}

.input-group-text {
    background: #f1f5f9;
}
</style>
<script>
function verDetalle(id) {
    window.location.href = `/alumno/tutoria/${id}`;
}

function filtrarEstado(estado, btn) {
    document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('tbody tr').forEach(tr => {
        if (estado === 'todos' || tr.dataset.estado === estado) {
            tr.style.display = '';
        } else {
            tr.style.display = 'none';
        }
    });
}

function filtrarBusqueda() {
    const valor = document.getElementById('buscadorTutorias').value.toLowerCase();

    document.querySelectorAll('tbody tr').forEach(tr => {
        const tema = tr.dataset.tema;

        if (tema.includes(valor)) {
            tr.style.display = '';
        } else {
            tr.style.display = 'none';
        }
    });
}
</script>

@endsection