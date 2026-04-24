<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::obtenerUsuarios();
        return view('users.index', compact('usuarios'));
    }

    public function store(Request $request)
    {
        if (Usuario::correoExiste($request->correo_electronico)) {
            return back()->with('error', 'El correo ya existe');
        }

        Usuario::create([
            'primer_nombre' => $request->primer_nombre,
            'segundo_nombre' => $request->segundo_nombre,
            'primer_apellido' => $request->primer_apellido,
            'segundo_apellido' => $request->segundo_apellido,
            'numero_de_cedula' => $request->numero_de_cedula,
            'correo_electronico' => $request->correo_electronico,
            'numero_de_celular' => $request->numero_de_celular,
            'direccion' => $request->direccion,
            'contraseña' => Hash::make($request->contrasena),
            'rol' => $request->rol
        ]);

        return back()->with('success', 'Usuario creado');
    }

    public function update(Request $request, $id)
    {
        $user = Usuario::findOrFail($id);

        // ✅ VALIDAR CORREO IGNORANDO EL MISMO USUARIO
        if (Usuario::where('correo_electronico', $request->correo_electronico)
                ->where('id_usuario', '!=', $id)
                ->exists()) {
            return back()->with('error', 'El correo ya existe');
        }

        $data = $request->except(['contrasena', '_method', '_token']);

        if (!empty($request->contrasena)) {
            $data['contraseña'] = Hash::make($request->contrasena);
        }

        $user->update($data);

        return back()->with('success', 'Usuario actualizado');
    }

    public function destroy($id)
    {
        Usuario::findOrFail($id)->delete();
        return back()->with('success', 'Usuario eliminado');
    }
}