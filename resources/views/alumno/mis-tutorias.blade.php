@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="fw-bold mb-4">Mis Tutorías</h2>

    @php
        $tutorias = auth()->user()->tutorias ?? collect();
    @endphp

    @if($tutorias->isEmpty())
        <div class="alert alert-info">No tienes tutorías registradas</div>
    @else
        <div class="card p-4">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tema</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tutorias as $tutoria)
                        <tr onclick="verDetalle({{ $tutoria->id }})" style="cursor:pointer;">
                            <td>{{ \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $tutoria->tema ?? 'Sin tema' }}</td>
                            <td>
                                @if($tutoria->estado == 'completada')
                                    <span class="badge bg-success">Completada</span>
                                @elseif($tutoria->estado == 'pendiente')
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($tutoria->estado) }}</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" onclick="verDetalle({{ $tutoria->id }}); event.stopPropagation();">
                                    Ver
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

<script>
function verDetalle(id) {
    window.location.href = `/alumno/tutoria/${id}`;
}
</script>

@endsection