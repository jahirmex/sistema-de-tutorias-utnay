@extends('layouts.coordinador')

@section('content')
<div class="container py-4">

    <h2 class="fw-bold mb-4">Detalle de Tutoría</h2>

    <div class="card p-4 shadow-sm">

        <h4>{{ $tutoria->tema }}</h4>
        <p class="text-muted">{{ $tutoria->descripcion }}</p>

        <p><strong>Alumno:</strong> {{ $tutoria->alumno->user->name }}</p>
        <p><strong>Tutor:</strong> {{ $tutoria->tutor->user->name ?? 'Sin tutor' }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($tutoria->fecha)->format('d M Y - h:i A') }}</p>

        <p>
            <strong>Estado:</strong>
            @if($tutoria->estado === 'confirmada')
                <span class="badge bg-success">Confirmada</span>
            @else
                <span class="badge bg-warning text-dark">Pendiente</span>
            @endif
        </p>

        @if($tutoria->estado !== 'confirmada')
            <form action="{{ route('tutorias.confirmar', $tutoria->id) }}" method="POST">
                @csrf
                <button class="btn btn-success mt-3">
                    ✔ Confirmar tutoría
                </button>
            </form>
        @endif

    </div>

</div>
@endsection