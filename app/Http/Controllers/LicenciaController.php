<?php

namespace App\Http\Controllers;

use App\Models\Licencia;
use App\Http\Resources\LicenciaResource;
use Illuminate\Http\Request;

class LicenciaController extends Controller
{
    public function index(Request $request)
    {
        // Verificar si el usuario tiene un docente asociado
        if (!$request->user()->docente) {
            return response()->json(['error' => 'No se encuentra un docente asociado al usuario'], 400);
        }

        $docenteId = $request->user()->docente->id;
        $licencias = Licencia::where('docente_id', $docenteId)->get();

        return LicenciaResource::collection($licencias);
    }
    public function store(Request $request)
    {
        // Verificar si el usuario tiene un docente asociado
        $docente = $request->user()->docente;
        if (!$docente) {
            return response()->json(['error' => 'No se encuentra un docente asociado al usuario'], 400);
        }

        // Validar los datos recibidos en la solicitud
        $validated = $request->validate([
            'tipo' => 'required|in:maternidad,enfermedad,personal,otro',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'motivo' => 'nullable|string',
        ]);

        // Crear la nueva licencia
        $licencia = Licencia::create([
            'docente_id' => $docente->id,  // Usamos el ID del docente autenticado
            'tipo' => $validated['tipo'],
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_fin' => $validated['fecha_fin'],
            'estado' => 'pendiente',  // Inicialmente la licencia está pendiente
            'motivo' => $validated['motivo'],
        ]);

        return response()->json(new LicenciaResource($licencia), 201);
    }
    public function updateEstado(Request $request, $id)
    {
        
        // Buscar la licencia
        $licencia = Licencia::findOrFail($id);

        // Validar el estado
        $validated = $request->validate([
            'estado' => 'required|in:aprobada,rechazada',  // Solo permite aprobar o rechazar
        ]);

        // Actualizar el estado de la licencia
        $licencia->update([
            'estado' => $validated['estado'],  // Asigna el nuevo estado
        ]);

        // Devolver la respuesta con los datos actualizados de la licencia
        return response()->json(['message' => 'Estado de la licencia actualizado correctamente', 'licencia' => $licencia], 200);
    }

    public function update(Request $request, $id)
    {
        // Buscar la licencia
        $licencia = Licencia::findOrFail($id);

        // Verificar si el usuario tiene un docente asociado
        if (!$request->user()->docente) {
            return response()->json(['error' => 'No se encuentra un docente asociado al usuario'], 400);
        }

        // Validar que el docente autenticado sea el dueño de la licencia
        if ($licencia->docente_id !== $request->user()->docente->id) {
            return response()->json(['error' => 'No tienes permiso para actualizar esta licencia'], 403);
        }

        $validated = $request->validate([
            'estado' => 'required|in:aprobada,rechazada',
        ]);

        $licencia->update([
            'estado' => $validated['estado'],
        ]);

        return response()->json(new LicenciaResource($licencia));
    }
    public function allLicencias(Request $request)
    {
       
        // Obtener todas las licencias (incluidas aprobadas, rechazadas, y pendientes)
        $licencias = Licencia::all();  // Si quieres agregar paginación, puedes usar ->paginate()

        // Retornar las licencias en formato JSON
        return LicenciaResource::collection($licencias);
    }

    public function destroy(Request $request, $id)
    {
        // Buscar la licencia
        $licencia = Licencia::findOrFail($id);

        // Verificar si el usuario tiene un docente asociado
        if (!$request->user()->docente) {
            return response()->json(['error' => 'No se encuentra un docente asociado al usuario'], 400);
        }

        // Validar que el docente autenticado sea el dueño de la licencia
        if ($licencia->docente_id !== $request->user()->docente->id) {
            return response()->json(['error' => 'No tienes permiso para eliminar esta licencia'], 403);
        }

        // Eliminar la licencia
        $licencia->delete();

        return response()->json(['message' => 'Licencia eliminada exitosamente']);
    }
}
