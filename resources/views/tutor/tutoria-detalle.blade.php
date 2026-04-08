@extends('layouts.tutor')

@section('title', 'Detalle de Tutoría')

@section('content')
<div class="container-fluid px-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-info-circle me-2 text-primary"></i>Detalle de Tutoría
            </h2>
            <p class="text-muted">Información completa de la sesión de tutoría</p>
        </div>
        <a href="{{ route('tutor.tutorias') }}" class="btn btn-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Volver a tutorías
        </a>
    </div>

    <div class="row">
        <!-- Información principal -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-calendar-check me-2 text-primary"></i>Información de la sesión
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-calendar3 text-primary fs-5"></i>
                                </div>
                                <div>
                                    <label class="text-muted small text-uppercase fw-semibold">Fecha</label>
                                    <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($tutoria->fecha)->translatedFormat('j \d\e F, Y') }}</p>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($tutoria->fecha)->format('l') }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-success bg-opacity-10 rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-clock text-success fs-5"></i>
                                </div>
                                <div>
                                    <label class="text-muted small text-uppercase fw-semibold">Horario</label>
                                    <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($tutoria->fecha)->format('h:i A') }}</p>
                                    <small class="text-muted">Duración: {{ $tutoria->duracion_minutos ?? 60 }} minutos</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-info bg-opacity-10 rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-person text-info fs-5"></i>
                                </div>
                                <div>
                                    <label class="text-muted small text-uppercase fw-semibold">Alumno</label>
                                    <p class="fw-semibold mb-0">{{ $tutoria->alumno->user->name ?? 'Sin nombre' }}</p>
                                    <small class="text-muted">Matrícula: {{ $tutoria->alumno->matricula ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-people text-warning fs-5"></i>
                                </div>
                                <div>
                                    <label class="text-muted small text-uppercase fw-semibold">Grupo</label>
                                    <p class="fw-semibold mb-0">{{ $tutoria->alumno->grupo->nombre ?? 'Sin grupo' }}</p>
                                    <small class="text-muted">Carrera: {{ $tutoria->alumno->carrera ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tema y descripción -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-book me-2 text-primary"></i>Tema de la tutoría
                    </h5>
                </div>
                <div class="card-body p-4">
                    <h6 class="fw-semibold mb-2">{{ $tutoria->tema ?? 'Sin tema específico' }}</h6>
                    @if($tutoria->descripcion)
                        <p class="text-muted mb-0">{{ $tutoria->descripcion }}</p>
                    @else
                        <p class="text-muted mb-0">No se proporcionó una descripción detallada.</p>
                    @endif
                </div>
            </div>
            
            <!-- Comentarios y calificación -->
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-chat-dots me-2 text-primary"></i>Retroalimentación
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($tutoria->comentarios)
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase fw-semibold">Comentarios</label>
                            <div class="bg-light rounded-3 p-3 mt-2">
                                <p class="mb-0">{{ $tutoria->comentarios }}</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-chat-quote display-6 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">No hay comentarios registrados para esta tutoría.</p>
                        </div>
                    @endif
                    
                    @if($tutoria->calificacion)
                        <div class="mt-3">
                            <label class="text-muted small text-uppercase fw-semibold">Calificación</label>
                            <div class="mt-2">
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $tutoria->calificacion)
                                            <i class="bi bi-star-fill fs-4"></i>
                                        @else
                                            <i class="bi bi-star fs-4"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-2 fw-semibold">{{ $tutoria->calificacion }}/5</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Barra lateral -->
        <div class="col-lg-4">
            <!-- Estado -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-info-circle me-2 text-primary"></i>Estado
                    </h5>
                </div>
                <div class="card-body p-4 text-center">
                    @if($tutoria->estado == 'completada')
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-check-circle-fill text-success fs-1"></i>
                            <h5 class="fw-bold text-success mt-2 mb-0">Completada</h5>
                            <small class="text-muted">Tutoría finalizada exitosamente</small>
                        </div>
                    @elseif($tutoria->estado == 'pendiente')
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-hourglass-split text-warning fs-1"></i>
                            <h5 class="fw-bold text-warning mt-2 mb-0">Pendiente</h5>
                            <small class="text-muted">Esperando realización</small>
                        </div>
                        @if($tutoria->fecha >= now())
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-calendar-check me-1"></i>
                                    Próxima a realizarse
                                </small>
                            </div>
                        @endif
                    @elseif($tutoria->estado == 'cancelada')
                        <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-x-circle-fill text-danger fs-1"></i>
                            <h5 class="fw-bold text-danger mt-2 mb-0">Cancelada</h5>
                            <small class="text-muted">Tutoría cancelada</small>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Acciones -->
            @if($tutoria->estado == 'pendiente')
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-gear me-2 text-primary"></i>Acciones
                    </h5>
                </div>
                <div class="card-body p-4">
                    <button type="button" 
                            class="btn btn-success w-100 rounded-pill py-2 mb-2"
                            data-bs-toggle="modal" 
                            data-bs-target="#modalCompletarTutoria">
                        <i class="bi bi-check-lg me-2"></i>Marcar como completada
                    </button>
                    <button type="button" 
                            class="btn btn-outline-danger w-100 rounded-pill py-2"
                            data-bs-toggle="modal" 
                            data-bs-target="#modalCancelarTutoria">
                        <i class="bi bi-x-lg me-2"></i>Cancelar tutoría
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para completar tutoría -->
<div class="modal fade" id="modalCompletarTutoria" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-success text-white border-0" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-check-circle-fill me-2"></i>Completar tutoría
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('tutor.tutoria.completar', $tutoria->id) }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alumno</label>
                        <input type="text" class="form-control rounded-pill" value="{{ $tutoria->alumno->user->name ?? 'Sin nombre' }}" readonly disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Comentarios</label>
                        <textarea name="comentarios" class="form-control rounded-3" rows="3" placeholder="Agrega observaciones sobre la tutoría..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Calificación (1-5)</label>
                        <select name="calificacion" class="form-select rounded-pill">
                            <option value="">Sin calificar</option>
                            <option value="1">⭐ 1 - Muy deficiente</option>
                            <option value="2">⭐⭐ 2 - Deficiente</option>
                            <option value="3">⭐⭐⭐ 3 - Aceptable</option>
                            <option value="4">⭐⭐⭐⭐ 4 - Bueno</option>
                            <option value="5">⭐⭐⭐⭐⭐ 5 - Excelente</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="bi bi-check-lg me-2"></i>Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para cancelar tutoría -->
<div class="modal fade" id="modalCancelarTutoria" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header bg-danger text-white border-0" style="border-radius: 20px 20px 0 0;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Cancelar tutoría
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('tutor.tutoria.cancelar', $tutoria->id) }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="text-center mb-3">
                        <i class="bi bi-question-circle display-1 text-warning"></i>
                    </div>
                    <p class="text-center mb-3">
                        ¿Estás seguro de que deseas cancelar esta tutoría con 
                        <strong>{{ $tutoria->alumno->user->name ?? 'el alumno' }}</strong>?
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Motivo de cancelación</label>
                        <textarea name="motivo_cancelacion" class="form-control rounded-3" rows="3" placeholder="¿Por qué se cancela esta tutoría?" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Volver</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        <i class="bi bi-x-lg me-2"></i>Sí, cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Listo!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end'
        });
    @endif
    
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc2626'
        });
    @endif
});
</script>

@endsection