@extends('layouts.app')

@section('title', 'Expediente: ' . $patient->name)

@section('content')
<style>
    .patient-header { background: #0f172a; color: white; padding: 30px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center; }
    .history-container { background: white; padding: 30px; border-radius: 0 0 12px 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
    .appointment-item { border-left: 3px solid #0284c7; padding: 20px; margin-bottom: 20px; background: #f8fafc; border-radius: 0 8px 8px 0; }
    .appt-date { font-weight: 700; color: #0284c7; margin-bottom: 5px; display: block; }
    .appt-meta { font-size: 13px; color: #64748b; margin-bottom: 10px; }
    .appt-notes { font-size: 14px; color: #334155; line-height: 1.6; background: white; padding: 10px; border-radius: 4px; border: 1px solid #e2e8f0; }
    
    .btn-download { padding: 8px 15px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; color: white; margin-left: 10px; }
    .btn-pdf { background-color: #dc2626; }
    .btn-excel { background-color: #166534; }
</style>

<div class="patient-header">
    <div>
        <a href="{{ route('reports.index') }}" style="color: #cbd5e1; text-decoration: none; font-size: 13px;">← Volver al listado</a>
        <h2 style="margin-top: 10px;">{{ $patient->name }}</h2>
        <p style="color: #94a3b8; font-size: 14px;">Documento: {{ $patient->document }}</p>
    </div>
    <div>
        <span style="font-size: 12px; color: #94a3b8; display: block; margin-bottom: 8px; text-align: right;">Descargar Expediente:</span>
        <a href="{{ route('reports.patient.export', [$patient->id, 'pdf']) }}" class="btn-download btn-pdf" target="_blank">PDF</a>
        <a href="{{ route('reports.patient.export', [$patient->id, 'excel']) }}" class="btn-download btn-excel">Excel</a>
    </div>
</div>

<div class="history-container">
    <h3 style="margin-bottom: 25px; color: #0f172a;">Línea de Tiempo de Consultas</h3>

    @forelse($appointments as $appt)
    <div class="appointment-item">
        <span class="appt-date">{{ \Carbon\Carbon::parse($appt->appointment_date)->format('d/m/Y - h:i A') }}</span>
        <div class="appt-meta">
            Atendido por: <strong>Dr./Dra. {{ $appt->doctor->name }}</strong> ({{ $appt->doctor->specialty->name }}) 
            en <strong>{{ $appt->consultingRoom->name }}</strong>
            <span style="margin-left: 10px; font-weight: bold; color: #0f172a;">[{{ $appt->status }}]</span>
        </div>
        <div class="appt-notes">
            <strong>Observaciones Clínicas:</strong><br>
            {{ $appt->notes ?? 'Sin observaciones registradas.' }}
        </div>
    </div>
    @empty
    <p style="text-align: center; color: #64748b; padding: 40px;">Este paciente no tiene citas registradas.</p>
    @endforelse
</div>
@endsection