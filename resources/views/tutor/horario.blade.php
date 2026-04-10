@extends('layouts.tutor')

@section('content')
<div class="container-fluid py-4">

    <!-- Header moderno -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Horarios</h2>
            <small class="text-muted">Vista organizada de tus grupos</small>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-dark btn-sm">
                🖨 Imprimir
            </button>
        </div>
    </div>

    @foreach($grupos as $grupo)

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

    <div class="card mb-4 border-0 shadow-sm rounded-4">

        <div class="card-body">
            <h5 class="fw-semibold mb-3">Grupo {{ $grupo }}</h5>

            <div class="table-responsive">
                <table class="table table-borderless text-center align-middle">

                    <thead>
                        <tr class="text-muted small">
                            <th>Hora</th>
                            <th>Lun</th>
                            <th>Mar</th>
                            <th>Mié</th>
                            <th>Jue</th>
                            <th>Vie</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($horas as $hora)

                        @php
                            $bloques = $horarios->where('grupo', $grupo)->where('hora', $hora);
                        @endphp

                        @if($hora === $horaReceso)
                        <tr class="receso-row">
                            <td class="hora-col small text-muted">{{ $hora }}</td>
                            <td colspan="5">
                                <div class="receso-card">
                                    <div class="receso-text">RECESO</div>
                                </div>
                            </td>
                        </tr>
                        @continue
                        @endif

                        <tr>

                            <td class="fw-semibold small text-muted">
                                {{ $hora }}
                            </td>

                            @foreach(['lunes','martes','miercoles','jueves','viernes'] as $dia)

                            @php
                                $clase = $bloques->firstWhere('dia', $dia);
                            @endphp

                            <td>

                                @if($clase)
                                <div class="clase-card">
                                    <div class="materia">{{ $clase->materia }}</div>
                                    <div class="detalle">{{ $clase->docente }}</div>
                                    <div class="detalle">{{ $clase->aula }}</div>
                                </div>
                                @else
                                <div class="empty">—</div>
                                @endif

                            </td>

                            @endforeach

                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>

    </div>

    @endforeach

</div>

<style>
.clase-card {
    background: #f8fafc;
    border-radius: 10px;
    padding: 8px;
    transition: 0.2s;
}

.clase-card:hover {
    transform: scale(1.03);
}

.materia {
    font-weight: 600;
    font-size: 0.8rem;
}

.detalle {
    font-size: 0.7rem;
    color: #64748b;
}

.empty {
    color: #cbd5f5;
}

.dark-mode .clase-card {
    background: #1e293b;
    color: white;
}

.dark-mode body {
    background: #0f172a;
}

.receso-row td {
    background: transparent;
}

.receso-card {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: linear-gradient(135deg, hsla(123, 32%, 50%, 0.41), rgb(99, 158, 87));
    border-radius: 12px;
    padding: 10px;
}

.receso-icon {
    font-size: 1.2rem;
}

.receso-text {
    font-weight: 600;
}

.receso-sub {
    font-size: 0.7rem;
    color: rgb(11, 11, 11);
}

.dark-mode .receso-card {
    background: hsl(119, 23%, 37%);
    color: rgb(66, 131, 75);
}
</style>

<script>
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
}
</script>

@endsection