@extends('layouts.app')

@section('title', 'Administración de Usuarios | MediSys')

@section('content')
<style>
    .module-container { background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); padding: 30px; border-top: 4px solid #0f172a; }
    .module-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9; }
    .module-title { color: #0f172a; font-size: 20px; font-weight: 600; }
    .btn-primary { background-color: #0284c7; color: #ffffff; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 500; font-size: 14px; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background-color: #f8fafc; color: #475569; font-size: 12px; font-weight: 600; text-transform: uppercase; padding: 15px; text-align: left; border-bottom: 2px solid #e2e8f0; }
    .data-table td { padding: 16px 15px; color: #334155; font-size: 14px; border-bottom: 1px solid #f1f5f9; }
    .role-badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; text-transform: uppercase; }
    .role-admin { background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .role-recepcionista { background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
    .alert-success { background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .alert-error { background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .btn-action { text-decoration: none; font-weight: 600; font-size: 13px; margin-right: 10px; }
    .btn-edit { color: #0284c7; }
    .btn-delete { color: #dc2626; background: none; border: none; cursor: pointer; font-weight: 600; font-size: 13px; padding: 0; }
</style>

<div class="module-container">
    <div class="module-header">
        <h2 class="module-title">Directorio de Accesos</h2>
        <a href="{{ route('users.create') }}" class="btn-primary">Crear Nuevo Usuario</a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-error">{{ session('error') }}</div> @endif

    <table class="data-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Perfil / Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="role-badge role-{{ $user->role }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td style="display: flex; align-items: center;">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn-action btn-edit">Editar</a>
                        @if(auth()->id() != $user->id)
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar este usuario del sistema?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-action btn-delete">Eliminar</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection