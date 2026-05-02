@extends('layouts.app')

@section('title', 'Agenda de Citas | MediSys')

@section('content')
<div class="module-container" style="background: white; padding: 30px; border-radius: 12px; border-top: 4px solid #0f172a;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 style="color: #0f172a; font-size: 20px; font-weight: 600;">Agenda General de Citas</h2>
        <a href="{{ route('appointments.create') }}" style="background: #0284c7; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-size: 14px; font-weight: 600;">Nueva Cita</a>
    </div>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                <th style="padding: 15px; text-align: left; font-size: 12px; color: #475569; text-transform: uppercase;">Fecha y Hora</th>
                <th style="padding: 15px; text-align: left; font-size: 12px; color: #475569; text-transform: uppercase;">Paciente</th>
                <th style="padding: 15px; text-align: left; font-size: 12px; color: #475569; text-transform: uppercase;">Médico</th>
                <th style="padding: 15px; text-align: left; font-size: 12px; color: #475569; text-transform: uppercase;">Estado</th>
                <th style="padding: 15px; text-align: left; font-size: 12px; color: #475569; text-transform: uppercase;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appt)
                <tr style="border-bottom: 1px solid #f1f5f9;">
                    <td style="padding: 15px; font-size: 14px;"><strong>{{ $appt->appointment_date }}</strong></td>
                    <td style="padding: 15px; font-size: 14px;">{{ $appt->patient->name }}</td>
                    <td style="padding: 15px; font-size: 14px;">Dr. {{ $appt->doctor->name }}</td>
                    <td style="padding: 15px; font-size: 14px;">
                        <span style="background: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">{{ $appt->status }}</span>
                    </td>
                    <td style="padding: 15px;">
                        <button onclick="enviarRecordatorio({{ $appt->id }})" id="btn-rem-{{ $appt->id }}" style="background: #0f172a; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                            <span>📧</span> Enviar Recordatorio
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
function enviarRecordatorio(appointmentId) {
    const btn = document.getElementById('btn-rem-' + appointmentId);
    const originalContent = btn.innerHTML;
    
    // Feedback visual inmediato
    btn.innerHTML = '<span>⏳</span> Enviando...';
    btn.style.opacity = '0.7';
    btn.disabled = true;

    fetch(`/appointments/${appointmentId}/send-reminder`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ Éxito: ' + data.message);
            btn.innerHTML = '<span>✅</span> Enviado';
            btn.style.background = '#166534';
        } else {
            alert('❌ Error: ' + data.message);
            btn.innerHTML = originalContent;
            btn.disabled = false;
            btn.style.opacity = '1';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error de conexión con el servidor.');
        btn.innerHTML = originalContent;
        btn.disabled = false;
        btn.style.opacity = '1';
    });
}
</script>
@endsection