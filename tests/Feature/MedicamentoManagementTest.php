<?php

use App\Models\Medicamento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
    $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class]);
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('pode visualizar o formulário de criação', function () {
    $response = $this->get(route('medicamentos.create'));
    $response->assertSuccessful();
});

test('pode cadastrar um novo medicamento', function () {
    $data = [
        'nome_comercial' => 'Novo Remedio',
        'observacoes' => 'Teste obs',
    ];

    $response = $this->postJson(route('medicamentos.store'), $data);

    $response->assertRedirect(route('medicamentos.index'));
    $this->assertDatabaseHas('medicamento', ['nome_comercial' => 'Novo Remedio']);
});

test('pode visualizar o formulário de edição', function () {
    $med = Medicamento::factory()->create();
    $response = $this->get(route('medicamentos.edit', $med->id_medicamento));
    $response->assertSuccessful();
});

test('pode atualizar um medicamento', function () {
    $med = Medicamento::factory()->create(['nome_comercial' => 'Antigo']);
    $data = [
        'nome_comercial' => 'Atualizado',
    ];

    $response = $this->putJson(route('medicamentos.update', $med->id_medicamento), $data);

    $response->assertRedirect(route('medicamentos.index'));
    $this->assertDatabaseHas('medicamento', [
        'id_medicamento' => $med->id_medicamento,
        'nome_comercial' => 'Atualizado'
    ]);
});

test('pode deletar um medicamento', function () {
    $med = Medicamento::factory()->create();

    $response = $this->deleteJson(route('medicamentos.destroy', $med->id_medicamento));

    $response->assertRedirect(route('medicamentos.index'));
    $this->assertDatabaseMissing('medicamento', ['id_medicamento' => $med->id_medicamento]);
});
