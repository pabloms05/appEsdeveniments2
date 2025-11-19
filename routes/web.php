<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EsdevenimentController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Auth;

Auth::routes();

// Home / Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Ruta per l'admin
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    // Vista per gestionar esdeveniments
    Route::get('/esdeveniments', [EsdevenimentController::class, 'index'])->name('esdeveniments.index');
    Route::get('esdeveniments/create', [EsdevenimentController::class, 'create'])->name('esdeveniments.create');
    Route::post('esdeveniments', [EsdevenimentController::class, 'store'])->name('esdeveniments.store');
    Route::get('esdeveniments/{id}/edit', [EsdevenimentController::class, 'edit'])->name('esdeveniments.edit');
    Route::put('esdeveniments/{id}', [EsdevenimentController::class, 'update'])->name('esdeveniments.update');
    Route::delete('esdeveniments/{id}', [EsdevenimentController::class, 'destroy'])->name('esdeveniments.destroy');

});

// Ruta per usuaris autenticats
Route::middleware(['auth'])->group(function () {
    // Vista principal (llistat d’esdeveniments per categories)
    Route::get('/esdeveniments', [EsdevenimentController::class, 'index'])->name('esdeveniments.index');
    // Detall esdeveniment
    Route::get('/esdeveniments/{id}', [EsdevenimentController::class, 'show'])->name('esdeveniments.show');
    // Fer reserva
    Route::post('/esdeveniments/{id}/reserva', [EsdevenimentController::class, 'reserva'])->name('esdeveniments.reserva');
});


