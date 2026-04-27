@extends('layouts.app')

@section('title', 'Exportar Reportes | MediSys')

@section('content')
<style>
    .export-container { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); max-width: 600px; margin: 0 auto; border-top: 4px solid #0f172a; text-align: center; }
    .export-title { color: #0f172a; font-size: 22px; font-weight: 700; margin-bottom: 10px; }
    .export-desc { color: #64748b; font-size: 15px; margin-bottom: 40px; }
    
    .btn-export { display: flex; align-items: center; justify-content: center; width: 100%; padding: 15px; border-radius: 8px; font-size: 16px; font-weight: 600; text-decoration: none; cursor: pointer; border: none; transition: all 0.2s; margin-bottom: 20px; }
    
    .btn-excel { background-color: #166534; color: white; }
    .btn-excel:hover { background-color: #14532d; transform: translateY(-2px); }
    
    .btn-pdf { background-color: #dc2626; color: white; }
    .btn-pdf:hover { background-color: #b91c1c; transform: translateY(-2px); }
</style>

<div class="export-container">
    <h2 class="export-title">Generación de Reportes</h2>
    <p class="export-desc">Descarga el consolidado general de todas las citas registradas en el sistema.</p>

    <form action="{{ route('exports.excel') }}" method="POST">
        @csrf
        <button type="submit" class="btn-export btn-excel">
            Descargar Reporte en Excel (.CSV)
        </button>
    </form>

    <form action="{{ route('exports.pdf') }}" method="POST" target="_blank">
        @csrf
        <button type="submit" class="btn-export btn-pdf">
            Generar Reporte para Imprimir (PDF)
        </button>
    </form>
</div>
@endsection