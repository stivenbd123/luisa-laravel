@extends('layouts.app')

@section('title', 'Registrar Paciente | MediSys')

@section('content')
<style>
    .form-container {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        padding: 40px;
        max-width: 600px;
        margin: 0 auto;
        border-top: 4px solid #0284c7;
    }
    .form-title {
        color: #0f172a;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 25px;
        text-align: center;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .form-group { margin-bottom: 20px; }
    .form-group.full-width { grid-column: span 2; }
    
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
        background-color: #f8fafc;
        transition: border-color 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: #0284c7;
        background-color: #ffffff;
    }
    .text-danger {
        color: #dc2626;
        font-size: 12px;
        margin-top: 6px;
        display: block;
    }
    .form-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
    .btn-cancel {
        color: #64748b;
        text-decoration: none;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 500;
    }
    .btn-submit {
        background-color: #0284c7;
        color: #ffffff;
        border: none;
        padding: 12px 25px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-submit:hover { background-color: #0369a1; }
</style>

<div class="form-container">
    <h2 class="form-title">Datos del Nuevo Paciente</h2>

    <form action="{{ route('patients.store') }}" method="POST">
        @csrf
        
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Número de Documento</label>
                <input type="text" name="document" class="form-control" value="{{ old('document') }}" required>
                @error('document') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label class="form-label">Nombre Completo</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Teléfono de Contacto</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('patients.index') }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-submit">Guardar Paciente</button>
        </div>
    </form>
</div>
@endsection