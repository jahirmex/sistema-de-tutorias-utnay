@extends('layouts.alumno')

@section('content')
<div class="container py-4">

    <h2 class="fw-bold mb-4">Mis tutorías</h2>

    @if($tutorias->isEmpty())
        <div class="alert alert-info">
            No tienes tutorías registradas aún.
        </div>
    @else
        <div class="card p-3">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Tema</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tutorias as $tutoria)
                        <tr>
                            <td>{{ $tutoria->tema }}</td>
                            <td>{{ $tutoria->descripcion }}</td>
                            <td>{{ $tutoria->fecha }}</td>
                            <td>
                                @if($tutoria->estado === 'completada')
                                    <span class="badge bg-success">Completada</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection