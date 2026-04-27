
@extends('layouts.app')

@section('title', 'Pacientes | MediSys')

@section('content')
<style>
    .module-container {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        padding: 30px;
        border-top: 4px solid #0f172a;
    }
    .module-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f5f9;
    }
    .module-title {
        color: #0f172a;
        font-size: 20px;
        font-weight: 600;
    }
    .btn-primary {
        background-color: #0284c7;
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        transition: background-color 0.2s;
    }
    .btn-primary:hover {
        background-color: #0369a1;
    }
    .alert-success {
        background-color: #f0fdf4;
        color: #166534;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #bbf7d0;
        margin-bottom: 20px;
        font-size: 14px;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th {
        background-color: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        padding: 15px;
        text-align: left;
        border-bottom: 2px solid #e2e8f0;
    }
    .data-table td {
        padding: 16px 15px;
        color: #334155;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
    }
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #64748b;
        font-style: italic;
    }
</style>

<div class="module-container">
    <div class="module-header">
        <h2 class="module-title">Directorio de Pacientes</h2>
        <a href="{{ route('patients.create') }}" class="btn-primary">Registrar Paciente</a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="data-table">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Nombre Completo</th>
                <th>Correo Electrónico</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody>
            @forelse($patients as $patient)
                <tr>
                    <td><strong>{{ $patient->document }}</strong></td>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->phone ?? 'No registrado' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="empty-state">No hay pacientes registrados en el sistema.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection