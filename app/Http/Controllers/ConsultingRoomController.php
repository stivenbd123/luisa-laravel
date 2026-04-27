<?php

namespace App\Http\Controllers;

use App\Models\ConsultingRoom;
use App\Models\Specialty;
use Illuminate\Http\Request;

class ConsultingRoomController extends Controller
{
    public function index()
    {
        // Trae los consultorios junto con el nombre de su especialidad
        $rooms = ConsultingRoom::with('specialty')->orderBy('name', 'asc')->get();
        return view('consulting_rooms.index', compact('rooms'));
    }

    public function create()
    {
        $specialties = Specialty::orderBy('name', 'asc')->get();
        return view('consulting_rooms.create', compact('specialties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'specialty_id' => 'required|exists:specialties,id'
        ], [
            'name.required'         => 'El identificador o nombre del consultorio es obligatorio.',
            'specialty_id.required' => 'Debe asignar el consultorio a una especialidad médica.',
            'specialty_id.exists'   => 'La especialidad seleccionada no es válida en el sistema.'
        ]);

        ConsultingRoom::create($request->all());

        return redirect()->route('consulting_rooms.index')->with('success', 'Consultorio registrado y habilitado en el sistema.');
    }
}