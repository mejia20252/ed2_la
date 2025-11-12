<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    // Desactivar timestamps
    public $timestamps = false;
    //Especificamos el nombre de la tabla
    protected $table = 'aulas';
    // Especificamos los campos que pueden ser asignados masivamente
    protected $fillable = [
        'codigo',
        'nombre',
        'capacidad',
        'ubicacion',
        'estado',
    ];
    protected $casts = [
        'creditos' => 'integer',
        'hps' => 'integer',
    ];
}
