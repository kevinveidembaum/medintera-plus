<?php

use App\Models\Medicamento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('pode visualizar detalhes do medicamento', function () {
    $med = Medicamento::factory()->create([
        'nome_comercial' => 'Aspirina Especial',
        'observacoes' => 'Cuidado com o estômago'
    ]);

    $response = $this->get(route('medicamentos.show', $med->id_medicamento));

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page
        ->component('medicamentos/Show')
        ->has('medicamento', fn ($page) => $page
            ->where('nome_comercial', 'Aspirina Especial')
            ->where('observacoes', 'Cuidado com o estômago')
            ->has('principio_ativo')
            ->has('classificacao')
            ->has('sintomatologia')
            ->has('alteracao_laboratorial')
            ->has('acao_medicina')
            ->has('acao_nutricao')
            ->has('acao_enfermagem')
            ->etc()
        )
    );
});
