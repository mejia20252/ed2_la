<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('materias')->insert([
            // Semestre 1
            ['codigo' => 'MAT101', 'nombre' => 'Cálculo I', 'creditos' => 5, 'hps' => 6],
            ['codigo' => 'INF119', 'nombre' => 'Estructuras Discretas', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF110', 'nombre' => 'Introducción a la Informática', 'creditos' => 3, 'hps' => 4],
            ['codigo' => 'LIN100', 'nombre' => 'Inglés Técnico I', 'creditos' => 2, 'hps' => 2],
            ['codigo' => 'FIS100', 'nombre' => 'Física I', 'creditos' => 5, 'hps' => 6],

            // Semestre 2
            ['codigo' => 'MAT102', 'nombre' => 'Cálculo II', 'creditos' => 5, 'hps' => 6],
            ['codigo' => 'MAT103', 'nombre' => 'Álgebra Lineal', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF120', 'nombre' => 'Programación I', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'LIN101', 'nombre' => 'Inglés Técnico II', 'creditos' => 2, 'hps' => 2],
            ['codigo' => 'FIS102', 'nombre' => 'Física II', 'creditos' => 5, 'hps' => 6],

            // Semestre 3
            ['codigo' => 'MAT207', 'nombre' => 'Ecuaciones Diferenciales', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF210', 'nombre' => 'Programación II', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF211', 'nombre' => 'Arquitectura de Computadoras', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'ADM100', 'nombre' => 'Administración', 'creditos' => 3, 'hps' => 3],
            ['codigo' => 'FIS200', 'nombre' => 'Física III', 'creditos' => 5, 'hps' => 6],
             //Semestre 4
            ['codigo' => 'MAT202', 'nombre' => 'Probabilidad y Estadística I', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'MAT205', 'nombre' => 'Métodos Numéricos', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF220', 'nombre' => 'Estructura de Datos I', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF221', 'nombre' => 'Programación Ensamblador', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'ADM200', 'nombre' => 'Contabilidad', 'creditos' => 3, 'hps' => 3],

            // Semestre 5
            ['codigo' => 'MAT302', 'nombre' => 'Probabilidad y Estadística II', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF310', 'nombre' => 'Estructura de Datos II', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'ADM330', 'nombre' => 'Organización y Métodos', 'creditos' => 3, 'hps' => 3],
            ['codigo' => 'INF312', 'nombre' => 'Base de Datos I', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'ECO300', 'nombre' => 'Economía para la Gestión', 'creditos' => 3, 'hps' => 3],

            // Semestre 6
            ['codigo' => 'MAT329', 'nombre' => 'Investigación Operativa I', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF323', 'nombre' => 'Sistemas Operativos I', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'ADM320', 'nombre' => 'Finanzas para la Empresa', 'creditos' => 3, 'hps' => 3],
            ['codigo' => 'INF342', 'nombre' => 'Sistemas de Información I', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF322', 'nombre' => 'Base de Datos II', 'creditos' => 4, 'hps' => 4],

            // Semestre 7
            ['codigo' => 'MAT419', 'nombre' => 'Investigación Operativa II', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF433', 'nombre' => 'Redes I', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF413', 'nombre' => 'Sistemas Operativos II', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF432', 'nombre' => 'Sistemas para el Soporte a la Toma de Decisiones', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF412', 'nombre' => 'Sistemas de Información II', 'creditos' => 4, 'hps' => 4],

            // Semestre 8
            ['codigo' => 'ECO449', 'nombre' => 'Preparación y Evaluación de Proyectos', 'creditos' => 3, 'hps' => 3],
            ['codigo' => 'INF423', 'nombre' => 'Redes II', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF462', 'nombre' => 'Auditoría Informática', 'creditos' => 3, 'hps' => 3],
            ['codigo' => 'INF442', 'nombre' => 'Sistemas de Información Geográfica', 'creditos' => 3, 'hps' => 3],
            ['codigo' => 'INF422', 'nombre' => 'Ingeniería de Software I', 'creditos' => 4, 'hps' => 4],

            // Semestre 9
            ['codigo' => 'INF511', 'nombre' => 'Taller de Grado I', 'creditos' => 2, 'hps' => 2],
            ['codigo' => 'INF512', 'nombre' => 'Ingeniería de Software II', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF513', 'nombre' => 'Tecnología Web', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'INF552', 'nombre' => 'Arquitectura de Software', 'creditos' => 4, 'hps' => 4],
            ['codigo' => 'GRL001', 'nombre' => 'Modalidad de Licenciatura', 'creditos' => 0, 'hps' => 0],

            // Electivas (ELC)
            ['codigo' => 'ELC001', 'nombre' => 'Administración de Recursos Humanos', 'creditos' => 3, 'hps' => 3],
            ['codigo' => 'ELC002', 'nombre' => 'Costos y Presupuestos', 'creditos' => 3, 'hps' => 3],
            ['codigo' => 'ELC003', 'nombre' => 'Producción y Marketing', 'creditos' => 3, 'hps' => 3],
            ['codigo' => 'ELC004', 'nombre' => 'Reingeniería', 'creditos' => 3, 'hps' => 3],
            ['codigo' => 'ELC005', 'nombre' => 'Ingeniería de la Calidad', 'creditos' => 3, 'hps' => 3],
            ['codigo' => 'ELC006', 'nombre' => 'Benchmarking', 'creditos' => 3, 'hps' => 3],
            ['codigo' => 'ELC007', 'nombre' => 'Introducción a la Macroeconomía', 'creditos' => 3, 'hps' => 3],
            ['codigo' => 'ELC008', 'nombre' => 'Legislación en Ciencias de la Computación', 'creditos' => 3, 'hps' => 3],
        ]);
    }
}
