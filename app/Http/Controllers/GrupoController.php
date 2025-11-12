<?php

namespace App\Http\Controllers;

use App\Models\Grupo;

use Illuminate\Http\Request;

class GrupoController extends Controller
{
    // Obtener todos los grupos
    public function index()
    {
        $grupos = Grupo::with(['materia', 'gestion', 'docente', 'aula', 'horarios'])->get();  // Obtener los grupos con sus relaciones
        return response()->json($grupos);
    }

    // Mostrar un grupo específico
    public function show($id)
    {
        $grupo = Grupo::with(['materia', 'gestion', 'docente', 'aula', 'horarios'])->find($id);

        if (!$grupo) {
            return response()->json(['message' => 'Grupo no encontrado'], 404);
        }

        return response()->json($grupo);
    }

    // Crear un nuevo grupo
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'gestion_id' => 'required|exists:gestiones,id',
            'codigo' => 'required|string|unique:grupos,codigo',
            'capacidad' => 'required|integer',
            'modalidad' => 'required|string',
            'docente_id' => 'required|exists:docentes,id',
            'aula_id' => 'required|exists:aulas,id',
        ]);

        // Verificar si ya existe un grupo con el mismo docente y aula en el mismo horario
        $conflictoDocente = Grupo::where('docente_id', $validatedData['docente_id'])
            ->where('aula_id', $validatedData['aula_id'])
            ->whereHas('horarios', function ($query) use ($request) {
                $query->where('hora_inicio', $request->hora_inicio)
                    ->where('hora_fin', $request->hora_fin);
            })
            ->exists();

        if ($conflictoDocente) {
            return response()->json(['message' => 'El docente ya tiene otra clase en este horario.'], 400);
        }

        // Verificar si el aula ya está ocupada en el mismo horario
        $conflictoAula = Grupo::where('aula_id', $validatedData['aula_id'])
            ->whereHas('horarios', function ($query) use ($request) {
                $query->where('hora_inicio', $request->hora_inicio)
                    ->where('hora_fin', $request->hora_fin);
            })
            ->exists();

        if ($conflictoAula) {
            return response()->json(['message' => 'El aula ya está ocupada en este horario.'], 400);
        }
        // Crear el nuevo grupo
        $grupo = Grupo::create($validatedData);

        return response()->json(['message' => 'Grupo creado con éxito', 'grupo' => $grupo], 201);
    }
    // Actualizar un grupo existente
    public function update(Request $request, $id)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'gestion_id' => 'required|exists:gestiones,id',
            'codigo' => 'required|string|unique:grupos,codigo,' . $id,
            'capacidad' => 'required|integer',
            'modalidad' => 'required|string',
            'docente_id' => 'nullable|exists:docentes,id',
            'aula_id' => 'required|exists:aulas,id',
        ]);

        // Buscar el grupo por ID
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return response()->json(['message' => 'Grupo no encontrado'], 404);
        }

        // Actualizar el grupo
        $grupo->update($validatedData);

        return response()->json(['message' => 'Grupo actualizado con éxito', 'grupo' => $grupo]);
    }

    // Eliminar un grupo
    public function destroy($id)
    {
        $grupo = Grupo::find($id);

        if (!$grupo) {
            return response()->json(['message' => 'Grupo no encontrado'], 404);
        }

        // Eliminar el grupo
        $grupo->delete();

        return response()->json(['message' => 'Grupo eliminado con éxito']);
    }
    public function asignarHorarioAutomatico(Request $request, $grupoId)
    {
        // Paso 1: Validar si el grupo existe
        $grupo = Grupo::find($grupoId);
        if (!$grupo) {
            return response()->json(['message' => 'Grupo no encontrado'], 404);
        }

        // Paso 2: Obtener el docente y el aula
        $docente = $grupo->docente;  // El docente ya está asignado al grupo
        $aula = $grupo->aula;        // El aula ya está asignada al grupo

        // Paso 3: Validar si el docente ya tiene otra clase en el mismo horario
        $conflictoDocente = Grupo::where('docente_id', $docente->id)
            ->where('dia', $request->dia)
            ->where(function ($query) use ($request) {
                // Verificar si hay conflicto en el horario
                $query->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                    ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin]);
            })
            ->exists();

        if ($conflictoDocente) {
            return response()->json(['message' => 'El docente ya tiene otra clase en este horario.'], 400);
        }

        // Paso 4: Validar si el aula está ocupada en el mismo horario
        $conflictoAula = Grupo::where('aula_id', $aula->id)
            ->where('dia', $request->dia)
            ->where(function ($query) use ($request) {
                // Verificar si el aula está ocupada en el horario solicitado
                $query->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])
                    ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin]);
            })
            ->exists();

        if ($conflictoAula) {
            return response()->json(['message' => 'El aula ya está ocupada en este horario.'], 400);
        }

        // Paso 5: Asignar el nuevo horario al grupo
        $grupo->update([
            'dia' => $request->dia,          // Día de la clase
            'hora_inicio' => $request->hora_inicio,  // Hora de inicio
            'hora_fin' => $request->hora_fin,      // Hora de fin
        ]);

        // Paso 6: Responder con el grupo actualizado
        return response()->json(['message' => 'Horario asignado correctamente al grupo', 'grupo' => $grupo]);
    }
}
