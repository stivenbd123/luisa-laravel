<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        // Usamos with('specialty') para traer los datos de la especialidad asociada (Eager Loading)
        $doctors = Doctor::with('specialty')->orderBy('name', 'asc')->get();
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        // Traemos todas las especialidades para llenar el menú desplegable del formulario
        $specialties = Specialty::orderBy('name', 'asc')->get();
        return view('doctors.create', compact('specialties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            // Valida que el ID seleccionado realmente exista en la tabla specialties
            'specialty_id' => 'required|exists:specialties,id' 
        ], [
            'name.required'         => 'El nombre del médico es obligatorio.',
            'specialty_id.required' => 'Debe seleccionar una especialidad.',
            'specialty_id.exists'   => 'La especialidad seleccionada no es válida.'
        ]);

        Doctor::create($request->all());

        return redirect()->route('doctors.index')->with('success', 'Médico registrado correctamente en el sistema.');
    }
}