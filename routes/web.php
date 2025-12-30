<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/admin', [AdminController::class, 'edit'])->name('admin.edit');
    Route::post('/admin/horarios-semanales', [AdminController::class, 'updateWeeklySchedules'])->name('admin.weekly-schedules.update');
    Route::post('/admin/horarios', [AdminController::class, 'updateHorarios'])->name('admin.horarios.update');
    Route::post('/admin/tarifas', [AdminController::class, 'updateTarifas'])->name('admin.tarifas.update');
    Route::post('/admin/bonificaciones', [AdminController::class, 'updateBonificaciones'])->name('admin.bonificaciones.update');
    Route::post('/admin/personalizacion', [AdminController::class, 'updatePersonalizacion'])->name('admin.personalizacion.update');
    Route::post('/admin/contacto', [AdminController::class, 'updateContacto'])->name('admin.contacto.update');
    Route::delete('/admin/personalizacion/hero-background', [AdminController::class, 'deleteHeroBackground'])->name('admin.personalizacion.delete-hero');
    Route::delete('/admin/personalizacion/logo', [AdminController::class, 'deleteLogo'])->name('admin.personalizacion.delete-logo');
});

require __DIR__.'/auth.php';

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
