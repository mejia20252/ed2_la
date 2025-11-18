<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunicado extends Model
{
    //
    public $timestamps = false;
    protected $fillable = [
        'titulo',
        'contenido',
        'fecha',
        'usuario_id',
        'archivo',
    ];

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

}
