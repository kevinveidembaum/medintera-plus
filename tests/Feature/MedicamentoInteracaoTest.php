<?php

use App\Models\Medicamento;
use App\Models\MedicamentoInteracao;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
    $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class]);
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('pode listar interações', function () {
    MedicamentoInteracao::factory()->count(3)->create();

    $response = $this->get(route('interacoes.index'));

    $response->assertSuccessful();
    $response->assertInertia(fn ($page) => $page
        ->component('interacoes/Index')
        ->has('interacoes.data', 3)
    );
});

test('pode cadastrar uma nova interação', function () {
    $med1 = Medicamento::factory()->create();
    $med2 = Medicamento::factory()->create();

    $data = [
        'medicamento_origem' => $med1->id_medicamento,
        'medicamento_alvo' => $med2->id_medicamento,
        'severidade' => 'Grave',
        'descricao' => 'Interação perigosa',
    ];

    $response = $this->postJson(route('interacoes.store'), $data);

    $response->assertRedirect();
    $this->assertDatabaseHas('medicamento_interacao', [
        'medicamento_origem' => $med1->id_medicamento,
        'medicamento_alvo' => $med2->id_medicamento,
        'severidade' => 'Grave'
    ]);
});

test('não pode cadastrar interação com o mesmo medicamento', function () {
    $med1 = Medicamento::factory()->create();

    $data = [
        'medicamento_origem' => $med1->id_medicamento,
        'medicamento_alvo' => $med1->id_medicamento,
        'severidade' => 'Leve',
        'descricao' => 'Erro',
    ];

    $response = $this->postJson(route('interacoes.store'), $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['medicamento_alvo']);
});

test('pode atualizar uma interação', function () {
    $interacao = MedicamentoInteracao::factory()->create(['severidade' => 'Leve']);
    
    $data = [
        'medicamento_origem' => $interacao->medicamento_origem,
        'medicamento_alvo' => $interacao->medicamento_alvo,
        'severidade' => 'Fatal',
        'descricao' => 'Atualizado',
    ];

    $response = $this->putJson(route('interacoes.update', $interacao->id_med_interacao), $data);

    $response->assertRedirect();
    $this->assertDatabaseHas('medicamento_interacao', [
        'id_med_interacao' => $interacao->id_med_interacao,
        'severidade' => 'Fatal'
    ]);
});

test('pode deletar uma interação', function () {
    $interacao = MedicamentoInteracao::factory()->create();

    $response = $this->deleteJson(route('interacoes.destroy', $interacao->id_med_interacao));

    $response->assertRedirect();
    $this->assertDatabaseMissing('medicamento_interacao', ['id_med_interacao' => $interacao->id_med_interacao]);
});
