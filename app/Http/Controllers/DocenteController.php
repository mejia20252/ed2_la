<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use App\Models\Docente;
use App\Models\Grupo;
use App\Models\User;
use App\Models\AsistenciaDocente;
use App\Models\GrupoHorario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::with('user')->get();  // Obtiene todos los docentes con sus usuarios
        return response()->json($docentes);
    }

    // Mostrar un docente específico
    public function show($id)
    {
        $docente = Docente::with('user')->find($id);

        if (!$docente) {
            return response()->json(['message' => 'Docente no encontrado'], 404);
        }

        return response()->json($docente);
    }

    public function store(Request $request)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',  // Validar que el user_id existe en la tabla users
            'registro' => 'required|string|unique:docentes,registro',  // Registro único
            'especialidad' => 'nullable|string|max:255',  // Especialidad opcional
        ]);

        // Crear el docente con el user_id ya existente
        $docente = Docente::create($validatedData);

        return response()->json(['message' => 'Docente creado con éxito', 'docente' => $docente], 201);
    }


    // Actualizar un docente existente
    public function update(Request $request, $id)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',  // Relación con la tabla users
            'registro' => 'required|string|unique:docentes,registro,' . $id,  // Registro único, excepto el actual
            'especialidad' => 'nullable|string|max:255',  // Especialidad opcional
        ]);

        $docente = Docente::find($id);

        if (!$docente) {
            return response()->json(['message' => 'Docente no encontrado'], 404);
        }

        // Actualizar el docente
        $docente->update($validatedData);

        return response()->json(['message' => 'Docente actualizado con éxito', 'docente' => $docente]);
    }

    // Eliminar un docente
    public function destroy($id)
    {
        $docente = Docente::find($id);

        if (!$docente) {
            return response()->json(['message' => 'Docente no encontrado'], 404);
        }

        // Eliminar el docente
        $docente->delete();

        return response()->json(['message' => 'Docente eliminado con éxito']);
    }
    // Método para obtener los horarios del docente
     public function horarios()
    {
        // Paso 1: Obtener el userId del usuario autenticado
        $userId = Auth::id();  // Obtiene el id del usuario autenticado
        
        // Paso 2: Buscar el docenteId relacionado con este userId
        $docente = Docente::where('user_id', $userId)->first();

        if (!$docente) {
            return response()->json(['message' => 'Docente no encontrado'], 404);
        }

        // Paso 3: Obtener los grupos del docente y sus horarios
        // Usamos la relación que ya hemos definido en el modelo Docente
        $docenteWithHorarios = Docente::with(['grupos.horarios'])->find($docente->id);

        if (!$docenteWithHorarios) {
            return response()->json(['message' => 'No se encontraron grupos o horarios para este docente'], 404);
        }

        // Paso 4: Devolver los datos con los grupos y horarios
        return response()->json($docenteWithHorarios);
    }
     public function obtenerAsistencias(Request $request)
    {
        // Obtener el usuario autenticado
        $userId = Auth::id();
        
        // Buscar el docente relacionado con este usuario
        $docente = Docente::where('user_id', $userId)->first();

        if (!$docente) {
            return response()->json(['message' => 'Docente no encontrado'], 404);
        }

        // Obtener la fecha del query parameter, si no existe usar la fecha actual
        $fecha = $request->query('fecha', now()->toDateString());

        // Validar formato de fecha (opcional pero recomendado)
        try {
            $fechaValidada = \Carbon\Carbon::parse($fecha)->toDateString();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Formato de fecha inválido'], 400);
        }

        // Obtener las asistencias del docente para la fecha especificada
        $asistencias = AsistenciaDocente::where('docente_id', $docente->id)
            ->where('fecha', $fechaValidada)
            ->get(['id', 'grupo_id', 'grupo_horario_id', 'estado', 'fecha']);

        return response()->json($asistencias);
    }
   
   
public function crearDocente()
{
    // Paso 1: Buscar todos los usuarios con el rol 'Docente'
    $users = User::whereHas('rol', function ($query) {
        $query->where('nombre', 'Docente');  // Asegúrate que el rol 'Docente' exista en la tabla 'roles'
    })->get();

    // Paso 2: Crear un docente para cada usuario encontrado
    foreach ($users as $user) {
        // Paso 2.1: Verificar si el usuario ya tiene un docente asociado
        $existingDocente = Docente::where('user_id', $user->id)->first();

        if ($existingDocente) {
            // Si ya existe un docente para este usuario, continuamos con el siguiente usuario
            continue;
        }

        // Paso 2.2: Generar un registro aleatorio
        $registroAleatorio = 'DOC-' . Str::random(8); // Puedes ajustar el prefijo y la longitud si es necesario

        // Paso 3: Crear el registro en la tabla docentes
        $docente = Docente::create([
            'user_id' => $user->id, // Relacionar con el usuario
            'registro' => $registroAleatorio, // Asignar el registro aleatorio
            'especialidad' => null, // Puedes asignar una especialidad o dejarlo null
        ]);
    }

    return response()->json(['message' => 'Docentes creados con éxito']);
}

}