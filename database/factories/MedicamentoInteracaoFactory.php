<?php

namespace Database\Factories;

use App\Models\Interacao;
use App\Models\Medicamento;
use App\Models\MedicamentoInteracao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicamentoInteracao>
 */
class MedicamentoInteracaoFactory extends Factory
{
    protected $model = MedicamentoInteracao::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'medicamento_origem' => Medicamento::factory(),
            'medicamento_alvo' => Medicamento::factory(),
            'id_interacao' => Interacao::factory(),
            'severidade' => $this->faker->randomElement(['Leve', 'Moderada', 'Grave', 'Fatal']),
            'descricao' => $this->faker->text(300),
        ];
    }
}
