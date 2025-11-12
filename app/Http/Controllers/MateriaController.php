<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $materias = Materia::all();
        return response()->json($materias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('materias') // Asegura que el código sea único en la tabla 'materias'
            ],
            'creditos' => 'required|integer|min:0',
            'hps' => 'required|integer|min:0',
        ]);

        // Creación del nuevo registro
        $materia = Materia::create($validatedData);

        // Retorna la materia creada con un estado 201 (Created)
        return response()->json($materia, 201);
    }

    /**
     * Display the specified resource.
     */
    // ... dentro de la clase MateriaController

/**
 * Display the specified resource.
 */
public function show($id)
{
    // 1. Buscar la materia por su ID
    $materia = Materia::find($id);

    // 2. Verificar si la materia fue encontrada
    if (is_null($materia)) {
        // Si no se encuentra, retorna una respuesta 404 (Not Found)
        // Puedes personalizar el mensaje si lo deseas
        return response()->json(['message' => 'Materia no encontrada'], 404);
    }

    // 3. Si se encuentra, retorna la materia en formato JSON
    return response()->json($materia);
}
// ...
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materia $materia)
    {
         // Validación similar a 'store', pero permite campos opcionales (sometimes)
        // y ajusta la regla 'unique' para ignorar el ID actual
        $validatedData = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'codigo' => [
                'sometimes',
                'nullable',
                'string',
                'max:100',
                Rule::unique('materias')->ignore($materia->id) // Ignora el ID actual al chequear
            ],
            'creditos' => 'sometimes|required|integer|min:0',
            'hps' => 'sometimes|required|integer|min:0',
        ]);

        // Actualiza el modelo
        $materia->update($validatedData);

        // Retorna la materia actualizada
        return response()->json($materia);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materia $materia)
    {
        // Elimina el registro
        $materia->delete();

        // Retorna una respuesta vacía con estado 204 (No Content)
        return response()->json(null, 204);
    }
}
