<?php

namespace Database\Factories;

use App\Models\Interacao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interacao>
 */
class InteracaoFactory extends Factory
{
    protected $model = Interacao::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descricao' => $this->faker->text(100),
        ];
    }
}
