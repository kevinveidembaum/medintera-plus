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
// Importar Interações Base (Categorias)
$this->call(InteracaoBaseSeeder::class);

// Importar Base de Dados Real
$this->call(MedicamentoBaseSeeder::class);
// Importar Interações Clínicas Reais
$this->call(MedicamentoInteracaoRealSeeder::class);
        // }
    }
}
