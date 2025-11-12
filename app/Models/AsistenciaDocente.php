<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsistenciaDocente extends Model
{
  
    protected $table = 'asistencias_docentes';
    public $timestamps = false;

    protected $fillable = [
        'docente_id',
        'grupo_id',
        'grupo_horario_id',
        'estado',  // (presente, ausente, justificado)
        'fecha'
    ];

    // Relación con el docente
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    // Relación con el grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    // Relación con el grupo horario
    public function grupoHorario()
    {
        return $this->belongsTo(GrupoHorario::class);
    }
}
