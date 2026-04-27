<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        // Obtiene todos los pacientes ordenados por el más reciente
        $patients = Patient::orderBy('created_at', 'desc')->get();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        // Muestra el formulario vacío
        return view('patients.create');
    }

    public function store(Request $request)
    {
        // Valida los datos antes de guardar
        $request->validate([
            'document' => 'required|unique:patients,document',
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:patients,email',
            'phone'    => 'nullable|string|max:20'
        ], [
            'document.required' => 'El documento es obligatorio.',
            'document.unique'   => 'Este documento ya está registrado.',
            'name.required'     => 'El nombre es obligatorio.',
            'email.required'    => 'El correo es obligatorio.',
            'email.unique'      => 'Este correo ya pertenece a otro paciente.'
        ]);

        // Guarda en la base de datos
        Patient::create($request->all());

        return redirect()->route('patients.index')->with('success', 'Paciente registrado exitosamente.');
    }
}