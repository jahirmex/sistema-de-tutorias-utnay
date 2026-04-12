@extends('layouts.tutor')

@section('content')
<div class="container-fluid px-4 py-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-semibold mb-1 text-dark">
                <i class="bi bi-calendar-week me-2 text-primary"></i>Horarios de Clases
            </h2>
            <p class="text-muted small mb-0">Visualiza los horarios organizados por grupo</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-3 btn-sm">
                <i class="bi bi-printer me-1"></i> Imprimir
            </button>
        </div>
    </div>

    @foreach($grupos as $index => $grupo)
    @php
        $horaReceso = '16:40 - 17:00';

        $horas = $horarios
            ->where('grupo', $grupo)
            ->pluck('hora')
            ->push($horaReceso)
            ->unique()
            ->filter(function($hora){
                return strtotime(trim(explode('-', $hora)[0])) >= strtotime('13:00');
            })
            ->sortBy(function($hora){
                return strtotime(trim(explode('-', $hora)[0]));
            })
            ->values();
    @endphp

    <div class="card mb-4 border-0 shadow-sm hover-card" style="border-radius: 16px; overflow: hidden;">
        <!-- Header del grupo -->
        <div class="card-header bg-white border-bottom px-4 py-3" style="border-radius: 16px 16px 0 0;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-people-fill me-2 text-primary"></i>Grupo {{ $grupo }}
                    </h5>
                    <small class="text-muted">
                        <i class="bi bi-calendar-range me-1"></i>Horario vespertino
                    </small>
                </div>
                <div class="d-flex gap-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                        <i class="bi bi-clock me-1"></i>{{ $horas->count() - 1 }} horas
                    </span>
                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                        <i class="bi bi-book me-1"></i>{{ $horarios->where('grupo', $grupo)->pluck('materia')->unique()->count() }} materias
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table horario-table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="col-hora">
                                <i class="bi bi-clock me-1 text-primary"></i> Hora
                            </th>
                            <th>
                                <i class="bi bi-calendar-day me-1 text-primary"></i> Lunes
                            </th>
                            <th>
                                <i class="bi bi-calendar-day me-1 text-primary"></i> Martes
                            </th>
                            <th>
                                <i class="bi bi-calendar-day me-1 text-primary"></i> Miércoles
                            </th>
                            <th>
                                <i class="bi bi-calendar-day me-1 text-primary"></i> Jueves
                            </th>
                            <th>
                                <i class="bi bi-calendar-day me-1 text-primary"></i> Viernes
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($horas as $hora)
                        @php
                            $bloques = $horarios->where('grupo', $grupo)->where('hora', $hora);
                        @endphp

                        @if($hora === $horaReceso)
                        <tr class="receso-row">
                            <td class="hora-cell">
                                <div class="hora-time">
                                    <span class="hora-inicio">{{ explode('-', $hora)[0] }}</span>
                                    <span class="hora-fin">{{ explode('-', $hora)[1] ?? '' }}</span>
                                </div>
                            </td>
                            <td colspan="5">
                                <div class="receso-card">
                                    <i class="bi bi-cup-hot-fill receso-icon"></i>
                                    <div>
                                        <span class="receso-text">RECESO</span>
                                        <small class="receso-sub d-block">{{ $hora }}</small>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @continue
                        @endif

                        <tr>
                            <td class="hora-cell">
                                <div class="hora-time">
                                    @php
                                        $partes = explode('-', $hora);
                                    @endphp
                                    <span class="hora-inicio">{{ trim($partes[0]) }}</span>
                                    <span class="hora-fin">{{ trim($partes[1] ?? '') }}</span>
                                </div>
                            </td>

                            @foreach(['lunes','martes','miercoles','jueves','viernes'] as $dia)
                            @php
                                $clase = $bloques->firstWhere('dia', $dia);
                                $colorClass = $clase ? 'materia-' . ($clase->id % 5 + 1) : '';
                            @endphp
                            <td class="clase-cell">
                                @if($clase)
                                <div class="clase-card {{ $colorClass }}" onclick="verDetalleMateria('{{ $clase->materia }}', '{{ $clase->docente }}', '{{ $clase->aula }}')">
                                    <div class="clase-materia">
                                        <i class="bi bi-book-fill me-1"></i>{{ $clase->materia }}
                                    </div>
                                    <div class="clase-docente">
                                        <i class="bi bi-person-badge me-1"></i>{{ $clase->docente }}
                                    </div>
                                    <div class="clase-aula">
                                        <i class="bi bi-door-closed me-1"></i>{{ $clase->aula }}
                                    </div>
                                </div>
                                @else
                                <div class="clase-vacia">
                                    <i class="bi bi-dash-circle"></i>
                                </div>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top py-2 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Horario vespertino - Clases de 13:00 a 17:00
                </small>
                <small class="text-muted">
                    <i class="bi bi-building me-1"></i>
                    Actualizado: {{ now()->format('d/m/Y') }}
                </small>
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
/* Tabla de horarios */
.horario-table {
    width: 100%;
    border-collapse: collapse;
}

.horario-table thead th {
    background: #f8f9fa;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 8px;
    text-align: center;
    border-bottom: 2px solid #e2e8f0;
    color: #475569;
}

.horario-table tbody td {
    padding: 12px 8px;
    vertical-align: middle;
    border-bottom: 1px solid #e9ecef;
}

/* Celda de hora */
.hora-cell {
    background: #fefce8;
    text-align: center;
    vertical-align: middle;
    width: 100px;
}

.hora-time {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.hora-inicio {
    font-weight: 700;
    font-size: 0.9rem;
    color: #854d0e;
}

.hora-fin {
    font-size: 0.7rem;
    color: #a16207;
}

/* Tarjeta de clase */
.clase-card {
    padding: 10px 8px;
    border-radius: 12px;
    text-align: center;
    transition: all 0.2s ease;
    cursor: pointer;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

.clase-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.clase-materia {
    font-weight: 700;
    font-size: 0.8rem;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}

.clase-docente {
    font-size: 0.7rem;
    color: #555;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}

.clase-aula {
    font-size: 0.65rem;
    color: #777;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}

/* Colores para materias */
.materia-1 { background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%); color: #3730a3; }
.materia-2 { background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); color: #166534; }
.materia-3 { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #92400e; }
.materia-4 { background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%); color: #9d174d; }
.materia-5 { background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%); color: #5b21b6; }

/* Clase vacía */
.clase-vacia {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 70px;
    color: #cbd5e1;
}

/* Receso */
.receso-row td {
    padding: 8px;
}

.receso-card {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    border-radius: 12px;
    padding: 10px;
    color: #065f46;
}

.receso-icon {
    font-size: 1.3rem;
}

.receso-text {
    font-weight: 700;
    font-size: 0.9rem;
}

.receso-sub {
    font-size: 0.65rem;
    color: #047857;
}

/* Hover card */
.hover-card {
    transition: all 0.2s ease;
}

.hover-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
}

/* Dark mode */
.dark-mode {
    background-color: #0f172a !important;
    color: #e2e8f0 !important;
}

.dark-mode .card,
.dark-mode .card-header,
.dark-mode .card-footer {
    background-color: #1e293b !important;
    border-color: #334155 !important;
}

.dark-mode .horario-table thead th {
    background-color: #0f3460;
    color: #e2e8f0;
    border-bottom-color: #334155;
}

.dark-mode .horario-table tbody td {
    border-bottom-color: #334155;
}

.dark-mode .hora-cell {
    background: #422006;
}

.dark-mode .hora-inicio {
    color: #fbbf24;
}

.dark-mode .hora-fin {
    color: #fcd34d;
}

.dark-mode .materia-1 {
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
    color: #a5b4fc;
}

.dark-mode .materia-2 {
    background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
    color: #6ee7b7;
}

.dark-mode .materia-3 {
    background: linear-gradient(135deg, #451a03 0%, #78350f 100%);
    color: #fcd34d;
}

.dark-mode .materia-4 {
    background: linear-gradient(135deg, #4c0519 0%, #831843 100%);
    color: #f9a8d4;
}

.dark-mode .materia-5 {
    background: linear-gradient(135deg, #2e1065 0%, #4c1d95 100%);
    color: #c4b5fd;
}

.dark-mode .clase-docente,
.dark-mode .clase-aula {
    color: #cbd5e1;
}

.dark-mode .clase-vacia {
    color: #475569;
}

.dark-mode .receso-card {
    background: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
    color: #6ee7b7;
}

.dark-mode .receso-sub {
    color: #a7f3d0;
}

.dark-mode .text-muted {
    color: #94a3b8 !important;
}

.dark-mode .badge-primary {
    background-color: #1e40af !important;
    color: #60a5fa !important;
}

/* Responsive */
@media (max-width: 768px) {
    .horario-table {
        font-size: 0.7rem;
    }
    
    .horario-table thead th {
        font-size: 0.6rem;
        padding: 8px 4px;
    }
    
    .clase-materia {
        font-size: 0.65rem;
    }
    
    .clase-docente,
    .clase-aula {
        display: none;
    }
    
    .hora-inicio {
        font-size: 0.7rem;
    }
    
    .hora-fin {
        font-size: 0.55rem;
    }
    
    .clase-card {
        padding: 6px 4px;
    }
    
    .receso-text {
        font-size: 0.7rem;
    }
    
    .receso-icon {
        font-size: 1rem;
    }
}

/* Impresión */
@media print {
    .btn-outline-secondary,
    #darkModeBtn {
        display: none !important;
    }
    
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
    
    .clase-card {
        break-inside: avoid;
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
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Ver detalle de materia
function verDetalleMateria(materia, docente, aula) {
    Swal.fire({
        title: materia,
        html: `
            <div class="text-start">
                <div class="mb-2">
                    <i class="bi bi-person-badge me-2 text-primary"></i>
                    <strong>Docente:</strong> ${docente}
                </div>
                <div class="mb-2">
                    <i class="bi bi-door-closed me-2 text-primary"></i>
                    <strong>Aula:</strong> ${aula}
                </div>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Cerrar',
        confirmButtonColor: '#0d6efd',
        customClass: {
            popup: 'rounded-3'
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

// Verificar dark mode al cargar
if (localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark-mode');
    const btn = document.getElementById('darkModeBtn');
    if (btn) {
        btn.innerHTML = '<i class="bi bi-sun me-1"></i> Modo claro';
    }
}
</script>
@endsection