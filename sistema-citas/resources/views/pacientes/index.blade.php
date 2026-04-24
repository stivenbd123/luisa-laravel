<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Pacientes | Sistema Médico</title>

    <link rel="stylesheet" href="{{ asset('css/styleCRUDPacientes.css') }}">
</head>
<body>

<!-- HEADER -->
<header>
    <span>Sistema de Gestión de Citas Médicas - Pacientes</span>
    <a href="{{ url('/home') }}" class="home-btn">⬅ Volver al Home</a>
</header>

<div class="container">

    {{-- ALERTAS --}}
    @if(session('success_paciente'))
        <div class="alert success-alert">
            {{ session('success_paciente') }}
        </div>
    @endif

    @if(session('error_paciente'))
        <div class="alert error-alert">
            {{ session('error_paciente') }}
        </div>
    @endif

    <!-- TOP BAR -->
    <div class="top-bar">
        <h2>Listado de Pacientes</h2>
        <button class="btn btn-primary" onclick="openModal('crear')">
            + Nuevo Paciente
        </button>
    </div>

    <!-- TABLA -->
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Cédula</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($pacientes as $p)
                <tr>
                    <td><strong>{{ $p->id_paciente }}</strong></td>
                    <td>{{ $p->primer_nombre }} {{ $p->primer_apellido }}</td>
                    <td>{{ $p->numero_de_cedula }}</td>
                    <td>{{ $p->correo_electronico }}</td>
                    <td>{{ $p->numero_de_celular }}</td>

                    <td>
                        <!-- EDITAR -->
                        <button class="btn btn-warning"
                                onclick='openModal("editar", @json($p))'>
                            Editar
                        </button>

                        <!-- ELIMINAR -->
                        <form action="{{ route('pacientes.destroy', $p->id_paciente) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger"
                                    onclick="return confirm('¿Está seguro?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>


<!-- MODAL (IGUAL AL TUYO) -->
<div class="modal" id="pacienteModal">
    <div class="modal-content">

        <h3 id="modalTitle">Nuevo Paciente</h3>
        <hr>

        <form id="pacienteForm" method="POST">
            @csrf

            <input type="hidden" id="formAccion">
            <input type="hidden" id="id_paciente" name="id_paciente">

            <!-- FILA 1 -->
            <div class="row">
                <div class="form-group">
                    <label>Primer Nombre</label>
                    <input type="text" name="primer_nombre" id="primer_nombre" required>
                </div>

                <div class="form-group">
                    <label>Segundo Nombre</label>
                    <input type="text" name="segundo_nombre" id="segundo_nombre">
                </div>
            </div>

            <!-- FILA 2 -->
            <div class="row">
                <div class="form-group">
                    <label>Primer Apellido</label>
                    <input type="text" name="primer_apellido" id="primer_apellido" required>
                </div>

                <div class="form-group">
                    <label>Segundo Apellido</label>
                    <input type="text" name="segundo_apellido" id="segundo_apellido">
                </div>
            </div>

            <div class="form-group">
                <label>Cédula</label>
                <input type="text" name="numero_de_cedula" id="numero_de_cedula" required>
            </div>

            <div class="form-group">
                <label>Correo</label>
                <input type="email" name="correo_electronico" id="correo_electronico" required>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Celular</label>
                    <input type="text" name="numero_de_celular" id="numero_de_celular">
                </div>

                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" name="direccion" id="direccion">
                </div>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Paciente</button>
            </div>

        </form>
    </div>
</div>

<script src="{{ asset('js/pacientes.js') }}"></script>

</body>
</html>