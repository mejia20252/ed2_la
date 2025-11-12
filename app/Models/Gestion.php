<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    public $timestamps = false;
    protected $table = 'gestiones';

    // Definir los campos que son asignables en masa
    protected $fillable = [
        'year',
        'periodo',
        'inicio',
        'fin',
        'estado'
    ];
     public static $rules = [
        'year' => 'required|integer',
        'periodo' => 'required|string|max:255',
        'inicio' => 'required|date',
        'fin' => 'required|date|',
        'estado' => 'required|in:abierto,cerrado,en curso'
    ];

}
