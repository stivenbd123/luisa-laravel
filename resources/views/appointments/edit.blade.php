@extends('layouts.app')

@section('title', 'Gestionar Cita | MediSys')

@section('content')
<style>
    .form-container {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        padding: 40px;
        max-width: 600px;
        margin: 0 auto;
        border-top: 4px solid #0f172a;
    }
    .form-title {
        color: #0f172a;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 25px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 15px;
    }
    
    .info-card {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 25px;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
    }
    .info-label { color: #64748b; font-weight: 600; }
    .info-value { color: #0f172a; font-weight: 500; }
    
    .form-group { margin-bottom: 20px; }
    .form-label {
        display: block;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 14px;
        color: #1e293b;
        background-color: #ffffff;
        transition: border-color 0.2s;
    }
    .form-control:focus { outline: none; border-color: #0284c7; }
    
    .form-actions { display: flex; justify-content: space-between; margin-top: 30px; }
    .btn-cancel { color: #64748b; text-decoration: none; padding: 12px 20px; font-size: 14px; font-weight: 500; }
    .btn-submit { background-color: #0284c7; color: #ffffff; border: none; padding: 12px 25px; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; }
    .btn-submit:hover { background-color: #0369a1; }
</style>

<div class="form-container">
    <h2 class="form-title">Gestión de Cita Médica</h2>

    <div class="info-card">
        <div class="info-row">
            <span class="info-label">Paciente:</span>
            <span class="info-value">{{ $appointment->patient->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Médico:</span>
            <span class="info-value">Dr./Dra. {{ $appointment->doctor->name }} ({{ $appointment->doctor->specialty->name }})</span>
        </div>
        <div class="info-row">
            <span class="info-label">Fecha y Hora:</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row" style="margin-bottom: 0;">
            <span class="info-label">Consultorio:</span>
            <span class="info-value">{{ $appointment->consultingRoom->name }}</span>
        </div>
    </div>

    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT') <div class="form-group">
            <label class="form-label">Estado de la Cita</label>
            <select name="status" class="form-control" required>
                <option value="Agendada" {{ $appointment->status === 'Agendada' ? 'selected' : '' }}>Agendada</option>
                <option value="Confirmada" {{ $appointment->status === 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                <option value="Atendida" {{ $appointment->status === 'Atendida' ? 'selected' : '' }}>Atendida</option>
                <option value="Cancelada" {{ $appointment->status === 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Observaciones / Motivo de Cancelación</label>
            <textarea name="notes" class="form-control" rows="4" placeholder="Registre detalles adicionales...">{{ $appointment->notes }}</textarea>
        </div>

        <div class="form-actions">
            <a href="{{ route('appointments.index') }}" class="btn-cancel">Volver</a>
            <button type="submit" class="btn-submit">Guardar Cambios</button>
        </div>
    </form>
</div>
@endsection