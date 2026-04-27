<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = ['name', 'specialty_id'];

    // Un médico pertenece a una especialidad
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    // Un médico puede tener muchas citas
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}