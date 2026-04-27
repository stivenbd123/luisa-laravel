@extends('layouts.app')

@section('title', 'Consultorios | MediSys')

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
    .badge-room {
        background-color: #f1f5f9;
        color: #334155;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #cbd5e1;
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
        <h2 class="module-title">Gestión de Consultorios</h2>
        <a href="{{ route('consulting_rooms.create') }}" class="btn-primary">Añadir Consultorio</a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 15%;">ID</th>
                <th style="width: 45%;">Identificador de Sala</th>
                <th style="width: 40%;">Área Médica Asignada</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td><strong>{{ $room->name }}</strong></td>
                    <td>
                        <span class="badge-room">
                            {{ $room->specialty->name ?? 'Sin asignar' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="empty-state">No hay consultorios registrados en el sistema.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection