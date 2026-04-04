<h1>Crear Alumno</h1>

<form method="POST" action="/coordinador/alumnos">
    @csrf

    <input type="text" name="nombre" placeholder="Nombre"><br>
    <input type="email" name="correo" placeholder="Correo"><br>
    <input type="text" name="matricula" placeholder="Matrícula"><br>
    <input type="text" name="carrera" placeholder="Carrera"><br>
    <input type="number" name="cuatrimestre" placeholder="Cuatrimestre"><br>
    <select name="grupo_id" required>
        <option value="" disabled selected>Selecciona un grupo</option>
        @foreach($grupos as $grupo)
            <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
        @endforeach
    </select><br>

    <button type="submit">Guardar</button>
</form>