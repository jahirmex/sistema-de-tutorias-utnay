<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grupo;

class GruposSeeder extends Seeder
{
    public function run()
    {
        Grupo::insert([
            ['nombre' => 'IDGS81', 'turno' => 'Vespertino', 'carrera' => 'IDGS'],
            ['nombre' => 'IDGS82', 'turno' => 'Vespertino', 'carrera' => 'IDGS'],
            ['nombre' => 'IDGS83', 'turno' => 'Vespertino', 'carrera' => 'IDGS'],
            ['nombre' => 'IDGS84', 'turno' => 'Vespertino', 'carrera' => 'IDGS'],
        ]);
    }
}
