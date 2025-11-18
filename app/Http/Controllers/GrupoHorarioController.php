<?php

namespace App\Http\Controllers;

use App\Models\GrupoHorario;
use App\Models\Grupo;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class GrupoHorarioController extends Controller
{
    // Mostrar todos los horarios del grupo
    public function index($grupo_id)
    {
        $horarios = GrupoHorario::where('grupo_id', $grupo_id)->get();
        return response()->json($horarios);
    }
    public function gruposDias($grupo_id)
    {
        $horarios = GrupoHorario::where('grupo_id', $grupo_id)->get();
        return response()->json($horarios);
    }

  public function store(Request $request)
{
    // Validar los datos del request
    $validatedData = $request->validate([
        'grupo_id' => 'required|exists:grupos,id',
        'dia' => 'required|string',
        'hora_inicio' => 'required|date_format:H:i',
        'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
    ]);

    // Obtener el grupo para verificar el aula
    $grupo = Grupo::find($request->grupo_id);

    // Verificar si el horario del grupo se solapa con otro grupo en el mismo aula y día
    $conflictoHorario = GrupoHorario::whereHas('grupo', function ($query) use ($grupo) {
        // Verificar que no sea el mismo grupo
        $query->where('aula_id', $grupo->aula_id);
    })
    ->where('dia', $request->dia)  // Mismo día
    ->where(function($query) use ($request) {
        $query->whereBetween('hora_inicio', [$request->hora_inicio, $request->hora_fin])  // El nuevo horario se solapa con el inicio
              ->orWhereBetween('hora_fin', [$request->hora_inicio, $request->hora_fin])  // El nuevo horario se solapa con el fin
              ->orWhere(function($query2) use ($request) {
                  $query2->where('hora_inicio', '<', $request->hora_inicio)  // El nuevo horario empieza antes
                         ->where('hora_fin', '>', $request->hora_fin);  // Y termina después
              });
    })
    ->exists();

    // Si existe un conflicto, devolver un error
    if ($conflictoHorario) {
        throw ValidationException::withMessages([
            'horario' => 'El aula ya está ocupada en este horario por otro grupo.',
        ]);
    }

    // Si no existe un conflicto, proceder con la creación del horario
    GrupoHorario::create($validatedData);

    return response()->json(['message' => 'Horario creado con éxito.'], 201);
}


    // Mostrar un horario específico
    public function show($id)
    {
        $horario = GrupoHorario::find($id);
        if (!$horario) {
            return response()->json(['message' => 'Horario no encontrado'], 404);
        }
        return response()->json($horario);
    }

    public function update(Request $request, $id)
{
    $horario = GrupoHorario::find($id);
    if (!$horario) {
        return response()->json(['message' => 'Horario no encontrado'], 404);
    }

    // Validar los datos
    $validatedData = $request->validate([
        'grupo_id' => 'required|exists:grupos,id',
        'dia' => 'required|string',
        'hora_inicio' => 'required|date_format:H:i',
        'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
    ]);

    // Actualizar el horario
    $horario->update($validatedData);

    return response()->json(['message' => 'Horario actualizado con éxito.'], 200);
}


    // Eliminar un horario
    public function destroy($id)
    {
        $horario = GrupoHorario::find($id);
        if (!$horario) {
            return response()->json(['message' => 'Horario no encontrado'], 404);
        }

        $horario->delete();
        return response()->json(['message' => 'Horario eliminado'], 200);
    }
}
