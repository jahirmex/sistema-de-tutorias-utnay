<?php

namespace App\Http\Controllers;

use App\Exports\AlumnosExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\User;
use App\Models\Grupo;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{
    // Mostrar lista de alumnos
    public function index(Request $request)
    {
        $query = Alumno::with('user', 'grupo');

        // FILTRO POR GRUPO
        if ($request->grupo_id) {
            $query->where('grupo_id', $request->grupo_id);
        }

        $alumnos = $query->paginate(5);
        $grupos = Grupo::all();

        // 🔥 MÉTRICAS
        $totalAlumnos = Alumno::count();
        $totalGrupos = Grupo::count();
        $promedioGeneral = Alumno::avg('promedio');

        $alumnosPorGrupo = Alumno::select('grupo_id', DB::raw('count(*) as total'))
            ->groupBy('grupo_id')
            ->pluck('total', 'grupo_id');

        return view('coordinador.alumnos', compact(
            'alumnos',
            'grupos',
            'totalAlumnos',
            'totalGrupos',
            'promedioGeneral',
            'alumnosPorGrupo'
        ));
    }

    // Mostrar formulario para crear alumno
    public function create()
    {
         $grupos = \App\Models\Grupo::all();
        
         return view('coordinador.create_alumno', compact('grupos'));
    }

    // Guardar alumno en BD
    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:users,email',
            'matricula' => 'required|string|max:50',
            'carrera' => 'required|string|max:255',
            'cuatrimestre' => 'required|integer',
            'grupo_id' => 'required|integer'
        ]);

        $user = User::create([
            'name' => $request->nombre,
            'email' => $request->correo,
            'password' => bcrypt('12345678'),
            'role' => 'alumno'
        ]);

        Alumno::create([
            'user_id' => $user->id,
            'matricula' => $request->matricula,
            'carrera' => $request->carrera,
            'cuatrimestre' => $request->cuatrimestre,
            'grupo_id' => $request->grupo_id,
        ]);

        return redirect('/coordinador/alumnos')->with('success', 'Alumno creado correctamente');
    }

            public function edit($id)
        {
            $alumno = Alumno::with('user')->findOrFail($id);
            $grupos = \App\Models\Grupo::all();
            return view('coordinador.edit_alumno', compact('alumno','grupos'));
        }

                public function update(Request $request, $id)
        {
            $alumno = Alumno::findOrFail($id);

            $request->validate([
                'nombre' => 'required',
                'correo' => 'required|email',
                'matricula' => 'required',
                'carrera' => 'required',
                'cuatrimestre' => 'required|integer'
            ]);

            // actualizar usuario
            $alumno->user->update([
                'name' => $request->nombre,
                'email' => $request->correo
            ]);

            // actualizar alumno
            $alumno->update([
                'matricula' => $request->matricula,
                'carrera' => $request->carrera,
                'cuatrimestre' => $request->cuatrimestre,
            ]);

            return redirect('/coordinador/alumnos')->with('success', 'Alumno actualizado');
        }

                public function destroy($id)
        {
            $alumno = Alumno::findOrFail($id);

            // elimina también el usuario relacionado
            $alumno->user->delete();

            return redirect('/coordinador/alumnos')->with('success', 'Alumno eliminado');
        }

        public function exportar()
        {
            return Excel::download(new AlumnosExport, 'alumnos.xlsx');
        }


        //vista alumno tutorias
        public function dashboard()
        {
            $alumno = \App\Models\Alumno::with(['tutorias.tutor.user', 'user', 'grupo'])
                ->where('user_id', auth()->id())
                ->firstOrFail();

            // 🔥 filtrar tutorías próximas correctamente
            $proximasTutorias = $alumno->tutorias
                ->filter(function ($t) {
                    return \Carbon\Carbon::parse($t->fecha)->isFuture();
                })
                ->sortBy('fecha');

            return view('alumno.dashboard', compact('alumno', 'proximasTutorias'));
        }

            public function verTutoria($id)
            {
                $tutoria = \App\Models\Tutoria::with(['tutor.user', 'alumno.user'])
                    ->findOrFail($id);

                return view('alumno.tutoria-detalle', compact('tutoria'));
            }

            public function miTutor()
            {
                $alumno = \App\Models\Alumno::with('grupo.tutor.user')
                    ->where('user_id', auth()->id())
                    ->first();

                $tutor = $alumno->grupo->tutor ?? null;
                $tutorias = $alumno->tutorias;

                return view('alumno.mi-tutor', compact('tutor', 'tutorias'));
            }

    
 }

      
