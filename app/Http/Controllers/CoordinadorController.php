<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Alumno;
use App\Models\Tutor;
use App\Models\Grupo;
use App\Models\Tutoria;

class CoordinadorController extends Controller
{

    public function dashboard()
    {
        $totalUsuarios = User::count();
        $totalAlumnos = Alumno::count();
        $totalTutores = Tutor::count();
        $totalGrupos = Grupo::count();

        // 🔵 Alumnos por grupo (promedio simple)
        $alumnosPorGrupo = $totalGrupos > 0 ? round($totalAlumnos / $totalGrupos) : 0;

        // 🟣 Promedio por tutor
        $promedioAlumnosPorTutor = $totalTutores > 0 ? round($totalAlumnos / $totalTutores) : 0;

        // 🟢 % asignación (ejemplo simple)
        $gruposConTutor = Grupo::whereNotNull('tutor_id')->count();
        $porcentajeAsignacion = $totalGrupos > 0 
            ? round(($gruposConTutor / $totalGrupos) * 100) 
            : 0;

        // 📊 Datos para gráfica
        $grupos = Grupo::withCount('alumnos')->get();

        $labels = $grupos->pluck('nombre');
        $data = $grupos->pluck('alumnos_count');

        return view('coordinador.dashboard', compact(
            'totalUsuarios',
            'totalAlumnos',
            'totalTutores',
            'totalGrupos',
            'alumnosPorGrupo',
            'promedioAlumnosPorTutor',
            'porcentajeAsignacion',
            'labels',
            'data'
        ));
    }

        public function reportes()
    {
        $alumnos = Alumno::withCount('tutorias') ->with(['grupo', 'user']) ->get();

        $totalTutorias = Tutoria::count();

        return view('coordinador.reportes', compact('alumnos', 'totalTutorias'));
    }

    public function showAlumno($id)
    {
        $alumno = \App\Models\Alumno::with(['tutorias.tutor.user', 'user', 'grupo'])
            ->findOrFail($id);

        return view('coordinador.alumnos.show', compact('alumno'));
    }
}