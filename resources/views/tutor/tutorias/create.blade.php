

@extends('layouts.tutor')

@section('content')
<div class="container">

    <h2 class="mb-4">Registrar tutoría</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('tutor.tutorias.store') }}" method="POST">
                @csrf

                <input type="hidden" name="alumno_id" value="{{ $alumno }}">

                <div class="mb-3">
                    <label class="form-label">Tema</label>
                    <input type="text" name="tema" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="4" required></textarea>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('tutor.dashboard') }}" class="btn btn-secondary">
                        ← Cancelar
                    </a>

                    <button type="submit" class="btn btn-success">
                        Guardar tutoría
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection