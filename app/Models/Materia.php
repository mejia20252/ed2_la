<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
      // Desactivar timestamps
    public $timestamps = false;
    protected $table = 'materias';
     protected $fillable = [
        'nombre',
        'codigo',
        'creditos',
        'hps',
    ];
    

}
