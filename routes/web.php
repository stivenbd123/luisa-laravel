<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ConsultingRoomController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ReportController;

// ==========================================
// REDIRECCIÓN INICIAL
// ==========================================
Route::get('/', function () {
    return redirect()->route('login');
});

// ==========================================
// MÓDULO DE AUTENTICACIÓN (Público)
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ==========================================
// MÓDULOS PROTEGIDOS (Requieren sesión)
// ==========================================
Route::middleware('auth')->group(function () {
    
    // Panel de Control Principal
    Route::get('/home', function () { return view('home'); })->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Módulos Maestros (CRUDs automáticos generados por resource)
    Route::resource('users', UserController::class);
    Route::resource('patients', PatientController::class);
    Route::resource('specialties', SpecialtyController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('consulting_rooms', ConsultingRoomController::class);
    Route::resource('appointments', AppointmentController::class);

    // ==========================================
    // RUTAS ESPECIALES Y AJAX
    // ==========================================
    
    Route::get('/api/specialties/{specialty_id}/details', [AppointmentController::class, 'getDetailsBySpecialty']);

    // AJAX: Enviar correo de recordatorio (Pendiente de implementar)
    Route::post('/appointments/{id}/send-reminder', [AppointmentController::class, 'sendReminder'])->name('appointments.reminder');

    // ==========================================
    // MÓDULO DE HISTORIAL CLÍNICO
    // ==========================================
    
    Route::get('/historial', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/historial/{id}', [ReportController::class, 'show'])->name('reports.show');

   
    Route::get('/exportaciones', [ReportController::class, 'exportsView'])->name('exports.view');
    
    Route::get('/exportaciones', [ReportController::class, 'exportsView'])->name('exports.view');
    Route::post('/exportaciones/generar', [ReportController::class, 'generateReport'])->name('exports.generate');
    Route::get('/historial/{id}/exportar/{format}', [ReportController::class, 'exportPatientHistory'])->name('reports.patient.export');
});