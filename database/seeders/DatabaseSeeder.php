<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuarios base del sistema

        // Coordinador
        User::firstOrCreate([
            'email' => 'coordinador@utnay.edu.mx'
        ], [
            'name' => 'Coordinador',
            'password' => Hash::make('12345678'),
            'role' => 'coordinador',
        ]);

        // Tutor
        User::firstOrCreate([
            'email' => 'tovar@utnay.edu.mx'
        ], [
            'name' => 'Tutor',
            'password' => Hash::make('12345678'),
            'role' => 'tutor',
        ]);

        // Alumno
        User::firstOrCreate([
            'email' => 'jahir@utnay.edu.mx'
        ], [
            'name' => 'Alumno',
            'password' => Hash::make('12345678'),
            'role' => 'alumno',
        ]);

        $this->call([
            GruposSeeder::class,
            AlumnosSeeder::class,
        ]);
    }
}
