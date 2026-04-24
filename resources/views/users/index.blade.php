<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios | Sistema Médico</title>

    <!-- ✅ CORRECCIÓN CLAVE -->
    <link rel="stylesheet" href="{{ asset('css/styleCRUDUsuarios.css') }}">
</head>
<body>

<header>
    <span>Panel de Administración - Usuarios</span>
    <a href="{{ url('/home') }}" class="home-btn">⬅ Volver al Home</a>
</header>

<div class="container">

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert success-alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert error-alert">
            {{ session('error') }}
        </div>
    @endif


    <div class="top-bar">
        <h2>Listado de Usuarios</h2>
        <button class="btn btn-primary" onclick="openModal('create')">
            + Nuevo Usuario
        </button>
    </div>


    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cédula</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($usuarios as $u)
                <tr>
                    <td><strong>{{ $u->id_usuario }}</strong></td>

                    <td>{{ $u->primer_nombre }} {{ $u->primer_apellido }}</td>

                    <td>{{ $u->numero_de_cedula }}</td>
                    <td>{{ $u->correo_electronico }}</td>

                    <td>
                        <span class="badge">
                            {{ ucfirst($u->rol) }}
                        </span>
                    </td>

                    <td>
                        <button class="btn btn-warning"
                            onclick='openModal("edit", @json($u))'>
                            Editar
                        </button>

                        <form action="{{ route('users.destroy', $u->id_usuario) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger"
                                onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">
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


<!-- MODAL (IGUAL QUE EL TUYO) -->
<div class="modal" id="userModal">
    <div class="modal-content">

        <h3 id="modalTitle">Nuevo Usuario</h3>
        <hr>

        <!-- ✅ CORRECCIÓN: ruta Laravel -->
        <form id="userForm" action="{{ route('users.store') }}" method="POST">
            @csrf

            <input type="hidden" name="id_usuario" id="form_id_usuario">
            <input type="hidden" name="accion" id="form_accion" value="crear_usuario">

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

            <div class="row">
                <div class="form-group">
                    <label>Cédula</label>
                    <input type="text" name="numero_de_cedula" id="numero_de_cedula" required>
                </div>
                <div class="form-group">
                    <label>Celular</label>
                    <input type="text" name="numero_de_celular" id="numero_de_celular" required>
                </div>
            </div>

            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="correo_electronico" id="correo_electronico" required>
            </div>

            <div class="form-group">
                <label>Rol del Sistema</label>
                <select name="rol" id="rol" required>
                    <option value="">Seleccione...</option>
                    <option value="administrador">Administrador</option>
                    <option value="recepcionista">Recepcionista</option>
                </select>
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="contrasena" id="contrasena">
                <small id="pass_hint" style="display:none; color:#666;">
                    (Dejar en blanco para no cambiar)
                </small>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">
                    Cancelar
                </button>

                <button type="submit" class="btn btn-primary">
                    Guardar Usuario
                </button>
            </div>

        </form>

    </div>
</div>


<!-- ✅ CORRECCIÓN JS -->
<script src="{{ asset('js/usuarios.js') }}"></script>

</body>
</html>