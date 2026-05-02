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
    
    Route::get('medicamentos/export/excel', [MedicamentoController::class, 'exportExcel'])->name('medicamentos.export.excel');
    Route::get('medicamentos/export/pdf', [MedicamentoController::class, 'exportPdf'])->name('medicamentos.export.pdf');
    Route::post('medicamentos/import', [MedicamentoController::class, 'import'])->name('medicamentos.import');

    Route::resource('medicamentos', MedicamentoController::class);
    Route::resource('interacoes', MedicamentoInteracaoController::class)->except(['create', 'show', 'edit'])->parameters([
        'interacoes' => 'interacao'
    ]);
});

require __DIR__.'/settings.php';
