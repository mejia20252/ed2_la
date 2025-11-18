<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\GrupoHorario;
use App\Models\AsistenciaDocente;
use App\Models\Grupo;
use App\Exports\AsistenciaDocentesExport;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AsistenciaDocenteController extends Controller
{
    // Mostrar el estado de la asistencia para un docente
    public function show(GrupoHorario $grupoHorario)
    {
        $docente = Auth::user()->docente;  // Obtener el docente autenticado

        // Verificar si el docente imparte el grupo en el horario
        $grupo = $grupoHorario->grupo;
        if (!$grupo->docente_id || $grupo->docente_id != $docente->id) {
            return response()->json(['error' => 'No tienes permiso para marcar asistencia en este grupo.'], 403);
        }

        return response()->json(['grupoHorario' => $grupoHorario]);
    }

    // Registrar la asistencia del docente
    public function marcarAsistencia(Request $request, GrupoHorario $grupoHorario)
    {
        $request->validate([
            'estado' => 'required|in:presente,ausente,justificado',
        ]);

        $docente = Auth::user()->docente;
        $grupo = $grupoHorario->grupo;

        // Verificar si el docente imparte el grupo en el horario
        if (!$grupo->docente_id || $grupo->docente_id != $docente->id) {
            return response()->json(['error' => 'No tienes permiso para marcar asistencia en este grupo.'], 403);
        }

        // Verificar si ya se registró la asistencia para este día
        $asistenciaExistente = AsistenciaDocente::where('docente_id', $docente->id)
            ->where('grupo_id', $grupo->id)
            ->where('grupo_horario_id', $grupoHorario->id)
            ->where('fecha', now()->toDateString())
            ->first();

        if ($asistenciaExistente) {
            return response()->json(['error' => 'Ya se ha marcado asistencia para hoy.'], 400);
        }

        // Registrar la asistencia
        $asistencia = AsistenciaDocente::create([
            'docente_id' => $docente->id,
            'grupo_id' => $grupo->id,
            'grupo_horario_id' => $grupoHorario->id,
            'estado' => $request->estado,
            'fecha' => now()->toDateString(),
        ]);

        return response()->json(['success' => 'Asistencia marcada correctamente.', 'asistencia' => $asistencia], 201);
    }
    public function generateAsistenciaDocentesPdf(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Obtener los datos de la base de datos
        $asistencias = AsistenciaDocente::whereBetween('fecha', [$fromDate, $toDate])
            ->get();

        // Crear el contenido del PDF
        $html = view('reportes.asistencia', compact('asistencias'))->render();

        // Crear el PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream('asistencia_docentes.pdf');
    }

    public function generateAsistenciaDocentesReport(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Obtener datos de la base de datos
        $asistencias = AsistenciaDocente::whereBetween('fecha', [$fromDate, $toDate])
            ->get();
        // Generar el archivo Excel
        return Excel::download(new AsistenciaDocentesExport($asistencias), 'asistencia_docentes.xlsx');
    }
    public function getAsistenciasDocente(Request $request)
    {
        // Obtener el docente autenticado
        $docenteId = $request->user()->docente->id;

        // Obtener las clases del docente
        $grupos = Grupo::where('docente_id', $docenteId)->get();

        // Obtener las asistencias de cada grupo para este docente
        $asistencias = [];

        foreach ($grupos as $grupo) {
            $asistencias[] = AsistenciaDocente::where('grupo_id', $grupo->id)->get();
        }

        // Devolver las asistencias
        return response()->json($asistencias);
    }

    
}
