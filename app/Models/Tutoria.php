<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutoria extends Model
{
    protected $fillable = [
        'alumno_id',
        'tema',
        'descripcion',
        'fecha',
        'tutor_id',
        'estado',
        'duracion_minutos',
        'comentarios',
        'calificacion',
        'motivo_cancelacion',
        'fecha_completado',
        'fecha_cancelacion'
    ];

    // Estados de tutoría
    const ESTADO_PENDIENTE = 'pendiente';
    const ESTADO_PROCESO = 'en_proceso';
    const ESTADO_COMPLETADA = 'completada';

    // Relación con el tutor
    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    // Relación con el alumno (AGREGAR ESTA RELACIÓN)
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }
}