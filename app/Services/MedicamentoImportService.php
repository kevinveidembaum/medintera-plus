<?php

namespace App\Services;

use App\Models\AcaoEnfermagem;
use App\Models\AcaoMedicina;
use App\Models\AcaoNutricao;
use App\Models\AlteracaoLaboratorial;
use App\Models\ClassificacaoMedicamento;
use App\Models\Interacao;
use App\Models\Medicamento;
use App\Models\PrincipioAtivo;
use App\Models\Sintomatologia;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class MedicamentoImportService
{
    /**
     * Importa medicamentos de um arquivo Excel ou CSV.
     */
    public function import(string $path, ?string $extension = null): array
    {
        $reader = SimpleExcelReader::create($path, $extension ?? '');
        $rows = $reader->getRows();
        $importedCount = 0;
        $errors = [];

        DB::transaction(function () use ($rows, &$importedCount, &$errors) {
            foreach ($rows as $index => $row) {
                try {
                    // Normalização de chaves e limpeza de valores
                    $row = array_change_key_case(array_map(function($val) {
                        return is_string($val) ? trim($val) : $val;
                    }, (array) $row), CASE_LOWER);

                    $nomeComercial = $row['nome comercial'] ?? $row['nome_comercial'] ?? null;
                    
                    if (!$nomeComercial) {
                        $errors[] = "Linha " . ($index + 1) . ": Nome Comercial é obrigatório.";
                        continue;
                    }

                    // 1. Princípio Ativo (Fármaco)
                    $idPrincipioAtivo = null;
                    $nomePrincipio = $row['fármaco'] ?? $row['princípio ativo'] ?? $row['principio_ativo'] ?? null;
                    if ($nomePrincipio) {
                        $principio = PrincipioAtivo::firstOrCreate(['nome_principio_ativo' => $nomePrincipio]);
                        $idPrincipioAtivo = $principio->id_principio_ativo;
                    }

                    // 2. Classificação
                    $idClassificacao = null;
                    $nomeClasse = $row['classificação'] ?? $row['classificacao'] ?? null;
                    if ($nomeClasse) {
                        $classe = ClassificacaoMedicamento::firstOrCreate(['classificacao' => $nomeClasse]);
                        $idClassificacao = $classe->id_classificacao;
                    }

                    // 3. Sintomatologia
                    $idSintomatologia = null;
                    $sintoma = $row['sintomatologia'] ?? null;
                    if ($sintoma) {
                        $sintoma = $this->translateClinicalSymbols($sintoma);
                        $obj = Sintomatologia::firstOrCreate(['descricao' => $sintoma]);
                        $idSintomatologia = $obj->id_sintomatologia;
                    }

                    // 4. Alterações Laboratoriais
                    $idAltLab = null;
                    $alteracao = $row['alterações'] ?? $row['alteracoes'] ?? null;
                    if ($alteracao) {
                        $alteracao = $this->translateClinicalSymbols($alteracao);
                        $obj = AlteracaoLaboratorial::firstOrCreate(['descricao' => $alteracao]);
                        $idAltLab = $obj->id_alt_lab;
                    }

                    // 5. Interação (Base / Alimentos / Geral)
                    $idInteracaoBase = null;
                    $interacaoTxt = $row['interação'] ?? $row['interacao'] ?? null;
                    if ($interacaoTxt) {
                        $interacaoTxt = $this->translateClinicalSymbols($interacaoTxt);
                        $obj = Interacao::firstOrCreate(['descricao' => $interacaoTxt]);
                        $idInteracaoBase = $obj->id_interacao;
                    }

                    // 6. Ação Medicina
                    $idAcaoMed = null;
                    $acaoMed = $row['ação com os médicos'] ?? $row['acao_medicina'] ?? null;
                    if ($acaoMed) {
                        $acaoMed = $this->translateClinicalSymbols($acaoMed);
                        $obj = AcaoMedicina::firstOrCreate(['descricao' => $acaoMed]);
                        $idAcaoMed = $obj->id_acao_med;
                    }

                    // 7. Ação Nutrição
                    $idAcaoNut = null;
                    $acaoNut = $row['ação com a nutrição'] ?? $row['acao_nutricao'] ?? null;
                    if ($acaoNut) {
                        $acaoNut = $this->translateClinicalSymbols($acaoNut);
                        $obj = AcaoNutricao::firstOrCreate(['descricao' => $acaoNut]);
                        $idAcaoNut = $obj->id_acao_nut;
                    }

                    // 8. Ação Enfermagem
                    $idAcaoEnf = null;
                    $acaoEnf = $row['ação com a enfermagem'] ?? $row['acao_enfermagem'] ?? null;
                    if ($acaoEnf) {
                        $acaoEnf = $this->translateClinicalSymbols($acaoEnf);
                        $obj = AcaoEnfermagem::firstOrCreate(['descricao' => $acaoEnf]);
                        $idAcaoEnf = $obj->id_acao_enf;
                    }

                    Medicamento::create([
                        'nome_comercial' => $nomeComercial,
                        'id_principio_ativo' => $idPrincipioAtivo,
                        'id_classificacao' => $idClassificacao,
                        'id_sintomatologia' => $idSintomatologia,
                        'id_alt_lab' => $idAltLab,
                        'id_interacao' => $idInteracaoBase,
                        'id_acao_med' => $idAcaoMed,
                        'id_acao_nut' => $idAcaoNut,
                        'id_acao_enf' => $idAcaoEnf,
                        'observacoes' => $row['observações'] ?? $row['observacoes'] ?? null,
                    ]);

                    $importedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Linha " . ($index + 1) . ": " . $e->getMessage();
                }
            }
        });

        return [
            'success' => $importedCount,
            'errors' => $errors,
        ];
    }

    /**
     * Converte símbolos clínicos comuns em texto amigável para busca e leitura.
     */
    private function translateClinicalSymbols(string $text): string
    {
        $replacements = [
            '↑' => 'Aumento de ',
            '↓' => 'Redução de ',
            '↗' => 'Tendência de aumento de ',
            '↘' => 'Tendência de redução de ',
            '↔' => 'Estabilidade de ',
            'Δ' => 'Variação de ',
            '+' => 'Presença de ',
            '-' => 'Ausência de ',
        ];

        // Substituir os símbolos
        $text = str_replace(array_keys($replacements), array_values($replacements), $text);
        
        // Limpeza de espaços duplos resultantes das substituições
        return preg_replace('/\s+/', ' ', trim($text));
    }
}
