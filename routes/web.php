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
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('cuadres', CuadreController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('users', UserController::class);
    Route::resource('dispensadores', DispensadorController::class)->parameters(['dispensadores' => 'dispensador']);
    Route::resource('lados', LadoController::class)->only(['update']);
    Route::resource('mangueras', MangueraController::class)->only(['update']);
    Route::resource('turnos', TurnoController::class)->except(['show']);
});

require __DIR__.'/auth.php';
