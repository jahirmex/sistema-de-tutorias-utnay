@extends('layouts.tutor')

@section('content')
<div class="container">

    <h2>Editar tutoría</h2>

    <form action="{{ route('tutor.tutorias.update', $tutoria->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Tema</label>
            <input type="text" name="tema" class="form-control" value="{{ $tutoria->tema }}" required>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required>{{ $tutoria->descripcion }}</textarea>
        </div>

        <button class="btn btn-success">Actualizar</button>
    </form>

</div>
@endsection