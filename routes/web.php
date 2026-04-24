<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/**
 * RUTAS PÚBLICAS
 */
Route::get('/', function () {
    return view('welcome');
});

/**
 * RUTAS PROTEGIDAS (AUTENTICACIÓN)
 */
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Panel de control principal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Gestión de Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Visualización de Servicios (Pública para autenticados)
    Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios.index');

    // Módulo de Citas (CRUD Completo)
    Route::resource('citas', \App\Http\Controllers\CitaController::class);
    Route::patch('/citas/{cita}/estado', [\App\Http\Controllers\CitaController::class, 'cambiarEstado'])->name('citas.cambiarEstado');

    /**
     * SOLO ADMINISTRADORES
     */
    Route::middleware(['role:admin'])->group(function () {
        // Panel de Estadísticas
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        
        // CRUD de Servicios completo
        Route::get('/servicios/create', [ServicioController::class, 'create'])->name('servicios.create');
        Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
        Route::get('/servicios/{servicio}/edit', [ServicioController::class, 'edit'])->name('servicios.edit');
        Route::put('/servicios/{servicio}', [ServicioController::class, 'update'])->name('servicios.update');
        Route::delete('/servicios/{servicio}', [ServicioController::class, 'destroy'])->name('servicios.destroy');

        // CRUD de Usuarios
        Route::resource('usuario', UsuariosController::class);
    });
});

require __DIR__ . '/auth.php';