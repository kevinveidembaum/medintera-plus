<?php

use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\MedicamentoInteracaoController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    
    Route::resource('medicamentos', MedicamentoController::class);
    Route::resource('interacoes', MedicamentoInteracaoController::class)->except(['create', 'show', 'edit'])->parameters([
        'interacoes' => 'interacao'
    ]);
});

require __DIR__.'/settings.php';
