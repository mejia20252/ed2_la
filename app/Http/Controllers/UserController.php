<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::with('rol')->get()); // Obtener usuarios con el rol relacionado
    }

    public function show($id)
    {
        $user = User::with('rol')->findOrFail($id); // Obtener usuario por ID con su rol
        return response()->json($user);
    }

    /*
    {
  "nombre": "Juan Perez",
  "username": "juanperez",
  "email": "juanperez@example.com",
  "password": "123456",
  "apellido_paterno": "Perez",
  "apellido_materno": "Lopez", 
  "sexo": "Masculino",
  "direccion": "avenida santos dumont",
  "fecha_nacimiento": "1990-05-15",
  "rol": null
}
    */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'rol' => 'nullable|exists:roles,id',
        ]);

        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Si la contraseña está vacía, no la incluimos en la actualización
        $data = $request->all();

        // Solo actualizamos la contraseña si se proporciona
        if (empty($data['password'])) {
            unset($data['password']); // Eliminar la contraseña del array de actualización si está vacía
        }

        // Validación opcional de contraseña
        if (!empty($data['password'])) {
            // Validar que la contraseña solo se actualice si se ha proporcionado
            $request->validate([
                'password' => 'string|min:6',  // Asegurarse de que la contraseña es válida
            ]);
        }

        $user->update($data);
        return response()->json($user);
    }
    public function verPerfil($id)
    {
        $user = User::with('rol')->findOrFail($id); // Obtener usuario por ID con su rol
        return response()->json($user);
    }
    public function crearCuentas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt|',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $file = $request->file('file');
            $handle = fopen($file->getRealPath(), 'r');

            // Leer encabezados
            $headers = fgetcsv($handle);

            // Cachear roles (nombre => id) en memoria
            // Normalizamos en minúsculas y sin espacios
            $rolesMap = Role::pluck('id', 'nombre')->mapWithKeys(function ($id, $nombre) {
                return [mb_strtolower(trim($nombre)) => $id];
            })->toArray();

            $usersCreated = 0;
            $errors = [];
            DB::beginTransaction();

            $rowNum = 1; // considerando que 0 fue el header
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $rowNum++;

                // Campos por índice según tu CSV, quitamos espacios en blanco con trim()
                $row = array_map('trim', $row);  // Esto quitará los espacios de cada campo

                [$nombre, $username, $email, $apPat, $apMat, $sexo, $direccion, $fechaNac, $rolNombre, $passwordPlano] = $row;

                // Normalizar y mapear rol
                $rolKey = mb_strtolower($rolNombre);
                $rolId = $rolesMap[$rolKey] ?? null;

                if (!$rolId) {
                    $errors[] = "Fila {$rowNum}: rol '{$rolNombre}' no existe en tabla roles.";
                    continue;
                }

                // Validaciones mínimas por fila (puedes ampliarlas)
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Fila {$rowNum}: email inválido '{$email}'.";
                    continue;
                }

                // Si ya existe el email, puedes omitirlo o actualizarlo
                if (User::where('email', $email)->exists()) {
                    $errors[] = "Fila {$rowNum}: email '{$email}' ya existe, se omitió.";
                    continue;
                }

                User::create([
                    'nombre'            => $nombre,
                    'username'          => $username,
                    'email'             => $email,
                    'apellido_paterno'  => $apPat,
                    'apellido_materno'  => $apMat,
                    'sexo'              => $sexo,
                    'direccion'         => $direccion,
                    'fecha_nacimiento'  => $fechaNac, // verifica formato Y-m-d
                    'rol'               => $rolId,     // <-- AQUÍ VA EL ID
                    'password'          => Hash::make($passwordPlano),
                ]);

                $usersCreated++;
            }

            fclose($handle);
            DB::commit();

            return response()->json([
                'message' => "Se importaron {$usersCreated} usuarios correctamente",
                'errors'  => $errors, // te devuelvo los saltos/errores de filas
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al procesar archivo: ' . $e->getMessage()
            ], 500);
        }
    }



    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
    public function getDocentes()
    {
        // Filtrar usuarios que tengan el rol 'docente'
        $usuariosDocentes = User::whereHas('rol', function ($query) {
            $query->where('nombre', 'Docente'); // Filtrar por el rol docente
        })->with('rol')->get(); // Obtener usuarios con el rol 'docente'

        return response()->json($usuariosDocentes); // Retorna los usuarios con rol docente
    }
}
