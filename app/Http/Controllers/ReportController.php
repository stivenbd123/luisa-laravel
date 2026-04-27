<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // ==========================================
    // MÓDULO: HISTORIAL CLÍNICO INDIVIDUAL
    // ==========================================

    public function index(Request $request)
    {
        $search = $request->input('search');

        $patients = Patient::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('document', 'like', "%{$search}%");
        })->orderBy('name', 'asc')->paginate(10);

        return view('reports.index', compact('patients', 'search'));
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        
        $appointments = Appointment::with(['doctor', 'consultingRoom', 'doctor.specialty'])
            ->where('patient_id', $id)
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('reports.show', compact('patient', 'appointments'));
    }

    // Exportar el expediente de un paciente (PDF o CSV puro)
    public function exportPatientHistory($id, $format)
    {
        $patient = Patient::findOrFail($id);
        $appointments = Appointment::with(['doctor', 'consultingRoom', 'doctor.specialty'])
            ->where('patient_id', $id)
            ->orderBy('appointment_date', 'desc')
            ->get();

        if ($format === 'pdf') {
            return view('reports.pdf_patient', compact('patient', 'appointments'));
        }

        // CSV NATIVO: Rápido y sin errores de Excel
        $filename = "historial_" . str_replace(' ', '_', $patient->name) . ".csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($appointments) {
            $file = fopen('php://output', 'w');
            
            // Forzar UTF-8 para evitar caracteres extraños en las tildes
            fputs($file, "\xEF\xBB\xBF"); 
            
            fputcsv($file, ['Fecha de Cita', 'Medico Asignado', 'Especialidad', 'Consultorio', 'Estado', 'Observaciones'], ';');

            foreach ($appointments as $appt) {
                fputcsv($file, [
                    \Carbon\Carbon::parse($appt->appointment_date)->format('d/m/Y H:i'),
                    "Dr. " . $appt->doctor->name,
                    $appt->doctor->specialty->name ?? 'N/A',
                    $appt->consultingRoom->name,
                    strtoupper($appt->status),
                    $appt->notes ?? 'Sin observaciones'
                ], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    // ==========================================
    // MÓDULO: REPORTES GLOBALES ADMINISTRATIVOS
    // ==========================================

    public function exportsView()
    {
        $doctors = Doctor::orderBy('name', 'asc')->get();
        $specialties = Specialty::orderBy('name', 'asc')->get();
        
        return view('reports.exports', compact('doctors', 'specialties'));
    }

    public function generateReport(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor', 'consultingRoom', 'doctor.specialty'])
            ->orderBy('appointment_date', 'desc');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('appointment_date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->filled('specialty_id')) {
            $query->whereHas('doctor', function($q) use ($request) {
                $q->where('specialty_id', $request->specialty_id);
            });
        }

        $appointments = $query->get();

        if ($request->input('format') === 'pdf') {
            return view('reports.pdf', compact('appointments'));
        }

        // CSV NATIVO: Rápido y sin errores de Excel
        $filename = "reporte_citas_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($appointments) {
            $file = fopen('php://output', 'w');
            
            // Forzar UTF-8 para evitar caracteres extraños en las tildes
            fputs($file, "\xEF\xBB\xBF"); 
            
            fputcsv($file, ['Fecha de Cita', 'Paciente', 'Documento', 'Medico Asignado', 'Especialidad', 'Consultorio', 'Estado'], ';');

            foreach ($appointments as $appt) {
                fputcsv($file, [
                    \Carbon\Carbon::parse($appt->appointment_date)->format('d/m/Y H:i'),
                    $appt->patient->name,
                    $appt->patient->document,
                    "Dr. " . $appt->doctor->name,
                    $appt->doctor->specialty->name ?? 'N/A',
                    $appt->consultingRoom->name,
                    strtoupper($appt->status)
                ], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}