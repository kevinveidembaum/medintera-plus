<?php

namespace Database\Factories;

use App\Models\PrincipioAtivo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrincipioAtivo>
 */
class PrincipioAtivoFactory extends Factory
{
    protected $model = PrincipioAtivo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome_principio_ativo' => $this->faker->word() . 'icina',
        ];
    }
}
