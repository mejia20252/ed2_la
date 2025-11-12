<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Asegúrate de importar el modelo User

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear el usuario admin
        User::create([
            'nombre' => 'Administrador',
            'username' => 'admin',
            'email' => 'admin@example.com', // Cambia a un email válido
            'apellido_paterno' => 'Admin',
            'apellido_materno' => 'User',
            'sexo' => 'Masculino',
            'direccion' => 'Direccion de admin',
            'fecha_nacimiento' => '1990-01-01',
              'rol' => null,// Asumiendo que 'admin' es el rol
            'password' => Hash::make('fail2025'), // Encriptando la contraseña
        ]);
    }
}
