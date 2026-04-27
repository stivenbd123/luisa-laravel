<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Specialty;
use App\Models\Doctor;
use App\Models\ConsultingRoom;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        // Trae las citas con las relaciones cargadas para optimizar consultas
        $appointments = Appointment::with(['patient', 'doctor', 'consultingRoom'])
            ->orderBy('appointment_date', 'desc')
            ->get();
            
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name', 'asc')->get();
        $specialties = Specialty::orderBy('name', 'asc')->get();
        
        // No enviamos médicos ni consultorios aún, eso lo hará el AJAX
        return view('appointments.create', compact('patients', 'specialties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'         => 'required|exists:patients,id',
            'specialty_id'       => 'required|exists:specialties,id',
            'doctor_id'          => 'required|exists:doctors,id',
            'consulting_room_id' => 'required|exists:consulting_rooms,id',
            'appointment_date'   => 'required|date',
        ]);

        Appointment::create([
            'patient_id'         => $request->patient_id,
            'doctor_id'          => $request->doctor_id,
            'consulting_room_id' => $request->consulting_room_id,
            'appointment_date'   => $request->appointment_date,
            'status'             => 'Agendada', // Estado por defecto
            'notes'              => $request->notes
        ]);

        return redirect()->route('appointments.index')->with('success', 'Cita médica agendada y registrada en el sistema.');
    }

    // ==========================================
    // FUNCIÓN PARA LA PETICIÓN AJAX
    // ==========================================
    public function getDetailsBySpecialty($specialty_id)
    {
        // Busca los doctores y salas que pertenecen estrictamente a la especialidad seleccionada
        $doctors = Doctor::where('specialty_id', $specialty_id)->get();
        $rooms = ConsultingRoom::where('specialty_id', $specialty_id)->get();

        return response()->json([
            'doctors' => $doctors,
            'rooms'   => $rooms
        ]);
    }
    public function edit($id)
    {
        // Buscamos la cita y cargamos la información relacionada
        $appointment = Appointment::with(['patient', 'doctor', 'consultingRoom', 'doctor.specialty'])->findOrFail($id);
        
        return view('appointments.edit', compact('appointment'));
    }

    public function update(Request $request, $id)
    {
        // Validamos estrictamente que el estado sea uno de los permitidos por tu base de datos
        $request->validate([
            'status' => 'required|in:Agendada,Confirmada,Cancelada,Atendida',
            'notes'  => 'nullable|string'
        ]);

        $appointment = Appointment::findOrFail($id);
        
        $appointment->update([
            'status' => $request->status,
            'notes'  => $request->notes
        ]);

        return redirect()->route('appointments.index')->with('success', 'El estado de la cita ha sido actualizado.');
    }
}