<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | Sistema de Citas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ✅ CORRECTO en Laravel -->
    <link rel="stylesheet" href="{{ asset('css/styleAuth.css') }}">
</head>
<body>

<div class="login-container">
    <h1>Sistema de Gestión de Citas Médicas</h1>

    {{-- ERROR LOGIN --}}
    @if(session('error_login'))
        <div class="alert-error">
            {{ session('error_login') }}
        </div>
    @endif

    {{-- FORMULARIO --}}
    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
            <label>Correo Electrónico</label>
            <input type="email" name="correo_electronico" required>
        </div>

        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="contrasena" required>
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