<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TutoriaController extends Controller
{
    public function completar($id)
    {
        $tutoria = \App\Models\Tutoria::findOrFail($id);

        $tutoria->estado = \App\Models\Tutoria::ESTADO_COMPLETADA;
        $tutoria->save();

        return back()->with('success', 'Tutoría completada correctamente');
    }
}
