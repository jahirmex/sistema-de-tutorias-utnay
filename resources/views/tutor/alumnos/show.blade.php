@extends('layouts.tutor')

@section('content')
<div class="container">

    <h2 class="mb-4 fw-bold text-dark">👤 Detalle del Alumno</h2>

    <div class="card shadow-sm rounded-4 border-0 mb-4">
        <div class="card-body">
            <h4 class="fw-semibold">{{ $alumno->user->name ?? 'Sin nombre' }}</h4>
            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                {{ $alumno->grupo->nombre ?? 'Sin grupo' }}
            </span>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                <h6 class="text-muted">Total Tutorías</h6>
                <h3 class="fw-bold">{{ $alumno->tutorias->count() }}</h3>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>📅 Registro de Tutorías</h4>
        <a href="{{ route('tutor.tutorias.create', $alumno->id) }}" class="btn btn-primary rounded-3">
            + Nueva Tutoría
        </a>
    </div>

    @if($alumno->tutorias->isEmpty())
        <div class="alert alert-info">No hay tutorías registradas.</div>
    @else
        @foreach($alumno->tutorias as $tutoria)
            <div class="card shadow-sm rounded-4 border-0 mb-3">
                <div class="card-body">
                    <h5 class="fw-semibold text-dark">{{ $tutoria->tema }}</h5>
                    <p class="text-muted mb-2">{{ $tutoria->descripcion }}</p>

                    <div class="d-flex gap-3 flex-wrap mt-2">
                        <span class="badge bg-light text-dark">
                            📅 {{ \Carbon\Carbon::parse($tutoria->fecha)->format('d M Y - h:i A') }}
                        </span>
                        <span class="badge bg-success-subtle text-success">
                            👨‍🏫 {{ $tutoria->tutor->user->name ?? 'Sin tutor' }}
                        </span>
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <a href="{{ route('tutor.tutorias.edit', $tutoria->id) }}" class="btn btn-outline-warning btn-sm rounded-3">✏️ Editar</a>

                        <form action="{{ route('tutor.tutorias.destroy', $tutoria->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta tutoría?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-3">🗑️ Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

</div>
<style>
.card:hover {
    transform: translateY(-3px);
    transition: all 0.2s ease-in-out;
}
</style>
@endsection