<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Campos que permitimos guardar en la base de datos
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Campos que se ocultan al hacer consultas (por seguridad)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casteo de tipos de datos
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}