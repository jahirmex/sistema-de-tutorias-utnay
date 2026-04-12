@extends('layouts.app')

@section('title', 'Dashboard Alumno')

@section('sidebar')
    <a href="{{ route('alumno.dashboard') }}" class="active">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="{{ route('alumno.mis-tutorias') }}">
        <i class="bi bi-calendar-check"></i> Mis Tutorías
        @if($alumno->tutorias->where('estado', 'pendiente')->count() > 0)
            <span class="badge bg-danger ms-auto rounded-pill">{{ $alumno->tutorias->where('estado', 'pendiente')->count() }}</span>
        @endif
    </a>

    <a href="{{ route('alumno.solicitar-tutoria') }}">
        <i class="bi bi-plus-circle"></i> Solicitar Tutoría
    </a>

    <a href="{{ route('alumno.mi-tutor') }}">
        <i class="bi bi-person-badge"></i> Mi Tutor
    </a>
@endsection

@section('content')
    <!-- Header de bienvenida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Panel de Tutorías</h2>
            <p class="text-muted">
                Bienvenido, {{ $alumno->user->name }} · 
                <strong>{{ $alumno->matricula }}</strong> · 
                {{ $alumno->carrera }} · 
                {{ $alumno->cuatrimestre }}° Cuatrimestre
                @if($alumno->grupo)
                    · Grupo {{ $alumno->grupo->nombre }}
                @endif
            </p>
        </div>
        <div class="text-end">
            <small class="text-muted">Último acceso: {{ now()->format('d/m/Y H:i') }}</small>
        </div>
    </div>

    <!-- Tarjetas de estadísticas mejoradas -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm hover-shadow transition" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Tutorías completadas</div>
                            <h2 class="fw-bold display-6 mb-0">{{ $alumno->tutorias->where('estado','completada')->count() }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-calendar-check me-1"></i> Total de tutorías finalizadas
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
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Última tutoría</div>
                            @php
                                $ultimaTutoria = $alumno->tutorias->where('estado','completada')->sortByDesc('fecha')->first();
                            @endphp
                            @if($ultimaTutoria)
                                <h6 class="fw-semibold mb-1">{{ $ultimaTutoria->tema ?? 'Sin tema' }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i> 
                                    {{ \Carbon\Carbon::parse($ultimaTutoria->fecha)->format('d/m/Y') }}
                                </small>
                            @else
                                <h6 class="fw-semibold mb-0 text-warning">Sin registros</h6>
                                <small class="text-muted">Aún no tienes tutorías</small>
                            @endif
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-calendar-week text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm hover-shadow transition" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Promedio académico</div>
                            <h2 class="fw-bold display-6 mb-0">{{ number_format($alumno->promedio ?? 0,1) }}</h2>
                            @php
                                $promedio = $alumno->promedio ?? 0;
                                $mensajePromedio = $promedio >= 9 ? 'Excelente' : ($promedio >= 7 ? 'Bueno' : ($promedio > 0 ? 'Requiere atención' : 'Sin registro'));
                            @endphp
                            <small class="text-{{ $promedio >= 9 ? 'success' : ($promedio >= 7 ? 'info' : 'warning') }}">
                                <i class="bi bi-info-circle me-1"></i>{{ $mensajePromedio }}
                            </small>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-trophy-fill text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Próximas tutorías (pendientes) -->
    @php
        $proximasTutorias = $alumno->tutorias->where('estado', 'pendiente')->filter(function ($t) {return \Carbon\Carbon::parse($t->fecha)->isFuture();})->sortBy('fecha');
    @endphp
    
    @if($proximasTutorias->count() > 0)
    <div class="card mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-calendar-week me-2 text-primary"></i>Próximas sesiones
                </h5>
                <span class="badge bg-primary rounded-pill px-3 py-2">
                    <i class="bi bi-clock me-1"></i> {{ $proximasTutorias->count() }} pendientes
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr class="border-0">
                            <th class="px-4 py-3 border-0"><i class="bi bi-calendar3 me-1"></i> Fecha</th>
                            <th class="py-3 border-0"><i class="bi bi-book me-1"></i> Tema</th>
                            <th class="py-3 border-0"><i class="bi bi-person me-1"></i> Tutor</th>
                            <th class="py-3 border-0"><i class="bi bi-hourglass-split me-1"></i> Duración</th>
                            <th class="py-3 border-0"><i class="bi bi-info-circle me-1"></i> Estado</th>
                            <th class="px-4 py-3 border-0 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proximasTutorias as $tutoria)
                        <tr class="border-bottom">
                            <td class="px-4 py-3">
                                <div class="fw-semibold">{{ \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($tutoria->fecha)->format('l') }}</small>
                            </td>
                            <td class="py-3">
                                <div class="fw-semibold">{{ $tutoria->tema ?? 'Sin especificar' }}</div>
                            </td>
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle bg-info bg-opacity-10 rounded-circle p-2" style="width: 32px; height: 32px;">
                                        <i class="bi bi-person-circle text-info"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $tutoria->tutor->user->name ?? 'No asignado' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                    <i class="bi bi-clock me-1"></i> {{ $tutoria->duracion_minutos ?? 60 }} min
                                </span>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                    <i class="bi bi-hourglass-split me-1"></i> Pendiente
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button class="btn btn-sm btn-outline-primary rounded-pill btn-ver-detalle"
                                        data-tutoria='@json($tutoria)' 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalDetalleTutoria">
                                    <i class="bi bi-eye"></i> Ver detalles
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Historial de tutorías minimalista -->
<div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-clock-history me-2 text-primary"></i>Historial de tutorías
        </h5>
    </div>
    
    <div class="card-body p-0">
        @php
            $historialTutorias = $alumno->tutorias->where('estado', '!=', 'pendiente')->sortByDesc('fecha');
        @endphp

        @if($historialTutorias->count() > 0)
            @foreach($historialTutorias as $tutoria)
            <div class="border-bottom hover-bg p-4">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="fw-bold">{{ \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y') }}</div>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($tutoria->fecha)->format('l') }}</small>
                    </div>
                    <div class="col-md-4">
                        <div class="fw-semibold">{{ $tutoria->tema ?? 'Sin tema' }}</div>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <i class="bi bi-person-circle text-muted small"></i>
                            <small class="text-muted">{{ $tutoria->tutor->user->name ?? 'No asignado' }}</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-hourglass-split text-muted"></i>
                            <span>{{ $tutoria->duracion_minutos ?? 60 }} min</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        @if($tutoria->calificacion)
                            <div class="text-warning">
                                @for($i = 1; $i <= $tutoria->calificacion; $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor
                                @for($i = $tutoria->calificacion + 1; $i <= 5; $i++)
                                    <i class="bi bi-star"></i>
                                @endfor
                            </div>
                        @else
                            <span class="text-muted">Sin calificar</span>
                        @endif
                    </div>
                    <div class="col-md-1 text-end">
                        <button class="btn btn-sm btn-link text-primary btn-ver-detalle p-0"
                                data-tutoria='@json($tutoria)' 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalDetalleTutoria">
                            <i class="bi bi-chevron-right fs-5"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state m-4">
                <i class="bi bi-inbox display-1 text-muted mb-3 d-block"></i>
                <h5 class="text-muted">No tienes tutorías registradas</h5>
                <p class="text-muted mb-0">Aún no has participado en ninguna sesión de tutoría.</p>
                <a href="{{ route('alumno.solicitar-tutoria') }}" class="btn btn-primary rounded-pill px-4 mt-3">
                    <i class="bi bi-plus-circle me-2"></i>Solicitar primera tutoría
                </a>
            </div>
        @endif
    </div>
</div>

<style>
.hover-bg {
    transition: background-color 0.2s ease;
}

.hover-bg:hover {
    background-color: #f8f9fa;
    cursor: pointer;
}
</style>

    <!-- Modal para ver detalles de la tutoría -->
    <div class="modal fade" id="modalDetalleTutoria" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">

                <!-- Header moderno -->
                <div class="modal-header border-0" style="background: linear-gradient(135deg,#4f46e5,#6366f1); color:white;">
                    <div>
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="bi bi-calendar-check me-2"></i>Detalle de Tutoría
                        </h5>
                        <small class="opacity-75">Información completa de la sesión</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4" id="modalDetalleContent">
                    <!-- Contenido dinámico -->
                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 d-flex justify-content-between">
                    <small class="text-muted">Sistema de Tutorías</small>
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Botones de ver detalle
    document.querySelectorAll('.btn-ver-detalle').forEach(button => {
        button.addEventListener('click', function() {
            const tutoriaData = JSON.parse(this.getAttribute('data-tutoria'));
            const modalContent = document.getElementById('modalDetalleContent');
            
            const fecha = new Date(tutoriaData.fecha);
            const opcionesFecha = { year: 'numeric', month: 'long', day: 'numeric' };
            
            modalContent.innerHTML = `

    <div class="mb-3">

        <div class="mb-4">
            <h5 class="fw-bold text-primary mb-1">${tutoriaData.tema || 'Sin tema'}</h5>
            <span class="badge ${tutoriaData.estado === 'completada' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning'}">
                ${tutoriaData.estado}
            </span>
        </div>

        <div class="row g-3">

            <div class="col-md-6">
                <div class="p-3 rounded-4 bg-light">
                    <small class="text-muted">📅 Fecha</small>
                    <div class="fw-semibold">${fecha.toLocaleDateString('es-ES', opcionesFecha)}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 rounded-4 bg-light">
                    <small class="text-muted">👨‍🏫 Tutor</small>
                    <div class="fw-semibold">${tutoriaData.tutor?.user?.name || 'No asignado'}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 rounded-4 bg-light">
                    <small class="text-muted">⏱ Duración</small>
                    <div class="fw-semibold">${tutoriaData.duracion_minutos || 60} min</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 rounded-4 bg-light">
                    <small class="text-muted">⭐ Calificación</small>
                    <div class="text-warning">
                        ${tutoriaData.calificacion ? Array(5).fill().map((_, i) => 
                            i < tutoriaData.calificacion ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>'
                        ).join('') : '<span class="text-muted">Pendiente</span>'}
                    </div>
                </div>
            </div>

        </div>

        ${tutoriaData.descripcion ? `
            <div class="mt-4">
                <h6 class="fw-semibold text-muted">📄 Descripción</h6>
                <div class="p-3 bg-light rounded-4">${tutoriaData.descripcion}</div>
            </div>
        ` : ''}

        ${tutoriaData.comentarios ? `
            <div class="mt-3">
                <h6 class="fw-semibold text-muted">💬 Comentarios</h6>
                <div class="p-3 bg-light rounded-4">${tutoriaData.comentarios}</div>
            </div>
        ` : ''}

    </div>

`;
        });
    });
});
</script>
@endsection