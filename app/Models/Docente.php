<?php

namespace App\Models;
use App\Models\Grupo;
use App\Models\User;


use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    public $timestamps = false;
    protected $table = 'docentes';

    // Atributos que pueden ser asignados masivamente
    protected $fillable = [
        'user_id',
        'registro',
        'especialidad',
    ];

    // Relación con el modelo User (un docente pertenece a un usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relación con el modelo Grupo (un docente puede tener muchos grupos)
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'docente_id');
    }

    // Relación con los horarios de los grupos
    public function gruposConHorarios()
    {
        return $this->hasMany(Grupo::class)->with('horarios'); // Traer grupos con horarios
    }
    
}
