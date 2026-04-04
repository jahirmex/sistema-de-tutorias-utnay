<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Tutoria;

class TutorAlumnoController extends Controller
{
    public function show($id)
    {
        $alumno = Alumno::with(['tutorias.tutor.user', 'user', 'grupo'])->findOrFail($id);

        return view('tutor.alumnos.show', compact('alumno'));
    }

    public function createTutoria($alumno)
    {
        return view('tutor.tutorias.create', compact('alumno'));
    }

    public function storeTutoria(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'tema' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        Tutoria::create([
            'alumno_id' => $request->alumno_id,
            'tema' => $request->tema,
            'descripcion' => $request->descripcion,
            'fecha' => now(),
            'tutor_id' => \App\Models\Tutor::where('user_id', auth()->id())->value('id'),
        ]);

        return redirect()->route('tutor.dashboard')
            ->with('success', 'Tutoría registrada correctamente');
    }

        public function editTutoria($id)
    {
        $tutoria = \App\Models\Tutoria::findOrFail($id);

        return view('tutor.tutorias.edit', compact('tutoria'));
    }

    public function updateTutoria(Request $request, $id)
    {
        $tutoria = \App\Models\Tutoria::findOrFail($id);

        $tutoria->update([
            'tema' => $request->tema,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('tutor.alumnos.show', $tutoria->alumno_id)
            ->with('success', 'Tutoría actualizada');
    }

        public function destroyTutoria($id)
    {
        $tutoria = \App\Models\Tutoria::findOrFail($id);
        $alumno_id = $tutoria->alumno_id;

        $tutoria->delete();

        return redirect()->route('tutor.alumnos.show', $alumno_id)
            ->with('success', 'Tutoría eliminada correctamente');
    }
}
