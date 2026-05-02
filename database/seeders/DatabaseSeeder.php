<?php

namespace Database\Seeders;

use App\Models\Medicamento;
use App\Models\MedicamentoInteracao;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criar usuário de teste
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Criar medicamentos (isso criará as tabelas de lookup automaticamente via factory)
        Medicamento::factory()->count(20)->create();

        // Criar algumas interações entre medicamentos existentes
        $medicamentos = Medicamento::all();

        for ($i = 0; $i < 10; $i++) {
            MedicamentoInteracao::factory()->create([
                'medicamento_origem' => $medicamentos->random()->id_medicamento,
                'medicamento_alvo' => $medicamentos->random()->id_medicamento,
            ]);
        }
    }
}
