<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\User;
use App\Models\Grupo;
use App\Models\Tutoria;
use Illuminate\Support\Facades\Auth;

class TutorController extends Controller
{
    public function index()
    {
        $tutores = Tutor::with('user')->get();
        return view('coordinador.tutores', compact('tutores'));
    }

    public function create()
    {
        $grupos = Grupo::all();
        return view('coordinador.create_tutor', compact('grupos'));
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->nombre,
            'email' => $request->correo,
            'password' => bcrypt('12345678'),
            'role' => 'tutor',
        ]);

        $tutor = Tutor::create([
            'user_id' => $user->id,
            'area' => $request->area,
        ]);

        // asignar grupos seleccionados
        if ($request->grupos) {
            Grupo::whereIn('id', $request->grupos)
                ->update(['tutor_id' => $tutor->id]);
        }

        return redirect('/coordinador/tutores');
    }

    public function edit($id)
    {
        $tutor = Tutor::with('user')->findOrFail($id);
        $grupos = Grupo::all();
        return view('coordinador.edit_tutor', compact('tutor', 'grupos'));
    }

    public function update(Request $request, $id)
    {
        $tutor = Tutor::findOrFail($id);

        $tutor->user->update([
            'name' => $request->nombre,
            'email' => $request->correo,
        ]);

        $tutor->update([
            'area' => $request->area,
        ]);

        Grupo::where('tutor_id', $tutor->id)->update(['tutor_id' => null]);

        if ($request->grupos) {
            Grupo::whereIn('id', $request->grupos)
                ->update(['tutor_id' => $tutor->id]);
        }

        return redirect('/coordinador/tutores');
    }

    public function destroy($id)
    {
        $tutor = Tutor::findOrFail($id);
        $tutor->user->delete();

        return redirect('/coordinador/tutores');
    }

    /**
     * Dashboard del tutor desde el panel del coordinador (requiere ID)
     */
    public function dashboard($id)
    {
        $tutor = Tutor::with(['user', 'grupos.alumnos'])->findOrFail($id);

        // alumnos del tutor (a través de grupos)
        $alumnos = $tutor->grupos->flatMap->alumnos;

        $totalAlumnos = $alumnos->count();
        $totalGrupos = $tutor->grupos->count();

        // alumnos por grupo (para gráfica)
        $alumnosPorGrupo = $tutor->grupos->map(function ($grupo) {
            return [
                'nombre' => $grupo->nombre,
                'total' => $grupo->alumnos->count()
            ];
        });

        return view('coordinador.tutor_dashboard', compact(
            'tutor',
            'totalAlumnos',
            'totalGrupos',
            'alumnosPorGrupo'
        ));
    }

    /**
     * Dashboard del tutor autenticado (para el panel del tutor)
     */
    public function tutorDashboard()
    {
        // Obtener el tutor autenticado
        $tutor = Tutor::with(['user', 'grupos.alumnos'])->where('user_id', Auth::id())->firstOrFail();
        
        // Alumnos asignados al tutor (a través de grupos)
        $alumnos = $tutor->grupos->flatMap->alumnos;
        $totalAlumnos = $alumnos->count();
        $totalGrupos = $tutor->grupos->count();
        
        // Tutorías del tutor (si tienes el modelo Tutoria)
        $tutoriasPendientes = Tutoria::where('tutor_id', $tutor->id)
            ->where('estado', 'pendiente')
            ->count();
            
        $tutoriasCompletadas = Tutoria::where('tutor_id', $tutor->id)
            ->where('estado', 'completada')
            ->count();
        
        // Próximas tutorías (pendientes y con fecha futura)
        $proximasTutorias = Tutoria::where('tutor_id', $tutor->id)
            ->where('estado', 'pendiente')
            ->where('fecha', '>=', now())
            ->with(['alumno.user'])
            ->orderBy('fecha', 'asc')
            ->limit(5)
            ->get();
        
        // Alumnos por grupo (para gráfica)
        $alumnosPorGrupo = $tutor->grupos->map(function ($grupo) {
            return [
                'nombre' => $grupo->nombre,
                'total' => $grupo->alumnos->count()
            ];
        });
        
        return view('tutor.dashboard', compact(
            'tutor',
            'totalAlumnos',
            'totalGrupos',
            'tutoriasPendientes',
            'tutoriasCompletadas',
            'proximasTutorias',
            'alumnosPorGrupo',
            'alumnos'
        ));
    }

    /**
 * Ver mis alumnos asignados
 */
public function misAlumnos(Request $request)
{
    $tutor = Tutor::with(['user', 'grupos.alumnos.user', 'grupos.alumnos.grupo'])
        ->where('user_id', Auth::id())
        ->firstOrFail();
    
    // Obtener todos los alumnos del tutor (a través de grupos)
    $alumnos = collect();
    foreach ($tutor->grupos as $grupo) {
        foreach ($grupo->alumnos as $alumno) {
            $alumno->nombre_grupo = $grupo->nombre;
            $alumnos->push($alumno);
        }
    }
    
    // Filtrar por búsqueda
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $alumnos = $alumnos->filter(function($alumno) use ($search) {
            return stripos($alumno->user->name ?? '', $search) !== false ||
                   stripos($alumno->matricula ?? '', $search) !== false ||
                   stripos($alumno->carrera ?? '', $search) !== false;
        });
    }
    
    // Filtrar por grupo
    if ($request->has('grupo_id') && $request->grupo_id != '') {
        $alumnos = $alumnos->filter(function($alumno) use ($request) {
            return $alumno->grupo_id == $request->grupo_id;
        });
    }
    
    // Paginación manual
    $perPage = 10;
    $currentPage = request()->get('page', 1);
    $paginatedAlumnos = new \Illuminate\Pagination\LengthAwarePaginator(
        $alumnos->forPage($currentPage, $perPage),
        $alumnos->count(),
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );
    
    // Estadísticas (DEFINIR ESTAS VARIABLES)
    $totalAlumnos = $alumnos->count();
    $totalGrupos = $tutor->grupos->count();
    $totalTutorias = Tutoria::where('tutor_id', $tutor->id)->count();
    
    // Alumnos por grupo para la gráfica
    $alumnosPorGrupo = $tutor->grupos->map(function ($grupo) {
        return [
            'nombre' => $grupo->nombre,
            'total' => $grupo->alumnos->count()
        ];
    });
    
    return view('tutor.mis-alumnos', compact(
        'tutor',
        'paginatedAlumnos',
        'totalAlumnos',      // Esta variable debe estar definida
        'totalGrupos',       // Esta variable debe estar definida
        'totalTutorias',     // Esta variable debe estar definida
        'alumnosPorGrupo'    // Esta variable debe estar definida
    ));
}

  /**
 * Ver todas las tutorías del tutor
 */
public function tutorias(Request $request)
{
    $tutor = Tutor::where('user_id', Auth::id())->firstOrFail();
    
    $query = Tutoria::where('tutor_id', $tutor->id)
        ->with(['alumno.user', 'alumno.grupo']);
    
    // Filtrar por estado
    if ($request->has('estado') && $request->estado != '') {
        $query->where('estado', $request->estado);
    }
    
    // Filtrar por grupo
    if ($request->has('grupo_id') && $request->grupo_id != '') {
        $query->whereHas('alumno', function($q) use ($request) {
            $q->where('grupo_id', $request->grupo_id);
        });
    }
    
    // Filtrar por búsqueda (nombre del alumno o tema)
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->whereHas('alumno.user', function($sub) use ($search) {
                $sub->where('name', 'LIKE', "%{$search}%");
            })->orWhere('tema', 'LIKE', "%{$search}%");
        });
    }
    
    $tutorias = $query->orderBy('fecha', 'desc')->paginate(10);
    
    // Obtener grupos del tutor para el filtro
    $grupos = $tutor->grupos;
    
    // Estadísticas
    $totalTutorias = Tutoria::where('tutor_id', $tutor->id)->count();
    $tutoriasPendientes = Tutoria::where('tutor_id', $tutor->id)->where('estado', 'pendiente')->count();
    $tutoriasCompletadas = Tutoria::where('tutor_id', $tutor->id)->where('estado', 'completada')->count();
    $tutoriasCanceladas = Tutoria::where('tutor_id', $tutor->id)->where('estado', 'cancelada')->count();
    
    return view('tutor.tutorias', compact(
        'tutorias',
        'tutor',
        'grupos',
        'totalTutorias',
        'tutoriasPendientes',
        'tutoriasCompletadas',
        'tutoriasCanceladas'
    ));
}

    /**
     * Ver detalle de una tutoría específica
     */
    public function verTutoria($id)
    {
        $tutor = Tutor::where('user_id', Auth::id())->firstOrFail();
        
        $tutoria = Tutoria::where('tutor_id', $tutor->id)
            ->with(['alumno.user'])
            ->findOrFail($id);
        
        return view('tutor.tutoria-detalle', compact('tutoria'));
    }

    /**
     * Marcar tutoría como completada
     */
    public function completarTutoria(Request $request, $id)
    {
        $tutor = Tutor::where('user_id', Auth::id())->firstOrFail();
        
        $tutoria = Tutoria::where('tutor_id', $tutor->id)->findOrFail($id);
        
        $tutoria->update([
            'estado' => 'completada',
            'comentarios' => $request->comentarios,
            'calificacion' => $request->calificacion ?? null
        ]);
        
        return redirect()->back()->with('success', 'Tutoría completada exitosamente');
    }

    /**
     * Mi horario de tutorías
     */
    public function horario()
    {
        $tutor = Tutor::where('user_id', Auth::id())->firstOrFail();
        
        // Aquí puedes obtener el horario del tutor de donde lo tengas almacenado
        $horario = $tutor->horario ?? null;
        
        return view('tutor.horario', compact('tutor', 'horario'));
    }

    /**
     * Perfil del tutor
     */
    public function perfil()
    {
        $tutor = Tutor::with('user')->where('user_id', Auth::id())->firstOrFail();
        
        return view('tutor.perfil', compact('tutor'));
    }

    /**
     * Configuración del tutor
     */
    public function configuracion()
    {
        $tutor = Tutor::where('user_id', Auth::id())->firstOrFail();
        
        return view('tutor.configuracion', compact('tutor'));
    }

    /**
    * Cancelar tutoría
    */
    public function cancelarTutoria(Request $request, $id)
    {
        $tutor = Tutor::where('user_id', Auth::id())->firstOrFail();
        
        $tutoria = Tutoria::where('tutor_id', $tutor->id)->findOrFail($id);
        
        $tutoria->update([
            'estado' => 'cancelada',
            'motivo_cancelacion' => $request->motivo_cancelacion,
            'fecha_cancelacion' => now()
        ]);
        
        return redirect()->route('tutor.tutorias')->with('success', 'Tutoría cancelada exitosamente');
    }

}