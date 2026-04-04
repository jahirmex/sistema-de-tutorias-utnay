@extends('layouts.coordinador')

@section('content')
<div class="container">

    <h2 class="mb-4 fw-bold text-dark">👤 Detalle del alumno</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="fw-semibold">{{ $alumno->user->name ?? 'Sin nombre' }}</h4>
            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                {{ $alumno->grupo->nombre ?? '-' }}
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

    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <h5 class="fw-semibold mb-3">📊 Tutorías por mes</h5>
        <canvas id="tutoriasChart"></canvas>
    </div>

    <h4 class="mb-3">📅 Tutorías</h4>

    @if($alumno->tutorias->isEmpty())
        <div class="alert alert-info">
            No hay tutorías registradas.
        </div>
    @else
        @foreach($alumno->tutorias as $tutoria)
            <div class="card mb-3 shadow-sm">
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const tutorias = @json($alumno->tutorias);

    // Agrupar por mes
    const conteo = {};

    tutorias.forEach(t => {
        const fecha = new Date(t.fecha);
        const mes = fecha.toLocaleString('es-MX', { month: 'short', year: 'numeric' });

        conteo[mes] = (conteo[mes] || 0) + 1;
    });

    const sorted = Object.entries(conteo).sort((a, b) => new Date(a[0]) - new Date(b[0]));

    const labels = sorted.map(e => e[0]);
    const data = sorted.map(e => e[1]);

    // acumulado
    let acumulado = [];
    let total = 0;
    data.forEach(v => {
        total += v;
        acumulado.push(total);
    });

    const ctx = document.getElementById('tutoriasChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Tutorías por mes',
                    data: data,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Acumulado',
                    data: acumulado,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.4,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            animation: {
                duration: 1000
            }
        }
    });
</script>
@endsection