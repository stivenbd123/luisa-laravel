<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $usuario = DB::table('usuarios')
            ->where('correo_electronico', $request->correo_electronico)
            ->first();

        if ($usuario && Hash::check($request->contrasena, $usuario->contraseña)) {

            session([
                'id_usuario' => $usuario->id_usuario,
                'nombre' => $usuario->primer_nombre,
                'rol' => $usuario->rol
            ]);

            return redirect('/home');
        }

        return back()->with('error_login', 'Correo o contraseña incorrectos');
    }

    public function register(Request $request)
    {
        DB::table('usuarios')->insert([
            'primer_nombre' => $request->primer_nombre,
            'primer_apellido' => $request->primer_apellido,
            'correo_electronico' => $request->correo_electronico,
            'contraseña' => Hash::make($request->contrasena),
            'numero_de_celular' => $request->numero_de_celular,
            'rol' => 'recepcionista'
        ]);

        return back()->with('success', 'Usuario registrado correctamente');
    }
}