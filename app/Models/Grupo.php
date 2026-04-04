<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Alumno;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'turno',
        'carrera',
    ];

    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }
    
}
