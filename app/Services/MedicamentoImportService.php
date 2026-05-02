<?php

namespace App\Services;

use App\Models\ClassificacaoMedicamento;
use App\Models\Medicamento;
use App\Models\PrincipioAtivo;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class MedicamentoImportService
{
    /**
     * Importa medicamentos de um arquivo Excel ou CSV.
     * 
     * @param string $path Caminho do arquivo temporário
     * @param string|null $extension Extensão original do arquivo
     * @return array Resumo da importação
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
                    $nomeComercial = $row['Nome Comercial'] ?? $row['nome_comercial'] ?? null;
                    
                    if (!$nomeComercial) {
                        $errors[] = "Linha {$index}: Nome Comercial é obrigatório.";
                        continue;
                    }

                    // Buscar ou criar Princípio Ativo
                    $idPrincipioAtivo = null;
                    $nomePrincipio = $row['Princípio Ativo'] ?? $row['principio_ativo'] ?? null;
                    if ($nomePrincipio) {
                        $principio = PrincipioAtivo::firstOrCreate(['nome_principio_ativo' => $nomePrincipio]);
                        $idPrincipioAtivo = $principio->id_principio_ativo;
                    }

                    // Buscar ou criar Classificação
                    $idClassificacao = null;
                    $nomeClasse = $row['Classificação'] ?? $row['classificacao'] ?? null;
                    if ($nomeClasse) {
                        $classe = ClassificacaoMedicamento::firstOrCreate(['classificacao' => $nomeClasse]);
                        $idClassificacao = $classe->id_classificacao;
                    }

                    Medicamento::create([
                        'nome_comercial' => $nomeComercial,
                        'id_principio_ativo' => $idPrincipioAtivo,
                        'id_classificacao' => $idClassificacao,
                        'observacoes' => $row['Observações'] ?? $row['observacoes'] ?? null,
                    ]);

                    $importedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Linha {$index}: " . $e->getMessage();
                }
            }
        });

        return [
            'success' => $importedCount,
            'errors' => $errors,
        ];
    }
}
