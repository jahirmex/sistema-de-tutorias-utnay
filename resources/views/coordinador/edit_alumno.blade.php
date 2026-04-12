@extends('layouts.coordinador')

@section('content')

<div class="container py-4">

    <h2 class="mb-4 fw-semibold fade-in">Editar Alumno</h2>

    <div class="card border-0 shadow-sm rounded-4 fade-in">
        <div class="card-body">

            <form method="POST" action="{{ route('alumnos.update', $alumno->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" name="nombre" class="form-control rounded-3"
                               value="{{ $alumno->user->name }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Correo</label>
                        <input type="email" name="correo" class="form-control rounded-3"
                               value="{{ $alumno->user->email }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Matrícula</label>
                        <input type="text" name="matricula" class="form-control rounded-3"
                               value="{{ $alumno->matricula }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Carrera</label>
                        <input type="text" name="carrera" class="form-control rounded-3"
                               value="{{ $alumno->carrera }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Cuatrimestre</label>
                        <input type="number" name="cuatrimestre" class="form-control rounded-3"
                               value="{{ $alumno->cuatrimestre }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Grupo</label>
                        <select name="grupo_id" class="form-select rounded-3">
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}"
                                    {{ $alumno->grupo_id == $grupo->id ? 'selected' : '' }}>
                                    {{ $grupo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="mt-4 d-flex justify-content-between">

                    <a href="{{ route('coordinador.alumnos') }}" class="btn btn-outline-secondary rounded-3">
                        ← Volver
                    </a>

                    <button type="submit" class="btn btn-primary rounded-3 px-4">
                        Actualizar Alumno
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Éxito',
    text: '{{ session('success') }}',
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: '{{ session('error') }}',
});
</script>
@endif

@endsection