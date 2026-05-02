<?php

namespace Database\Factories;

use App\Models\AlteracaoLaboratorial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AlteracaoLaboratorial>
 */
class AlteracaoLaboratorialFactory extends Factory
{
    protected $model = AlteracaoLaboratorial::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descricao' => $this->faker->randomElement([
                'Aumento de Glicemia', 'Redução de Na+', 'Alteração de K+', 'Aumento de Creatinina'
            ]) . ' - ' . $this->faker->word(),
        ];
    }
}
