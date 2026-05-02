<?php

namespace App\Services;

use App\Models\Interacao;
use App\Models\Medicamento;
use App\Models\MedicamentoInteracao;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class MedicamentoInteracaoService
{
    /**
     * Lista as interações com paginação e filtros.
     */
    public function list(array $filters = []): LengthAwarePaginator
    {
        $query = MedicamentoInteracao::query()
            ->with(['origem', 'alvo', 'interacao']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('origem', function ($q) use ($search) {
                    $q->where('nome_comercial', 'ilike', "%{$search}%");
                })->orWhereHas('alvo', function ($q) use ($search) {
                    $q->where('nome_comercial', 'ilike', "%{$search}%");
                })->orWhere('descricao', 'ilike', "%{$search}%");
            });
        }

        if (!empty($filters['severidade'])) {
            $query->where('severidade', $filters['severidade']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
    }

    /**
     * Retorna lookups para o formulário de interações.
     */
    public function getLookups(): array
    {
        return [
            'medicamentos' => Medicamento::orderBy('nome_comercial')->get(['id_medicamento', 'nome_comercial']),
            'interacoes_base' => Interacao::orderBy('descricao')->get(['id_interacao', 'descricao']),
            'severidades' => ['Leve', 'Moderada', 'Grave', 'Fatal'],
        ];
    }

    /**
     * Cria uma nova interação.
     */
    public function create(array $data): MedicamentoInteracao
    {
        return MedicamentoInteracao::create($data);
    }

    /**
     * Atualiza uma interação existente.
     */
    public function update(MedicamentoInteracao $interacao, array $data): bool
    {
        return $interacao->update($data);
    }

    /**
     * Remove uma interação.
     */
    public function delete(MedicamentoInteracao $interacao): ?bool
    {
        return $interacao->delete();
    }
}
