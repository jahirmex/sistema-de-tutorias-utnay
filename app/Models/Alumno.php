<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'user_id',
        'matricula',
        'carrera',
        'cuatrimestre',
        'grupo_id',
        'telefono',
        'promedio',
        'estatus',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    public function tutorias()
    {
        return $this->hasMany(\App\Models\Tutoria::class);
    }
}
