<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Role; // Importar el modelo Role
use App\Models\User; // Importar el modelo User

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar los roles
        $roles = [
            ['nombre' => 'Administrador'],
            ['nombre' => 'Docente'],
            ['nombre' => 'Coordinador'],

        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert($role);  // Insertamos los roles
        }

        // Obtener el ID del rol 'Administrador'
        $adminRole = Role::where('nombre', 'Administrador')->first(); 

        // Crear el usuario admin y asignarle el rol de 'Administrador'
        User::create([
            'nombre' => 'Administrador',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'apellido_paterno' => 'Admin',
            'apellido_materno' => 'User',
            'sexo' => 'Masculino',
            'direccion' => 'Direccion de admin',
            'fecha_nacimiento' => '1990-01-01',
            'rol' => $adminRole->id, // Asignamos el ID del rol 'Administrador'
            'password' => Hash::make('fail2025'), // Encriptando la contraseña
        ]);
    }
}
