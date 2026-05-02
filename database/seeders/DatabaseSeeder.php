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
            'name' => 'Profissional MedIntera',
            'email' => 'admin@medintera.com.br',
            'password' => bcrypt('admin123'),
        ]);

        // Importar Base de Dados Real
        $this->call(MedicamentoBaseSeeder::class);

        // // Criar algumas interações entre medicamentos existentes se houver dados
        // $medicamentos = Medicamento::all();
        //
        // if ($medicamentos->count() >= 2) {
        //     for ($i = 0; $i < 10; $i++) {
        //         MedicamentoInteracao::factory()->create([
        //             'medicamento_origem' => $medicamentos->random()->id_medicamento,
        //             'medicamento_alvo' => $medicamentos->random()->id_medicamento,
        //         ]);
        //     }
        // }
    }
}
