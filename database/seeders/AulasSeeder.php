<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AulasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('aulas')->insert([
            ['codigo' => '236-22', 'nombre' => 'Aula 236-22', 'capacidad' => 30, 'ubicacion' => 'Bloque 2', 'estado' => 'disponible'],
            ['codigo' => '236-26', 'nombre' => 'Aula 236-26', 'capacidad' => 30, 'ubicacion' => 'Bloque 3', 'estado' => 'disponible'],
            ['codigo' => '236-35', 'nombre' => 'Aula 236-35', 'capacidad' => 30, 'ubicacion' => 'Bloque 4', 'estado' => 'disponible'],
            ['codigo' => '224-08', 'nombre' => 'Aula 224-08', 'capacidad' => 30, 'ubicacion' => 'Bloque 1', 'estado' => 'disponible'],
            ['codigo' => '225-17', 'nombre' => 'Aula 225-17', 'capacidad' => 30, 'ubicacion' => 'Bloque 2', 'estado' => 'disponible'],
            ['codigo' => '236-25', 'nombre' => 'Aula 236-25', 'capacidad' => 30, 'ubicacion' => 'Bloque 3', 'estado' => 'disponible'],
            ['codigo' => '236-11', 'nombre' => 'Aula 236-11', 'capacidad' => 30, 'ubicacion' => 'Bloque 4', 'estado' => 'disponible'],
            ['codigo' => '236-12', 'nombre' => 'Aula 236-12', 'capacidad' => 30, 'ubicacion' => 'Bloque 1', 'estado' => 'disponible'],
            ['codigo' => '225-21', 'nombre' => 'Aula 225-21', 'capacidad' => 30, 'ubicacion' => 'Bloque 2', 'estado' => 'disponible'],
            ['codigo' => '236-14', 'nombre' => 'Aula 236-14', 'capacidad' => 30, 'ubicacion' => 'Bloque 3', 'estado' => 'disponible'],
            ['codigo' => '236-45', 'nombre' => 'Aula 236-45', 'capacidad' => 30, 'ubicacion' => 'Bloque 2', 'estado' => 'disponible'],
            ['codigo' => '236-43', 'nombre' => 'Aula 236-43', 'capacidad' => 30, 'ubicacion' => 'Bloque 3', 'estado' => 'disponible'],
            ['codigo' => '236-15', 'nombre' => 'Aula 236-15', 'capacidad' => 30, 'ubicacion' => 'Bloque 4', 'estado' => 'disponible'],
            ['codigo' => '236-41', 'nombre' => 'Aula 236-41', 'capacidad' => 30, 'ubicacion' => 'Bloque 2', 'estado' => 'disponible'],
            ['codigo' => '236-24', 'nombre' => 'Aula 236-24', 'capacidad' => 30, 'ubicacion' => 'Bloque 4', 'estado' => 'disponible'],
            ['codigo' => '236-46', 'nombre' => 'Aula 236-46', 'capacidad' => 30, 'ubicacion' => 'Bloque 3', 'estado' => 'disponible'],
            ['codigo' => '236-23', 'nombre' => 'Aula 236-23', 'capacidad' => 30, 'ubicacion' => 'Bloque 4', 'estado' => 'disponible'],
            ['codigo' => '236-32', 'nombre' => 'Aula 236-32', 'capacidad' => 30, 'ubicacion' => 'Bloque 1', 'estado' => 'disponible'],
            ['codigo' => '236-16', 'nombre' => 'Aula 236-16', 'capacidad' => 30, 'ubicacion' => 'Bloque 3', 'estado' => 'disponible'],
            ['codigo' => '236-13', 'nombre' => 'Aula 236-13', 'capacidad' => 30, 'ubicacion' => 'Bloque 2', 'estado' => 'disponible'],
            ['codigo' => '224-01', 'nombre' => 'Aula 224-01', 'capacidad' => 30, 'ubicacion' => 'Bloque 1', 'estado' => 'disponible'],
            ['codigo' => '236-44', 'nombre' => 'Aula 236-44', 'capacidad' => 30, 'ubicacion' => 'Bloque 3', 'estado' => 'disponible'],
            ['codigo' => '236-21', 'nombre' => 'Aula 236-21', 'capacidad' => 30, 'ubicacion' => 'Bloque 1', 'estado' => 'disponible'],
            ['codigo' => '236-34', 'nombre' => 'Aula 236-34', 'capacidad' => 30, 'ubicacion' => 'Bloque 2', 'estado' => 'disponible'],
            ['codigo' => '242-03', 'nombre' => 'Aula 242-03', 'capacidad' => 30, 'ubicacion' => 'Bloque 3', 'estado' => 'disponible'],
            ['codigo' => '225-42', 'nombre' => 'Aula 225-42', 'capacidad' => 30, 'ubicacion' => 'Bloque 4', 'estado' => 'disponible'],
            ['codigo' => '225-16', 'nombre' => 'Aula 225-16', 'capacidad' => 30, 'ubicacion' => 'Bloque 1', 'estado' => 'disponible'],
            ['codigo' => '225-15', 'nombre' => 'Aula 225-15', 'capacidad' => 30, 'ubicacion' => 'Bloque 2', 'estado' => 'disponible'],
            ['codigo' => '236-31', 'nombre' => 'Aula 236-31', 'capacidad' => 30, 'ubicacion' => 'Bloque 4', 'estado' => 'disponible'],
            ['codigo' => '225-38', 'nombre' => 'Aula 225-38', 'capacidad' => 30, 'ubicacion' => 'Bloque 2', 'estado' => 'disponible'],
            ['codigo' => '224-07', 'nombre' => 'Aula 224-07', 'capacidad' => 30, 'ubicacion' => 'Bloque 3', 'estado' => 'disponible'],
        ]);
    }
}
