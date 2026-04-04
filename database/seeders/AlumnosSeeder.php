<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Alumno;
use App\Models\Grupo;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class AlumnosSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $grupos = Grupo::all();

        $contador = 1;

        foreach ($grupos as $grupo) {

            for ($i = 1; $i <= 10; $i++) {

                $user = User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'password' => Hash::make('12345678'),
                ]);

                Alumno::create([
                    'user_id' => $user->id,
                    'matricula' => 'tic-3120' . str_pad($contador, 2, '0', STR_PAD_LEFT),
                    'carrera' => 'IDGS',
                    'cuatrimestre' => 8,
                    'grupo_id' => $grupo->id,
                    'telefono' => $faker->phoneNumber,
                    'promedio' => $faker->randomFloat(2, 7, 10),
                    'estatus' => 'Activo',
                ]);

                $contador++;
            }
        }
    }
}