<?php

namespace Database\Factories;

use App\Models\Sintomatologia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sintomatologia>
 */
class SintomatologiaFactory extends Factory
{
    protected $model = Sintomatologia::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descricao' => $this->faker->sentence(),
        ];
    }
}
