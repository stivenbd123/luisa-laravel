<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="{{ asset('css/styleAuth.css') }}">
</head>
<body>

<div class="register-container">

    <h1>Sistema de Gestión de Citas Médicas</h1>

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

        <div class="row">
            <div class="form-group">
                <input type="text" name="primer_nombre" placeholder="Primer Nombre" required>
            </div>
            <div class="form-group">
                <input type="text" name="segundo_nombre" placeholder="Segundo Nombre">
            </div>
        </div>

        <div class="row">
            <div class="form-group">
                <input type="text" name="primer_apellido" placeholder="Primer Apellido" required>
            </div>
            <div class="form-group">
                <input type="text" name="segundo_apellido" placeholder="Segundo Apellido">
            </div>
        </div>

        <div class="form-group">
            <input type="text" name="numero_de_cedula" placeholder="Cédula" required>
        </div>

        <div class="form-group">
            <input type="email" name="correo_electronico" placeholder="Correo" required>
        </div>

        <div class="form-group">
            <input type="text" name="direccion" placeholder="Dirección">
        </div>

        <div class="form-group">
            <input type="text" name="numero_de_celular" placeholder="Celular">
        </div>

        <div class="form-group">
            <input type="password" name="contrasena" placeholder="Contraseña" required>
        </div>

        <button type="submit" class="register-btn">Registrarse</button>

    </form>
    <div class="footer-text">
    ¿Ya tienes cuenta?
    <a href="{{ route('login') }}">Inicia sesión aquí</a>
</div>
</div>

</body>
</html>