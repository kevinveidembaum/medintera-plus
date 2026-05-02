<?php

namespace App\Services;

use App\Models\ClassificacaoMedicamento;
use App\Models\Medicamento;
use App\Models\PrincipioAtivo;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MedicamentoExportService
{
    /**
     * Gera um arquivo Excel dos medicamentos filtrados.
     */
    public function exportExcel(Collection $medicamentos, string $path): void
    {
        $writer = SimpleExcelWriter::create($path);

        foreach ($medicamentos as $med) {
            $writer->addRow([
                'Nome Comercial' => $med->nome_comercial,
                'Princípio Ativo' => $med->principioAtivo?->nome_principio_ativo ?? 'N/A',
                'Classificação' => $med->classificacao?->classificacao ?? 'N/A',
                'Sintomatologia' => $med->sintomatologia?->descricao ?? '',
                'Alterações Lab' => $med->alteracaoLaboratorial?->descricao ?? '',
                'Observações' => $med->observacoes ?? '',
            ]);
        }
    }

    /**
     * Gera um PDF dos medicamentos filtrados.
     */
    public function exportPdf(Collection $medicamentos): string
    {
        $pdf = Pdf::loadView('exports.medicamentos', ['medicamentos' => $medicamentos]);
        return $pdf->output();
    }
}
