<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicamentoInteracaoRequest;
use App\Models\MedicamentoInteracao;
use App\Services\MedicamentoInteracaoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MedicamentoInteracaoController extends Controller
{
    public function __construct(
        protected MedicamentoInteracaoService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('interacoes/Index', [
            'interacoes' => $this->service->list($request->all()),
            'lookups' => $this->service->getLookups(),
            'filters' => $request->only(['search', 'severidade']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicamentoInteracaoRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()->back()
            ->with('status', 'Interação cadastrada com sucesso!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMedicamentoInteracaoRequest $request, MedicamentoInteracao $interacao): RedirectResponse
    {
        $this->service->update($interacao, $request->validated());

        return redirect()->back()
            ->with('status', 'Interação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicamentoInteracao $interacao): RedirectResponse
    {
        $this->service->delete($interacao);

        return redirect()->back()
            ->with('status', 'Interação excluída com sucesso!');
    }
}
