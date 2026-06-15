<?php

use App\Http\Controllers\CuadreController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DispensadorController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\LadoController;
use App\Http\Controllers\MangueraController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConfiguracionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/empleados/{empleado}/disable', [EmpleadoController::class, 'disable'])->name('empleados.disable');
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('cuadres', CuadreController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    Route::patch('/users/{user}/disable', [UserController::class, 'disable'])->name('users.disable');
    Route::resource('users', UserController::class);
    Route::resource('dispensadores', DispensadorController::class)->parameters(['dispensadores' => 'dispensador']);
    Route::resource('lados', LadoController::class)->only(['update']);
    Route::resource('mangueras', MangueraController::class)->only(['update']);
    Route::resource('turnos', TurnoController::class)->except(['show']);

    // Configuración
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::get('/configuracion/turnos', [ConfiguracionController::class, 'turnos'])->name('configuracion.turnos');
    Route::post('/configuracion/turnos', [ConfiguracionController::class, 'updateTurnos'])->name('configuracion.turnos.update');
    Route::get('/configuracion/sistema', [ConfiguracionController::class, 'sistema'])->name('configuracion.sistema');
    Route::post('/configuracion/sistema', [ConfiguracionController::class, 'updateSistema'])->name('configuracion.sistema.update');
    Route::get('/configuracion/regional', [ConfiguracionController::class, 'regional'])->name('configuracion.regional');
    Route::post('/configuracion/regional', [ConfiguracionController::class, 'updateRegional'])->name('configuracion.regional.update');
});

require __DIR__.'/auth.php';
