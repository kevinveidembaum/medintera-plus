<?php

namespace Database\Factories;

use App\Models\AcaoNutricao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcaoNutricao>
 */
class AcaoNutricaoFactory extends Factory
{
    protected $model = AcaoNutricao::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descricao' => $this->faker->text(200),
        ];
    }
}
