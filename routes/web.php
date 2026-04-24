<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/home', function () {return view('home');});
Route::post('/logout', function () {session()->flush();return redirect('/login');});

use App\Http\Controllers\UserController;

Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::resource('usuarios', UserController::class)->names([
    'index' => 'users.index',
    'store' => 'users.store',
    'update' => 'users.update',
    'destroy' => 'users.destroy'
]);

use App\Http\Controllers\PacienteController;

Route::resource('pacientes', PacienteController::class);