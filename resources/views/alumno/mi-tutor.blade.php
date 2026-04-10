@extends('layouts.alumno')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Mi Tutor</h2>
        <span class="badge bg-light text-dark">Información actual</span>
    </div>

    <!-- Card principal -->
    <div class="card border-0 shadow-sm rounded-4 p-4">

        @if($tutor)
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-circle">
                    👨‍🏫
                </div>
                <div>
                    <h4 class="fw-semibold mb-0">{{ $tutor->user->name }}</h4>
                    <p class="text-muted mb-0">{{ $tutor->user->email }}</p>
                </div>
            </div>

            <div class="row mt-4 g-3">

                <div class="col-md-6">
                    <div class="info-box">
                        <div class="label">Estado</div>
                        <div class="value">
                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                ✔ Tutor asignado
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <div class="label">Contacto</div>
                        <div class="value">
                            {{ $tutor->user->email }}
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-4">
                <a href="mailto:{{ $tutor->user->email }}" class="btn btn-primary">
                    ✉️ Enviar correo
                </a>
            </div>

        @else
            <div class="text-center py-5">
                <div class="mb-3" style="font-size: 40px;">😕</div>
                <h5 class="fw-semibold">Sin tutor asignado</h5>
                <p class="text-muted">Aún no tienes un tutor asignado. Contacta con coordinación.</p>
            </div>
        @endif

    </div>

</div>

<style>
.avatar-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

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
}

.card {
    transition: all 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}
</style>

@endsection