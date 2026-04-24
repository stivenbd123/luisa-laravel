<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    // Nombre real de la tabla
    protected $table = 'usuarios';

    // Clave primaria personalizada
    protected $primaryKey = 'id_usuario';

    // Si tu tabla NO tiene created_at y updated_at
    public $timestamps = false;

    // Campos que se pueden insertar masivamente
    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'numero_de_cedula',
        'correo_electronico',
        'direccion',
        'numero_de_celular',
        'contraseña',
        'rol'
    ];

    // ===============================
    // Equivalente a correoExiste()
    // ===============================
    public static function correoExiste($correo)
    {
        return self::where('correo_electronico', $correo)->exists();
    }

    // ===============================
    // Equivalente a login()
    // ===============================
    public static function login($correo)
    {
        return self::where('correo_electronico', $correo)->first();
    }

    // ===============================
    // Obtener todos (como tu método)
    // ===============================
    public static function obtenerUsuarios()
    {
        return self::orderBy('id_usuario', 'desc')->get();
    }

    // ===============================
    // Obtener por ID
    // ===============================
    public static function obtenerPorId($id)
    {
        return self::find($id);
    }
}