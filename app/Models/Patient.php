<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['document', 'name', 'email', 'phone'];

    // Un paciente puede tener muchas citas
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}