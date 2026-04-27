<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Función de seguridad para reemplazar el middleware obsoleto
    private function checkAdminAccess()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Acceso denegado. Solo los administradores pueden gestionar usuarios.');
        }
    }

    public function index()
    {
        $this->checkAdminAccess(); // Protegemos la ruta
        
        $users = User::orderBy('name', 'asc')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->checkAdminAccess(); // Protegemos la ruta
        
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->checkAdminAccess(); // Protegemos la ruta

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => ['required', Rule::in(['admin', 'recepcionista'])],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        $this->checkAdminAccess(); // Protegemos la ruta

        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAdminAccess(); // Protegemos la ruta

        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'  => ['required', Rule::in(['admin', 'recepcionista'])],
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Datos de usuario actualizados.');
    }

    public function destroy($id)
    {
        $this->checkAdminAccess(); // Protegemos la ruta

        $user = User::findOrFail($id);
        
        if (auth()->id() == $user->id) {
            return redirect()->route('users.index')->with('error', 'No puedes eliminar tu propia cuenta de administrador.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado del sistema.');
    }
}