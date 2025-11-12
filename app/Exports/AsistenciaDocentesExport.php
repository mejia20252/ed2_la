<?php

namespace App\Exports;

use App\Models\AsistenciaDocente;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AsistenciaDocentesExport implements FromQuery, WithHeadings
{
    protected $asistencias;

    // Se usa FromQuery en lugar de FromCollection
    public function query()
    {
        return AsistenciaDocente::query(); // Puedes filtrar los resultados según sea necesario
    }

    // Agregar los encabezados en la hoja de Excel
    public function headings(): array
    {
        return [
            'ID Docente',
            'ID Grupo',
            'Fecha',
            'Estado',
        ];
    }
}
