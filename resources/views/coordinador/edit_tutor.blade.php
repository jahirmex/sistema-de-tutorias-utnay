@extends('layouts.coordinador')

@section('content')

<div class="container py-4">

    <h2 class="mb-4 fw-semibold">Editar Tutor</h2>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">

            <form method="POST" action="/coordinador/tutores/{{ $tutor->id }}">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" name="nombre" class="form-control"
                            value="{{ $tutor->user->name }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Correo</label>
                        <input type="email" name="correo" class="form-control"
                            value="{{ $tutor->user->email }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Área</label>
                        <input type="text" name="area" class="form-control"
                            value="{{ $tutor->area }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Grupos asignados</label>
                        <select name="grupos[]" class="form-select" multiple size="5">
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}"
                                    {{ $grupo->tutor_id == $tutor->id ? 'selected' : '' }}>
                                    {{ $grupo->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Mantén presionada la tecla Ctrl (o Cmd en Mac) para seleccionar varios grupos</small>
                    </div>

                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary rounded-3 px-4">
                        Actualizar
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection