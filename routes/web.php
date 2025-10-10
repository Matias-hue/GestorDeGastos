<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\GastoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Ruta raíz: si está logueado va a principal, sino al login
Route::get('/', function () {
    return Auth::check() ? redirect()->route('principal') : redirect()->route('login');
});

// Rutas protegidas por auth
Route::middleware(['auth'])->group(function () {

    // Vista principal con botones de acceso
    Route::get('/principal', function () {
        return view('principal');
    })->name('principal');

    // Dashboard (resumen semanal)
    Route::get('/dashboard', [GastoController::class, 'dashboard'])->name('dashboard');

    // Presupuesto
    Route::get('/presupuesto/crear', [PresupuestoController::class, 'create'])->name('presupuestos.crear');
    Route::post('/presupuesto', [PresupuestoController::class, 'store'])->name('presupuestos.store');
    Route::delete('/presupuesto/{id}', [PresupuestoController::class, 'destroy'])->name('presupuestos.destroy');

    // Gastos individuales
    Route::get('/gastos/crear', [GastoController::class, 'create'])->name('gastos.crear');
    Route::post('/gastos', [GastoController::class, 'store'])->name('gastos.store');
    Route::delete('/gastos/{id}', [GastoController::class, 'destroy'])->name('gastos.destroy');

    // Historial de semanas
    Route::get('/gastos/semanas', [GastoController::class, 'historialSemanas'])->name('gastos.historialSemanas');
    Route::get('/gastos/semanas/{id}', [GastoController::class, 'verSemana'])->name('gastos.verSemana');
    Route::delete('/gastos/semanas/{id}', [GastoController::class, 'eliminarSemana'])->name('gastos.eliminarSemana');

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de autenticación (Breeze/Laravel)
require __DIR__.'/auth.php';