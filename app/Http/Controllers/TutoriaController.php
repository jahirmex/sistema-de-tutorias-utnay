<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutoria;

class TutoriaController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'tema' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'fecha' => 'required|date',
    ]);

    $alumno = \App\Models\Alumno::with('grupo.tutor')
        ->where('user_id', auth()->id())
        ->first();

    Tutoria::create([
        'tema' => $request->tema,
        'descripcion' => $request->descripcion,
        'fecha' => $request->fecha,
        'alumno_id' => $alumno->id,
        'tutor_id' => $alumno->grupo->tutor->id ?? null,
        'estado' => 'pendiente',
    ]);

    return redirect()->route('alumno.dashboard')
        ->with('success', 'Tutoría solicitada correctamente');
}

    public function completar($id)
    {
        $tutoria = \App\Models\Tutoria::findOrFail($id);

        $tutoria->estado = \App\Models\Tutoria::ESTADO_COMPLETADA;
        $tutoria->save();

        return back()->with('success', 'Tutoría completada correctamente');
    }

    public function index()
    {
        $alumnoId = \App\Models\Alumno::where('user_id', auth()->id())->value('id');

        $tutorias = \App\Models\Tutoria::where('alumno_id', $alumnoId)->get();

        return view('alumno.tutorias', compact('tutorias'));
    }

    public function show($id)
    {
        $tutoria = \App\Models\Tutoria::with(['alumno.user','tutor.user'])->findOrFail($id);

        return view('tutorias.show', compact('tutoria'));
    }

    public function confirmar($id)
    {
        $tutoria = \App\Models\Tutoria::findOrFail($id);

        $tutoria->estado = 'confirmada';
        $tutoria->save();

        return back()->with('success', 'Tutoría confirmada');
    }
}
