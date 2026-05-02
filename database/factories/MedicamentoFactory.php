<?php

namespace Database\Factories;

use App\Models\AcaoEnfermagem;
use App\Models\AcaoMedicina;
use App\Models\AcaoNutricao;
use App\Models\AlteracaoLaboratorial;
use App\Models\ClassificacaoMedicamento;
use App\Models\Interacao;
use App\Models\Medicamento;
use App\Models\PrincipioAtivo;
use App\Models\Sintomatologia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicamento>
 */
class MedicamentoFactory extends Factory
{
    protected $model = Medicamento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome_comercial' => $this->faker->word() . ' Plus',
            'id_principio_ativo' => PrincipioAtivo::factory(),
            'id_classificacao' => ClassificacaoMedicamento::factory(),
            'id_sintomatologia' => Sintomatologia::factory(),
            'id_alt_lab' => AlteracaoLaboratorial::factory(),
            'id_interacao' => Interacao::factory(),
            'id_acao_med' => AcaoMedicina::factory(),
            'id_acao_nut' => AcaoNutricao::factory(),
            'id_acao_enf' => AcaoEnfermagem::factory(),
            'observacoes' => $this->faker->paragraph(),
        ];
    }
}
