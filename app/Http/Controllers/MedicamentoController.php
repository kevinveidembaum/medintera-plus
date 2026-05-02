<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicamentoRequest;
use App\Models\Medicamento;
use App\Services\MedicamentoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MedicamentoController extends Controller
{
    public function __construct(
        protected MedicamentoService $medicamentoService
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
}
