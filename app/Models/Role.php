<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public $timestamps = false;
    // Asegúrate de que 'descripcion' esté en $fillable para que se pueda asignar masivamente
    protected $fillable = ['nombre'];

    // Relación con los usuarios (un rol puede tener muchos usuarios)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}