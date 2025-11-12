<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'username',
        'email',
        'apellido_paterno',
        'apellido_materno',
        'sexo',
        'direccion',
        'fecha_nacimiento',
        'rol',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',  // Ocultar el campo `created_at`
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Métodos requeridos por JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    } // Relación con el rol (un usuario pertenece a un rol)
    public function rol()
    {
        return $this->belongsTo(Role::class, 'rol');
    }
    public function docente()
    {
        return $this->hasOne(Docente::class);
    }
}
