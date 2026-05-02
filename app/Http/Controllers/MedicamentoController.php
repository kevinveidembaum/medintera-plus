<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicamentoRequest;
use App\Models\Medicamento;
use App\Services\MedicamentoExportService;
use App\Services\MedicamentoImportService;
use App\Services\MedicamentoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MedicamentoController extends Controller
{
    public function __construct(
        protected MedicamentoService $medicamentoService,
        protected MedicamentoExportService $exportService,
        protected MedicamentoImportService $importService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('medicamentos/Index', [
            'medicamentos' => $this->medicamentoService->search($request->all()),
            'classificacoes' => $this->medicamentoService->getLookups()['classificacoes'],
            'filters' => $request->only(['search', 'classificacao']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('medicamentos/Create', [
            'lookups' => $this->medicamentoService->getLookups(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicamentoRequest $request): RedirectResponse
    {
        $this->medicamentoService->create($request->validated());

        return redirect()->route('medicamentos.index')
            ->with('status', 'Medicamento cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicamento $medicamento): Response
    {
        return Inertia::render('medicamentos/Show', [
            'medicamento' => $this->medicamentoService->getDetailed($medicamento),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicamento $medicamento): Response
    {
        return Inertia::render('medicamentos/Edit', [
            'medicamento' => $medicamento,
            'lookups' => $this->medicamentoService->getLookups(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMedicamentoRequest $request, Medicamento $medicamento): RedirectResponse
    {
        $this->medicamentoService->update($medicamento, $request->validated());

        return redirect()->route('medicamentos.index')
            ->with('status', 'Medicamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicamento $medicamento): RedirectResponse
    {
        $this->medicamentoService->delete($medicamento);

        return redirect()->route('medicamentos.index')
            ->with('status', 'Medicamento excluído com sucesso!');
    }

    /**
     * Exporta os medicamentos para Excel.
     */
    public function exportExcel(Request $request): BinaryFileResponse
    {
        $medicamentos = $this->medicamentoService->getAllForExport($request->all());
        $tempPath = storage_path('app/public/medicamentos_export.xlsx');
        
        $this->exportService->exportExcel($medicamentos, $tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

    /**
     * Exporta os medicamentos para PDF.
     */
    public function exportPdf(Request $request): \Illuminate\Http\Response
    {
        $medicamentos = $this->medicamentoService->getAllForExport($request->all());
        $pdfContent = $this->exportService->exportPdf($medicamentos);

        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="medicamentos_medintera.pdf"');
    }

    /**
     * Importa medicamentos de um arquivo.
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv,txt'],
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $extension = $file->getClientOriginalExtension();
        
        $result = $this->importService->import($path, $extension);

        $status = "Importação concluída: {$result['success']} registros importados.";
        if (count($result['errors']) > 0) {
            $status .= " Houve alguns erros nas linhas: " . implode(', ', array_slice($result['errors'], 0, 3)) . "...";
        }

        return redirect()->back()->with('status', $status);
    }
}
