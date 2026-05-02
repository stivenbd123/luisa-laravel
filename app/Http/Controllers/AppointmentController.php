<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Specialty;
use App\Models\Doctor;
use App\Models\ConsultingRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

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


public function sendReminder($id)
{
    // Buscamos la cita con la información del paciente y el médico
    $appt = Appointment::with(['patient', 'doctor', 'consultingRoom'])->findOrFail($id);

    try {
        $data = [
            'patient_name' => $appt->patient->name,
            'date' => Carbon::parse($appt->appointment_date)->format('d/m/Y h:i A'),
            'doctor' => $appt->doctor->name,
            'room' => $appt->consultingRoom->name,
        ];

        // Envío del correo usando el Facade de Mail de Laravel
        Mail::send([], [], function ($message) use ($appt, $data) {
            $message->to($appt->patient->email)
                ->subject('Recordatorio de Cita Médica - MediSys')
                ->html("
                    <div style='font-family: sans-serif; color: #334155; max-width: 600px; border: 1px solid #e2e8f0; padding: 20px; border-radius: 8px;'>
                        <h2 style='color: #0284c7;'>Recordatorio de Cita</h2>
                        <p>Hola <strong>{$data['patient_name']}</strong>,</p>
                        <p>Te escribimos de <strong>MediSys Clinic</strong> para recordarte tu próxima cita programada:</p>
                        <div style='background: #f8fafc; padding: 15px; border-radius: 6px; margin: 20px 0;'>
                            <p style='margin: 5px 0;'><strong>📅 Fecha y Hora:</strong> {$data['date']}</p>
                            <p style='margin: 5px 0;'><strong>👨‍⚕️ Médico:</strong> Dr./Dra. {$data['doctor']}</p>
                            <p style='margin: 5px 0;'><strong>🏥 Consultorio:</strong> {$data['room']}</p>
                        </div>
                        <p style='font-size: 13px; color: #64748b;'>Si no puedes asistir, por favor infórmanos con al menos 24 horas de antelación. Te recomendamos llegar 15 minutos antes de la hora pactada.</p>
                        <hr style='border: 0; border-top: 1px solid #e2e8f0; margin: 20px 0;'>
                        <p style='font-size: 11px; text-align: center; color: #94a3b8;'>Este es un mensaje automático, por favor no respondas a este correo.</p>
                    </div>
                ");
        });

        return response()->json([
            'success' => true, 
            'message' => 'El recordatorio ha sido enviado con éxito al correo del paciente.'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false, 
            'message' => 'Hubo un error al intentar enviar el correo: ' . $e->getMessage()
        ], 500);
    }
}
}