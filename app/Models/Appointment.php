<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id', 
        'doctor_id', 
        'consulting_room_id', 
        'appointment_date', 
        'status', 
        'notes'
    ];

    // Relaciones (A quién pertenece esta cita)
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function consultingRoom()
    {
        return $this->belongsTo(ConsultingRoom::class);
    }
}