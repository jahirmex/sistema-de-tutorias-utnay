@extends('layouts.alumno')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Detalle de Tutoría</h2>
        <a href="/alumno/tutorias" class="btn btn-light">
            ← Volver
        </a>
    </div>

    <!-- Card principal -->
    <div class="card border-0 shadow-sm rounded-4 p-4">

        <!-- Tema -->
        <h4 class="fw-semibold mb-1">{{ $tutoria->tema }}</h4>
        <p class="text-muted mb-4">{{ $tutoria->descripcion }}</p>

        <div class="row g-3">

            <!-- Fecha -->
            <div class="col-md-6">
                <div class="info-box">
                    <div class="label">📅 Fecha</div>
                    <div class="value">
                        {{ \Carbon\Carbon::parse($tutoria->fecha)->translatedFormat('j \\d\\e F, Y') }}
                    </div>
                </div>
            </div>

            <!-- Tutor -->
            <div class="col-md-6">
                <div class="info-box">
                    <div class="label">👨‍🏫 Tutor</div>
                    <div class="value">
                        {{ $tutoria->tutor->user->name ?? 'Sin tutor asignado' }}
                    </div>
                </div>
            </div>

            <!-- Estado -->
            <div class="col-md-6">
                <div class="info-box">
                    <div class="label">📊 Estado</div>
                    <div class="value">
                        @if($tutoria->estado == 'completada')
                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">✔ Completada</span>
                        @else
                            <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2">⏳ Pendiente</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Calificación -->
            @if($tutoria->calificacion)
            <div class="col-md-6">
                <div class="info-box">
                    <div class="label">⭐ Calificación</div>
                    <div class="value">
                        {{ str_repeat('⭐', $tutoria->calificacion) }}
                    </div>
                </div>
            </div>
            @endif

        </div>

        <!-- Comentarios -->
        @if($tutoria->comentarios)
        <div class="mt-4">
            <div class="info-box">
                <div class="label">💬 Comentarios del tutor</div>
                <div class="value text-muted">
                    {{ $tutoria->comentarios }}
                </div>
            </div>
        </div>
        @endif

    </div>

</div>

<style>
.info-box {
    background: #f8fafc;
    border-radius: 12px;
    padding: 14px 16px;
}

.label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
    margin-bottom: 4px;
}

.value {
    font-weight: 600;
    font-size: 0.95rem;
}

.card {
    transition: all 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}
</style>

@endsection