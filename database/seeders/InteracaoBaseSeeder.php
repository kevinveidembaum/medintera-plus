<?php

namespace Database\Seeders;

use App\Models\Interacao;
use Illuminate\Database\Seeder;

class InteracaoBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            'Interação Droga-Alimento: Melhora a absorção quando administrado com alimentos.',
            'Interação Droga-Alimento: Deve ser administrado em jejum para evitar redução da absorção.',
            'Risco de Sangramento: Aumento do tempo de protrombina.',
            'Depressão Respiratória: Risco crítico em uso concomitante com sedativos.',
            'Toxicidade Hepática: Necessário monitoramento de enzimas (TGO/TGP).',
            'Toxicidade Renal: Risco aumentado de insuficiência renal aguda.',
            'Hipotensão Severa: Monitorar pressão arterial sistêmica.',
            'Bradicardia: Redução significativa da frequência cardíaca.',
            'Efeito Sinérgico: Potencialização mútua dos efeitos terapêuticos e adversos.',
            'Antagonismo: Um fármaco anula ou reduz o efeito do outro.',
        ];

        foreach ($categorias as $descricao) {
            Interacao::firstOrCreate(['descricao' => $descricao]);
        }
    }
}
