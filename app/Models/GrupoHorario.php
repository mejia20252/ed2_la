<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoHorario extends Model
{ 
    public $timestamps = false;

    // Tabla a la que se asocia este modelo
    protected $table = 'grupo_horarios';

    // Los atributos que son asignables
    protected $fillable = ['grupo_id', 'dia', 'hora_inicio', 'hora_fin'];

   // Relación con el modelo Grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
}
