<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Alumno;
use App\Models\Tutor;
use App\Models\Grupo;
use App\Models\Tutoria;
use App\Models\Horario;

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

    public function alumnos(Request $request)
{
    $grupo = $request->grupo;

    $alumnos = Alumno::with(['user','grupo.tutor.user'])
        ->when($grupo, function ($query) use ($grupo) {
            $query->whereHas('grupo', function ($q) use ($grupo) {
                $q->whereRaw('LOWER(nombre) = ?', [strtolower($grupo)]);
            });
        })
        ->paginate(10)
        ->withQueryString();

    $grupos = Grupo::all();

    // 🔥 ESTO ES LO QUE TE FALTABA
    $totalAlumnos = Alumno::count();
    $totalGrupos = Grupo::count();
    $promedioGeneral = Alumno::avg('promedio') ?? 0;

    $alumnosPorGrupo = Grupo::withCount('alumnos')
        ->get()
        ->pluck('alumnos_count', 'id');

    return view('coordinador.alumnos', compact(
        'alumnos',
        'grupos',
        'totalAlumnos',
        'totalGrupos',
        'promedioGeneral',
        'alumnosPorGrupo'
    ));
}

public function tutorias()
    {
        $tutorias = Tutoria::with(['alumno.user', 'tutor.user'])
            ->latest()
            ->get();

        return view('coordinador.tutorias', compact('tutorias'));
    }

    public function horarios()
    {
        // Obtener todos los horarios
        $horarios = Horario::all();

        // Agrupar por grupo
        $horariosPorGrupo = $horarios->groupBy('grupo');

        return view('coordinador.horarios', compact('horarios', 'horariosPorGrupo'));
    }
}