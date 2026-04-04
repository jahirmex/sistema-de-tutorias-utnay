<?php

namespace App\Exports;

use App\Models\Alumno;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AlumnosExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Alumno::with('user')->get();
    }

    public function map($alumno): array
    {
        return [
            $alumno->user->name,
            $alumno->user->email,
            $alumno->matricula,
            $alumno->carrera,
            $alumno->cuatrimestre,
        ];
    }
    public function headings(): array
    {
        return [
            'Nombre',
            'Correo',
            'Matrícula',
            'Carrera',
            'Cuatrimestre'
        ];
    }
}

