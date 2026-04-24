<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';

    protected $primaryKey = 'id_paciente';

    public $timestamps = false;

    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'numero_de_cedula',
        'correo_electronico',
        'direccion',
        'numero_de_celular'
    ];
}