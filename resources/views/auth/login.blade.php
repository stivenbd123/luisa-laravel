<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión | Sistema de Citas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/styleAuth.css') }}">
</head>
<body>

<div class="login-container">
    <h1>Acceso al Sistema</h1>

    {{-- Mostrar errores si las credenciales son incorrectas --}}
    @if($errors->any())
        <div class="alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Mostrar mensaje verde si viene redirigido desde el registro --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
            <label>Correo Electrónico</label>
            {{-- Corregido: name="email" --}}
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label>Contraseña</label>
            {{-- Corregido: name="password" --}}
            <input type="password" name="password" required>
        </div>

        <button type="submit" class="login-btn">
            Iniciar Sesión
        </button>
    </form>

    <div class="footer-text">
        ¿No tienes cuenta?
        <a href="{{ route('register') }}">Regístrate aquí</a>
    </div>
</div>

</body>
</html>