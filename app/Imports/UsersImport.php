<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
class UsersImport  
{
    public function model(array $row)
    {
        // Asignar el rol según el texto en el CSV
        $rol = $row[8]; // Esto es el índice del rol en el archivo CSV

        // Si el rol es válido, crea el usuario, si no, no lo crea o asigna un rol por defecto
        return new User([
            'nombre' => $row[0],
            'username' => $row[1],
            'email' => $row[2],
            'apellido_paterno' => $row[3],
            'apellido_materno' => $row[4],
            'sexo' => $row[5],
            'direccion' => $row[6],
            'fecha_nacimiento' => $row[7],
            'rol' => $rol, // Asegúrate de que el rol esté correctamente asignado
            'password' => Hash::make($row[9]), // Encriptamos la contraseña
        ]);
    }
}
