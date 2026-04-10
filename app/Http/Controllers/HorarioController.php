<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;

class HorarioController extends Controller
{
    // Mostrar todos los horarios
    public function index()
    {
        $horarios = Horario::orderBy('grupo')
            ->orderBy('dia')
            ->orderBy('hora')
            ->get();

        return view('coordinador.horarios', compact('horarios'));
    }

    // Guardar nuevo horario
    public function store(Request $request)
    {
        $request->validate([
            'grupo' => 'required',
            'dia' => 'required',
            'hora' => 'required',
            'materia' => 'required'
        ]);

        Horario::create($request->all());

        return back()->with('success', 'Horario creado correctamente');
    }

    // Actualizar horario
    public function update(Request $request, $id)
    {
        $horario = Horario::findOrFail($id);

        $horario->update($request->all());

        return back()->with('success', 'Horario actualizado');
    }

    // Eliminar horario
    public function destroy($id)
    {
        $horario = Horario::findOrFail($id);
        $horario->delete();

        return back()->with('success', 'Horario eliminado');
    }
}
