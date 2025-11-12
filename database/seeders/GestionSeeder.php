<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
    {
        $gestiones = [
            // 2023
            [
                'year' => 2023, 'periodo' => '1/2023', 'inicio' => '2023-01-01', 'fin' => '2023-03-31', 'estado' => 'cerrado',
            ],
            [
                'year' => 2023, 'periodo' => '2/2023', 'inicio' => '2023-04-01', 'fin' => '2023-06-30', 'estado' => 'cerrado',
            ],
            [
                'year' => 2023, 'periodo' => '3/2023', 'inicio' => '2023-07-01', 'fin' => '2023-09-30', 'estado' => 'cerrado',
            ],
            [
                'year' => 2023, 'periodo' => '4/2023', 'inicio' => '2023-10-01', 'fin' => '2023-12-31', 'estado' => 'cerrado',
            ],

            // 2024
            [
                'year' => 2024, 'periodo' => '1/2024', 'inicio' => '2024-01-01', 'fin' => '2024-03-31', 'estado' => 'cerrado',
            ],
            [
                'year' => 2024, 'periodo' => '2/2024', 'inicio' => '2024-04-01', 'fin' => '2024-06-30', 'estado' => 'cerrado',
            ],
            [
                'year' => 2024, 'periodo' => '3/2024', 'inicio' => '2024-07-01', 'fin' => '2024-09-30', 'estado' => 'cerrado',
            ],
            [
                'year' => 2024, 'periodo' => '4/2024', 'inicio' => '2024-10-01', 'fin' => '2024-12-31', 'estado' => 'cerrado',
            ],

            // 2025
            [
                'year' => 2025, 'periodo' => '1/2025', 'inicio' => '2025-01-01', 'fin' => '2025-03-31', 'estado' => 'cerrado',
            ],
            [
                'year' => 2025, 'periodo' => '2/2025', 'inicio' => '2025-04-01', 'fin' => '2025-06-30', 'estado' => 'cerrado',
            ],
            [
                'year' => 2025, 'periodo' => '3/2025', 'inicio' => '2025-07-01', 'fin' => '2025-09-30', 'estado' => 'cerrado',
            ],
            [
                'year' => 2025, 'periodo' => '4/2025', 'inicio' => '2025-10-01', 'fin' => '2025-12-31', 'estado' => 'cerrado',
            ],
        ];

        DB::table('gestiones')->insert($gestiones);
    }

}
