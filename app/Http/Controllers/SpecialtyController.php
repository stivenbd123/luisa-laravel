<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    // Muestra la lista de especialidades
    public function index()
    {
        // Traemos todas las especialidades ordenadas alfabéticamente
        $specialties = Specialty::orderBy('name', 'asc')->get();
        return view('specialties.index', compact('specialties'));
    }

    // Muestra el formulario vacío
    public function create()
    {
        return view('specialties.create');
    }

    // Guarda en la base de datos
    public function store(Request $request)
    {
        // Valida que el nombre no esté vacío y no exista ya en la tabla
        $request->validate([
            'name' => 'required|string|max:255|unique:specialties,name'
        ], [
            'name.required' => 'El nombre de la especialidad es obligatorio.',
            'name.unique'   => 'Esta especialidad ya existe en el sistema.'
        ]);

        Specialty::create($request->all());

        return redirect()->route('specialties.index')->with('success', 'Especialidad médica registrada correctamente.');
    }
}