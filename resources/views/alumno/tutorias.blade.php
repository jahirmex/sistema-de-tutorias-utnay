@extends('layouts.alumno')

@section('content')
<div class="container py-4">

    <div class="mb-5">
        <div class="d-flex align-items-center gap-3 mb-2">
            <div class="bg-primary bg-opacity-10 p-3 rounded-4">
                <i class="bi bi-calendar-check fs-2 text-primary"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-0 display-6">Mis Tutorías</h2>
                <p class="text-muted mb-0 mt-1">Consulta el estado y detalle de tus sesiones</p>
            </div>
        </div>
    </div>

    @if($tutorias->isEmpty())
        <div class="text-center py-5">
            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px;">
                <i class="bi bi-inbox fs-1 text-muted"></i>
            </div>
            <h5 class="fw-semibold mt-3">Sin tutorías aún</h5>
            <p class="text-muted">Cuando solicites tutorías aparecerán aquí.</p>
            <button class="btn btn-primary mt-2 rounded-pill px-4">
                <i class="bi bi-plus-circle me-2"></i>Solicitar Tutoría
            </button>
        </div>
    @else
        <div class="timeline">
            @foreach($tutorias->sortByDesc('fecha') as $tutoria)
                <div class="timeline-item">
                    <div class="timeline-dot-wrapper">
                        <div class="timeline-dot 
                            {{ $tutoria->estado === 'completada' ? 'bg-success' : 'bg-warning' }}">
                            @if($tutoria->estado === 'completada')
                                <i class="bi bi-check-lg text-white" style="font-size: 10px;"></i>
                            @else
                                <i class="bi bi-clock text-white" style="font-size: 10px;"></i>
                            @endif
                        </div>
                    </div>

                    <div class="timeline-content card border-0 shadow-sm rounded-4 p-4">
                        <div class="row align-items-start g-3">
                            <div class="col-md-8">
                                <div class="d-flex flex-wrap align-items-start gap-2 mb-3">
                                    <h5 class="fw-bold mb-0">{{ $tutoria->tema }}</h5>
                                    @if($tutoria->estado === 'completada')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                            <i class="bi bi-check-circle-fill me-1"></i> Completada
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 rounded-pill">
                                            <i class="bi bi-hourglass-split me-1"></i> Pendiente
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="text-secondary mb-3">{{ $tutoria->descripcion }}</p>
                                
                                <div class="d-flex flex-wrap gap-3 small">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="bi bi-calendar3 me-2"></i>
                                        <span data-bs-toggle="tooltip" title="Fecha programada">
                                            {{ \Carbon\Carbon::parse($tutoria->fecha)->format('d M Y') }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="bi bi-clock me-2"></i>
                                        <span>{{ \Carbon\Carbon::parse($tutoria->fecha)->format('h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 text-md-end">
                                @if($tutoria->estado === 'pendiente')
                                    <button class="btn btn-outline-primary rounded-pill btn-sm px-3">
                                        <i class="bi bi-chat-dots me-1"></i> Detalles
                                    </button>
                                @else
                                    <div class="text-success small">
                                        <i class="bi bi-star-fill me-1"></i> Sesión completada
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 20px;
    bottom: 20px;
    width: 2px;
    background: linear-gradient(180deg, #e5e7eb 0%, #e5e7eb 80%, transparent 100%);
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
    animation: slideIn 0.4s ease-out forwards;
    opacity: 0;
}

/* Animación escalonada para cada elemento */
.timeline-item:nth-child(1) { animation-delay: 0.05s; }
.timeline-item:nth-child(2) { animation-delay: 0.10s; }
.timeline-item:nth-child(3) { animation-delay: 0.15s; }
.timeline-item:nth-child(4) { animation-delay: 0.20s; }
.timeline-item:nth-child(5) { animation-delay: 0.25s; }
.timeline-item:nth-child(6) { animation-delay: 0.30s; }
.timeline-item:nth-child(7) { animation-delay: 0.35s; }
.timeline-item:nth-child(8) { animation-delay: 0.40s; }
.timeline-item:nth-child(9) { animation-delay: 0.45s; }
.timeline-item:nth-child(10) { animation-delay: 0.50s; }

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.timeline-dot-wrapper {
    position: absolute;
    left: -22px;
    top: 20px;
    z-index: 2;
}

.timeline-dot {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
}

.timeline-dot:hover {
    transform: scale(1.1);
}

.timeline-content {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 1px solid rgba(0,0,0,0.05);
}

.timeline-content:hover {
    transform: translateX(8px) translateY(-2px);
    box-shadow: 0 20px 30px -12px rgba(0,0,0,0.15);
}

/* Badge custom styles */
.bg-success-subtle {
    background-color: #d1fae5;
}

.bg-warning-subtle {
    background-color: #fed7aa;
}

/* Responsive */
@media (max-width: 768px) {
    .timeline {
        padding-left: 20px;
    }
    
    .timeline-dot-wrapper {
        left: -18px;
    }
    
    .timeline-dot {
        width: 28px;
        height: 28px;
    }
    
    .timeline-content:hover {
        transform: translateX(4px) translateY(-2px);
    }
}
</style>

<script>
// Inicializar tooltips si usas Bootstrap 5
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>
@endsection