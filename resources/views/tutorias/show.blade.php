@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-semibold mb-1 text-dark">
                <i class="bi bi-journal-bookmark-fill me-2 text-primary"></i>Detalle de Tutoría
            </h2>
            <p class="text-muted small mb-0">Información completa de la sesión de tutoría</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-3 btn-sm">
                <i class="bi bi-printer me-1"></i> Imprimir
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Información principal -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom px-4 py-3" style="border-radius: 16px 16px 0 0;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5 class="fw-semibold mb-0">
                            <i class="bi bi-info-circle me-2 text-primary"></i>Información de la Tutoría
                        </h5>
                        @if($tutoria->estado === 'completada')
                            <span class="badge-estado completada">
                                <i class="bi bi-check-circle-fill me-1"></i> Completada
                            </span>
                        @else
                            <span class="badge-estado pendiente">
                                <i class="bi bi-clock-fill me-1"></i> Pendiente
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <!-- Tema -->
                    <div class="detail-section">
                        <div class="detail-icon bg-primary bg-opacity-10">
                            <i class="bi bi-book-fill text-primary"></i>
                        </div>
                        <div class="detail-content">
                            <small class="text-muted text-uppercase fw-semibold">Tema</small>
                            <h4 class="fw-bold mb-0">{{ $tutoria->tema ?? 'Sin tema' }}</h4>
                        </div>
                    </div>

                    <!-- Fecha -->
                    <div class="detail-section">
                        <div class="detail-icon bg-success bg-opacity-10">
                            <i class="bi bi-calendar-check-fill text-success"></i>
                        </div>
                        <div class="detail-content">
                            <small class="text-muted text-uppercase fw-semibold">Fecha y hora</small>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold fs-5">
                                    {{ \Carbon\Carbon::parse($tutoria->fecha)->translatedFormat('l, d \\d\\e F \\d\\e Y') }}
                                </span>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($tutoria->fecha)->format('h:i A') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Tutor -->
                    <div class="detail-section">
                        <div class="detail-icon bg-info bg-opacity-10">
                            <i class="bi bi-person-badge-fill text-info"></i>
                        </div>
                        <div class="detail-content">
                            <small class="text-muted text-uppercase fw-semibold">Tutor responsable</small>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-tutor">
                                    {{ strtoupper(substr($tutoria->tutor->user->name ?? 'T', 0, 2)) }}
                                </div>
                                <span class="fw-semibold fs-5">
                                    {{ $tutoria->tutor->user->name ?? 'No asignado' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen rápido -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom px-4 py-3" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-speedometer2 me-2 text-primary"></i>Resumen
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="info-list">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-hash me-2 text-primary"></i>ID de tutoría
                            </div>
                            <div class="info-value">
                                <code>#{{ $tutoria->id }}</code>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-calendar-range me-2 text-primary"></i>Registrada
                            </div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($tutoria->created_at)->diffForHumans() }}
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-clock-history me-2 text-primary"></i>Última actualización
                            </div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($tutoria->updated_at)->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descripción -->
        @if(!empty($tutoria->descripcion))
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom px-4 py-3" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-file-text-fill me-2 text-primary"></i>Descripción
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="description-content">
                        <i class="bi bi-quote quote-icon"></i>
                        <p class="mb-0 fs-5">{{ $tutoria->descripcion }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Comentarios -->
        @if(!empty($tutoria->comentarios))
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom px-4 py-3" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-chat-dots-fill me-2 text-primary"></i>Comentarios adicionales
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="comment-content">
                        <div class="comment-avatar">
                            <i class="bi bi-person-circle fs-2 text-muted"></i>
                        </div>
                        <div class="comment-text">
                            <p class="mb-0">{{ $tutoria->comentarios }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Botones de acción -->
        <div class="col-12">
            <div class="d-flex gap-3 justify-content-between flex-wrap">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                    <i class="bi bi-arrow-left me-2"></i>Volver
                </a>
                <div class="d-flex gap-2">
                    @if($tutoria->estado !== 'completada')
                    <button class="btn btn-success rounded-pill px-4 py-2" onclick="marcarCompletada({{ $tutoria->id }})">
                        <i class="bi bi-check-circle me-2"></i>Marcar como completada
                    </button>
                    @endif
                    <button class="btn btn-primary rounded-pill px-4 py-2" onclick="window.print()">
                        <i class="bi bi-printer me-2"></i>Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Detail sections */
.detail-section {
    display: flex;
    gap: 20px;
    padding: 20px 0;
    border-bottom: 1px solid #e9ecef;
}

.detail-section:last-child {
    border-bottom: none;
}

.detail-icon {
    width: 55px;
    height: 55px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.detail-content {
    flex: 1;
}

.detail-content h4 {
    color: #1e293b;
}

/* Badges estado */
.badge-estado {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-estado.completada {
    background: #d1fae5;
    color: #065f46;
}

.badge-estado.pendiente {
    background: #fed7aa;
    color: #92400e;
}

/* Avatar tutor */
.avatar-tutor {
    width: 45px;
    height: 45px;
    border-radius: 14px;
    background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 16px;
    text-transform: uppercase;
}

/* Info list */
.info-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 12px;
    border-bottom: 1px solid #e9ecef;
}

.info-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-label {
    font-size: 0.8rem;
    color: #6c757d;
    display: flex;
    align-items: center;
}

.info-value {
    font-weight: 600;
    font-size: 0.9rem;
    color: #212529;
}

.info-value code {
    background: #f1f5f9;
    padding: 4px 8px;
    border-radius: 8px;
    font-size: 0.8rem;
}

/* Descripción */
.description-content {
    position: relative;
    padding: 20px;
    background: #f8fafc;
    border-radius: 16px;
}

.quote-icon {
    position: absolute;
    top: 15px;
    left: 15px;
    font-size: 2rem;
    color: #cbd5e1;
    opacity: 0.5;
}

.description-content p {
    padding-left: 30px;
    line-height: 1.6;
}

/* Comentarios */
.comment-content {
    display: flex;
    gap: 15px;
    padding: 20px;
    background: #f8fafc;
    border-radius: 16px;
}

.comment-avatar {
    flex-shrink: 0;
}

.comment-text {
    flex: 1;
    line-height: 1.6;
}

/* Dark mode */
.dark-mode {
    background-color: #0f172a !important;
    color: #e2e8f0 !important;
}

.dark-mode .card,
.dark-mode .card-header {
    background-color: #1e293b !important;
    border-color: #334155 !important;
}

.dark-mode .detail-section {
    border-bottom-color: #334155;
}

.dark-mode .detail-content h4 {
    color: #e2e8f0;
}

.dark-mode .description-content,
.dark-mode .comment-content {
    background: #334155;
}

.dark-mode .quote-icon {
    color: #64748b;
}

.dark-mode .info-item {
    border-bottom-color: #334155;
}

.dark-mode .info-label {
    color: #94a3b8;
}

.dark-mode .info-value {
    color: #e2e8f0;
}

.dark-mode .info-value code {
    background: #475569;
    color: #e2e8f0;
}

.dark-mode .badge-estado.completada {
    background: #064e3b;
    color: #6ee7b7;
}

.dark-mode .badge-estado.pendiente {
    background: #78350f;
    color: #fcd34d;
}

.dark-mode .text-muted {
    color: #94a3b8 !important;
}

.dark-mode .btn-outline-secondary {
    border-color: #475569;
    color: #94a3b8;
}

.dark-mode .btn-outline-secondary:hover {
    background-color: #334155;
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .detail-section {
        flex-direction: column;
        gap: 12px;
    }
    
    .detail-icon {
        width: 45px;
        height: 45px;
    }
    
    .avatar-tutor {
        width: 35px;
        height: 35px;
        font-size: 12px;
    }
    
    .detail-content h4 {
        font-size: 1.2rem;
    }
    
    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .description-content p {
        font-size: 0.9rem;
    }
}

/* Animación */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeIn 0.3s ease-out;
}

/* Impresión */
@media print {
    .btn-outline-secondary,
    #darkModeBtn,
    .btn-primary,
    .btn-success {
        display: none !important;
    }
    
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
    
    .badge-estado {
        print-color-adjust: exact;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Marcar como completada
function marcarCompletada(id) {
    Swal.fire({
        title: '¿Completar tutoría?',
        text: 'Esta acción marcará la tutoría como completada.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-check-circle me-1"></i>Sí, completar',
        cancelButtonText: '<i class="bi bi-x-circle me-1"></i>Cancelar',
        customClass: {
            popup: 'rounded-3'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí iría la llamada AJAX para actualizar el estado
            Swal.fire({
                title: '¡Completada!',
                text: 'La tutoría ha sido marcada como completada.',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#198754'
            }).then(() => {
                location.reload();
            });
        }
    });
}

// Dark mode toggle
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    const isDark = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDark);
    
    const btn = document.getElementById('darkModeBtn');
    if (btn) {
        btn.innerHTML = isDark ? '<i class="bi bi-sun me-1"></i> Modo claro' : '<i class="bi bi-moon-stars me-1"></i> Modo oscuro';
    }
}

// Verificar dark mode
if (localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark-mode');
    const btn = document.getElementById('darkModeBtn');
    if (btn) {
        btn.innerHTML = '<i class="bi bi-sun me-1"></i> Modo claro';
    }
}
</script>
@endsection