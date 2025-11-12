<?php

namespace App\Http\Controllers;
use App\Models\Gestion;

use Illuminate\Http\Request;

class GestionController extends Controller
{
     public function index()
    {
        $gestiones = Gestion::all();
        return response()->json($gestiones);
    }

    /**
     * Mostrar una gestión específica.
     */
    public function show($id)
    {
        $gestion = Gestion::find($id);

        if (!$gestion) {
            return response()->json(['message' => 'Gestión no encontrada'], 404);
        }

        return response()->json($gestion);
    }

    /**
     * Crear una nueva gestión.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate(Gestion::$rules);

        // Crear la gestión
        $gestion = Gestion::create($request->all());

        return response()->json(['message' => 'Gestión creada con éxito', 'gestion' => $gestion], 201);
    }

    /**
     * Actualizar una gestión existente.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos
        $request->validate(Gestion::$rules);

        $gestion = Gestion::find($id);

        if (!$gestion) {
            return response()->json(['message' => 'Gestión no encontrada'], 404);
        }

        // Actualizar la gestión
        $gestion->update($request->all());

        return response()->json(['message' => 'Gestión actualizada con éxito', 'gestion' => $gestion]);
    }

    /**
     * Eliminar una gestión.
     */
    public function destroy($id)
    {
        $gestion = Gestion::find($id);

        if (!$gestion) {
            return response()->json(['message' => 'Gestión no encontrada'], 404);
        }

        // Eliminar la gestión
        $gestion->delete();

        return response()->json(['message' => 'Gestión eliminada con éxito']);
    }
}
