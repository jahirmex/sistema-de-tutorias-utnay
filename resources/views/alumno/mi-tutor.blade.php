@extends('layouts.alumno')

@section('content')
<div class="container py-4">

    <!-- Header mejorado -->
    <div class="mb-5">
        <div class="d-flex align-items-center gap-3 mb-2">
            <div class="bg-primary bg-opacity-10 p-3 rounded-4">
                <i class="bi bi-person-badge fs-2 text-primary"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-0 display-6">Mi Tutor</h2>
                <p class="text-muted mb-0 mt-1">Consulta la información de tu tutor asignado</p>
            </div>
        </div>
    </div>

    @if($tutor)
        <!-- Dashboard resumen mejorado -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100 stat-card">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-2">
                            <i class="bi bi-person-circle text-primary"></i>
                        </div>
                        <span class="badge bg-success-subtle text-success rounded-pill">Activo</span>
                    </div>
                    <h6 class="text-muted mb-1">Mi Tutor</h6>
                    <h4 class="fw-bold mb-0">{{ $tutor->user->name ?? 'Sin asignar' }}</h4>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100 stat-card">
                    <div class="stat-icon bg-info bg-opacity-10 rounded-circle p-2 mb-2">
                        <i class="bi bi-journal-bookmark-fill text-info"></i>
                    </div>
                    <h6 class="text-muted mb-1">Total Tutorías</h6>
                    <h4 class="fw-bold mb-0">{{ isset($tutorias) ? $tutorias->count() : 0 }}</h4>
                    <small class="text-muted mt-1">Sesiones realizadas</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 h-100 stat-card">
                    <div class="stat-icon bg-success bg-opacity-10 rounded-circle p-2 mb-2">
                        <i class="bi bi-calendar-check text-success"></i>
                    </div>
                    <h6 class="text-muted mb-1">Próxima Tutoría</h6>
                    <h4 class="fw-bold mb-0">
                        @php
                            $proxima = isset($tutorias) ? $tutorias->where('estado', 'pendiente')->sortBy('fecha')->first() : null;
                        @endphp
                        @if($proxima)
                            {{ \Carbon\Carbon::parse($proxima->fecha)->format('d M') }}
                        @else
                            —
                        @endif
                    </h4>
                    <small class="text-muted mt-1">
                        @if($proxima)
                            {{ \Carbon\Carbon::parse($proxima->fecha)->format('h:i A') }}
                        @else
                            Sin sesiones agendadas
                        @endif
                    </small>
                </div>
            </div>
        </div>

        <!-- Card principal mejorado -->
        <div class="card border-0 shadow-lg rounded-4 p-4 tutor-card mb-5">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="d-flex align-items-center gap-4 mb-4 mb-md-0">
                        <div class="avatar-circle gradient-bg text-white">
                            {{ strtoupper(substr($tutor->user->name, 0, 2)) }}
                        </div>
                        <div>
                            <h3 class="fw-bold mb-1">{{ $tutor->user->name }}</h3>
                            <p class="text-muted mb-2">
                                <i class="bi bi-envelope me-2"></i>{{ $tutor->user->email }}
                            </p>
                            <div class="d-flex gap-2">
                                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                    <i class="bi bi-mortarboard-fill me-1"></i> Tutor Académico
                                </span>
                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                    <i class="bi bi-clock-history me-1"></i> 10+ años experiencia
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="bg-light rounded-4 p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted">📊 Calificación</small>
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                        </div>
                        <div class="progress mb-2" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 92%"></div>
                        </div>
                        <small class="text-muted">5/5 - 1 reseña</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información detallada -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>Información del Tutor
                    </h6>
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Especialidad:</span>
                            <span class="info-value">Base de datos y creación de video juegos</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Departamento:</span>
                          <span class="info-value text-end">Tecnologías de la información, Inteligencia Artificial y Comunicación</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Oficina:</span>
                            <span class="info-value">Edificio 3 PB</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Teléfono:</span>
                            <span class="info-value">+52 311 232 9611</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h6 class="fw-semibold mb-3">
                        <i class="bi bi-clock-history text-primary me-2"></i>Horario de Atención
                    </h6>
                    <div class="schedule-list">
                        <div class="schedule-item">
                            <span class="schedule-day">Lunes - Miércoles:</span>
                            <span class="schedule-time">9:00 AM - 1:00 PM</span>
                        </div>
                        <div class="schedule-item">
                            <span class="schedule-day">Martes - Jueves:</span>
                            <span class="schedule-time">3:00 PM - 6:00 PM</span>
                        </div>
                        <div class="schedule-item">
                            <span class="schedule-day">Viernes:</span>
                            <span class="schedule-time">10:00 AM - 2:00 PM</span>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3 mb-0 py-2 small">
                        <i class="bi bi-info-circle me-1"></i> Requiere cita previa
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de acción mejorados -->
        <div class="row g-3">
            <div class="col-12">
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-md-start">
                    <a href="mailto:{{ $tutor->user->email }}" class="btn btn-primary rounded-pill px-4 py-2">
                        <i class="bi bi-envelope-paper-fill me-2"></i>Contactar Tutor
                    </a>
                    <a href="/alumno/tutorias" class="btn btn-outline-primary rounded-pill px-4 py-2">
                        <i class="bi bi-journal-text me-2"></i>Mis Tutorías
                    </a>
                    <button class="btn btn-outline-secondary rounded-pill px-4 py-2" data-bs-toggle="modal" data-bs-target="#scheduleModal">
                        <i class="bi bi-calendar-week me-2"></i>Solicitar Cita
                    </button>
                </div>
            </div>
        </div>

    @else
        <!-- Estado sin tutor asignado mejorado -->
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
            <div class="empty-state">
                <div class="empty-state-icon bg-warning bg-opacity-10 rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <i class="bi bi-person-x fs-1 text-warning"></i>
                </div>
                <h4 class="fw-bold mb-3">Sin tutor asignado</h4>
                <p class="text-muted mb-4">Aún no tienes un tutor asignado. Por favor, contacta con el departamento de coordinación académica para solicitar uno.</p>
                <a href="/contacto" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-headset me-2"></i>Contactar Coordinación
                </a>
            </div>
        </div>
    @endif

</div>

<style>
/* Stat Cards */
.stat-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(0,0,0,0.05);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -12px rgba(0,0,0,0.1);
}

.stat-icon i {
    font-size: 1.5rem;
}

/* Avatar Circle */
.avatar-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 2rem;
}

.gradient-bg {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Tutor Card */
.tutor-card {
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
}

.tutor-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 25px 35px -12px rgba(0,0,0,0.15) !important;
}

/* Info List */
.info-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #e5e7eb;
}

.info-label {
    color: #6c757d;
    font-size: 0.9rem;
}

.info-value {
    font-weight: 500;
    color: #1f2937;
}

/* Schedule List */
.schedule-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.schedule-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
}

.schedule-day {
    font-weight: 500;
    color: #374151;
}

.schedule-time {
    color: #059669;
    font-weight: 500;
}

/* Badge custom styles */
.bg-success-subtle {
    background-color: #d1fae5;
}

.bg-primary-subtle {
    background-color: #dbeafe;
}

/* Empty State */
.empty-state {
    animation: fadeInUp 0.5s ease-out;
}

/* Progress bar */
.progress {
    background-color: #e5e7eb;
    border-radius: 10px;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .avatar-circle {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .info-item, .schedule-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .btn {
        width: 100%;
    }
}
</style>

<!-- Modal para solicitar cita (opcional) -->
<div class="modal fade" id="scheduleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Solicitar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Fecha deseada</label>
                        <input type="date" class="form-control rounded-3">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Horario preferido</label>
                        <select class="form-select rounded-3">
                            <option>9:00 - 10:00 AM</option>
                            <option>10:00 - 11:00 AM</option>
                            <option>11:00 - 12:00 PM</option>
                            <option>3:00 - 4:00 PM</option>
                            <option>4:00 - 5:00 PM</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motivo de la cita</label>
                        <textarea class="form-control rounded-3" rows="3" placeholder="Describe brevemente el tema a tratar..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary rounded-pill px-4">Enviar Solicitud</button>
            </div>
        </div>
    </div>
</div>

@endsection