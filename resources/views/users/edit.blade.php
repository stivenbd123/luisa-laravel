@extends('layouts.app')

@section('title', 'Editar Usuario | MediSys')

@section('content')
<style>
    .form-container { background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); padding: 40px; max-width: 500px; margin: 0 auto; border-top: 4px solid #0f172a; }
    .form-title { color: #0f172a; font-size: 20px; font-weight: 600; margin-bottom: 25px; text-align: center; }
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; color: #475569; font-size: 13px; font-weight: 600; margin-bottom: 8px; }
    .form-control { width: 100%; padding: 12px 15px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; background-color: #f8fafc; }
    .form-control:focus { outline: none; border-color: #0284c7; background-color: #ffffff; }
    .text-danger { color: #dc2626; font-size: 12px; margin-top: 6px; display: block; }
    .form-actions { display: flex; justify-content: space-between; margin-top: 30px; }
    .btn-cancel { color: #64748b; text-decoration: none; padding: 12px 20px; font-size: 14px; font-weight: 500; }
    .btn-submit { background-color: #0f172a; color: #ffffff; border: none; padding: 12px 25px; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; }
</style>

<div class="form-container">
    <h2 class="form-title">Modificar Accesos</h2>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label">Nombre Completo</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Nueva Contraseña (Dejar en blanco para conservar la actual)</label>
            <input type="password" name="password" class="form-control">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Perfil de Usuario (Rol)</label>
            <select name="role" class="form-control" required>
                <option value="recepcionista" {{ old('role', $user->role) == 'recepcionista' ? 'selected' : '' }}>Recepcionista (Operativo)</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador (Control Total)</option>
            </select>
            @error('role') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('users.index') }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-submit">Actualizar Datos</button>
        </div>
    </form>
</div>
@endsection