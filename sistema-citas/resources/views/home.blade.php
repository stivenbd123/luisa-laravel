<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Home | Sistema de Gestión de Citas Médicas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Laravel usa asset() -->
    <link rel="stylesheet" href="{{ asset('css/styleHome.css') }}">
</head>

<body>

    <!-- HEADER -->
    <header>
        Sistema de Gestión de Citas Médicas

        <div class="user-info">
            {{ session('nombre') }} ({{ session('rol') }})

            <!-- Logout en Laravel -->
            <form action="/logout" method="POST" style="display:inline;">
                @csrf
                <button class="logout-btn">Cerrar Sesión</button>
            </form>
        </div>
    </header>

    <!-- CONTENIDO -->
    <div class="container">

        {{-- SOLO ADMIN --}}
        @if(session('rol') == 'administrador')
        <div class="card" onclick="location.href='/usuarios'">
            <div class="icon">👤</div>
            Usuarios
            <span>Gestión de usuarios del sistema</span>
        </div>
        @endif

        <div class="card" onclick="location.href='/pacientes'">
            <div class="icon">🧾</div>
            Pacientes
            <span>Registro y edición de pacientes</span>
        </div>

        <div class="card" onclick="location.href='/medicos'">
            <div class="icon">💉</div>
            Médicos y Especialidades
            <span>Asignación y gestión</span>
        </div>

        <div class="card" onclick="location.href='/consultorios'">
            <div class="icon">🏥</div>
            Consultorios
            <span>Gestión por especialidad</span>
        </div>

        <div class="card" onclick="location.href='/citas'">
            <div class="icon">📅</div>
            Citas Médicas
            <span>Agendar y modificar citas</span>
        </div>

        <div class="card" onclick="location.href='/historial'">
            <div class="icon">📖</div>
            Historial de Pacientes
            <span>Consultar historial de citas</span>
        </div>

        <div class="card" onclick="location.href='/reportes'">
            <div class="icon">📊</div>
            Reportes
            <span>Generar PDF y Excel</span>
        </div>

    </div>

</body>
</html>