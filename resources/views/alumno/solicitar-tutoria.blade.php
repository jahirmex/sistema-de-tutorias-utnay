@extends('layouts.alumno')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold">Solicitar tutoría</h2>
        <p class="text-muted mb-0">Completa el formulario para registrar una nueva tutoría</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card p-4">

                <form action="{{ route('alumno.tutorias.store') }}" method="POST">
                    @csrf

                    <!-- Tema -->
                    <div class="mb-3">
                        <label class="form-label">Tema</label>
                        <input type="text" name="tema" class="form-control" placeholder="Ej: Problemas académicos" required>
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" rows="4" class="form-control" placeholder="Describe el motivo de la tutoría" required></textarea>
                    </div>

                    <!-- Fecha -->
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="datetime-local" name="fecha" class="form-control" required>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('alumno.dashboard') }}" class="btn btn-outline-secondary">
                            ← Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Guardar solicitud
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

</div>

<style>
.card {
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.form-control {
    border-radius: 10px;
}

.form-control:focus {
    box-shadow: 0 0 0 2px rgba(59,130,246,0.2);
}

.btn {
    border-radius: 999px;
}
</style>

@endsection