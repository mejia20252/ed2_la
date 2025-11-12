<?php

namespace App\Http\Controllers;
use App\Models\Docente;
use App\Models\Aula;
use App\Models\Grupo;
use App\Models\CargaHoraria;

use Illuminate\Http\Request;

class CargaHorariaController extends Controller
{
    // Mostrar la vista para crear la carga horaria
      public function index()
    {
        // Obtener las cargas horarias junto con los datos de docente, grupo y aula
        $cargasHorarias = CargaHoraria::with(['docente', 'grupo', 'aula'])->get();
        return response()->json($cargasHorarias); // Devolver como JSON
    }

    // Mostrar la vista para crear la carga horaria (API)
    public function create()
    {
        $docentes = Docente::all(); // Obtener todos los docentes
        $grupos = Grupo::all(); // Obtener todos los grupos
        $aulas = Aula::all(); // Obtener todas las aulas

        return response()->json([
            'docentes' => $docentes,
            'grupos' => $grupos,
            'aulas' => $aulas
        ]); // Devolver como JSON
    }

    // Guardar la carga horaria
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'grupo_id' => 'required|exists:grupos,id',
            'aula_id' => 'required|exists:aulas,id',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'dia' => 'required|in:lunes,martes,miércoles,jueves,viernes',
        ]);

        // Crear la carga horaria
        $cargaHoraria = CargaHoraria::create([
            'docente_id' => $request->docente_id,
            'grupo_id' => $request->grupo_id,
            'aula_id' => $request->aula_id,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'dia' => $request->dia,
        ]);

        return response()->json(['message' => 'Carga horaria asignada correctamente.', 'data' => $cargaHoraria], 201); // Respuesta JSON
    }

    // Eliminar una carga horaria
    public function destroy($id)
    {
        $cargaHoraria = CargaHoraria::findOrFail($id);
        $cargaHoraria->delete();
        
        return response()->json(['message' => 'Carga horaria eliminada correctamente.'], 200); // Respuesta JSON
    }
}
