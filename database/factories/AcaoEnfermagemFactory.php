<?php

namespace Database\Factories;

use App\Models\AcaoEnfermagem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcaoEnfermagem>
 */
class AcaoEnfermagemFactory extends Factory
{
    protected $model = AcaoEnfermagem::class;

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
