<?php

namespace Database\Seeders;

use App\Models\Medicamento;
use App\Models\MedicamentoInteracao;
use Illuminate\Database\Seeder;

class MedicamentoInteracaoRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mapeamento de interações reais baseadas nos medicamentos existentes na lista
        $interacoes = [
            [
                'origem' => 'AAS',
                'alvo' => 'Transamin',
                'severidade' => 'Moderada',
                'descricao' => 'O uso concomitante pode antagonizar o efeito antifibrinolítico do Transamin devido às propriedades antiagregantes plaquetárias do AAS.',
            ],
            [
                'origem' => 'Ancoron',
                'alvo' => 'Atenol',
                'severidade' => 'Grave',
                'descricao' => 'Risco aumentado de bradicardia excessiva e depressão da contratilidade miocárdica devido ao efeito sinérgico na condução cardíaca.',
            ],
            [
                'origem' => 'AAS',
                'alvo' => 'Depakene',
                'severidade' => 'Grave',
                'descricao' => 'O ácido acetilsalicílico pode deslocar o valproato de seus sítios de ligação proteica, aumentando os níveis plasmáticos livres e o risco de toxicidade hepática.',
            ],
            [
                'origem' => 'Aminofilina',
                'alvo' => 'Amoxil',
                'severidade' => 'Leve',
                'descricao' => 'Embora menos comum com amoxicilina do que com macrolídeos, recomenda-se monitorar níveis de teofilina, pois antibióticos podem alterar o clearance renal.',
            ],
            [
                'origem' => 'Norvasc',
                'alvo' => 'Ancoron',
                'severidade' => 'Moderada',
                'descricao' => 'Ambos os fármacos reduzem a condução atrioventricular e a frequência cardíaca; monitorar quanto a hipotensão e bradicardia.',
            ],
            [
                'origem' => 'Diamox',
                'alvo' => 'AAS',
                'severidade' => 'Grave',
                'descricao' => 'O uso de salicilatos pode levar ao acúmulo de acetazolamida e causar acidose metabólica grave e toxicidade do sistema nervoso central.',
            ],
            [
                'origem' => 'Frontal',
                'alvo' => 'Rapifen',
                'severidade' => 'Fatal',
                'descricao' => 'INTERAÇÃO CRÍTICA: O uso de benzodiazepínicos com opioides pode resultar em sedação profunda, depressão respiratória grave, coma e morte.',
            ],
            [
                'origem' => 'Zyloric',
                'alvo' => 'Amoxil',
                'severidade' => 'Moderada',
                'descricao' => 'O alopurinol aumenta a incidência de rash cutâneo (erupções na pele) em pacientes que utilizam amoxicilina/ampicilina.',
            ],
            [
                'origem' => 'Depakene',
                'alvo' => 'Frontal',
                'severidade' => 'Moderada',
                'descricao' => 'O valproato pode inibir o metabolismo do alprazolam, aumentando seus efeitos sedativos e psicomotores.',
            ],
            [
                'origem' => 'Clavulin',
                'alvo' => 'AAS',
                'severidade' => 'Leve',
                'descricao' => 'Doses elevadas de salicilatos podem aumentar o tempo de sangramento, o que deve ser monitorado em pacientes em uso de penicilinas.',
            ]
        ];

        foreach ($interacoes as $data) {
            // Busca os medicamentos por nome parcial (ex: "AAS" encontra "AAS 100 mg infantil")
            $origens = Medicamento::where('nome_comercial', 'ilike', '%' . $data['origem'] . '%')->get();
            $alvos = Medicamento::where('nome_comercial', 'ilike', '%' . $data['alvo'] . '%')->get();

            foreach ($origens as $origem) {
                foreach ($alvos as $alvo) {
                    if ($origem->id_medicamento === $alvo->id_medicamento) continue;

                    MedicamentoInteracao::firstOrCreate([
                        'medicamento_origem' => $origem->id_medicamento,
                        'medicamento_alvo' => $alvo->id_medicamento,
                    ], [
                        'severidade' => $data['severidade'],
                        'descricao' => $data['descricao'],
                    ]);
                }
            }
        }
    }
}
