<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Comunicado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ComunicadoController extends Controller
{
    /**a
     * Display a listing of the resource.
     */
    public function index()
    {
        $comunicados = Comunicado::all(); // Obtiene todos los comunicados
        return response()->json([
            'data' => $comunicados
        ], 200); // Retorna los comunicados en formato JSON
    }
    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha' => 'required|date',
            'archivo' => 'nullable|file', // Validar si el archivo es una carga válida
        ]);

        // Subir el archivo a GCP si existe
        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('comunicados', 'gcs'); // Subir el archivo al bucket GCS
        } else {
            $path = null; // Si no hay archivo, dejamos el valor como null
        }

        // Crear el nuevo comunicado
        $comunicado = Comunicado::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'fecha' => $request->fecha,
            'usuario_id' => Auth::id(),// Guardamos el ID del usuario autenticado
            'archivo' => $path, // Ruta del archivo en el bucket GCP (si se subió)
        ]);

        // Retornar respuesta en formato JSON
        return response()->json([
            'message' => 'Comunicado creado exitosamente',
            'data' => $comunicado
        ], 201); // Código 201 para creación exitosa
    }

    /**
     * Display the specified resource.
     */
    public function show(Comunicado $comunicado)
    {
        //
           return response()->json([
            'data' => $comunicado
        ], 200); // Muestra el comunicado en formato JSON
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comunicado $comunicado)
    {
        //
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha' => 'required|date',
            'archivo' => 'nullable|file', // Validación para el archivo
        ]);

        // Subir el archivo si se ha cargado uno nuevo
        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('comunicados', 'gcs'); // Subir el archivo al bucket GCS
        } else {
            $path = $comunicado->archivo; // Si no se carga un archivo, mantenemos el anterior
        }

        // Actualizar el comunicado
        $comunicado->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'fecha' => $request->fecha,
            'archivo' => $path, // Ruta del archivo
        ]);

        // Retornar respuesta en formato JSON
        return response()->json([
            'message' => 'Comunicado actualizado exitosamente.',
            'data' => $comunicado
        ], 200); // Código de estado 20
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comunicado $comunicado)
    {
        //
        // Eliminar el archivo si existe en el GCP
        if ($comunicado->archivo) {
            Storage::disk('gcs')->delete($comunicado->archivo); // Elimina el archivo del GCP
        }

        $comunicado->delete(); // Eliminar el comunicado

        // Retornar respuesta en formato JSON
        return response()->json([
            'message' => 'Comunicado eliminado exitosamente.'
        ], 200); // Código de estado 200 para eliminación exitosa
    }
    
}

