<?php

use App\Models\Medicamento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
    $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class]);
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('pode exportar medicamentos para excel', function () {
    Medicamento::factory()->count(5)->create();

    $response = $this->get(route('medicamentos.export.excel'));

    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
});

test('pode exportar medicamentos para pdf', function () {
    Medicamento::factory()->count(5)->create();

    $response = $this->get(route('medicamentos.export.pdf'));

    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'application/pdf');
});

test('pode importar medicamentos via csv', function () {
    $csvContent = "Nome Comercial,Princípio Ativo,Classificação,Observações\n";
    $csvContent .= "MedImportado,Fármaco X,Classe Y,Obs Importada";
    
    $file = UploadedFile::fake()->create('import.csv', 0); // apenas para ter o objeto
    file_put_contents($file->getRealPath(), $csvContent);

    $response = $this->post(route('medicamentos.import'), [
        'file' => $file
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('medicamento', ['nome_comercial' => 'MedImportado']);
});
