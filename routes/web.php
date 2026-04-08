<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\CoordinadorController;
use App\Http\Controllers\TutorDashboardController;
use Illuminate\Support\Facades\Auth;
use App\Models\Tutor;
use App\Http\Controllers\TutorAlumnoController;
use App\Http\Controllers\TutoriaController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/coordinador/alumnos/exportar', [AlumnoController::class, 'exportar'])
    ->name('alumnos.exportar');

Route::get('/coordinador/tutores/{id}/dashboard', [TutorController::class, 'dashboard'])
    ->name('tutores.dashboard');

Route::get('/dashboard', function () {

    $user = Auth::user();

    // Si es tutor
    if ($user->role === 'tutor') {
        return redirect()->route('tutor.dashboard');
    }   

    // Si es alumno
    if (\App\Models\Alumno::where('user_id', $user->id)->exists()) {
        return redirect('/alumno/dashboard');
    }

    // Si no, coordinador
    return redirect('/coordinador/dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Perfil
    // Dashboard coordinador
    Route::get('/coordinador/dashboard', [CoordinadorController::class, 'dashboard'])
        ->name('coordinador.dashboard');

    // Tutor - Ver detalle de alumno
    Route::get('/tutor/alumnos/{id}', [TutorAlumnoController::class, 'show'])
        ->name('tutor.alumnos.show');

    // Tutor - Crear tutoría
    Route::get('/tutor/tutorias/create/{alumno}', [TutorAlumnoController::class, 'createTutoria'])
        ->name('tutor.tutorias.create');

    // Tutor - Guardar tutoría
    Route::post('/tutor/tutorias/store', [TutorAlumnoController::class, 'storeTutoria'])
        ->name('tutor.tutorias.store');

    // Tutor - Editar tutoría
    Route::get('/tutor/tutorias/edit/{id}', [TutorAlumnoController::class, 'editTutoria'])
        ->name('tutor.tutorias.edit');

    // Tutor - Eliminar tutoría
    Route::delete('/tutor/tutorias/delete/{id}', [TutorAlumnoController::class, 'destroyTutoria'])
    ->name('tutor.tutorias.destroy');
    
    // Tutor - Actualizar tutoría
    Route::post('/tutor/tutorias/update/{id}', [TutorAlumnoController::class, 'updateTutoria'])
        ->name('tutor.tutorias.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Coordinador - Reporte tutorías
    Route::get('/coordinador/reportes', [CoordinadorController::class, 'reportes'])
    ->name('coordinador.reportes');

    // Coordinador - Ver detalle de alumno
    Route::get('/coordinador/alumnos/{id}', [CoordinadorController::class, 'showAlumno'])
    ->name('coordinador.alumnos.show');

    // Coordinador - Alumnos
    Route::get('/coordinador/alumnos', [CoordinadorController::class, 'alumnos'])->name('coordinador.alumnos');
    Route::get('/coordinador/alumnos/create', [AlumnoController::class, 'create']);
    Route::post('/coordinador/alumnos', [AlumnoController::class, 'store'])->name('alumnos.store');
    Route::get('/coordinador/alumnos/{id}/edit', [AlumnoController::class, 'edit'])->name('alumnos.edit');
    Route::put('/coordinador/alumnos/{id}', [AlumnoController::class, 'update'])->name('alumnos.update');
    Route::delete('/coordinador/alumnos/{id}', [AlumnoController::class, 'destroy'])->name('alumnos.destroy');

    // Coordinador - Tutores
    Route::get('/coordinador/tutores', [TutorController::class, 'index']);
    Route::get('/coordinador/tutores/create', [TutorController::class, 'create']);
    Route::post('/coordinador/tutores', [TutorController::class, 'store'])->name('tutores.store');
    Route::get('/coordinador/tutores/{id}/edit', [TutorController::class, 'edit']);
    Route::put('/coordinador/tutores/{id}', [TutorController::class, 'update']);
    Route::delete('/coordinador/tutores/{id}', [TutorController::class, 'destroy']);

    // Rutas ALUMNO (protegidas por rol)
    Route::middleware(['auth','role:alumno'])
        ->prefix('alumno')
        ->name('alumno.')
        ->group(function () {

        Route::get('/dashboard', [AlumnoController::class, 'dashboard'])->name('dashboard');

        Route::get('/mis-tutorias', function() {
            return view('alumno.mis-tutorias');
        })->name('mis-tutorias');

        Route::get('/solicitar-tutoria', function() {
            return view('alumno.solicitar-tutoria');
        })->name('solicitar-tutoria');

        Route::get('/mi-tutor', function() {
            return view('alumno.mi-tutor');
        })->name('mi-tutor');
    });

});


    require __DIR__.'/auth.php';

    // Fallback para logout por GET (evita error 405 si algún componente envía GET)
    Route::get('/logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        return redirect('/');
    });

    //mistutorias - alumno
    Route::get('/alumno/tutoria/{id}', [AlumnoController::class, 'verTutoria']);


    // Rutas para el panel del tutor (autenticado)
    Route::middleware(['auth','role:tutor'])->prefix('tutor')->name('tutor.')->group(function () {
        // Dashboard del tutor autenticado
        Route::get('/dashboard', [TutorController::class, 'tutorDashboard'])->name('dashboard');
        
        // Mis alumnos
        Route::get('/mis-alumnos', [TutorController::class, 'misAlumnos'])->name('mis-alumnos');
        
        // Tutorías
        Route::get('/tutorias', [TutorController::class, 'tutorias'])->name('tutorias');
        Route::get('/tutoria/{id}', [TutorController::class, 'verTutoria'])->name('tutoria.detalle');
        Route::post('/tutoria/{id}/completar', [TutorController::class, 'completarTutoria'])->name('tutoria.completar');
        
        // Horario
        Route::get('/horario', [TutorController::class, 'horario'])->name('horario');
        
        // Perfil y configuración
        Route::get('/perfil', [TutorController::class, 'perfil'])->name('perfil');
        Route::get('/configuracion', [TutorController::class, 'configuracion'])->name('configuracion');

        // Cancelar tutoría
        Route::post('/tutoria/{id}/cancelar', [TutorController::class, 'cancelarTutoria'])->name('tutoria.cancelar');

    });

    Route::middleware(['auth','role:alumno'])->group(function () {
    Route::post('/alumno/tutorias', [TutoriaController::class, 'store'])
        ->name('alumno.tutorias.store');
    });

    Route::get('/alumno/tutorias', [TutoriaController::class, 'index'])
        ->name('alumno.tutorias.index');

    Route::get('/tutorias/{id}', [TutoriaController::class, 'show'])
    ->name('tutorias.show');

    Route::post('/tutorias/{id}/confirmar', [TutoriaController::class, 'confirmar'])
    ->name('tutorias.confirmar');