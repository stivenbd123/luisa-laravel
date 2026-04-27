@extends('layouts.app')

@section('title', 'Historial Clínico | MediSys')

@section('content')
<style>
    .report-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border-top: 4px solid #0f172a; }
    .search-bar { display: flex; gap: 10px; margin-bottom: 25px; }
    .search-input { flex: 1; padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; }
    .btn-search { background: #0284c7; color: white; border: none; padding: 0 20px; border-radius: 6px; cursor: pointer; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8fafc; padding: 15px; text-align: left; color: #475569; font-size: 12px; text-transform: uppercase; border-bottom: 2px solid #e2e8f0; }
    .data-table td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
    .btn-view { color: #0284c7; text-decoration: none; font-weight: 600; }

    /* =======================================================
       FIX DE PAGINACIÓN DE LARAVEL (Flechas gigantes)
       ======================================================= */
    
    /* 1. Controlar el tamaño de los iconos SVG */
    nav[role="navigation"] svg { width: 20px; height: 20px; }
    
    /* 2. Ocultar la versión móvil que trae por defecto Laravel */
    nav[role="navigation"] .sm\:hidden { display: none; }
    
    /* 3. Estructurar la barra inferior */
    nav[role="navigation"] .sm\:flex { display: flex; justify-content: space-between; align-items: center; margin-top: 25px; border-top: 1px solid #e2e8f0; padding-top: 20px; }
    nav[role="navigation"] p { color: #64748b; font-size: 14px; margin: 0; }
    
    /* 4. Estilos de los botones de páginas */
    nav[role="navigation"] span.relative.z-0.inline-flex { display: inline-flex; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); border-radius: 6px; }
    nav[role="navigation"] a, 
    nav[role="navigation"] span[aria-current="page"], 
    nav[role="navigation"] span[aria-disabled="true"] { 
        position: relative; display: inline-flex; align-items: center; padding: 8px 15px; 
        border: 1px solid #cbd5e1; background-color: #ffffff; font-size: 14px; color: #0f172a; text-decoration: none; margin-left: -1px;
    }
    
    /* Comportamientos hover y página activa */
    nav[role="navigation"] a:hover { background-color: #f8fafc; color: #0284c7; z-index: 2; }
    nav[role="navigation"] span[aria-current="page"] { background-color: #0284c7; color: white; border-color: #0284c7; z-index: 10; font-weight: 600; }
    nav[role="navigation"] span[aria-disabled="true"] { color: #94a3b8; background-color: #f1f5f9; cursor: not-allowed; }
    
    /* Redondear las esquinas del primer y último botón */
    nav[role="navigation"] span.relative > span:first-child > span,
    nav[role="navigation"] span.relative > a:first-child { border-top-left-radius: 6px; border-bottom-left-radius: 6px; }
    nav[role="navigation"] span.relative > span:last-child > span,
    nav[role="navigation"] span.relative > a:last-child { border-top-right-radius: 6px; border-bottom-right-radius: 6px; }
</style>

<div class="report-card">
    <h2 style="margin-bottom: 20px; color: #0f172a;">Historiales de Pacientes</h2>
    
    <form action="{{ route('reports.index') }}" method="GET" class="search-bar">
        <input type="text" name="search" class="search-input" placeholder="Buscar por nombre o documento..." value="{{ request('search') }}">
        <button type="submit" class="btn-search">Buscar</button>
    </form>

    <table class="data-table">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Paciente</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($patients as $patient)
            <tr>
                <td><strong>{{ $patient->document }}</strong></td>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->email }}</td>
                <td>
                    <a href="{{ route('reports.show', $patient->id) }}" class="btn-view">Ver Historial</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; padding:30px; color:#64748b;">No se encontraron pacientes.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div>
        {{ $patients->appends(['search' => request('search')])->links() }}
    </div>
</div>
@endsection