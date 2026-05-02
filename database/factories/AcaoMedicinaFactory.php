<?php

namespace Database\Factories;

use App\Models\AcaoMedicina;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcaoMedicina>
 */
class AcaoMedicinaFactory extends Factory
{
    protected $model = AcaoMedicina::class;

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
