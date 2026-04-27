<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $fillable = ['name'];

    // Una especialidad tiene varios médicos
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    // Una especialidad tiene varios consultorios
    public function consultingRooms()
    {
        return $this->hasMany(ConsultingRoom::class);
    }
}