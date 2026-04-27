<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Personal | Sistema de Citas</title>
    <link rel="stylesheet" href="{{ asset('css/styleAuth.css') }}">
</head>
<body>

<div class="register-container">

    <h1>Registro en el Sistema</h1>

    {{-- Alertas de éxito o error --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf

        {{-- Campo mapeado a la columna 'name' --}}
        <div class="form-group">
            <label>Nombre Completo</label>
            <input type="text" name="name" placeholder="Ej: Juan Pérez" required value="{{ old('name') }}">
        </div>

        {{-- Campo mapeado a la columna 'email' --}}
        <div class="form-group">
            <label>Correo Electrónico</label>
            <input type="email" name="email" placeholder="correo@consultorio.com" required value="{{ old('email') }}">
        </div>

        {{-- Campo mapeado a la columna 'password' --}}
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" placeholder="Mínimo 8 caracteres" required>
        </div>

        {{-- Confirmación de contraseña (Laravel la pide automáticamente al validar) --}}
        <div class="form-group">
            <label>Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" placeholder="Repite tu contraseña" required>
        </div>

        <button type="submit" class="register-btn">Registrar Usuario</button>

    </form>
    
    <div class="footer-text">
        ¿Ya tienes cuenta?
        <a href="{{ route('login') }}">Inicia sesión aquí</a>
    </div>
</div>

</body>
</html>