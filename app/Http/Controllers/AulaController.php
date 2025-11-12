<?php

namespace App\Http\Controllers;
use App\Models\Aula;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    public  function index(){
        $aulas=Aula::all();
        return response()->json($aulas);
    }
    public function store(Request $request)
    {
      
        // Validar los datos de entrada
        $validated = $request->validate([
            'codigo' => 'required|unique:aulas,codigo',
            'nombre' => 'required|string|max:255',
            'capacidad' => 'required|integer',
            'ubicacion' => 'required|string|max:255',
            'estado' => 'required|string|max:50',
        ]);

        // Crear el aula con los datos validados
        $aula = Aula::create($validated);

        return response()->json($aula, 201);  // Retorna la aula recién creada
    }

    // Mostrar una aula específica
    public function show($id)
    {
        $aula = Aula::find($id);

        if (!$aula) {
            return response()->json(['message' => 'Aula no encontrada'], 404);
        }

        return response()->json($aula);
    }

    // Actualizar una aula
    public function update(Request $request, $id)
    {
        $aula = Aula::find($id);

        if (!$aula) {
            return response()->json(['message' => 'Aula no encontrada'], 404);
        }

        // Validar los datos de entrada
        $validated = $request->validate([
            'codigo' => 'required|unique:aulas,codigo,' . $id,
            'nombre' => 'required|string|max:255',
            'capacidad' => 'required|integer',
            'ubicacion' => 'required|string|max:255',
            'estado' => 'required|string|max:50',
        ]);

        // Actualizar el aula con los nuevos datos
        $aula->update($validated);

        return response()->json($aula);
    }

    // Eliminar una aula
    public function destroy($id)
    {
        $aula = Aula::find($id);

        if (!$aula) {
            return response()->json(['message' => 'Aula no encontrada'], 404);
        }

        // Eliminar el aula
        $aula->delete();

        return response()->json(['message' => 'Aula eliminada exitosamente']);
    }
}
