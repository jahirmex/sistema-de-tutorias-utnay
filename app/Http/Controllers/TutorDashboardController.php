<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\Tutor;

class TutorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tutor = Tutor::where('user_id', $user->id)->first();

        if (!$tutor) {
            return redirect('/dashboard')->with('error', 'No eres tutor');
        }

        $grupos = Grupo::where('tutor_id', $tutor->id)->get();

        $alumnos = Alumno::whereIn('grupo_id', $grupos->pluck('id'))->get();

        $totalAlumnos = $alumnos->count();
        $totalGrupos = $grupos->count();

        return view('tutor.dashboard', compact(
            'tutor',
            'grupos',
            'alumnos',
            'totalAlumnos',
            'totalGrupos'
        ));
    }
}