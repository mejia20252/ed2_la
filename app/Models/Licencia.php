<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Licencia extends Model
{
    
    public $timestamps = false;
    protected $table = 'licencias';

      protected $fillable = [
        'docente_id',
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'motivo',
    ];

    // Relación con el docente
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }
}
