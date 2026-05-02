<?php

use App\Models\ClassificacaoMedicamento;
use App\Models\Medicamento;
use App\Models\PrincipioAtivo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('pode buscar medicamento por nome comercial', function () {
    Medicamento::factory()->create(['nome_comercial' => 'Aspirina Plus']);
    Medicamento::factory()->create(['nome_comercial' => 'Paracetamol']);

    $response = $this->get(route('medicamentos.index', ['search' => 'Aspirina']));

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page
        ->has('medicamentos.data', 1)
        ->where('medicamentos.data.0.nome_comercial', 'Aspirina Plus')
    );
});

test('pode buscar medicamento por princípio ativo', function () {
    $principio = PrincipioAtivo::factory()->create(['nome_principio_ativo' => 'Ibuprofeno']);
    Medicamento::factory()->create([
        'nome_comercial' => 'Advil',
        'id_principio_ativo' => $principio->id_principio_ativo
    ]);

    $response = $this->get(route('medicamentos.index', ['search' => 'Ibuprofeno']));

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page
        ->has('medicamentos.data', 1)
        ->where('medicamentos.data.0.nome_comercial', 'Advil')
    );
});

test('pode filtrar medicamento por classificação farmacológica', function () {
    $classe = ClassificacaoMedicamento::factory()->create(['classificacao' => 'Diurético']);
    Medicamento::factory()->create([
        'nome_comercial' => 'Lasix',
        'id_classificacao' => $classe->id_classificacao
    ]);

    $response = $this->get(route('medicamentos.index', ['classificacao' => $classe->id_classificacao]));

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page
        ->has('medicamentos.data', 1)
        ->where('medicamentos.data.0.nome_comercial', 'Lasix')
    );
});

test('pode buscar medicamento por sinais e sintomas', function () {
    $sintoma = \App\Models\Sintomatologia::factory()->create(['descricao' => 'Dor de cabeça intensa']);
    Medicamento::factory()->create([
        'nome_comercial' => 'Enxaquecol',
        'id_sintomatologia' => $sintoma->id_sintomatologia
    ]);

    $response = $this->get(route('medicamentos.index', ['search' => 'cabeça']));

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page
        ->has('medicamentos.data', 1)
        ->where('medicamentos.data.0.nome_comercial', 'Enxaquecol')
    );
});

test('pode buscar medicamento por alterações laboratoriais', function () {
    $alt = \App\Models\AlteracaoLaboratorial::factory()->create(['descricao' => 'Hipocalemia']);
    Medicamento::factory()->create([
        'nome_comercial' => 'Kalium',
        'id_alt_lab' => $alt->id_alt_lab
    ]);

    $response = $this->get(route('medicamentos.index', ['search' => 'Hipocalemia']));

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page
        ->has('medicamentos.data', 1)
        ->where('medicamentos.data.0.nome_comercial', 'Kalium')
    );
});
