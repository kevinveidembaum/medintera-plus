<?php

namespace Database\Factories;

use App\Models\ClassificacaoMedicamento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassificacaoMedicamento>
 */
class ClassificacaoMedicamentoFactory extends Factory
{
    protected $model = ClassificacaoMedicamento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'classificacao' => $this->faker->randomElement([
                'Analgesiante', 'Antibiótico', 'Anti-inflamatório', 'Diurético', 'Mucolítico', 'Antiglaucoma'
            ]),
        ];
    }
}
