<?php

namespace App\Models;
use App\Models\User;
use App\Models\Materia;
use App\Models\Gestion;
use App\Models\Docente;
use App\Models\GrupoHorario;
use App\Models\Aula;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
   // Desactivar los timestamps si no los vas a usar
    public $timestamps = false;

    // Especificar la tabla si el nombre de la tabla no es plural de la clase
    protected $table = 'grupos';

    // Definir los campos que son asignables en masa
    protected $fillable = [
        'materia_id',   // Renombrado a materia_id
        'gestion_id',   // Renombrado a gestion_id
        'codigo',
        'capacidad',
        'modalidad',
        'docente_id',   // Renombrado a docente_id
        'aula_id',      // Renombrado a aula_id
       
    ];

    // Definir las relaciones con otros modelos
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');  // Relación con la tabla 'materias'
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class, 'gestion_id');  // Relación con la tabla 'gestiones'
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');  // Relación con la tabla 'docentes'
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class, 'aula_id');  // Relación con la tabla 'aulas'
    }
     // <<--- FALTA ESTO
    public function horarios()
    {
        return $this->hasMany(GrupoHorario::class, 'grupo_id');
    }
}
