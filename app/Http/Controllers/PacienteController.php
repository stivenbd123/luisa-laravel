<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;

class PacienteController extends Controller
{
    // LISTAR
    public function index()
    {
        $pacientes = Paciente::orderBy('id_paciente', 'desc')->get();
        return view('pacientes.index', compact('pacientes'));
    }

    // CREAR
    public function store(Request $request)
    {
        Paciente::create($request->all());

        return redirect()->route('pacientes.index')
            ->with('success_paciente', 'Paciente registrado correctamente.');
    }

    // ACTUALIZAR
    public function update(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());

        return redirect()->route('pacientes.index')
            ->with('success_paciente', 'Paciente actualizado correctamente.');
    }

    // ELIMINAR
    public function destroy($id)
    {
        Paciente::destroy($id);

        return redirect()->route('pacientes.index')
            ->with('success_paciente', 'Paciente eliminado.');
    }
}