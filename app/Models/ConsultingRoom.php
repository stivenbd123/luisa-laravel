<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultingRoom extends Model
{
    protected $fillable = ['name', 'specialty_id'];

    // Un consultorio pertenece a una especialidad
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    // En un consultorio se pueden dar muchas citas
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}