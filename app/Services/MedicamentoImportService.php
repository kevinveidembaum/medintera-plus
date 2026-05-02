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
    public function import(string $path, ?string $extension = null): array
    {
        $reader = SimpleExcelReader::create($path, $extension ?? '');
        $rows = $reader->getRows();
        $importedCount = 0;
        $errors = [];

        DB::transaction(function () use ($rows, &$importedCount, &$errors) {
            foreach ($rows as $index => $row) {
                try {
                    $row = (array) $row;

                    // 1. Nome Comercial (Obrigatório)
                    $nomeComercial = $row['nome comercial'] ?? $row['Nome Comercial'] ?? $row['medicamento'] ?? null;

                    if (!$nomeComercial) {
                        $errors[] = "Linha " . ($index + 1) . ": Coluna 'nome comercial' não encontrada.";
                        continue;
                    }

                    // 2. Fármaco / Princípio Ativo
                    $idPrincipioAtivo = null;
                    $nomePrincipio = $row['fármaco'] ?? $row['farmaco'] ?? $row['princípio ativo'] ?? $row['Princípio Ativo'] ?? null;
                    if ($nomePrincipio) {
                        $principio = PrincipioAtivo::firstOrCreate(['nome_principio_ativo' => trim($nomePrincipio)]);
                        $idPrincipioAtivo = $principio->id_principio_ativo;
                    }

                    // 3. Classificação
                    $idClassificacao = null;
                    $nomeClasse = $row['classificação'] ?? $row['classificacao'] ?? $row['Classificação'] ?? null;
                    if ($nomeClasse) {
                        $classe = ClassificacaoMedicamento::firstOrCreate(['classificacao' => trim($nomeClasse)]);
                        $idClassificacao = $classe->id_classificacao;
                    }

                    // 4. Sintomatologia
                    $idSintomatologia = null;
                    $sintoma = $row['sintomatologia'] ?? $row['Sintomatologia'] ?? null;
                    if ($sintoma) {
                        $sintoma = $this->translateClinicalSymbols($sintoma);
                        $obj = Sintomatologia::firstOrCreate(['descricao' => trim($sintoma)]);
                        $idSintomatologia = $obj->id_sintomatologia;
                    }

                    // 5. Alterações Laboratoriais
                    $idAltLab = null;
                    $alteracao = $row['alterações laboratoriais'] ?? $row['Alterações laboratoriais'] ?? $row['alterações'] ?? $row['alteracoes'] ?? null;
                    if ($alteracao) {
                        $alteracao = $this->translateClinicalSymbols($alteracao);
                        $obj = AlteracaoLaboratorial::firstOrCreate(['descricao' => trim($alteracao)]);
                        $idAltLab = $obj->id_alt_lab;
                    }

                    // 6. Interação Geral
                    $idInteracaoBase = null;
                    $interacaoTxt = $row['interação'] ?? $row['interacao'] ?? $row['Interação'] ?? null;
                    if ($interacaoTxt) {
                        $interacaoTxt = $this->translateClinicalSymbols($interacaoTxt);
                        $obj = Interacao::firstOrCreate(['descricao' => trim($interacaoTxt)]);
                        $idInteracaoBase = $obj->id_interacao;
                    }

                    // 7. Ação Medicina
                    $idAcaoMed = null;
                    $acaoMed = $row['ação com os médicos'] ?? $row['acao com os medicos'] ?? null;
                    if ($acaoMed) {
                        $acaoMed = $this->translateClinicalSymbols($acaoMed);
                        $obj = AcaoMedicina::firstOrCreate(['descricao' => trim($acaoMed)]);
                        $idAcaoMed = $obj->id_acao_med;
                    }

                    // 8. Ação Nutrição
                    $idAcaoNut = null;
                    $acaoNut = $row['ação com a nutrição'] ?? $row['acao com a nutricao'] ?? null;
                    if ($acaoNut) {
                        $acaoNut = $this->translateClinicalSymbols($acaoNut);
                        $obj = AcaoNutricao::firstOrCreate(['descricao' => trim($acaoNut)]);
                        $idAcaoNut = $obj->id_acao_nut;
                    }

                    // 9. Ação Enfermagem (Condutas Enfermagem)
                    $idAcaoEnf = null;
                    $acaoEnf = $row['ação com a enfermagem'] ?? $row['acao com a enfermagem'] ?? null;
                    if ($acaoEnf) {
                        $acaoEnf = $this->translateClinicalSymbols($acaoEnf);
                        $obj = AcaoEnfermagem::firstOrCreate(['descricao' => trim($acaoEnf)]);
                        $idAcaoEnf = $obj->id_acao_enf;
                    }

                    Medicamento::create([
                        'nome_comercial' => trim($nomeComercial),
                        'id_principio_ativo' => $idPrincipioAtivo,
                        'id_classificacao' => $idClassificacao,
                        'id_sintomatologia' => $idSintomatologia,
                        'id_alt_lab' => $idAltLab,
                        'id_interacao' => $idInteracaoBase,
                        'id_acao_med' => $idAcaoMed,
                        'id_acao_nut' => $idAcaoNut,
                        'id_acao_enf' => $idAcaoEnf,
                        'observacoes' => is_string($row['observações'] ?? null) ? trim($row['observações']) : null,
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

        $text = str_replace(array_keys($replacements), array_values($replacements), $text);
        return preg_replace('/\s+/', ' ', trim($text));
    }
}
