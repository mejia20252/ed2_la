<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargaHoraria extends Model
{
    public $timestamps = false;

     protected $table = 'carga_horarias';

    // Especificamos los campos que se pueden asignar de manera masiva
    protected $fillable = [
        'docente_id',
        'grupo_id',
        'aula_id',
        'hora_inicio',
        'hora_fin',
        'dia',
    ];

    // Relaciones
    public function docente()
    {
        return $this->belongsTo(Docente::class); // Relación con el modelo Docente
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class); // Relación con el modelo Grupo
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class); // Relación con el modelo Aula
    }
}
